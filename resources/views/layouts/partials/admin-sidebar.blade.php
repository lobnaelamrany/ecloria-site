<aside class="admin-sidebar" id="adminSidebar">
    {{-- Brand --}}
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <span class="brand-text">ÉCL<span class="accent">O</span>RIA</span>
        <span class="d-none">É</span>
    </a>

    {{-- Nav --}}
    <ul class="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <div class="nav-section-title">Catalogue</div>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                <i class="bi bi-box-seam"></i>
                <span>Produits</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <i class="bi bi-tags"></i>
                <span>Catégories</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}" href="{{ route('admin.brands.index') }}">
                <i class="bi bi-award"></i>
                <span>Marques</span>
            </a>
        </li>

        <div class="nav-section-title">Ventes</div>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                <i class="bi bi-receipt"></i>
                <span>Commandes</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}" href="{{ route('admin.promotions.index') }}">
                <i class="bi bi-percent"></i>
                <span>Promotions</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.returns.*') ? 'active' : '' }}" href="{{ route('admin.returns.index') }}">
                <i class="bi bi-arrow-return-left"></i>
                <span>Retours</span>
            </a>
        </li>

        <div class="nav-section-title">Stock</div>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.stock.*') ? 'active' : '' }}" href="{{ route('admin.stock.index') }}">
                <i class="bi bi-boxes"></i>
                <span>Lots & Stock</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}" href="{{ route('admin.suppliers.index') }}">
                <i class="bi bi-truck"></i>
                <span>Fournisseurs</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.purchases.*') ? 'active' : '' }}" href="{{ route('admin.purchases.index') }}">
                <i class="bi bi-cart-check"></i>
                <span>Achats</span>
            </a>
        </li>

        <div class="nav-section-title">Clients & Service</div>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.users.clients') ? 'active' : '' }}" href="{{ route('admin.users.clients') }}">
                <i class="bi bi-people"></i>
                <span>Clients</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.users.employees.*') ? 'active' : '' }}" href="{{ route('admin.users.employees') }}">
                <i class="bi bi-person-badge"></i>
                <span>Employés</span>
            </a>
        </li>

        {{-- زدنا رابط الشكاوى --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}" href="{{ route('admin.complaints.index') }}">
                <i class="bi bi-chat-dots"></i>
                <span>Réclamations</span>
            </a>
        </li>
    </ul>
</aside>
