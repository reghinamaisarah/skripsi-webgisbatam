<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Aksesibilitas Kawasan Industri Batam</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-screen overflow-hidden bg-[#f0eff4] font-['Poppins'] text-[#18172b]">

@include('partials.navbar')

@php
    $hasApplied = $hasApplied ?? false;
@endphp

{{-- ── Mobile: overlay & tombol toggle ── --}}
<div class="drawer-overlay fixed inset-x-0 bottom-0 top-[60px] z-[1099] hidden bg-black/35 [&.active]:block md:hidden" id="drawerOverlay" onclick="closeAllDrawers()"></div>

<button class="mobile-fab-left fixed bottom-6 left-4 z-[1050] flex items-center gap-1.5 rounded-full bg-white px-3.5 py-2 text-[0.7rem] font-semibold text-[#18172b] shadow-[0_4px_16px_rgba(0,0,0,0.14)] transition-all duration-200 active:scale-95 md:hidden"
        onclick="toggleDrawer('left')" aria-label="Buka panel parameter analisis">
    <svg class="mr-[5px] inline align-middle" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
    Parameter Analisis
</button>

<button class="mobile-fab-right fixed bottom-6 right-4 z-[1050] flex items-center gap-1.5 rounded-full bg-[#3b5bdb] px-3.5 py-2 text-[0.7rem] font-semibold text-white shadow-[0_4px_16px_rgba(59,91,219,0.4)] transition-all duration-200 active:scale-95 md:hidden"
        onclick="toggleDrawer('right')" aria-label="Buka panel hasil analisis">
    Hasil Analisis
    <svg class="ml-[5px] inline align-middle" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
</button>

<div class="peta-wrapper mt-[60px] grid h-[calc(100vh-60px)] grid-cols-1 grid-rows-[1fr] md:grid-cols-[220px_1fr_260px] lg:grid-cols-[260px_1fr_300px] [&_.leaflet-control-zoom]:!overflow-hidden [&_.leaflet-control-zoom]:!rounded-[10px] [&_.leaflet-control-zoom]:!border-0 [&_.leaflet-control-zoom]:!shadow-[0_4px_16px_rgba(0,0,0,0.08),0_1px_4px_rgba(0,0,0,0.04)] [&_.leaflet-control-zoom]:!mb-20 md:[&_.leaflet-control-zoom]:!mb-2.5 [&_.leaflet-control-zoom_a]:!text-[16px] [&_.leaflet-control-zoom_a]:!leading-[30px] [&_.leaflet-popup-content-wrapper]:!overflow-hidden [&_.leaflet-popup-content-wrapper]:!rounded-[14px] [&_.leaflet-popup-content-wrapper]:!border [&_.leaflet-popup-content-wrapper]:!border-[#e4e3ea] [&_.leaflet-popup-content-wrapper]:!p-0 [&_.leaflet-popup-content-wrapper]:!shadow-[0_8px_32px_rgba(0,0,0,0.1),0_2px_8px_rgba(0,0,0,0.06)] [&_.leaflet-popup-content]:!m-0 [&_.leaflet-popup-content]:!w-auto [&_.leaflet-popup-tip-container]:!hidden [&_.leaflet-popup-close-button]:!right-2.5 [&_.leaflet-popup-close-button]:!top-2 [&_.leaflet-popup-close-button]:!h-5 [&_.leaflet-popup-close-button]:!w-5 [&_.leaflet-popup-close-button]:!text-[16px] [&_.leaflet-popup-close-button]:!leading-5 [&_.leaflet-popup-close-button]:!text-[#a8a7b8] [&_.lf-popup]:w-[180px] [&_.lf-popup]:break-words [&_.lf-popup]:p-[10px_12px] [&_.lf-popup]:font-['Poppins'] [&_.lf-popup]:text-[#18172b] [&_.lf-popup_b]:mb-[3px] [&_.lf-popup_b]:block [&_.lf-popup_b]:text-[0.75rem] [&_.lf-popup_b]:font-medium [&_.lf-popup_b]:leading-[1.35] [&_.lf-popup_small]:block [&_.lf-popup_small]:text-[0.67rem] [&_.lf-popup_small]:leading-[1.4] [&_.lf-popup_small]:text-[#a8a7b8] [&_.kw-popup]:w-[240px] [&_.kw-popup]:font-['Poppins'] [&_.kw-popup]:text-[#18172b] [&_.kw-popup-head]:border-b [&_.kw-popup-head]:border-[#e4e3ea] [&_.kw-popup-head]:bg-[#fafafa] [&_.kw-popup-head]:px-[13px] [&_.kw-popup-head]:pb-2.5 [&_.kw-popup-head]:pt-[11px] [&_.kw-popup-name]:mb-0.5 [&_.kw-popup-name]:pr-4 [&_.kw-popup-name]:text-[0.8rem] [&_.kw-popup-name]:font-medium [&_.kw-popup-name]:leading-[1.3] [&_.kw-popup-name]:text-[#18172b] [&_.kw-popup-lokasi]:flex [&_.kw-popup-lokasi]:items-center [&_.kw-popup-lokasi]:gap-[3px] [&_.kw-popup-lokasi]:text-[0.66rem] [&_.kw-popup-lokasi]:text-[#6b6a7d] [&_.kw-popup-body]:flex [&_.kw-popup-body]:flex-col [&_.kw-popup-body]:gap-2 [&_.kw-popup-body]:bg-white [&_.kw-popup-body]:p-[10px_13px] [&_.kw-popup-badge]:inline-flex [&_.kw-popup-badge]:items-center [&_.kw-popup-badge]:gap-1 [&_.kw-popup-badge]:rounded-full [&_.kw-popup-badge]:px-[9px] [&_.kw-popup-badge]:py-[3px] [&_.kw-popup-badge]:text-[0.64rem] [&_.kw-popup-badge]:font-normal [&_.kw-popup-badge.green]:bg-[#dcfce7] [&_.kw-popup-badge.green]:text-[#16a34a] [&_.kw-popup-badge.red]:bg-[#fee2e2] [&_.kw-popup-badge.red]:text-[#dc2626] [&_.kw-popup-meta]:grid [&_.kw-popup-meta]:grid-cols-2 [&_.kw-popup-meta]:gap-[5px] [&_.kw-popup-meta-item]:rounded-md [&_.kw-popup-meta-item]:bg-[#f4f3f8] [&_.kw-popup-meta-item]:px-2 [&_.kw-popup-meta-item]:py-1.5 [&_.kw-popup-meta-key]:mb-px [&_.kw-popup-meta-key]:text-[0.56rem] [&_.kw-popup-meta-key]:font-normal [&_.kw-popup-meta-key]:text-[#a8a7b8] [&_.kw-popup-meta-val]:text-[0.7rem] [&_.kw-popup-meta-val]:font-normal [&_.kw-popup-meta-val]:text-[#18172b] [&_.kw-popup-akses-title]:mb-1 [&_.kw-popup-akses-title]:text-[0.6rem] [&_.kw-popup-akses-title]:font-normal [&_.kw-popup-akses-title]:text-[#a8a7b8] [&_.kw-popup-akses-row]:flex [&_.kw-popup-akses-row]:items-center [&_.kw-popup-akses-row]:justify-between [&_.kw-popup-akses-row]:border-b [&_.kw-popup-akses-row]:border-[#e4e3ea] [&_.kw-popup-akses-row]:py-[5px] [&_.kw-popup-akses-row:last-child]:border-b-0 [&_.kw-popup-akses-row:last-child]:pb-0 [&_.kw-popup-akses-name]:text-[0.69rem] [&_.kw-popup-akses-name]:font-normal [&_.kw-popup-akses-name]:text-[#18172b] [&_.kw-popup-chip]:rounded-full [&_.kw-popup-chip]:px-[7px] [&_.kw-popup-chip]:py-0.5 [&_.kw-popup-chip]:text-[0.6rem] [&_.kw-popup-chip]:font-normal [&_.kw-popup-chip.ya]:bg-[#dcfce7] [&_.kw-popup-chip.ya]:text-[#16a34a] [&_.kw-popup-chip.not]:bg-[#fee2e2] [&_.kw-popup-chip.not]:text-[#dc2626] [&_.detail-name]:mb-0.5 [&_.detail-name]:text-[0.82rem] [&_.detail-name]:font-semibold [&_.detail-name]:leading-[1.3] [&_.detail-name]:text-[#18172b] [&_.detail-lokasi]:mb-2.5 [&_.detail-lokasi]:text-[0.68rem] [&_.detail-lokasi]:text-[#6b6a7d] [&_.detail-meta]:mb-2.5 [&_.detail-meta]:grid [&_.detail-meta]:grid-cols-2 [&_.detail-meta]:gap-1.5 [&_.detail-meta-item]:rounded-md [&_.detail-meta-item]:bg-[#f4f3f8] [&_.detail-meta-item]:px-[9px] [&_.detail-meta-item]:py-[7px] [&_.detail-meta-key]:mb-0.5 [&_.detail-meta-key]:text-[0.58rem] [&_.detail-meta-key]:font-normal [&_.detail-meta-key]:text-[#a8a7b8] [&_.detail-meta-val]:font-['Poppins'] [&_.detail-meta-val]:text-[0.73rem] [&_.detail-meta-val]:font-medium [&_.detail-meta-val]:text-[#18172b] [&_.detail-status-badge]:mb-2.5 [&_.detail-status-badge]:inline-flex [&_.detail-status-badge]:items-center [&_.detail-status-badge]:gap-1 [&_.detail-status-badge]:rounded-full [&_.detail-status-badge]:px-2.5 [&_.detail-status-badge]:py-[3px] [&_.detail-status-badge]:text-[0.67rem] [&_.detail-status-badge]:font-medium [&_.detail-status-badge.green]:bg-[#dcfce7] [&_.detail-status-badge.green]:text-[#16a34a] [&_.detail-status-badge.red]:bg-[#fee2e2] [&_.detail-status-badge.red]:text-[#dc2626] [&_.detail-status-badge_svg]:h-[11px] [&_.detail-status-badge_svg]:w-[11px] [&_.detail-status-badge_svg]:shrink-0 [&_.detail-status-badge_svg]:fill-none [&_.detail-status-badge_svg]:stroke-current [&_.detail-status-badge_svg]:stroke-[2.5] [&_.detail-status-badge_svg]:[stroke-linecap:round] [&_.detail-status-badge_svg]:[stroke-linejoin:round] [&_.detail-akses-title]:mb-1.5 [&_.detail-akses-title]:text-[0.62rem] [&_.detail-akses-title]:font-normal [&_.detail-akses-title]:text-[#a8a7b8] [&_.akses-row]:flex [&_.akses-row]:items-center [&_.akses-row]:justify-between [&_.akses-row]:border-b [&_.akses-row]:border-[#e4e3ea] [&_.akses-row]:py-1.5 [&_.akses-row:last-child]:border-b-0 [&_.akses-row:last-child]:pb-0 [&_.akses-row-left]:flex [&_.akses-row-left]:items-center [&_.akses-row-left]:gap-[7px] [&_.akses-name]:text-[0.71rem] [&_.akses-name]:font-normal [&_.akses-name]:text-[#18172b] [&_.akses-status-chip]:rounded-full [&_.akses-status-chip]:px-2 [&_.akses-status-chip]:py-0.5 [&_.akses-status-chip]:font-['Poppins'] [&_.akses-status-chip]:text-[0.62rem] [&_.akses-status-chip]:font-medium [&_.akses-status-chip.ya]:bg-[#dcfce7] [&_.akses-status-chip.ya]:text-[#16a34a] [&_.akses-status-chip.not]:bg-[#fee2e2] [&_.akses-status-chip.not]:text-[#dc2626]">
    
{{-- ══════════════════════════════════════════
         LEFT SIDEBAR
    ══════════════════════════════════════════ --}}
    <aside class="sidebar-left fixed bottom-0 left-0 top-[60px] z-[1100] flex w-[280px] max-w-[85vw] -translate-x-full flex-col overflow-y-auto overflow-x-hidden border-r border-[#e4e3ea] bg-[#fafafa] shadow-[4px_0_24px_rgba(0,0,0,0.12)] transition-transform duration-200 ease-in-out [&.drawer-open]:translate-x-0 [&::-webkit-scrollbar]:w-[3px] [&::-webkit-scrollbar-thumb]:rounded-sm [&::-webkit-scrollbar-thumb]:bg-[#d0cfd8] md:static md:z-auto md:w-auto md:max-w-none md:translate-x-0 md:shadow-none md:transition-none">
        <div class="sidebar-header shrink-0 border-b border-[#e4e3ea] px-3.5 pb-2.5 pt-3">
            <div class="sidebar-header-label mb-0.5 text-[0.62rem] font-normal tracking-[0.02em] text-[#a8a7b8]">Panel Kontrol</div>
            <div class="sidebar-header-title text-[0.82rem] font-medium leading-[1.3] text-[#18172b]">Parameter Analisis</div>
        </div>

        {{-- Radius Buffer --}}
        @php $reqRadius = request('radius', ''); @endphp
        <div class="ctrl-section collapsible border-b border-[#e4e3ea] p-0 last:border-b-0">
            <div class="ctrl-section-head {{ ($hasApplied && $reqRadius) ? 'open' : '' }} flex cursor-pointer select-none items-center justify-between border-b border-[#e4e3ea] px-3.5 py-2.5 transition-colors duration-[180ms] hover:bg-[#f4f3f8] [&_.ctrl-label]:mb-0 [&.open_.ctrl-chevron]:rotate-180" id="head-radius" onclick="toggleSection('radius')">
                <div class="ctrl-label mb-2 flex items-center gap-[5px] text-[0.68rem] font-normal tracking-[0.01em] text-[#6b6a7d] [&_svg]:h-[11px] [&_svg]:w-[11px] [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-[#3b5bdb] [&_svg]:stroke-2 [&_svg]:[stroke-linecap:round] [&_svg]:[stroke-linejoin:round]">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="3"/></svg>
                    Radius Buffer
                    @if($hasApplied && $reqRadius)
                        <span class="radius-badge rounded-full bg-[rgba(59,91,219,0.1)] px-1.5 py-px font-['Poppins'] text-[0.58rem] font-semibold text-[#3b5bdb]">{{ $reqRadius }} km</span>
                    @endif
                </div>
                <svg class="ctrl-chevron h-3.5 w-3.5 shrink-0 fill-none stroke-[#a8a7b8] stroke-2 transition-transform duration-[220ms] [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="ctrl-section-body {{ ($hasApplied && $reqRadius) ? 'open' : '' }} max-h-0 overflow-hidden px-3.5 py-0 transition-[max-height,padding] duration-200 ease-in-out [&.open]:max-h-[400px] [&.open]:px-3.5 [&.open]:py-2.5" id="body-radius">
                <div class="radius-group flex flex-col gap-1" id="radiusGroup">
                    @foreach (['1' => '1 km', '3' => '3 km', '5' => '5 km'] as $val => $label)
                    @php $valStr = (string) $val; @endphp
                    <label class="radius-option {{ ($hasApplied && $reqRadius === $valStr) ? 'active' : '' }} relative flex cursor-pointer items-center gap-2 rounded-[10px] border-[1.5px] border-[#e4e3ea] bg-white px-2.5 py-1.5 transition-all duration-[180ms] hover:border-[#3b5bdb] hover:bg-[#e8edff] [&.active]:border-[#3b5bdb] [&.active]:bg-[#e8edff] [&.active]:shadow-[0_0_0_3px_rgba(59,91,219,0.08)] [&.active_.radius-dot]:border-[#3b5bdb] [&.active_.radius-dot]:bg-[#3b5bdb] [&.active_.radius-dot]:shadow-[inset_0_0_0_2px_#fff]" data-radius="{{ $valStr }}">
                        <input class="hidden" type="radio" name="radius" value="{{ $valStr }}" {{ ($hasApplied && $reqRadius === $valStr) ? 'checked' : '' }}>
                        <div class="radius-dot relative h-3 w-3 shrink-0 rounded-full border-2 border-[#d0cfd8] transition-all duration-[180ms]"></div>
                        <span class="radius-option-text flex-1 text-[0.73rem] font-medium text-[#18172b]">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Infrastruktur --}}
        <div class="ctrl-section collapsible border-b border-[#e4e3ea] p-0 last:border-b-0">
            <div class="ctrl-section-head {{ ($hasApplied && count($infrastruktur)) ? 'open' : '' }} flex cursor-pointer select-none items-center justify-between border-b border-[#e4e3ea] px-3.5 py-2.5 transition-colors duration-[180ms] hover:bg-[#f4f3f8] [&_.ctrl-label]:mb-0 [&.open_.ctrl-chevron]:rotate-180" id="head-infra" onclick="toggleSection('infra')">
                <div class="ctrl-label mb-2 flex items-center gap-[5px] text-[0.68rem] font-normal tracking-[0.01em] text-[#6b6a7d] [&_svg]:h-[11px] [&_svg]:w-[11px] [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-[#3b5bdb] [&_svg]:stroke-2 [&_svg]:[stroke-linecap:round] [&_svg]:[stroke-linejoin:round]">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Infrastruktur
                    @if($hasApplied && count($infrastruktur))
                        <span class="radius-badge rounded-full bg-[rgba(59,91,219,0.1)] px-1.5 py-px font-['Poppins'] text-[0.58rem] font-semibold text-[#3b5bdb]">{{ count($infrastruktur) }} dipilih</span>
                    @endif
                </div>
                <svg class="ctrl-chevron h-3.5 w-3.5 shrink-0 fill-none stroke-[#a8a7b8] stroke-2 transition-transform duration-[220ms] [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="ctrl-section-body {{ ($hasApplied && count($infrastruktur)) ? 'open' : '' }} max-h-0 overflow-hidden px-3.5 py-0 transition-[max-height,padding] duration-200 ease-in-out [&.open]:max-h-[400px] [&.open]:px-3.5 [&.open]:py-2.5" id="body-infra">
                <div class="infra-group flex flex-col gap-1">
                    @php
                        $infraOptions = [
                            'jalan'     => ['label' => 'Jalan', 'colorClass' => 'bg-[#6b7280]'],
                            'pelabuhan' => ['label' => 'Pelabuhan', 'colorClass' => 'bg-[#0891b2]'],
                            'bandara'   => ['label' => 'Bandara', 'colorClass' => 'bg-[#7c3aed]'],
                        ];
                    @endphp
                    @foreach ($infraOptions as $val => $opt)
                    <label class="infra-item {{ ($hasApplied && in_array($val, $infrastruktur)) ? 'active' : '' }} flex cursor-pointer select-none items-center gap-2 rounded-[10px] border-[1.5px] border-[#e4e3ea] bg-white px-2.5 py-1.5 transition-all duration-[180ms] hover:border-[#3b5bdb] [&.active]:border-[#3b5bdb] [&.active]:bg-[#e8edff] [&.active_.infra-check]:border-[#3b5bdb] [&.active_.infra-check]:bg-[#3b5bdb] [&.active_.infra-check_svg]:block" data-infra="{{ $val }}">
                        <input class="hidden" type="checkbox" name="infrastruktur[]" value="{{ $val }}" {{ ($hasApplied && in_array($val, $infrastruktur)) ? 'checked' : '' }}>
                        <div class="infra-check flex h-3.5 w-3.5 shrink-0 items-center justify-center rounded-[3px] border-[1.5px] border-[#d0cfd8] bg-white transition-all duration-[180ms] [&_svg]:hidden [&_svg]:h-2 [&_svg]:w-2 [&_svg]:fill-none [&_svg]:stroke-white [&_svg]:stroke-[3] [&_svg]:[stroke-linecap:round] [&_svg]:[stroke-linejoin:round]">
                            <svg viewBox="0 0 8 8"><polyline points="1 4 3 6 7 2"/></svg>
                        </div>
                        <div class="infra-color h-[7px] w-[7px] shrink-0 rounded-sm {{ $opt['colorClass'] }}"></div>
                        <span class="infra-label flex-1 text-[0.73rem] font-medium text-[#18172b]">{{ $opt['label'] }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Status Filter --}}
        <div class="ctrl-section collapsible border-b border-[#e4e3ea] p-0 last:border-b-0">
            <div class="ctrl-section-head {{ ($hasApplied && $statusFilter) ? 'open' : '' }} flex cursor-pointer select-none items-center justify-between border-b border-[#e4e3ea] px-3.5 py-2.5 transition-colors duration-[180ms] hover:bg-[#f4f3f8] [&_.ctrl-label]:mb-0 [&.open_.ctrl-chevron]:rotate-180" id="head-status" onclick="toggleSection('status')">
                <div class="ctrl-label mb-2 flex items-center gap-[5px] text-[0.68rem] font-normal tracking-[0.01em] text-[#6b6a7d] [&_svg]:h-[11px] [&_svg]:w-[11px] [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-[#3b5bdb] [&_svg]:stroke-2 [&_svg]:[stroke-linecap:round] [&_svg]:[stroke-linejoin:round]">
                    <svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                    Filter Status
                    @if($hasApplied && $statusFilter === 'terjangkau')
                        <span class="radius-badge rounded-full bg-[#dcfce7] px-1.5 py-px font-['Poppins'] text-[0.58rem] font-semibold text-[#16a34a]">Terjangkau</span>
                    @elseif($hasApplied && $statusFilter === 'tidak_terjangkau')
                        <span class="radius-badge rounded-full bg-[#fee2e2] px-1.5 py-px font-['Poppins'] text-[0.58rem] font-semibold text-[#dc2626]">Tidak Terjangkau</span>
                    @elseif($hasApplied && $statusFilter === 'semua')
                        <span class="radius-badge rounded-full bg-[rgba(59,91,219,0.1)] px-1.5 py-px font-['Poppins'] text-[0.58rem] font-semibold text-[#3b5bdb]">Semua</span>
                    @endif
                </div>
                <svg class="ctrl-chevron h-3.5 w-3.5 shrink-0 fill-none stroke-[#a8a7b8] stroke-2 transition-transform duration-[220ms] [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="ctrl-section-body {{ ($hasApplied && $statusFilter) ? 'open' : '' }} max-h-0 overflow-hidden px-3.5 py-0 transition-[max-height,padding] duration-200 ease-in-out [&.open]:max-h-[400px] [&.open]:px-3.5 [&.open]:py-2.5" id="body-status">
                <div class="status-group flex flex-col gap-1">
                    <div class="status-btn {{ ($hasApplied && $statusFilter === 'semua') ? 'active-all' : '' }} flex cursor-pointer select-none items-center gap-[7px] rounded-[10px] border-[1.5px] border-[#e4e3ea] bg-white px-2.5 py-1.5 text-[0.73rem] font-medium text-[#6b6a7d] transition-all duration-[180ms] hover:border-[#d0cfd8] [&.active-all]:border-[#3b5bdb] [&.active-all]:bg-[#e8edff] [&.active-all]:text-[#3b5bdb] [&.active-green]:border-[#16a34a] [&.active-green]:bg-[#dcfce7] [&.active-green]:text-[#16a34a] [&.active-red]:border-[#dc2626] [&.active-red]:bg-[#fee2e2] [&.active-red]:text-[#dc2626]" data-status="semua">
                        <div class="status-dot h-2 w-2 shrink-0 rounded-full bg-[#3b5bdb]"></div>
                        Semua Kawasan
                    </div>
                    <div class="status-btn {{ ($hasApplied && $statusFilter === 'terjangkau') ? 'active-green' : '' }} flex cursor-pointer select-none items-center gap-[7px] rounded-[10px] border-[1.5px] border-[#e4e3ea] bg-white px-2.5 py-1.5 text-[0.73rem] font-medium text-[#6b6a7d] transition-all duration-[180ms] hover:border-[#d0cfd8] [&.active-all]:border-[#3b5bdb] [&.active-all]:bg-[#e8edff] [&.active-all]:text-[#3b5bdb] [&.active-green]:border-[#16a34a] [&.active-green]:bg-[#dcfce7] [&.active-green]:text-[#16a34a] [&.active-red]:border-[#dc2626] [&.active-red]:bg-[#fee2e2] [&.active-red]:text-[#dc2626]" data-status="terjangkau">
                        <div class="status-dot h-2 w-2 shrink-0 rounded-full bg-[#16a34a]"></div>
                        Terjangkau
                    </div>
                    <div class="status-btn {{ ($hasApplied && $statusFilter === 'tidak_terjangkau') ? 'active-red' : '' }} flex cursor-pointer select-none items-center gap-[7px] rounded-[10px] border-[1.5px] border-[#e4e3ea] bg-white px-2.5 py-1.5 text-[0.73rem] font-medium text-[#6b6a7d] transition-all duration-[180ms] hover:border-[#d0cfd8] [&.active-all]:border-[#3b5bdb] [&.active-all]:bg-[#e8edff] [&.active-all]:text-[#3b5bdb] [&.active-green]:border-[#16a34a] [&.active-green]:bg-[#dcfce7] [&.active-green]:text-[#16a34a] [&.active-red]:border-[#dc2626] [&.active-red]:bg-[#fee2e2] [&.active-red]:text-[#dc2626]" data-status="tidak_terjangkau">
                        <div class="status-dot h-2 w-2 shrink-0 rounded-full bg-[#dc2626]"></div>
                        Tidak Terjangkau
                    </div>
                </div>
            </div>
        </div>

        {{-- Layer Kontrol --}}
        <div class="ctrl-section border-b border-[#e4e3ea] px-3.5 py-2.5 last:border-b-0">
            <div class="ctrl-label mb-2 flex items-center gap-[5px] text-[0.68rem] font-normal tracking-[0.01em] text-[#6b6a7d] [&_svg]:h-[11px] [&_svg]:w-[11px] [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-[#3b5bdb] [&_svg]:stroke-2 [&_svg]:[stroke-linecap:round] [&_svg]:[stroke-linejoin:round]">
                <svg viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
                Tampilkan Layer
            </div>
            <div class="layer-group flex flex-col gap-1">
                <div class="layer-item flex cursor-pointer items-center gap-2.5 rounded-md px-2.5 py-1.5 transition-colors duration-[180ms] hover:bg-[#f4f3f8] [&_input]:h-3.5 [&_input]:w-3.5 [&_input]:shrink-0 [&_input]:cursor-pointer [&_input]:accent-[#3b5bdb] [&_label]:cursor-pointer [&_label]:select-none [&_label]:text-[0.71rem] [&_label]:text-[#6b6a7d]"><input type="checkbox" id="layer-kawasan" checked><label for="layer-kawasan">Kawasan Industri</label></div>
                <div class="layer-item flex cursor-pointer items-center gap-2.5 rounded-md px-2.5 py-1.5 transition-colors duration-[180ms] hover:bg-[#f4f3f8] [&_input]:h-3.5 [&_input]:w-3.5 [&_input]:shrink-0 [&_input]:cursor-pointer [&_input]:accent-[#3b5bdb] [&_label]:cursor-pointer [&_label]:select-none [&_label]:text-[0.71rem] [&_label]:text-[#6b6a7d]"><input type="checkbox" id="layer-buffer" checked><label for="layer-buffer">Buffer Analisis</label></div>
                <div class="layer-item flex cursor-pointer items-center gap-2.5 rounded-md px-2.5 py-1.5 transition-colors duration-[180ms] hover:bg-[#f4f3f8] [&_input]:h-3.5 [&_input]:w-3.5 [&_input]:shrink-0 [&_input]:cursor-pointer [&_input]:accent-[#3b5bdb] [&_label]:cursor-pointer [&_label]:select-none [&_label]:text-[0.71rem] [&_label]:text-[#6b6a7d]"><input type="checkbox" id="layer-jalan" checked><label for="layer-jalan">Jalan</label></div>
                <div class="layer-item flex cursor-pointer items-center gap-2.5 rounded-md px-2.5 py-1.5 transition-colors duration-[180ms] hover:bg-[#f4f3f8] [&_input]:h-3.5 [&_input]:w-3.5 [&_input]:shrink-0 [&_input]:cursor-pointer [&_input]:accent-[#3b5bdb] [&_label]:cursor-pointer [&_label]:select-none [&_label]:text-[0.71rem] [&_label]:text-[#6b6a7d]"><input type="checkbox" id="layer-pelabuhan" checked><label for="layer-pelabuhan">Pelabuhan</label></div>
                <div class="layer-item flex cursor-pointer items-center gap-2.5 rounded-md px-2.5 py-1.5 transition-colors duration-[180ms] hover:bg-[#f4f3f8] [&_input]:h-3.5 [&_input]:w-3.5 [&_input]:shrink-0 [&_input]:cursor-pointer [&_input]:accent-[#3b5bdb] [&_label]:cursor-pointer [&_label]:select-none [&_label]:text-[0.71rem] [&_label]:text-[#6b6a7d]"><input type="checkbox" id="layer-bandara" checked><label for="layer-bandara">Bandara</label></div>
                <div class="layer-item flex cursor-pointer items-center gap-2.5 rounded-md px-2.5 py-1.5 transition-colors duration-[180ms] hover:bg-[#f4f3f8] [&_input]:h-3.5 [&_input]:w-3.5 [&_input]:shrink-0 [&_input]:cursor-pointer [&_input]:accent-[#3b5bdb] [&_label]:cursor-pointer [&_label]:select-none [&_label]:text-[0.71rem] [&_label]:text-[#6b6a7d]"><input type="checkbox" id="layer-wilayah" checked><label for="layer-wilayah">Wilayah Administrasi</label></div>
            </div>
        </div>

        {{-- Hidden input status --}}
        <input type="hidden" id="hiddenStatus" value="{{ $statusFilter }}">

        <div class="apply-btn-group mx-3.5 my-2.5 flex flex-wrap gap-2">
            <button class="reset-btn flex min-w-[84px] flex-1 cursor-pointer items-center justify-center gap-1.5 rounded-[10px] border-[1.5px] border-[#e4e3ea] bg-white p-2 font-['Poppins'] text-[0.75rem] font-semibold text-[#6b6a7d] transition duration-[180ms] hover:border-[#d0cfd8] hover:bg-[#f4f3f8] active:scale-[0.98] [&_svg]:h-3.5 [&_svg]:w-3.5 [&_svg]:fill-none [&_svg]:stroke-[#6b6a7d] [&_svg]:stroke-[2.5] [&_svg]:[stroke-linecap:round] [&_svg]:[stroke-linejoin:round]" id="resetBtn" type="button" aria-label="Kosongkan pilihan parameter">
                <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-9.36L1 10"/></svg>
                Reset
            </button>
            <button class="apply-btn flex min-w-[140px] flex-[2] cursor-pointer items-center justify-center gap-1.5 rounded-[10px] border-0 bg-[#3b5bdb] p-2 font-['Poppins'] text-[0.75rem] font-semibold text-white transition duration-[180ms] hover:bg-[#2f4ac4] active:scale-[0.98] [&_svg]:h-3.5 [&_svg]:w-3.5 [&_svg]:fill-none [&_svg]:stroke-white [&_svg]:stroke-[2.5] [&_svg]:[stroke-linecap:round] [&_svg]:[stroke-linejoin:round]" id="applyBtn" type="button">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Terapkan Analisis
            </button>
        </div>

    </aside>

    {{-- ══════════════════════════════════════════
         CENTER MAP
    ══════════════════════════════════════════ --}}
    <div class="map-area relative overflow-hidden">
        <div id="map" class="h-full w-full"></div>

        {{-- Cara Menggunakan Peta – floating button --}}
        <button onclick="document.getElementById('modalCaraPenggunaan').classList.remove('hidden')" class="absolute right-3.5 top-3.5 z-[500] flex items-center gap-1.5 rounded-full bg-white/95 px-3 py-1.5 font-['Poppins'] text-[0.68rem] font-medium text-[#6b6a7d] shadow-[0_4px_16px_rgba(0,0,0,0.08),0_1px_4px_rgba(0,0,0,0.04)] backdrop-blur-md transition duration-[180ms] hover:bg-[#e8edff] hover:text-[#3b5bdb] active:scale-95 [&_svg]:h-3.5 [&_svg]:w-3.5 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-2 [&_svg]:[stroke-linecap:round] [&_svg]:[stroke-linejoin:round]">
            <svg viewBox="0 0 24 24" class="!stroke-[#f97316]"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            Cara Menggunakan Peta
        </button>



        <div class="map-legend absolute bottom-32 left-3.5 z-[500] min-w-[130px] md:min-w-[170px] md:bottom-6 rounded-[8px] md:rounded-[10px] bg-white/95 px-2.5 py-2 md:px-3.5 md:py-3 shadow-[0_4px_16px_rgba(0,0,0,0.08),0_1px_4px_rgba(0,0,0,0.04)] backdrop-blur-md">
            <div class="legend-title mb-[6px] md:mb-[9px] text-[0.58rem] md:text-[0.68rem] font-normal tracking-[0.02em] text-[#a8a7b8]">Legenda</div>
            <div class="legend-row mb-[4px] md:mb-[5px] flex items-center gap-[6px] md:gap-[9px] last:mb-0 [&_span]:text-[0.6rem] md:[&_span]:text-[0.71rem] [&_span]:text-[#6b6a7d]">
                <div class="ld h-[9px] w-[9px] md:h-[11px] md:w-[11px] shrink-0 rounded-full bg-[#22c55e]"></div>
                <span>Kawasan – Terjangkau</span>
            </div>
            <div class="legend-row mb-[4px] md:mb-[5px] flex items-center gap-[6px] md:gap-[9px] last:mb-0 [&_span]:text-[0.6rem] md:[&_span]:text-[0.71rem] [&_span]:text-[#6b6a7d]">
                <div class="ld h-[9px] w-[9px] md:h-[11px] md:w-[11px] shrink-0 rounded-full bg-[#ef4444]"></div>
                <span>Kawasan – Tidak Terjangkau</span>
            </div>
            <div class="legend-sep my-[5px] md:my-[7px] h-px bg-[#e4e3ea]"></div>
            <div class="legend-row mb-[4px] md:mb-[5px] flex items-center gap-[6px] md:gap-[9px] last:mb-0 [&_span]:text-[0.6rem] md:[&_span]:text-[0.71rem] [&_span]:text-[#6b6a7d]">
                <div class="ls h-[9px] w-[9px] md:h-[11px] md:w-[11px] shrink-0 rotate-45 rounded-sm bg-[#7c3aed]"></div>
                <span>Bandara</span>
            </div>
            <div class="legend-row mb-[4px] md:mb-[5px] flex items-center gap-[6px] md:gap-[9px] last:mb-0 [&_span]:text-[0.6rem] md:[&_span]:text-[0.71rem] [&_span]:text-[#6b6a7d]">
                <div class="ls h-[9px] w-[9px] md:h-[11px] md:w-[11px] shrink-0 rounded-sm bg-[#0891b2]"></div>
                <span>Pelabuhan</span>
            </div>
            <div class="legend-row mb-[4px] md:mb-[5px] flex items-center gap-[6px] md:gap-[9px] last:mb-0 [&_span]:text-[0.6rem] md:[&_span]:text-[0.71rem] [&_span]:text-[#6b6a7d]">
                <div class="ll h-[2px] w-[18px] md:h-[2.5px] md:w-[22px] shrink-0 rounded-sm bg-[#6b7280]"></div>
                <span>Jalan</span>
            </div>
            <div class="legend-sep my-[5px] md:my-[7px] h-px bg-[#e4e3ea]"></div>
            <div class="legend-row mb-[4px] md:mb-[5px] flex items-center gap-[6px] md:gap-[9px] last:mb-0 [&_span]:text-[0.6rem] md:[&_span]:text-[0.71rem] [&_span]:text-[#6b6a7d]">
                <div class="h-0 w-[18px] md:w-[22px] shrink-0 border-t-2 border-dashed border-[#8b6eb4]"></div>
                <span>Buffer Aktif</span>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         RIGHT SIDEBAR – PANEL ANALISIS
    ══════════════════════════════════════════ --}}
    <aside class="sidebar-right fixed bottom-0 right-0 top-[60px] z-[1100] flex w-[300px] max-w-[90vw] translate-x-full flex-col overflow-hidden border-l border-[#e4e3ea] bg-[#fafafa] shadow-[-4px_0_24px_rgba(0,0,0,0.12)] transition-transform duration-200 ease-in-out [&.drawer-open]:translate-x-0 md:static md:z-auto md:w-auto md:max-w-none md:translate-x-0 md:shadow-none md:transition-none">
        <div class="panel-header shrink-0 border-b border-[#e4e3ea] px-3.5 pb-2.5 pt-3">
            <div class="panel-header-label mb-0.5 text-[0.62rem] font-normal tracking-[0.02em] text-[#a8a7b8]">Hasil Analisis</div>
            <div class="panel-header-title text-[0.82rem] font-medium text-[#18172b]" id="panelTitle">Ringkasan</div>
        </div>

        <div class="panel-body flex-1 overflow-y-auto overflow-x-hidden px-3 py-2.5 [&::-webkit-scrollbar]:w-[3px] [&::-webkit-scrollbar-thumb]:rounded-sm [&::-webkit-scrollbar-thumb]:bg-[#d0cfd8]">

            {{-- ── Mode 1: Summary ── --}}
            <div id="panel-summary" class="flex flex-col gap-2">

                @if(!$hasApplied)
                {{-- Belum ada filter yang diterapkan --}}
                <div class="flex flex-col items-center justify-center gap-2.5 px-4 py-8 text-center">
                    <svg class="h-9 w-9 fill-none stroke-[#a8a7b8] stroke-[1.5] [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                    </svg>
                    <div class="text-[0.75rem] font-medium text-[#6b6a7d]">Belum ada analisis</div>
                    <div class="text-[0.68rem] leading-[1.5] text-[#a8a7b8]">Pilih radius, infrastruktur, dan filter status, lalu klik <strong>Terapkan Analisis</strong>.</div>
                </div>
                @else

                <div class="summary-params rounded-[10px] border border-[rgba(59,91,219,0.2)] bg-[#e8edff] px-2.5 py-2">
                    <div class="summary-params-row mb-[3px] flex items-center justify-between text-[0.68rem] last:mb-0">
                        <span class="summary-params-key font-normal text-[#6b6a7d]">Radius aktif</span>
                        <span class="summary-params-val font-['Poppins'] text-[0.68rem] font-normal text-[#3b5bdb]" id="sumRadius">{{ $radius }} km</span>
                    </div>
                    <div class="summary-params-row mb-[3px] flex items-center justify-between text-[0.68rem] last:mb-0">
                        <span class="summary-params-key font-normal text-[#6b6a7d]">Infrastruktur</span>
                        <span class="summary-params-val font-['Poppins'] text-[0.68rem] font-normal text-[#3b5bdb]" id="sumInfra">{{ implode(', ', $infrastruktur) }}</span>
                    </div>
                </div>

                <div class="stat-grid grid grid-cols-2 gap-1.5">
                    <div class="stat-card full col-span-full rounded-[10px] border border-[#e4e3ea] bg-white px-2 py-2.5 text-center shadow-[0_1px_3px_rgba(0,0,0,0.06),0_1px_2px_rgba(0,0,0,0.04)]">
                        <div class="stat-number blue font-['Poppins'] text-[1.2rem] font-medium leading-none text-[#3b5bdb]">{{ $totalKawasan }}</div>
                        <div class="stat-label mt-[3px] text-[0.58rem] font-normal text-[#a8a7b8]">Total Kawasan Industri</div>
                    </div>
                    <div class="stat-card rounded-[10px] border border-[#e4e3ea] bg-white px-2 py-2.5 text-center shadow-[0_1px_3px_rgba(0,0,0,0.06),0_1px_2px_rgba(0,0,0,0.04)]">
                        <div class="stat-number green font-['Poppins'] text-[1.2rem] font-medium leading-none text-[#16a34a]" id="sumTerjangkau">{{ $totalTerjangkau }}</div>
                        <div class="stat-label mt-[3px] text-[0.58rem] font-normal text-[#a8a7b8]">Terjangkau</div>
                    </div>
                    <div class="stat-card rounded-[10px] border border-[#e4e3ea] bg-white px-2 py-2.5 text-center shadow-[0_1px_3px_rgba(0,0,0,0.06),0_1px_2px_rgba(0,0,0,0.04)]">
                        <div class="stat-number red font-['Poppins'] text-[1.2rem] font-medium leading-none text-[#dc2626]" id="sumTidak">{{ $totalTidakTerjangkau }}</div>
                        <div class="stat-label mt-[3px] text-[0.58rem] font-normal text-[#a8a7b8]">Tidak Terjangkau</div>
                    </div>
                </div>

                @php $pct = $totalKawasan > 0 ? round($totalTerjangkau / $totalKawasan * 100) : 0; @endphp
                <div class="pct-bar-wrap rounded-[10px] border border-[#e4e3ea] bg-white px-2.5 py-[9px] shadow-[0_1px_3px_rgba(0,0,0,0.06),0_1px_2px_rgba(0,0,0,0.04)]">
                    <div class="pct-bar-label mb-[5px] flex justify-between text-[0.65rem] font-normal text-[#6b6a7d] [&_span:last-child]:font-['Poppins'] [&_span:last-child]:text-[#16a34a]">
                        <span>Keterjangkauan</span>
                        <span id="sumPct">{{ $pct }}%</span>
                    </div>
                    <div class="pct-bar-track h-1.5 overflow-hidden rounded bg-[#fee2e2]">
                        <div class="pct-bar-fill h-full rounded bg-gradient-to-r from-[#22c55e] to-[#4ade80] transition-[width] duration-300" id="pctBar" data-pct="{{ $pct }}"></div>
                    </div>
                </div>

                <div class="section-label mb-[5px] px-0.5 text-[0.62rem] font-normal text-[#a8a7b8]">Kawasan Terjangkau</div>
                <div class="kawasan-list flex flex-col gap-1" id="kawasanList">
                    @foreach ($kawasan as $k)
                        @if ($k->terjangkau)
                        <div class="kawasan-list-item flex cursor-pointer items-center gap-2 rounded-[10px] border border-[#e4e3ea] bg-white px-2.5 py-[7px] shadow-[0_1px_3px_rgba(0,0,0,0.06),0_1px_2px_rgba(0,0,0,0.04)] transition duration-[180ms] hover:border-[#3b5bdb] hover:bg-[#e8edff]" data-id="{{ $k->id }}" onclick="openDetail({{ $k->id }})">
                            <div class="kawasan-list-dot h-[7px] w-[7px] shrink-0 rounded-full bg-[#22c55e]"></div>
                            <span class="kawasan-list-name flex-1 truncate text-[0.71rem] font-medium text-[#18172b]">{{ $k->nama }}</span>
                            <svg class="kawasan-list-arrow h-3 w-3 shrink-0 fill-none stroke-[#a8a7b8] stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </div>
                        @endif
                    @endforeach
                    @if (collect($kawasan)->where('terjangkau', true)->isEmpty())
                    <div class="py-4 text-center text-[0.77rem] text-[#a8a7b8]">
                        Tidak ada kawasan terjangkau<br>dengan parameter saat ini.
                    </div>
                    @endif
                </div>

                @if ($statusFilter !== 'terjangkau')
                <div class="section-label mb-[5px] mt-1 px-0.5 text-[0.62rem] font-normal text-[#a8a7b8]">Kawasan Tidak Terjangkau</div>
                <div class="kawasan-list flex flex-col gap-1" id="kawasanListTidak">
                    @foreach ($kawasan as $k)
                        @if (!$k->terjangkau)
                        <div class="kawasan-list-item flex cursor-pointer items-center gap-2 rounded-[10px] border border-[#e4e3ea] bg-white px-2.5 py-[7px] shadow-[0_1px_3px_rgba(0,0,0,0.06),0_1px_2px_rgba(0,0,0,0.04)] transition duration-[180ms] hover:border-[#3b5bdb] hover:bg-[#e8edff]" data-id="{{ $k->id }}" onclick="openDetail({{ $k->id }})">
                            <div class="kawasan-list-dot h-[7px] w-[7px] shrink-0 rounded-full bg-[#ef4444]"></div>
                            <span class="kawasan-list-name flex-1 truncate text-[0.71rem] font-medium text-[#18172b]">{{ $k->nama }}</span>
                            <svg class="kawasan-list-arrow h-3 w-3 shrink-0 fill-none stroke-[#a8a7b8] stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </div>
                        @endif
                    @endforeach
                    @if (collect($kawasan)->where('terjangkau', false)->isEmpty())
                    <div class="py-4 text-center text-[0.77rem] text-[#a8a7b8]">
                        Semua kawasan terjangkau.
                    </div>
                    @endif
                </div>
                @endif

                @endif {{-- end $hasApplied --}}

            </div>

            {{-- ── Mode 2: Detail Kawasan ── --}}
            <div id="panel-detail" class="hidden flex-col gap-2">
                <div class="detail-back mb-1 flex w-fit cursor-pointer items-center gap-[5px] rounded-md px-[7px] py-[5px] text-[0.68rem] font-medium text-[#3b5bdb] transition-colors duration-[180ms] hover:bg-[#e8edff] [&_svg]:h-3 [&_svg]:w-3 [&_svg]:fill-none [&_svg]:stroke-[#3b5bdb] [&_svg]:stroke-[2.5] [&_svg]:[stroke-linecap:round] [&_svg]:[stroke-linejoin:round]" onclick="closeDetail()">
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    Kembali ke ringkasan
                </div>
                <div class="detail-card rounded-[10px] border border-[#e4e3ea] bg-white p-3 shadow-[0_1px_3px_rgba(0,0,0,0.06),0_1px_2px_rgba(0,0,0,0.04)]" id="detailCard">
                    {{-- diisi oleh JS --}}
                </div>
            </div>

        </div>
    </aside>

