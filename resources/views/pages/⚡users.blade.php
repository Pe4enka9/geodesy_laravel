<?php

use App\Models\Users\Enums\UserRoleEnum;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Персонал')]
class extends Component {
    public string $search = '';
    public ?UserRoleEnum $currentFilter = null;

    #[On('user-updated')]
    public function refreshList(): void
    {
    }

    #[Computed]
    public function users(): Collection
    {
        return User::when($this->search, function (Builder $query) {
            $query->where(function (Builder $q) {
                $q->where('first_name', 'like', "%$this->search%")
                    ->orWhere('last_name', 'like', "%$this->search%")
                    ->orWhere('login', 'like', "%$this->search%");
            });
        })
            ->when($this->currentFilter, function (Builder $query) {
                $query->where('role', $this->currentFilter);
            })
            ->latest()
            ->get();
    }

    public function delete(int $id): void
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        $user->delete();
    }

    public function setFilter(?UserRoleEnum $currentFilter): void
    {
        $this->currentFilter = $currentFilter;
    }
};
?>

<x-tab title="Персонал">
    <livewire:users.create/>
    <livewire:users.edit/>

    <x-tab-content>
        <x-tab-actions
            :current-filter="$currentFilter"
            :filters="UserRoleEnum::cases()"
            placeholder="Поиск по ФИО, логину..."
            :model="User::class"
        />

        <x-tables.table
            :headers="['Пользователь', 'Логин', 'Должность', 'Роль']"
            :items="$this->users"
            empty-text="Пользователи не найдены"
        >
            @php /** @var User $user */ @endphp

            @foreach($this->users as $user)
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
                        <x-actions :model="$user"/>
                    </x-tables.td>
                </x-tables.tr>
            @endforeach
        </x-tables.table>
    </x-tab-content>
</x-tab>
