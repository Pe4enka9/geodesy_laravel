<div class="table">
    <table>
        <thead>
        <tr>
            <th>Пользователь</th>
            <th>Логин</th>
            <th>Должность</th>
            <th>Роль</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr wire:key="{{ $user->id }}">
                <td class="table__user-td">
                    <div class="table__user-img-wrapper">
                        <img src="" alt="" class="table__user-img">
                    </div>

                    <div class="table__user-info">
                        <div class="table__username">{{ $user->getFullName() }}</div>

                        @if($user->id === auth()->id())
                            <div class="table__user-me">(Вы)</div>
                        @endif
                    </div>
                </td>

                <td>{{ $user->login }}</td>
                <td>{{ $user->position?->label() ?? '-' }}</td>

                <td>
                    <div class="badge badge--{{ $user->role->value }}">
                        {{ $user->role->label() }}
                    </div>
                </td>

                <td>
                    <livewire:actions :item="$user">
                        @include('components.delete-btn', ['item' => $user])
                    </livewire:actions>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
