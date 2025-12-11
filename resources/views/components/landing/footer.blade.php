<footer class="footer footer-center bg-base-200 text-base-content rounded p-10">
    <nav class="grid grid-flow-col gap-4">
        <a href="#about" class="link link-hover">{{ __('About') }}</a>
        <a href="#contacta" class="link link-hover">{{ __('Contacta') }}</a>
        <a href="#noticias" class="link link-hover">{{ __('Noticias') }}</a>
        <a href="#referencias" class="link link-hover">{{ __('Referencias') }}</a>
    </nav>
    <nav>
        <div class="grid grid-flow-col gap-4">
            <a href="#" class="text-2xl hover:text-primary transition-colors">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="text-2xl hover:text-primary transition-colors">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="#" class="text-2xl hover:text-primary transition-colors">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="text-2xl hover:text-primary transition-colors">
                <i class="fab fa-linkedin"></i>
            </a>
        </div>
    </nav>
    <aside>
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Instituto') }}. {{ __('Todos los derechos reservados.') }}</p>
    </aside>
</footer>
