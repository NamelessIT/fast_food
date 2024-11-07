document.addEventListener("DOMContentLoaded", () => {
    Livewire.on('addToCartNotLogin', (params) => {

        Swal.fire({
            title: "Vui lòng đăng nhập để đặt hàng",
            // text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đăng nhập",
            cancelButtonText: "Hủy",

        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = params[0].url
            }
        });

    })
})