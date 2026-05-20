@extends('layouts.app')

@section('bg_class', 'bg-[#0a0a0a]')
@section('hide_overlay', false)

@section('content')
<div class="min-h-screen w-full flex items-center justify-center p-4">
    <div class="relative w-full max-w-lg my-12">
        <!-- Glow Effect -->
        <div class="absolute -inset-0.5 bg-gradient-to-r from-[#E50914]/50 to-red-900/50 rounded-2xl blur opacity-30"></div>
        
        <!-- Form Card -->
        <div class="relative bg-[#141414]/80 backdrop-blur-xl border border-white/10 rounded-2xl p-8 sm:p-10 shadow-2xl">
            
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight">Add New User</h1>
                    <p class="text-gray-400 text-xs mt-0.5">Register a new user account manually</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
                @csrf

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-1.5">Name <span class="text-gray-500 font-normal">(Optional)</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Full Name"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#E50914]/50 focus:border-transparent transition-all">
                    @error('name')
                        <p class="mt-1.5 text-xs text-[#E50914]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username Field -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-300 mb-1.5">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required placeholder="username"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#E50914]/50 focus:border-transparent transition-all">
                    @error('username')
                        <p class="mt-1.5 text-xs text-[#E50914]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
                    <input id="password" type="password" name="password" required placeholder="••••••••"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#E50914]/50 focus:border-transparent transition-all">
                    @error('password')
                        <p class="mt-1.5 text-xs text-[#E50914]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1.5">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#E50914]/50 focus:border-transparent transition-all">
                </div>

                <!-- Actions -->
                <div class="pt-3 flex items-center justify-end gap-4">
                    <a href="{{ route('admin.users.index') }}" 
                       class="bg-white/5 hover:bg-white/10 border border-white/10 text-white font-medium py-2.5 px-5 rounded-xl transition duration-200 text-sm">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-gradient-to-r from-[#E50914] to-red-700 hover:from-red-600 hover:to-red-800 text-white font-medium py-2.5 px-5 rounded-xl shadow-[0_0_15px_rgba(229,9,20,0.3)] hover:shadow-[0_0_25px_rgba(229,9,20,0.5)] transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] text-sm">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
