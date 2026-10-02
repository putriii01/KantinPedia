@extends('layouts.app')

@section('content')
<div class="space-y-8 pb-24">

    <!-- Header & Hero Section -->
    <header class="text-center max-w-2xl mx-auto pt-4 space-y-4">
        <!-- Status Jam Operasional Otomatis (Real-Time JS) -->
        <div class="inline-flex items-center justify-center">
            <div id="operationalBadge" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-medium border transition-all duration-300 bg-white/80 backdrop-blur shadow-sm border-slate-200 text-slate-600">
                <span id="operationalDot" class="w-2 h-2 rounded-full bg-slate-400"></span>
                <span id="operationalLabel">Memeriksa jam operasional...</span>
            </div>
        </div>

        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-800 tracking-tight">
            Katalog Jajanan <span class="text-rose-500 font-serif italic">Kantin Litaren</span>
        </h1>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
            Temukan menu sarapan, makan siang, dan cemilan favoritmu saat jam istirahat dengan mudah, cepat, dan pas di kantong.
        </p>

        <!-- Papan Pengumuman (Jika Ada) -->
        @if(!empty($announcement->value))
            <div class="mt-4 p-3.5 rounded-2xl bg-pink-50/80 border border-pink-200/70 text-slate-700 text-xs sm:text-sm flex items-start gap-2.5 text-left max-w-lg mx-auto shadow-sm">
                <i data-lucide="info" class="w-4 h-4 text-rose-500 shrink-0 mt-0.5"></i>
                <div class="flex-1">
                    <span class="font-semibold text-rose-700 block mb-0.5">Pengumuman Kantin:</span>
                    <p class="leading-relaxed">{{ $announcement->value }}</p>
                </div>
            </div>
        @endif
    </header>

    <!-- Toolbar: Search & Urutkan -->
    <section class="max-w-4xl mx-auto bg-white/90 backdrop-blur p-4 sm:p-5 rounded-3xl border border-pink-100 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <!-- Input Pencarian -->
            <div class="relative flex-1">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    id="searchInput" 
                    placeholder="Cari nasi uduk, es teh, stan..." 
                    class="w-full pl-10 pr-4 py-2.5 rounded-2xl bg-[#FAF8F5] border border-pink-200/80 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-300 focus:bg-white transition"
                >
            </div>

            <!-- Urutkan Harga -->
            <div class="relative sm:w-56 shrink-0">
                <i data-lucide="arrow-up-down" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <select 
                    id="sortSelect" 
                    class="w-full pl-10 pr-8 py-2.5 rounded-2xl bg-[#FAF8F5] border border-pink-200/80 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-rose-300 focus:bg-white transition appearance-none cursor-pointer"
                >
                    <option value="default">Urutan Default</option>
                    <option value="price-asc">Harga: Terendah ke Tertinggi</option>
                    <option value="price-desc">Harga: Tertinggi ke Terendah</option>
                </select>
            </div>
        </div>

        <!-- Filter Baris 1: Kategori Makanan -->
        <div class="flex flex-wrap items-center gap-2 pt-1 border-t border-slate-100">
            <span class="text-xs font-semibold text-slate-500 mr-1 flex items-center gap-1">
                <i data-lucide="utensils" class="w-3.5 h-3.5 text-rose-400"></i> Kategori:
            </span>
            <button type="button" class="category-btn active px-3.5 py-1.5 rounded-full text-xs font-medium transition" data-category="Semua">Semua</button>
            <button type="button" class="category-btn px-3.5 py-1.5 rounded-full text-xs font-medium transition" data-category="Makanan">Makanan</button>
            <button type="button" class="category-btn px-3.5 py-1.5 rounded-full text-xs font-medium transition" data-category="Minuman">Minuman</button>
            <button type="button" class="category-btn px-3.5 py-1.5 rounded-full text-xs font-medium transition" data-category="Camilan">Camilan</button>
        </div>

        <!-- Filter Baris 2: Budget Matcher (Pas Kantong) -->
        <div class="flex flex-wrap items-center gap-2 pt-1 border-t border-slate-100">
            <span class="text-xs font-semibold text-slate-500 mr-1 flex items-center gap-1">
                <i data-lucide="wallet" class="w-3.5 h-3.5 text-rose-400"></i> Budget:
            </span>
            <button type="button" class="budget-btn active px-3.5 py-1.5 rounded-full text-xs font-medium transition" data-budget="0">Semua</button>
            <button type="button" class="budget-btn px-3.5 py-1.5 rounded-full text-xs font-medium transition" data-budget="5000">≤ Rp 5.000</button>
            <button type="button" class="budget-btn px-3.5 py-1.5 rounded-full text-xs font-medium transition" data-budget="10000">≤ Rp 10.000</button>
            <button type="button" class="budget-btn px-3.5 py-1.5 rounded-full text-xs font-medium transition" data-budget="15000">≤ Rp 15.000</button>
        </div>

        <!-- Filter Baris 3: Filter Stan Penjual -->
        @php
            $stans = $menus->pluck('stan_name')->unique()->filter()->values();
        @endphp
        @if($stans->count() > 1)
        <div class="flex flex-wrap items-center gap-2 pt-1 border-t border-slate-100">
            <span class="text-xs font-semibold text-slate-500 mr-1 flex items-center gap-1">
                <i data-lucide="store" class="w-3.5 h-3.5 text-rose-400"></i> Stan:
            </span>
            <button type="button" class="stan-btn active px-3.5 py-1.5 rounded-full text-xs font-medium transition" data-stan="Semua">Semua Stan</button>
            @foreach($stans as $stan)
                <button type="button" class="stan-btn px-3.5 py-1.5 rounded-full text-xs font-medium transition" data-stan="{{ $stan }}">{{ $stan }}</button>
            @endforeach
        </div>
        @endif
    </section>

    <!-- Grid Katalog Menu -->
    <main class="max-w-6xl mx-auto">
        <div id="menuGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @forelse($menus as $menu)
                @php
                    $isAvailable = $menu->is_available;
                    $badgeLower = strtolower($menu->badge ?? '');
                    
                    $badgeColorClass = 'bg-slate-100 text-slate-700 border-slate-200';
                    if (str_contains($badgeLower, 'pedas')) {
                        $badgeColorClass = 'bg-rose-50 text-rose-700 border-rose-200';
                    } elseif (str_contains($badgeLower, 'manis')) {
                        $badgeColorClass = 'bg-amber-50 text-amber-700 border-amber-200';
                    } elseif (str_contains($badgeLower, 'best') || str_contains($badgeLower, 'laris') || str_contains($badgeLower, 'favorit')) {
                        $badgeColorClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                    } elseif (str_contains($badgeLower, 'siap') || str_contains($badgeLower, 'cepat')) {
                        $badgeColorClass = 'bg-sky-50 text-sky-700 border-sky-200';
                    }
                @endphp

                <article 
                    class="menu-card bg-white rounded-3xl border border-pink-100/80 shadow-sm hover:shadow-md hover:-translate-y-1 transition duration-200 flex flex-col overflow-hidden cursor-pointer group {{ !$isAvailable ? 'opacity-65' : '' }}"
                    data-id="{{ $menu->id }}"
                    data-name="{{ $menu->name }}"
                    data-category="{{ $menu->category }}"
                    data-stan="{{ $menu->stan_name }}"
                    data-phone="{{ $menu->stan_phone ?? '' }}"
                    data-location="{{ $menu->stan_name }} • Area Kantin Sekolah"
                    data-price="{{ $menu->price }}"
                    data-available="{{ $isAvailable ? '1' : '0' }}"
                    data-badge="{{ $menu->badge ?? '' }}"
                    data-desc="{{ $menu->description ?? 'Pilihan jajanan lezat dan higienis dari Kantin Litaren.' }}"
                    data-image="{{ $menu->image ? asset('storage/'.$menu->image) : '' }}"
                    onclick="openDetailModal(this)"
                >
                    <!-- Foto Menu & Badge Status -->
                    <div class="relative w-full h-44 bg-[#FAF8F5] overflow-hidden flex items-center justify-center">
                        @if($menu->image)
                            <img 
                                src="{{ asset('storage/'.$menu->image) }}" 
                                alt="{{ $menu->name }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300 {{ !$isAvailable ? 'grayscale' : '' }}"
                                loading="lazy"
                            >
                        @else
                            <div class="flex flex-col items-center justify-center text-slate-300 gap-1">
                                <i data-lucide="utensils" class="w-10 h-10"></i>
                                <span class="text-[11px] font-medium text-slate-400">Kantin Litaren</span>
                            </div>
                        @endif

                        <!-- Badge Habis -->
                        @if(!$isAvailable)
                            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[1px] flex items-center justify-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold tracking-wider bg-slate-800 text-white shadow">
                                    HABIS
                                </span>
                            </div>
                        @endif

                        <!-- Badge Karakteristik -->
                        @if(!empty($menu->badge) && $isAvailable)
                            <div class="absolute top-2.5 left-2.5">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold border shadow-sm {{ $badgeColorClass }}">
                                    {{ $menu->badge }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Informasi Menu -->
                    <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between text-xs text-slate-500">
                                <span class="inline-flex items-center gap-1 font-medium text-rose-600">
                                    <i data-lucide="store" class="w-3 h-3"></i>
                                    {{ $menu->stan_name }}
                                </span>
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px]">
                                    {{ $menu->category }}
                                </span>
                            </div>

                            <h3 class="font-bold text-slate-800 text-base leading-snug group-hover:text-rose-600 transition line-clamp-1">
                                {{ $menu->name }}
                            </h3>

                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $menu->description ?? 'Jajanan lezat dan segar untuk menemani waktu istirahat sekolah.' }}
                            </p>
                        </div>

                        <!-- Harga & Tombol Tambah Catatan -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-medium">Harga</span>
                                <span class="text-base font-extrabold text-slate-800">
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Tombol + Catat Jajan -->
                            @if($isAvailable)
                                <button 
                                    type="button" 
                                    class="add-note-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-pink-50 hover:bg-rose-500 text-rose-600 hover:text-white text-xs font-semibold border border-pink-200 hover:border-rose-500 transition duration-150 shadow-sm"
                                    onclick="event.stopPropagation(); addToNote('{{ $menu->id }}', '{{ addslashes($menu->name) }}', {{ $menu->price }}, '{{ addslashes($menu->stan_name) }}')"
                                    title="Tambahkan ke kalkulator catatan jajan"
                                >
                                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                    <span>Catat</span>
                                </button>
                            @else
                                <span class="text-[11px] font-medium text-slate-400 italic">Habis</span>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-pink-100">
                    <i data-lucide="utensils-crossed" class="w-12 h-12 text-rose-300 mx-auto mb-3"></i>
                    <h3 class="font-bold text-slate-700 text-lg">Belum Ada Menu Terdaftar</h3>
                    <p class="text-xs text-slate-500 mt-1">Pengelola kantin sedang menyiapkan menu lezat untuk hari ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="hidden py-16 px-4 text-center bg-white rounded-3xl border border-dashed border-pink-200 mt-4 max-w-lg mx-auto">
            <div class="w-14 h-14 rounded-full bg-pink-50 text-rose-400 flex items-center justify-center mx-auto mb-3">
                <i data-lucide="search-x" class="w-7 h-7"></i>
            </div>
            <h3 class="font-bold text-slate-800 text-base">Menu Tidak Ditemukan</h3>
            <p class="text-xs text-slate-500 mt-1.5 max-w-sm mx-auto leading-relaxed">
                Yah, jajanan yang kamu cari belum cocok dengan filter atau kata kunci saat ini. Coba sesuaikan budget atau pilih kategori lain ya!
            </p>
            <button 
                type="button" 
                onclick="resetAllFilters()" 
                class="mt-4 px-4 py-2 rounded-2xl bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold transition shadow-sm inline-flex items-center gap-1.5"
            >
                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                <span>Reset Semua Filter</span>
            </button>
        </div>
    </main>

    <!-- Modal Pop-up Detail Menu -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm transition-opacity duration-200">
        <div class="bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl border border-pink-100 animate-in fade-in zoom-in-95 duration-150">
            <!-- Header Modal & Tombol Close -->
            <div class="relative h-56 bg-[#FAF8F5] flex items-center justify-center overflow-hidden">
                <img id="modalImage" src="" alt="" class="w-full h-full object-cover hidden">
                <div id="modalImagePlaceholder" class="flex flex-col items-center justify-center text-slate-300 gap-1.5">
                    <i data-lucide="utensils" class="w-12 h-12"></i>
                    <span class="text-xs text-slate-400 font-medium">Kantin Litaren</span>
                </div>
                
                <button 
                    type="button" 
                    onclick="closeDetailModal()" 
                    class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 hover:bg-white text-slate-600 hover:text-slate-900 flex items-center justify-center shadow-md transition"
                >
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>

                <div id="modalStatusBadge" class="absolute bottom-3 left-3"></div>
            </div>

            <!-- Konten Modal -->
            <div class="p-6 space-y-4">
                <div>
                    <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                        <span id="modalStan" class="font-semibold text-rose-600 flex items-center gap-1"></span>
                        <span id="modalCategory" class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px]"></span>
                    </div>
                    <h2 id="modalTitle" class="text-xl font-bold text-slate-800"></h2>
                    <p id="modalLocation" class="text-[11px] text-slate-400 flex items-center gap-1 mt-0.5"></p>
                </div>

                <div class="p-3.5 rounded-2xl bg-[#FAF8F5] border border-pink-100/60">
                    <span class="text-[11px] font-semibold text-slate-400 block mb-1">Deskripsi Menu:</span>
                    <p id="modalDesc" class="text-xs sm:text-sm text-slate-600 leading-relaxed"></p>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-medium">Harga Menu</span>
                        <span id="modalPrice" class="text-xl font-extrabold text-slate-800"></span>
                    </div>

                    <!-- Tombol Aksi Modal -->
                    <div class="flex items-center gap-2">
                        <button 
                            type="button" 
                            id="modalAddNoteBtn" 
                            class="px-3.5 py-2.5 rounded-2xl bg-pink-50 hover:bg-pink-100 text-rose-600 text-xs font-semibold border border-pink-200 transition inline-flex items-center gap-1.5"
                        >
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            <span>Catat</span>
                        </button>

                        <a 
                            id="modalWaBtn" 
                            href="#" 
                            target="_blank" 
                            rel="noopener noreferrer" 
                            class="px-4 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm inline-flex items-center gap-1.5"
                        >
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            <span>Pesan via WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Bar "Catatan Jajan / Kalkulator Pesanan" -->
    <aside 
        id="cartFloatingBar" 
        class="fixed bottom-6 right-6 z-40 hidden transition-all duration-300"
    >
        <button 
            type="button" 
            onclick="openCartModal()" 
            class="group bg-slate-900/90 hover:bg-slate-900 text-white pl-4 pr-5 py-3 rounded-full shadow-xl hover:shadow-2xl border border-slate-700/50 backdrop-blur-md flex items-center gap-3 transition-transform hover:scale-105"
        >
            <div class="w-8 h-8 rounded-full bg-rose-500 flex items-center justify-center text-white shrink-0">
                <i data-lucide="clipboard-list" class="w-4 h-4"></i>
            </div>
            <div class="text-left">
                <div class="text-[11px] text-slate-300 font-medium">
                    <span id="cartCount">0</span> menu dicatat
                </div>
                <div id="cartTotal" class="text-sm font-extrabold text-white">
                    Rp 0
                </div>
            </div>
            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition"></i>
        </button>
    </aside>

    <!-- Modal Rincian Catatan Jajan -->
    <div id="cartModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-pink-100 flex flex-col max-h-[85vh] animate-in fade-in zoom-in-95 duration-150">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-xl bg-pink-100 text-rose-500 flex items-center justify-center">
                        <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-base">Catatan Titipan Jajan</h3>
                </div>
                <button type="button" onclick="closeCartModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- List Menu yang Dicatat -->
            <div id="cartItemsList" class="flex-1 overflow-y-auto py-3 space-y-2.5 my-2 divide-y divide-slate-100/80"></div>

            <!-- Footer & Aksi Catatan -->
            <div class="pt-3 border-t border-slate-100 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500">Total Uang yang Disiapkan:</span>
                    <span id="cartModalTotal" class="text-lg font-black text-rose-600">Rp 0</span>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <button 
                        type="button" 
                        onclick="clearCart()" 
                        class="px-3 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition flex items-center justify-center gap-1.5"
                    >
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>Kosongkan</span>
                    </button>

                    <button 
                        type="button" 
                        onclick="copyCartSummary()" 
                        class="px-3 py-2.5 rounded-2xl bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold transition shadow-sm flex items-center justify-center gap-1.5"
                    >
                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                        <span id="copyBtnText">Salin ke WA Kelas</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Melayang Back to Top -->
    <button 
        id="backToTopBtn" 
        type="button" 
        onclick="scrollToTop()" 
        class="fixed bottom-6 left-6 z-40 hidden w-10 h-10 rounded-full bg-white/90 hover:bg-white text-slate-600 hover:text-rose-600 shadow-md border border-pink-100 items-center justify-center transition duration-200 hover:-translate-y-0.5"
        title="Kembali ke atas"
    >
        <i data-lucide="chevron-up" class="w-5 h-5"></i>
    </button>

