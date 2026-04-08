@props([
    'user',
    'initials' => false,
    'role' => false,
    'mod' => '',
])

<div @class(['user', "user--$mod" => $mod])>
    <div class="user__img-wrapper">
        <img src="" alt="" class="user__img">
    </div>

    <div class="user__info">
        <div class="user__name">{{ $initials ? $user->getInitials() : $user->getFullName() }}</div>

        @if($role)
            <div class="user__role">{{ $user->role->label() }}</div>
        @elseif($user->id === auth()->id())
            <div class="user__me">(Вы)</div>
        @endif
    </div>
</div>
