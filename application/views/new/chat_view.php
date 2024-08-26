
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <title>User Chat</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
    @media only screen and (max-width:763px){
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container100 {
            margin: 20px;
            margin-top: 30px;
            background-color: #fff;
            border: 2px solid #ccc;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .user-message {
            background-color: #DCDCDC;
            color: #000;
            font-size: 13px;
            border-radius: 10px;
            padding: 10px;
            max-width: 80%;
            clear: both;
            float: right;
        }

        .admin-message {
            background-color: #0FA4AF;
            color: #fff;
            font-size: 13px;
            border-radius: 10px;
            padding: 10px;
            max-width: 80%;
            clear: both;
            float: left;
        }

        #user-inputt {
            font-size: 10px;
            padding: 10px;
            border-radius: 15px;
            border: 1px solid #0FA4AF;
        }

        #message-form button {
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .fa-paper-plane {
            font-size: 25px;
            color: #0FA4AF;
        }

        #message-form button:hover {
            background-color: #45a049;
        }

        #user-inputt {
            flex: 1;
            margin-right: 10px; 
        }
        .input-container{
            display: flex;
            margin: 10px;
        }
        .message-container {
            margin: 10px;
            height: 300px; 
            overflow-y: auto; 
        }
        .message-container::-webkit-scrollbar {
            width: 0; 
            background: transparent; 
        }
        .header23 {
                height: 60px;
                font-size: 20px;
                background-color: #0FA4AF;
                color: #fff;
                padding: 10px;
                text-align: center;
                margin: 0px;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .inside-container{
                padding: 10px;
            }
    }
    @media only screen and (max-width: 999px) and (min-width: 764px){
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container100 {
            margin: 20px;
            margin-top: -30px;
            background-color: #fff;
            border: 2px solid #ccc;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .user-message {
            font-size: 15px;
            background-color: #DCDCDC;
            color: #000;
            border-radius: 10px;
            padding: 10px;
            max-width: 80%;
            clear: both;
            float: right;
        }

        .admin-message {
            font-size: 15px;
            background-color: #0FA4AF;
            color: #fff;
            border-radius: 10px;
            padding: 10px;
            max-width: 80%;
            clear: both;
            float: left;
        }

        #user-inputt {
            padding: 10px;
            border-radius: 15px;
            border: 1px solid #0FA4AF;
            margin-right: 10px;
        }

        #message-form button {
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .fa-paper-plane {
            font-size: 25px;
            color: #0FA4AF;
        }

        #user-inputt {
            flex: 1; 
            margin-right: 10px; 
        }
        .input-container{
            display: flex;
            margin: 10px;
        }
        .message-container {
            height: 300px; 
            overflow-y: auto; 
            margin: 10px;
        }
        .message-container::-webkit-scrollbar {
            width: 0; 
            background: transparent; 
        }
        .header23 {
                height: 60px;
                font-size: 20px;
                background-color: #0FA4AF;
                color: #fff;
                padding: 10px;
                text-align: center;
                margin: 0px;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .inside-container{
                padding: 10px;
            }
    }
    @media only screen and (min-width: 1000px){
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container100{
            width: 350px;
            height: 500px;
            margin: 20px;
            margin-top: 210px;
            margin-left: 1150px;
            background-color: #fff;
            border: 2px solid #ccc;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .user-message {
            font-size: 15px;
            background-color: #DCDCDC;
            color: #000;
            border-radius: 15px;
            padding: 10px;
            max-width: 80%;
            clear: both;
            float: right;
            word-wrap: break-word;
            margin: 5px;
        }

        .admin-message {
            margin: 5px;
            font-size: 15px;
            background-color: #0FA4AF;
            color: #fff;
            border-radius: 15px;
            padding: 10px;
            max-width: 80%;
            clear: both;
            float: left;
            word-wrap: break-word;
        }


        #user-inputt {
            padding: 10px;
            border-radius: 15px;
            border: 1px solid #0FA4AF;
            margin-right: 10px; 
        }

        #message-form button {
            border: none;
            border-radius: 50%;
            cursor: pointer;
        }
        .fa-paper-plane {
            font-size: 25px;
            color: #0FA4AF;
        }

        #user-inputt {
            flex: 1;
            margin-right: 10px; 
        }
        .input-container{
            display: flex;
            margin: 10px;
        }
        .message-container {
            height: 340px;
            overflow-y: auto; 
            margin: 15px;
            
        }
        .message-container::-webkit-scrollbar {
            width: 0; 
            background: transparent; 
        }
        .header23 {
                height: 60px;
                font-size: 20px;
                background-color: #0FA4AF;
                color: #fff;
                padding: 10px;
                text-align: center;
                margin: 0px;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
                display: flex;
                justify-content: center;
                align-items: center;
        }
    }
    </style>
</head>
<body>
    <div class="container100">
        <!-- Display existing messages if available -->
        <div class="header23" style="font-family: 'Comic Sans MS', Comic Sans, cursive; font-weight: bold;">
            TGS Chat Support
        </div>
        <div class="message-container" id="message-container">
                <?php if (!empty($messages)) : ?>
                    <?php foreach ($messages as $message) : ?>
                        <?php if ($message['sender'] === 'user') : ?>
                            <p class="user-message"><?php echo $message['message']; ?></p>
                        <?php else : ?>
                            <p class="admin-message"><?php echo $message['message']; ?></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No messages available</p>
                <?php endif; ?>
        </div>
        <form action="<?= base_url('index.php/UserReply') ?>" method="POST" id="message-form" onsubmit="clearInput()">
            <div class="input-container">
                <textarea id="user-inputt" name="user-input" rows="1" placeholder="Type your message here..."></textarea>
                <button type="submit">
                    <i class="fas fa-paper-plane"></i> <!-- Send icon -->
                </button>
            </div>
        </form>
    </div>

    <script>
        setTimeout(() => {
    document.getElementById('message-container').scrollTop = document.getElementById('message-container').scrollHeight;
}, 100);
    </script>  
    <script>
        setInterval(function() {
            location.reload();
        }, 20000); 
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Retrieve the user-input element
    const userInput = document.getElementById('user-input');

    // Retrieve message from local storage and populate the input field
    userInput.value = localStorage.getItem('typedMessage') || '';

    // Store the message in local storage whenever user types in the input field
    userInput.addEventListener('input', function() {
        localStorage.setItem('typedMessage', userInput.value);
    });

    // Function to clear the input field after submitting the form
    function clearInput() {
        // Clear the message from local storage
        localStorage.removeItem('typedMessage');
        // Clear the input field
        userInput.value = '';
    }

    // Add the form submit event listener to clear the input field after form submission
    const form = document.getElementById('message-form');
    form.addEventListener('submit', function(event) {
        clearInput();
    });
});

    </script>
</body>