</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
/* ══════════════════════════════════════════
   DATA DARI LARAVEL
══════════════════════════════════════════ */
const wilayah   = @json($wilayah);
const jalan     = @json($jalan);
const kawasan   = @json($kawasan);
const bandara   = @json($bandara);
const pelabuhan = @json($pelabuhan);
const buffer    = @json($buffer);
const activeRadius = '{{ $radius }}';
const activeInfra  = @json($infrastruktur);
const hasApplied = @json($hasApplied);

document.querySelectorAll('[data-pct]').forEach(el => {
    el.style.width = (el.dataset.pct || 0) + '%';
});

/* Buat lookup kawasan by id */
const kawasanMap = {};
kawasan.forEach(k => kawasanMap[k.id] = k);

/* Buat lookup buffer by id */
const bufferMap = {};
buffer.forEach(b => bufferMap[b.id] = b);

/* ══════════════════════════════════════════
   INISIALISASI MAP
══════════════════════════════════════════ */
const map = L.map('map', { zoomControl: false });

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

L.control.zoom({ position: 'bottomright' }).addTo(map);

map.setView([1.10, 104.02], 11);

setTimeout(() => map.invalidateSize(), 100);
window.addEventListener('resize', () => {
    setTimeout(() => map.invalidateSize(), 100);
});

