// Get the modal and close button
var modal = document.getElementById("productDetailsModal");
var closeBtn = document.getElementById("closeModalBtn"); // Get the close button by ID
var modalAddToCartBtn = document.getElementById("modalAddToCartBtn");
var productImage = document.getElementById("productImage");
var productName = document.getElementById("productName");
var productPrice = document.getElementById("productPrice");
var productDescription = document.getElementById("productDescription");


//Save button message
function confirmSave() {
    // Display a confirmation dialog
    const userConfirmed = confirm("Do you want to save the change?");
    
    if (userConfirmed) {
        // If the user clicked "Yes," proceed with the save action
        // You can add the code here to submit the form or perform the save action
        alert("Changes saved successfully!");
    } else {
        // If the user clicked "No," cancel the action
        alert("Save canceled.");
    }
}

