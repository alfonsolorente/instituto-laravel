<header class="navbar bg-base-100 shadow-lg fixed top-0 z-50">
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <i class="fas fa-bars text-xl"></i>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                <li><a href="#about">{{ __('About') }}</a></li>
                <li><a href="#contacta">{{ __('Contacta') }}</a></li>
                <li><a href="#noticias">{{ __('Noticias') }}</a></li>
                <li><a href="#referencias">{{ __('Referencias') }}</a></li>
            </ul>
        </div>
        <a href="/" class="btn btn-ghost text-xl">
            <i class="fas fa-graduation-cap text-primary"></i>
            <span class="ml-2">{{ config('app.name', 'Instituto') }}</span>
        </a>
    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1">
            <li><a href="#about">{{ __('About') }}</a></li>
            <li><a href="#contacta">{{ __('Contacta') }}</a></li>
            <li><a href="#noticias">{{ __('Noticias') }}</a></li>
            <li><a href="#referencias">{{ __('Referencias') }}</a></li>
        </ul>
    </div>
    <div class="navbar-end gap-2">
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-ghost">{{ __('Dashboard') }}</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline btn-error">{{ __('Logout') }}</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-ghost">{{ __('Login') }}</a>
            <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Register') }}</a>
        @endauth
    </div>
</header>
