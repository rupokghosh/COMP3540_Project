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
    <h1>Movies you have already watched!</h1>
    <div id="movies">
    </div>
    <script>
        $(document).ready(function() {
            fetchMovies();
        });

        function fetchMovies() {
            $.ajax({
                url: 'controller.php',
                type: 'POST',
                data: {
                    page: 'ArchivedPage',
                    command: 'FetchArchivedMovies'
                },
                success: function(response) {
                    var movies = JSON.parse(response);
                    console.log(movies)
                    var html = '';
                    movies.forEach(function(movie) {
                        html += '<div>';
                        html += '<h2>' + movie.movie_name + '</h2>';
                        html += '<p>Rating: ' + movie.rating + '</p>';
                        html += '</div>';
                    });
                    $('#movies').html(html);
                }
            });
        }
    </script>
</body>

</html>