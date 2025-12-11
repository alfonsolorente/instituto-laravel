<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" 
                   class="block w-full px-3 py-2 border border-blue-400 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-blue-50" 
                   required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" type="password" name="password" 
                   class="block w-full px-3 py-2 border border-blue-400 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-blue-50" 
                   required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif

            <button type="submit" class="px-4 py-2 bg-[#1e3a5f] text-white text-sm font-medium rounded hover:bg-[#2d4a6f] uppercase">
                LOG IN
            </button>
        </div>
    </form>
</x-guest-layout>
