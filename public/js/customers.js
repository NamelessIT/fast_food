let startX;
let element;

function startSwipe(event) {
    startX = event.clientX;
    element = event.currentTarget;
}

function detectSwipe(event) {
    if (!startX) return;
    const deltaX = event.clientX - startX;
    element.style.transform = `translateX(${deltaX}px)`;
}

function endSwipe(event) {
    const deltaX = event.clientX - startX;
    if (Math.abs(deltaX) > 100) {
        const addressId = element.getAttribute('data-id');
        element.style.transform = `translateX(${deltaX > 0 ? 100 : -100}%)`; // Slide effect

        // Sử dụng Fetch API để gửi yêu cầu xóa
        fetch(`/delete-address/${addressId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                element.remove(); // Xóa hàng khỏi giao diện
            } else {
                console.log(data.message);
                element.style.transform = 'translateX(0)';
            }
        })
        .catch(error => {
            console.log("Xóa bị lỗi:", error);
            element.style.transform = 'translateX(0)';
        });
    } else {
        element.style.transform = 'translateX(0)'; // Trả về vị trí ban đầu nếu vuốt ngắn
    }
    startX = null;
}

// Gán sự kiện cho các hàng có thể swipe
document.querySelectorAll('.swipeable-row').forEach(row => {
    row.addEventListener('mousedown', startSwipe);
    row.addEventListener('mousemove', detectSwipe);
    row.addEventListener('mouseup', endSwipe);
});
