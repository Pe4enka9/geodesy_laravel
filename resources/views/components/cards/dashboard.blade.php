@props([
    'title',
    'count',
    'style',
    'icon',
])

<div class="dashboard__card">
    <div class="dashboard__card-title-wrapper">
        <div class="dashboard__card-title">{{ $title }}</div>

        <div class="dashboard__card-count dashboard__card-count--{{ $style }}">
            {{ $count }}
        </div>
    </div>

    <div class="dashboard__card-icon-wrapper dashboard__card-icon-wrapper--{{ $style }}">
        @switch($icon)
            @case('box')
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" class="dashboard__card-icon dashboard__card-icon--{{ $style }}"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path
                        d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"/>
                    <path d="M12 22V12"/>
                    <polyline points="3.29 7 12 12 20.71 7"/>
                    <path d="m7.5 4.27 9 5.15"/>
                </svg>
                @break
            @case('success')
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" class="dashboard__card-icon dashboard__card-icon--{{ $style }}"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="m9 12 2 2 4-4"/>
                </svg>
                @break
            @case('danger')
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" class="dashboard__card-icon dashboard__card-icon--{{ $style }}"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/>
                    <path d="M12 9v4"/>
                    <path d="M12 17h.01"/>
                </svg>
                @break
        @endswitch
    </div>
</div>
