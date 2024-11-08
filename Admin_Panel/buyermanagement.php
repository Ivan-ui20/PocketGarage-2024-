
    <style>
    
    .container-buyer {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;

            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 12px;

        }
        th {
            background-color: #007BFF;
            color: white;
            text-align: center;
        }

        
        .action-buttons .btn {
            padding: 5px 10px;
            margin-right: 5px;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            font-size: 0.9em;
        }
        .btn-approve {
            background-color: #28a745;
        }
        .btn-reject {
            background-color: #dc3545;
        }
        .btn-details {
            background-color: #17a2b8;
        }
        .controls {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .controls select, .controls button {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1em;
        }
        .btn-notify {
            background-color: #007BFF;
            color: #fff;
            border: none;
        }
        .container-buyer th.actions, td.actions {
          width: 20%; /* Adjust as needed */
          text-align: center;
      }
    </style>

<body>

<div class="container-buyer">
    <h2>Buyer Management</h2>

    <!-- Pending Registrations Table -->
    <table>
    <thead>
        <tr>
            <th>User ID</th>
            <th>Full name</th>
            <th>Email</th>
            <th>Mobile Number</th>
            <th>Address</th>
            <th>Registration Date</th>
            <th>Status</th>
            <th class="actions">Actions</th> 
        </tr>
    </thead>
    <tbody>
        <?php
            $stmt = $conn->prepare("SELECT * FROM customer");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Loop through each seller and create a table row
                while ($row = $result->fetch_assoc()) {
                    $sellerId = htmlspecialchars($row['customer_id']);
                    $fullname = htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']);
                    $email = htmlspecialchars($row['email_address']);
                    $contactNumber = htmlspecialchars($row['contact_number']);
                    $address = htmlspecialchars($row['address']);
                    $registrationDate = htmlspecialchars($row['created_at']);
                    $dateTime = new DateTime($registrationDate);
                    $registrationDate = htmlspecialchars($dateTime->format('F j Y, H:i'));
                    $status = htmlspecialchars($row['status']);
                    
                    echo "<tr data-status='{$status}'>";
                    echo "<td>{$sellerId}</td>";
                    echo "<td>{$fullname}</td>";
                    echo "<td>{$email}</td>";
                    echo "<td>{$contactNumber}</td>";
                    echo "<td>{$address}</td>";
                    echo "<td>{$registrationDate}</td>";
                    echo "<td>{$status}</td>";
                    echo '<td class="action-buttons">';
                    echo "<a href=\"#\" class=\"btn btn-approve\" onclick=\"updateSellerStatus({$sellerId}, 'Active')\">Activate</a>";
                    echo "<a href=\"#\" class=\"btn btn-reject\" onclick=\"updateSellerStatus({$sellerId}, 'Deactivated')\">Deactivate</a>";
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
        <!-- Filter by Account Status -->
        <div>
            <label for="status-filter">Filter by Account Status:</label>
            <select id="status-filter">
                <<option value="all">All</option>
              <option value="active">Active</option>
              <option value="deactivated">Deactivated</option>
            </select>
        </div>

        <!-- Notifications Button -->
        <button class="btn-notify">Send Status Updates</button>
    </div>
</div>

</body>

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

    async function updateSellerStatus(id, status) {           
        const data = new URLSearchParams({
            customer_id: id,
            status: status
        }); 

        const response = await fetch('/backend/src/admin/route.php?route=admin/buyer/status', {
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
</html>
