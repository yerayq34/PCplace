function addToCart() {
    const productId = document.getElementById("addToCartButton").getAttribute("data-product-id");
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        const response = JSON.parse(xhr.responseText);
        alert(response.message);
    };
    xhr.send("action=add&product_id=" + productId);
}
