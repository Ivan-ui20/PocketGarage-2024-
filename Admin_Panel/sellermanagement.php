

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
            $stmt = $conn->prepare("SELECT 
                seller.seller_id, 
                seller.front_id_url, 
                seller.back_id_url, 
                proof_seller_url, 
                seller.status as seller_status, 
                customer.* 
                FROM seller LEFT JOIN customer ON customer.customer_id = seller.user_id");
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
                    $status = htmlspecialchars($row['seller_status']);
                    $frontIdUrl = htmlspecialchars($row['front_id_url']);
                    $backIdUrl = htmlspecialchars($row['back_id_url']);
                    
                    // Set data-status attribute for filtering
                    echo "<tr data-status='{$status}' onclick=\"showDetailsModal(
                    '{$sellerId}', 
                    '{$fullname}', 
                    '{$email}', 
                    '{$contactNumber}', 
                    '{$status}', 
                    '{$frontIdUrl}', 
                    '{$backIdUrl}')\">";
                    
                    echo "<td>{$sellerId}</td>";
                    echo "<td>{$fullname}</td>";
                    echo "<td>{$email}</td>";
                    echo "<td>{$contactNumber}</td>";                        
                    echo "<td>{$formattedDate}</td>";
                    echo "<td>{$status}</td>";
                    echo '<td class="action-buttons">';
                    if ($status === "Approved") {                        
                        echo "<a href=\"#\" class=\"btn btn-reject\" onclick=\"updateSellerStatus({$sellerId}, 'Deactivated')\">Deactivate</a>";
                    } else if ($status === "Deactivated") {                        
                        echo "<a href=\"#\" class=\"btn btn-approve\" onclick=\"updateSellerStatus({$sellerId}, 'Approved')\">Activate</a>";
                    } else if ($status === "Pending") {
                        echo "<a href=\"#\" class=\"btn btn-approve\" onclick=\"updateSellerStatus({$sellerId}, 'Approved')\">Approve</a>";
                        echo "<a href=\"#\" class=\"btn btn-reject\" onclick=\"updateSellerStatus({$sellerId}, 'Deactivated')\">Deactivate</a>";
                    } else {
                        echo "";
                    }
                    
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No sellers found.</td></tr>";
            }

            $stmt->close();
        ?>      
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


<div id="detailsModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div id="modal-header" class="modal-header">User Details</div>

        <p><strong>Fullname:</strong> <span id="details-fullname"></span></p>
        <p><strong>Email:</strong> <span id="details-email"></span></p>
        <p><strong>Mobile Number:</strong> <span id="details-contact-number"></span></p>
        <p><strong>Status:</strong> <span id="details-status"></span></p>

        <!-- ID Images Section -->
        <div class="id-images">
            <div>
                <p><strong>Valid ID (Front):</strong></p>
                <img id="details-front-id" src="" alt="ID Front">
            </div>
            <div>
                <p><strong>Valid ID (Back):</strong></p>
                <img id="details-back-id" src="" alt="ID Back">
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
    function showDetailsModal(sellerId, fullname, email, contactNumber, status, frontIdUrl, backIdUrl) {
        // Update the modal header
        document.getElementById('modal-header').textContent = "Seller Details";

        // Populate modal content
        document.getElementById('details-fullname').textContent = fullname;
        document.getElementById('details-email').textContent = email;
        document.getElementById('details-contact-number').textContent = contactNumber;
        document.getElementById('details-status').textContent = status;

        // Update ID images
        document.getElementById('details-front-id').src = "http://pocket-garage.com/backend/" + frontIdUrl || 'placeholder.jpg';
        document.getElementById('details-back-id').src = "http://pocket-garage.com/backend/" +  backIdUrl || 'placeholder.jpg';

        // Show the modal
        document.getElementById('detailsModal').style.display = 'block';
    }

    // Close the modal
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
</script>

</body>
</html>