/* ══════════════════════════════════════════
   WILAYAH ADMINISTRASI
══════════════════════════════════════════ */
const wilayahGroup = L.layerGroup().addTo(map);
wilayah.forEach(item => {
    if (!item.geom) return;
    L.geoJSON(JSON.parse(item.geom), {
        style: { color: '#f5ed0b', weight: 1.5, fillColor: '#f5ed0b', fillOpacity: 0.1, dashArray: null }
    }).addTo(wilayahGroup);
});

/* ══════════════════════════════════════════
   JALAN
══════════════════════════════════════════ */
const jalanGroup = L.layerGroup().addTo(map);
jalan.forEach(item => {
    L.geoJSON(JSON.parse(item.geom), {
        style: { color: '#6b7280', weight: 1.5, opacity: 0.6 }
    })
    .bindPopup(`<div class="lf-popup"><b>${item.nama_jalan ?? 'Jalan'}</b><small>${item.jenis_jalan ?? ''}</small></div>`)
    .addTo(jalanGroup);
});

/* ══════════════════════════════════════════
   BANDARA
══════════════════════════════════════════ */
const bandaraGroup = L.layerGroup().addTo(map);
let activeBandaraMarker = null;
let activePelabuhanMarker = null;

function makeBandaraIcon(active) {
    const borderClass = active ? 'border-[2.5px] border-[#facc15]' : 'border-2 border-white';
    return L.divIcon({
        html: `<div class="h-[13px] w-[13px] rotate-45 rounded-[3px] bg-[#7c3aed] shadow-[0_2px_6px_rgba(0,0,0,0.3)] ${borderClass}"></div>`,
        className: '', iconAnchor: [7, 7]
    });
}
function makePelabuhanIcon(active) {
    const borderClass = active ? 'border-[2.5px] border-[#facc15]' : 'border-2 border-white';
    return L.divIcon({
        html: `<div class="h-[13px] w-[13px] rounded-[3px] bg-[#0891b2] shadow-[0_2px_6px_rgba(0,0,0,0.3)] ${borderClass}"></div>`,
        className: '', iconAnchor: [7, 7]
    });
}

