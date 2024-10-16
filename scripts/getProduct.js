let cartItems = [];
const checkoutModal = document.getElementById('checkout-modal');
const closeCheckout = document.querySelector('.close-checkout');

const cartItemsElement = document.getElementById('cart-items');   
const checkoutItemsElement = document.getElementById('checkout-product-list');
const checkoutTotalPrice = document.getElementById("checkout-total-price");
const cartCountElement = document.getElementById('cart-count');
const cartTotalPriceElement = document.getElementById('cart-total-price');
const cartModal = document.getElementById('cart-modal');
const closeModal = document.querySelector('.cart-modal .close');

function updateCartModal() {

    cartItemsElement.innerHTML = '';
    checkoutItemsElement.innerHTML = '';
    let totalPrice = 0;
    cartItems.forEach((item, index) => {
     ;
        
        const li = document.createElement('li');
        li.innerHTML = `
            <div class="cart-item">
                <img src="http://localhost:3000/backend/${item.image}" alt="${item.name}">
                <div class="cart-item-details">
                    <span>${item.name}</span>
                    <span>₱${item.price}</span>
                    <div class="quantity-controls">
                        <button class="quantity-decrease" data-index="${index}">-</button>
                        <span>${item.quantity}</span>
                        <button class="quantity-increase" data-index="${index}">+</button>
                    </div>
                    <button class="remove-btn" data-index="${index}" data-remove-id="${item.id}">Remove</button>
                </div>
            </div>
        `;
        cartItemsElement.appendChild(li);

        const li1 = document.createElement('li');
        li1.innerHTML = `
            <div class="checkout-item">
                <span>${item.name}</span>
                <div class="checkout-item-details">
                    
                    <span>₱${item.price}</span>
                    <span>${item.quantity}</span>
                </div>
                
            </div>
        `;
        checkoutItemsElement.appendChild(li1);        
        
        
        totalPrice += item.price * item.quantity;
    });

    // Format total price with commas
    checkoutTotalPrice.textContent = `${totalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    cartTotalPriceElement.textContent = `₱${totalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
}

document.addEventListener('DOMContentLoaded', () => {
      
    function getProductWithFilter(brand, size, modelType, query) {
        let queryString = '';
    
        if (brand) {
            const trimmedBrand = brand.trim(); 
            if (trimmedBrand) {
                queryString += `brand=${encodeURIComponent(trimmedBrand)}&`;
            }
        }
        if (size) {
            const trimmedSize = size.trim(); 
            if (trimmedSize) {
                queryString += `size=${encodeURIComponent(trimmedSize)}&`;
            }
        }
        if (modelType) {
            const trimmedModelType = modelType.trim(); 
            if (trimmedModelType) {
                queryString += `model_type=${encodeURIComponent(trimmedModelType)}&`;
            }
        }
        if (query) {
            const trimmedQuery = query.trim(); 
            if (trimmedQuery) {
                queryString += `model_name=${encodeURIComponent(trimmedQuery)}&`;
            }
        }
            
        if (queryString.endsWith('&')) {
            queryString = queryString.slice(0, -1);
        }
                           
        var userId = localStorage.getItem('userId');
        fetch(`./backend/src/customer/route.php?route=products&${queryString}`, {
            method: 'GET',                
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {  // Ensure `data` is defined here
            const productList = document.getElementById('product-list');
            productList.innerHTML = '';
                        
            if (data.data.length !== 0) {
                let limit = 8; // Default limit for index.php
                const currentPage = window.location.pathname;
                if (!currentPage.includes('index.php')) {
                    limit = data.data.length; // No limit for other pages
                }
    
                const latestProducts = data.data.slice(0, limit);  // Use the correct `data` here
    
                latestProducts.forEach(product => {
                    const productBox = document.createElement('div');
                    productBox.classList.add('product-box');
    
                    if (userId) {
                        productBox.innerHTML = `
                            <img src="http://localhost:3000/backend/${product.model_image_url}" alt="${product.model_name}">
                            <div class="product-text">
                                <h4>${product.model_name}</h4>
                            </div>
                            <div class="price">
                                <p>₱${product.model_price}</p>
                            </div>
                            <button 
                                class="add-to-cart-btn"
                                data-product-id="${product.model_id}" 
                                data-product-name="${product.model_name}"
                                data-product-image="${product.model_image_url}"
                                data-product-price="${product.model_price}">Add to Cart</button>
                        `;
                    } else {
                        productBox.innerHTML = `
                            <img src="http://localhost:3000/backend/${product.model_image_url}" alt="${product.model_name}">
                            <div class="product-text">
                                <h4>${product.model_name}</h4>
                            </div>
                            <div class="price">
                                <p>₱${product.model_price}</p>
                            </div>
                            <p class="login-prompt">Please log in to add items to your cart.</p>
                        `;
                    }
    
                    productList.appendChild(productBox);
                });
    
                // Add event listeners for all 'Add to Cart' buttons after loading products
                attachAddToCartListeners();
            } else {
                productList.innerHTML = 'No products here...';
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }
    
    getProductWithFilter("", "", "", "");

    function saveCartItems(cartItems) {

        cartItems.forEach(cartItem => {
                                    
            const data = new URLSearchParams({                    
                customer_id: localStorage.getItem("userId"),                    
                items : JSON.stringify([
                    {
                        model_id: cartItem.id,
                        quantity: cartItem.quantity,
                        total: cartItem.price * cartItem.quantity
                    }                       
                ])
            });
    
            fetch('/backend/src/customer/route.php?route=customer/save/cart', {
                method: 'POST',
                body: data.toString(),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        })
        
    }
    function removeCartItem(cartItemId) {
        const data = new URLSearchParams({                    
            cart_id: localStorage.getItem("cartId"),
            model_id: cartItemId,            
        });

        fetch('/backend/src/customer/route.php?route=customer/delete/item/cart', {
            method: 'POST',
            body: data.toString(),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }
    function getCartItems () {
        var userId = localStorage.getItem('userId');
        fetch(`./backend/src/customer/route.php?route=customer/get/cart&customer_id=${userId}`, {
            method: 'GET',                
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {        
            const items = data.data            
            localStorage.setItem('cartId', data.data[0].cart_id);
            items.forEach(cartItem => {
                
                const existingItemIndex = cartItems.findIndex(item => item.id === cartItem.model_id);
                if (existingItemIndex === -1) {
                    cartItems.push({ 
                        id: cartItem.model_id, 
                        name: cartItem.model_name, 
                        image: `${cartItem.model_image_url}`, 
                        price: cartItem.model_price, 
                        quantity: cartItem.quantity });
                } else {
                    cartItems[existingItemIndex].quantity += 1;
                }
                cartCountElement.textContent = cartItems.reduce((sum, item) => sum + item.quantity, 0);
            })
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });

    }
    getCartItems();
    function attachAddToCartListeners() {
        
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const productId = event.target.getAttribute('data-product-id');
                const productName = event.target.getAttribute('data-product-name');
                const productImage = event.target.getAttribute('data-product-image');
                const productPrice = event.target.getAttribute('data-product-price');
                
                const existingItemIndex = cartItems.findIndex(item => item.id === productId);
                if (existingItemIndex === -1) {
                    cartItems.push({ id: productId, name: productName, image: productImage, price: productPrice, quantity: 1 });
                } else {
                    cartItems[existingItemIndex].quantity += 1;
                }
                cartCountElement.textContent = cartItems.reduce((sum, item) => sum + item.quantity, 0);
                alert(productName + ' has been added to the cart!');   
                saveCartItems(cartItems)
            });
        });
    }
                            
    cartItemsElement.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-btn')) {
            const index = event.target.getAttribute('data-index');
            const modelId = event.target.getAttribute('data-remove-id');
            
            removeCartItem(modelId)
            cartItems.splice(index, 1);
            cartCountElement.textContent = cartItems.reduce((sum, item) => sum + item.quantity, 0);
            updateCartModal();
            return
        } else if (event.target.classList.contains('quantity-increase')) {
            const index = event.target.getAttribute('data-index');
            cartItems[index].quantity += 1;
            cartCountElement.textContent = cartItems.reduce((sum, item) => sum + item.quantity, 0);
            updateCartModal();
        } else if (event.target.classList.contains('quantity-decrease')) {
            const index = event.target.getAttribute('data-index');
            if (cartItems[index].quantity > 1) {
                cartItems[index].quantity -= 1;
                cartCountElement.textContent = cartItems.reduce((sum, item) => sum + item.quantity, 0);
                updateCartModal();
            }
        }
                
        saveCartItems(cartItems)
    });

    
    
    
});
