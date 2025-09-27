@props(['cinemaLevel', 'message'])

@if($cinemaLevel['level'])
    <div {{ $attributes }}
        x-data="{ show: true }"
        x-show="show"
        x-transition
        class="cinema-level-banner"
    >
        <div class="relative flex items-center justify-center text-center">
            <div>
                <p class="text-lg font-semibold cinema-level-text">
                    {{ $cinemaLevel['badge'] }}
                    {{ $message }}
                    <span class="font-bold">{{ $cinemaLevel['level'] }}</span>
                </p>
                <p class="text-sm opacity-90">
                    You’ve collected <span class="font-bold">{{ $cinemaLevel['count'] }}</span> gems of cinema.
                </p>

                @if($cinemaLevel['toNext'])
                    <p class="text-sm mt-1">
                        Only <span class="font-bold">{{ $cinemaLevel['toNext'] }}</span> more to reach
                        <span class="font-bold">{{ $cinemaLevel['nextLevel'] }}</span>!
                    </p>
                @endif
            </div>

            <button @click="show = false" class="absolute right-3 top-6 text-white hover:opacity-80 hover:cursor-pointer transition duration-300 ease-in-out hover:scale-150">
                ✖
            </button>
        </div>

        {{-- Progress bar --}}
        @if($cinemaLevel['toNext'])
            <div class="mt-3 h-2 bg-white/30 rounded-full overflow-hidden">
                @php
                    $current = $cinemaLevel['count'];
                    $min = $cinemaLevel['min'];
                    $max = $cinemaLevel['max'];
                    $percent = ($current - $min) / ($max - $min) * 100;
                @endphp

                <div class="h-full bg-yellow-300 rounded-full" style="width: {{ $percent }}%"></div>
            </div>
        @endif

        {{ $slot}}
    </div>
@endif
