@extends('layouts.app')

@section('content')
<div class="min-h-screen pt-24 pb-12 flex flex-col justify-center bg-[#f0f2f5]">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <div class="flex items-center justify-center gap-2 mb-2">
                <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.22.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                <span class="text-2xl font-bold text-[#1e2a78] tracking-tighter">Jatijajar</span>
            </div>
            <p class="text-[10px] font-bold text-slate-400 tracking-widest uppercase mb-6">Tiket Online</p>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">Buat Akun Baru</h2>
            <p class="mt-2 text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Masuk di sini
                </a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white/80 backdrop-blur-xl py-8 px-10 shadow-2xl shadow-blue-100/50 sm:rounded-3xl border border-white/50">
                <form class="space-y-5" action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                        <div class="mt-1">
                            <input id="name" name="name" type="text" required 
                                class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all"
                                value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700">Alamat Email</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" required 
                                class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all"
                                value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" required 
                                class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                        <div class="mt-1">
                            <input id="password_confirmation" name="password_confirmation" type="password" required 
                                class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all">
                        </div>
                    </div>

                    <div class="text-xs text-gray-500 leading-relaxed">
                        Dengan mendaftar, Anda menyetujui <a href="#" class="text-blue-600 underline">Syarat & Ketentuan</a> serta <a href="#" class="text-blue-600 underline">Kebijakan Privasi</a> kami.
                    </div>

                    <div>
                        <button type="submit" 
                            class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-lg text-sm font-bold text-white bg-[#1e2a78] hover:bg-[#151d54] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:scale-[1.02] active:scale-95">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
