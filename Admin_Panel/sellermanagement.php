

    <style>
        /* Basic styling */
    
        .container-seller {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .action-buttons a {
            padding: 5px 10px;
            text-decoration: none;
            color: #fff;
            border-radius: 3px;
            margin-right: 5px;
        }
        .btn-approve { background-color: #28a745; }
        .btn-reject { background-color: #dc3545; }
        .btn-details { background-color: #17a2b8; }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 700px;
            text-align: left;
        }
        .modal-header {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .close {
            float: right;
            font-size: 1.2em;
            color: #aaa;
            cursor: pointer;
        }
        .close:hover {
            color: #000;
        }
        .id-images {
            display: flex;
            gap: 10px;
        }
        .id-images img {
            width: 200px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .transaction-list {
            margin-top: 10px;
        }

        .container-seller th.actions, td.actions {
          width: 32%; /* Adjust as needed */
          text-align: center;
      }
    </style>

<body>

<div class="container-seller">
    <h2>Seller Management</h2>

    <!-- Pending Registrations Table -->
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Fullname</th>
                <th>Email</th>
                <th>Mobile Number</th>
                <th>Registration Date</th>
                <th>Status</th>
                <th class="actions">Actions</th> 
            </tr>
        </thead>
        <tbody>
        <?php
            $stmt = $conn->prepare("SELECT * FROM seller");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $sellerId = htmlspecialchars($row['seller_id']);
                    $fullname = htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']);
                    $email = htmlspecialchars($row['email_address']);
                    $contactNumber = htmlspecialchars($row['contact_number']);
                    $registrationDate = htmlspecialchars($row['created_at']);
                    $dateTime = new DateTime($registrationDate);
                    $formattedDate = htmlspecialchars($dateTime->format('F j Y, H:i'));
                    $status = htmlspecialchars($row['status']);
                    
                    // Set data-status attribute for filtering
                    echo "<tr data-status='{$status}'>";
                    echo "<td>{$sellerId}</td>";
                    echo "<td>{$fullname}</td>";
                    echo "<td>{$email}</td>";
                    echo "<td>{$contactNumber}</td>";                        
                    echo "<td>{$formattedDate}</td>";
                    echo "<td>{$status}</td>";
                    echo '<td class="action-buttons">';
                    echo "<a href=\"#\" class=\"btn btn-approve\" onclick=\"updateSellerStatus({$sellerId}, 'Verified')\">Activate</a>";
                    echo "<a href=\"#\" class=\"btn btn-reject\" onclick=\"updateSellerStatus({$sellerId}, 'Not Verified')\">Deactivate</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No sellers found.</td></tr>";
            }

            $stmt->close();
        ?>      
            <!--add hyperlink for detailsModal      echo "<a href=\"#\" class=\"btn btn-details\" onclick=\"openDetailsModal({$sellerId})\">View Details</a>"; // Added hyperlink for details-->

    </tbody>

    </table>

    <!-- Account Management Options -->
    <div class="controls">
        <label for="status-filter">Filter by Account Status:</label>
        <select id="status-filter">
            <option value="all">All</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
            <option value="deactivated">Deactivated</option>
        </select>
    </div>
</div>

<!-- Modal for Viewing Details -->
<div id="detailsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="modal-header">User Details</div>

        <p><strong>Fullname:</strong> John Doe</p>
        <p><strong>Email:</strong> johndoe@example.com</p>
        <p><strong>Mobile Number:</strong> 12345678902</p>
        <p><strong>Account Type:</strong> Seller</p>
        <p><strong>Status:</strong> Pending</p>

        <!-- ID Images Section -->
        <div class="id-images">
            <div>
                <p><strong>Valid ID (Front):</strong></p>
                <img src="id_front.jpg" alt="ID Front">
            </div>
            <div>
                <p><strong>Valid ID (Back):</strong></p>
                <img src="id_back.jpg" alt="ID Back">
            </div>
        </div>

        <!-- Past Transactions Section -->
        <div class="transaction-list">
     <div>          
            <h4>Past Transactions:</h4>
                <img src="id_back.jpg" alt="Proof of Transaction">
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById("status-filter").addEventListener("change", function() {
        const selectedStatus = this.value;
        const rows = document.querySelectorAll("tbody tr");

        rows.forEach(row => {
            const rowStatus = row.getAttribute("data-status").toLowerCase();
            
            if (selectedStatus === "all" || rowStatus === selectedStatus) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
    // Open modal and display details
    function openModal(userId) {
        // Here you could add logic to fetch and display user data dynamically
        document.getElementById('detailsModal').style.display = 'flex';
    }

    // Close modal
    function closeModal() {
        document.getElementById('detailsModal').style.display = 'none';
    }

    // Close modal if clicking outside of it
    window.onclick = function(event) {
        let modal = document.getElementById('detailsModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    async function updateSellerStatus(id, status) {           
        const data = new URLSearchParams({
            seller_id: id,
            status: status
        }); 

        const response = await fetch('/backend/src/admin/route.php?route=admin/seller/status', {
            method: 'POST', 
            body: data 
        });          
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }          
        const responseData = await response.json();
                                            
        alert(responseData.message)
        window.location.reload();
    }

        /* FOR Opendetails sample

            function openDetailsModal(sellerId) {
            // Fetch seller details using sellerId (AJAX or server-side request)
            fetch(`getSellerDetails.php?seller_id=${sellerId}`)
                .then(response => response.json())
                .then(data => {
                    // Populate modal with seller details dynamically
                    document.getElementById('modal-fullname').textContent = `${data.first_name} ${data.last_name}`;
                    document.getElementById('modal-email').textContent = data.email_address;
                    document.getElementById('modal-contact').textContent = data.contact_number;
                    document.getElementById('modal-account-type').textContent = data.account_type; // e.g., Seller
                    document.getElementById('modal-status').textContent = data.status;

                    // Populate ID Images
                    document.getElementById('modal-id-front').src = data.id_front; // Image URL from server
                    document.getElementById('modal-id-back').src = data.id_back;   // Image URL from server

                    // Populate Past Transaction Proof (assuming proof is available)
                    document.getElementById('modal-transaction-proof').src = data.transaction_proof; // Image URL for transaction proof

                    // Show the modal
                    document.getElementById('detailsModal').style.display = 'block';
                })
                .catch(error => console.error('Error fetching seller details:', error));
        }

        function closeModal() {
            document.getElementById('detailsModal').style.display = 'none';
        }

        */ 
</script>





</body>
</html>
