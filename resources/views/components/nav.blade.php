<nav class="nav">
    @auth
        <x-nav-link name="dashboard">Главная</x-nav-link>
        <x-nav-link name="equipments">Оборудование</x-nav-link>

        @adminOrOwner
        <x-nav-link name="users">Персонал</x-nav-link>
        @endadminOrOwner

        <x-nav-link name="models">Модели</x-nav-link>
        <x-nav-link name="types">Типы</x-nav-link>
        <x-nav-link name="calibrations">Поверки</x-nav-link>
        <x-nav-link name="transfers">Передачи</x-nav-link>
    @endauth
</nav>
