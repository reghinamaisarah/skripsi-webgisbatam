<section
    id="tentang"
    class="bg-white px-8 py-16 font-['DM_Sans']"
>
    <div class="mx-auto grid max-w-[1080px] grid-cols-1 items-start gap-8 md:grid-cols-[1fr_1.1fr] md:gap-16">

        {{-- Kiri --}}
        <div class="fade-up translate-y-5 opacity-0 transition-all duration-[600ms] ease-out">
            <p class="mb-2 flex items-center gap-2 font-['Plus_Jakarta_Sans'] text-[0.9375rem] font-[550] uppercase tracking-[0.1em] text-[#2F6390]">
                Tentang Sistem
            </p>

            <h2 class="mb-6 font-['Plus_Jakarta_Sans'] text-[1.45rem] font-bold leading-[1.2] text-[#213448] md:whitespace-nowrap">
                Sistem Informasi Geografis Berbasis Web
            </h2>

            <p class="mb-4 text-[0.9375rem] leading-[1.8] text-[#37506b]">
                WebGIS ini dirancang untuk memvisualisasikan dan menganalisis keterjangkauan kawasan industri di Kota Batam terhadap infrastruktur pendukung berupa jalan, pelabuhan, dan bandara.
            </p>

            <p class="mb-4 text-[0.9375rem] leading-[1.8] text-[#37506b]">
                Pengguna dapat memilih radius analisis, jenis infrastruktur, serta status keterjangkauan kawasan. Sistem kemudian menampilkan hasil analisis secara interaktif melalui peta dan panel ringkasan.
            </p>

            <div class="mt-7 flex flex-wrap gap-2.5">
                @foreach ([
                    '26 Kawasan Industri',
                    'Buffer 1 km, 3 km, dan 5 km',
                    'Analisis Spasial Interaktif',
                ] as $tag)
                    <span
                        class="inline-flex items-center gap-[0.4rem] rounded-full border border-[rgba(26,115,232,0.15)]
                               bg-[rgba(26,115,232,0.07)] px-3 py-[0.3rem] font-['Plus_Jakarta_Sans']
                               text-[0.68rem] font-medium text-[#304f70]
                               transition-[background,border-color] duration-[180ms]
                               before:h-[6px] before:w-[6px] before:shrink-0 before:rounded-full
                               before:bg-[#1a73e8] before:opacity-60 before:content-['']
                               hover:border-[rgba(26,115,232,0.3)] hover:bg-[rgba(26,115,232,0.13)]"
                    >
                        {{ $tag }}
                    </span>
                @endforeach
            </div>
        </div>

        {{-- Kanan: methodology box --}}
        <div
            class="fade-up relative overflow-hidden rounded-[20px] bg-[#0f2147] px-6 pb-6 pt-7
                   translate-y-5 opacity-0 transition-all delay-100 duration-[600ms] ease-out
                   before:pointer-events-none before:absolute before:-right-[50px] before:-top-[60px]
                   before:h-40 before:w-40 before:rounded-full before:bg-white/[0.03] before:content-['']
                   after:pointer-events-none after:absolute after:bottom-5 after:-left-[30px]
                   after:h-20 after:w-20 after:rounded-full after:bg-white/[0.02] after:content-['']"
        >
            <p
                class="mb-5 flex items-center gap-2 font-['Plus_Jakarta_Sans'] text-[0.9375rem] font-medium text-white
                       before:h-[18px] before:w-[4px] before:shrink-0 before:rounded-[2px]
                       before:bg-white/35 before:content-['']"
            >
                Tahapan Analisis
            </p>

            @php
                $methods = [
                    ['01', 'Pengumpulan Data', 'Data kawasan industri, jalan, pelabuhan, bandara, dan wilayah administrasi Kota Batam.'],
                    ['02', 'Pembentukan Buffer', 'Sistem membentuk area jangkauan kawasan industri berdasarkan pemilihan radius 1 km, 3 km, atau 5 km.'],
                    ['03', 'Analisis Keterjangkauan', 'Pemeriksaan keterjangkauan kawasan terhadap jalan, pelabuhan, dan bandara sesuai parameter yang dipilih.'],
                    ['04', 'Visualisasi Hasil', 'Penyajian hasil analisis melalui peta interaktif, visualisasi buffer, dan panel ringkasan.'],
                ];
            @endphp

            <div
                id="methodScroll"
                class="flex snap-x snap-mandatory gap-3 overflow-x-auto scroll-smooth pb-2
                    overscroll-x-contain [scrollbar-width:none] [-webkit-overflow-scrolling:touch]
                    [&::-webkit-scrollbar]:hidden"
            >
                @foreach ($methods as [$num, $name, $detail])
                    <div
                        class="method-card group relative flex flex-[0_0_196px] snap-start flex-col gap-2.5 overflow-hidden
                            rounded-[14px] border border-white/[0.09] bg-white/[0.05]
                            px-[1.125rem] py-5 transition-[background,border-color] duration-200
                            before:absolute before:left-4 before:right-4 before:top-0 before:h-[2px]
                            before:rounded-b-[2px] before:bg-white/[0.12] before:content-['']
                            before:transition-[background] before:duration-200
                            hover:border-white/[0.15] hover:bg-white/[0.09] hover:before:bg-white/30
                            max-[640px]:flex-[0_0_82%]"
                    >
                        <div
                            class="flex h-[30px] w-[30px] shrink-0 items-center justify-center rounded-lg
                                bg-[#EAF9FF] font-['Plus_Jakarta_Sans'] text-[0.7rem]
                                font-semibold text-[#2F6390]"
                        >
                            {{ $num }}
                        </div>

                        <p class="font-['Plus_Jakarta_Sans'] text-[0.75rem] font-semibold leading-[1.3] text-white">
                            {{ $name }}
                        </p>

                        <div class="my-0.5 h-px bg-white/[0.08]"></div>

                        <p class="text-[0.6875rem] font-normal leading-[1.55] text-white/50">
                            {{ $detail }}
                        </p>
                    </div>
                @endforeach
            </div>

            <div id="methodDots" class="mt-[1.125rem] flex justify-center gap-[5px]">
                @foreach ($methods as $index => $method)
                    <button
                        type="button"
                        data-method-dot="{{ $index }}"
                        aria-label="Tahapan {{ $index + 1 }}"
                        class="method-dot h-[5px] rounded-full border-0 p-0 transition-all duration-200
                            {{ $index === 0 ? 'w-4 rounded-[3px] bg-white/70' : 'w-[5px] bg-white/20' }}"
                    ></button>
                @endforeach
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fadeItems = document.querySelectorAll('#tentang .fade-up');

    fadeItems.forEach(function (item) {
        requestAnimationFrame(function () {
            item.classList.remove('translate-y-5', 'opacity-0');
            item.classList.add('translate-y-0', 'opacity-100');
        });
    });

    const scroll = document.getElementById('methodScroll');
    const dots = document.querySelectorAll('#methodDots .method-dot');

    if (!scroll || dots.length === 0) return;

    let originalCards = Array.from(scroll.querySelectorAll('.method-card'));
    const realCount = originalCards.length;

    if (realCount === 0) return;

    originalCards.forEach(function (card) {
        const clone = card.cloneNode(true);
        clone.setAttribute('aria-hidden', 'true');
        scroll.appendChild(clone);
    });

    [...originalCards].reverse().forEach(function (card) {
        const clone = card.cloneNode(true);
        clone.setAttribute('aria-hidden', 'true');
        scroll.prepend(clone);
    });

    function getCardWidth() {
        const styles = window.getComputedStyle(scroll);
        const gap = parseFloat(styles.columnGap || styles.gap || 0);

        return originalCards[0].offsetWidth + gap;
    }

    function getLoopStart() {
        return getCardWidth() * realCount;
    }

    function setActiveDot(activeIndex) {
        dots.forEach(function (dot, index) {
            const active = index === activeIndex;

            dot.classList.toggle('w-4', active);
            dot.classList.toggle('rounded-[3px]', active);
            dot.classList.toggle('bg-white/70', active);

            dot.classList.toggle('w-[5px]', !active);
            dot.classList.toggle('rounded-full', !active);
            dot.classList.toggle('bg-white/20', !active);
        });
    }

    function getActiveIndex() {
        const cardWidth = getCardWidth();

        if (!cardWidth) return 0;

        const middleStart = cardWidth * realCount;
        const rawIndex = Math.round((scroll.scrollLeft - middleStart) / cardWidth);
        const activeIndex = ((rawIndex % realCount) + realCount) % realCount;

        return activeIndex;
    }

    function updateDots() {
        setActiveDot(getActiveIndex());
    }

    function keepLooping() {
        const cardWidth = getCardWidth();

        if (!cardWidth) return;

        const leftLimit = cardWidth * 0.5;
        const rightLimit = cardWidth * ((realCount * 2) - 0.5);

        if (scroll.scrollLeft <= leftLimit) {
            scroll.classList.remove('scroll-smooth');
            scroll.scrollLeft += cardWidth * realCount;
            requestAnimationFrame(function () {
                scroll.classList.add('scroll-smooth');
            });
        }

        if (scroll.scrollLeft >= rightLimit) {
            scroll.classList.remove('scroll-smooth');
            scroll.scrollLeft -= cardWidth * realCount;
            requestAnimationFrame(function () {
                scroll.classList.add('scroll-smooth');
            });
        }

        updateDots();
    }

    requestAnimationFrame(function () {
        scroll.classList.remove('scroll-smooth');
        scroll.scrollLeft = getLoopStart();

        requestAnimationFrame(function () {
            scroll.classList.add('scroll-smooth');
            updateDots();
        });
    });

    dots.forEach(function (dot, index) {
        dot.addEventListener('click', function () {
            const cardWidth = getCardWidth();

            if (!cardWidth) return;

            scroll.scrollTo({
                left: getLoopStart() + (cardWidth * index),
                behavior: 'smooth'
            });

            setActiveDot(index);
        });
    });

    scroll.addEventListener('scroll', keepLooping);

    window.addEventListener('resize', function () {
        scroll.classList.remove('scroll-smooth');
        scroll.scrollLeft = getLoopStart() + (getCardWidth() * getActiveIndex());

        requestAnimationFrame(function () {
            scroll.classList.add('scroll-smooth');
            updateDots();
        });
    });
});
</script>
@endpush