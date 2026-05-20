@extends('layouts.app')

@section('bg_class', 'bg-[#0a0a0a]')
@section('hide_overlay', false)

@section('content')
<div class="w-full max-w-5xl mx-auto px-4 py-8" x-data="{ showToast: true }">
    <!-- Success/Error Alert Toast -->
    @if(session('success') || session('error'))
        <div x-show="showToast" 
             x-init="setTimeout(() => showToast = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-[-20px]"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-[-20px]"
             class="fixed top-24 right-6 z-50 max-w-sm w-full bg-[#141414]/90 backdrop-blur-xl border {{ session('success') ? 'border-green-500/30' : 'border-red-500/30' }} rounded-2xl shadow-2xl p-4 flex items-center justify-between gap-4">
            
            <div class="flex items-center gap-3">
                @if(session('success'))
                    <span class="p-2 rounded-full bg-green-500/10 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <span class="text-sm font-medium text-gray-200">{{ session('success') }}</span>
                @else
                    <span class="p-2 rounded-full bg-[#E50914]/10 text-[#E50914]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </span>
                    <span class="text-sm font-medium text-gray-200">{{ session('error') }}</span>
                @endif
            </div>

            <button @click="showToast = false" class="text-gray-400 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-white">Manage Users</h1>
            <p class="text-gray-400 text-sm mt-1">Add, update, or remove user accounts on CineMatch</p>
        </div>
        <a href="{{ route('admin.users.create') }}" 
           class="bg-gradient-to-r from-[#E50914] to-red-700 hover:from-red-600 hover:to-red-800 text-white font-medium py-2.5 px-5 rounded-xl shadow-[0_0_15px_rgba(229,9,20,0.3)] hover:shadow-[0_0_25px_rgba(229,9,20,0.5)] transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Add New User
        </a>
    </div>

    <!-- Table Container -->
    <div class="relative bg-[#141414]/75 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/10 bg-white/5">
                        <th class="py-4 px-6 text-sm font-semibold text-gray-300">Name</th>
                        <th class="py-4 px-6 text-sm font-semibold text-gray-300">Username</th>
                        <th class="py-4 px-6 text-sm font-semibold text-gray-300">Date Registered</th>
                        <th class="py-4 px-6 text-sm font-semibold text-gray-300 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($users as $user)
                        <tr class="hover:bg-white/5 transition-colors duration-200">
                            <td class="py-4 px-6 text-sm font-medium text-white">
                                {{ $user->name ?? '-' }}
                                @if($user->username === 'admin')
                                    <span class="ml-2 px-2 py-0.5 text-xs font-semibold bg-[#E50914]/20 border border-[#E50914]/40 text-[#ff4f59] rounded-full">Admin</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-300">
                                {{ $user->username }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-400">
                                {{ $user->created_at ? $user->created_at->format('M d, Y H:i') : '-' }}
                            </td>
                            <td class="py-4 px-6 text-sm text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="bg-white/5 hover:bg-white/10 border border-white/10 text-white font-medium py-1.5 px-3 rounded-lg text-xs transition duration-200 flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.83 20.013a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                        Edit
                                    </a>
                                    
                                    @if($user->username !== 'admin')
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete user {{ $user->username }}? This action cannot be undone.');"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-500/10 hover:bg-[#E50914] border border-[#E50914]/20 hover:border-transparent text-[#ff4f59] hover:text-white font-medium py-1.5 px-3 rounded-lg text-xs transition duration-200 flex items-center gap-1.5 shadow-[0_0_10px_rgba(239,68,68,0.05)]">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    @else
                                        <button disabled 
                                                class="bg-white/5 border border-white/5 text-gray-500 font-medium py-1.5 px-3 rounded-lg text-xs cursor-not-allowed flex items-center gap-1.5 opacity-40">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                            </svg>
                                            Locked
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-gray-500 text-sm">
                                No registered users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
