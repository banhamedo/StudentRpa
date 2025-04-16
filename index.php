<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 100px;
        }
        button {
            padding: 15px 30px;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
    </style>
</head>
<body>

    <h2>Welcome! Please choose an option</h2>
    <div class="container">
        <button onclick="window.location.href='login.php'">Login</button>
        <button onclick="window.location.href='signup.php'">Sign Up</button>
    </div>

</body>
</html>