bandara.forEach(item => {
    const el = document.createElement('div');
    el.className = 'lf-popup';
    el.innerHTML = 
        '<b>' + item.nama + '</b>' +
        '<small>' + (item.alamat || '') + '</small>' +
        '<div class="mt-1 inline-flex w-fit rounded-full bg-[#e8edff] px-2 py-[2px] text-[0.62rem] font-medium text-[#3b5bdb]">Kecamatan: ' + (item.kecamatan || '–') + '</div>';

    let markerRef;
    const layer = L.geoJSON(JSON.parse(item.geom), {
        pointToLayer: (f, latlng) => {
            markerRef = L.marker(latlng, { icon: makeBandaraIcon(false) });
            return markerRef;
        }
    });
    layer.bindPopup(el, { maxWidth: 200 });
    layer.on('click', function(e) {
        L.DomEvent.stopPropagation(e);
        resetAllHighlights();
        activeBandaraMarker = markerRef;
        markerRef.setIcon(makeBandaraIcon(true));
    });
    layer.addTo(bandaraGroup);
});

/* ══════════════════════════════════════════
   PELABUHAN
══════════════════════════════════════════ */
const pelabuhanGroup = L.layerGroup().addTo(map);
pelabuhan.forEach(item => {
    const el = document.createElement('div');
    el.className = 'lf-popup';
    el.innerHTML =
        '<b>' + item.nama + '</b>' +
        '<small>' + (item.jenis || '') + (item.jenis && item.alamat ? ' · ' : '') + (item.alamat || '') + '</small>' +
        '<div class="mt-1 inline-flex w-fit rounded-full bg-[#e8edff] px-2 py-[2px] text-[0.62rem] font-medium text-[#3b5bdb]">Kecamatan: ' + (item.kecamatan || '–') + '</div>';

    let markerRef;
    const layer = L.geoJSON(JSON.parse(item.geom), {
        pointToLayer: (f, latlng) => {
            markerRef = L.marker(latlng, { icon: makePelabuhanIcon(false) });
            return markerRef;
        }
    });
    layer.bindPopup(el, { maxWidth: 200 });
    layer.on('click', function(e) {
        L.DomEvent.stopPropagation(e);
        resetAllHighlights();
        activePelabuhanMarker = markerRef;
        markerRef.setIcon(makePelabuhanIcon(true));
    });
    layer.addTo(pelabuhanGroup);
});

