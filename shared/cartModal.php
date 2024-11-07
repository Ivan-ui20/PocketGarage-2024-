
<div id="cart-modal" class="cart-modal">
    <div class="cart-modal-content">
        <h4 class="">Cart</h4>
        <span class="close">&times;</span>

        <!-- <div class="cart-total">
            <strong>Total:</strong> <span id="cart-total-price">                
            </span>
        </div> -->
       
        <!-- <button id="checkout-btn" class="checkout-btn">CHECKOUT</button> -->
    </div>
</div>

<script>
        
    document.getElementById('cart-icon').addEventListener('click', function (e) {        
        // const cartModal = document.getElementById('cart-modal');
        const checkout = document.getElementById("checkout-modal-container")
        
        e.preventDefault();
        updateCartModal();

        checkout.style.display = 'flex';
    });

    document.querySelector('.cart-modal .close').addEventListener('click', function () {           
        // const cartModal = document.getElementById('cart-modal');
        
        cartModal.style.display = 'none';
    });

    // const cartModal = document.getElementById('cart-modal');
    window.addEventListener('click', function (event) {
        if (event.target == cartModal) {
            cartModal.style.display = 'none';
        }
    });

</script>

