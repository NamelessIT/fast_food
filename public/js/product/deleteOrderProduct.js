document.addEventListener("DOMContentLoaded", () => {
    Livewire.on('deleteOrder', (params) => {
        cards = document.querySelectorAll(".order-item")
        cards.forEach(element => {
            if (params[0].id === Number(element.getAttribute("data-id")))
                element.remove()

        });
    });


})