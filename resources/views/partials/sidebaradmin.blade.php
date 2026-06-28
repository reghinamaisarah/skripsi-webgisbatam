<aside id="adminSidebar" class="flex h-full min-h-0 flex-col overflow-hidden border-r border-[#e5e7eb] bg-white max-[900px]:fixed max-[900px]:bottom-0 max-[900px]:left-0 max-[900px]:top-[56px] max-[900px]:z-[200] max-[900px]:h-[calc(100vh-56px)] max-[900px]:w-[250px] max-[900px]:-translate-x-full max-[900px]:shadow-[8px_0_24px_rgba(15,23,42,0.12)] max-[900px]:transition-transform max-[900px]:duration-200 [&.is-open]:translate-x-0">
    <div class="shrink-0 border-b border-[#e5e7eb] px-4 pb-[0.6rem] pt-[0.9rem]">
        <div class="text-[0.78rem] font-semibold tracking-[0.06em] text-[#6b7280]">
            Menu Admin
        </div>
    </div>

    <nav class="min-h-0 flex-1 overflow-y-auto px-2 pb-4 pt-2">
        <div class="mt-[0.4rem]">
            <div class="block px-[0.65rem] pb-[0.3rem] pt-2 text-[0.68rem] font-semibold uppercase tracking-[0.08em] text-[#6b7280]">
                Data
            </div>

            <button
                type="button"
                class="tab-btn flex w-full cursor-pointer items-center justify-between gap-2 rounded-[7px] border-0 bg-[#eef2f7] px-[0.65rem] py-2 text-left text-[0.8rem] font-medium text-[#233d59] transition-colors duration-150 hover:bg-[#f3f4f6]"
                data-tab="kawasan"
            >
                <span class="tb-left flex min-w-0 items-center gap-[0.55rem]">
                    <svg class="h-[15px] w-[15px] shrink-0 fill-none stroke-current stroke-[1.75]" viewBox="0 0 24 24">
                        <path d="M12 16h.01"/>
                        <path d="M16 16h.01"/>
                        <path d="M3 19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.5a.5.5 0 0 0-.769-.422l-4.462 2.844A.5.5 0 0 1 15 10.5v-2a.5.5 0 0 0-.769-.422L9.77 10.922A.5.5 0 0 1 9 10.5V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2z"/>
                        <path d="M8 16h.01"/>
                    </svg>

                    <span class="truncate">
                        Data Kawasan Industri
                    </span>
                </span>
            </button>

            <button
                type="button"
                class="tab-btn mt-[0.15rem] flex w-full cursor-pointer items-center justify-between gap-2 rounded-[7px] border-0 bg-transparent px-[0.65rem] py-2 text-left text-[0.8rem] font-medium text-[#1f2937] transition-colors duration-150 hover:bg-[#f3f4f6]"
                data-tab="infrastruktur"
                data-collapsible="true"
            >
                <span class="tb-left flex min-w-0 items-center gap-[0.55rem]">
                    <svg class="h-[15px] w-[15px] shrink-0 fill-none stroke-current stroke-[1.75]" viewBox="0 0 24 24">
                        <path d="M2 22h20"/>
                        <path d="M6 22V10l6-4 6 4v12"/>
                        <path d="M10 22v-6h4v6"/>
                    </svg>

                    <span class="truncate">
                        Data Infrastruktur
                    </span>
                </span>

                <svg id="chev-infrastruktur" class="chev h-[13px] w-[13px] shrink-0 fill-none stroke-current stroke-[1.75] opacity-70 transition-transform duration-200" viewBox="0 0 24 24">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </button>

            <div id="subnav-infrastruktur" class="subnav ml-[0.6rem] mt-[0.15rem] hidden border-l border-[#e5e7eb] pb-[0.25rem] pl-[0.6rem]">
                <button
                    type="button"
                    class="subtab-btn flex w-full cursor-pointer items-center gap-2 rounded-md border-0 bg-[#eef2f7] px-[0.55rem] py-[0.4rem] text-left text-[0.76rem] font-medium text-[#233d59] transition-colors duration-150 hover:bg-[#f3f4f6]"
                    data-subtab="pelabuhan"
                >
                    <span class="dot h-1.5 w-1.5 shrink-0 rounded-full bg-[#233d59]"></span>
                    <span>Pelabuhan</span>
                </button>

                <button
                    type="button"
                    class="subtab-btn flex w-full cursor-pointer items-center gap-2 rounded-md border-0 bg-transparent px-[0.55rem] py-[0.4rem] text-left text-[0.76rem] text-[#1f2937] transition-colors duration-150 hover:bg-[#f3f4f6]"
                    data-subtab="bandara"
                >
                    <span class="dot h-1.5 w-1.5 shrink-0 rounded-full bg-[#cbd5e1]"></span>
                    <span>Bandara</span>
                </button>

                <button
                    type="button"
                    class="subtab-btn flex w-full cursor-pointer items-center gap-2 rounded-md border-0 bg-transparent px-[0.55rem] py-[0.4rem] text-left text-[0.76rem] text-[#1f2937] transition-colors duration-150 hover:bg-[#f3f4f6]"
                    data-subtab="jalan"
                >
                    <span class="dot h-1.5 w-1.5 shrink-0 rounded-full bg-[#cbd5e1]"></span>
                    <span>Jalan</span>
                </button>
            </div>
        </div>
    </nav>

    <div class="mb-[18px] shrink-0 border-t border-[#e5e7eb] bg-white p-[0.6rem]">
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button
                type="submit"
                class="flex w-full cursor-pointer items-center justify-center gap-[0.45rem] rounded-lg border border-[#fecaca] bg-white px-3 py-[0.55rem] text-[0.8rem] font-medium text-[#b91c1c] no-underline transition-colors duration-150 hover:bg-[#fef2f2]"
            >
                <svg class="h-[14px] w-[14px] shrink-0 fill-none stroke-current stroke-[1.75]" viewBox="0 0 24 24">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>

                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
