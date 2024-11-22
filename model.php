<?php

$conn = mysqli_connect("localhost", "w3radin", "w3radin136", "C354_w3radin");

// auth functions

function signUpUser($username, $email, $password)
{
    global $conn;
    $query = "INSERT INTO User_Details (username, email, password) VALUES ('$username', '$email', '$password')";
    return mysqli_query($conn, $query);
}

function loginUser($email, $password)
{
    global $conn;
    $query = "SELECT id AS user_id, username FROM User_Details WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result) : null;
}

function fetchMovies($userId)
{
    global $conn;
    $query = "SELECT * FROM movies WHERE user_id = $userId AND status = 0";
    $result = mysqli_query($conn, $query);
    $movies = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $movies[] = $row;
    }
    return $movies;
}

// Add a new movie
function addMovie($title, $userId, $rating)
{
    global $conn;
    $query = "INSERT INTO movies (title, user_id, status, rating) VALUES ('$title', $userId, 0, $rating)";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "Movie added successfully!";
    } else {
        echo "Error adding movie: " . $conn->error;
    }
}

// Delete a movie
function deleteMovie($movieId, $userId)
{
    global $conn;
    $query = "DELETE FROM movies WHERE id = $movieId AND user_id = $userId";
    return mysqli_query($conn, $query);
}

// Add or update rating for a movie
function addRating($movieId, $userId, $rating)
{
    global $conn;
    $query = "UPDATE movies SET rating = $rating WHERE id = $movieId AND user_id = $userId";
    return mysqli_query($conn, $query);
}

// Mark a movie as watched (archived)
function markAsWatched($movieId, $userId)
{
    global $conn;
    $query = "UPDATE movies SET status = 1 WHERE id = $movieId AND user_id = $userId";
    return mysqli_query($conn, $query);
}
