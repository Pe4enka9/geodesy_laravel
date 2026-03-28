<nav>
    @auth
        <a href="{{ route('dashboard') }}">Главная</a>
        <a href="{{ route('equipments.index') }}">Оборудование</a>
        <a href="{{ route('users.index') }}">Персонал</a>
        <a href="{{ route('models.index') }}">Модели</a>
        <a href="{{ route('types.index') }}">Типы</a>
        <a href="{{ route('calibrations.index') }}">Поверки</a>

        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit">Выйти</button>
        </form>
    @endauth
</nav>