/* ══════════════════════════════════════════
   KAWASAN INDUSTRI – MARKER + BUFFER
══════════════════════════════════════════ */
const kawasanGroup = L.layerGroup().addTo(map);
const bufferGroup  = L.layerGroup().addTo(map);

let activeMarkerId = null;

/* Registry marker by kawasan id */
const markerRegistry = {};

/* Warna buffer sesuai radius */
const bufferStyles = {
    '1': { color: '#8b6eb4', fillColor: '#8b6eb4', fillOpacity: 0.1, weight: 1.5, dashArray: '5,5' },
    '3': { color: '#4a7fd4', fillColor: '#4a7fd4', fillOpacity: 0.1, weight: 1.5, dashArray: '5,5' },
    '5': { color: '#a0b840', fillColor: '#a0b840', fillOpacity: 0.1, weight: 1.5, dashArray: '5,5' },
};

function showBuffer(kawasanId) {
    bufferGroup.clearLayers();
    const buf = bufferMap[kawasanId];
    if (!buf) return;

    const styleKey = activeRadius;
    const bufKey   = `buffer_${activeRadius}km`;
    if (!buf[bufKey]) return;

    L.geoJSON(JSON.parse(buf[bufKey]), { style: bufferStyles[styleKey] }).addTo(bufferGroup);
}

