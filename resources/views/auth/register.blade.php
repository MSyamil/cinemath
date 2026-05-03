@extends('layouts.app')

@section('bg_class', 'bg-[#0a0a0a]')
@section('hide_overlay', false)

@section('content')
<div class="min-h-screen w-full flex items-center justify-center p-4">
    <div class="relative w-full max-w-md">
        <!-- Glow Effect -->
        <div class="absolute -inset-0.5 bg-gradient-to-r from-[#E50914]/50 to-red-900/50 rounded-2xl blur opacity-30"></div>
        
        <!-- Register Card -->
        <div class="relative bg-[#141414]/80 backdrop-blur-xl border border-white/10 rounded-2xl p-8 sm:p-10 shadow-2xl">
            
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white tracking-tight mb-2">Create Account</h1>
                <p class="text-gray-400 text-sm">Join to personalize your movie recommendations</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-300 mb-2">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#E50914]/50 focus:border-transparent transition-all">
                    @error('username')
                        <p class="mt-2 text-sm text-[#E50914]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <input id="password" type="password" name="password" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#E50914]/50 focus:border-transparent transition-all">
                    @error('password')
                        <p class="mt-2 text-sm text-[#E50914]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#E50914]/50 focus:border-transparent transition-all">
                </div>

                <div class="pt-2">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-[#E50914] to-red-700 hover:from-red-600 hover:to-red-800 text-white font-medium py-3 px-4 rounded-xl shadow-[0_0_15px_rgba(229,9,20,0.3)] transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]">
                        Sign Up
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <p class="text-gray-400 text-sm">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-white hover:text-[#E50914] font-medium transition-colors">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
