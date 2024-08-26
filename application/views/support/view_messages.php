<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Ticket Messages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 10px;
            overflow: hidden;
        }
        h6{
            text-align: center;
        }
        .ticketmessage {
            position: fixed;
            width: 400px;
            height: 460px;
            left: 500px;
            margin-top: 100px;
            padding: 20px;
            background-color: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .message-container {
            margin-top: 15px;
            max-height: 400px; 
            overflow: auto;
        }

        .user-message { 
            background-color: #DCDCDC;
            color: #000000;
            font-size: 13px;
            border-radius: 10px;
            padding: 10px;
            max-width: 80%;
            margin-bottom: 10px;
            clear: both;
            float: left;
        }

        .admin-message {
            background-color:  #1E90FF;
            color: #fff;
            font-size: 13px;
            border-radius: 10px;
            padding: 10px;
            max-width: 80%;
            margin-bottom: 10px;
            clear: both;
            float: right;
        }
        .message-container::-webkit-scrollbar {
            width: 0; 
            background: transparent; 
        }
        .back-btn {
            position: fixed;
        }
        .back-btn a {
            text-decoration: none;
            color: #333; 
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="ticketmessage">
        <div class="back-btn">
            <a href="#" onclick="goBack();" title="go back"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h6>Messages for Ticket ID <?php echo $ticket_id; ?></h6>
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
    </div>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
