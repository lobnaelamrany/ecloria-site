<nav class="navbar navbar-expand-lg navbar-ecloria">
    <div class="container">
        {{-- Logo --}}
        <a class="navbar-brand" href="{{ route('home') }}">
            ÉCL<span class="accent">O</span>RIA
        </a>

        {{-- Mobile toggle --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Nav links + Icons --}}
        <div class="collapse navbar-collapse" id="mainNav">
            {{-- Liens centraux --}}
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('messages.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">{{ __('messages.shop') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">{{ __('messages.categories') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('brands.*') ? 'active' : '' }}" href="{{ route('brands.index') }}">{{ __('messages.brands') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>

            {{-- Icons (يمين) --}}
            <ul class="navbar-nav navbar-icons">
                {{-- Language Switcher --}}
                <li class="nav-item dropdown-custom">
                    <details>
                        <summary class="nav-link icon-link" title="Language">
                            <i class="bi bi-globe"></i>
                        </summary>
                        <div class="dropdown-menu-custom">
                            <a class="dropdown-item-custom" href="{{ route('lang.switch', 'fr') }}">🇫🇷 Français</a>
                            <a class="dropdown-item-custom" href="{{ route('lang.switch', 'en') }}">🇬🇧 English</a>
                            <a class="dropdown-item-custom" href="{{ route('lang.switch', 'de') }}">🇩🇪 Deutsch</a>
                        </div>
                    </details>
                </li>

                {{-- Recherche (Live Search) --}}
                <li class="nav-item dropdown-custom">
                    <details id="searchDetails">
                        <summary class="nav-link icon-link" title="Recherche">
                            <i class="bi bi-search"></i>
                        </summary>
                        <div class="dropdown-menu-custom p-3" style="min-width: 350px;">
                            <div class="input-group">
                                <input type="text" id="searchInput" class="form-control" placeholder="{{ __('messages.search_placeholder') }}" autocomplete="off">
                                <button type="button" id="searchButton" class="btn btn-ecloria-primary" data-url="{{ route('products.index') }}">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <div id="searchResults" class="mt-2" style="max-height: 300px; overflow-y: auto;"></div>
                        </div>
                    </details>
                </li>

                <li class="nav-item">
                    <a class="nav-link icon-link" href="{{ route('favorites.index') }}" title="Favoris">
                        <i class="bi bi-heart"></i>
                        @auth
                            @php $favCount = auth()->user()->favorites()->count(); @endphp
                            @if($favCount > 0)
                                <span class="cart-count">{{ $favCount }}</span>
                            @endif
                        @endauth
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link icon-link" href="{{ route('cart.index') }}" title="Panier">
                        <i class="bi bi-bag"></i>
                        <span class="cart-count">
                            @auth
                                {{ auth()->user()->cart?->items->sum('quantity') ?? 0 }}
                            @else
                                0
                            @endauth
                        </span>
                    </a>
                </li>

                @auth
                    <li class="nav-item dropdown-custom">
                        <details>
                            <summary class="nav-link icon-link">
                                <i class="bi bi-person-circle"></i>
                            </summary>
                            <div class="dropdown-menu-custom">
                                <div class="dropdown-header-custom">
                                    {{ auth()->user()->full_name }}
                                </div>
                                <hr class="dropdown-divider">

                                {{-- Dashboard: غير للأدمن و الموظف --}}
                                @if(auth()->user()->isAdmin() || auth()->user()->isEmployee())
                                    <a class="dropdown-item-custom" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i> {{ __('messages.dashboard') }}
                                    </a>
                                @endif

                                {{-- Mon profil: للجميع --}}
                                <a class="dropdown-item-custom" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i> {{ __('messages.my_profile') }}
                                </a>

                                {{-- Mes commandes + Mes réclamations: غير للعميل --}}
                                @if(auth()->user()->isClient())
                                    <a class="dropdown-item-custom" href="{{ route('orders.index') }}">
                                        <i class="bi bi-bag-check me-2"></i> {{ __('messages.my_orders') }}
                                    </a>
                                    <a class="dropdown-item-custom" href="{{ route('client.complaints.index') }}">
                                        <i class="bi bi-chat-dots me-2"></i> {{ __('messages.my_complaints') }}
                                    </a>
                                @endif

                                <hr class="dropdown-divider">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item-custom text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> {{ __('messages.logout') }}
                                    </button>
                                </form>
                            </div>
                        </details>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link icon-link" href="{{ route('login') }}" title="{{ __('messages.login') }}">
                            <i class="bi bi-person"></i>
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

{{-- Live Search Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    const searchButton = document.getElementById('searchButton');

    if (!searchInput || !searchResults) {
        return;
    }

    let timeout = null;

    searchInput.addEventListener('input', function() {
        clearTimeout(timeout);
        const query = this.value.trim();

        if (query.length < 2) {
            searchResults.innerHTML = '';
            return;
        }

        timeout = setTimeout(() => {
            fetch(`{{ route('products.search') }}?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        searchResults.innerHTML = '<p class="text-muted small p-2">Aucun résultat.</p>';
                        return;
                    }
                    searchResults.innerHTML = data.map(product => `
                        <a href="/products/${product.slug}" class="d-flex align-items-center gap-2 p-2 text-decoration-none border-bottom">
                            <img src="${product.image}" alt="${product.name}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                            <div>
                                <div class="small fw-bold">${product.name}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">${product.brand || ''}</div>
                                <div class="text-ecloria-rose small">${product.price}</div>
                            </div>
                        </a>
                    `).join('');
                });
        }, 300);
    });

    if (searchButton) {
        searchButton.addEventListener('click', function() {
            const url = searchButton.dataset.url;
            window.location.href = url + '?search=' + encodeURIComponent(searchInput.value);
        });
    }
});
</script>
