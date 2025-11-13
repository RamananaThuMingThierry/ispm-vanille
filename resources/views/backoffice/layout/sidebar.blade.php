<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
                @include('backoffice.widget.nav_link', [
                    'url' => route('admin.dashboard'),
                    'icon' => 'fa-tachometer-alt',
                    'name' => 'sidebar.dashboard',
                    'ids' => 'dashboard-count',
                    'faIcons' => false
                ])
            <div class="sb-sidenav-menu-heading">ADMIN</div>
                @include('backoffice.widget.nav_link', [
                    'url' => route('admin.producteurs.index'),
                    'icon' => 'fa-seedling',
                    'name' => 'sidebar.producteurs',
                    'ids' => 'producteurs-count',
                    'faIcons' => false
                ])

                @include('backoffice.widget.nav_link', [
                    'url' => route('admin.marches.index'),
                    'icon' => 'fa-store',
                    'name' => 'sidebar.marches',
                    'ids' => 'marches-count',
                    'faIcons' => false
                ])

                @include('backoffice.widget.nav_link', [
                    'url' => route('admin.produits.index'),
                    'icon' => 'fa-boxes',
                    'name' => 'sidebar.produits',
                    'ids' => 'produits-count',
                    'faIcons' => false
                ])

                @include('backoffice.widget.nav_link', [
                    'url' => route('admin.annonces.index'),
                    'icon' => 'fa-bullhorn',
                    'name' => __('sidebar.annonces'),
                    'ids' => 'annonces-count',
                    'faIcons' => false
                ])

                @include('backoffice.widget.nav_link', [
                    'url' => route('admin.flux_commerciaux.index'),
                    'icon' => 'fa-exchange-alt',
                    'name' => __('sidebar.flux_commercials'),
                    'ids' => 'flux-count',
                    'faIcons' => false
                ])

                @include('backoffice.widget.nav_link', [
                    'url' => route('admin.actualites.index'),
                    'icon' => 'fa-newspaper',
                    'name' => 'sidebar.actualites',
                    'ids' => 'actualites-count',
                    'faIcons' => false
                ])

                @include('backoffice.widget.nav_link', [
                    'url' => route('admin.entreprises_exportatrices.index'),
                    'icon' => 'fa-truck-loading',
                    'name' => 'sidebar.entreprise_exportatrice',
                    'ids' => 'entreprises-exportatrices-count',
                    'faIcons' => false
                ])

                @include('backoffice.widget.nav_link', [
                    'url' => route('admin.entreprises_importatrices.index'),
                    'icon' => 'fa-ship',
                    'name' => 'sidebar.entreprise_importatrice',
                    'ids' => 'entreprises-importatrices-count',
                    'faIcons' => false
                ])

                @include('backoffice.widget.nav_link', [
                    'url' => route('admin.users.index'),
                    'icon' => 'fa-users',
                    'name' => 'sidebar.user',
                    'ids' => 'users-count',
                    'faIcons' => true
                ])
        </div>
    </div>
</nav>
