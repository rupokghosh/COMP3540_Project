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
        <h1>Movies you have already watched!</h1>
        <div>
            <label for="sort-options">Sort by:</label>
            <select id="sort-options">
                <option value="name">Name</option>
                <option value="date">Date</option>
            </select>
        </div>
        <div id="movies">
        </div>
    </div>
    <script>
        $(document).ready(function() {
            fetchMovies();
            $('#sort-options').on('change', function() {
                fetchMovies();
            });
        });

        function fetchMovies() {
            var sortOption = $('#sort-options').val();
            $.ajax({
                url: 'controller.php',
                type: 'POST',
                data: {
                    page: 'ArchivedPage',
                    command: 'FetchArchivedMovies',
                    sort: sortOption
                },
                success: function(response) {
                    var movies = JSON.parse(response);
                    console.log(movies)
                    var html = '';
                    movies.forEach(function(movie) {
                        html += `
                   <div class="movie-card">
                        <h2>${movie.movie_name}</h2>
                        <div class="movie-details">
                            ${
                                movie.rating == 0
                                ? `<button class="add-rating-btn" data-movie-id="${movie.movie_id}">Add Rating</button>`
                                : `<p class="movie-rating">Rating: ${movie.rating}/5</p>`
                            }
                        </div>
                    </div>
                `;
                    });
                    $('#movies').html(html);
                    // Add event listener for Add Rating button
                    $('.add-rating-btn').on('click', function() {
                        var movieId = $(this).data('movie-id');
                        console.log(movieId);
                        addRating(movieId);
                    })
                }


            });
        }

        function addRating(movieId) {
            var newRating = prompt("Enter your rating (1-5):");
            parseInt(newRating);
            parseInt(movieId)
            console.log(newRating);
            console.log(movieId);
            if (newRating >= 1 && newRating <= 5) {
                $.ajax({
                    url: 'controller.php',
                    type: 'POST',
                    data: {
                        page: 'ArchivedPage',
                        command: 'AddRating',
                        movie_id: movieId,
                        rating: newRating,
                    },
                    success: function() {
                        alert('Rating added successfully fr!');
                        fetchMovies(); // Refresh the movies list
                    },
                    error: function() {
                        alert('Failed to add rating.');
                    }
                });
            } else {
                alert('Please enter a valid rating between 1 and 5.');
            }
        }
    </script>
</body>

</html>