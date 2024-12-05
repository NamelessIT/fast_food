<div class="container-fluid mx-auto container-form">
    @if (Route::currentRouteName() == 'account.index')
        @livewire('account.form-login')
    @elseif (Route::currentRouteName() == 'account.register')
        @livewire('account.form-register')
    @elseif (Route::currentRouteName() == 'account.forgot-password')
        @livewire('account.form-forgot-password')
    @elseif (Route::currentRouteName() == 'account.reset-password')
        @livewire('account.form-reset-password')
    @endif

    <div wire:loading >
        <x-loader />
    </div>
</div>