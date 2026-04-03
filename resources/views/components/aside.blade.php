<aside class="aside">
    <div class="aside__header">
        @include('components.logo')

        <div class="aside__title-wrapper">
            <h1 class="aside__title">ГеоКонтроль</h1>
            <div class="aside__subtitle">Учёт оборудования</div>
        </div>
    </div>

    @include('components.nav')

    <div class="aside__actions">
        <div class="aside__user">
            <div class="aside__user-img-wrapper">
                <img src="" alt="" class="aside__user-img">
            </div>

            <div class="aside__user-info">
                <div class="aside__username">{{ auth()->user()->getInitials() }}</div>
                <div class="aside__user-role">{{ auth()->user()->role->label() }}</div>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="post" class="aside__exit-form">
            @csrf
            <div class="nav__link" id="exit">
                <img src="{{ asset('icons/exit.svg') }}" alt="" class="nav__link-icon">
                <span class="nav__link-text">Выйти</span>
            </div>
        </form>
    </div>
</aside>

@push('scripts')
    <script>
        document.getElementById('exit').addEventListener('click', function () {
            this.closest('form').submit();
        });
    </script>
@endpush
