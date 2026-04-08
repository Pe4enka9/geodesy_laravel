<aside class="aside">
    <div class="aside__header">
        <x-logo/>

        <div class="aside__title-wrapper">
            <h1 class="aside__title">ГеоКонтроль</h1>
            <div class="aside__subtitle">Учёт оборудования</div>
        </div>
    </div>

    <x-nav/>

    <div class="aside__actions">
        <x-user :user="auth()->user()" mod="padding" initials role/>

        <form action="{{ route('logout') }}" method="post" class="aside__exit-form">
            @csrf
            <div class="nav__link" id="exit">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" class="nav__link-icon" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" aria-hidden="true">
                    <path d="m16 17 5-5-5-5"/>
                    <path d="M21 12H9"/>
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                </svg>

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
