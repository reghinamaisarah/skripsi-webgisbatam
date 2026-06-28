<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data & Insight Kawasan Industri</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .scrollbar-none { scrollbar-width: none; }
        .scrollbar-none::-webkit-scrollbar { display: none; }
    </style>
</head>

<body class="font-['Poppins'] bg-[#f5f3ee] text-[#1a1a2e]">

@include('partials.navbar')

@php
    $aksesMap = $aksesMap ?? collect();
    $total = $kawasan->count();
    $akses = fn($kawasanId, $field) => (bool) data_get($aksesMap->get($kawasanId), $field, false);
    $jmlJalan     = $kawasan->filter(fn($k) => $akses($k->id, 'jalan_5km'))->count();
    $jmlPelabuhan = $kawasan->filter(fn($k) => $akses($k->id, 'pelabuhan_5km'))->count();
    $jmlBandara   = $kawasan->filter(fn($k) => $akses($k->id, 'bandara_5km'))->count();
    $terjangkauSemua = $kawasan->filter(fn($k) => $akses($k->id, 'jalan_5km') && $akses($k->id, 'pelabuhan_5km') && $akses($k->id, 'bandara_5km'))->count();
    $tidakSatupun = $kawasan->filter(fn($k) => !$akses($k->id, 'jalan_5km') && !$akses($k->id, 'pelabuhan_5km') && !$akses($k->id, 'bandara_5km'))->count();
    $profilKombinasi = [
        ['chips'=>[['label'=>'Jalan','ya'=>true],['label'=>'Pelabuhan','ya'=>true],['label'=>'Bandara','ya'=>true]],'count'=>$kawasan->filter(fn($k)=> $akses($k->id,'jalan_5km')&& $akses($k->id,'pelabuhan_5km')&& $akses($k->id,'bandara_5km'))->count(),'barClass'=>'bg-[#059669]'],
        ['chips'=>[['label'=>'Jalan','ya'=>true],['label'=>'Pelabuhan','ya'=>true],['label'=>'Bandara','ya'=>false]],'count'=>$kawasan->filter(fn($k)=> $akses($k->id,'jalan_5km')&& $akses($k->id,'pelabuhan_5km')&&!$akses($k->id,'bandara_5km'))->count(),'barClass'=>'bg-[#0891b2]'],
        ['chips'=>[['label'=>'Jalan','ya'=>true],['label'=>'Pelabuhan','ya'=>false],['label'=>'Bandara','ya'=>true]],'count'=>$kawasan->filter(fn($k)=> $akses($k->id,'jalan_5km')&&!$akses($k->id,'pelabuhan_5km')&& $akses($k->id,'bandara_5km'))->count(),'barClass'=>'bg-[#7c3aed]'],
        ['chips'=>[['label'=>'Jalan','ya'=>true],['label'=>'Pelabuhan','ya'=>false],['label'=>'Bandara','ya'=>false]],'count'=>$kawasan->filter(fn($k)=> $akses($k->id,'jalan_5km')&&!$akses($k->id,'pelabuhan_5km')&&!$akses($k->id,'bandara_5km'))->count(),'barClass'=>'bg-[#d97706]'],
        ['chips'=>[['label'=>'Jalan','ya'=>false],['label'=>'Pelabuhan','ya'=>true],['label'=>'Bandara','ya'=>true]],'count'=>$kawasan->filter(fn($k)=>!$akses($k->id,'jalan_5km')&& $akses($k->id,'pelabuhan_5km')&& $akses($k->id,'bandara_5km'))->count(),'barClass'=>'bg-[#0891b2]'],
        ['chips'=>[['label'=>'Jalan','ya'=>false],['label'=>'Pelabuhan','ya'=>true],['label'=>'Bandara','ya'=>false]],'count'=>$kawasan->filter(fn($k)=>!$akses($k->id,'jalan_5km')&& $akses($k->id,'pelabuhan_5km')&&!$akses($k->id,'bandara_5km'))->count(),'barClass'=>'bg-[#6b7280]'],
        ['chips'=>[['label'=>'Jalan','ya'=>false],['label'=>'Pelabuhan','ya'=>false],['label'=>'Bandara','ya'=>true]],'count'=>$kawasan->filter(fn($k)=>!$akses($k->id,'jalan_5km')&&!$akses($k->id,'pelabuhan_5km')&& $akses($k->id,'bandara_5km'))->count(),'barClass'=>'bg-[#6b7280]'],
        ['chips'=>[['label'=>'Jalan','ya'=>false],['label'=>'Pelabuhan','ya'=>false],['label'=>'Bandara','ya'=>false]],'count'=>$tidakSatupun,'barClass'=>'bg-[#dc2626]'],
    ];
    $profilAktif = collect($profilKombinasi)->filter(fn($p) => $p['count'] > 0)->sortByDesc('count')->values();
    $kawasanBaik = $kawasan->filter(function($k) use ($akses) { $c = (int)$akses($k->id,'jalan_5km') + (int)$akses($k->id,'pelabuhan_5km') + (int)$akses($k->id,'bandara_5km'); return $c >= 2; })->sortByDesc(fn($k) => (int)$akses($k->id,'jalan_5km') + (int)$akses($k->id,'pelabuhan_5km') + (int)$akses($k->id,'bandara_5km'))->take(5)->values();
    $kawasanKurang = $kawasan->filter(function($k) use ($akses) { $c = (int)$akses($k->id,'jalan_5km') + (int)$akses($k->id,'pelabuhan_5km') + (int)$akses($k->id,'bandara_5km'); return $c <= 1; })->sortBy(fn($k) => (int)$akses($k->id,'jalan_5km') + (int)$akses($k->id,'pelabuhan_5km') + (int)$akses($k->id,'bandara_5km'))->take(5)->values();

    // class util reusable
    $statCardCls = 'bg-white border border-[#ececec] rounded-xl px-5 py-4 flex items-center gap-[0.9rem] shadow-[0_1px_3px_rgba(0,0,0,0.03)]';
    $insightCardCls = 'bg-white border border-[#ececec] rounded-xl px-5 pt-[1.1rem] pb-5 flex flex-col';
    $insightEmptyCls = 'flex-1 flex items-center justify-center text-[#b8b8b8] text-[0.78rem] italic border-[1.5px] border-dashed border-[#e5e5e5] rounded-[10px] p-6';
    $chipBase = 'text-[0.58rem] px-1.5 py-px rounded-full font-medium';
