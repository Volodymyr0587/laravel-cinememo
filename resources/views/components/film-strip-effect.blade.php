<!-- Film strip / movie tape effect -->
    <!-- Top -->
    <div class="absolute top-0 left-0 right-0 h-6
            bg-gradient-to-r from-red-600 via-purple-600 to-pink-600
            rounded-t-2xl flex items-center justify-around px-2 overflow-hidden">

        @for ($i = 0; $i < 12; $i++)
            <div class="w-3 h-4 bg-neutral-100/80 dark:bg-neutral-900/70 rounded-xs"></div>
        @endfor
    </div>
    <!-- End Top -->
    <!-- Bottom -->
    <div class="absolute bottom-0 left-0 right-0 h-6
            bg-gradient-to-r from-red-600 via-purple-600 to-pink-600
            rounded-b-2xl flex items-center justify-around px-2 overflow-hidden">

        @for ($i = 0; $i < 12; $i++)
            <div class="w-3 h-4 bg-neutral-100/80 dark:bg-neutral-900/70 rounded-xs"></div>
        @endfor
    </div>
    <!-- End Bottom -->
    <!-- End film strip / movie tape effect -->
