<div id="useragreementModal" class="modalfooter">
    <div class="modal-content">
        <p>To continue using PocketGarage, please review and agree to our 
            <a href="#" id=openTermsBtn onclick="showSection('term-section')">Terms & Conditions</a> and 
            <a href="#" onclick="showSection('privacy-section')">Privacy Policy</a>.
        </p>
        <div class="terms-content" id="termsContent">
            <p>Do you agree to the Terms & Conditions and Privacy Policy?</p>
        </div>
        <div class="modal-buttons">
            <button id="agreeBtn" class="action-button">I Agree</button>
        </div>
    </div>
</div>


<div id="pageOverlay">

<div id="term-section" class="section"><?php include './shared/TermsModal.php';?>
</div>
<div id="privacy-section" class="section"><?php include './shared/PrivacyModal.php';?>
</div>

</div> <!-- Overlay to disable page interaction -->


   


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

    .section {
        display: none; /* Hidden by default */
    }
    .section.active {
        display: block; /* Displayed when active */
    }

    .terms-conditions-section {
    display: none; /* Hide by default */
}

</style>

<script>
        document.addEventListener("DOMContentLoaded", function() {
            const userAgreementModal = document.getElementById("useragreementModal");
            const agreeBtn = document.getElementById("agreeBtn");
            const pageOverlay = document.getElementById("pageOverlay");

            // Check if the user has already agreed
            const hasAgreed = localStorage.getItem("userAgreedToTerms") === "true";

            // Only show the modal if the user hasn't agreed
            if (!hasAgreed) {
                userAgreementModal.style.display = "flex";
                pageOverlay.style.display = "block";
                document.body.style.overflow = "hidden";
            }

            if (hasAgreed) {
                userAgreementModal.style.display = "none";
                pageOverlay.style.display = "none";
                document.body.style.overflow = "";
                localStorage.setItem("userAgreedToTerms", "true"); // Save agreement status
            }

            // Event listener for the "Agree" button
            agreeBtn?.addEventListener("click", function() {
                userAgreementModal.style.display = "none";
                pageOverlay.style.display = "none";
                document.body.style.overflow = "";
                localStorage.setItem("userAgreedToTerms", "true"); // Save agreement status
            });

        
        });

  
        function showSection(sectionId) {
        // Hide all sections first
        const sections = document.querySelectorAll('.section');
        sections.forEach(section => section.classList.remove('active'));

        // Show the selected section
        const selectedSection = document.getElementById(sectionId);
        if (selectedSection) {
            selectedSection.classList.add('active');
            pageOverlay.style.display = "block";
            document.body.style.overflow = "hidden";
        } else {
            console.error(`Section with ID '${sectionId}' not found.`);
        }

    }

     // Close the selected section and overlay
     function closeSection(sectionId) {
        const selectedSection = document.getElementById(sectionId);
        if (selectedSection) {
            selectedSection.classList.remove('active');
            pageOverlay.style.display = "block";
            document.body.style.overflow = "hidden";
        }
    }

      // Function to load the last active section on page load
      window.addEventListener('DOMContentLoaded', () => {
        try {
            // Retrieve the last active section from localStorage, default to 'dashboard' if none found
            const savedSection = localStorage.getItem('activeSection') || 'dashboard';
            
            // Verify the section exists before displaying
            const sectionExists = document.getElementById(savedSection);
            if (sectionExists) {
                showSection(savedSection);
                console.log(`Loaded section from storage: ${savedSection}`);
            } else {
                console.warn(`Saved section '${savedSection}' not found. Loading default section.`);
                showSection('dashboard');
            }
        } catch (error) {
            console.error('Error loading saved section:', error);
            showSection('dashboard'); // Default to dashboard on error
        }
    });


    closeTermsBtn.addEventListener('click', closeTerms);

    </script>