</div>

<style>
    .category-btn.active, .budget-btn.active, .stan-btn.active {
        background-color: #f43f5e !important;
        color: #ffffff !important;
        border-color: #f43f5e !important;
        box-shadow: 0 1px 2px 0 rgba(244, 63, 94, 0.25);
    }
    .category-btn, .budget-btn, .stan-btn {
        background-color: #FAF8F5;
        color: #64748b;
        border: 1px solid #fce7f3;
    }
    .category-btn:hover, .budget-btn:hover, .stan-btn:hover {
        background-color: #fdf2f8;
        color: #e11d48;
    }
</style>

<script>
    let activeCategory = 'Semua';
    let activeBudget = 0;
    let activeStan = 'Semua';
    let activeSearch = '';
    let activeSort = 'default';

    @php
        $rawNumber = !empty($contact->value) ? preg_replace('/[^0-9]/', '', $contact->value) : '6281234567890';
        if (str_starts_with($rawNumber, '0')) {
            $rawNumber = '62' . substr($rawNumber, 1);
        }
    @endphp
    const DEFAULT_WA_NUMBER = "{{ $rawNumber }}";

    let cart = JSON.parse(localStorage.getItem('kantinpedia_cart') || '[]');

    document.addEventListener('DOMContentLoaded', () => {
        initOperationalStatus();
        initFilterListeners();
        initBackToTop();
        updateCartUI();
        lucide.createIcons();
    });

    /* 1. Indikator Jam Buka Otomatis Real-Time (07:00 - 14:30) */
    function initOperationalStatus() {
        const updateStatus = () => {
            const now = new Date();
            const currentHour = now.getHours();
            const currentMinute = now.getMinutes();
            const currentTime = currentHour * 60 + currentMinute;

            const openTime = 7 * 60; // 07:00
            const closeTime = 14 * 60 + 30; // 14:30

            const badge = document.getElementById('operationalBadge');
            const dot = document.getElementById('operationalDot');
            const label = document.getElementById('operationalLabel');

            if (currentTime >= openTime && currentTime <= closeTime) {
                badge.className = "inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold border transition-all duration-300 bg-emerald-50 border-emerald-200 text-emerald-700 shadow-sm";
                dot.className = "w-2 h-2 rounded-full bg-emerald-500 animate-pulse";
                label.textContent = "Kantin Buka Sekarang (07:00 - 14:30)";
            } else {
                badge.className = "inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold border transition-all duration-300 bg-rose-50 border-rose-200 text-rose-700 shadow-sm";
                dot.className = "w-2 h-2 rounded-full bg-rose-400";
                label.textContent = "Kantin Sedang Tutup / Di Luar Jam Istirahat";
            }
        };

        updateStatus();
        setInterval(updateStatus, 60000);
    }

    /* 2. Logika Filter, Pencarian, & Sorting */
    function initFilterListeners() {
        document.getElementById('searchInput').addEventListener('input', (e) => {
            activeSearch = e.target.value.toLowerCase().trim();
            applyFilters();
        });

        document.getElementById('sortSelect').addEventListener('change', (e) => {
            activeSort = e.target.value;
            sortMenuCards();
            applyFilters();
        });

        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activeCategory = btn.dataset.category;
                applyFilters();
            });
        });

        document.querySelectorAll('.budget-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.budget-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activeBudget = parseInt(btn.dataset.budget) || 0;
                applyFilters();
            });
        });

        document.querySelectorAll('.stan-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.stan-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activeStan = btn.dataset.stan;
                applyFilters();
            });
        });
    }

    function applyFilters() {
        const cards = document.querySelectorAll('.menu-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.dataset.name.toLowerCase();
            const desc = card.dataset.desc.toLowerCase();
            const category = card.dataset.category;
            const stan = card.dataset.stan;
            const price = parseInt(card.dataset.price) || 0;

            const matchSearch = activeSearch === '' || name.includes(activeSearch) || desc.includes(activeSearch) || stan.toLowerCase().includes(activeSearch);
            const matchCategory = activeCategory === 'Semua' || category === activeCategory;
            const matchStan = activeStan === 'Semua' || stan === activeStan;
            const matchBudget = activeBudget === 0 || price <= activeBudget;

            if (matchSearch && matchCategory && matchStan && matchBudget) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const emptyState = document.getElementById('emptyState');
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }

    function sortMenuCards() {
        const grid = document.getElementById('menuGrid');
        const cards = Array.from(grid.querySelectorAll('.menu-card'));

        cards.sort((a, b) => {
            const priceA = parseInt(a.dataset.price) || 0;
            const priceB = parseInt(b.dataset.price) || 0;
            const idA = parseInt(a.dataset.id) || 0;
            const idB = parseInt(b.dataset.id) || 0;

            if (activeSort === 'price-asc') return priceA - priceB;
            if (activeSort === 'price-desc') return priceB - priceA;
            return idB - idA;
        });

        cards.forEach(card => grid.appendChild(card));
    }

    function resetAllFilters() {
        activeSearch = '';
        activeCategory = 'Semua';
        activeBudget = 0;
        activeStan = 'Semua';
        activeSort = 'default';

        document.getElementById('searchInput').value = '';
        document.getElementById('sortSelect').value = 'default';

        document.querySelectorAll('.category-btn').forEach(b => b.classList.toggle('active', b.dataset.category === 'Semua'));
        document.querySelectorAll('.budget-btn').forEach(b => b.classList.toggle('active', b.dataset.budget === '0'));
        document.querySelectorAll('.stan-btn').forEach(b => b.classList.toggle('active', b.dataset.stan === 'Semua'));

        sortMenuCards();
        applyFilters();
    }

    /* 3. Modal Detail Menu & WhatsApp Per-Stan Otomatis */
    let currentDetailItem = null;

    function openDetailModal(card) {
        currentDetailItem = {
            id: card.dataset.id,
            name: card.dataset.name,
            stan: card.dataset.stan,
            phone: card.dataset.phone,
            location: card.dataset.location,
            category: card.dataset.category,
            price: parseInt(card.dataset.price) || 0,
            desc: card.dataset.desc,
            image: card.dataset.image,
            available: card.dataset.available === '1'
        };

        const modal = document.getElementById('detailModal');
        const img = document.getElementById('modalImage');
        const imgPlaceholder = document.getElementById('modalImagePlaceholder');
        const statusBadge = document.getElementById('modalStatusBadge');

        if (currentDetailItem.image) {
            img.src = currentDetailItem.image;
            img.alt = currentDetailItem.name;
            img.classList.remove('hidden');
            imgPlaceholder.classList.add('hidden');
        } else {
            img.classList.add('hidden');
            imgPlaceholder.classList.remove('hidden');
        }

        document.getElementById('modalTitle').textContent = currentDetailItem.name;
        document.getElementById('modalStan').textContent = currentDetailItem.stan;
        document.getElementById('modalCategory').textContent = currentDetailItem.category;
        document.getElementById('modalLocation').innerHTML = `<i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i> ${currentDetailItem.location}`;
        document.getElementById('modalDesc').textContent = currentDetailItem.desc;
        document.getElementById('modalPrice').textContent = 'Rp ' + currentDetailItem.price.toLocaleString('id-ID');

        if (currentDetailItem.available) {
            statusBadge.innerHTML = `<span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500 text-white shadow">Tersedia</span>`;
            document.getElementById('modalAddNoteBtn').style.display = '';
            document.getElementById('modalWaBtn').style.display = '';
        } else {
            statusBadge.innerHTML = `<span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-700 text-white shadow">Habis</span>`;
            document.getElementById('modalAddNoteBtn').style.display = 'none';
            document.getElementById('modalWaBtn').style.display = 'none';
        }

        // Tentukan nomor WhatsApp target: jika stan punya nomor sendiri, pakai nomor stan; jika kosong, fallback ke nomor pengelola
        let targetPhone = currentDetailItem.phone && currentDetailItem.phone.trim() !== '' 
            ? currentDetailItem.phone 
            : DEFAULT_WA_NUMBER;

        targetPhone = targetPhone.replace(/[^0-9]/g, '');
        if (targetPhone.startsWith('0')) {
            targetPhone = '62' + targetPhone.substring(1);
        }

        const waText = encodeURIComponent(
            `Halo ${currentDetailItem.stan}, saya ingin memesan:\n• Menu: ${currentDetailItem.name}\n• Jumlah: 1 porsi\n• Total: Rp ${currentDetailItem.price.toLocaleString('id-ID')}\n\nApakah masih tersedia untuk diambil saat jam istirahat? Terima kasih!`
        );
        document.getElementById('modalWaBtn').href = `https://wa.me/${targetPhone}?text=${waText}`;

        document.getElementById('modalAddNoteBtn').onclick = () => {
            addToNote(currentDetailItem.id, currentDetailItem.name, currentDetailItem.price, currentDetailItem.stan);
            closeDetailModal();
        };

        modal.classList.remove('hidden');
        lucide.createIcons();
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    /* 4. Fitur Catatan Jajan & Kalkulator Pesanan */
    function addToNote(id, name, price, stan) {
        const existing = cart.find(item => item.id == id);
        if (existing) {
            existing.qty += 1;
        } else {
            cart.push({ id, name, price, stan, qty: 1 });
        }
        saveCart();
        updateCartUI();
    }

    function changeQty(id, delta) {
        const item = cart.find(i => i.id == id);
        if (!item) return;

        item.qty += delta;
        if (item.qty <= 0) {
            cart = cart.filter(i => i.id != id);
        }
        saveCart();
        updateCartUI();
    }

    function clearCart() {
        cart = [];
        saveCart();
        updateCartUI();
        closeCartModal();
    }

    function saveCart() {
        localStorage.setItem('kantinpedia_cart', JSON.stringify(cart));
    }

    function updateCartUI() {
        const bar = document.getElementById('cartFloatingBar');
        const countSpan = document.getElementById('cartCount');
        const totalSpan = document.getElementById('cartTotal');
        const modalTotal = document.getElementById('cartModalTotal');
        const listContainer = document.getElementById('cartItemsList');

        const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
        const totalPrice = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);

        if (totalItems > 0) {
            bar.classList.remove('hidden');
            countSpan.textContent = totalItems;
            totalSpan.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
            modalTotal.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
        } else {
            bar.classList.add('hidden');
            modalTotal.textContent = 'Rp 0';
        }

        if (cart.length === 0) {
            listContainer.innerHTML = `
                <div class="py-8 text-center text-slate-400">
                    <p class="text-xs">Belum ada jajanan yang dicatat.</p>
                </div>
            `;
        } else {
            listContainer.innerHTML = cart.map(item => `
                <div class="pt-2 pb-1 flex items-center justify-between text-xs">
                    <div class="flex-1 pr-2">
                        <div class="font-bold text-slate-800">${item.name}</div>
                        <div class="text-[11px] text-slate-400">${item.stan} • @Rp ${item.price.toLocaleString('id-ID')}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden bg-[#FAF8F5]">
                            <button type="button" onclick="changeQty('${item.id}', -1)" class="w-6 h-6 flex items-center justify-center text-slate-600 hover:bg-slate-200 font-bold">-</button>
                            <span class="w-7 text-center font-bold text-slate-700">${item.qty}</span>
                            <button type="button" onclick="changeQty('${item.id}', 1)" class="w-6 h-6 flex items-center justify-center text-slate-600 hover:bg-slate-200 font-bold">+</button>
                        </div>
                        <span class="font-bold text-slate-800 w-16 text-right">
                            Rp ${(item.price * item.qty).toLocaleString('id-ID')}
                        </span>
                    </div>
                </div>
            `).join('');
        }

        lucide.createIcons();
    }

    function openCartModal() {
        document.getElementById('cartModal').classList.remove('hidden');
    }

    function closeCartModal() {
        document.getElementById('cartModal').classList.add('hidden');
    }

    /* 5. Salin Ringkasan Titipan Jajan ke WhatsApp */
    function copyCartSummary() {
        if (cart.length === 0) return;

        let summaryText = "*TITIPAN JAJAN KANTIN LITAREN*\n";
        summaryText += "---------------------------------\n";
        let grandTotal = 0;

        cart.forEach((item, idx) => {
            const subtotal = item.price * item.qty;
            grandTotal += subtotal;
            summaryText += `${idx + 1}. ${item.name} (${item.qty}x) - Rp ${subtotal.toLocaleString('id-ID')}\n   [Stan: ${item.stan}]\n`;
        });

        summaryText += "---------------------------------\n";
        summaryText += `*TOTAL BIAYA: Rp ${grandTotal.toLocaleString('id-ID')}*\n`;
        summaryText += "_Tolong siapkan uang pas ya teman-teman!_";

        navigator.clipboard.writeText(summaryText).then(() => {
            const btnText = document.getElementById('copyBtnText');
            const oldText = btnText.textContent;
            btnText.textContent = "Berhasil Disalin!";
            setTimeout(() => {
                btnText.textContent = oldText;
            }, 2500);
        });
    }

    /* 6. Tombol Melayang Back to Top */
    function initBackToTop() {
        const topBtn = document.getElementById('backToTopBtn');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                topBtn.classList.remove('hidden');
                topBtn.classList.add('flex');
            } else {
                topBtn.classList.add('hidden');
                topBtn.classList.remove('flex');
            }
        });
    }

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endsection