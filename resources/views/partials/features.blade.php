<section
    id="fitur"
    class="bg-[linear-gradient(180deg,#ffffff_0%,#B9CAD1_100%)] px-8 py-8 max-md:px-5 max-md:py-14"
>
    <div class="mx-auto max-w-[1080px]">

        <div class="fade-up mx-auto mb-14 max-w-[620px] translate-y-5 text-center opacity-0 transition-all duration-[600ms] ease-out">
            <p class="mb-2 font-['Plus_Jakarta_Sans'] text-[0.9375rem] font-[550] uppercase tracking-[0.1em] text-[#2F6390]">
                Fitur Utama
            </p>

            <h2 class="mb-[0.875rem] font-['Plus_Jakarta_Sans'] text-[1.45rem] font-bold text-[#213448]">
                Analisis Spasial Komprehensif
            </h2>

            <p class="mx-auto max-w-[520px] font-['DM_Sans'] text-[0.9375rem] leading-[1.7] text-[#37506b]">
                Fitur visualisasi dan analisis untuk memahami keterjangkauan kawasan industri terhadap infrastruktur pendukung di Kota Batam.
            </p>
        </div>

        @php
            $features = [
                [
                    'Peta Interaktif',
                    'Visualisasi kawasan industri dan infrastruktur pendukung melalui layer peta yang dapat diatur oleh pengguna.',
                    'delay-0',
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />'
                ],
                [
                    'Analisis Akses Pelabuhan',
                    'Pemeriksaan keterjangkauan kawasan industri terhadap pelabuhan pada radius yang dipilih.',
                    'delay-[50ms]',
                    '<path d="M12 6v16"/><path d="m19 13 2-1a9 9 0 0 1-18 0l2 1"/><path d="M9 11h6"/><circle cx="12" cy="4" r="2"/>'
                ],
                [
                    'Analisis Akses Bandara',
                    'Pemeriksaan keterjangkauan kawasan industri terhadap bandara pada radius yang dipilih.',
                    'delay-100',
                    '<path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>'
                ],
                [
                    'Analisis Akses Jalan',
                    'Pemeriksaan keterjangkauan kawasan industri terhadap jalan pada radius yang dipilih.',
                    'delay-150',
                    '<path d="M12 17v4"/><path d="M12 5V3"/><path d="M12 9v3"/><path d="M2.077 18.449A2 2 0 0 0 4 21h16a2 2 0 0 0 1.924-2.55l-4-14A2 2 0 0 0 16 3H8a2 2 0 0 0-1.924 1.45z"/>'
                ],
                [
                    'Buffer Analysis',
                    'Analisis spasial kawasan industri menggunakan radius buffer 1 km, 3 km, dan 5 km.',
                    'delay-200',
                    '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>'
                ],
                [
                    'Status Keterjangkauan',
                    'Penyajian kawasan yang terjangkau atau tidak terjangkau berdasarkan parameter analisis.',
                    'delay-[250ms]',
                    '<path d="m15 6 2 2 4-4"/><path d="M2 12h20A10 10 0 1 1 12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 4-10"/>'
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 gap-x-10 gap-y-14 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($features as [$name, $detail, $delay, $svg])
                <div
                    class="group fade-up relative flex translate-y-5 flex-col gap-3 overflow-hidden rounded-[16px]
                           border border-white/60 bg-[#EAF4F9] px-[1.625rem] py-7 opacity-0
                           shadow-[0_2px_0_rgba(33,52,72,0.25),0_6px_20px_rgba(33,52,72,0.1)]
                           transition-all duration-[600ms] ease-out {{ $delay }}
                           hover:-translate-y-1.5 hover:shadow-[0_2px_0_rgba(33,52,72,0.2),0_14px_32px_rgba(33,52,72,0.15)]
                           before:absolute before:bottom-5 before:left-0 before:top-5 before:w-[3px]
                           before:rounded-r-[3px] before:bg-[#213448] before:opacity-0 before:content-['']
                           before:transition-opacity before:duration-[220ms]
                           hover:before:opacity-100"
                >
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-[10px] bg-[#213448] transition-transform duration-[220ms] group-hover:scale-[1.08]">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            class="h-[22px] w-[22px] fill-none stroke-white [stroke-linecap:round] [stroke-linejoin:round] [stroke-width:1.75]"
                        >
                            {!! $svg !!}
                        </svg>
                    </div>

                    <p class="m-0 font-['Plus_Jakarta_Sans'] text-[0.875rem] font-semibold text-[#213448]">
                        {{ $name }}
                    </p>

                    <div class="my-0.5 h-px bg-[rgba(33,52,72,0.1)]"></div>

                    <p class="m-0 font-['DM_Sans'] text-[0.775rem] leading-[1.6] text-[#37506b]">
                        {{ $detail }}
                    </p>
                </div>
            @endforeach
        </div>

    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fadeItems = document.querySelectorAll('.fade-up');

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