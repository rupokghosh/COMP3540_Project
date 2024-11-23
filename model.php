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

// movie functions

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
    $query = "UPDATE archived SET rating = $rating WHERE movie_id = $movieId AND user_id = $userId";
    return mysqli_query($conn, $query);
}

// Mark a movie as watched (archived)
function markAsWatched($movieId, $userId)
{
    global $conn;

    $query1 = "UPDATE movies SET status = 1 WHERE id = $movieId AND user_id = $userId";
    if (!mysqli_query($conn, $query1)) {
        die("Error updating status: " . mysqli_error($conn));
    }


    $query2 = "INSERT INTO archived (movie_id, user_id, rating) 
               SELECT id, user_id, rating FROM movies WHERE id = $movieId AND user_id = $userId";
    if (!mysqli_query($conn, $query2)) {
        die("Error inserting into archived: " . mysqli_error($conn));
    }

    return true;
}

// archived movie functions

function fetchArchivedMovies($userId, $sort)
{
    global $conn;

    $orderBy = '';
    if ($sort === 'name') {
        $orderBy = 'movie_name ASC';
    } elseif ($sort === 'date') {
        $orderBy = 'archived_at DESC';
    } else {
        $orderBy = 'movie_name ASC';
    }

    $query = "
        SELECT 
            archived.movie_id, 
            archived.user_id, 
            archived.rating, 
            movies.title AS movie_name 
        FROM 
            archived
        JOIN 
            movies 
        ON 
            archived.movie_id = movies.id
        WHERE 
            archived.user_id = $userId
        ORDER BY $orderBy
    ";
    $result = mysqli_query($conn, $query);
    $movies = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $movies[] = $row;
    }
    return $movies;
}

// profile functions

function updateUsername($userId, $newUsername)
{
    global $conn;
    $query = "UPDATE User_Details SET username = '$newUsername' WHERE id = $userId";
    $result = mysqli_query($conn, $query);
    return $result;
}

function deleteAccount($userId)
{
    global $conn;

    $query1 = "DELETE FROM archived WHERE user_id = $userId";
    if (!mysqli_query($conn, $query1)) {
        die("Error deleting archived movies: " . mysqli_error($conn));
    }

    $query2 = "DELETE FROM movies WHERE user_id = $userId";
    if (!mysqli_query($conn, $query2)) {
        die("Error deleting movies: " . mysqli_error($conn));
    }

    $query3 = "DELETE FROM User_Details WHERE id = $userId";
    if (!mysqli_query($conn, $query3)) {
        die("Error deleting account: " . mysqli_error($conn));
    }

    return true;
}
