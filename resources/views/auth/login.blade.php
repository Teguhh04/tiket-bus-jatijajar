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
            <h2 class="mt-6 text-3xl font-bold text-gray-900">Selamat Datang Kembali</h2>
            <p class="mt-2 text-sm text-gray-600">
                Atau
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    buat akun baru sekarang
                </a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white/80 backdrop-blur-xl py-8 px-10 shadow-2xl shadow-blue-100/50 sm:rounded-3xl border border-white/50">
                <form class="space-y-6" action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all"
                                value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                        <div class="mt-1 relative">
                            <input id="password" name="password" type="password" autocomplete="current-password" required 
                                class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" 
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded-lg">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Lupa password?</a>
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                            class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-lg text-sm font-bold text-white bg-[#1e2a78] hover:bg-[#151d54] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:scale-[1.02] active:scale-95">
                            Masuk Ke Akun
                        </button>
                    </div>
                </form>

                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500 font-medium">Atau lanjutkan dengan</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <button class="w-full inline-flex justify-center py-3 px-4 border border-gray-200 rounded-2xl bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 transition-all">
                            <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="currentColor" d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/></svg>
                        </button>
                        <button class="w-full inline-flex justify-center py-3 px-4 border border-gray-200 rounded-2xl bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 transition-all">
                            <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="currentColor" d="M16.365,1.43c-1.14,0-2.31,0.52-3.12,1.33c-0.19,0.19-0.34,0.39-0.47,0.61c-0.13-0.22-0.28-0.42-0.47-0.61c-0.81-0.81-1.98-1.33-3.12-1.33c-2.45,0-4.41,1.96-4.41,4.41c0,0.88,0.26,1.72,0.74,2.44L12,18.5l6.53-10.62c0.48-0.72,0.74-1.56,0.74-2.44C19.27,3.39,17.31,1.43,16.365,1.43z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
