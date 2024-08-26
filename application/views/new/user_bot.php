

</head>
    <style>
        label{
            margin-bottom: 0px !important;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 500;
        }
        @media only screen and (max-width:762px){
        

            .container122 {
                margin: 20px;
                margin-top: 35px;
                background-color: #fff;
                border: 2px solid #ccc;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h2 {
                text-align: center;
                color: #333;
            }

            .bot_form {
                display: flex;
                flex-direction: column;
            }

            .bot_label {
                color: #666;
            }

            .bot_input {
                padding: 5px;
                border: 1px solid #ccc;
                border-radius: 10px;
                resize: none;
            }

            .mysubmit {
                padding: 10px;
                margin: 10px 0px;
                border: none;
                border-radius: 10px;
                background-color: #0FA4AF;
                color: #fff;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .header-for1 {
                height: 60px;
                font-size: 15px;
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
                padding: 20px;
            }
        }
        @media only screen and (min-width:763px) and (max-width:999px){
        
            .container122 {
                margin: 20px;
                margin-top: -30px !important;
                background-color: #fff;
                border: 2px solid #ccc;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h2 {
                text-align: center;
                color: #333;
            }

            .bot_form {
                display: flex;
                flex-direction: column;
            }

            .bot_label {
                color: #666;
            }

            .bot_input {
                padding: 5px;
                border: 1px solid #ccc ;
                border-radius: 10px;
                resize: none;
            }

            .mysubmit {
                padding: 10px;
                margin: 10px 0px;
                border: none;
                border-radius: 10px;
                background-color: #0FA4AF;
                color: #fff;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .header-for1 {
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
                padding: 20px;
            }
        }
        @media only screen and (min-width:1000px){
           

            .container122 {
                width: 350px;
                height: 500px;
                margin: 20px;
                margin-top: 210px;
                margin-left: 1140px;
                background-color: #fff;
                border: 2px solid #ccc;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h2 {
                text-align: center;
                color: #333;
            }

            .bot_form {
                display: flex;
                flex-direction: column;
            }

            .bot_label {
                color: #666;
            }

            .bot_input {
                padding: 5px;
                border: 1px solid #ccc ;
                border-radius: 10px;
                resize: none;
                
            }

            .mysubmit {
                padding: 10px;
                margin: 10px 0px;
                border: none;
                border-radius: 10px;
                background-color: #0FA4AF;
                color: #fff;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .header-for1 {
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
                padding: 20px;
                height: 300px;
            }
            .bot_input{
                border: 1px solid #ccc !important;
                margin: 10px 0px;
                padding-left: 10px;
                height: 50px;
            }
            .bot_label{
                margin-top: 10px;
            }
        }

    </style>

<body>
    <div class="container122">
        <div class="header-for1" style="font-family: 'Comic Sans MS', Comic Sans, cursive; font-weight: bold;">
            TGS Chat Support
        </div>
        <div class="inside-container">
            <form class="bot_form" action="<?= base_url('index.php/UserMessage') ?>" method="POST">
                <label class="bot_label" for="email">Email</label>
                <!-- <i class="fe fe-mail input-icon"></i> -->
                <input class="bot_input" style= "border:1px solid #ccc !important; margin-bottom: 5px; padding-left: 10px;" type="email" id="email" name="email" placeholder="Enter your email" required>
                
                <label class="bot_label" for="phone">Phone Number</label>
                <!-- <i class="fe fe-phone input-icon"></i> -->
                <input class="bot_input" style= "border:1px solid #ccc !important; margin-bottom: 5px; padding-left: 10px;" type="tel" id="phone" name="phone" pattern="[0-9]{10}" placeholder="Enter your phone_no" required>
                
                <label class="bot_label" for="message">Message</label>
                <!-- <i class="fe fe-message-square input-icon"></i> -->
                <textarea class="bot_input" style= "border:1px solid #ccc !important; margin-bottom: 5px; padding-left: 10px;" id="message" name="message" rows="4" cols="50" placeholder="Enter your message" required></textarea>
                
                <input class="mysubmit" style="height: 50px; margin-top: 20px;" type="submit" value="Submit">
            </form>
        </div>
    </div>
</body>

