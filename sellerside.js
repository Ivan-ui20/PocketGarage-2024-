const mainSection = document.getElementById('main-section');
const iframe = document.getElementById('content-iframe');
const links = document.querySelectorAll('a');

// function to load content
function loadContent(url) {
    iframe.src = url;
}

// function to load dashboard content
function loadDashboard() {
    mainSection.innerHTML = `
        <h1>Dashboard</h1>
        <div class="date">
          <input type="date" />
        </div>

        <div class="insights">
          <!--selling-->
          <div class="sales">
            <span class="material-symbols-sharp">trending-up</span>
            <div class="middle">
              <div class="left">
                <h3>Total Sales</h3>
                <h1>₱1,000</h1>
              </div>
              <div class="progress">
                <svg>
                  <circle r="30" cy="40" cx="40"></circle>
                </svg>
                <div class="number">80%</div>
              </div>
              <small>Last 24 hours</small>
            </div>
          </div>
        </div>
    `;
}
function loadAddProduct(){
    mainSection.innerHTML = `
    <link rel="stylesheet" href="addproductCSS.css">
<div class="add-product-container">
    <h1>Add Product</h1>
    <form>
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName"><br><br>
        <label for="productDescription">Product Description:</label>
        <textarea id="productDescription" name="productDescription"></textarea><br><br>
        <label for="productPrice">Product Price:</label>
        <input type="number" id="productPrice" name="productPrice"><br><br>
        <label for="productPictures">Product Pictures (up to 5):</label>
        <input type="file" id="productPicture1" name="productPicture1">
        <input type="file" id="productPicture2" name="productPicture2">
        <input type="file" id="productPicture3" name="productPicture3">
        <input type="file" id="productPicture4" name="productPicture4">
        <input type="file" id="productPicture5" name="productPicture5"><br><br>
        <button type="submit" class="btn sell-btn">Sell</button>
        <button type="reset" class="btn cancel-btn">Cancel</button>
    </form>
</div>`;
}

// add event listeners to links
// add event listeners to links
links.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const url = link.getAttribute('href');
        const text = link.querySelector('h3').textContent;

        // remove active class from all links
        links.forEach(link => link.classList.remove('active'));

        // add active class to the clicked link
        link.classList.add('active');

        if (text === 'Dashboard') {
            // load dashboard content
            loadDashboard();
        } else if (text === 'Add product') {
            // load add product content
            loadAddProduct();
        } else {
            // load other content
            // you can add more conditions here
        }
    });
});