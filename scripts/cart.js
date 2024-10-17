// cart.js
document.addEventListener('DOMContentLoaded', () => {
    const cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    const cartIcon = document.querySelector('.bx-cart');
    const addToCartButtons = document.querySelectorAll('.add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            const productBox = button.closest('.product-box');
            const productId = productBox.dataset.productId;
            const productName = productBox.querySelector('.product-text h4').innerText;
            const productPrice = productBox.querySelector('.price p').innerText;

            const product = {
                id: productId,
                name: productName,
                price: productPrice
            };

            // Add product to cart
            cart.push(product);
            sessionStorage.setItem('cart', JSON.stringify(cart));

            // Update cart icon (optional)
            updateCartIcon();
        });
    });

    cartIcon.addEventListener('click', () => {
        // Display cart items (for demonstration purposes)
        alert(`Cart items: ${cart.map(item => `${item.name} - ${item.price}`).join(', ')}`);
    });

    function updateCartIcon() {
        const cartCount = cart.length;
        cartIcon.setAttribute('data-cart-count', cartCount);
    }

    // Initialize cart icon with current cart count
    updateCartIcon();
});