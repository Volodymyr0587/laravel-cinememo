@php
// These variables are often passed from Livewire's pagination trait, but good to ensure they're here for context
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="mt-6">
        <ul class="flex flex-wrap justify-center gap-1 text-sm font-medium p-3 rounded-xl shadow text-black dark:text-white">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-1 rounded border border-gray-300 dark:border-zinc-700 opacity-50 cursor-not-allowed select-none">
                        &laquo;
                    </span>
                </li>
            @else
                <li>
                    {{-- IMPORTANT: Use wire:click for Livewire pagination --}}
                    <a href="#" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="px-3 py-1 rounded border border-gray-300 dark:border-zinc-700 hover:bg-gray-100 dark:hover:bg-zinc-700 transition">
                        &laquo;
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="px-3 py-1 text-gray-500 dark:text-zinc-400 select-none">...</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                            @if ($page == $paginator->currentPage())
                                <li>
                                    <span class="px-3 py-1 rounded border glow-effect border-blue-500 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300">
                                        {{ $page }}
                                    </span>
                                </li>
                            @else
                                <li>
                                    {{-- IMPORTANT: Use wire:click for Livewire pagination --}}
                                    <a href="#" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="px-3 py-1 rounded border border-gray-300 dark:border-zinc-700 hover:bg-gray-100 dark:hover:bg-zinc-700 transition">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endif
                        </span>
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    {{-- IMPORTANT: Use wire:click for Livewire pagination --}}
                    <a href="#" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="px-3 py-1 rounded border border-gray-300 dark:border-zinc-700 hover:bg-gray-100 dark:hover:bg-zinc-700 transition">
                        &raquo;
                    </a>
                </li>
            @else
                <li>
                    <span class="px-3 py-1 rounded border border-gray-300 dark:border-zinc-700 opacity-50 cursor-not-allowed select-none">
                        &raquo;
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
