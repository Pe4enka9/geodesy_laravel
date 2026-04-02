<a href="{{ $route }}" @class(['nav__link', 'nav__link--active' => request()->routeIs($routeName)])>
    <img src="{{ asset($icon) }}" alt="" class="nav__link-icon">
    <span @class(['nav__link-text', 'nav__link-text--active' => request()->routeIs($routeName)])>{{ $name }}</span>
</a>
