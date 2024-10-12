<section class="main-home">
    <div class="slider">
        <div class="slides">
            <input type="radio" name="radio-btn" id="radio1" checked>
            <input type="radio" name="radio-btn" id="radio2">
            <input type="radio" name="radio-btn" id="radio3">
            <div class="slide first">
                <img src="./assets/BGM.jpg" alt="Image 1">
            </div>
            <div class="slide">
                <img src="./assets/BGM3.jpg" alt="Image 2">
            </div>
            <div class="slide">
                <img src="./assets/BGM4.jpg" alt="Image 3">
            </div>
            <div class="navigation-auto">
                <div class="auto-btn1"></div>
                <div class="auto-btn2"></div>
                <div class="auto-btn3"></div>
            </div>
        </div>
        <div class="navigation-manual">
            <label for="radio1" class="manual-btn"></label>
            <label for="radio2" class="manual-btn"></label>
            <label for="radio3" class="manual-btn"></label>
        </div>
    </div>
</section>

<script>
    const header = document.querySelector("header");

    let counter = 1;
    setInterval(function() {
        document.getElementById('radio' + counter).checked = true;
        counter++;
        if (counter > 3) {
            counter = 1;
        }
    }, 5000);
</script>