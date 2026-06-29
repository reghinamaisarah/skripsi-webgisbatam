<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Data Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen overflow-x-hidden bg-[#f3f4f6] font-[Poppins] text-[13px] leading-[1.5] text-[#1f2937] antialiased min-[901px]:h-screen min-[901px]:overflow-hidden">

    @include('partials.navbaradmin')

    {{-- Mobile sidebar toggle --}}
    <div id="adminSidebarOverlay" class="pointer-events-none fixed inset-x-0 bottom-0 top-[56px] z-[190] bg-black/35 opacity-0 transition-opacity duration-200 min-[901px]:hidden"></div>

    <button
        type="button"
        id="adminSidebarToggle"
        class="fixed left-3 top-[82px] z-[180] hidden items-center gap-2 rounded-lg border border-[#e5e7eb] bg-white px-3 py-2 text-[0.76rem] font-semibold text-[#233d59] shadow-[0_4px_14px_rgba(15,23,42,0.08)] transition-colors duration-150 hover:bg-[#f8fafc] max-[900px]:inline-flex"
        aria-label="Buka menu admin"
        aria-expanded="false"
    >
        <svg class="h-4 w-4 fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24">
            <line x1="4" y1="7" x2="20" y2="7"/>
            <line x1="4" y1="12" x2="20" y2="12"/>
            <line x1="4" y1="17" x2="20" y2="17"/>
        </svg>
        Menu Admin
    </button>

    <div class="relative grid h-[calc(100vh-56px)] min-h-[calc(100vh-56px)] grid-cols-[250px_minmax(0,1fr)] max-[900px]:block max-[900px]:overflow-hidden">
        @include('partials.sidebaradmin')

        {{-- ============== MAIN ============== --}}
        <main class="h-full min-w-0 overflow-hidden px-6 py-5 max-[900px]:h-[calc(100vh-56px)] max-[900px]:overflow-y-auto max-[900px]:px-3 max-[900px]:pb-4 max-[900px]:pt-[4.75rem]">

            @if(session('success'))
                <div class="fixed bottom-6 right-6 z-[9999] flex w-[360px] max-[560px]:left-3 max-[560px]:right-3 max-[560px]:bottom-3 max-[560px]:w-auto translate-x-0 items-start gap-[14px] border-l-[5px] border-[#16a34a] bg-[#d1fae5] px-5 py-[18px] text-[#15803d] opacity-100 shadow-[0_10px_25px_rgba(0,0,0,0.08)] transition-all duration-300" id="toastSuccess">
                    <div class="shrink-0 text-[0.95rem] font-bold leading-none text-[#16a34a]">✓</div>

                    <div class="flex flex-col gap-0.5">
                        <div class="text-[0.78rem] font-semibold leading-tight">Berhasil</div>
                        <div class="text-[0.74rem] font-medium leading-snug">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif

            {{-- ===== TAB: KAWASAN ===== --}}
            <div id="tab-kawasan" class="tab-pane block">
                <div class="flex flex-col rounded-[10px] border border-[#e5e7eb] bg-white p-[1.1rem] shadow-[0_1px_2px_rgba(0,0,0,0.03)] h-[calc(100vh-100px)] max-[900px]:h-auto max-[900px]:min-h-0">
                    <div class="mb-[0.9rem] flex flex-wrap items-center justify-between gap-3 [&_h3]:text-[0.92rem] [&_h3]:font-semibold [&_h3]:tracking-[-0.005em] [&_h3]:text-[#1f2937]">
                        <h3>Data Kawasan Industri ({{ $totalKawasan }})</h3>
                        <div class="flex gap-[0.4rem]">
                            <button type="button" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-transparent bg-[#233d59] text-[#f5f3ee] hover:bg-[#0f1f3d]" onclick="openModal('modal-kawasan-create')">
                                <svg viewBox="0 0 24 24"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
                                Tambah
                            </button>
                        </div>
                    </div>

                    <div class="mb-3 flex">
                        <div class="flex min-w-[260px] max-[560px]:min-w-0 max-[560px]:w-full items-center gap-[0.45rem] rounded-[7px] border border-[#e5e7eb] bg-[#f9fafb] px-[0.65rem] py-[0.4rem] [&_svg]:h-[14px] [&_svg]:w-[14px] [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-[#6b7280] [&_svg]:stroke-[1.75] [&_input]:w-full [&_input]:border-0 [&_input]:bg-transparent [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none">
                            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                            <input type="text" placeholder="Cari data kawasan..." class="search-input" data-target="tbl-kawasan">
                        </div>
                    </div>

                    <div class="min-h-0 flex-1 overflow-x-auto overflow-y-auto">
                        <table id="tbl-kawasan" class="w-full min-w-[900px] border-separate border-spacing-0 text-[0.76rem] [&_thead_th]:sticky [&_thead_th]:top-0 [&_thead_th]:z-[100] [&_thead_th]:whitespace-nowrap [&_thead_th]:border-b [&_thead_th]:border-[#e5e7eb] [&_thead_th]:bg-[#f8fafc] [&_thead_th]:px-[0.9rem] [&_thead_th]:py-3 [&_thead_th]:text-left [&_thead_th]:text-[0.78rem] [&_thead_th]:font-semibold [&_thead_th]:text-[#374151] [&_td]:border-t [&_td]:border-[#f1f1f1] [&_td]:bg-white [&_td]:px-[0.8rem] [&_td]:py-[0.6rem] [&_td]:align-middle [&_td]:leading-[1.45] [&_td]:text-[#374151] [&_tbody_tr:hover_td]:bg-[#fafafa] [&_td:first-child]:w-12 [&_td:first-child]:text-center [&_th:first-child]:w-12 [&_th:first-child]:text-center">
                            <colgroup>
                                <col class="w-[4%]">
                                <col class="w-[12%]">
                                <col class="w-[16%]">
                                <col class="w-[10%]">
                                <col class="w-[8%]">
                                <col class="w-[16%]">
                                <col class="w-[25%]">
                                <col class="w-[5%]">
                                <col class="w-[5%]">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>No</th><th>Nama</th><th>Alamat</th><th>Kecamatan</th><th>Luas Lahan</th>
                                    <th>Infrastruktur</th><th>Fasilitas</th><th>Tahun</th><th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($kawasan as $k)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $k->nama }}</td>
                                    <td>{{ $k->lokasi }}</td>
                                    <td>{{ $k->wilayah->kecamatan ?? '-' }}</td>
                                    <td>{{ $k->luas_lahan }}</td>
                                    <td>{{ $k->infrastruktur }}</td>
                                    <td>{{ $k->fasilitas }}</td>
                                    <td>{{ $k->tahun_beroperasi }}</td>
                                    <td>
                                        <div class="flex items-center gap-[0.35rem]">
                                            <button type="button" class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-[#d1d5db] bg-white p-0 text-[0px] text-[#233d59] transition-colors duration-150 hover:bg-[#f3f4f6] [&_svg]:h-[15px] [&_svg]:w-[15px] [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75]" onclick='openEditKawasan(@json($k))'>
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
                                                        <path d="m15 5 4 4"/>
                                                    </svg>
                                                </button>
                                            <form action="{{ route('admin.kawasan.delete', $k->id) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="button" class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-[#fecaca] bg-white p-0 text-[0px] text-[#b91c1c] transition-colors duration-150 hover:bg-[#fee2e2] [&_svg]:h-[15px] [&_svg]:w-[15px] [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75]" onclick="openDeleteModal(this)">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
                                                        <path d="M3 6h18"/>
                                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="!px-6 !py-6 !text-center !text-[#6b7280]">Belum ada data kawasan.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===== TAB: INFRASTRUKTUR (with sub-tabs) ===== --}}
            <div id="tab-infrastruktur" class="tab-pane hidden">

                {{-- ── SUB-TAB: PELABUHAN ── --}}
                <div id="subtab-pelabuhan" class="subtab-pane block">
                    <div class="flex flex-col rounded-[10px] border border-[#e5e7eb] bg-white p-[1.1rem] shadow-[0_1px_2px_rgba(0,0,0,0.03)] h-auto">
                        <div class="mb-[0.9rem] flex flex-wrap items-center justify-between gap-3 [&_h3]:text-[0.92rem] [&_h3]:font-semibold [&_h3]:tracking-[-0.005em] [&_h3]:text-[#1f2937]">
                            <h3>Data Pelabuhan ({{ $totalPelabuhan }})</h3>
                            <div class="flex gap-[0.4rem]">
                                <button type="button" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-transparent bg-[#233d59] text-[#f5f3ee] hover:bg-[#0f1f3d]" onclick="openModal('modal-pelabuhan-create')">
                                    <svg viewBox="0 0 24 24"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
                                    Tambah
                                </button>
                            </div>
                        </div>
                        <div class="mb-3 flex">
                            <div class="flex min-w-[260px] max-[560px]:min-w-0 max-[560px]:w-full items-center gap-[0.45rem] rounded-[7px] border border-[#e5e7eb] bg-[#f9fafb] px-[0.65rem] py-[0.4rem] [&_svg]:h-[14px] [&_svg]:w-[14px] [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-[#6b7280] [&_svg]:stroke-[1.75] [&_input]:w-full [&_input]:border-0 [&_input]:bg-transparent [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none">
                                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                                <input type="text" placeholder="Cari data pelabuhan..." class="search-input" data-target="tbl-pelabuhan">
                            </div>
                        </div>
                        <div class="min-h-0 flex-1 overflow-x-auto overflow-y-auto">
                            <table id="tbl-pelabuhan" class="w-full min-w-[880px] border-separate border-spacing-0 text-[0.76rem] [&_thead_th]:sticky [&_thead_th]:top-0 [&_thead_th]:z-[100] [&_thead_th]:whitespace-nowrap [&_thead_th]:border-b [&_thead_th]:border-[#e5e7eb] [&_thead_th]:bg-[#f8fafc] [&_thead_th]:px-[0.9rem] [&_thead_th]:py-3 [&_thead_th]:text-left [&_thead_th]:text-[0.78rem] [&_thead_th]:font-semibold [&_thead_th]:text-[#374151] [&_td]:border-t [&_td]:border-[#f1f1f1] [&_td]:bg-white [&_td]:px-[0.8rem] [&_td]:py-[0.6rem] [&_td]:align-middle [&_td]:leading-[1.45] [&_td]:text-[#374151] [&_tbody_tr:hover_td]:bg-[#fafafa] [&_td:first-child]:w-12 [&_td:first-child]:text-center [&_th:first-child]:w-12 [&_th:first-child]:text-center">
                                <thead><tr><th>No</th><th>Nama</th><th>Alamat</th><th>Kecamatan</th><th>Jenis</th><th>Aksi</th></tr></thead>
                                <tbody>
                                @forelse($pelabuhan as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->nama }}</td>
                                        <td>{{ $p->alamat }}</td>
                                        <td>{{ $p->wilayah->kecamatan ?? '-' }}</td>
                                        <td>{{ $p->jenis }}</td>
                                        <td>
                                            <div class="flex items-center gap-[0.35rem]">
                                                <button type="button" class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-[#d1d5db] bg-white p-0 text-[0px] text-[#233d59] transition-colors duration-150 hover:bg-[#f3f4f6] [&_svg]:h-[15px] [&_svg]:w-[15px] [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75]" onclick='openEditPelabuhan(@json($p))'>
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
                                                        <path d="m15 5 4 4"/>
                                                    </svg>
                                                </button>
                                                <form action="{{ route('admin.pelabuhan.delete', $p->id) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-[#fecaca] bg-white p-0 text-[0px] text-[#b91c1c] transition-colors duration-150 hover:bg-[#fee2e2] [&_svg]:h-[15px] [&_svg]:w-[15px] [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75]" onclick="openDeleteModal(this)">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
                                                            <path d="M3 6h18"/>
                                                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="!px-6 !py-6 !text-center !text-[#6b7280]">Belum ada data pelabuhan.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- ── SUB-TAB: BANDARA ── --}}
                <div id="subtab-bandara" class="subtab-pane hidden">
                    <div class="flex flex-col rounded-[10px] border border-[#e5e7eb] bg-white p-[1.1rem] shadow-[0_1px_2px_rgba(0,0,0,0.03)] h-auto">
                        <div class="mb-[0.9rem] flex flex-wrap items-center justify-between gap-3 [&_h3]:text-[0.92rem] [&_h3]:font-semibold [&_h3]:tracking-[-0.005em] [&_h3]:text-[#1f2937]">
                            <h3>Data Bandara ({{ $totalBandara }})</h3>
                            <div class="flex gap-[0.4rem]">
                                <button type="button" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-transparent bg-[#233d59] text-[#f5f3ee] hover:bg-[#0f1f3d]" onclick="openModal('modal-bandara-create')">
                                    <svg viewBox="0 0 24 24"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
                                    Tambah
                                </button>
                            </div>
                        </div>
                        <div class="mb-3 flex">
                            <div class="flex min-w-[260px] max-[560px]:min-w-0 max-[560px]:w-full items-center gap-[0.45rem] rounded-[7px] border border-[#e5e7eb] bg-[#f9fafb] px-[0.65rem] py-[0.4rem] [&_svg]:h-[14px] [&_svg]:w-[14px] [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-[#6b7280] [&_svg]:stroke-[1.75] [&_input]:w-full [&_input]:border-0 [&_input]:bg-transparent [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none">
                                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                                <input type="text" placeholder="Cari data bandara..." class="search-input" data-target="tbl-bandara">
                            </div>
                        </div>
                        <div class="min-h-0 flex-1 overflow-x-auto overflow-y-auto">
                            <table id="tbl-bandara" class="w-full min-w-[880px] border-separate border-spacing-0 text-[0.76rem] [&_thead_th]:sticky [&_thead_th]:top-0 [&_thead_th]:z-[100] [&_thead_th]:whitespace-nowrap [&_thead_th]:border-b [&_thead_th]:border-[#e5e7eb] [&_thead_th]:bg-[#f8fafc] [&_thead_th]:px-[0.9rem] [&_thead_th]:py-3 [&_thead_th]:text-left [&_thead_th]:text-[0.78rem] [&_thead_th]:font-semibold [&_thead_th]:text-[#374151] [&_td]:border-t [&_td]:border-[#f1f1f1] [&_td]:bg-white [&_td]:px-[0.8rem] [&_td]:py-[0.6rem] [&_td]:align-middle [&_td]:leading-[1.45] [&_td]:text-[#374151] [&_tbody_tr:hover_td]:bg-[#fafafa] [&_td:first-child]:w-12 [&_td:first-child]:text-center [&_th:first-child]:w-12 [&_th:first-child]:text-center">
                                <thead><tr><th>No</th><th>Nama</th><th>Alamat</th><th>Kecamatan</th><th>Aksi</th></tr></thead>
                                <tbody>
                                @forelse($bandara as $b)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $b->nama }}</td>
                                        <td>{{ $b->alamat }}</td>
                                        <td>{{ $b->wilayah->kecamatan ?? '-' }}</td>
                                        <td>
                                            <div class="flex items-center gap-[0.35rem]">
                                                <button type="button" class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-[#d1d5db] bg-white p-0 text-[0px] text-[#233d59] transition-colors duration-150 hover:bg-[#f3f4f6] [&_svg]:h-[15px] [&_svg]:w-[15px] [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75]" onclick='openEditBandara(@json($b))'>
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
                                                        <path d="m15 5 4 4"/>
                                                    </svg>
                                                </button>
                                                <form action="{{ route('admin.bandara.delete', $b->id) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-[#fecaca] bg-white p-0 text-[0px] text-[#b91c1c] transition-colors duration-150 hover:bg-[#fee2e2] [&_svg]:h-[15px] [&_svg]:w-[15px] [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75]" onclick="openDeleteModal(this)">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
                                                            <path d="M3 6h18"/>
                                                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                        </svg>
                                                    </button>   
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="!px-6 !py-6 !text-center !text-[#6b7280]">Belum ada data bandara.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- ── SUB-TAB: JALAN ── --}}
                <div id="subtab-jalan" class="subtab-pane hidden">
                    <div class="flex flex-col rounded-[10px] border border-[#e5e7eb] bg-white p-[1.1rem] shadow-[0_1px_2px_rgba(0,0,0,0.03)] h-[calc(100vh-100px)] max-[900px]:h-auto max-[900px]:min-h-0">
                        <div class="mb-[0.9rem] flex flex-wrap items-center justify-between gap-3 [&_h3]:text-[0.92rem] [&_h3]:font-semibold [&_h3]:tracking-[-0.005em] [&_h3]:text-[#1f2937]">
                            <h3>Data Jalan ({{ $totalJalan }})</h3>
                        </div>
                        <div class="mb-3 flex">
                            <div class="flex min-w-[260px] max-[560px]:min-w-0 max-[560px]:w-full items-center gap-[0.45rem] rounded-[7px] border border-[#e5e7eb] bg-[#f9fafb] px-[0.65rem] py-[0.4rem] [&_svg]:h-[14px] [&_svg]:w-[14px] [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-[#6b7280] [&_svg]:stroke-[1.75] [&_input]:w-full [&_input]:border-0 [&_input]:bg-transparent [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none">
                                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                                <input type="text" placeholder="Cari data jalan..." class="search-input" data-target="tbl-jalan">
                            </div>
                        </div>
                        <div class="min-h-0 flex-1 overflow-x-auto overflow-y-auto">
                            <table id="tbl-jalan" class="w-full min-w-[880px] border-separate border-spacing-0 text-[0.76rem] [&_thead_th]:sticky [&_thead_th]:top-0 [&_thead_th]:z-[100] [&_thead_th]:whitespace-nowrap [&_thead_th]:border-b [&_thead_th]:border-[#e5e7eb] [&_thead_th]:bg-[#f8fafc] [&_thead_th]:px-[0.9rem] [&_thead_th]:py-3 [&_thead_th]:text-left [&_thead_th]:text-[0.78rem] [&_thead_th]:font-semibold [&_thead_th]:text-[#374151] [&_td]:border-t [&_td]:border-[#f1f1f1] [&_td]:bg-white [&_td]:px-[0.8rem] [&_td]:py-[0.6rem] [&_td]:align-middle [&_td]:leading-[1.45] [&_td]:text-[#374151] [&_tbody_tr:hover_td]:bg-[#fafafa] [&_td:first-child]:w-12 [&_td:first-child]:text-center [&_th:first-child]:w-12 [&_th:first-child]:text-center">
                                <thead><tr><th>No</th><th>Nama Jalan</th><th>Jenis Jalan</th><th>Aksi</th></tr></thead>
                                <tbody>
                                @forelse($jalan as $j)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $j->nama_jalan }}</td>
                                        <td>{{ $j->jenis_jalan }}</td>
                                        <td>
                                            <div class="flex items-center gap-[0.35rem]">
                                                <button type="button" class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-[#d1d5db] bg-white p-0 text-[0px] text-[#233d59] transition-colors duration-150 hover:bg-[#f3f4f6] [&_svg]:h-[15px] [&_svg]:w-[15px] [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75]" onclick='openEditJalan(@json($j))'>
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
                                                        <path d="m15 5 4 4"/>
                                                    </svg>
                                                </button>
                                                <form action="{{ route('admin.jalan.delete', $j->id) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-[#fecaca] bg-white p-0 text-[0px] text-[#b91c1c] transition-colors duration-150 hover:bg-[#fee2e2] [&_svg]:h-[15px] [&_svg]:w-[15px] [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75]" onclick="openDeleteModal(this)">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
                                                            <path d="M3 6h18"/>
                                                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="!px-6 !py-6 !text-center !text-[#6b7280]">Belum ada data jalan.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>{{-- /tab-infrastruktur --}}

            {{-- ===== TAB: PETA ===== --}}
            <div id="tab-peta" class="tab-pane hidden">
                <div class="flex flex-col rounded-[10px] border border-[#e5e7eb] bg-white p-[1.1rem] shadow-[0_1px_2px_rgba(0,0,0,0.03)] h-[calc(100vh-100px)] max-[900px]:h-auto max-[900px]:min-h-0 overflow-hidden p-0">
                    <div class="min-h-0 flex-1 [&_iframe]:block [&_iframe]:h-full [&_iframe]:w-full [&_iframe]:border-0">
                        <iframe id="peta-frame" data-src="{{ route('peta.index', ['embed' => 1]) }}" title="Peta WebGIS" loading="lazy"></iframe>
                    </div>
                </div>
            </div>

        </main>
    </div>

    {{-- ====================== MODALS ====================== --}}

    {{-- Kawasan: Create --}}
    <div class="modal-overlay fixed inset-0 z-[200] hidden items-center justify-center bg-[rgba(15,23,42,0.45)] p-4" id="modal-kawasan-create">
        <div class="w-full max-w-[480px] max-h-[90vh] overflow-y-auto rounded-[10px] bg-white p-[1.35rem] shadow-[0_18px_40px_rgba(0,0,0,0.18)] [&_h3]:mb-4 [&_h3]:text-[0.95rem] [&_h3]:font-semibold [&_h3]:text-[#1a3a5c]">
            <h3>Tambah Kawasan Industri</h3>
            <form action="{{ route('admin.kawasan.store') }}" method="POST">
                @csrf
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Nama</label><input name="nama" required></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Alamat</label><input name="lokasi" id="ck_lokasi"></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]">
                    <label>Cari Alamat di Peta</label>
                    <div class="flex gap-[0.4rem] [&_input]:min-w-0 [&_input]:flex-1 [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59]">
                        <input type="text" id="ck_alamat_cari" placeholder="Ketik alamat, lalu tekan Cari">
                        <button type="button" class="inline-flex shrink-0 cursor-pointer items-center gap-[0.3rem] whitespace-nowrap rounded-[7px] border border-[#d1d5db] bg-white px-[0.7rem] py-[0.45rem] text-[0.74rem] font-medium text-[#233d59] transition-colors duration-150 hover:bg-[#f3f4f6] disabled:cursor-default disabled:opacity-60 [&_svg]:h-[13px] [&_svg]:w-[13px] [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75]" id="ck_cari_btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            Cari
                        </button>
                    </div>
                    <div class="geocode-status mt-[0.35rem] min-h-[1em] text-[0.68rem] text-[#6b7280]" id="ck_geo_status"></div>
                    <div id="map-kawasan-create" class="mt-[0.45rem] h-[220px] w-full overflow-hidden rounded-lg border border-[#d1d5db]"></div>
                    <div class="mt-[0.4rem] text-[0.68rem] text-[#6b7280]">Klik pada peta atau geser marker untuk menentukan titik kawasan.</div>
                </div>
                <div class="grid grid-cols-2 gap-[0.65rem] max-[560px]:grid-cols-1">
                    <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Latitude</label><input name="latitude" id="ck_latitude" type="text" required></div>
                    <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Longitude</label><input name="longitude" id="ck_longitude" type="text" required></div>
                </div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Luas Lahan</label><input name="luas_lahan" type="text"></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Infrastruktur (pisah koma)</label><textarea name="infrastruktur"></textarea></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Fasilitas (pisah koma)</label><textarea name="fasilitas"></textarea></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Tahun Beroperasi</label><input name="tahun_beroperasi" type="text"></div>
                <div class="mt-[1.1rem] flex justify-end gap-[0.4rem]">
                    <button type="button" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-[#d1d5db] bg-white text-[#233d59] hover:bg-[#f3f4f6]" onclick="closeModal('modal-kawasan-create')">Batal</button>
                    <button type="submit" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-transparent bg-[#233d59] text-[#f5f3ee] hover:bg-[#0f1f3d]">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Kawasan: Edit --}}
    <div class="modal-overlay fixed inset-0 z-[200] hidden items-center justify-center bg-[rgba(15,23,42,0.45)] p-4" id="modal-kawasan-edit">
        <div class="w-full max-w-[480px] max-h-[90vh] overflow-y-auto rounded-[10px] bg-white p-[1.35rem] shadow-[0_18px_40px_rgba(0,0,0,0.18)] [&_h3]:mb-4 [&_h3]:text-[0.95rem] [&_h3]:font-semibold [&_h3]:text-[#1a3a5c]">
            <h3>Edit Kawasan Industri</h3>
            <form id="form-kawasan-edit" method="POST">
                @csrf @method('PUT')
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Nama</label><input name="nama" id="ek_nama" required></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Alamat</label><input name="lokasi" id="ek_lokasi"></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]">
                    <label>Cari Alamat di Peta</label>
                    <div class="flex gap-[0.4rem] [&_input]:min-w-0 [&_input]:flex-1 [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59]">
                        <input type="text" id="ek_alamat_cari" placeholder="Ketik alamat, lalu tekan Cari">
                        <button type="button" class="inline-flex shrink-0 cursor-pointer items-center gap-[0.3rem] whitespace-nowrap rounded-[7px] border border-[#d1d5db] bg-white px-[0.7rem] py-[0.45rem] text-[0.74rem] font-medium text-[#233d59] transition-colors duration-150 hover:bg-[#f3f4f6] disabled:cursor-default disabled:opacity-60 [&_svg]:h-[13px] [&_svg]:w-[13px] [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75]" id="ek_cari_btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            Cari
                        </button>
                    </div>
                    <div class="geocode-status mt-[0.35rem] min-h-[1em] text-[0.68rem] text-[#6b7280]" id="ek_geo_status"></div>
                    <div id="map-kawasan-edit" class="mt-[0.45rem] h-[220px] w-full overflow-hidden rounded-lg border border-[#d1d5db]"></div>
                    <div class="mt-[0.4rem] text-[0.68rem] text-[#6b7280]">Klik pada peta atau geser marker untuk memperbarui titik kawasan.</div>
                </div>
                <div class="grid grid-cols-2 gap-[0.65rem] max-[560px]:grid-cols-1">
                    <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Latitude</label><input name="latitude" id="ek_latitude" type="text" required></div>
                    <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Longitude</label><input name="longitude" id="ek_longitude" type="text" required></div>
                </div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Luas Lahan (Ha)</label><input name="luas_lahan" id="ek_luas" type="text"></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Infrastruktur</label><textarea name="infrastruktur" id="ek_infra"></textarea></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Fasilitas</label><textarea name="fasilitas" id="ek_fas"></textarea></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Tahun Beroperasi</label><input name="tahun_beroperasi" id="ek_tahun" type="text"></div>
                <div class="mt-[1.1rem] flex justify-end gap-[0.4rem]">
                    <button type="button" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-[#d1d5db] bg-white text-[#233d59] hover:bg-[#f3f4f6]" onclick="closeModal('modal-kawasan-edit')">Batal</button>
                    <button type="submit" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-transparent bg-[#233d59] text-[#f5f3ee] hover:bg-[#0f1f3d]">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Pelabuhan: Create --}}
    <div class="modal-overlay fixed inset-0 z-[200] hidden items-center justify-center bg-[rgba(15,23,42,0.45)] p-4" id="modal-pelabuhan-create">
        <div class="w-full max-w-[480px] max-h-[90vh] overflow-y-auto rounded-[10px] bg-white p-[1.35rem] shadow-[0_18px_40px_rgba(0,0,0,0.18)] [&_h3]:mb-4 [&_h3]:text-[0.95rem] [&_h3]:font-semibold [&_h3]:text-[#1a3a5c]">
            <h3>Tambah Pelabuhan</h3>
            <form action="{{ route('admin.pelabuhan.store') }}" method="POST">
                @csrf
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Nama</label><input name="nama" required></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Alamat</label><input name="alamat" id="cp_alamat"></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]">
                    <label>Cari Alamat di Peta</label>
                    <div class="flex gap-[0.4rem] [&_input]:min-w-0 [&_input]:flex-1 [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59]">
                        <input type="text" id="cp_alamat_cari" placeholder="Ketik alamat, lalu tekan Cari">
                        <button type="button" class="inline-flex shrink-0 cursor-pointer items-center gap-[0.3rem] whitespace-nowrap rounded-[7px] border border-[#d1d5db] bg-white px-[0.7rem] py-[0.45rem] text-[0.74rem] font-medium text-[#233d59] transition-colors duration-150 hover:bg-[#f3f4f6] disabled:cursor-default disabled:opacity-60 [&_svg]:h-[13px] [&_svg]:w-[13px] [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75]" id="cp_cari_btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            Cari
                        </button>
                    </div>
                    <div class="geocode-status mt-[0.35rem] min-h-[1em] text-[0.68rem] text-[#6b7280]" id="cp_geo_status"></div>
                    <div id="map-pelabuhan-create" class="mt-[0.45rem] h-[220px] w-full overflow-hidden rounded-lg border border-[#d1d5db]"></div>
                    <div class="mt-[0.4rem] text-[0.68rem] text-[#6b7280]">Klik pada peta atau geser marker untuk menentukan titik pelabuhan.</div>
                </div>
                <div class="grid grid-cols-2 gap-[0.65rem] max-[560px]:grid-cols-1">
                    <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Latitude</label><input name="latitude" id="cp_latitude" type="text" required></div>
                    <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Longitude</label><input name="longitude" id="cp_longitude" type="text" required></div>
                </div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Jenis</label><input name="jenis"></div>
                <div class="mt-[1.1rem] flex justify-end gap-[0.4rem]">
                    <button type="button" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-[#d1d5db] bg-white text-[#233d59] hover:bg-[#f3f4f6]" onclick="closeModal('modal-pelabuhan-create')">Batal</button>
                    <button type="submit" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-transparent bg-[#233d59] text-[#f5f3ee] hover:bg-[#0f1f3d]">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Pelabuhan: Edit --}}
    <div class="modal-overlay fixed inset-0 z-[200] hidden items-center justify-center bg-[rgba(15,23,42,0.45)] p-4" id="modal-pelabuhan-edit">
        <div class="w-full max-w-[480px] max-h-[90vh] overflow-y-auto rounded-[10px] bg-white p-[1.35rem] shadow-[0_18px_40px_rgba(0,0,0,0.18)] [&_h3]:mb-4 [&_h3]:text-[0.95rem] [&_h3]:font-semibold [&_h3]:text-[#1a3a5c]">
            <h3>Edit Pelabuhan</h3>
            <form id="form-pelabuhan-edit" method="POST">
                @csrf @method('PUT')
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Nama</label><input name="nama" id="ep_nama" required></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Alamat</label><input name="alamat" id="ep_alamat"></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]">
                    <label>Cari Alamat di Peta</label>
                    <div class="flex gap-[0.4rem] [&_input]:min-w-0 [&_input]:flex-1 [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59]">
                        <input type="text" id="ep_alamat_cari" placeholder="Ketik alamat, lalu tekan Cari">
                        <button type="button" class="inline-flex shrink-0 cursor-pointer items-center gap-[0.3rem] whitespace-nowrap rounded-[7px] border border-[#d1d5db] bg-white px-[0.7rem] py-[0.45rem] text-[0.74rem] font-medium text-[#233d59] transition-colors duration-150 hover:bg-[#f3f4f6] disabled:cursor-default disabled:opacity-60 [&_svg]:h-[13px] [&_svg]:w-[13px] [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75]" id="ep_cari_btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            Cari
                        </button>
                    </div>
                    <div class="geocode-status mt-[0.35rem] min-h-[1em] text-[0.68rem] text-[#6b7280]" id="ep_geo_status"></div>
                    <div id="map-pelabuhan-edit" class="mt-[0.45rem] h-[220px] w-full overflow-hidden rounded-lg border border-[#d1d5db]"></div>
                    <div class="mt-[0.4rem] text-[0.68rem] text-[#6b7280]">Klik pada peta atau geser marker untuk memperbarui titik pelabuhan.</div>
                </div>
                <div class="grid grid-cols-2 gap-[0.65rem] max-[560px]:grid-cols-1">
                    <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Latitude</label><input name="latitude" id="ep_latitude" type="text" required></div>
                    <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Longitude</label><input name="longitude" id="ep_longitude" type="text" required></div>
                </div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Jenis</label><input name="jenis" id="ep_jenis"></div>
                <div class="mt-[1.1rem] flex justify-end gap-[0.4rem]">
                    <button type="button" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-[#d1d5db] bg-white text-[#233d59] hover:bg-[#f3f4f6]" onclick="closeModal('modal-pelabuhan-edit')">Batal</button>
                    <button type="submit" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-transparent bg-[#233d59] text-[#f5f3ee] hover:bg-[#0f1f3d]">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Bandara: Create --}}
    <div class="modal-overlay fixed inset-0 z-[200] hidden items-center justify-center bg-[rgba(15,23,42,0.45)] p-4" id="modal-bandara-create">
        <div class="w-full max-w-[480px] max-h-[90vh] overflow-y-auto rounded-[10px] bg-white p-[1.35rem] shadow-[0_18px_40px_rgba(0,0,0,0.18)] [&_h3]:mb-4 [&_h3]:text-[0.95rem] [&_h3]:font-semibold [&_h3]:text-[#1a3a5c]">
            <h3>Tambah Bandara</h3>
            <form action="{{ route('admin.bandara.store') }}" method="POST">
                @csrf
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Nama</label><input name="nama" required></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Alamat</label><input name="alamat" id="cb_alamat"></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]">
                    <label>Cari Alamat di Peta</label>
                    <div class="flex gap-[0.4rem] [&_input]:min-w-0 [&_input]:flex-1 [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59]">
                        <input type="text" id="cb_alamat_cari" placeholder="Ketik alamat, lalu tekan Cari">
                        <button type="button" class="inline-flex shrink-0 cursor-pointer items-center gap-[0.3rem] whitespace-nowrap rounded-[7px] border border-[#d1d5db] bg-white px-[0.7rem] py-[0.45rem] text-[0.74rem] font-medium text-[#233d59] transition-colors duration-150 hover:bg-[#f3f4f6] disabled:cursor-default disabled:opacity-60 [&_svg]:h-[13px] [&_svg]:w-[13px] [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75]" id="cb_cari_btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            Cari
                        </button>
                    </div>
                    <div class="geocode-status mt-[0.35rem] min-h-[1em] text-[0.68rem] text-[#6b7280]" id="cb_geo_status"></div>
                    <div id="map-bandara-create" class="mt-[0.45rem] h-[220px] w-full overflow-hidden rounded-lg border border-[#d1d5db]"></div>
                    <div class="mt-[0.4rem] text-[0.68rem] text-[#6b7280]">Klik pada peta atau geser marker untuk menentukan titik bandara.</div>
                </div>
                <div class="grid grid-cols-2 gap-[0.65rem] max-[560px]:grid-cols-1">
                    <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Latitude</label><input name="latitude" id="cb_latitude" type="text" required></div>
                    <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Longitude</label><input name="longitude" id="cb_longitude" type="text" required></div>
                </div>
                <div class="mt-[1.1rem] flex justify-end gap-[0.4rem]">
                    <button type="button" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-[#d1d5db] bg-white text-[#233d59] hover:bg-[#f3f4f6]" onclick="closeModal('modal-bandara-create')">Batal</button>
                    <button type="submit" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-transparent bg-[#233d59] text-[#f5f3ee] hover:bg-[#0f1f3d]">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Bandara: Edit --}}
    <div class="modal-overlay fixed inset-0 z-[200] hidden items-center justify-center bg-[rgba(15,23,42,0.45)] p-4" id="modal-bandara-edit">
        <div class="w-full max-w-[480px] max-h-[90vh] overflow-y-auto rounded-[10px] bg-white p-[1.35rem] shadow-[0_18px_40px_rgba(0,0,0,0.18)] [&_h3]:mb-4 [&_h3]:text-[0.95rem] [&_h3]:font-semibold [&_h3]:text-[#1a3a5c]">
            <h3>Edit Bandara</h3>
            <form id="form-bandara-edit" method="POST">
                @csrf @method('PUT')
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Nama</label><input name="nama" id="eb_nama" required></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Alamat</label><input name="alamat" id="eb_alamat"></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]">
                    <label>Cari Alamat di Peta</label>
                    <div class="flex gap-[0.4rem] [&_input]:min-w-0 [&_input]:flex-1 [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59]">
                        <input type="text" id="eb_alamat_cari" placeholder="Ketik alamat, lalu tekan Cari">
                        <button type="button" class="inline-flex shrink-0 cursor-pointer items-center gap-[0.3rem] whitespace-nowrap rounded-[7px] border border-[#d1d5db] bg-white px-[0.7rem] py-[0.45rem] text-[0.74rem] font-medium text-[#233d59] transition-colors duration-150 hover:bg-[#f3f4f6] disabled:cursor-default disabled:opacity-60 [&_svg]:h-[13px] [&_svg]:w-[13px] [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75]" id="eb_cari_btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            Cari
                        </button>
                    </div>
                    <div class="geocode-status mt-[0.35rem] min-h-[1em] text-[0.68rem] text-[#6b7280]" id="eb_geo_status"></div>
                    <div id="map-bandara-edit" class="mt-[0.45rem] h-[220px] w-full overflow-hidden rounded-lg border border-[#d1d5db]"></div>
                    <div class="mt-[0.4rem] text-[0.68rem] text-[#6b7280]">Klik pada peta atau geser marker untuk memperbarui titik bandara.</div>
                </div>
                <div class="grid grid-cols-2 gap-[0.65rem] max-[560px]:grid-cols-1">
                    <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Latitude</label><input name="latitude" id="eb_latitude" type="text" required></div>
                    <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Longitude</label><input name="longitude" id="eb_longitude" type="text" required></div>
                </div>
                <div class="mt-[1.1rem] flex justify-end gap-[0.4rem]">
                    <button type="button" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-[#d1d5db] bg-white text-[#233d59] hover:bg-[#f3f4f6]" onclick="closeModal('modal-bandara-edit')">Batal</button>
                    <button type="submit" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-transparent bg-[#233d59] text-[#f5f3ee] hover:bg-[#0f1f3d]">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Jalan: Edit --}}
    <div class="modal-overlay fixed inset-0 z-[200] hidden items-center justify-center bg-[rgba(15,23,42,0.45)] p-4" id="modal-jalan-edit">
        <div class="w-full max-w-[480px] max-h-[90vh] overflow-y-auto rounded-[10px] bg-white p-[1.35rem] shadow-[0_18px_40px_rgba(0,0,0,0.18)] [&_h3]:mb-4 [&_h3]:text-[0.95rem] [&_h3]:font-semibold [&_h3]:text-[#1a3a5c]">
            <h3>Edit Jalan</h3>
            <form id="form-jalan-edit" method="POST">
                @csrf @method('PUT')
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Nama Jalan</label><input name="nama_jalan" id="ej_nama" required></div>
                <div class="mb-3 [&_label]:mb-[0.3rem] [&_label]:block [&_label]:text-[0.72rem] [&_label]:font-medium [&_label]:text-[#374151] [&_input]:w-full [&_input]:rounded-[7px] [&_input]:border [&_input]:border-[#d1d5db] [&_input]:px-[0.65rem] [&_input]:py-[0.45rem] [&_input]:text-[0.78rem] [&_input]:text-[#1f2937] [&_input]:outline-none [&_input]:transition-colors [&_input]:duration-150 [&_input:focus]:border-[#233d59] [&_textarea]:min-h-16 [&_textarea]:w-full [&_textarea]:resize-y [&_textarea]:rounded-[7px] [&_textarea]:border [&_textarea]:border-[#d1d5db] [&_textarea]:px-[0.65rem] [&_textarea]:py-[0.45rem] [&_textarea]:text-[0.78rem] [&_textarea]:text-[#1f2937] [&_textarea]:outline-none [&_textarea]:transition-colors [&_textarea]:duration-150 [&_textarea:focus]:border-[#233d59]"><label>Jenis Jalan</label><input name="jenis_jalan" id="ej_jenis"></div>
                <div class="mt-[1.1rem] flex justify-end gap-[0.4rem]">
                    <button type="button" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-[#d1d5db] bg-white text-[#233d59] hover:bg-[#f3f4f6]" onclick="closeModal('modal-jalan-edit')">Batal</button>
                    <button type="submit" class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-transparent bg-[#233d59] text-[#f5f3ee] hover:bg-[#0f1f3d]">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay fixed inset-0 z-[200] hidden items-center justify-center bg-[rgba(15,23,42,0.45)] p-4" id="modal-delete">
        <div class="w-full max-w-[480px] max-h-[90vh] overflow-y-auto rounded-[10px] bg-white p-[1.35rem] shadow-[0_18px_40px_rgba(0,0,0,0.18)] [&_h3]:mb-4 [&_h3]:text-[0.95rem] [&_h3]:font-semibold [&_h3]:text-[#1a3a5c]">
            <h3>Hapus Data</h3>

            <p class="mb-4 text-[0.78rem] text-[#6b7280]">
                Apakah kamu yakin ingin menghapus data ini?
            </p>

            <div class="mt-[1.1rem] flex justify-end gap-[0.4rem]">
                <button type="button"
                        class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-[#d1d5db] bg-white text-[#233d59] hover:bg-[#f3f4f6]"
                        onclick="closeModal('modal-delete')">
                    Batal
                </button>

                <button type="button"
                        class="inline-flex cursor-pointer items-center gap-[0.35rem] rounded-[7px] border px-3 py-[0.4rem] text-[0.74rem] font-medium no-underline transition-colors duration-150 [&_svg]:h-3 [&_svg]:w-3 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:stroke-[1.75] border-[#fecaca] bg-white text-[#b91c1c] hover:bg-[#fee2e2]"
                        id="confirmDeleteBtn">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    function showTab(tabName, subtabName = null) {
        document.querySelectorAll('.tab-pane').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('block');
        });

        document.querySelectorAll('.subtab-pane').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('block');
        });

        document.querySelectorAll('.tab-btn').forEach(el => {
            el.classList.remove('bg-[#eef2f7]', 'text-[#233d59]', 'active', 'open');
            el.classList.add('bg-transparent', 'text-[#1f2937]');
        });

        document.querySelectorAll('.subtab-btn').forEach(el => {
            el.classList.remove('bg-[#eef2f7]', 'text-[#233d59]', 'font-medium', 'active');

            el.classList.add('bg-transparent', 'text-[#1f2937]');

            const dot = el.querySelector('.dot');
            if (dot) {
                dot.classList.remove('bg-[#233d59]');
                dot.classList.add('bg-[#cbd5e1]');
            }
        });

        const tabPane = document.getElementById('tab-' + tabName);

        if (tabPane) {
            tabPane.classList.remove('hidden');
            tabPane.classList.add('block');
        }

        const tabBtn = document.querySelector(`[data-tab="${tabName}"]`);

        if (tabBtn) {
            tabBtn.classList.remove('bg-transparent', 'text-[#1f2937]');
            tabBtn.classList.add('bg-[#eef2f7]', 'text-[#233d59]', 'active');
        }

        const subnav = document.getElementById('subnav-infrastruktur');
        const chev = document.getElementById('chev-infrastruktur');

        if (tabName === 'infrastruktur') {
            if (subnav) {
                subnav.classList.remove('hidden');
                subnav.classList.add('block');
            }

            if (tabBtn) {
                tabBtn.classList.add('open');
            }

            if (chev) {
                chev.classList.add('rotate-90');
            }

            const activeSub = subtabName || 'pelabuhan';

            const subPane = document.getElementById('subtab-' + activeSub);

            if (subPane) {
                subPane.classList.remove('hidden');
                subPane.classList.add('block');
            }

            const subBtn = document.querySelector(`[data-subtab="${activeSub}"]`);

            if (subBtn) {
                subBtn.classList.remove('bg-transparent', 'text-[#1f2937]');
                subBtn.classList.add('bg-[#eef2f7]', 'text-[#233d59]', 'font-medium', 'active');

                const dot = subBtn.querySelector('.dot');

                if (dot) {
                    dot.classList.remove('bg-[#cbd5e1]');
                    dot.classList.add('bg-[#233d59]');
                }
            }
        } else {
            if (subnav) {
                subnav.classList.add('hidden');
                subnav.classList.remove('block');
            }

            if (chev) {
                chev.classList.remove('rotate-90');
            }
        }

        if (tabName === 'peta') {
            const frame = document.getElementById('peta-frame');

            if (frame && !frame.getAttribute('src')) {
                frame.src = frame.dataset.src;
            }
        }
    }

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            showTab(this.dataset.tab);
        });
    });

    document.querySelectorAll('.subtab-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            showTab('infrastruktur', this.dataset.subtab);
        });
    });

    function openModal(id) {
        const modal = document.getElementById(id);

        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        setTimeout(() => {
            Object.values(mapPickers).forEach(picker => {
                if (picker.map) {
                    picker.map.invalidateSize();
                }
            });
        }, 200);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);

        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
            }
        });
    });

    function openEditKawasan(k) {
        document.getElementById('form-kawasan-edit').action = '/admin/kawasan/' + k.id;
        document.getElementById('ek_nama').value = k.nama || '';
        document.getElementById('ek_lokasi').value = k.lokasi || '';
        document.getElementById('ek_alamat_cari').value = k.lokasi || '';
        document.getElementById('ek_geo_status').textContent = '';
        document.getElementById('ek_luas').value = k.luas_lahan || '';
        document.getElementById('ek_infra').value = k.infrastruktur || '';
        document.getElementById('ek_fas').value = k.fasilitas || '';
        document.getElementById('ek_tahun').value = k.tahun_beroperasi || '';
        document.getElementById('ek_latitude').value = k.latitude || '';
        document.getElementById('ek_longitude').value = k.longitude || '';

        setMapPickerPosition('kawasan-edit', k.latitude, k.longitude);
        openModal('modal-kawasan-edit');
    }

    function openEditPelabuhan(p) {
        document.getElementById('form-pelabuhan-edit').action = '/admin/pelabuhan/' + p.id;
        document.getElementById('ep_nama').value = p.nama || '';
        document.getElementById('ep_alamat').value = p.alamat || '';
        document.getElementById('ep_alamat_cari').value = p.alamat || '';
        document.getElementById('ep_geo_status').textContent = '';
        document.getElementById('ep_jenis').value = p.jenis || '';
        document.getElementById('ep_latitude').value = p.latitude || '';
        document.getElementById('ep_longitude').value = p.longitude || '';

        setMapPickerPosition('pelabuhan-edit', p.latitude, p.longitude);
        openModal('modal-pelabuhan-edit');
    }

    function openEditBandara(b) {
        document.getElementById('form-bandara-edit').action = '/admin/bandara/' + b.id;
        document.getElementById('eb_nama').value = b.nama || '';
        document.getElementById('eb_alamat').value = b.alamat || '';
        document.getElementById('eb_alamat_cari').value = b.alamat || '';
        document.getElementById('eb_geo_status').textContent = '';
        document.getElementById('eb_latitude').value = b.latitude || '';
        document.getElementById('eb_longitude').value = b.longitude || '';

        setMapPickerPosition('bandara-edit', b.latitude, b.longitude);
        openModal('modal-bandara-edit');
    }

    function openEditJalan(j) {
        document.getElementById('form-jalan-edit').action = '/admin/jalan/' + j.id;
        document.getElementById('ej_nama').value = j.nama_jalan || '';
        document.getElementById('ej_jenis').value = j.jenis_jalan || '';

        openModal('modal-jalan-edit');
    }

    let deleteForm = null;

    function openDeleteModal(button) {
        deleteForm = button.closest('form');
        openModal('modal-delete');
    }

    document.getElementById('confirmDeleteBtn')?.addEventListener('click', function () {
        if (deleteForm) {
            deleteForm.submit();
        }
    });

    document.querySelectorAll('.search-input').forEach(input => {
        input.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            const table = document.getElementById(this.dataset.target);

            if (!table) return;

            table.querySelectorAll('tbody tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
            });
        });
    });

    const defaultLat = 1.10;
    const defaultLng = 104.02;
    const mapPickers = {};

    function initMapPicker(key, mapId, latInputId, lngInputId) {
        const mapEl = document.getElementById(mapId);
        const latInput = document.getElementById(latInputId);
        const lngInput = document.getElementById(lngInputId);

        if (!mapEl || !latInput || !lngInput || typeof L === 'undefined') return;

        const map = L.map(mapId).setView([defaultLat, defaultLng], 11);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(map);

        function setPosition(lat, lng, shouldMoveMap = true) {
            lat = parseFloat(lat);
            lng = parseFloat(lng);

            if (Number.isNaN(lat) || Number.isNaN(lng)) return;

            marker.setLatLng([lat, lng]);
            latInput.value = lat.toFixed(6);
            lngInput.value = lng.toFixed(6);

            if (shouldMoveMap) {
                map.setView([lat, lng], 13);
            }
        }

        map.on('click', function (e) {
            setPosition(e.latlng.lat, e.latlng.lng, false);
        });

        marker.on('dragend', function (e) {
            const pos = e.target.getLatLng();
            setPosition(pos.lat, pos.lng, false);
        });

        function manualInputHandler() {
            setPosition(latInput.value, lngInput.value, true);
        }

        latInput.addEventListener('change', manualInputHandler);
        lngInput.addEventListener('change', manualInputHandler);

        setPosition(latInput.value || defaultLat, lngInput.value || defaultLng, true);

        mapPickers[key] = {
            map,
            marker,
            setPosition
        };
    }

    function setMapPickerPosition(key, lat, lng) {
        const picker = mapPickers[key];

        if (!picker) return;

        if (lat && lng) {
            picker.setPosition(lat, lng, true);
        } else {
            picker.setPosition(defaultLat, defaultLng, true);
        }
    }

    async function geocodeAddress(key, query, statusElId, btnEl) {
        const picker = mapPickers[key];
        const statusEl = statusElId ? document.getElementById(statusElId) : null;

        function setStatus(text, type) {
            if (!statusEl) return;

            statusEl.textContent = text;
            statusEl.classList.remove('text-[#b91c1c]', 'text-[#15803d]', 'text-[#6b7280]');
            statusEl.classList.add(type || 'text-[#6b7280]');
        }

        if (!picker) return;

        const q = (query || '').trim();

        if (!q) {
            setStatus('Ketik alamat dulu sebelum mencari.', 'text-[#b91c1c]');
            return;
        }

        if (btnEl) btnEl.disabled = true;

        setStatus('Mencari lokasi...', 'text-[#6b7280]');

        try {
            const url = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&countrycodes=id&q=' + encodeURIComponent(q);

            const res = await fetch(url, {
                headers: {
                    'Accept-Language': 'id'
                }
            });

            if (!res.ok) throw new Error('Request gagal');

            const results = await res.json();

            if (!results || results.length === 0) {
                setStatus('Alamat tidak ditemukan. Coba kata kunci lain, atau geser marker secara manual.', 'text-[#b91c1c]');
                return;
            }

            const {
                lat,
                lon,
                display_name
            } = results[0];

            picker.setPosition(lat, lon, true);
            setStatus('Ditemukan: ' + display_name + ' — geser marker untuk titik yang lebih pas.', 'text-[#15803d]');
        } catch (err) {
            setStatus('Gagal menghubungi layanan pencarian alamat. Coba lagi.', 'text-[#b91c1c]');
        } finally {
            if (btnEl) btnEl.disabled = false;
        }
    }

    function bindAddressSearch(key, btnId, inputId, statusElId) {
        const btn = document.getElementById(btnId);
        const input = document.getElementById(inputId);

        if (!btn || !input) return;

        btn.addEventListener('click', function () {
            geocodeAddress(key, input.value, statusElId, btn);
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                geocodeAddress(key, input.value, statusElId, btn);
            }
        });
    }

    initMapPicker('kawasan-create', 'map-kawasan-create', 'ck_latitude', 'ck_longitude');
    initMapPicker('kawasan-edit', 'map-kawasan-edit', 'ek_latitude', 'ek_longitude');
    initMapPicker('pelabuhan-create', 'map-pelabuhan-create', 'cp_latitude', 'cp_longitude');
    initMapPicker('pelabuhan-edit', 'map-pelabuhan-edit', 'ep_latitude', 'ep_longitude');
    initMapPicker('bandara-create', 'map-bandara-create', 'cb_latitude', 'cb_longitude');
    initMapPicker('bandara-edit', 'map-bandara-edit', 'eb_latitude', 'eb_longitude');

    bindAddressSearch('kawasan-create', 'ck_cari_btn', 'ck_alamat_cari', 'ck_geo_status');
    bindAddressSearch('kawasan-edit', 'ek_cari_btn', 'ek_alamat_cari', 'ek_geo_status');
    bindAddressSearch('pelabuhan-create', 'cp_cari_btn', 'cp_alamat_cari', 'cp_geo_status');
    bindAddressSearch('pelabuhan-edit', 'ep_cari_btn', 'ep_alamat_cari', 'ep_geo_status');
    bindAddressSearch('bandara-create', 'cb_cari_btn', 'cb_alamat_cari', 'cb_geo_status');
    bindAddressSearch('bandara-edit', 'eb_cari_btn', 'eb_alamat_cari', 'eb_geo_status');

    showTab(
        "{{ request('tab', 'kawasan') }}",
        "{{ request('subtab', 'pelabuhan') }}"
    );


    const adminSidebar = document.getElementById('adminSidebar');
    const adminSidebarToggle = document.getElementById('adminSidebarToggle');
    const adminSidebarOverlay = document.getElementById('adminSidebarOverlay');

    function openAdminSidebar() {
        if (!adminSidebar || !adminSidebarOverlay || !adminSidebarToggle) return;
        adminSidebar.classList.add('is-open');
        adminSidebarOverlay.classList.remove('pointer-events-none', 'opacity-0');
        adminSidebarOverlay.classList.add('pointer-events-auto', 'opacity-100');
        adminSidebarToggle.setAttribute('aria-expanded', 'true');
    }

    function closeAdminSidebar() {
        if (!adminSidebar || !adminSidebarOverlay || !adminSidebarToggle) return;
        adminSidebar.classList.remove('is-open');
        adminSidebarOverlay.classList.add('pointer-events-none', 'opacity-0');
        adminSidebarOverlay.classList.remove('pointer-events-auto', 'opacity-100');
        adminSidebarToggle.setAttribute('aria-expanded', 'false');
    }

    if (adminSidebarToggle) {
        adminSidebarToggle.addEventListener('click', function () {
            adminSidebar?.classList.contains('is-open') ? closeAdminSidebar() : openAdminSidebar();
        });
    }

    if (adminSidebarOverlay) {
        adminSidebarOverlay.addEventListener('click', closeAdminSidebar);
    }

    window.addEventListener('resize', function () {
        if (window.innerWidth > 900) {
            closeAdminSidebar();
        }
    });

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            if (window.innerWidth <= 900 && this.dataset.tab !== 'infrastruktur') {
                closeAdminSidebar();
            }
        });
    });

    document.querySelectorAll('.subtab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            if (window.innerWidth <= 900) {
                closeAdminSidebar();
            }
        });
    });

    const toast = document.getElementById('toastSuccess');

    if (toast) {
        setTimeout(() => {
            toast.classList.add('translate-x-[120%]', 'opacity-0');

            setTimeout(() => {
                toast.remove();
            }, 400);
        }, 4000);
    }
