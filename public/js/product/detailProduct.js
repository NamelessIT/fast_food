const createOdometer = (element, valuePast, valueCurrent) => {
    const odometer = new Odometer({
        el: element,
        format: "(.ddd),dd",
        value: valuePast,
    });
    odometer.update(valueCurrent);
};

const changeQuantity = (type) => {
    let quantity = 0;
    if (type === "-") {
        quantity = +document.querySelector(".add-to-cart input").value - 1;
    } else if (type === "+") {
        quantity = +document.querySelector(".add-to-cart input").value + 1;
    }
    if (quantity == 0) {
        return 1;
    } else if (quantity == 50) {
        return 50;
    }
    document.querySelector(".add-to-cart input").value = quantity;
    return quantity;
};

const changeQuantityInput = (e, price) => {
    let quantity = +e.target.value;
    if (quantity == 0 || quantity > 50) {
        document.querySelector(".add-to-cart input").value = 1;
        createOdometer(document.querySelector("#product-price"), 0, price);
        return 1;
    }
    return quantity;
};
