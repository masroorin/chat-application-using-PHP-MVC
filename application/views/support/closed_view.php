<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Closed Tickets</title>
    <style>
        .arrivedtickets {
            display: flex;
            margin-top:20px;
        }
       
        #dateRangeForm {
            margin-bottom: 20px; /* Add some space below the form */
            text-align: center;
        }

        /* Style for form labels */
        #dateRangeForm label {
            margin: 5px;
        }

        /* Style for form input fields */
        #dateRangeForm input[type="date"] {
            margin-right: 5px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        /* Style for form submit button */
        #dateRangeForm button[type="submit"] {
            padding: 6px 16px;
            background-color: #1E90FF;
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        /* Hover effect for form submit button */
        #dateRangeForm button[type="submit"]:hover {
            background-color: #1E90CF;
        }
        
        .filter-btns {
            position: fixed;
            margin: 10px 0;
            top: 20%;
        }
        .filter-btns a {
            text-decoration: none; /* Remove underline */
            
        }
        .filter-btn {
            display: block;
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
        
        .vertical-hr {
            position: fixed;
            height: 100%;
            width: 1px;
            background-color: black;
            border: none;
            margin: 0;
            left: 15%;
        }

        .content-section {
            flex: 1;
            
        }
        .filter-section {
            flex: 0 0 auto;
            margin: 30px;
            margin-top: 10px;
        }
        .table-container {
            max-height: 380px;
            width: 80%;
            overflow-y: auto;
            position: fixed;
            left: 135px;
        }
        .ticket-table {
            width: 70%;
            margin-left:18%;
            border-collapse: collapse;
        }

        /* Style for table headers */
        .ticket-table thead th {
            position: sticky;
            top: 0;
            padding: 8px;
            background-color: #f2f2f2;
        }

        /* Style for table cells */
        .ticket-table td {
            border: 1px solid #ddd;
            padding: 8px;            
        }

        /* Style for alternating rows */
        .ticket-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .ticket-link {
            color: black; /* Set anchor tag color to black */
            text-decoration: none; /* Remove underline */
        }

        /* Hover effect for anchor tag */
        .ticket-link:hover {
            text-decoration: underline; /* Add underline on hover */
        }
       .sectionh2{
        text-align: center;
       }
       .back-btn {
            position: fixed;
        }
        .back-btn a {
            text-decoration: none;
            color: #333; /* Adjust the color as needed */
            font-size: 20px; /* Adjust the size as needed */
        }
    </style>
</head>
<body>
    <div class="arrivedtickets" >
        <!-- <div class="back-btn">
            <a href="<?php echo base_url('index.php/Fetch'); ?>" title="Open tickets view"><i class="fas fa-arrow-left"></i></a>
        </div> -->
        <div class = "filter-section">
            <div class="filter-btns">
                <a href="<?php echo base_url('index.php/Arrived'); ?>" class="filter-btn">Arrived</a>
                <a href="<?php echo base_url('index.php/Accepted'); ?>" class="filter-btn">Accepted</a>
                <a href="<?php echo base_url('index.php/Closed'); ?>" class="filter-btn">Closed</a>
                <a href="<?php echo base_url('index.php/Pending'); ?>" class="filter-btn">Pending</a>
            </div>
        </div>
        <hr class="vertical-hr">
        <div class="content-section">
            <div class="date-container">
                <h2 class="sectionh2">Closed Tickets</h2>
                <form id="dateRangeForm" action="<?php echo base_url('index.php/ClosedDate'); ?>" method="POST">
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" value="<?= isset($start_date) ? $start_date : '' ?>">
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date" value="<?= isset($end_date) ? $end_date : '' ?>">
                    <button type="submit">Filter</button>
                </form>
            </div>
            <div class = "table-container">
                <table class="ticket-table">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Created At</th>
                            <th>Accepted At</th>
                            <th>Closed At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tickets)): ?>
                            <?php foreach ($tickets as $ticket): ?>
                                <tr>
                                    <td>
                                    <a href="<?php echo base_url('index.php/ViewMessages/') . $ticket['ticket_id']; ?>" class = "ticket-link">
                                        <?php echo $ticket['ticket_id']; ?>
                                    </a>
                                    </td>
                                    <td><?php echo $ticket['created_at']; ?></td>
                                    <td><?php echo $ticket['accepted_at']; ?></td>
                                    <td><?php echo $ticket['closed_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2">No tickets found within the specified date range.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<!--<script>
    // Retrieve message from local storage and populate the input field
    document.getElementById('user-input').value = localStorage.getItem('typedMessage') || '';

    // Store the message in local storage whenever user types in the input field
    document.getElementById('user-input').addEventListener('input', function() {
        localStorage.setItem('typedMessage', this.value);
    });

    // Function to handle sending message without page reload
    function sendMessage(event) {
        // Prevent the form from submitting
        event.preventDefault();

        // Retrieve the typed message from the input field
        var message = document.getElementById('user-input').value;

        // Check if the message is not empty
        if (message.trim() !== '') {
            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Define the POST request parameters
            xhr.open('POST', '<?= base_url('index.php/UserReply') ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Define the function to handle the AJAX response
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Message sent successfully, handle any response here if needed

                        // Add the message to the message container
                        var messageContainer = document.getElementById('message-container');
                        var newMessage = document.createElement('p');
                        newMessage.className = 'user-message';
                        newMessage.textContent = message;
                        messageContainer.appendChild(newMessage);

                        // Clear the input field
                        document.getElementById('user-input').value = '';

                        // Scroll the message container to the bottom
                        messageContainer.scrollTop = messageContainer.scrollHeight;

                        // Clear the message from local storage
                        localStorage.removeItem('typedMessage');
                    } else {
                        // Error handling if message failed to send
                        console.error('Error sending message:', xhr.status);
                    }
                }
            };

            // Send the message as the POST body
            xhr.send('user-input=' + encodeURIComponent(message));
        }
    }
</script>-->