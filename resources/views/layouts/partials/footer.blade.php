<footer class="footer-ecloria">
    <div class="container">
        <div class="row g-4">
            {{-- Brand & Description --}}
            <div class="col-lg-4 col-md-6">
                <h5 style="font-family: 'Playfair Display', serif; font-size: 1.5rem;">
                    ÉCL<span style="color: var(--ecloria-gold);">O</span>RIA
                </h5>
                <p style="font-size: 0.9rem; color: var(--ecloria-gray);">
                    {{ __('messages.footer_desc') }}
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-white" title="Instagram"><i class="bi bi-instagram fs-5"></i></a>
                    <a href="#" class="text-white" title="Facebook"><i class="bi bi-facebook fs-5"></i></a>
                    <a href="#" class="text-white" title="TikTok"><i class="bi bi-tiktok fs-5"></i></a>
                </div>
            </div>

            {{-- Boutique --}}
            <div class="col-lg-2 col-md-6">
                <h5>{{ __('messages.footer_shop') }}</h5>
                <a href="{{ route('products.index') }}">{{ __('messages.footer_new') }}</a>
                <a href="{{ route('products.index') }}">{{ __('messages.footer_best') }}</a>
                <a href="{{ route('products.index') }}">{{ __('messages.footer_promos') }}</a>
            </div>

            {{-- Service Client --}}
            <div class="col-lg-3 col-md-6">
                <h5>{{ __('messages.footer_service') }}</h5>
                <a href="{{ route('contact') }}">{{ __('messages.footer_contact') }}</a>
                <a href="#">{{ __('messages.footer_shipping') }}</a>
                <a href="#">{{ __('messages.footer_returns') }}</a>
                <a href="#">{{ __('messages.footer_faq') }}</a>
            </div>

            {{-- Newsletter --}}
            <div class="col-lg-3 col-md-6">
                <h5>Newsletter</h5>
                <p style="font-size: 0.9rem; color: var(--ecloria-gray);">
                    Inscrivez-vous pour recevoir nos offres exclusives.
                </p>
                <form action="#" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="email" name="email" class="form-control form-control-sm" placeholder="Votre email" required>
                    <button type="submit" class="btn btn-ecloria-gold btn-sm">
                        <i class="bi bi-send"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="footer-bottom text-center mt-4 pt-4 border-top border-secondary">
            © {{ date('Y') }} ÉCLORIA. {{ __('messages.footer_rights') }}
            <span class="mx-2">|</span>
            <a href="#" class="text-muted" style="font-size: 0.8rem;">Mentions légales</a>
            <span class="mx-2">|</span>
            <a href="#" class="text-muted" style="font-size: 0.8rem;">Politique de confidentialité</a>
        </div>
    </div>
</footer>
