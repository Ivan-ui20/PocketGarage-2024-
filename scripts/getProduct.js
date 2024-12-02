
let cartItems = [];
const checkoutModal = document.getElementById('checkout-modal');
const closeCheckout = document.querySelector('.close-checkout');

const cartItemsElement = document.getElementById('cart-items');   
const checkoutTotalPrice = document.getElementById("checkout-total-price");
const cartCountElement = document.getElementById('cart-count');
const cartTotalPriceElement = document.getElementById('cart-total-price');
const cartModal = document.getElementById('cart-modal');
const closeModal = document.querySelector('.cart-modal .close');

function updateCartModal() {

    cartItemsElement.innerHTML = '';

    let totalPrice = 0;
    cartItems.forEach((item, index) => {
             
        const li = document.createElement('li');
        li.innerHTML = `
            <div class="cart-item">
                <div class="product-info">
                    <img class="product-image" src="http://pocket-garage.com/backend/${item.image}" alt="${item.name}">
                    <div class="product-description">
                        <h3>${item.name}</h3>
                        <p>${item.description || "no description"}</p>
                    </div>
                </div>
                
                <div class="cart-item-details">
                    <span></span>
                    <span>₱${item.price}</span>
                    <div class="quantity-controls">
                        ${
                            item.type !== "Bidding" 
                            ? `<button class="quantity-decrease" data-index="${index}">-</button>` 
                            : `<button class="quantity-decrease" disabled>-</button>` 
                        }
                        
                        <span>${item.quantity}</span>
                        ${
                            item.type !== "Bidding" 
                            ? `<button class="quantity-increase" data-index="${index}">+</button>` 
                            : `<button class="quantity-increase" disabled>+</button>` 
                        }
                    </div>
                    ${
                        item.type !== "Bidding" 
                        ? `<button class="remove-btn" data-index="${index}" data-remove-id="${item.id}">Remove</button>` 
                        : `<button class="remove-btn" disabled>Remove</button>`
                    }
                    
                </div>
            </div>
        `;
        cartItemsElement.appendChild(li);

                        
        totalPrice += item.price * item.quantity;
            
    });
        
    cartTotalPriceElement.textContent = `₱${totalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    
    
}

function attachAddToCartListeners() {
        
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
            
    addToCartButtons.forEach(button => {
        button.addEventListener('click', (event) => {                        
            event.preventDefault();
            event.stopPropagation();            
            const productId = parseInt(event.target.getAttribute('data-product-id'));
            const productName = event.target.getAttribute('data-product-name');
            const productImage = event.target.getAttribute('data-product-image');
            const productPrice = event.target.getAttribute('data-product-price');
            const productDescription = event.target.getAttribute('data-product-description');            
            let updatedItem;

            const existingItemIndex = cartItems.findIndex(item => item.id === productId);
            if (existingItemIndex === -1) {
                updatedItem = { 
                    id: productId, 
                    name: productName, 
                    description: productDescription, 
                    image: productImage, 
                    price: productPrice, 
                    quantity: 1,
                    type: cartItem.model_type };
                
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

function saveCartItems(cartItem) {   
    const data = new URLSearchParams({                    
        customer_id: customerId,                    
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
        } else {
            alert(data.message)
        }                 
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
    
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
                    
                    if (product.model_type === "Bidding") {
                        productBox.onclick = () => openBidModal(
                            product.bidding_id,
                            product.model_id, 
                            product.model_image_url, 
                            product.model_name,
                            product.details,                            
                            product.model_price,
                            product.appraisal_value,
                            product.seller_name,
                            product.start_time,
                            product.end_time,
                            product.bid_status,
                            product.brand_name,
                            product.model_type,
                            product.model_packaging,
                            product.ratio,
                            product.model_condition,
                            product.model_tags
                        );
                    } else {
                        productBox.onclick = () => openProductModal(
                            product.model_id, 
                            product.model_image_url, 
                            product.model_name,
                            product.seller_id,
                            product.seller_name,
                            product.model_description,
                            product.model_stock,
                            product.model_price,
                            product.brand_name,
                            product.model_type,
                            product.model_packaging,
                            product.ratio,
                            product.model_condition
                            
                        );
                    }
                                       
                    productBox.innerHTML = `
                        <img src="http://pocket-garage.com/backend/${product.model_image_url}" alt="${product.model_name}">
                        <div class="product-text">
                            <h4>${product.model_name}</h4>
                        </div>
                        <div class="price">
                            <p>₱${product.model_price}</p>
                        </div>
                    `;
                    if (product.model_type !== "Bidding") {
                        if (!customerId) {                        
                            productBox.innerHTML += `                            
                                <p class="login-prompt">Please log in to add items to your cart.</p>
                            `;
                        }
                    }           
                    productList.appendChild(productBox);
                });
                                    
            } else {
                productList.innerHTML = 'No products here...';
            }

            
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }
    
    getProductWithFilter("", "", "", "");
    attachAddToCartListeners();
   
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
            alert("item deleted in the cart")
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }
    function getCartItems () {
            
        if (!customerId) {
            return
        }
        fetch(`./backend/src/customer/route.php?route=customer/get/cart&customer_id=${customerId}`, {
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
                localStorage.setItem('cartId', data.data[0].cart_id);
                items.forEach(cartItem => {
                    
                    const existingItemIndex = cartItems.findIndex(item => item.id === cartItem.model_id);
                    if (existingItemIndex === -1) {
                        cartItems.push({ 
                            id: cartItem.model_id, 
                            name: cartItem.model_name, 
                            description: cartItem.model_description,
                            image: `${cartItem.model_image_url}`, 
                            price: cartItem.model_price, 
                            quantity: cartItem.quantity,
                            type: cartItem.model_type });
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
        
        window.location.href = `/Products.php?search=${searchFilter}`;
    });

    brandLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            
            brandFilter = this.getAttribute('data-brand-id');
            window.location.href = `/Products.php?brand=${brandFilter}`;
        });
    });
    sizeLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            
            sizeFilter = this.getAttribute('data-size-id');
            window.location.href = `/Products.php?size=${sizeFilter}`;
            
        });
    });

    modelTypeLink.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            
            modelTypeFilter = this.getAttribute('data-model-type');                
            window.location.href = `/Products.php?model=${modelTypeFilter}`;
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

    // document.getElementById('checkout-btn').addEventListener('click', function () {
            
    //     if (cartItems.length > 0) {
    //         checkoutModal.style.display = 'block';
                                                            
    //     } else {                
    //         alert('Your cart is empty!');
            
    //     }
    // });

    
});