/* Highlight / reset marker */
function highlightMarker(id) {
    /* Reset marker sebelumnya */
    if (activeMarkerId && markerRegistry[activeMarkerId]) {
        const prev = markerRegistry[activeMarkerId];
        prev.setStyle({ color: '#ffffff', weight: 2.5 });
    }

    if (!id) return;

    const marker = markerRegistry[id];
    if (!marker) return;

    marker.setStyle({ color: '#facc15', weight: 3.5 });
}

kawasan.forEach(item => {
    const geo = JSON.parse(item.geom);
    const isOk = item.terjangkau;

    const markerColor = !hasApplied
        ? '#64748b'                  // netral sebelum analisis
        : (isOk ? '#22c55e' : '#ef4444');

    const markerLayer = L.geoJSON(geo, {
        pointToLayer: function(feature, latlng) {
            const cm = L.circleMarker(latlng, {
                radius: 9,
                fillColor: markerColor,
                color: '#ffffff',
                weight: 2.5,
                fillOpacity: 1,
                className: 'kawasan-marker'
            });

            markerRegistry[item.id] = cm;
            return cm;
        }
    });

    markerLayer.on('click', function(e) {
        L.DomEvent.stopPropagation(e);

        resetAllHighlights();

        if (!hasApplied) {
            const el = document.createElement('div');

            el.className = 'kw-popup';

            el.innerHTML =
                '<div class="kw-popup-head">'
            +   '<div class="kw-popup-name">' + item.nama + '</div>'
            +   '<div class="kw-popup-lokasi">' + (item.lokasi || '–') + '</div>'
            +   '<div class="mt-1 inline-flex w-fit rounded-full bg-[#e8edff] px-2 py-[2px] text-[0.62rem] font-medium text-[#3b5bdb]">'
            +       'Kecamatan: ' + (item.kecamatan || '–') +
                '</div>'
            + '</div>'
            + '<div class="kw-popup-body">'
            +   '<span class="kw-popup-badge bg-[#f1f5f9] text-[#64748b]">'
            +     'Analisis belum diterapkan'
            +   '</span>'
            + '</div>';

            L.popup({
                offset: [0, -6],
                maxWidth: 250,
                closeButton: true,
                autoPan: true
            })
            .setContent(el)
            .setLatLng(e.latlng)
            .openOn(map);

            return;
        }

        activeMarkerId = item.id;
        highlightMarker(item.id);
        activeMarkerId = item.id;
        highlightMarker(item.id);

        const radiusKey = activeRadius;
        const jalanOk   = item['jalan_'   + radiusKey + 'km'];
        const pelabOk   = item['pelabuhan_' + radiusKey + 'km'];
        const bandaraOk = item['bandara_'  + radiusKey + 'km'];
        const isOk      = item.terjangkau;

        const badgeClass = isOk ? 'green' : 'red';
        const badgeText  = isOk ? 'Terjangkau' : 'Tidak Terjangkau';

        function aksesRow(label, val) {
            var chipClass = val ? 'ya' : 'not';
            var chipText  = val ? 'Ya' : 'Tidak';
            return '<div class="kw-popup-akses-row">'
                 +   '<span class="kw-popup-akses-name">' + label + '</span>'
                 +   '<span class="kw-popup-chip ' + chipClass + '">' + chipText + '</span>'
                 + '</div>';
        }

        var el = document.createElement('div');
        el.className = 'kw-popup';
        el.innerHTML =
            '<div class="kw-popup-head">'
          +   '<div class="kw-popup-name">' + item.nama + '</div>'
          +   '<div class="kw-popup-lokasi">' + (item.lokasi || '–') + '</div>'
          +   '<div class="mt-1 inline-flex w-fit rounded-full bg-[#e8edff] px-2 py-[2px] text-[0.62rem] font-medium text-[#3b5bdb]">'
          +       'Kecamatan: ' + (item.kecamatan || '–') +
              '</div>'
          + '</div>'
          + '<div class="kw-popup-body">'
          +   '<span class="kw-popup-badge ' + badgeClass + '">' + badgeText + '</span>'
          +   '<div class="kw-popup-meta">'
          +     '<div class="kw-popup-meta-item">'
          +       '<div class="kw-popup-meta-key">Luas Lahan</div>'
          +       '<div class="kw-popup-meta-val">' + (item.luas_lahan || '–') + '</div>'
          +     '</div>'
          +     '<div class="kw-popup-meta-item">'
          +       '<div class="kw-popup-meta-key">Tahun Beroperasi</div>'
          +       '<div class="kw-popup-meta-val">' + (item.tahun_beroperasi || '–') + '</div>'
          +     '</div>'
          +   '</div>'
          +   '<div>'
          +     '<div class="kw-popup-akses-title">Aksesibilitas – Radius ' + radiusKey + ' km</div>'
          +     aksesRow('Jalan',     jalanOk)
          +     aksesRow('Pelabuhan', pelabOk)
          +     aksesRow('Bandara',   bandaraOk)
          +   '</div>'
          + '</div>';

        L.popup({ offset: [0, -6], maxWidth: 250, closeButton: true, autoPan: true })
            .setContent(el)
            .setLatLng(e.latlng)
            .openOn(map);
    });

    markerLayer.addTo(kawasanGroup);
});

