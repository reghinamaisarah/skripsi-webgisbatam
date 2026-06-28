<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Aksesibilitas Kawasan Industri Kota Batam</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen items-center justify-center bg-[linear-gradient(160deg,#C4D3E2_0%,#ffffff_100%)] px-4 py-8 font-['Plus_Jakarta_Sans'] sm:p-6">

<div
    id="loginWrapper"
    class="w-full max-w-[820px] translate-y-[22px] scale-[0.98] opacity-0 transition-all duration-700 ease-[cubic-bezier(0.22,1,0.36,1)]
           max-[640px]:max-w-[390px]"
>
    <div
        class="flex min-h-[490px] w-full overflow-hidden rounded-[20px] bg-[#6B7886]
            shadow-[0_2px_0_rgba(33,52,72,0.28),0_24px_64px_rgba(33,52,72,0.22),0_4px_16px_rgba(33,52,72,0.14)]
            max-[640px]:min-h-0 max-[640px]:flex-col max-[640px]:rounded-2xl"
    >

        {{-- LEFT slideshow --}}
        <div class="relative min-w-[300px] flex-1 overflow-hidden
            max-[640px]:h-[210px] max-[640px]:min-w-0 max-[640px]:w-full max-[640px]:flex-none">
            @foreach (['login-1.png', 'login-2.png', 'login-3.png'] as $i => $img)
                <img
                    src="{{ asset('images/' . $img) }}"
                    alt=""
                    aria-hidden="true"
                    class="slide absolute inset-0 h-full w-full object-cover object-center transition-opacity duration-[900ms]
                           {{ $i === 0 ? 'opacity-100' : 'opacity-0' }}"
                >
            @endforeach

            <div class="absolute inset-0 z-[1] bg-[rgba(33,52,72,0.57)]"></div>
            <div class="absolute inset-0 z-[2] bg-[linear-gradient(to_top,rgba(33,52,72,0.5)_0%,transparent_50%)]"></div>

            <div class="absolute left-5 top-5 z-[4]">
                <img
                    src="{{ asset('images/logo-putih.png') }}"
                    alt="Logo"
                    class="block h-9 w-auto"
                >
            </div>

            <a
                href="{{ url('/') }}"
                class="absolute right-[1.1rem] top-[1.1rem] z-[4] inline-flex items-center gap-[0.35rem]
                       rounded-[20px] border border-white/30 bg-white/20 px-[0.85rem] py-[0.3rem]
                       font-['Plus_Jakarta_Sans'] text-[0.72rem] font-medium text-white no-underline
                       backdrop-blur-[10px] transition-colors duration-200 hover:bg-white/30"
            >
                <svg
                    viewBox="0 0 24 24"
                    class="h-[11px] w-[11px] fill-none stroke-white [stroke-linecap:round] [stroke-linejoin:round] [stroke-width:2.5]"
                >
                    <path d="M19 12H5M12 5l-7 7 7 7"/>
                </svg>

                Kembali
            </a>

            <div class="absolute bottom-0 left-0 right-0 z-[4] px-6 pb-[1.35rem] pt-6">
                @foreach ([
                    'Aksesibilitas Kawasan Industri<br>Terhadap Infrastruktur Pendukung',
                    'Kota Batam yang Terintegrasi<br>Jalan, Pelabuhan, dan Bandara<br>dalam Satu Sistem',
                    'WebGIS untuk Analisis Spasial<br>Visualisasi Data Aksesibilitas<br>Secara Interaktif',
                ] as $i => $cap)
                    <div class="slide-caption {{ $i === 0 ? 'block' : 'hidden' }}">
                        <h3
                            class="caption-text text-center text-[0.9375rem] font-bold leading-[1.4] text-white
                                   transition-all duration-[550ms] ease-out
                                   [text-shadow:0_2px_14px_rgba(0,0,0,0.5)]
                                   {{ $i === 0 ? 'translate-y-0 opacity-100' : 'translate-y-2 opacity-0' }}"
                        >
                            {!! $cap !!}
                        </h3>
                    </div>
                @endforeach

                <div class="mt-[0.875rem] flex justify-center gap-[0.4rem]">
                    @for ($i = 0; $i < 3; $i++)
                        <button
                            type="button"
                            data-slide="{{ $i }}"
                            aria-label="Pindah ke slide {{ $i + 1 }}"
                            class="dot h-[3px] cursor-pointer rounded-[2px] border-0 p-0 transition-[background,width] duration-300
                                   {{ $i === 0 ? 'w-7 bg-white' : 'w-[18px] bg-white/35' }}"
                        ></button>
                    @endfor
                </div>
            </div>
        </div>

        {{-- RIGHT form --}}
        <div class="flex flex-1 flex-col justify-center border-l border-white/10 px-12 py-11
            max-[640px]:border-l-0 max-[640px]:border-t max-[640px]:border-white/10
            max-[640px]:px-7 max-[640px]:py-8">

            <h2 class="mb-[0.4rem] text-center text-2xl font-bold tracking-[-0.01em] text-white
                       max-[640px]:text-[1.35rem]">
                Masuk Website
            </h2>

            <p class="mb-10 text-center font-['DM_Sans'] text-[0.775rem] leading-[1.55] text-white/55
                      max-[640px]:mb-8 max-[640px]:text-[0.75rem]">
                Masukkan email dan kata sandi yang terdaftar
            </p>

            @if(session('error'))
                <div
                    class="mb-6 flex items-start gap-2 rounded-lg border border-red-500/[0.32]
                           bg-red-500/[0.14] px-[0.875rem] py-[0.6rem]
                           font-['DM_Sans'] text-xs leading-relaxed text-[#fca5a5]"
                >
                    <svg
                        viewBox="0 0 24 24"
                        class="mt-0.5 h-3.5 w-3.5 shrink-0 fill-none stroke-[#fca5a5] [stroke-linecap:round] [stroke-linejoin:round] [stroke-width:2]"
                    >
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>

                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-7 max-[640px]:mb-6">
                    <label
                        for="email"
                        class="mb-[0.6rem] block text-[0.8rem] font-semibold text-white/[0.78]"
                    >
                        Email
                    </label>

                    <div class="group flex items-center border-b-[1.5px] border-white/[0.28] transition-colors duration-200 focus-within:border-white/80">
                        <svg
                            viewBox="0 0 24 24"
                            class="pointer-events-none h-[14px] w-[14px] shrink-0 fill-none stroke-white/45
                                   transition-[stroke] duration-200 [stroke-linecap:round] [stroke-linejoin:round] [stroke-width:1.75]
                                   group-focus-within:stroke-white/85"
                        >
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>

                        <span class="mx-[0.65rem] h-[14px] w-px shrink-0 bg-white/[0.28]"></span>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Masukkan email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required
                            class="login-input flex-1 border-none bg-transparent py-2 font-['DM_Sans'] text-[0.8rem] text-white outline-none
                                   placeholder:text-[0.775rem] placeholder:text-white/35
                                   max-[640px]:py-2.5
                                   [&:-webkit-autofill]:[-webkit-box-shadow:0_0_0_100px_#6B7886_inset]
                                   [&:-webkit-autofill]:[-webkit-text-fill-color:#fff]
                                   [&:-webkit-autofill]:[caret-color:#fff]"
                        >
                    </div>

                    @error('email')
                        <span class="mt-[0.35rem] block font-['DM_Sans'] text-[0.7rem] text-[#fca5a5]">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="mb-7 max-[640px]:mb-6">
                    <label
                        for="password"
                        class="mb-[0.6rem] block text-[0.8rem] font-semibold text-white/[0.78]"
                    >
                        Kata Sandi
                    </label>

                    <div class="group flex items-center border-b-[1.5px] border-white/[0.28] transition-colors duration-200 focus-within:border-white/80">
                        <svg
                            viewBox="0 0 24 24"
                            class="pointer-events-none h-[14px] w-[14px] shrink-0 fill-none stroke-white/45
                                   transition-[stroke] duration-200 [stroke-linecap:round] [stroke-linejoin:round] [stroke-width:1.75]
                                   group-focus-within:stroke-white/85"
                        >
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>

                        <span class="mx-[0.65rem] h-[14px] w-px shrink-0 bg-white/[0.28]"></span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan kata sandi"
                            autocomplete="current-password"
                            required
                            class="login-input flex-1 border-none bg-transparent py-2 font-['DM_Sans'] text-[0.8rem] text-white outline-none
                                   placeholder:text-[0.775rem] placeholder:text-white/35
                                   max-[640px]:py-2.5
                                   [&:-webkit-autofill]:[-webkit-box-shadow:0_0_0_100px_#6B7886_inset]
                                   [&:-webkit-autofill]:[-webkit-text-fill-color:#fff]
                                   [&:-webkit-autofill]:[caret-color:#fff]"
                        >

                        <button
                            type="button"
                            id="passwordToggle"
                            tabindex="-1"
                            class="group/eye flex shrink-0 cursor-pointer items-center border-none bg-transparent py-1 pl-2
                                   max-[640px]:py-2"
                        >
                            <svg
                                id="eye-icon"
                                viewBox="0 0 24 24"
                                class="h-[14px] w-[14px] fill-none stroke-white/40 transition-[stroke] duration-200
                                       [stroke-linecap:round] [stroke-linejoin:round] [stroke-width:1.75]
                                       group-hover/eye:stroke-white/[0.82]"
                            >
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>

                    @error('password')
                        <span class="mt-[0.35rem] block font-['DM_Sans'] text-[0.7rem] text-[#fca5a5]">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="mt-6 w-full cursor-pointer rounded-lg border-none bg-[#F5F2EE] py-3
                           font-['Plus_Jakarta_Sans'] text-sm font-semibold tracking-[0.01em] text-[#213448]
                           shadow-[0_2px_0_rgba(0,0,0,0.18),0_1px_3px_rgba(0,0,0,0.12)]
                           transition-[background,transform,box-shadow] duration-200
                           hover:-translate-y-px hover:bg-[#ede9e4] hover:shadow-[0_4px_14px_rgba(0,0,0,0.2)]
                           active:translate-y-0
                           max-[640px]:mt-5 max-[640px]:py-3.5"
                >
                    Masuk
                </button>
            </form>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('loginWrapper');

    if (wrapper) {
        requestAnimationFrame(function () {
            wrapper.classList.remove('translate-y-[22px]', 'scale-[0.98]', 'opacity-0');
            wrapper.classList.add('translate-y-0', 'scale-100', 'opacity-100');
        });
    }

    let current = 0;

    const slides = document.querySelectorAll('.slide');
    const captions = document.querySelectorAll('.slide-caption');
    const captionTexts = document.querySelectorAll('.caption-text');
    const dots = document.querySelectorAll('.dot');

    let timer;

    function goSlide(nextIndex) {
        if (!slides.length || !captions.length || !dots.length) return;

        slides[current].classList.remove('opacity-100');
        slides[current].classList.add('opacity-0');

        captions[current].classList.remove('block');
        captions[current].classList.add('hidden');

        if (captionTexts[current]) {
            captionTexts[current].classList.remove('translate-y-0', 'opacity-100');
            captionTexts[current].classList.add('translate-y-2', 'opacity-0');
        }

        dots[current].classList.remove('w-7', 'bg-white');
        dots[current].classList.add('w-[18px]', 'bg-white/35');

        current = nextIndex;

        slides[current].classList.remove('opacity-0');
        slides[current].classList.add('opacity-100');

        captions[current].classList.remove('hidden');
        captions[current].classList.add('block');

        requestAnimationFrame(function () {
            if (captionTexts[current]) {
                captionTexts[current].classList.remove('translate-y-2', 'opacity-0');
                captionTexts[current].classList.add('translate-y-0', 'opacity-100');
            }
        });

        dots[current].classList.remove('w-[18px]', 'bg-white/35');
        dots[current].classList.add('w-7', 'bg-white');

        clearInterval(timer);
        timer = setInterval(nextSlide, 4500);
    }

    function nextSlide() {
        goSlide((current + 1) % slides.length);
    }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            goSlide(Number(dot.dataset.slide));
        });
    });

    if (slides.length > 1) {
        timer = setInterval(nextSlide, 4500);
    }

    const passwordInput = document.getElementById('password');
    const passwordToggle = document.getElementById('passwordToggle');
    const eyeIcon = document.getElementById('eye-icon');

    if (passwordInput && passwordToggle && eyeIcon) {
        passwordToggle.addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';

                eyeIcon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>
                `;
            } else {
                passwordInput.type = 'password';

                eyeIcon.innerHTML = `
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                    <circle cx="12" cy="12" r="3"/>
                `;
            }
        });
    }
});
</script>

</body>
</html>