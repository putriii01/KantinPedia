@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-10 px-4">
    <div class="max-w-md w-full bg-white rounded-3xl border border-pink-100 shadow-xl p-8 space-y-6">
        
        <!-- Header Form -->
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-pink-50 text-rose-500 flex items-center justify-center mx-auto border border-pink-100 shadow-sm">
                <i data-lucide="lock" class="w-6 h-6"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Akses Pengelola</h2>
            <p class="text-xs text-slate-500">Masuk untuk mengelola katalog menu Kantin Litaren</p>
        </div>

        <!-- Alert Error Validasi -->
        @if ($errors->any())
            <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Form Login -->
        <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
            @csrf

            <!-- Input Email -->
            <div class="space-y-1">
                <label for="email" class="block text-xs font-semibold text-slate-600">Email Pengelola</label>
                <div class="relative">
                    <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        placeholder="admin@litaren.com" 
                        class="w-full pl-10 pr-4 py-2.5 rounded-2xl bg-[#FAF8F5] border border-pink-200/80 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300 focus:bg-white transition"
                    >
                </div>
            </div>

            <!-- Input Password -->
            <div class="space-y-1">
                <label for="password" class="block text-xs font-semibold text-slate-600">Password</label>
                <div class="relative">
                    <i data-lucide="key-round" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required 
                        placeholder="••••••••" 
                        class="w-full pl-10 pr-4 py-2.5 rounded-2xl bg-[#FAF8F5] border border-pink-200/80 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-300 focus:bg-white transition"
                    >
                </div>
            </div>

            <!-- Tombol Submit -->
            <button 
                type="submit" 
                class="w-full py-3 px-4 rounded-2xl bg-rose-500 hover:bg-rose-600 active:scale-[0.99] text-white text-sm font-semibold transition duration-150 shadow-md hover:shadow-lg flex items-center justify-center gap-2"
            >
                <i data-lucide="log-in" class="w-4 h-4"></i>
                <span>Masuk ke Dashboard</span>
            </button>
        </form>

        <!-- Link Kembali -->
        <div class="text-center pt-2 border-t border-slate-100">
            <a href="{{ route('home') }}" class="text-xs text-slate-400 hover:text-rose-500 transition inline-flex items-center gap-1">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Kembali ke Katalog Siswa</span>
            </a>
        </div>
    </div>
</div>
@endsection