<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Katalog Menu - KantinPedia</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;1,9..144,500&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ivory: '#FBF3E7',
                        cream: '#FFFCF7',
                        pinksoft: '#F6D3DC',
                        pinkmid: '#EDB4C4',
                        pinkdeep: '#E29AAF',
                        pinkdeeper: '#CF7D95',
                        ink: '#4A3733',
                        muted: '#9C8880',
                    },
                    fontFamily: {
                        display: ['Fraunces', 'serif'],
                        body: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        @page {
            size: A4;
            margin: 15mm 14mm;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: #ffffff !important;
            }

            .print-card {
                break-inside: avoid;
                box-shadow: none !important;
            }

            .print-page {
                max-width: 100% !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-ivory text-ink font-body antialiased">

    {{-- ===== TOOLBAR (tidak ikut tercetak) ===== --}}
    <div class="no-print sticky top-0 z-10 bg-cream/90 backdrop-blur-sm border-b border-pinksoft">
        <div class="max-w-3xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm text-ink/70 hover:text-pinkdeeper transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Dashboard
            </a>

            <button type="button" onclick="window.print()"
                class="inline-flex items-center gap-2 rounded-xl bg-pinkdeep hover:bg-pinkdeeper text-white text-sm font-medium px-5 py-2.5 transition-colors shadow-sm shadow-pinkdeep/30">
                <i data-lucide="printer" class="w-4 h-4"></i>
                Cetak Halaman Ini
            </button>
        </div>
    </div>

    {{-- ===== ISI KATALOG (yang tercetak) ===== --}}
    <div class="print-page max-w-3xl mx-auto px-6 py-10">

        <div class="text-center mb-8 pb-6 border-b-2 border-pinkdeep/40">
            <h1 class="font-display text-3xl text-ink mb-1">KantinPedia — Kantin Litaren</h1>
            <p class="text-sm text-muted">Daftar Menu &amp; Harga per Stan</p>
            <p class="text-xs text-muted mt-1">Dicetak pada {{ $printedAt->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>

        @if ($menusByStan->isEmpty())
            <p class="text-center text-muted py-16">Belum ada menu yang terdaftar untuk dicetak.</p>
        @else
            <div class="space-y-8">
                @foreach ($menusByStan as $stanName => $menus)
                    <div class="print-card border border-pinksoft rounded-2xl overflow-hidden">
                        <div class="bg-pinksoft/50 px-5 py-3">
                            <h2 class="font-display text-lg text-ink">{{ $stanName }}</h2>
                        </div>

                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-ink/50 border-b border-pinksoft">
                                    <th class="py-2 px-5 font-medium w-1/2">Nama Menu</th>
                                    <th class="py-2 px-5 font-medium">Kategori</th>
                                    <th class="py-2 px-5 font-medium text-right">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menus as $menu)
                                    <tr class="border-b border-pinksoft/50 last:border-0">
                                        <td class="py-2.5 px-5 text-ink">
                                            {{ $menu->name }}
                                            @if ($menu->badge)
                                                <span class="ml-1.5 text-[10px] text-pinkdeeper border border-pinkmid rounded-full px-2 py-0.5">
                                                    {{ $menu->badge }}
                                                </span>
                                            @endif
                                            @unless ($menu->is_available)
                                                <span class="ml-1.5 text-[10px] text-gray-500 border border-gray-300 rounded-full px-2 py-0.5">
                                                    Habis
                                                </span>
                                            @endunless
                                        </td>
                                        <td class="py-2.5 px-5 text-ink/60">{{ $menu->category }}</td>
                                        <td class="py-2.5 px-5 text-right text-ink font-medium">
                                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        @endif

        <p class="text-center text-xs text-muted mt-10">
            Harga dapat berubah sewaktu-waktu. Silakan konfirmasi langsung ke masing-masing stan.
        </p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>