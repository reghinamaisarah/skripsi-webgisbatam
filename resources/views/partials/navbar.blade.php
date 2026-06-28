<nav
    id="mainNavbar"
    data-scrolled="{{ request()->is('/') ? 'false' : 'true' }}"
    data-mobile-open="false"
    class="group fixed left-0 right-0 top-0 z-[3000] flex h-[65px] translate-y-0 items-center justify-between overflow-visible
           border-b border-transparent px-10 font-['Poppins'] opacity-100 shadow-none
           transition-[background,box-shadow,border-color,transform,opacity] duration-300 ease-out
           max-md:h-[65px] max-md:px-5
           data-[scrolled=true]:border-black/[0.07]
           data-[scrolled=true]:bg-[#f5f3ee]
           data-[scrolled=true]:shadow-[0_2px_16px_rgba(0,0,0,0.08)]"
>
    <a href="{{ url('/') }}" class="flex shrink-0 items-center no-underline">
        <img
            src="{{ asset('images/logo-krem.png') }}"
            alt="Logo"
            class="relative top-1 h-[72px] w-auto transition-[opacity,transform] duration-300
                   hover:-rotate-2 hover:scale-[1.05]
                   max-md:h-[62px]
                   group-data-[scrolled=true]:hidden"
        >

        <img
            src="{{ asset('images/logo-biru.png') }}"
            alt="Logo"
            class="relative top-1 hidden h-[72px] w-auto transition-[opacity,transform] duration-300
                   hover:-rotate-2 hover:scale-[1.05]
                   max-md:h-[62px]
                   group-data-[scrolled=true]:block"
        >
    </a>

    @php
        $links = [
            [
                'url' => url('/'),
                'active' => request()->is('/'),
                'label' => 'Beranda',
                'svg' => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>'
            ],
            [
                'url' => route('peta.index'),
                'active' => request()->routeIs('peta.*'),
                'label' => 'Peta',
                'svg' => '<polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/>'
            ],
            [
                'url' => route('data.index'),
                'active' => request()->routeIs('data.*'),
                'label' => 'Data',
                'svg' => '<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>'
            ],
        ];
    @endphp

    {{-- Desktop Menu --}}
    <ul class="m-0 flex list-none items-center gap-1 p-0 max-md:hidden">
        @foreach ($links as $l)
            <li>
                <a
                    href="{{ $l['url'] }}"
                    data-active="{{ $l['active'] ? 'true' : 'false' }}"
                    class="group/link relative flex items-center gap-[0.45rem] rounded-lg px-[0.875rem] py-[0.45rem]
                           font-['Poppins'] text-xs font-medium no-underline text-[#F5F2EE]
                           transition-[background,color] duration-[180ms]
                           after:absolute after:bottom-[2px] after:left-[0.875rem] after:right-[0.875rem]
                           after:h-[2px] after:origin-left after:scale-x-0 after:rounded-[2px]
                           after:bg-[linear-gradient(90deg,#1a3a8f,#4a7fd4)]
                           after:transition-transform after:duration-[250ms]
                           hover:!text-[#F5F2EE] hover:after:scale-x-100
                           data-[active=true]:after:scale-x-100
                           group-data-[scrolled=true]:text-[#343434]
                           group-data-[scrolled=true]:hover:!text-[#1a3a8f]
                           data-[active=true]:group-data-[scrolled=true]:!text-[#1a3a8f]"
                >
                    <svg
                        viewBox="0 0 24 24"
                        class="h-4 w-4 shrink-0 fill-none stroke-current transition-transform duration-200
                               [stroke-linecap:round] [stroke-linejoin:round] [stroke-width:1.75]
                               group-hover/link:-translate-y-0.5"
                    >
                        {!! $l['svg'] !!}
                    </svg>

                    {{ $l['label'] }}
                </a>
            </li>
        @endforeach

        <li>
            <a
                href="{{ route('login') }}"
                class="group/btn ml-2 flex items-center gap-[0.45rem] whitespace-nowrap rounded-lg bg-[#233d59]
                       px-5 py-2 font-['Poppins'] text-sm font-medium !text-[#F5F2EE] no-underline
                       transition-colors duration-200 hover:bg-[#0f1f3d]"
            >
                <svg
                    viewBox="0 0 24 24"
                    class="h-4 w-4 fill-none stroke-[#F5F2EE] transition-transform duration-200
                           [stroke-linecap:round] [stroke-linejoin:round] [stroke-width:2]
                           group-hover/btn:translate-x-[3px]"
                >
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>

                Masuk
            </a>
        </li>
    </ul>

    {{-- Mobile Toggle --}}
    <button
        type="button"
        id="mobileMenuButton"
        aria-label="Buka menu navigasi"
        aria-controls="mobileMenu"
        aria-expanded="false"
        class="hidden h-10 w-10 items-center justify-center rounded-lg border border-white/20 bg-white/10
               text-[#F5F2EE] backdrop-blur-sm transition-colors duration-200
               hover:bg-white/20 max-md:flex
               group-data-[scrolled=true]:border-black/10
               group-data-[scrolled=true]:bg-white
               group-data-[scrolled=true]:text-[#233d59]
               group-data-[scrolled=true]:shadow-sm"
    >
        <svg
            id="hamburgerIcon"
            viewBox="0 0 24 24"
            class="h-6 w-6 fill-none stroke-current [stroke-linecap:round] [stroke-linejoin:round] [stroke-width:2]"
        >
            <line x1="4" y1="7" x2="20" y2="7"/>
            <line x1="4" y1="12" x2="20" y2="12"/>
            <line x1="4" y1="17" x2="20" y2="17"/>
        </svg>

        <svg
            id="closeIcon"
            viewBox="0 0 24 24"
            class="hidden h-6 w-6 fill-none stroke-current [stroke-linecap:round] [stroke-linejoin:round] [stroke-width:2]"
        >
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </button>

    {{-- Mobile Menu --}}
    <div
        id="mobileMenu"
        class="absolute left-5 right-5 top-[75px] z-[3100] hidden overflow-hidden rounded-2xl border border-black/[0.07]
            bg-[#f5f3ee] p-3 shadow-[0_12px_30px_rgba(0,0,0,0.12)]
            md:hidden"
    >
        <ul class="m-0 flex list-none flex-col gap-1 p-0">
            @foreach ($links as $l)
                <li>
                    <a
                        href="{{ $l['url'] }}"
                        data-active="{{ $l['active'] ? 'true' : 'false' }}"
                        class="group/mobile-link relative flex items-center gap-3 rounded-xl px-4 py-3
                            font-['Poppins'] text-sm font-medium no-underline text-[#343434]
                            transition-colors duration-200 hover:bg-[#233d59]/10 hover:!text-[#1a3a8f]
                            data-[active=true]:bg-[#233d59]/10 data-[active=true]:!text-[#1a3a8f]"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            class="h-4 w-4 shrink-0 fill-none stroke-current transition-transform duration-200
                                [stroke-linecap:round] [stroke-linejoin:round] [stroke-width:1.75]
                                group-hover/mobile-link:-translate-y-0.5"
                        >
                            {!! $l['svg'] !!}
                        </svg>

                        {{ $l['label'] }}
                    </a>
                </li>
            @endforeach

            <li class="pt-2">
                <a
                    href="{{ route('login') }}"
                    class="group/mobile-btn flex w-full items-center justify-center gap-[0.45rem] whitespace-nowrap rounded-xl bg-[#233d59]
                        px-5 py-3 font-['Poppins'] text-sm font-medium !text-[#F5F2EE] no-underline
                        transition-colors duration-200 hover:bg-[#0f1f3d]"
                >
                    <svg
                        viewBox="0 0 24 24"
                        class="h-4 w-4 fill-none stroke-[#F5F2EE] transition-transform duration-200
                            [stroke-linecap:round] [stroke-linejoin:round] [stroke-width:2]
                            group-hover/mobile-btn:translate-x-[3px]"
                    >
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>

                    Masuk
                </a>
            </li>
        </ul>
    </div>
</nav>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.getElementById('mainNavbar');
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    const hamburgerIcon = document.getElementById('hamburgerIcon');
    const closeIcon = document.getElementById('closeIcon');

    if (!navbar) return;

    const setScrolledState = () => {
        if (window.location.pathname === '/') {
            navbar.dataset.scrolled = window.scrollY > 10 ? 'true' : 'false';
        } else {
            navbar.dataset.scrolled = 'true';
        }
    };

    const closeMobileMenu = () => {
        if (!mobileMenu || !mobileMenuButton || !hamburgerIcon || !closeIcon) return;

        navbar.dataset.mobileOpen = 'false';
        mobileMenu.classList.add('hidden');
        mobileMenuButton.setAttribute('aria-expanded', 'false');
        hamburgerIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
    };

    const openMobileMenu = () => {
        if (!mobileMenu || !mobileMenuButton || !hamburgerIcon || !closeIcon) return;

        navbar.dataset.mobileOpen = 'true';
        mobileMenu.classList.remove('hidden');
        mobileMenuButton.setAttribute('aria-expanded', 'true');
        hamburgerIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
    };

    setScrolledState();

    window.addEventListener('scroll', setScrolledState);

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function (event) {
            event.stopPropagation();

            const isOpen = navbar.dataset.mobileOpen === 'true';
            isOpen ? closeMobileMenu() : openMobileMenu();
        });

        document.addEventListener('click', function (event) {
            const clickedInsideNavbar = navbar.contains(event.target);

            if (!clickedInsideNavbar) {
                closeMobileMenu();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeMobileMenu();
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) {
                closeMobileMenu();
            }
        });

        mobileMenu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', closeMobileMenu);
        });
    }
});
</script>
@endpush