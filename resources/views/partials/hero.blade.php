<section
    id="hero"
    class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden px-8 pb-16 pt-28 text-center font-['Plus_Jakarta_Sans']"
>
    <img
        src="{{ asset('images/bg-hero.png') }}"
        alt=""
        aria-hidden="true"
        class="absolute inset-0 h-full w-full object-cover object-center"
    >

    <div class="absolute inset-0 bg-[hsla(225,37%,15%,0.74)]"></div>

    <div
        class="hero-fade relative z-[2] max-w-[860px] translate-y-5 opacity-0 transition-all duration-[900ms] ease-out"
    >
        <h1
            class="mb-[1.125rem] text-[clamp(2.1rem,5vw,3.25rem)] font-bold leading-[1.15] text-white
                   [text-shadow:0_4px_24px_rgba(0,0,0,0.55),0_2px_8px_rgba(0,0,0,0.45),0_1px_2px_rgba(0,0,0,0.6)]"
        >
            Analisis <span class="text-[#C7EEFF]">Aksesibilitas</span><br>
            Kawasan Industri Kota Batam
        </h1>

        <p
            class="mb-8 font-['DM_Sans'] text-base font-normal leading-[1.7] text-white/[0.78]
                   [text-shadow:0_2px_10px_rgba(0,0,0,0.5)]"
        >
            Visualisasi dan analisis keterjangkauan kawasan industri terhadap jalan,<br class="hidden sm:block">
            pelabuhan, dan bandara di Kota Batam melalui peta interaktif.
        </p>
    </div>

    <div
        class="hero-fade relative z-[2] mb-10 flex flex-wrap justify-center gap-12 opacity-0 translate-y-5
               transition-all delay-100 duration-[900ms] ease-out max-[600px]:gap-6"
    >
        <div class="flex flex-col items-center text-white">
            <span class="text-[2rem] font-extrabold leading-none">
                {{ $totalKawasan ?? 0 }}
            </span>
            <span class="mt-1 text-center font-['DM_Sans'] text-xs text-white/65">
                Kawasan<br>Industri
            </span>
        </div>

        <div class="flex flex-col items-center text-white">
            <span class="text-[2rem] font-extrabold leading-none">
                {{ $totalBandara ?? 0 }}
            </span>
            <span class="mt-1 text-center font-['DM_Sans'] text-xs text-white/65">
                Bandar<br>Udara
            </span>
        </div>

        <div class="flex flex-col items-center text-white">
            <span class="text-[2rem] font-extrabold leading-none">
                {{ $totalPelabuhan ?? 0 }}
            </span>
            <span class="mt-1 text-center font-['DM_Sans'] text-xs text-white/65">
                Pelabuhan<br>Barang
            </span>
        </div>

        <div class="flex flex-col items-center text-white">
            <span class="text-[2rem] font-extrabold leading-none">
                {{ $totalJalan ?? 0 }}
            </span>
            <span class="mt-1 text-center font-['DM_Sans'] text-xs text-white/65">
                Jalan<br>Terpetakan
            </span>
        </div>
    </div>

    <div
        class="hero-fade relative z-[2] flex translate-y-5 flex-wrap justify-center gap-4 opacity-0
               transition-all delay-200 duration-[900ms] ease-out"
    >
        <a
            href="{{ route('peta.index') }}"
            class="group inline-flex items-center gap-[0.4rem] rounded-lg border border-white/10 bg-[#213448]
                   px-7 py-[0.7rem] font-['Plus_Jakarta_Sans'] text-[0.8125rem] font-normal text-[#F5F2EE]
                   no-underline transition-[background,transform] duration-200
                   hover:-translate-y-0.5 hover:bg-[#2b425a]"
        >
            Lihat Peta

            <svg
                viewBox="0 0 24 24"
                class="h-[15px] w-[15px] fill-none stroke-[#F5F2EE] transition-transform duration-200
                       [stroke-linecap:round] [stroke-linejoin:round] [stroke-width:2.25]
                       group-hover:translate-x-[3px]"
            >
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>

        <a
            href="#tentang"
            class="inline-flex items-center gap-[0.4rem] rounded-lg border border-white/[0.22]
                   bg-[#F5F2EE]/[0.12] px-7 py-[0.7rem] font-['Plus_Jakarta_Sans']
                   text-[0.8125rem] font-medium text-[#F5F2EE] no-underline backdrop-blur-[6px]
                   transition-[background,transform] duration-200
                   hover:-translate-y-0.5 hover:bg-[#F5F2EE]/20"
        >
            Pelajari Lebih Lanjut
        </a>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const heroItems = document.querySelectorAll('#hero .hero-fade');

    heroItems.forEach(function (item) {
        requestAnimationFrame(function () {
            item.classList.remove('translate-y-5', 'opacity-0');
            item.classList.add('translate-y-0', 'opacity-100');
        });
    });
});
</script>
@endpush