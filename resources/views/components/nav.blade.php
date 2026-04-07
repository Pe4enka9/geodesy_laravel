<nav class="nav">
    @auth
        @include('components.nav-link', ['route' => route('dashboard'), 'routeName' => 'dashboard', 'name' => 'Дашборд', 'icon' => 'dashboard'])
        @include('components.nav-link', ['route' => route('equipments.index'), 'routeName' => 'equipments.*', 'name' => 'Оборудование', 'icon' => 'equipments'])

        @adminOrOwner
        @include('components.nav-link', ['route' => route('users.index'), 'routeName' => 'users.*', 'name' => 'Персонал', 'icon' => 'users'])
        @endadminOrOwner

        @include('components.nav-link', ['route' => route('models.index'), 'routeName' => 'models.*', 'name' => 'Модели', 'icon' => 'models'])
        @include('components.nav-link', ['route' => route('types.index'), 'routeName' => 'types.*', 'name' => 'Типы', 'icon' => 'types'])
        @include('components.nav-link', ['route' => route('calibrations.index'), 'routeName' => 'calibrations.*', 'name' => 'Поверки', 'icon' => 'calibrations'])
        @include('components.nav-link', ['route' => route('transfers.index'), 'routeName' => 'transfers.*', 'name' => 'Передачи', 'icon' => 'transfers'])
    @endauth
</nav>
