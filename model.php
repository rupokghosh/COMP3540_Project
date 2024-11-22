<?php

$conn = mysqli_connect("localhost", "w3radin", "w3radin136", "C354_w3radin");
function signUpUser($username, $email, $password) {
    global $db;
    $query = "INSERT INTO User_Details (username, email, password) VALUES ('$username', '$email', '$password')";
    return mysqli_query($db, $query);
}

function loginUser($email, $password) {
    global $db;
    $query = "SELECT username FROM User_Details WHERE email='$email' AND password='$password'";
    $result = mysqli_query($db, $query);
    return mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result) : null;
}
?>
