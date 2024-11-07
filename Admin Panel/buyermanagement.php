<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Seller and Buyer Management</title>
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
</head>
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
        <tr>
            <td>001</td>
            <td>johndoe</td>
            <td>johndoe@example.com</td>
            <td>12345678901</td>
            <td>123 Main St, Anytown, USA</td>
            <td>2024-01-15</td>
            <td>Active</td>
            <td class="action-buttons">
                      <a href="#" class="btn btn-approve">Activate</a>
                      <a href="#" class="btn btn-reject">Deactivate</a>
                  </td>
        </tr>
        
        <!-- Add more rows as needed -->
    </tbody>
  </table>

    <!-- Account Management Options -->
    <div class="controls">
        <!-- Filter by Account Status -->
        <div>
            <label for="status-filter">Filter by Account Status:</label>
            <select id="status-filter">
                <<option value="all">All</option>
              <option value="deactivated">Active</option>
              <option value="deactivated">Deactivated</option>
            </select>
        </div>

        <!-- Notifications Button -->
        <button class="btn-notify">Send Status Updates</button>
    </div>
</div>

</body>
</html>
