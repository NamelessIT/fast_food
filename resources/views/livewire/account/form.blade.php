<div class="container-fluid mx-auto container-form">
    @if (Route::currentRouteName() == 'account.index')
        @livewire('account.form-login')
    @elseif (Route::currentRouteName() == 'account.register')
        @livewire('account.form-register')
    @endif

    <div wire:loading >
        <x-loader />
    </div>
</div>