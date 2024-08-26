<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <title>Support Chat</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .ticket-container {
            margin-top: -280px;
            max-height: 550px; /* Adjust the maximum height as needed */
            overflow-y: auto;
        }
        .container11 {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 300px; /* Adjust the maximum width as needed */
            margin-left: 1150px;
            margin-block: 10px ;
            background-color: #fff;
            border: 2px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .message-container {
            max-height: 150px;
            overflow-y: auto;
            margin: 10px 0px;
        }

        .message-container p {
            margin: 5px 0;
        }

        .user-message {
            background-color: #DCDCDC;
            color: #000000;
            font-size: 14px;
            border-radius: 10px;
            padding: 10px;
            max-width: 70%; 
            word-wrap: break-word;
            clear: both; /* Ensure user messages appear below any floating admin messages */
            float: left; /* Float user messages to the left */
        }

        .admin-message { 
            background-color: #1E90FF;
            color: #fff;
            font-size: 14px;
            border-radius: 10px;
            padding: 10px;
            max-width: 70%; 
            word-wrap: break-word;
            clear: both; /* Ensure admin messages appear below any floating user messages */
            float: right; /* Float admin messages to the right */
        }


        .input-container {
            display: flex;
            align-items: center;
        }

        #user-input {
            flex: 1;
            padding: 10px;
            border-radius: 15px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        #message-form button {
            border: none;
            border-radius: 50%;
            cursor: pointer;
            padding: 10px;
            background-color: ;
            color: #fff;
        }

        #message-form button:hover {
            background-color: #007bff;
        }

        .close-button {
            background-color: #1E90FF;
            color: #fff;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .close-button:hover {
            background-color: #007bff;
        }

        .centered-button-container {
            text-align: center;
        }
    </style>
    
</head>  
<body>
<div class="ticket-container"> 
<?php foreach ($all_messages as $ticket_id => $messages) : ?>
        <div class="container11">
            <!-- Button for closing the ticket -->
            <div class="centered-button-container" >
            <form action="<?= base_url('index.php/CloseTicket') ?>" method="POST">
                <input type="hidden" name="ticket_id" value="<?= $ticket_id ?>">
                <button type="submit" class="close-button" style="font-family: 'Comic Sans MS', Comic Sans, cursive; font-weight: bold;">Close Ticket</button>
            </form>

            </div>  
            <!-- Display existing messages if available -->
            <div class="message-container" id="message-container">
                <?php if (!empty($messages)) : ?>
                    <?php foreach ($messages as $message) : ?>
                        <?php if ($message['sender'] === 'admin') : ?>
                            <p class="admin-message"><?php echo $message['message']; ?></p>
                        <?php else : ?>
                            <p class="user-message"><?php echo $message['message']; ?></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No messages available</p>
                <?php endif; ?>
            </div>

            <!-- Form for admin to send a reply -->
            <form action="<?= base_url('index.php/SupportReply') ?>" method="POST" id="message-form" onsubmit="clearInput()">
                <div class="input-container">
                    <textarea id="user-input" name="message" rows="1" placeholder="Type your message here..."></textarea>
                    <input type="hidden" name="ticket_id" value="<?= $ticket_id ?>">
                    <button type="submit">
                        <i class="fas fa-paper-plane" style="color: #1E90FF;"></i> <!-- Send icon -->
                    </button>
                </div>
            </form>
        </div>
    <?php endforeach; ?>
                </div>

    <!-- Script to ensure new messages are always visible at the bottom -->
    <script>
        // Scroll to the bottom of the message container
        document.querySelectorAll('.message-container').forEach(function(container) {
            container.scrollTop = container.scrollHeight;
        });
    </script>
    <script>
        // Retrieve message from local storage and populate the input field
        document.getElementById('user-input').value = localStorage.getItem('typedMessage') || '';

        // Store the message in local storage whenever user types in the input field
        document.getElementById('user-input').addEventListener('input', function() {
            localStorage.setItem('typedMessage', this.value);
        });

        // Function to clear the input field after submitting the form
        function clearInput() {
            // Clear the message from local storage
            localStorage.removeItem('typedMessage');
        }    
    </script>
</body>
</html>
