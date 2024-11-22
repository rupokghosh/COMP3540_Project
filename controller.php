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
                $_SESSION['user_id'] = $user['user_id'];
                echo "userrrr" . $_SESSION['user_id'];
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
                $user = loginUser($email, $password);
                if ($user) {
                    $_SESSION['signedin'] = 'YES';
                    $_SESSION['username'] = $username;
                    $_SESSION['user_id'] = $user['user_id'];
                    include('main.php');
                }
            } else {
                $error_msg = "Signup failed. Email may already be in use.";
                include('login.php');
            }
            break;
    }
}

if ($page == 'MainPage') {
    switch ($command) {
        case 'FetchMovies':
            $userId = $_SESSION['user_id'];
            $movies = fetchMovies($userId);
            echo json_encode($movies);
            break;

        case 'AddMovie':
            $title = $_POST['title'];
            $userId = $_SESSION['user_id'];
            $rating = $_POST['rating'];
            if (addMovie($title, $userId, $rating)) {
                echo "Movie added successfully.";
            } else {
                echo "Failed to add the movie.";
            }
            include('main.php');
            break;

        case 'MarkAsWatched':
            $movieId = $_POST['movieId'];
            $userId = $_SESSION['user_id'];
            if (markAsWatched($movieId, $userId)) {
                echo "Movie marked as watched.";
            } else {
                echo "Failed to mark the movie as watched.";
            }
            break;

        case 'DeleteMovie':
            $movieId = $_POST['movieId'];
            $userId = $_SESSION['user_id'];
            if (deleteMovie($movieId, $userId)) {
                echo "Movie deleted successfully.";
            } else {
                echo "Failed to delete the movie.";
            }
            break;

        case 'SignOut':
            session_unset();
            session_destroy();
            include('login.php');
            break;
    }
}
