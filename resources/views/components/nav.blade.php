<nav class="nav">
    @auth
        @include('components.nav-link', ['route' => route('dashboard'), 'routeName' => 'dashboard', 'name' => 'Дашборд', 'icon' => 'icons/dashboard.svg'])
        @include('components.nav-link', ['route' => route('equipments.index'), 'routeName' => 'equipments.*', 'name' => 'Оборудование', 'icon' => 'icons/equipments.svg'])
        @include('components.nav-link', ['route' => route('users.index'), 'routeName' => 'users.*', 'name' => 'Персонал', 'icon' => 'icons/users.svg'])
        @include('components.nav-link', ['route' => route('models.index'), 'routeName' => 'models.*', 'name' => 'Модели', 'icon' => 'icons/models.svg'])
        @include('components.nav-link', ['route' => route('types.index'), 'routeName' => 'types.*', 'name' => 'Типы', 'icon' => 'icons/types.svg'])
        @include('components.nav-link', ['route' => route('calibrations.index'), 'routeName' => 'calibrations.*', 'name' => 'Поверки', 'icon' => 'icons/calibrations.svg'])
        @include('components.nav-link', ['route' => route('transfers.index'), 'routeName' => 'transfers.*', 'name' => 'Передачи', 'icon' => 'icons/transfers.svg'])
    @endauth
</nav>
