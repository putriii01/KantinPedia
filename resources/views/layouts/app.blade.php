<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'KantinPedia - Kantin Litaren') }}</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        ivory: '#FAF8F5',
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#FAF8F5] text-slate-800 font-sans antialiased min-h-screen flex flex-col justify-between">

    <!-- Navbar Bersih Khusus Siswa (Tanpa Tombol Login Admin) -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-40 border-b border-pink-100 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-slate-800 font-extrabold text-lg sm:text-xl tracking-tight">
                <div class="w-9 h-9 rounded-2xl bg-rose-500 text-white flex items-center justify-center shadow-sm">
                    <i data-lucide="utensils" class="w-5 h-5"></i>
                </div>
                <span>Kantin<span class="text-rose-500 font-serif italic">Litaren</span></span>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="px-3.5 py-1.5 rounded-full text-xs font-semibold text-slate-600 hover:text-rose-600 hover:bg-pink-50/70 transition flex items-center gap-1.5">
                    <i data-lucide="store" class="w-4 h-4 text-rose-400"></i>
                    <span>Katalog Menu</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Konten Halaman -->
    <main class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 py-6">
        @yield('content')
    </main>

    <!-- Footer Ramah Pengguna dengan Akses Pengelola Samar di Bawah -->
    <footer class="bg-white border-t border-pink-100 py-6 text-center text-xs text-slate-500 space-y-2 mt-auto">
        <p class="font-medium text-slate-600">KantinPedia &mdash; dari kantin, untuk warga Litaren.</p>
        <p>&copy; 2026 Kantin Litaren. Dibuat dengan senang hati.</p>
        
        <div class="pt-1">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-[11px] text-slate-400 hover:text-rose-500 transition py-1 px-2.5 rounded-lg hover:bg-slate-50">
                <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                <span>Akses Pengelola</span>
            </a>
        </div>
    </footer>

    <!-- Inisialisasi SVG Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>