@endphp

<div class="pt-[90px] md:pt-[110px] px-4 sm:px-6 md:px-8 pb-8 w-full">
    <h1 class="text-[1.2rem] sm:text-[1.45rem] font-semibold text-[#111827]">Data &amp; Insight</h1>
    <p class="text-[0.78rem] sm:text-[0.82rem] text-[#6b7280] mt-1 mb-5 sm:mb-6">Seluruh data kawasan industri, pelabuhan, bandara, dan jalan di Kota Batam</p>

    {{-- STAT CARDS --}}
    @php
        $stats = [
            ['bg-[#fee2e2]', 'text-[#dc2626]', 'stroke-[#dc2626]', $totalKawasan, 'Kawasan Industri', '<path d="M12 16h.01"/><path d="M16 16h.01"/><path d="M3 19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.5a.5.5 0 0 0-.769-.422l-4.462 2.844A.5.5 0 0 1 15 10.5v-2a.5.5 0 0 0-.769-.422L9.77 10.922A.5.5 0 0 1 9 10.5V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2z"/><path d="M8 16h.01"/>'],
            ['bg-[#d1fae5]', 'text-[#059669]', 'stroke-[#059669]', $totalPelabuhan, 'Pelabuhan Barang', '<path d="M12 6v16"/><path d="m19 13 2-1a9 9 0 0 1-18 0l2 1"/><path d="M9 11h6"/><circle cx="12" cy="4" r="2"/>'],
            ['bg-[#dbeafe]', 'text-[#1a3a8f]', 'stroke-[#1a3a8f]', $totalBandara, 'Bandar Udara', '<path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>'],
            ['bg-[#fef3c7]', 'text-[#d97706]', 'stroke-[#d97706]', $totalJalan, 'Jalan Terdata', '<path d="M12 17v4"/><path d="M12 5V3"/><path d="M12 9v3"/><path d="M2.077 18.449A2 2 0 0 0 4 21h16a2 2 0 0 0 1.924-2.55l-4-14A2 2 0 0 0 16 3H8a2 2 0 0 0-1.924 1.45z"/>'],
        ];
    @endphp
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 mb-4 sm:mb-5">
        @foreach ($stats as [$bgClass, $textClass, $strokeClass, $num, $label, $svg])
        <div class="{{ $statCardCls }}">
            <div class="w-[36px] h-[36px] sm:w-[42px] sm:h-[42px] rounded-[10px] flex items-center justify-center shrink-0 {{ $bgClass }}">
                <svg viewBox="0 0 24 24" class="w-[18px] h-[18px] sm:w-[22px] sm:h-[22px] fill-none [stroke-width:2] [stroke-linecap:round] [stroke-linejoin:round] {{ $strokeClass }}">
                    {!! $svg !!}
                </svg>
            </div>
            <div>
                <div class="text-[1.35rem] sm:text-[1.65rem] font-bold leading-none {{ $textClass }}">{{ $num }}</div>
                <div class="text-[0.72rem] sm:text-[0.8rem] text-[#4b5563] mt-1">{{ $label }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- INSIGHT GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3 sm:gap-4 mb-4 sm:mb-5">

        {{-- Card 1 --}}
        <div class="{{ $insightCardCls }}">
            <div class="flex items-center gap-2 text-[0.85rem] font-semibold mb-4 text-[#1a3a8f]">
                <svg viewBox="0 0 24 24" class="w-4 h-4 fill-none [stroke-width:2] [stroke-linecap:round] [stroke-linejoin:round] stroke-[#1a3a8f]">
                    <path d="M21 12c.552 0 1.005-.449.95-.998a10 10 0 0 0-8.953-8.951c-.55-.055-.998.398-.998.95v8a1 1 0 0 0 1 1z"/>
                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"/>
                </svg>
                Distribusi Aksesibilitas
            </div>

            @if($total === 0)
                <div class="{{ $insightEmptyCls }}">Belum ada data kawasan</div>
            @else
                <div class="flex flex-col gap-[0.65rem]">
                    @php
                        $infraItems = [
                            ['label'=>'Jalan', 'count'=>$jmlJalan, 'dotClass'=>'bg-[#6b7280]', 'barClass'=>'bg-[#6b7280]'],
                            ['label'=>'Pelabuhan', 'count'=>$jmlPelabuhan, 'dotClass'=>'bg-[#0891b2]', 'barClass'=>'bg-[#0891b2]'],
                            ['label'=>'Bandara', 'count'=>$jmlBandara, 'dotClass'=>'bg-[#7c3aed]', 'barClass'=>'bg-[#7c3aed]'],
                        ];
                    @endphp
                    @foreach($infraItems as $item)
                    @php $pct = $total > 0 ? round($item['count'] / $total * 100) : 0; @endphp
                    <div class="flex flex-col gap-1">
                        <div class="flex justify-between items-center text-[0.74rem]">
                            <span class="flex items-center gap-1.5 text-[#374151] font-medium">
                                <span class="inline-block w-2 h-2 rounded-full shrink-0 {{ $item['dotClass'] }}"></span>
                                {{ $item['label'] }}
                            </span>
                            <span class="text-[#6b7280] text-[0.7rem]">{{ $item['count'] }} / {{ $total }} &nbsp;·&nbsp; {{ $pct }}%</span>
                        </div>
                        <div class="h-[7px] bg-[#f3f4f6] rounded overflow-hidden">
                            <div data-bar-pct="{{ $pct }}" class="h-full w-0 rounded transition-[width] duration-500 {{ $item['barClass'] }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-[0.85rem] pt-3 border-t border-[#f3f4f6] flex justify-between">
                    <div class="text-center">
                        <div class="text-[1.1rem] font-bold text-[#059669]">{{ $terjangkauSemua }}</div>
                        <div class="text-[0.65rem] text-[#9ca3af] mt-px">Terjangkau semua</div>
                    </div>
                    <div class="text-center">
                        <div class="text-[1.1rem] font-bold text-[#1a3a8f]">{{ $total }}</div>
                        <div class="text-[0.65rem] text-[#9ca3af] mt-px">Total kawasan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-[1.1rem] font-bold text-[#dc2626]">{{ $tidakSatupun }}</div>
                        <div class="text-[0.65rem] text-[#9ca3af] mt-px">Tidak terjangkau</div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Card 2 --}}
        <div class="{{ $insightCardCls }}">
            <div class="flex items-center gap-2 text-[0.85rem] font-semibold mb-4 text-[#1a3a8f]">
                <svg viewBox="0 0 24 24" class="w-4 h-4 fill-none [stroke-width:2] [stroke-linecap:round] [stroke-linejoin:round] stroke-[#1a3a8f]">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                </svg>
                Profil Kelengkapan Akses
            </div>

            @if($total === 0)
                <div class="{{ $insightEmptyCls }}">Belum ada data kawasan</div>
            @elseif($profilAktif->isEmpty())
                <div class="{{ $insightEmptyCls }}">Belum ada data aksesibilitas</div>
            @else
                <div class="flex flex-col gap-[0.65rem]">
                    @foreach($profilAktif as $profil)
                    @php $pct = $total > 0 ? round($profil['count'] / $total * 100) : 0; @endphp
                    <div class="flex flex-col gap-1">
                        <div class="flex justify-between items-center text-[0.74rem] mb-[3px]">
                            <span class="flex gap-[3px] items-center flex-wrap">
                                @foreach($profil['chips'] as $chip)
                                <span class="text-[0.57rem] px-1.5 py-px rounded-full font-medium {{ $chip['ya'] ? 'bg-[#d1fae5] text-[#059669]' : 'bg-[#fee2e2] text-[#dc2626]' }}">{{ $chip['label'] }}</span>
                                @endforeach
                            </span>
                            <span class="text-[#6b7280] text-[0.7rem]">{{ $profil['count'] }} &nbsp;·&nbsp; {{ $pct }}%</span>
                        </div>
                        <div class="h-[7px] bg-[#f3f4f6] rounded overflow-hidden">
                            <div data-bar-pct="{{ $pct }}" class="h-full w-0 rounded transition-[width] duration-500 {{ $profil['barClass'] }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p class="text-[0.68rem] text-[#9ca3af] mt-[0.85rem] pt-3 border-t border-[#f3f4f6]">
                    Hanya kombinasi yang ditemukan di data yang ditampilkan.
                </p>
            @endif
        </div>

        {{-- Card 3 & 4 --}}
        @php
            $rankCards = [
                ['Terjangkau Baik', 'text-[#059669]', 'stroke-[#059669]', '<polyline points="20 6 9 17 4 12"/>', $kawasanBaik, 'Tidak ada kawasan dengan akses ≥2 infrastruktur.', 'Terjangkau ≥2 infrastruktur dalam radius 5 km. Maks. 5 kawasan.'],
                ['Terjangkau Kurang', 'text-[#dc2626]', 'stroke-[#dc2626]', '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>', $kawasanKurang, 'Tidak ada kawasan dengan akses ≤1 infrastruktur.', 'Terjangkau ≤1 infrastruktur dalam radius 5 km. Maks. 5 kawasan.'],
            ];
        @endphp
        @foreach ($rankCards as [$title, $textClass, $strokeClass, $svg, $list, $emptyMsg, $footMsg])
        <div class="{{ $insightCardCls }}">
            <div class="flex items-center gap-2 text-[0.85rem] font-semibold mb-4 {{ $textClass }}">
                <svg viewBox="0 0 24 24" class="w-4 h-4 fill-none [stroke-width:2] [stroke-linecap:round] [stroke-linejoin:round] {{ $strokeClass }}">{!! $svg !!}</svg>
                {{ $title }}
            </div>
            @if($total === 0)
                <div class="{{ $insightEmptyCls }}">Belum ada data kawasan</div>
            @elseif($list->isEmpty())
                <div class="{{ $insightEmptyCls }}">{{ $emptyMsg }}</div>
            @else
                <div class="flex flex-col gap-2">
                    @foreach($list as $k)
                    <div class="flex items-center gap-[0.6rem] px-[0.65rem] py-2 rounded-lg border border-[#f3f4f6] bg-[#fafafa]">
                        <div class="flex-1 min-w-0">
                            <div class="text-[0.73rem] font-medium text-[#111827] whitespace-nowrap overflow-hidden text-ellipsis">{{ $k->nama }}</div>
                            <div class="flex gap-[3px] mt-[3px] flex-wrap">
                                <span class="{{ $chipBase }} {{ $akses($k->id,'jalan_5km') ? 'bg-[#d1fae5] text-[#059669]' : 'bg-[#fee2e2] text-[#dc2626]' }}">Jalan</span>
                                <span class="{{ $chipBase }} {{ $akses($k->id,'pelabuhan_5km') ? 'bg-[#d1fae5] text-[#059669]' : 'bg-[#fee2e2] text-[#dc2626]' }}">Pelabuhan</span>
                                <span class="{{ $chipBase }} {{ $akses($k->id,'bandara_5km') ? 'bg-[#d1fae5] text-[#059669]' : 'bg-[#fee2e2] text-[#dc2626]' }}">Bandara</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p class="text-[0.68rem] text-[#9ca3af] mt-[0.85rem] pt-3 border-t border-[#f3f4f6]">{{ $footMsg }}</p>
            @endif
        </div>
        @endforeach
    </div>

    {{-- TABS + TABLE --}}
    <div class="bg-white border border-[#e5e7eb] rounded-[10px] shadow-[0_1px_2px_rgba(0,0,0,0.03)] overflow-hidden">
        <div class="flex items-center gap-1 px-4 pt-3 border-b border-[#f0f0f0] overflow-x-auto scrollbar-none [-webkit-overflow-scrolling:touch]">
            @php
                $tabs = [
                    ['kawasan',"Kawasan Industri ({$totalKawasan})", true,'<path d="M12 16h.01"/><path d="M16 16h.01"/><path d="M3 19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.5a.5.5 0 0 0-.769-.422l-4.462 2.844A.5.5 0 0 1 15 10.5v-2a.5.5 0 0 0-.769-.422L9.77 10.922A.5.5 0 0 1 9 10.5V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2z"/><path d="M8 16h.01"/>'],
                    ['pelabuhan',"Pelabuhan Barang ({$totalPelabuhan})", false,'<path d="M12 6v16"/><path d="m19 13 2-1a9 9 0 0 1-18 0l2 1"/><path d="M9 11h6"/><circle cx="12" cy="4" r="2"/>'],
                    ['bandara',"Bandar Udara ({$totalBandara})", false,'<path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>'],
                    ['jalan',"Jalan Terdata ({$totalJalan})", false,'<path d="M12 17v4"/><path d="M12 5V3"/><path d="M12 9v3"/><path d="M2.077 18.449A2 2 0 0 0 4 21h16a2 2 0 0 0 1.924-2.55l-4-14A2 2 0 0 0 16 3H8a2 2 0 0 0-1.924 1.45z"/>'],
                ];
            @endphp
            @foreach ($tabs as [$key,$label,$active,$svg])
            <button
                    data-tab="{{ $key }}"
                    data-active="{{ $active ? 'true' : 'false' }}"
                    class="tab-btn flex shrink-0 cursor-pointer items-center gap-1.5 border-0 border-b-2 bg-transparent px-3 sm:px-4 py-[0.55rem]
                           text-[0.75rem] sm:text-[0.78rem] transition-[color,border-color] duration-[180ms] hover:text-[#1a3a8f] whitespace-nowrap
                           {{ $active ? 'border-[#1a3a8f] font-semibold text-[#1a3a8f]' : 'border-transparent font-medium text-[#6b7280]' }}">
                <svg viewBox="0 0 24 24" class="w-[14px] h-[14px] stroke-current fill-none [stroke-width:2] [stroke-linecap:round] [stroke-linejoin:round]">{!! $svg !!}</svg>
                {{ $label }}
            </button>
            @endforeach
        </div>

        <div class="flex gap-[0.6rem] px-4 py-[0.9rem] border-b border-[#e5e7eb] bg-white">
            <input type="text" id="searchInput" placeholder="Cari nama / lokasi..."
                   class="flex-1 w-full sm:max-w-[320px] text-[0.78rem] px-[0.85rem] py-[0.6rem] border border-[#e5e7eb] rounded-lg bg-white text-[#374151] outline-none focus:border-[#233d59]">
        </div>

        @php
            $tableWrap = 'border border-[#e5e7eb] rounded-lg overflow-auto max-h-[420px] sm:max-h-[520px] bg-white';
            $tableCls = 'w-full border-separate [border-spacing:0] text-[0.76rem] min-w-[1150px]';
            $thCls = 'sticky top-0 z-20 bg-[#f8fafc] text-left px-[0.9rem] py-3 font-semibold text-[#374151] text-[0.76rem] whitespace-nowrap border-b border-[#e5e7eb]';
            $tdCls = 'px-[0.9rem] py-3 border-t border-[#f3f4f6] text-[#374151] bg-white align-middle leading-[1.45]';
            $colNoTh = $thCls.' text-center w-[10px] min-w-[10px] max-w-[10px]';
            $colNoTd = $tdCls.' w-12 min-w-12 max-w-12 text-center';
            $emptyTr = 'text-center !p-8 text-[#9ca3af] italic';
        @endphp

        {{-- KAWASAN --}}
        <div id="panel-kawasan" class="tab-panel block">
            <div class="{{ $tableWrap }}">
                <table data-table class="{{ $tableCls }}">
                    <thead><tr>
                        <th class="{{ $colNoTh }}">No</th>
                        <th class="{{ $thCls }}">Nama</th>
                        <th class="{{ $thCls }} w-[200px] min-w-[220px]">Alamat</th>
                        <th class="{{ $thCls }}">Kecamatan</th>
                        <th class="{{ $thCls }}">Luas Lahan</th>
                        <th class="{{ $thCls }} w-[340px] min-w-[340px]">Infrastruktur</th>
                        <th class="{{ $thCls }} w-[300px] min-w-[300px]">Fasilitas</th>
                        <th class="{{ $thCls }}">Tahun Beroperasi</th>
                    </tr></thead>
                    <tbody>
                        @forelse($kawasan as $row)
                            <tr class="hover:[&_td]:bg-[#fafafa]">
                                <td class="{{ $colNoTd }}">{{ $loop->iteration }}</td>
                                <td class="{{ $tdCls }}">{{ $row->nama }}</td>
                                <td class="{{ $tdCls }} whitespace-normal break-words">{{ $row->lokasi }}</td>
                                <td class="{{ $tdCls }}">{{ $row->wilayah->kecamatan ?? '-' }}</td>
                                <td class="{{ $tdCls }}">{{ $row->luas_lahan }}</td>
                                <td class="{{ $tdCls }} w-[340px] min-w-[340px] whitespace-normal break-words">{{ $row->infrastruktur ?? '-' }}</td>
                                <td class="{{ $tdCls }} w-[300px] min-w-[300px] whitespace-normal break-words">{{ $row->fasilitas ?? '-' }}</td>
                                <td class="{{ $tdCls }}">{{ $row->tahun_beroperasi ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="{{ $emptyTr }}">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PELABUHAN --}}
        <div id="panel-pelabuhan" class="tab-panel hidden">
            <div class="{{ $tableWrap }}">
                <table data-table class="{{ $tableCls }}">
                    <thead><tr>
                        <th class="{{ $colNoTh }}">No</th>
                        <th class="{{ $thCls }}">Nama</th>
                        <th class="{{ $thCls }}">Alamat</th>
                        <th class="{{ $thCls }}">Kecamatan</th>
                        <th class="{{ $thCls }}">Jenis</th>
                    </tr></thead>
                    <tbody>
                        @forelse($pelabuhan as $row)
                            <tr class="hover:[&_td]:bg-[#fafafa]">
                                <td class="{{ $colNoTd }}">{{ $loop->iteration }}</td>
                                <td class="{{ $tdCls }}">{{ $row->nama }}</td>
                                <td class="{{ $tdCls }}">{{ $row->alamat ?? '-' }}</td>
                                <td class="{{ $tdCls }}">{{ $row->wilayah->kecamatan ?? '-' }}</td>
                                <td class="{{ $tdCls }}">{{ $row->jenis ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="{{ $emptyTr }}">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- BANDARA --}}
        <div id="panel-bandara" class="tab-panel hidden">
            <div class="{{ $tableWrap }}">
                <table data-table class="{{ $tableCls }}">
                    <thead><tr>
                        <th class="{{ $colNoTh }}">No</th>
                        <th class="{{ $thCls }}">Nama</th>
                        <th class="{{ $thCls }}">Alamat</th>
                        <th class="{{ $thCls }}">Kecamatan</th>
                    </tr></thead>
                    <tbody>
                        @forelse($bandara as $row)
                            <tr class="hover:[&_td]:bg-[#fafafa]">
                                <td class="{{ $colNoTd }}">{{ $loop->iteration }}</td>
                                <td class="{{ $tdCls }}">{{ $row->nama }}</td>
                                <td class="{{ $tdCls }}">{{ $row->alamat ?? '-' }}</td>
                                <td class="{{ $tdCls }}">{{ $row->wilayah->kecamatan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="{{ $emptyTr }}">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- JALAN --}}
        <div id="panel-jalan" class="tab-panel hidden">
            <div class="{{ $tableWrap }}">
                <table data-table class="{{ $tableCls }}">
                    <thead><tr>
                        <th class="{{ $colNoTh }}">No</th>
                        <th class="{{ $thCls }}">Nama Jalan</th>
                        <th class="{{ $thCls }}">Jenis Jalan</th>
                    </tr></thead>
                    <tbody>
                        @forelse($jalan as $row)
                            <tr class="hover:[&_td]:bg-[#fafafa]">
                                <td class="{{ $colNoTd }}">{{ $loop->iteration }}</td>
                                <td class="{{ $tdCls }}">{{ $row->nama_jalan }}</td>
                                <td class="{{ $tdCls }}">{{ $row->jenis_jalan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="{{ $emptyTr }}">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-bar-pct]').forEach(function (bar) {
        requestAnimationFrame(function () {
            bar.style.width = bar.dataset.barPct + '%';
        });
    });

    const tabs = document.querySelectorAll('.tab-btn');
    const panels = document.querySelectorAll('.tab-panel');
    const searchInput = document.getElementById('searchInput');

    function setActiveTab(activeButton) {
        tabs.forEach(function (button) {
            const active = button === activeButton;

            button.dataset.active = active ? 'true' : 'false';
            button.classList.toggle('border-[#1a3a8f]', active);
            button.classList.toggle('font-semibold', active);
            button.classList.toggle('text-[#1a3a8f]', active);
            button.classList.toggle('border-transparent', !active);
            button.classList.toggle('font-medium', !active);
            button.classList.toggle('text-[#6b7280]', !active);
        });

        panels.forEach(function (panel) {
            const active = panel.id === 'panel-' + activeButton.dataset.tab;

            panel.classList.toggle('block', active);
            panel.classList.toggle('hidden', !active);
        });

        if (searchInput) {
            searchInput.value = '';
        }

        filterRows('');
    }

    function filterRows(query) {
        const activePanel = document.querySelector('.tab-panel.block table tbody');

        if (!activePanel) return;

        const keyword = query.toLowerCase();

        activePanel.querySelectorAll('tr').forEach(function (row) {
            const matched = row.innerText.toLowerCase().includes(keyword);

            row.classList.toggle('hidden', !matched);
        });
    }

    tabs.forEach(function (button) {
        button.addEventListener('click', function () {
            setActiveTab(button);
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', function (event) {
            filterRows(event.target.value);
        });
    }
});
</script>

@stack('scripts')

</body>
</html>
