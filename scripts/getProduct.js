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
                           
        var userId = sessionStorage.getItem('userId');
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
        .then(data => {
                        
            const productList = document.getElementById('product-list');
            productList.innerHTML = '';
                        
            if (data.data.length !== 0) {
                let limit = 8
                const currentPage = window.location.pathname;
                if (!currentPage.includes('index.php')) {
                    limit = data.data.length
                }
    
                const latestProducts = data.data.slice(0, limit);
                            
                latestProducts.forEach(product => {                                        
                    const productBox = document.createElement('div');
                    productBox.classList.add('product-box');
                    productBox.onclick = () => openProductModal(
                        product.model_id, 
                        product.model_image_url, 
                        product.model_name,
                        product.model_description,
                        product.model_stock,
                        product.model_price
                    );
                    productBox.innerHTML = `
                            <img src="http://localhost:3000/backend/${product.model_image_url}" alt="${product.model_name}">
                            <div class="product-text">
                                <h4>${product.model_name}</h4>
                            </div>
                            <div class="price">
                                <p>₱${product.model_price}</p>
                            </div>
                    `;
                    if (userId) {
                        
                        productBox.innerHTML += `                           
                            <button 
                                class="add-to-cart-btn"
                                data-product-id="${product.model_id}" 
                                data-product-name="${product.model_name}"
                                data-product-image="${product.model_image_url}"
                                data-product-price="${product.model_price}">Add to Cart</button>
                        `;
                    } else {
                        productBox.innerHTML += `                            
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

    function saveCartItems(cartItem) {
                                               
        const data = new URLSearchParams({                    
            customer_id: sessionStorage.getItem("userId"),                    
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
            if (data.success === "Success") {
                alert("item added to cart")
            }                 
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
        
    }
    function removeCartItem(cartItemId) {
        const data = new URLSearchParams({                    
            cart_id: sessionStorage.getItem("cartId"),
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
            alert("item deleted in the cart")
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }
    function getCartItems () {
        
        var userId = sessionStorage.getItem('userId');
        if (!userId) {
            return
        }
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
            if (data.data.length !== 0) {            
                const items = data.data            
                sessionStorage.setItem('cartId', data.data[0].cart_id);
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
            }
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
                event.preventDefault();
                event.stopPropagation();
                const productId = event.target.getAttribute('data-product-id');
                const productName = event.target.getAttribute('data-product-name');
                const productImage = event.target.getAttribute('data-product-image');
                const productPrice = event.target.getAttribute('data-product-price');
                

                let updatedItem;

                const existingItemIndex = cartItems.findIndex(item => item.id === productId);
                if (existingItemIndex === -1) {
                    updatedItem = { id: productId, name: productName, image: productImage, price: productPrice, quantity: 1 };
                    cartItems.push(updatedItem);
                } else {
                    cartItems[existingItemIndex].quantity += 1;
                    updatedItem = cartItems[existingItemIndex];
                }
                cartCountElement.textContent = cartItems.reduce((sum, item) => sum + item.quantity, 0);                
                                
                saveCartItems(updatedItem)
            });
        });
    }
                            
    cartItemsElement.addEventListener('click', function (event) {
        const index = event.target.getAttribute('data-index');
        if (event.target.classList.contains('remove-btn')) {            
            const modelId = event.target.getAttribute('data-remove-id');            
            removeCartItem(modelId)
            cartItems.splice(index, 1);
            updateCartModal();            
            return
        } else if (event.target.classList.contains('quantity-increase')) {            
            cartItems[index].quantity += 1;                        
        } else if (event.target.classList.contains('quantity-decrease')) {
            
            if (cartItems[index].quantity > 1) {
                cartItems[index].quantity -= 1;                           
            }
        }
        
        cartCountElement.textContent = cartItems.reduce((sum, item) => sum + item.quantity, 0);
        updateCartModal();

        saveCartItems(cartItems[index])
        
    });

        
    let brandFilter = "";
    let sizeFilter = "";
    let modelTypeFilter = "";
    let searchFilter = "";
    
    const brandLinks = document.querySelectorAll('.brand-link');
    const sizeLinks = document.querySelectorAll('.size-link');
    const modelTypeLink = document.querySelectorAll('.model-type-link');

    const searchForm = document.getElementById('search-form');
            
    searchForm.addEventListener('submit', function(event) {                    
        event.preventDefault();
                    
        searchFilter = document.getElementById('search-query').value;     
        
        window.location.href = `/products.php?search=${searchFilter}`;
    });

    brandLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            
            brandFilter = this.getAttribute('data-brand-id');
            window.location.href = `/products.php?brand=${brandFilter}`;
        });
    });
    sizeLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            
            sizeFilter = this.getAttribute('data-size-id');
            window.location.href = `/products.php?size=${sizeFilter}`;
            
        });
    });

    modelTypeLink.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            
            modelTypeFilter = this.getAttribute('data-model-type');                
            window.location.href = `/products.php?model=${modelTypeFilter}`;
        });
    });


    function getQueryParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
    
    // When the page loads, check for a brand filter
    window.addEventListener('DOMContentLoaded', function() {
        const brandFilter = getQueryParameter('brand');
        const sizeFilter = getQueryParameter('size');
        const modelFilter = getQueryParameter('model');
        const searchFilter = getQueryParameter('search');
                                            
        getProductWithFilter(
            brandFilter,
            sizeFilter, 
            modelFilter, 
            searchFilter
        );
        
    });

    document.getElementById('checkout-btn').addEventListener('click', function () {
            
        if (cartItems.length > 0) {
            checkoutModal.style.display = 'block';
                                                            
        } else {                
            alert('Your cart is empty!');
            
        }
    });

    
});
