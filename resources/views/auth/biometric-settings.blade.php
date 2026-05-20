@extends('layouts.app')

@section('bg_class', 'bg-[#0a0a0a]')
@section('hide_overlay', false)

@section('content')
<div class="min-h-screen w-full flex items-center justify-center p-4">
    <div class="relative w-full max-w-2xl">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-[#E50914]/50 to-red-900/50 rounded-2xl blur opacity-30">
        </div>
        <div class="relative bg-[#141414]/80 backdrop-blur-xl border border-white/10 rounded-2xl p-8 sm:p-10 shadow-2xl">
            <div class="flex flex-col gap-6">
                <div class="space-y-2">
                    <h1 class="text-3xl font-bold text-white">Biometric Login</h1>
                    <p class="text-gray-400">Register fingerprint or face login for your account. Once registered, you can sign in faster using your device's biometric sensor.</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <button id="register-biometric" class="w-full bg-gradient-to-r from-[#E50914] to-red-700 text-white font-medium py-3 rounded-xl shadow-[0_0_15px_rgba(229,9,20,0.3)] transition hover:opacity-90">
                        Register Fingerprint / Face Login
                    </button>
                    <p class="mt-4 text-sm text-gray-400">Use a supported browser and device. If the device does not support Passkeys, this feature may not work.</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <h2 class="text-xl font-semibold text-white mb-4">Registered Devices</h2>
                    @if(auth()->user()->passkeys->isEmpty())
                        <p class="text-gray-400">You haven't registered any biometric devices yet.</p>
                    @else
                        <div class="space-y-4">
                            @foreach(auth()->user()->passkeys as $credential)
                                <div class="flex items-center justify-between rounded-2xl bg-black/60 border border-white/10 p-4">
                                    <div>
                                        <p class="font-medium text-white">{{ $credential->name }}</p>
                                        <p class="text-sm text-gray-400">Registered {{ $credential->created_at->diffForHumans() }}</p>
                                    </div>
                                    <form method="POST" action="/user/passkeys/{{ $credential->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-xl border border-red-600 text-red-200 px-3 py-2 text-sm hover:bg-red-600/20 transition">Remove</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div id="webauthn-message" class="rounded-3xl border border-white/10 bg-white/5 p-4 text-sm text-gray-300 hidden"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const registerBtn = document.getElementById('register-biometric');
        const messageElement = document.getElementById('webauthn-message');

        if (!window.Passkeys || !window.Passkeys.isSupported()) {
            registerBtn.disabled = true;
            registerBtn.classList.add('opacity-50', 'cursor-not-allowed');
            messageElement.textContent = 'Passkeys are not supported on this device/browser.';
            messageElement.classList.remove('hidden');
            messageElement.classList.add('text-red-400');
            return;
        }

        registerBtn.addEventListener('click', async () => {
            messageElement.classList.add('hidden');
            const previousText = registerBtn.innerHTML;
            registerBtn.innerHTML = 'Registering...';
            registerBtn.disabled = true;

            try {
                // Determine a name for the device
                const deviceName = prompt('Enter a name for this device (e.g., iPhone, My Laptop):', 'My Device');
                if (!deviceName) {
                    throw new Error('Registration cancelled.');
                }

                const response = await window.Passkeys.register({ name: deviceName });
                // If it reaches here, registration was successful.
                messageElement.textContent = 'Device registered successfully.';
                messageElement.classList.remove('hidden');
                messageElement.classList.remove('text-red-400');
                messageElement.classList.add('text-green-400');
                setTimeout(() => window.location.reload(), 1000);
            } catch (error) {
                console.error(error);
                messageElement.textContent = error.message || 'Registration failed.';
                messageElement.classList.remove('hidden');
                messageElement.classList.remove('text-green-400');
                messageElement.classList.add('text-red-400');
            } finally {
                registerBtn.innerHTML = previousText;
                registerBtn.disabled = false;
            }
        });
    });
</script>
@endsection
