<div class="container-fluid mx-auto container-form">
    @if (Route::currentRouteName() == 'account.index')
        @livewire('account.form-login')
    @elseif (Route::currentRouteName() == 'account.register')
        @livewire('account.form-register')
    @endif

    <div class="loader" wire:loading>
        <div class="loading"></div>
    </div>
</div>