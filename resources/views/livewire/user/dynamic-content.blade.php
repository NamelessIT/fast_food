<div style="display: flex; height: 100vh;">
    <div class="sidebar bg-dark text-light p-3" style="width: 250px;">
        <img src="{{ asset('images/logo.jpg') }}" alt="KFC-LOGO" class="img-fluid rounded mb-4">
        <h2>Xin chào, Nguyễn!</h2>
        <nav class="nav flex-column">
            <a href="{{ url('/') }}" class=" d-block mb-3 text-decoration-underline nav-link text-light" wire:click="logout">Đăng xuất</a>
            <a href="javascript:void(0)" class="nav-link text-light {{ $index === 0 ? 'active bg-primary' : '' }}" wire:click="navigate('previous-orders',0)">Đơn hàng đã đặt</a>
            <a href="javascript:void(0)" class="nav-link text-light {{ $index === 2 ? 'active bg-primary' : '' }}" wire:click="navigate('address',2)">Địa chỉ của bạn</a>
            <a href="javascript:void(0)" class="nav-link text-light {{ $index === 3 ? 'active bg-primary' : '' }}" wire:click="navigate('my-account.detail',3)">Chi tiết tài khoản</a>
            <a href="javascript:void(0)" class="nav-link text-light {{ $index === 4 ? 'active bg-primary' : '' }}" wire:click="navigate('my-account.reset-password',4)">Đặt lại mật khẩu</a>
            <a href="javascript:void(0)" class="nav-link text-light {{ $index === 5 ? 'active bg-primary' : '' }}" wire:click="navigate('my-account.delete',5)">Xóa tài khoản</a>
        </nav>
    </div>

    <div class="main-content flex-grow-1 p-4">
        @if($currentPage === 'previous-orders')
        @livewire('user.previous-orders')
        @elseif($currentPage === 'address')
        @livewire('user.address')
        @elseif($currentPage === 'my-account.detail')
        @livewire('user.my-account-detail')
        @elseif($currentPage === 'my-account.reset-password')
        @livewire('user.reset-password')
        @elseif($currentPage === 'my-account.delete')
        @livewire('user.delete-account')
        @endif
    </div>
</div>