/* Reset semua highlight */
function resetAllHighlights() {
    highlightMarker(null);
    if (activeBandaraMarker)   { activeBandaraMarker.setIcon(makeBandaraIcon(false));     activeBandaraMarker   = null; }
    if (activePelabuhanMarker) { activePelabuhanMarker.setIcon(makePelabuhanIcon(false)); activePelabuhanMarker = null; }
}

/* Reset highlight saat popup ditutup (tombol X atau klik luar) */
map.on('popupclose', function() {
    resetAllHighlights();
    activeMarkerId = null;
});

/* Tutup buffer saat klik di luar */
map.on('click', function(e) {
    bufferGroup.clearLayers();
    activeMarkerId = null;
    closeDetail();
});

/* ══════════════════════════════════════════
   PANEL DETAIL
══════════════════════════════════════════ */
function openDetail(id) {
    const item = kawasanMap[id];
    if (!item) return;

    activeMarkerId = id;
    highlightMarker(id);
    showBuffer(id);

    const isOk = item.terjangkau;
    const radiusKey = activeRadius;

    /* Akses per infrastruktur untuk radius aktif */
    const jalanOk      = item[`jalan_${radiusKey}km`];
    const pelabOk      = item[`pelabuhan_${radiusKey}km`];
    const bandaraOk    = item[`bandara_${radiusKey}km`];

    const statusBadge = isOk
        ? `<div class="detail-status-badge green">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Terjangkau
           </div>`
        : `<div class="detail-status-badge red">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Tidak Terjangkau
           </div>`;

    const svgJalan   = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 17l3-10h12l3 10"/><path d="M6 17h12"/></svg>`;
    const svgPelab   = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0891b2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20h20M12 4v12M4 12l8 8 8-8"/><circle cx="12" cy="4" r="2"/></svg>`;
    const svgBandara = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19.5 2.5S18 2 16.5 3.5L13 7 4.8 5.2 3.4 6.6l7.1 3.7-2.3 2.3-3.2-.9L3.6 13 7 14l1 3.4 1.4 1.4.9-3.2 2.3-2.3 3.7 7.1 1.4-1.4z"/></svg>`;

    function aksesRow(iconSvg, label, val) {
        const chip = val
            ? `<span class="akses-status-chip ya">Ya</span>`
            : `<span class="akses-status-chip not">Tidak</span>`;
        return `<div class="akses-row">
            <div class="akses-row-left">
                ${iconSvg}
                <span class="akses-name">${label}</span>
            </div>
            ${chip}
        </div>`;
    }

    document.getElementById('detailCard').innerHTML = `
        <div class="detail-name">${item.nama}</div>
        <div class="detail-lokasi">
            <div class="flex items-start gap-1">
                <svg class="mt-[2px] h-3 w-3 shrink-0 fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
                <span>${item.lokasi ?? '–'}</span>
            </div>
            <div class="mt-1 inline-flex w-fit rounded-full bg-[#e8edff] px-2 py-[2px] text-[0.62rem] font-medium text-[#3b5bdb]">
                Kecamatan: ${item.kecamatan ?? '–'}
            </div>
        </div>
        ${statusBadge}
        <div class="detail-meta">
            <div class="detail-meta-item">
                <div class="detail-meta-key">Luas Lahan</div>
                <div class="detail-meta-val">${item.luas_lahan ?? '–'}</div>
            </div>
            <div class="detail-meta-item">
                <div class="detail-meta-key">Tahun Beroperasi</div>
                <div class="detail-meta-val">${item.tahun_beroperasi ?? '–'}</div>
            </div>
        </div>
        <div class="detail-akses-title">Aksesibilitas – Radius ${radiusKey} km</div>
        ${aksesRow(svgJalan,   'Jalan',     jalanOk)}
        ${aksesRow(svgPelab,   'Pelabuhan', pelabOk)}
        ${aksesRow(svgBandara, 'Bandara',   bandaraOk)}
    `;

    document.getElementById('panel-summary').style.display = 'none';
    document.getElementById('panel-detail').style.display  = 'flex';
    document.getElementById('panelTitle').textContent = 'Detail Kawasan';
}

function closeDetail() {
    document.getElementById('panel-summary').style.display = 'flex';
    document.getElementById('panel-detail').style.display  = 'none';
    document.getElementById('panelTitle').textContent = 'Ringkasan';
    highlightMarker(null);
    bufferGroup.clearLayers();
    activeMarkerId = null;
}

/* ══════════════════════════════════════════
   LAYER TOGGLES
══════════════════════════════════════════ */
function bindLayer(checkId, group) {
    document.getElementById(checkId).addEventListener('change', function() {
        this.checked ? map.addLayer(group) : map.removeLayer(group);
    });
}
bindLayer('layer-kawasan',   kawasanGroup);
bindLayer('layer-buffer',    bufferGroup);
bindLayer('layer-jalan',     jalanGroup);
bindLayer('layer-bandara',   bandaraGroup);
bindLayer('layer-pelabuhan', pelabuhanGroup);
bindLayer('layer-wilayah',   wilayahGroup);

/* ══════════════════════════════════════════
   COLLAPSIBLE SECTIONS
══════════════════════════════════════════ */
function toggleSection(id) {
    const head = document.getElementById('head-' + id);
    const body = document.getElementById('body-' + id);
    const isOpen = body.classList.contains('open');
    body.classList.toggle('open', !isOpen);
    head.classList.toggle('open', !isOpen);
}

/* ══════════════════════════════════════════
   LEFT SIDEBAR: INTERAKSI KONTROL
══════════════════════════════════════════ */

/* Radius radio */
document.querySelectorAll('#radiusGroup .radius-option').forEach(opt => {
    opt.addEventListener('click', function() {
        document.querySelectorAll('#radiusGroup .radius-option').forEach(o => o.classList.remove('active'));
        this.classList.add('active');
        this.querySelector('input[type="radio"]').checked = true;
    });
});

/* Infrastruktur checkbox */
document.querySelectorAll('.infra-item').forEach(item => {
    item.addEventListener('click', function() {
        const cb = this.querySelector('input[type="checkbox"]');
        cb.checked = !cb.checked;
        this.classList.toggle('active', cb.checked);
    });
});

/* Status filter */
const statusClassMap = {
    'semua':             'active-all',
    'terjangkau':        'active-green',
    'tidak_terjangkau':  'active-red',
};
document.querySelectorAll('.status-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.status-btn').forEach(b => {
            b.classList.remove('active-all', 'active-green', 'active-red');
        });
        const status = this.dataset.status;
        this.classList.add(statusClassMap[status]);
        document.getElementById('hiddenStatus').value = status;
    });
});

