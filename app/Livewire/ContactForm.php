<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $message = '';

    public function send()
    {
        $key = 'contact-form:' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => __('Too many attempts. Please try again in :seconds seconds.', [
                    'seconds' => RateLimiter::availableIn($key),
                ]),
            ]);
        }

        RateLimiter::hit($key, 60); // 5 attempts per 60 seconds

        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Send email
        Mail::raw("Message from: {$validated['name']} ({$validated['email']})\n\n{$validated['message']}", function ($mail) use ($validated) {
            $mail->to('support@example.com')
                 ->subject('New Contact Message');
        });

        $this->reset('name', 'email', 'message');

        session()->flash('message', __('Your message has been sent successfully!'));
    }
    public function render()
    {
        return view('livewire.contact-form');
    }
}
