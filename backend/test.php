<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch Data Example</title>

    <body>
        
        <form id="productForm">
            <input type="file" id="fileInput" name="model_image" />
            <button type="button" onclick="addProductWithFile()">Add Product</button>
        </form>
    </body>
    <script>
        // This function will be called every time the page loads
        function sendData() {       
            // const data = new URLSearchParams({
            //     route: 'customer/login',
            //     first_name: "John 1",
            //     last_name: "Doe",
            //     contact_number: "1234567890",
            //     address: "123 Main St, Anytown, USA",
            //     email_address: "johndoe@example.com",
            //     password: "pass123"
            // });

            // const data = new URLSearchParams({
            //     route: 'customer/send/order',
            //     customer_id: "3",                
            //     shipping_addr: "Sa tabi ng kanto ng dagat",                
            //     order_total: "2597",
            //     order_payment_option: "Cash on delivery",
            //     items : JSON.stringify([
            //         {
            //             model_id: "1",
            //             quantity: 2,
            //             total: 1798
            //         },
            //         {
            //             model_id: "2",
            //             quantity: 1,
            //             total: 799
            //         }
            //     ])
                
            // });

            // const data = new URLSearchParams({
            //     route: 'customer/save/cart',
            //     customer_id: "3",
            //     items : JSON.stringify([
            //         {
            //             model_id: "1",
            //             quantity: 2,
            //             total: 1798
            //         },
            //         {
            //             model_id: "2",
            //             quantity: -1,
            //             total: -799
            //         }
            //     ])
                
            // });

            // const data = new URLSearchParams({
            //     route: 'seller/update/status/order',
            //     order_id: "4",
            //     order_ref_no: "REF-3-1728003594-571BD2",
            //     order_status: "To ship",                                
            // });

            // const data = new URLSearchParams({
            //     route: 'seller/add/product',
            //     seller_id: "12",
            //     size_id: "4",
            //     brand_id: "2",
            //     model_name: "Model X",
            //     model_description: "This is a detailed model of Model X.",
            //     model_price: "1999",
            //     model_stock: "50",
            //     model_availability: "Available",
            //     model_tags: "Limited Edition, New Arrival",
            //     model_type: "Premium",                                
            // });
            
            // fetch('/backend/src/customer/route.php?route=customer/login', {
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


            const id = 12
            // fetch(`/backend/src/seller/route.php?route=seller/get/products&seller_id=${id}`, {
            fetch(`/backend/src/customer/route.php?route=products`, {
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
                    console.log(data);
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
           
        }

        // Call sendData when the window loads
        window.onload = sendData;
    </script>
    <!-- <script>
        async function addProductWithFile() {

            const formData = new FormData();
                        
            formData.append('seller_id', '12');
            formData.append('size_id', '4');
            formData.append('brand_id', '2');
            formData.append('model_name', 'Model X');
            formData.append('model_description', 'This is a detailed model of Model X.');
            formData.append('model_price', '1999');
            formData.append('model_stock', '50');
            formData.append('model_availability', 'Available');
            formData.append('model_tags', 'Limited Edition, New Arrival');
            formData.append('model_type', 'Premium');

           
            const fileInput = document.querySelector('input[type="file"]'); 
            if (fileInput.files.length > 0) {
                formData.append('model_image', fileInput.files[0]); 
            } else {
                console.error('No file selected for upload');
                return; // Exit if no file is selected
            }

            try {
                const response = await fetch('/backend/src/seller/route.php?route=seller/add/product', {
                    method: 'POST', // Use POST method
                    body: formData // Send the FormData object as the request body
                });

                // Check if the response is okay
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                // Parse the JSON response
                const responseData = await response.json();
                
                // Log the response data or handle it as needed
                console.log('Response:', responseData);
            } catch (error) {
                console.error('Error during fetch:', error);
            }
        }

    </script> -->
</head>
<body>
    <h1>Fetch Data on Page Load</h1>
    <p>Check the console for the fetch response.</p>
</body>
</html>
