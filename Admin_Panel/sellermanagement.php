<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Management</title>
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
</head>
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
            <tr>
                <td>001</td>
                <td>John Doe</td>
                <td>johndoe@example.com</td>
                <td>12345678902</td>
                <td>2024-01-15</td>
                <td>Pending</td>
                <td class="action-buttons">
                    <a href="#" class="btn btn-approve">Approve</a>
                    <a href="#" class="btn btn-reject">Reject</a>
                    <a href="#" class="btn btn-details" onclick="openModal('001')">View Details</a>
                </td>
            </tr>
            <!-- Additional rows as needed -->
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
                <img src="id_back.jpg" alt="ID Back">
            </div>
        </div>
    </div>
</div>


<script>
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
</script>

</body>
</html>