/* Apply button → validasi dulu, baru submit */
document.getElementById('applyBtn').addEventListener('click', function() {
    const radiusInput = document.querySelector('#radiusGroup input[type="radio"]:checked');
    const radius = radiusInput ? radiusInput.value : null;

    const infra = [];
    document.querySelectorAll('.infra-item input[type="checkbox"]:checked').forEach(function(cb) {
        infra.push(cb.value);
    });

    const status = document.getElementById('hiddenStatus').value;

    const missing = [];
    if (!radius)          missing.push('Radius buffer');
    if (infra.length === 0) missing.push('Infrastruktur');
    if (!status)          missing.push('Filter status');

    if (missing.length > 0) {
        document.getElementById('validasiMsg').textContent =
            missing.join(', ') + ' belum dipilih.';
        document.getElementById('modalValidasi').classList.remove('hidden');
        return;
    }

    const url = new URL(window.location.pathname, window.location.origin);
    url.searchParams.set('radius', radius);
    infra.forEach(function(i) { url.searchParams.append('infrastruktur[]', i); });
    url.searchParams.set('status', status);
    window.location.href = url.toString();
});

/* Reset button → kosongkan semua pilihan tanpa reload halaman */
document.getElementById('resetBtn').addEventListener('click', function() {
    // Radius
    document.querySelectorAll('#radiusGroup .radius-option').forEach(function(opt) {
        opt.classList.remove('active');
        opt.querySelector('input[type="radio"]').checked = false;
    });

    // Infrastruktur
    document.querySelectorAll('.infra-item').forEach(function(item) {
        item.classList.remove('active');
        item.querySelector('input[type="checkbox"]').checked = false;
    });

    // Status
    document.querySelectorAll('.status-btn').forEach(function(btn) {
        btn.classList.remove('active-all', 'active-green', 'active-red');
    });
    document.getElementById('hiddenStatus').value = '';

    // Tutup pesan validasi kalau sedang terbuka
    document.getElementById('modalValidasi').classList.add('hidden');
});

/* ══════════════════════════════════════════
   MOBILE DRAWER LOGIC
══════════════════════════════════════════ */
function toggleDrawer(side) {
    const overlay  = document.getElementById('drawerOverlay');
    const sidebarL = document.querySelector('.sidebar-left');
    const sidebarR = document.querySelector('.sidebar-right');

    if (side === 'left') {
        const isOpen = sidebarL.classList.contains('drawer-open');
        closeAllDrawers();
        if (!isOpen) {
            sidebarL.classList.add('drawer-open');
            overlay.classList.add('active');
        }
    } else {
        const isOpen = sidebarR.classList.contains('drawer-open');
        closeAllDrawers();
        if (!isOpen) {
            sidebarR.classList.add('drawer-open');
            overlay.classList.add('active');
        }
    }
}

function closeAllDrawers() {
    document.querySelector('.sidebar-left')?.classList.remove('drawer-open');
    document.querySelector('.sidebar-right')?.classList.remove('drawer-open');
    document.getElementById('drawerOverlay')?.classList.remove('active');
}

/* Tutup drawer saat map di-klik di mobile */
document.getElementById('map').addEventListener('click', function() {
    if (window.innerWidth < 768) closeAllDrawers();
});

/* Invalidate map size saat drawer tertutup (supaya tile tidak blank) */
document.getElementById('drawerOverlay').addEventListener('click', function() {
    setTimeout(() => map.invalidateSize(), 260);
});
</script>

@stack('scripts')

{{-- ══════════════════════════════════════════
     MODAL: VALIDASI PARAMETER
══════════════════════════════════════════ --}}
<div id="modalValidasi" class="hidden fixed inset-0 z-[2100] flex items-center justify-center p-4" onclick="if(event.target===this)document.getElementById('modalValidasi').classList.add('hidden')">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative z-10 w-full max-w-xs rounded-xl border border-[#e4e3ea] bg-white shadow-[0_8px_32px_rgba(0,0,0,0.12)] p-5 flex flex-col gap-3">
        <div class="flex items-center gap-2.5">
            <svg class="shrink-0" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span class="text-[0.82rem] font-semibold text-[#18172b]">Parameter tidak lengkap</span>
        </div>
        <p id="validasiMsg" class="text-[0.73rem] leading-[1.55] text-[#6b6a7d] -mt-1"></p>
        <button onclick="document.getElementById('modalValidasi').classList.add('hidden')" class="w-full rounded-[10px] bg-[#18172b] py-2 font-['Poppins'] text-[0.75rem] font-semibold text-white transition hover:bg-[#2d2b44] active:scale-[0.98]">
            Lengkapi Parameter
        </button>
    </div>
</div>

{{-- ══════════════════════════════════════════
     MODAL: CARA MENGGUNAKAN PETA
══════════════════════════════════════════ --}}
<div id="modalCaraPenggunaan" class="hidden fixed inset-0 z-[2000] flex items-center justify-center p-4" onclick="if(event.target===this)this.classList.add('hidden')">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

    {{-- Modal card --}}
    <div class="relative z-10 w-full max-w-md rounded-2xl border border-[#e4e3ea] bg-white shadow-[0_24px_64px_rgba(0,0,0,0.16),0_4px_16px_rgba(0,0,0,0.08)] flex flex-col max-h-[85vh]">

        {{-- Header --}}
        <div class="shrink-0 flex items-center justify-between border-b border-[#e4e3ea] px-5 py-4">
            <div>
                <div class="text-[0.6rem] font-normal tracking-[0.02em] text-[#a8a7b8] mb-0.5">Panduan</div>
                <div class="text-[0.88rem] font-semibold text-[#18172b] leading-none">Cara Menggunakan Peta</div>
            </div>
            <button onclick="document.getElementById('modalCaraPenggunaan').classList.add('hidden')" class="flex h-7 w-7 items-center justify-center rounded-full border border-[#e4e3ea] bg-[#fafafa] text-[#a8a7b8] transition hover:bg-[#f4f3f8] hover:text-[#18172b] active:scale-95">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Body scrollable --}}
        <div class="overflow-y-auto px-5 py-4 flex flex-col gap-3 [&::-webkit-scrollbar]:w-[3px] [&::-webkit-scrollbar-thumb]:rounded-sm [&::-webkit-scrollbar-thumb]:bg-[#d0cfd8]">
            @php
            $steps = [
                ['num' => '1', 'text' => 'Pilih <strong>radius buffer</strong> 1 km, 3 km, atau 5 km pada panel Parameter Analisis.'],
                ['num' => '2', 'text' => 'Pilih <strong>infrastruktur pendukung</strong> yang ingin dianalisis. Dapat memilih satu, dua, atau semua infrastruktur, yaitu jalan, pelabuhan, dan bandara.'],
                ['num' => '3', 'text' => 'Pilih <strong>filter status</strong> untuk menampilkan semua kawasan, kawasan terjangkau, atau kawasan tidak terjangkau.'],
                ['num' => '4', 'text' => 'Atur <strong>layer peta</strong> yang ingin ditampilkan, seperti kawasan industri, buffer analisis, jalan, pelabuhan, bandara, dan wilayah administrasi.'],
                ['num' => '5', 'text' => 'Klik tombol <strong>Terapkan Analisis</strong> untuk menampilkan hasil analisis pada peta.'],
                ['num' => '6', 'text' => 'Lihat hasil analisis dan detail informasi kawasan pada <strong>Panel Ringkasan</strong>. Klik marker kawasan industri untuk melihat radius buffer pada peta.'],
                ['num' => '7', 'text' => 'Marker <span class="inline-flex items-center gap-1"><span class="inline-block h-2 w-2 rounded-full bg-[#22c55e]"></span><strong class="text-[#16a34a]">hijau</strong></span> menunjukkan kawasan terjangkau, sedangkan marker <span class="inline-flex items-center gap-1"><span class="inline-block h-2 w-2 rounded-full bg-[#ef4444]"></span><strong class="text-[#dc2626]">merah</strong></span> menunjukkan kawasan tidak terjangkau.'],
            ];
            @endphp

            @foreach($steps as $step)
            <div class="flex gap-3 items-start">
                <div class="shrink-0 h-6 w-6 rounded-full bg-[rgba(59,91,219,0.1)] flex items-center justify-center text-[0.64rem] font-semibold text-[#3b5bdb] leading-none mt-px">{{ $step['num'] }}</div>
                <p class="text-[0.73rem] leading-[1.55] text-[#18172b] flex-1">{!! $step['text'] !!}</p>
            </div>
            @endforeach
        </div>

        {{-- Footer --}}
        <div class="shrink-0 border-t border-[#e4e3ea] px-5 py-3">
            <button onclick="document.getElementById('modalCaraPenggunaan').classList.add('hidden')" class="w-full rounded-[10px] bg-[#3b5bdb] py-2 font-['Poppins'] text-[0.75rem] font-semibold text-white transition hover:bg-[#2f4ac4] active:scale-[0.98]">
                Mengerti
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.getElementById('modalCaraPenggunaan').classList.add('hidden');
        tutupModalValidasi();
    }
});
</script>
</body>
</html>