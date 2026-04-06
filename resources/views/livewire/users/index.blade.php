@use(App\Models\Users\Enums\UserRoleEnum, Role)

<x-tab-content>
    @include('components.tab-actions', ['sorts' => Role::cases(), 'placeholder' => 'Поиск по ФИО, логину...'])

    <x-tables.table
        :headers="['Пользователь', 'Логин', 'Должность', 'Роль']"
        :items="$users"
        empty-text="Пользователи не найдены"
    >
        @foreach($users as $user)
            <x-tables.tr :key="$user->id">
                <x-tables.td mod="users">
                    <x-user :user="$user"/>
                </x-tables.td>

                <x-tables.td>{{ $user->login }}</x-tables.td>
                <x-tables.td>{{ $user->position?->label() ?? '-' }}</x-tables.td>

                <x-tables.td>
                    <div class="badge badge--{{ $user->role->value }}">
                        {{ $user->role->label() }}
                    </div>
                </x-tables.td>

                <x-tables.td>
                    <x-actions :id="$user->id"/>
                </x-tables.td>
            </x-tables.tr>
        @endforeach
    </x-tables.table>
</x-tab-content>
