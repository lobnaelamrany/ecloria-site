<header class="admin-topbar">
    <div class="d-flex align-items-center gap-3">
        <button class="toggle-btn" id="sidebarToggle" type="button" aria-label="Toggle sidebar">
            <i class="bi bi-list"></i>
        </button>
        <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>
    </div>

    <div class="admin-user">
        <div class="d-flex align-items-center gap-2">
            <div class="admin-user-avatar">
                {{ strtoupper(substr(auth()->user()->first_name ?? 'A', 0, 1)) }}
            </div>
            <span class="admin-user-name d-none d-md-inline">
                {{ auth()->user()->full_name ?? 'Admin' }}
            </span>
        </div>

        {{-- زر الخروج --}}
        <form method="POST" action="{{ route('logout') }}" class="ms-2 mb-0">
            @csrf
            <button type="submit" class="topbar-icon border-0 bg-transparent" title="Déconnexion" style="cursor: pointer;">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </form>
    </div>
</header>
