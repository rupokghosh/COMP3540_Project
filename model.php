<?php

$conn = mysqli_connect("localhost", "w3radin", "w3radin136", "C354_w3radin");
function signUpUser($username, $email, $password) {
    global $conn;
    $query = "INSERT INTO User_Details (username, email, password) VALUES ('$username', '$email', '$password')";
    return mysqli_query($conn, $query);
}

function loginUser($email, $password) {
    global $conn;
    $query = "SELECT username FROM User_Details WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result) : null;
}
?>
