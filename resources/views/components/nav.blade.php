<nav>
    @auth
        <a href="{{ route('dashboard') }}">Главная</a>
        <a href="{{ route('equipments.index') }}">Оборудование</a>

        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit">Выйти</button>
        </form>
    @endauth
</nav>