</script>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    function showTab(tabName, subtabName = null) {
        document.querySelectorAll('.tab-pane').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('block');
        });

        document.querySelectorAll('.subtab-pane').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('block');
        });

        document.querySelectorAll('.tab-btn').forEach(el => {
            el.classList.remove('bg-[#eef2f7]', 'text-[#233d59]', 'active', 'open');
            el.classList.add('bg-transparent', 'text-[#1f2937]');
        });

        document.querySelectorAll('.subtab-btn').forEach(el => {
            el.classList.remove('bg-[#eef2f7]', 'text-[#233d59]', 'font-medium', 'active');

            el.classList.add('bg-transparent', 'text-[#1f2937]');

            const dot = el.querySelector('.dot');
            if (dot) {
                dot.classList.remove('bg-[#233d59]');
                dot.classList.add('bg-[#cbd5e1]');
            }
        });

        const tabPane = document.getElementById('tab-' + tabName);

        if (tabPane) {
            tabPane.classList.remove('hidden');
            tabPane.classList.add('block');
        }

        const tabBtn = document.querySelector(`[data-tab="${tabName}"]`);

        if (tabBtn) {
            tabBtn.classList.remove('bg-transparent', 'text-[#1f2937]');
            tabBtn.classList.add('bg-[#eef2f7]', 'text-[#233d59]', 'active');
        }

        const subnav = document.getElementById('subnav-infrastruktur');
        const chev = document.getElementById('chev-infrastruktur');

        if (tabName === 'infrastruktur') {
            if (subnav) {
                subnav.classList.remove('hidden');
                subnav.classList.add('block');
            }

            if (tabBtn) {
                tabBtn.classList.add('open');
            }

            if (chev) {
                chev.classList.add('rotate-90');
            }

            const activeSub = subtabName || 'pelabuhan';

            const subPane = document.getElementById('subtab-' + activeSub);

            if (subPane) {
                subPane.classList.remove('hidden');
                subPane.classList.add('block');
            }

            const subBtn = document.querySelector(`[data-subtab="${activeSub}"]`);

            if (subBtn) {
                subBtn.classList.remove('bg-transparent', 'text-[#1f2937]');
                subBtn.classList.add('bg-[#eef2f7]', 'text-[#233d59]', 'font-medium', 'active');

                const dot = subBtn.querySelector('.dot');

                if (dot) {
                    dot.classList.remove('bg-[#cbd5e1]');
                    dot.classList.add('bg-[#233d59]');
                }
            }
        } else {
            if (subnav) {
                subnav.classList.add('hidden');
                subnav.classList.remove('block');
            }

            if (chev) {
                chev.classList.remove('rotate-90');
            }
        }

        if (tabName === 'peta') {
            const frame = document.getElementById('peta-frame');

            if (frame && !frame.getAttribute('src')) {
                frame.src = frame.dataset.src;
            }
        }
    }

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            showTab(this.dataset.tab);
        });
    });

    document.querySelectorAll('.subtab-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            showTab('infrastruktur', this.dataset.subtab);
        });
    });

    function openModal(id) {
        const modal = document.getElementById(id);

        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        setTimeout(() => {
            Object.values(mapPickers).forEach(picker => {
                if (picker.map) {
                    picker.map.invalidateSize();
                }
            });
        }, 200);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);

        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
            }
        });
    });

    function openEditKawasan(k) {
        document.getElementById('form-kawasan-edit').action = '/admin/kawasan/' + k.id;
        document.getElementById('ek_nama').value = k.nama || '';
        document.getElementById('ek_lokasi').value = k.lokasi || '';
        document.getElementById('ek_alamat_cari').value = k.lokasi || '';
        document.getElementById('ek_geo_status').textContent = '';
        document.getElementById('ek_luas').value = k.luas_lahan || '';
        document.getElementById('ek_infra').value = k.infrastruktur || '';
        document.getElementById('ek_fas').value = k.fasilitas || '';
        document.getElementById('ek_tahun').value = k.tahun_beroperasi || '';
        document.getElementById('ek_latitude').value = k.latitude || '';
        document.getElementById('ek_longitude').value = k.longitude || '';

        setMapPickerPosition('kawasan-edit', k.latitude, k.longitude);
        openModal('modal-kawasan-edit');
    }

    function openEditPelabuhan(p) {
        document.getElementById('form-pelabuhan-edit').action = '/admin/pelabuhan/' + p.id;
        document.getElementById('ep_nama').value = p.nama || '';
        document.getElementById('ep_alamat').value = p.alamat || '';
        document.getElementById('ep_alamat_cari').value = p.alamat || '';
        document.getElementById('ep_geo_status').textContent = '';
        document.getElementById('ep_jenis').value = p.jenis || '';
        document.getElementById('ep_latitude').value = p.latitude || '';
        document.getElementById('ep_longitude').value = p.longitude || '';

        setMapPickerPosition('pelabuhan-edit', p.latitude, p.longitude);
        openModal('modal-pelabuhan-edit');
    }

    function openEditBandara(b) {
        document.getElementById('form-bandara-edit').action = '/admin/bandara/' + b.id;
        document.getElementById('eb_nama').value = b.nama || '';
        document.getElementById('eb_alamat').value = b.alamat || '';
        document.getElementById('eb_alamat_cari').value = b.alamat || '';
        document.getElementById('eb_geo_status').textContent = '';
        document.getElementById('eb_latitude').value = b.latitude || '';
        document.getElementById('eb_longitude').value = b.longitude || '';

        setMapPickerPosition('bandara-edit', b.latitude, b.longitude);
        openModal('modal-bandara-edit');
    }

    function openEditJalan(j) {
        document.getElementById('form-jalan-edit').action = '/admin/jalan/' + j.id;
        document.getElementById('ej_nama').value = j.nama_jalan || '';
        document.getElementById('ej_jenis').value = j.jenis_jalan || '';

        openModal('modal-jalan-edit');
    }

    let deleteForm = null;

    function openDeleteModal(button) {
        deleteForm = button.closest('form');
        openModal('modal-delete');
    }

    document.getElementById('confirmDeleteBtn')?.addEventListener('click', function () {
        if (deleteForm) {
            deleteForm.submit();
        }
    });

    document.querySelectorAll('.search-input').forEach(input => {
        input.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            const table = document.getElementById(this.dataset.target);

            if (!table) return;

            table.querySelectorAll('tbody tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
            });
        });
    });

    const defaultLat = 1.10;
    const defaultLng = 104.02;
    const mapPickers = {};

    function initMapPicker(key, mapId, latInputId, lngInputId) {
        const mapEl = document.getElementById(mapId);
        const latInput = document.getElementById(latInputId);
        const lngInput = document.getElementById(lngInputId);

        if (!mapEl || !latInput || !lngInput || typeof L === 'undefined') return;

        const map = L.map(mapId).setView([defaultLat, defaultLng], 11);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(map);

        function setPosition(lat, lng, shouldMoveMap = true) {
            lat = parseFloat(lat);
            lng = parseFloat(lng);

            if (Number.isNaN(lat) || Number.isNaN(lng)) return;

            marker.setLatLng([lat, lng]);
            latInput.value = lat.toFixed(6);
            lngInput.value = lng.toFixed(6);

            if (shouldMoveMap) {
                map.setView([lat, lng], 13);
            }
        }

        map.on('click', function (e) {
            setPosition(e.latlng.lat, e.latlng.lng, false);
        });

        marker.on('dragend', function (e) {
            const pos = e.target.getLatLng();
            setPosition(pos.lat, pos.lng, false);
        });

        function manualInputHandler() {
            setPosition(latInput.value, lngInput.value, true);
        }

        latInput.addEventListener('change', manualInputHandler);
        lngInput.addEventListener('change', manualInputHandler);

        setPosition(latInput.value || defaultLat, lngInput.value || defaultLng, true);

        mapPickers[key] = {
            map,
            marker,
            setPosition
        };
    }

    function setMapPickerPosition(key, lat, lng) {
        const picker = mapPickers[key];

        if (!picker) return;

        if (lat && lng) {
            picker.setPosition(lat, lng, true);
        } else {
            picker.setPosition(defaultLat, defaultLng, true);
        }
    }

    async function geocodeAddress(key, query, statusElId, btnEl) {
        const picker = mapPickers[key];
        const statusEl = statusElId ? document.getElementById(statusElId) : null;

        function setStatus(text, type) {
            if (!statusEl) return;

            statusEl.textContent = text;
            statusEl.classList.remove('text-[#b91c1c]', 'text-[#15803d]', 'text-[#6b7280]');
            statusEl.classList.add(type || 'text-[#6b7280]');
        }

        if (!picker) return;

        const q = (query || '').trim();

        if (!q) {
            setStatus('Ketik alamat dulu sebelum mencari.', 'text-[#b91c1c]');
            return;
        }

        if (btnEl) btnEl.disabled = true;

        setStatus('Mencari lokasi...', 'text-[#6b7280]');

        try {
            const url = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&countrycodes=id&q=' + encodeURIComponent(q);

            const res = await fetch(url, {
                headers: {
                    'Accept-Language': 'id'
                }
            });

            if (!res.ok) throw new Error('Request gagal');

            const results = await res.json();

            if (!results || results.length === 0) {
                setStatus('Alamat tidak ditemukan. Coba kata kunci lain, atau geser marker secara manual.', 'text-[#b91c1c]');
                return;
            }

            const {
                lat,
                lon,
                display_name
            } = results[0];

            picker.setPosition(lat, lon, true);
            setStatus('Ditemukan: ' + display_name + ' — geser marker untuk titik yang lebih pas.', 'text-[#15803d]');
        } catch (err) {
            setStatus('Gagal menghubungi layanan pencarian alamat. Coba lagi.', 'text-[#b91c1c]');
        } finally {
            if (btnEl) btnEl.disabled = false;
        }
    }

    function bindAddressSearch(key, btnId, inputId, statusElId) {
        const btn = document.getElementById(btnId);
        const input = document.getElementById(inputId);

        if (!btn || !input) return;

        btn.addEventListener('click', function () {
            geocodeAddress(key, input.value, statusElId, btn);
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                geocodeAddress(key, input.value, statusElId, btn);
            }
        });
    }

    initMapPicker('kawasan-create', 'map-kawasan-create', 'ck_latitude', 'ck_longitude');
    initMapPicker('kawasan-edit', 'map-kawasan-edit', 'ek_latitude', 'ek_longitude');
    initMapPicker('pelabuhan-create', 'map-pelabuhan-create', 'cp_latitude', 'cp_longitude');
    initMapPicker('pelabuhan-edit', 'map-pelabuhan-edit', 'ep_latitude', 'ep_longitude');
    initMapPicker('bandara-create', 'map-bandara-create', 'cb_latitude', 'cb_longitude');
    initMapPicker('bandara-edit', 'map-bandara-edit', 'eb_latitude', 'eb_longitude');

    bindAddressSearch('kawasan-create', 'ck_cari_btn', 'ck_alamat_cari', 'ck_geo_status');
    bindAddressSearch('kawasan-edit', 'ek_cari_btn', 'ek_alamat_cari', 'ek_geo_status');
    bindAddressSearch('pelabuhan-create', 'cp_cari_btn', 'cp_alamat_cari', 'cp_geo_status');
    bindAddressSearch('pelabuhan-edit', 'ep_cari_btn', 'ep_alamat_cari', 'ep_geo_status');
    bindAddressSearch('bandara-create', 'cb_cari_btn', 'cb_alamat_cari', 'cb_geo_status');
    bindAddressSearch('bandara-edit', 'eb_cari_btn', 'eb_alamat_cari', 'eb_geo_status');

    showTab(
        "{{ request('tab', 'kawasan') }}",
        "{{ request('subtab', 'pelabuhan') }}"
    );


    const adminSidebar = document.getElementById('adminSidebar');
    const adminSidebarToggle = document.getElementById('adminSidebarToggle');
    const adminSidebarOverlay = document.getElementById('adminSidebarOverlay');

    function openAdminSidebar() {
        if (!adminSidebar || !adminSidebarOverlay || !adminSidebarToggle) return;
        adminSidebar.classList.add('is-open');
        adminSidebarOverlay.classList.remove('pointer-events-none', 'opacity-0');
        adminSidebarOverlay.classList.add('pointer-events-auto', 'opacity-100');
        adminSidebarToggle.setAttribute('aria-expanded', 'true');
    }

    function closeAdminSidebar() {
        if (!adminSidebar || !adminSidebarOverlay || !adminSidebarToggle) return;
        adminSidebar.classList.remove('is-open');
        adminSidebarOverlay.classList.add('pointer-events-none', 'opacity-0');
        adminSidebarOverlay.classList.remove('pointer-events-auto', 'opacity-100');
        adminSidebarToggle.setAttribute('aria-expanded', 'false');
    }

    if (adminSidebarToggle) {
        adminSidebarToggle.addEventListener('click', function () {
            adminSidebar?.classList.contains('is-open') ? closeAdminSidebar() : openAdminSidebar();
        });
    }

    if (adminSidebarOverlay) {
        adminSidebarOverlay.addEventListener('click', closeAdminSidebar);
    }

    window.addEventListener('resize', function () {
        if (window.innerWidth > 900) {
            closeAdminSidebar();
        }
    });

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            if (window.innerWidth <= 900 && this.dataset.tab !== 'infrastruktur') {
                closeAdminSidebar();
            }
        });
    });

    document.querySelectorAll('.subtab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            if (window.innerWidth <= 900) {
                closeAdminSidebar();
            }
        });
    });

    const toast = document.getElementById('toastSuccess');

    if (toast) {
        setTimeout(() => {
            toast.classList.add('translate-x-[120%]', 'opacity-0');

            setTimeout(() => {
                toast.remove();
            }, 400);
        }, 4000);
    }
</script>
</body>
</html>