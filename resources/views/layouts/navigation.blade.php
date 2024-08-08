<nav id="sidebar" class="sidebar">
    <a class='sidebar-brand' href='index.html'>
        {{ config('app.name') }}
    </a>
    <div class="sidebar-content">
        <ul class="sidebar-nav mt-2">
            <li class="sidebar-header">
                İstifadəçi paneli
            </li>

            <!-- Əsas səhifə -->
            <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href='{{ route('dashboard') }}' class='sidebar-link'>
                    <i class="align-middle me-2 fas fa-fw fa-tachometer-alt"></i> <span class="align-middle">Əsas səhifə</span>
                </a>
            </li>

            <li class="sidebar-header">
                Bloqlar
            </li>

            <li class="sidebar-item {{ request()->routeIs('blogs.index') ? 'active' : '' }}">
                <a href='{{ route('blogs.index') }}' class='sidebar-link'>
                    <i class="align-middle me-2 fas fa-fw fa-book"></i> <span class="align-middle">Bütün bloqlar</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('blogs.create') ? 'active' : '' }}">
                <a href='{{ route('blogs.create') }}' class='sidebar-link'>
                    <i class="align-middle me-2 fas fa-fw fa-pen"></i> <span class="align-middle">Yeni bloq yazısı</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('category.index') ? 'active' : '' }}">
                <a href='{{ route('category.index') }}' class='sidebar-link'>
                    <i class="align-middle me-2 fas fa-fw fa-tags"></i> <span class="align-middle">Bloq kateqoriyaları</span>
                </a>
            </li>



            <hr>
            <!-- Hesabdan çıxış -->
            <li class="sidebar-item" style="background: transparent;
                border-radius: .2rem;
                color: #6c757d;
                cursor: pointer;
                display: block;
                font-weight: 400;
                margin: 0 .5rem;
                padding: .65rem .75rem;
                position: relative;
                text-decoration: none;
                transition: background .1s ease-in-out;">
                <i class="align-middle me-2 fas fa-fw fa-sign-out-alt" style="color: #297fba;"></i>
                <form action="{{ route('logout') }}" method="post" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 align-middle" style="color: inherit; text-decoration: none;">
                        <span class="align-middle">Hesabdan çıxış</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>
