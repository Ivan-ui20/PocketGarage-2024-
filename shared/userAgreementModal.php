<div id="useragreementModal" class="modalfooter">
    <div class="modal-content">
        <p>To continue using PocketGarage, please review and agree to our <a href="#" onclick="showSection('terms-section')">Terms & Conditions</a> and <a href="/about">Privacy Policy</a>.</p>
        <div class="terms-content">
            <p>Do you agree to the Terms & Conditions and Privacy Policy?</p>
        </div>
        <div class="modal-buttons">
            <button id="agreeBtn" class="action-button">I Agree</button>
        </div>
    </div>
</div>


<div id="pageOverlay"></div> <!-- Overlay to disable page interaction -->



    <style>
    /* Styles for overlay to disable interaction */
    #pageOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: none;

    }



</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const termsModal = document.getElementById("useragreementModal");
    const agreeBtn = document.getElementById("agreeBtn");
    const pageOverlay = document.getElementById("pageOverlay");

    const isLoggedIn = localStorage.getItem("isLoggedIn") === "true";
    const hasAgreed = localStorage.getItem("userAgreedToTerms") === "true";

    if (!hasAgreed && !isLoggedIn) {
        termsModal.style.display = "flex";
        pageOverlay.style.display = "block";
        document.body.style.overflow = "hidden";
    }

    agreeBtn?.addEventListener("click", function() {
        if (termsModal && pageOverlay) {
            termsModal.style.display = "none";
            pageOverlay.style.display = "none";
            document.body.style.overflow = "";
            localStorage.setItem("userAgreedToTerms", "true");
        }
    });
});


</script>