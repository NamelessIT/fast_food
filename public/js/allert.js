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
    Livewire.on('order_success', () => {
        Swal.fire({
            title: "Đặt hàng thành công",
            // text: "Đặt hàng thành công",
            icon: "success",


        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = params[0].url
            }
        });

    })
    Livewire.on("empty_order",()=>{
        Swal.fire({
            title: "Vui lòng thêm sản phẩm để thanh toán",
            showClass: {
                popup: `
                animate__animated
                animate__fadeInUp
                animate__faster
              `
            },
            hideClass: {
                popup: `
                animate__animated
                animate__fadeOutDown
                animate__faster
              `
            }
        });
    }) 
     
    
})