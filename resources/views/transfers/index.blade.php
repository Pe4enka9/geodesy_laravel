@use(App\Models\TransferRequests\Enums\TransferRequestStatusEnum, Status)
@extends('theme')
@section('title', 'Передачи')
@section('content')
    <h1>Передачи</h1>

    <a href="{{ route('transfers.create') }}">Добавить</a>

    <div style="display:flex; flex-direction: column; gap: 10px">
        @forelse($transfers as $transfer)
            <div style="background-color: #fff;border: 1px solid #000;">
                <div>Оборудование: {{ $transfer->equipment->inventory_number }}</div>
                <div>Отправитель: {{ $transfer->sender->name }}</div>
                <div>Получатель: {{ $transfer->receiver->name }}</div>
                <div>Статус: {{ $transfer->status->label() }}</div>

                @isset($transfer->comment)
                    <div>Комментарий: {{ $transfer->comment }}</div>
                @endisset

                @isset($transfer->resolved_at)
                    <div>Решено: {{ $transfer->resolved_at->format('d.m.Y H:i') }}</div>
                @endisset

                @if($transfer->status === Status::PENDING)
                    @if($transfer->sender_id === auth()->id())
                        <form action="{{ route('transfers.cancel', $transfer) }}" method="post">
                            @csrf
                            <button type="submit">Отменить</button>
                        </form>
                    @elseif($transfer->receiver_id === auth()->id())
                        <form action="{{ route('transfers.accept', $transfer) }}" method="post">
                            @csrf
                            <button type="submit">Принять</button>
                        </form>

                        <form action="{{ route('transfers.reject', $transfer) }}" method="post">
                            @csrf
                            <button type="submit">Отклонить</button>
                        </form>
                    @endif
                @endif
            </div>
        @empty
            <h2>Ничего не найдено</h2>
        @endforelse
    </div>
@endsection
