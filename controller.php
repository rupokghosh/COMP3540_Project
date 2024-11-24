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
                $_SESSION['email'] = $email;
                include('main.php');
            } else {
                echo "Invalid email or password. Please try again.";
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
                    $_SESSION['email'] = $email;
                    include('main.php');
                }
            } else {
                echo "Signup failed. Email may already be in use.";
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
if ($page == 'ArchivedPage') {

    switch ($command) {
        case 'FetchArchivedMovies':
            $userId = $_SESSION['user_id'];
            $sort = isset($_POST['sort']) ? $_POST['sort'] : 'name';
            $movies = fetchArchivedMovies($userId, $sort);
            echo json_encode($movies);
            break;
        case 'AddRating':
            $movieId = $_POST['movie_id'];
            $rating = $_POST['rating'];
            $userId = $_SESSION['user_id'];
            if (addRating($movieId, $userId, $rating)) {
                echo "Rating added successfully.";
            } else {
                echo "Failed to add the rating.";
            }
            break;
    }
}

if ($page == 'ProfilePage') {
    switch ($command) {
        case 'updateUsername':
            $userId = $_SESSION['user_id'];
            $newUsername = $_POST['username'];
            $result = updateUsername($userId, $newUsername);
            if ($result) {
                $_SESSION['username'] = $newUsername;
                echo "Username updated successfully";
            } else {
                echo "Failed to update username";
            }
            break;

        case 'deleteAccount':
            $userId = $_SESSION['user_id'];
            $result = deleteAccount($userId);
            if ($result) {
                echo "Account deleted successfully";
            } else {
                echo  "Failed to delete account";
            }
            break;
    }
}
