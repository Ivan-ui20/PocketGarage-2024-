document.getElementById('cart-icon1').addEventListener('click', function (e) {        
    // const cartModal = document.getElementById('cart-modal');
    const checkout = document.getElementById("checkout-modal-container")
    
    e.preventDefault();
    updateCartModal();

    checkout.style.display = 'flex';
});
function openProductModal(id, image, name, sellerId, sellerName, description, stock, price) {
    document.getElementById("productModal").style.display = "flex";

    const modalImage = document.getElementById("modal-product-image");
    const modalTitle = document.getElementById("modal-product-title");
    const modalSellerId = document.getElementById("modal-seller-id");
    const modalSeller = document.getElementById("modal-seller-name");
    const modalDescription = document.getElementById("modal-product-description");
    const modalStock = document.getElementById("modal-product-stock");
    const modalPrice = document.getElementById("modal-product-price");
    const modalCart = document.getElementById("modal-cart");
    const modalButtons = document.getElementById("modal-buttons1");
    const outOfStockMessage = document.getElementById("out-of-stock-message");
    const chatIcon = document.getElementById("chat-icon");
    
  
    modalImage.src = `http://pocket-garage.com/backend/${image}`;
    modalImage.alt = name;
    modalTitle.textContent = name;
    modalSellerId.value = sellerId;
    modalSeller.textContent = sellerName;
    modalDescription.textContent = description;
    modalStock.textContent = `Available stocks: ${stock}`;
    modalPrice.innerHTML = `<span>₱${price}</span>`;
        
    modalCart.setAttribute("data-product-id", id);
    modalCart.setAttribute("data-product-name", name);
    modalCart.setAttribute("data-product-description", description);
    modalCart.setAttribute("data-product-image", image);
    modalCart.setAttribute("data-product-price", price);  
        
    chatIcon.href = `chatModal.php?seller_id=${sellerId}&customer_id=${customerId}`;
        
    if (stock <= 0) {            
      modalButtons.style.display = "none";        
      outOfStockMessage.style.display = "block"
    } else {
      modalButtons.style.display = "block";        
      outOfStockMessage.style.display = "none"
    }
    
}

// Function to close the modal
function closeProductModal() {
  document.getElementById("productModal").style.display = "none";
}


// function saveTheCartItem(cartItem) {
                                               
//     const data = new URLSearchParams({                    
//         customer_id: sessionStorage.getItem("userId"),                    
//         items : JSON.stringify([
//             {
//                 model_id: cartItem.id,
//                 quantity: cartItem.quantity,
//                 total: cartItem.price * cartItem.quantity
//             }                       
//         ])
//     });                         

//     fetch('/backend/src/customer/route.php?route=customer/save/cart', {
//         method: 'POST',
//         body: data.toString(),
//         headers: {
//             'Content-Type': 'application/x-www-form-urlencoded'
//         }
//     })
//     .then(response => {
//         if (!response.ok) {
//             throw new Error('Network response was not ok');
//         }
//         return response.json();
//     })
//     .then(data => {
//         console.log(data);
//         if (data.success === "Success") {
//             alert("item added to cart")
//         }                 
//     })
//     .catch(error => {
//         console.error('There was a problem with the fetch operation:', error);
//     });
    
// }


// function saveToCart(event) {
    
//     const productId = event.target.getAttribute('data-product-id');
//     const productName = event.target.getAttribute('data-product-name');
//     const productImage = event.target.getAttribute('data-product-image');
//     const productPrice = event.target.getAttribute('data-product-price');
    
//     console.log(productId);
    
//     let updatedItem = {
//         id: productId, 
//         name: productName, 
//         image: productImage, 
//         price: productPrice, 
//         quantity: 1
//     };
                                     
//     // saveTheCartItem(updatedItem)
// }

// Close the modal when clicking outside of it
window.onclick = function(event) {
  const modal = document.getElementById("productModal");
  if (event.target == modal) {
      modal.style.display = "none";
  }
};

