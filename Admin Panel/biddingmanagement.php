<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Appraisal and Bidding Management</title>
    <style>
        
        .container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {

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
            text-align: center;
        }
        th {
            background-color:  #0b0b45;;
            color: white;
        }
        .action-buttons .btn {
            padding: 5px 10px;
            margin-right: 5px;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            font-size: 0.9em;
            display: inline-block;
        }
        .btn-approve {
            background-color: #28a745;
        }
        .btn-reject {
            background-color: #dc3545;
        }
        .btn-assign {
            background-color: #6f42c1;
        }
        .btn-cancel {
            background-color: #ff6347;
        }
        .btn-flag {
            background-color: #ffc107;
            color: #000;
        }
        .btn-view {
            background-color: #17a2b8;
        }
        .controls {
            margin-top: 20px;
        }
        .form-group {
            margin-top: 20px;
        }
        .form-group input, .form-group button {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1em;
        }
        .btn-pause {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-reactivate {
            background-color: #28a745;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container">
  

    <!-- Bidding Monitoring Section -->
    <h2>Bidding Monitoring</h2>

    <!-- Active Bids Table -->
    <h3>Active Bids</h3>
    <table>
      <thead>
          <tr>
              <th>Item ID</th>
              <th>Item Name</th>
              <th>Appraisal Value</th> <!-- New column for Appraisal Value -->
              <th>Current Bid Amount</th>
              <th>Bidder Username</th>
              <th>Time Left</th>
              <th>Actions</th>
          </tr>
      </thead>
      <tbody>
          <tr>
              <td>201</td>
              <td>Vintage Watch</td>
              <td>$300</td> <!-- Example appraisal value -->
              <td>$250</td> <!-- Current bid amount -->
              <td>bidder123</td>
              <td>2h 30m</td>
              <td class="action-buttons">
                  <a href="#" class="btn btn-cancel">Cancel Bid</a>
                  <a href="#" class="btn btn-flag">Flag for Review</a>
                  <a href="#" class="btn btn-view">View History</a>
              </td>
          </tr>
          <!-- Add more rows as needed -->
      </tbody>
    </table>

    <!-- Fraud Alerts Table -->
    <h3>Fraud Alerts</h3>
    <table>
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Reason</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>202</td>
                <td>Rare Coin</td>
                <td>Suspicious Bidding Activity</td>
                <td class="action-buttons">
                    <a href="#" class="btn btn-cancel">Cancel Bid</a>
                    <a href="#" class="btn btn-view">View History</a>
                </td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>

    <!-- Pause/Remove Items from Bidding -->
    <h3>Pause/Remove Items from Bidding</h3>
    <div class="form-group">
        <label for="item-id">Enter Item ID to Pause/Remove:</label>
        <input type="text" id="item-id" placeholder="Enter Item ID">
        <button class="btn btn-pause">Pause/Remove</button>
    </div>

    <!-- Paused/Removed Items Table -->
    <h3>Paused/Removed Items</h3>
    <table>
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Reason</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>203</td>
                <td>Classic Painting</td>
                <td>Manual Pause</td>
                <td class="action-buttons">
                    <a href="#" class="btn btn-reactivate">Reactivate</a>
                </td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
</div>

</body>
</html>
