<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Tickets</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- Include jQuery library -->

    <style>
        body {
            font-family: Arial, sans-serif;
            overflow: hidden;
        }
        .containerabc{
            margin: 30px;
            padding: 30px;
            background: #F5F5DC;
            height: 100%;
            border: 1px solid #0000;
        }
        .filter-section{
            margin-bottom: 30px;
        }
        .table-container11 {
            overflow-y: auto;

        } 
        .ticket-table {
            width: 70%;
            border-collapse: collapse;
        }

        .ticket-table thead th {
            position: sticky;
            top: 0;
            padding: 8px;
            background-color: #f2f2f2;
        }

        .ticket-table td {
            border: 1px solid #ddd;
            padding: 8px;            
        }

        .ticket-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        
        .ticket_view {
            margin-bottom: 20px; /* Add some space below the form */
            
        }

        label {
            margin-right: 10px; /* Add spacing between label and input */
        }

        input[type="date"] {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-right: 10px; /* Add spacing between input fields */
        }

        .filter {                        /*for date range */
            padding: 6px 16px;
            background-color: #1E90FF;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .filter-btn {
            text-align: center;
            width: 100px;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #1E90FF;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .filter-btn:hover {
            background-color: #1E90CF;
        }
        
        
    </style>
</head>
<body>
    <div class="containerabc">
        <div class="filter-section">
            <h2 class="tickets1">Tickets</h2>
            <div class="filter-btns">
                <a href="<?php echo base_url('index.php/Arrived'); ?>" class="filter-btn">Arrived</a>
                <a href="<?php echo base_url('index.php/Accepted'); ?>" class="filter-btn">Accepted</a>
                <a href="<?php echo base_url('index.php/Closed'); ?>" class="filter-btn">Closed</a>
                <a href="<?php echo base_url('index.php/Pending'); ?>" class="filter-btn">Pending</a>
            </div>
        </div>
        <hr class="vertical-hr">
        <div class="content-section">
            <h2 class = "opentickets" >Open Tickets</h2>
            <form action="<?= base_url('index.php/FindbyDate') ?>" method="post" class="ticket_view">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="<?= isset($start_date) ? $start_date : '' ?>">
                
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" value="<?= isset($end_date) ? $end_date : '' ?>">

                <button class="filter" type="submit">Filter</button>
            </form>

            <p class="ticketp" >Total number of tickets arrived: <?php echo $ticket_count; ?></p>
            <p class="ticketp" >Number of tickets accepted by <?php echo $this->session->userdata('user_email'); ?>: <?php echo $accepted_tickets_count; ?></p>
           
        </div>
        
        <div class= "table-container11">
            <table class="ticket-table">
                <thead>
                    <tr>    
                        <th>Ticket ID</th> 
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($open_tickets as $ticket) : ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url('index.php/AcceptTicket/') . $ticket['ticket_id']; ?>">
                                    <?php echo $ticket['ticket_id']; ?>
                                </a>
                            </td>
                            <td>
                                <?php echo $ticket['acceptance']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // Reload the page every 30 seconds
        setInterval(function() {
            location.reload();
        }, 20000); // Adjust the interval as needed (in milliseconds)
    </script>
</body>
</html>
