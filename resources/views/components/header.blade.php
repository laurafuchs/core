{{ \Cachet\Facades\CachetView::renderHook(\Cachet\View\RenderHook::STATUS_PAGE_NAVIGATION_BEFORE) }}
<div class="flex items-center justify-between border-b border-zinc-200 px-4 sm:px-6 lg:px-8 py-4 dark:border-zinc-700">
    <div>
        <a href="{{ route('cachet.status-page') }}" class="transition hover:opacity-80">
            @if($appBanner)
            <img src="{{ Storage::url($appBanner) }}" alt="{{ $siteName }}" class="h-8 w-auto" />
            @else
            <x-cachet::logo class="hidden h-8 w-auto sm:block" />
            <x-cachet::logomark class="h-8 w-auto sm:hidden" />
            @endif
        </a>
    </div>

    <div class="flex items-center gap-2.5 sm:gap-5">
        <div
            x-data="{
                resolvedTheme: 'light',
                sync() {
                    this.resolvedTheme = window.CachetTheme?.resolved?.()
                        ?? (document.documentElement.classList.contains('dark') ? 'dark' : 'light')
                },
                toggle() {
                    const nextTheme = this.resolvedTheme === 'dark' ? 'light' : 'dark'

                    if (window.CachetTheme?.set) {
                        window.CachetTheme.set(nextTheme)

                        return
                    }

                    document.documentElement.classList.toggle('dark', nextTheme === 'dark')
                    document.documentElement.classList.toggle('light', nextTheme === 'light')
                    this.resolvedTheme = nextTheme
                },
            }"
            x-init="
                sync()
                window.addEventListener('cachet-theme-changed', () => sync())
            "
        >
            <button
                id="cachet-theme-toggle"
                type="button"
                x-on:click="toggle()"
                aria-label="{{ __('cachet::cachet.theme_toggle.dark_mode') }}"
                x-bind:aria-label="resolvedTheme === 'dark' ? @js(__('cachet::cachet.theme_toggle.light_mode')) : @js(__('cachet::cachet.theme_toggle.dark_mode'))"
                class="inline-flex items-center gap-2 rounded-sm border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-white/5"
            >
                <x-heroicon-o-moon
                    x-cloak
                    x-show="resolvedTheme !== 'dark'"
                    class="size-4"
                />
                <x-heroicon-o-sun
                    x-cloak
                    x-show="resolvedTheme === 'dark'"
                    class="size-4"
                />
                <span x-text="resolvedTheme === 'dark' ? @js(__('cachet::cachet.theme_toggle.light_mode')) : @js(__('cachet::cachet.theme_toggle.dark_mode'))">{{ __('cachet::cachet.theme_toggle.dark_mode') }}</span>
            </button>
        </div>
        @if ($dashboardLoginLink)
        <a href="{{ Cachet\Cachet::dashboardPath() }}" class="rounded-sm bg-accent px-3 py-2 text-sm font-semibold text-accent-foreground">
            {{ __('filament-panels::pages/dashboard.title') }}
        </a>
        @auth
        {{-- TODO: This form sucks... --}}
        <form action="{{ \Cachet\Cachet::dashboardPath() }}/logout" method="POST">
            @csrf
            <button class="text-sm font-medium text-zinc-800 transition hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300 sm:text-base">
                {{ __('filament-panels::layout.actions.logout.label') }}
            </button>
        </form>
        @endauth
        @endif
    </div>
</div>
{{ \Cachet\Facades\CachetView::renderHook(\Cachet\View\RenderHook::STATUS_PAGE_NAVIGATION_AFTER) }}
