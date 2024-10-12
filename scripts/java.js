
// Get the modal and close button
var modal = document.getElementById("productDetailsModal");
var closeBtn = document.getElementById("closeModalBtn"); // Get the close button by ID
var modalAddToCartBtn = document.getElementById("modalAddToCartBtn");
var productImage = document.getElementById("productImage");
var productName = document.getElementById("productName");
var productPrice = document.getElementById("productPrice");
var productDescription = document.getElementById("productDescription");

// To track which products are added to the cart
var addedToCart = {};

// Initially ensure modal is hidden
modal.style.display = "none";

// Add event listeners to all product boxes to open modal
document.querySelectorAll('.product-box').forEach(item => {

    item.addEventListener('click', function(event) {
                        
        // Get product ID from the button
        var productId = this.querySelector('.add-to-cart-btn').getAttribute('data-product-id');

        // Prevent modal from opening if the product is already added to the cart
        if (addedToCart[productId]) {
            alert("This product is already in your cart.");
            var userId = localStorage.getItem("user_id")
            const data = new URLSearchParams({                
                customer_id: "3",
                items : JSON.stringify([
                    {
                        model_id: userId,
                        quantity: 2,
                        total: 1798
                    },
                    {
                        model_id: "2",
                        quantity: -1,
                        total: -799
                    }
                ])
                
            });

            // fetch('/backend/src/customer/route.php?route=customer/save/cart', {
            //     method: 'POST',
            //     body: data.toString(),
            //     headers: {
            //         'Content-Type': 'application/x-www-form-urlencoded'
            //     }
            //     })
            //     .then(response => {
            //         if (!response.ok) {
            //             throw new Error('Network response was not ok');
            //         }
            //         return response.json();
            //     })
            //     .then(data => {
            //         console.log(data);
            //     })
            //     .catch(error => {
            //         console.error('There was a problem with the fetch operation:', error);
            //     });

            return; // Don't show the modal if the product was already added
        }

        // Prevent click events from the "Add to Cart" button inside the product-box
        if (event.target.classList.contains('add-to-cart-btn')) {
            // If the "Add to Cart" button outside the modal is clicked, mark the product as added
            addedToCart[productId] = true;
            alert("Product has been added to the cart.");
            return; // Don't open the modal, just perform the add-to-cart action
        }

        // Extract product details from the clicked product
        var imgSrc = this.querySelector('img').src;
        var name = this.querySelector('h4').innerText;
        var price = this.querySelector('.price p').innerText;
        var description = "This is a detailed description for " + name; // Example description

        // Update modal with product details
        productImage.src = imgSrc;
        productName.innerText = name;
        productPrice.innerText = price;
        productDescription.innerText = description; // Set the product description
        
        // Show the modal and disable body scroll
        modal.style.display = "flex";
        document.body.classList.add("modal-open");

        // Store the product ID in the modal for later use
        modal.setAttribute('data-product-id', productId);
    });
});


// Close modal when the close button (X) is clicked
closeBtn.onclick = function() {
    modal.style.display = "none"; // Hide the modal
    document.body.classList.remove("modal-open"); // Remove the scroll lock
}

// Close the modal when clicking outside the modal content
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none"; // Hide the modal
        document.body.classList.remove("modal-open"); // Remove the scroll lock
    }
}

// Close the modal and mark product as added to cart when the "Add to Cart" button is clicked inside the modal
modalAddToCartBtn.onclick = function() {
    // Get the product ID from the modal
    var productId = modal.getAttribute('data-product-id');
    
    // Mark the product as added to cart
    addedToCart[productId] = true;

    // Close the modal
    modal.style.display = "none"; // Hide the modal
    document.body.classList.remove("modal-open"); // Remove the scroll lock

    // Perform the add to cart action here (logic can be added if needed)
    alert("Product has been added to the cart.");
}

