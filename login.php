<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to MovieList</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 320px;
            padding: 20px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }

        p {
            color: #555;
            margin: 8px 0 20px;
        }

        .form-container {
            display: none;
        }

        .form-container.active {
            display: block;
        }

        label {
            display: block;
            text-align: left;
            font-size: 14px;
            margin-bottom: 5px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button.login-btn {
            background: #007bff;
            color: white;
            margin-top: 10px;
        }

        button.signup-btn {
            background: #28a745;
            color: white;
            margin-top: 10px;
        }

        .switch-btn {
            color: #007bff;
            background: none;
            border: none;
            cursor: pointer;
            text-decoration: underline;
            font-size: 14px;
        }

        .switch-btn:hover {
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>MovieList</h1>
        <p>Manage your movie watchlist</p>

        <div id="loginForm" class="form-container active">
            <form method="POST" action="controller.php">
                <input type="hidden" name="page" value="StartPage">
                <input type="hidden" name="command" value="SignIn">
                <div>
                    <label for="login-email">Email:</label>
                    <input type="email" id="login-email" name="email" required>
                </div>
                <div>
                    <label for="login-password">Password:</label>
                    <input type="password" id="login-password" name="password" required>
                </div>
                <button type="submit" class="login-btn">Log In</button>
            </form>
            <p>Don't have an account? <button onclick="showSignup()" class="switch-btn">Sign Up</button></p>
        </div>

        <div id="signupForm" class="form-container">
            <form method="POST" action="controller.php">
                <input type="hidden" name="page" value="StartPage">
                <input type="hidden" name="command" value="SignUp">
                <div>
                    <label for="signup-username">Username:</label>
                    <input type="text" id="signup-username" name="username" required>
                </div>
                <div>
                    <label for="signup-email">Email:</label>
                    <input type="email" id="signup-email" name="email" required>
                </div>
                <div>
                    <label for="signup-password">Password:</label>
                    <input type="password" id="signup-password" name="password" required>
                </div>
                <button type="submit" class="signup-btn">Sign Up</button>
            </form>
            <p>Already have an account? <button onclick="showLogin()" class="switch-btn">Log In</button></p>
        </div>
    </div>

    <script>
        function showLogin() {
            document.getElementById('loginForm').classList.add('active');
            document.getElementById('signupForm').classList.remove('active');
        }

        function showSignup() {
            document.getElementById('signupForm').classList.add('active');
            document.getElementById('loginForm').classList.remove('active');
        }
    </script>

</body>

</html>