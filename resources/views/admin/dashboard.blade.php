@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 pb-20">

    <!-- Top Navigation Bar Admin: Bersih & Ringkas -->
    <header class="bg-white p-4 sm:p-5 rounded-3xl border border-pink-100 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-pink-100 text-rose-500 flex items-center justify-center font-bold">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            </div>
            <div>
                <h1 class="text-base sm:text-lg font-bold text-slate-800">Panel Pengelola Kantin Litaren</h1>
                <p class="text-xs text-slate-400">Atur ketersediaan menu, nomor kontak WhatsApp, dan informasi kantin</p>
            </div>
        </div>

        <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end">
            <!-- Tombol Pratinjau Web Siswa -->
            <a href="{{ route('home') }}" class="px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition inline-flex items-center gap-1.5 shadow-sm">
                <i data-lucide="external-link" class="w-4 h-4 text-slate-500"></i>
                <span>Lihat Web Siswa</span>
            </a>

            <!-- Tombol Keluar (Logout) -->
            <form method="POST" action="{{ route('logout') }}" class="inline m-0">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-2xl bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold transition inline-flex items-center gap-1.5 shadow-sm">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </header>

    <!-- Notifikasi Alert Sukses / Error -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-2.5 shadow-sm">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-center gap-2.5 shadow-sm">
            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-500 shrink-0"></i>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <!-- Form Section: 2 Kolom (Pengaturan Info & Tambah Menu) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Kolom 1: Pengaturan Informasi Kantin & Kontak Pengelola -->
        <div class="bg-white p-5 rounded-3xl border border-pink-100 shadow-sm space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                <i data-lucide="settings" class="w-4 h-4 text-rose-500"></i>
                <h2 class="text-sm font-bold text-slate-800">Pengaturan Utama Kantin</h2>
            </div>

            <form method="POST" action="{{ route('admin.information.update') }}" class="space-y-4">
                @csrf
                <!-- Nomor WhatsApp Cadangan Pengelola -->
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-slate-600">Nomor WA Cadangan / Pengelola</label>
                    <div class="relative">
                        <i data-lucide="phone" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="text" 
                            name="contact" 
                            value="{{ old('contact', $contact->value ?? $contact) }}" 
                            placeholder="Contoh: 081234567890" 
                            class="w-full pl-9 pr-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300"
                        >
                    </div>
                    <p class="text-[10px] text-slate-400">Digunakan jika stan terkait belum mengisi nomor WhatsApp pribadinya.</p>
                </div>

                <!-- Jam Operasional -->
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-slate-600">Jam Operasional Kantin</label>
                    <div class="relative">
                        <i data-lucide="clock" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="text" 
                            name="operational_hours" 
                            value="{{ old('operational_hours', $operationalHours->value ?? $operationalHours) }}" 
                            placeholder="07:00 - 14:30" 
                            class="w-full pl-9 pr-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300"
                        >
                    </div>
                </div>

                <!-- Pengumuman Kantin -->
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-slate-600">Teks Pengumuman</label>
                    <textarea 
                        name="announcement" 
                        rows="3" 
                        placeholder="Contoh: Hari ini menu Soto Ayam Litaren diskon Rp 2.000!" 
                        class="w-full p-3 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300"
                    >{{ old('announcement', $announcement->value ?? $announcement) }}</textarea>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-semibold transition flex items-center justify-center gap-1.5 shadow-sm">
                    <i data-lucide="save" class="w-3.5 h-3.5"></i>
                    <span>Simpan Pengaturan</span>
                </button>
            </form>
        </div>

        <!-- Kolom 2: Form Tambah Menu Baru -->
        <div class="lg:col-span-2 bg-white p-5 rounded-3xl border border-pink-100 shadow-sm space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                <i data-lucide="plus-circle" class="w-4 h-4 text-rose-500"></i>
                <h2 class="text-sm font-bold text-slate-800">Tambah Jajanan Baru</h2>
            </div>

            <form method="POST" action="{{ route('admin.menus.store') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-slate-600">Nama Menu</label>
                        <input type="text" name="name" required placeholder="Contoh: Nasi Uduk Litaren" class="w-full px-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-slate-600">Kategori</label>
                        <select name="category" required class="w-full px-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-rose-300 cursor-pointer">
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Camilan">Camilan</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-slate-600">Nama Stan</label>
                        <input type="text" name="stan_name" required placeholder="Contoh: Stan Bu Ani 01" class="w-full px-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-slate-600">Nomor WhatsApp Stan (Opsional)</label>
                        <input type="text" name="stan_phone" placeholder="Contoh: 085712345678" class="w-full px-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-slate-600">Harga (Rupiah)</label>
                        <input type="number" name="price" required min="0" placeholder="Contoh: 8000" class="w-full px-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-slate-600">Badge Karakteristik (Opsional)</label>
                        <input type="text" name="badge" placeholder="Contoh: Pedas / Best Seller / Segar" class="w-full px-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300">
                    </div>

                    <div class="space-y-1 sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600">Foto Menu (Opsional)</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-2 py-1.5 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:bg-pink-100 file:text-rose-700 hover:file:bg-pink-200">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-slate-600">Deskripsi Singkat</label>
                    <input type="text" name="description" placeholder="Deskripsi porsi atau rasa menu..." class="w-full px-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300">
                </div>

                <div class="text-right pt-1">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold transition inline-flex items-center gap-1.5 shadow-sm">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>Tambahkan ke Katalog</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Daftar Menu Terdaftar -->
    <div class="bg-white p-5 rounded-3xl border border-pink-100 shadow-sm space-y-4">
        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <i data-lucide="utensils" class="w-4 h-4 text-rose-500"></i>
                <h2 class="text-sm font-bold text-slate-800">Daftar Menu Kantin Saat Ini ({{ count($menus) }})</h2>
            </div>
            <span class="text-xs text-slate-400">Klik status untuk ubah ketersediaan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-3">Menu</th>
                        <th class="py-3 px-3">Stan & WA</th>
                        <th class="py-3 px-3">Harga</th>
                        <th class="py-3 px-3">Badge</th>
                        <th class="py-3 px-3 text-center">Status Stok</th>
                        <th class="py-3 px-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (count($menus) > 0): ?>
                        <?php foreach ($menus as$menu): ?>
                            <tr class="hover:bg-pink-50/30 transition">
                                <td class="py-3 px-3">
                                    <div class="flex items-center gap-3">
                                        <?php if ($menu->image): ?>
                                            <img src="{{ asset('storage/'.$menu->image) }}" class="w-9 h-9 rounded-xl object-cover border border-slate-100 shadow-sm" alt="{{ $menu->name }}">
                                        <?php else: ?>
                                            <div class="w-9 h-9 rounded-xl bg-pink-50 text-rose-400 flex items-center justify-center font-bold">
                                                <i data-lucide="utensils" class="w-4 h-4"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="font-bold text-slate-800">{{ $menu->name }}</div>
                                            <div class="text-[11px] text-slate-400 line-clamp-1">{{ $menu->description ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="font-medium text-slate-700">{{ $menu->stan_name }}</div>
                                    <div class="text-[11px] text-emerald-600 flex items-center gap-1">
                                        <i data-lucide="phone" class="w-3 h-3"></i>
                                        <span>{{ $menu->stan_phone ? $menu->stan_phone : 'Mengikuti WA Pengelola' }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-3 font-bold text-slate-800">
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-3">
                                    <?php if (!empty($menu->badge)): ?>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-pink-50 text-rose-600 border border-pink-200">
                                            {{ $menu->badge }}
                                        </span>
                                    <?php else: ?>
                                        <span class="text-slate-300">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <form method="POST" action="{{ route('admin.menus.toggle', $menu->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <?php if ($menu->is_available): ?>
                                            <button type="submit" class="px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition shadow-sm inline-flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                <span>Tersedia</span>
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" class="px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-500 border border-slate-200 hover:bg-slate-200 transition shadow-sm inline-flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                <span>Habis</span>
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <!-- Tombol Edit Menu -->
                                        <button 
                                            type="button" 
                                            data-id="{{ $menu->id }}"
                                            data-name="{{ $menu->name }}"
                                            data-category="{{ $menu->category }}"
                                            data-stan="{{ $menu->stan_name }}"
                                            data-phone="{{ $menu->stan_phone ?? '' }}"
                                            data-price="{{ $menu->price }}"
                                            data-badge="{{ $menu->badge ?? '' }}"
                                            data-desc="{{ $menu->description ?? '' }}"
                                            onclick="openEditModal(this)" 
                                            class="p-1.5 text-slate-400 hover:text-amber-500 transition rounded-lg hover:bg-amber-50" 
                                            title="Edit Menu"
                                        >
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </button>

                                        <!-- Tombol Hapus Menu -->
                                        <form method="POST" action="{{ route('admin.menus.destroy', $menu->id) }}" onsubmit="return confirm('Yakin ingin menghapus menu {{ $menu->name }}?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-500 transition rounded-lg hover:bg-rose-50" title="Hapus Menu">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                Belum ada menu yang didaftarkan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Pop-up Modal Edit Menu -->
<div id="editMenuModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm transition-opacity duration-200">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-pink-100 max-h-[90vh] overflow-y-auto animate-in fade-in zoom-in-95 duration-150 space-y-4">
        
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center font-bold">
                    <i data-lucide="pencil" class="w-4 h-4"></i>
                </div>
                <h3 class="font-bold text-slate-800 text-base">Edit Rincian Menu</h3>
            </div>
            <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form id="editMenuForm" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-slate-600">Nama Menu</label>
                    <input type="text" name="name" id="edit_name" required class="w-full px-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-slate-600">Kategori</label>
                    <select name="category" id="edit_category" required class="w-full px-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-rose-300 cursor-pointer">
                        <option value="Makanan">Makanan</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Camilan">Camilan</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-slate-600">Nama Stan</label>
                    <input type="text" name="stan_name" id="edit_stan_name" required class="w-full px-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-slate-600">Nomor WhatsApp Stan</label>
                    <input type="text" name="stan_phone" id="edit_stan_phone" placeholder="Contoh: 085712345678" class="w-full px-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-slate-600">Harga (Rupiah)</label>
                    <input type="number" name="price" id="edit_price" required min="0" class="w-full px-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-slate-600">Badge Karakteristik</label>
                    <input type="text" name="badge" id="edit_badge" placeholder="Pedas / Best Seller / Segar" class="w-full px-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300">
                </div>

                <div class="space-y-1 sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600">Ganti Foto (Biarkan kosong jika tidak diubah)</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-2 py-1.5 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:bg-pink-100 file:text-rose-700 hover:file:bg-pink-200">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-600">Deskripsi Singkat</label>
                <input type="text" name="description" id="edit_description" class="w-full px-3 py-2 rounded-xl bg-[#FAF8F5] border border-pink-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300">
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold transition shadow-sm flex items-center gap-1.5">
                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });

    function openEditModal(btn) {
        const id = btn.dataset.id;
        document.getElementById('editMenuForm').action = `/admin/menus/${id}`;

        document.getElementById('edit_name').value = btn.dataset.name || '';
        document.getElementById('edit_category').value = btn.dataset.category || 'Makanan';
        document.getElementById('edit_stan_name').value = btn.dataset.stan || '';
        document.getElementById('edit_stan_phone').value = btn.dataset.phone || '';
        document.getElementById('edit_price').value = btn.dataset.price || 0;
        document.getElementById('edit_badge').value = btn.dataset.badge || '';
        document.getElementById('edit_description').value = btn.dataset.desc || '';

        document.getElementById('editMenuModal').classList.remove('hidden');
        lucide.createIcons();
    }

    function closeEditModal() {
        document.getElementById('editMenuModal').classList.add('hidden');
    }
</script>
@endsection