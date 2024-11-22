<?php

require('model.php');
session_start();

if (empty($_POST['page'])) {
    include('login.php');
    exit;
}

$page = $_POST['page'];
$command = $_POST['command'];

if ($page == 'StartPage') {
    switch ($command) {
        case 'SignIn':
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = loginUser($email, $password);
            if ($user) {
                $_SESSION['signedin'] = 'YES';
                $_SESSION['username'] = $user['username'];
                include('main.php');
            } else {
                $error_msg = "Invalid email or password. Please try again.";
                include('login.php');
            }
            break;

        case 'SignUp':
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (signUpUser($username, $email, $password)) {
                $_SESSION['signedin'] = 'YES';
                $_SESSION['username'] = $username;
                include('main.php');
            } else {
                $error_msg = "Signup failed. Email may already be in use.";
                include('login.php');
            }
            break;
    }
}

if ($page == 'MainPage' && $command == 'SignOut') {
    session_unset();
    session_destroy();
    include('login.php');
}
?>
