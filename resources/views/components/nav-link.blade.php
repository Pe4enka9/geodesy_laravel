@props(['name'])

<a href="{{ route($name) }}" @class(['nav__link', 'nav__link--active' => request()->routeIs($name)])>
    @switch($name)
        @case('dashboard')
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="#ffffffb3" class="nav__link-icon" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" aria-hidden="true">
                <rect width="7" height="9" x="3" y="3" rx="1"/>
                <rect width="7" height="5" x="14" y="3" rx="1"/>
                <rect width="7" height="9" x="14" y="12" rx="1"/>
                <rect width="7" height="5" x="3" y="16" rx="1"/>
            </svg>
            @break
        @case('equipments')
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="#ffffffb3" class="nav__link-icon" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" aria-hidden="true">
                <path
                    d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.106-3.105c.32-.322.863-.22.983.218a6 6 0 0 1-8.259 7.057l-7.91 7.91a1 1 0 0 1-2.999-3l7.91-7.91a6 6 0 0 1 7.057-8.259c.438.12.54.662.219.984z"/>
            </svg>
            @break
        @case('users')
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="#ffffffb3" class="nav__link-icon" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <path d="M16 3.128a4 4 0 0 1 0 7.744"/>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                <circle cx="9" cy="7" r="4"/>
            </svg>
            @break
        @case('models')
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="#ffffffb3" class="nav__link-icon" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" aria-hidden="true">
                <path
                    d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                <path d="m3.3 7 8.7 5 8.7-5"/>
                <path d="M12 22V12"/>
            </svg>
            @break
        @case('types')
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="#ffffffb3" class="nav__link-icon" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" aria-hidden="true">
                <path
                    d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"/>
                <path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"/>
                <path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"/>
            </svg>
            @break
        @case('calibrations')
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="#ffffffb3" class="nav__link-icon" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" aria-hidden="true">
                <rect width="8" height="4" x="8" y="2" rx="1" ry="1"/>
                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                <path d="m9 14 2 2 4-4"/>
            </svg>
            @break
        @case('transfers')
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="#ffffffb3" class="nav__link-icon" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" aria-hidden="true">
                <path d="M8 3 4 7l4 4"/>
                <path d="M4 7h16"/>
                <path d="m16 21 4-4-4-4"/>
                <path d="M20 17H4"/>
            </svg>
            @break
    @endswitch

    <span @class(['nav__link-text', 'nav__link-text--active' => request()->routeIs($name)])>{{ $slot }}</span>
</a>
