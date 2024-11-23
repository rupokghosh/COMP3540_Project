<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar {
            width: 200px;
            background-color: #333;
            color: white;
            padding: 15px;
            height: 100vh;
            position: fixed;
        }

        .sidebar h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 10px 0;
            padding: 10px;
            border-radius: 4px;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
            flex-grow: 1;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h1>ArchivedList</h1>
        <a href="main.php">your movie list</a>
        <a href="archived.php">watched movies</a>
        <a href="profile.php">profile</a>
    </div>
    <div class="content">
        <h1>Profile</h1>
        <p>Username: <span id="username-display"><?php echo $_SESSION['username']; ?></span></p>
        <input type="text" id="new-username" placeholder="Enter new username">
        <button id="update-username-btn">Update Username</button>
        <p>Email: <?php echo $_SESSION['email']; ?></p>
        <button id="delete-account-btn">Delete Account</button>
    </div>
    <script>
        $("#update-username-btn").on("click", function() {
            const newUsername = $("#new-username").val();
            if (newUsername === "") {
                alert("Please enter a new username.");
                return;
            }

            $.ajax({
                url: "controller.php",
                type: "POST",
                data: {
                    page: "ProfilePage",
                    command: "updateUsername",
                    username: newUsername,
                },
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function() {
                    alert("An error occurred while updating the username.");
                }
            });
        });

        $("#delete-account-btn").on("click", function() {
            if (!confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
                return;
            }

            $.ajax({
                url: "controller.php",
                type: "POST",
                data: {
                    page: "ProfilePage",
                    command: "deleteAccount"
                },
                success: function(response) {
                    alert(response);
                    window.location.href = "login.php";
                },
                error: function() {
                    alert("An error occurred while deleting the account.");
                }
            });
        });
    </script>
</body>

</html>