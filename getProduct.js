
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
        .then(data => {
            const productList = document.getElementById('product-list');
            productList.innerHTML = '';

            data.data.forEach(product => {
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
                        <button class="add-to-cart-btn" 
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
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }

    getProductWithFilter ("", "", "", "")

    
        
