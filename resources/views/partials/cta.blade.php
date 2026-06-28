<section
    id="eksplorasi"
    class="bg-[linear-gradient(180deg,#B9CAD1_0%,#DCE5E8_60%,#ffffff_100%)]
           px-8 pb-20 pt-16 text-center
           max-[640px]:px-5 max-[640px]:pb-14 max-[640px]:pt-12"
>
    <div class="mx-auto max-w-[780px]">

        <p class="fade-up mb-2 translate-y-5 font-['Plus_Jakarta_Sans'] text-[0.9375rem] font-[550] uppercase tracking-[0.1em] text-[#2F6390] opacity-0 transition-all duration-[600ms] ease-out
                  max-[640px]:text-[0.78rem] max-[640px]:tracking-[0.08em]">
            Eksplorasi
        </p>

        <h2 class="fade-up mb-[0.875rem] translate-y-5 font-['Plus_Jakarta_Sans'] text-[1.45rem] font-bold leading-[1.25] text-[#213448] opacity-0 transition-all delay-75 duration-[600ms] ease-out
                   max-[640px]:text-[1.35rem] max-[640px]:leading-[1.25]">
            Mulai Analisis Aksesibilitas
        </h2>

        <p class="fade-up mb-7 translate-y-5 font-['DM_Sans'] text-[0.9375rem] leading-[1.7] text-[#37506b] opacity-0 transition-all delay-100 duration-[600ms] ease-out
                  max-[640px]:mb-6 max-[640px]:text-[0.875rem] max-[640px]:leading-[1.65]">
            Jelajahi peta interaktif dan analisis keterjangkauan kawasan industri<br class="hidden sm:block">
            terhadap jalan, pelabuhan, dan bandara di Kota Batam.
        </p>

        <div class="fade-up mb-10 flex translate-y-5 flex-wrap items-center justify-center opacity-0 transition-all delay-150 duration-[600ms] ease-out
                    max-[640px]:mb-8 max-[640px]:flex-col max-[640px]:gap-3">
            @foreach ([
                'Data Spasial Terintegrasi',
                'Analisis Interaktif',
                'Mudah Digunakan',
            ] as $i => $label)
                <span
                    class="flex items-center gap-2 px-7 font-['Plus_Jakarta_Sans'] text-[0.9375rem] font-[450] text-[#37506b]
                           max-[640px]:w-full max-[640px]:justify-center max-[640px]:rounded-full
                           max-[640px]:border max-[640px]:border-[#213448]/10 max-[640px]:bg-white/35
                           max-[640px]:px-4 max-[640px]:py-2.5 max-[640px]:text-[0.82rem]
                           {{ $i < 2 ? 'border-r-2 border-[#213448a4] max-[640px]:border-r max-[640px]:border-[#213448]/10' : '' }}"
                >
                    <svg
                        viewBox="0 0 24 24"
                        class="h-6 w-6 shrink-0 fill-none stroke-[#5d97d5] [stroke-linecap:round] [stroke-linejoin:round] [stroke-width:3.5]
                               max-[640px]:h-5 max-[640px]:w-5"
                    >
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>

                    {{ $label }}
                </span>
            @endforeach
        </div>

        <div
            class="fade-up relative translate-y-5 overflow-hidden rounded-[20px] border border-[rgba(180,205,240,0.6)]
                   opacity-0 shadow-[0_2px_0_rgba(33,52,72,0.2),0_8px_32px_rgba(26,80,160,0.12)]
                   transition-all delay-200 duration-[600ms] ease-out
                   max-[640px]:rounded-2xl"
        >
            <img
                src="{{ asset('images/eksplorasi.png') }}"
                alt="Preview Peta Industri Kota Batam"
                class="block h-[300px] w-full object-cover opacity-90
                       max-[640px]:h-[220px] max-[420px]:h-[190px]"
            >

            <div
                class="absolute inset-0 flex items-center justify-center px-4
                       bg-[linear-gradient(160deg,rgba(199,218,228,0.3)_0%,rgba(199,218,228,0.55)_100%)]"
            >
                <a
                    href="{{ route('peta.index') }}"
                    class="group inline-flex items-center justify-center gap-2 rounded-[10px] bg-[#F5F2EE] px-7 py-3
                           font-['Plus_Jakarta_Sans'] text-sm font-medium text-[#213448] no-underline
                           shadow-[0_2px_0_rgba(33,52,72,0.5),0_6px_18px_rgba(33,52,72,0.2)]
                           transition-[transform,box-shadow,background] duration-200
                           hover:-translate-y-[3px] hover:bg-white
                           hover:shadow-[0_2px_0_rgba(33,52,72,0.45),0_10px_24px_rgba(33,52,72,0.22)]
                           active:translate-y-0
                           max-[640px]:w-full max-[640px]:max-w-[260px]
                           max-[640px]:px-5 max-[640px]:py-3 max-[640px]:text-[0.82rem]"
                >
                    Jelajahi Peta Industri

                    <svg
                        viewBox="0 0 24 24"
                        class="h-[18px] w-[18px] fill-none stroke-[#213448] transition-transform duration-200
                               [stroke-linecap:round] [stroke-linejoin:round] [stroke-width:2.5]
                               group-hover:translate-x-[3px]
                               max-[640px]:h-4 max-[640px]:w-4"
                    >
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fadeItems = document.querySelectorAll('#eksplorasi .fade-up');

    if (!fadeItems.length) return;

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;

            entry.target.classList.remove('translate-y-5', 'opacity-0');
            entry.target.classList.add('translate-y-0', 'opacity-100');

            observer.unobserve(entry.target);
        });
    }, {
        threshold: 0.15
    });

    fadeItems.forEach(function (item) {
        observer.observe(item);
    });
});
</script>
@endpush