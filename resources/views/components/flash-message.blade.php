@if (session()->has('message'))
<div x-data="{show: true}" x-init="setTimeout(() => show = false, 4000)" x-show="show"
    x-transition:enter="transition transform ease-out duration-300"
    x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transition transform ease-in duration-300" x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="translate-x-full opacity-0" class="fixed top-4 right-4 z-50 w-[90%] max-w-md px-4">
    <div
        class="border-l-8 border-green-500 bg-white text-gray-800 dark:bg-gray-600 dark:text-white shadow-lg rounded-md px-6 py-4">
        <div class="flex justify-between items-center">
            <p class="text-sm font-medium">
                {{ session('message') }}
            </p>
            <button @click="show = false"
                class="text-gray-400 hover:text-gray-600 dark:text-gray-800 dark:hover:text-gray-300 ml-4">
                &times;
            </button>
        </div>
    </div>
</div>
@endif
