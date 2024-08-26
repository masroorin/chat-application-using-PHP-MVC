<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Registration</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            width: 300px;  
            margin: 100px 500px; 
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 80%;
            padding: 10px;
            margin-left: 25px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            
            background-color: #0056b3;
        }

        p {
            margin-top: 15px;
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="<?= base_url('index.php/SupportRegister') ?>" method="POST">
            <label for="email">Enter Email:</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
          
            <label for="password">Enter Password:</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            
            <input type="submit" name="register" value="Register">
        </form>
        <p>Already have an account? <a href="<?= base_url('index.php/SupportLogin') ?>">Login</a></p>
    </div>
</body>
</html>
