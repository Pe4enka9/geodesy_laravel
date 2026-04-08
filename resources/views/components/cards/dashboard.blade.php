@props([
    'title',
    'count',
    'icon',
    'style',
])

<div class="dashboard__card">
    <div class="dashboard__card-title-wrapper">
        <div class="dashboard__card-title">{{ $title }}</div>

        <div class="dashboard__card-count dashboard__card-count--{{ $style }}">
            {{ $count }}
        </div>
    </div>

    <div class="dashboard__card-icon-wrapper dashboard__card-icon-wrapper--{{ $style }}">
        <img src="{{ $icon }}" alt="" class="dashboard__card-icon">
    </div>
</div>
