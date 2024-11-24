<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Watchlist</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #FBFBFB;
        }

        .sidebar {
            width: 200px;
            background-color: #333;
            color: white;
            padding: 15px;
            float: left;
            height: 100%;
            position: fixed;
        }

        .sidebar h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 40px 0;
            padding: 10px;
            border-radius: 4px;
            background-color: #444;
            text-align: center;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
        }

        #movieTitle {
            padding: 10px;
            margin: 20px;
            border: 1px solid #444;
            border-radius: 4px;
            font-size: 16px;
            background-color: #E5E1DA;
        }

        button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        #movie-container {
            margin: 20px 350px 30px 0;
            padding: 10px;
            border: 1px solid;
            border-radius: 4px;
            background-color: #E5E1DA;
            width: 50vw;
        }

        .movie {
            font-size: 18px;
            font-weight: bold;
            padding: 8px;
        }

        .watched-btn {
            font-size: 12px;
            padding: 10px 15px;
            background-color: #80C4E9;
        }

        .watched-btn:hover {
            background-color: lightskyblue
        }

        .delete-btn {
            font-size: 12px;
            padding: 10px 15px;
            background-color: #89A8B2;
            color: white;
        }

        .delete-btn:hover {
            background-color: #333;
        }

        #addMovieForm button {
            background-color: #333;
            color: white;
            padding: 10px;
            margin: 10px;
            border: 1px solid #444;
            border-radius: 4px;
            font-size: 16px;
        }

        #addMovieForm button:hover {
            background-color: #575757;
        }

        #signOut {
            margin-top: 30px;
            padding: 10px 15px;
            background-color: #AE445A;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;

        }
        #signOut:hover {
            background-color: purple;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h1>MovieList</h1>
        <a href="main.php">your movie list</a>
        <a href="archived.php">watched movies</a>
        <a href="profile.php">profile</a>
    </div>
    <div class="content">
        <h1>Movielist of <?php echo $_SESSION['username']; ?>!</h1>
        <hr>

        <h2>Add a Movie</h2>
        <form id="addMovieForm">
            <input type="text" id="movieTitle" placeholder="Enter movie title" required>
            <button type="submit">Add Movie</button>
        </form>

        <h2>Your Watchlist</h2>
        <div id="watchlist">

        </div>

        <button id="signOut">Sign Out</button>
    </div>
    <script>
        $(document).ready(function() {
            function fetchMovies() {
                $.post('controller.php', {
                    page: 'MainPage',
                    command: 'FetchMovies'
                }, function(response) {
                    const movies = JSON.parse(response);
                    const watchlist = $('#watchlist');
                    watchlist.empty();


                    movies.forEach((movie) => {
                        const listItem = $(`
                <div id="movie-container">
                    <div class="movie"> ${movie.title}</div>
                    <button class="watched-btn" data-id="${movie.id}" data-status="${movie.status}">
                     mark as watched 
                    </button>
                    <button class="delete-btn" data-id="${movie.id}">Delete</button>
                </div>
            `);
                        watchlist.append(listItem);
                    });
                });
            }


            fetchMovies();

            $('#addMovieForm').submit(function(event) {
                event.preventDefault();
                const title = $('#movieTitle').val();
                $.post('controller.php', {
                    page: 'MainPage',
                    command: 'AddMovie',
                    title: title,
                    rating: 0,
                }, function(response) {
                    alert("Movie added successfully.");
                    fetchMovies();
                });
            });

            // Mark as Watched
            $(document).on('click', '.watched-btn', function() {
                const movieId = $(this).data('id');
                $.post('controller.php', {
                    page: 'MainPage',
                    command: 'MarkAsWatched',
                    movieId: movieId
                }, function(response) {
                    alert(response);
                    fetchMovies();
                });
            });

            // Delete Movie
            $(document).on('click', '.delete-btn', function() {
                const movieId = $(this).data('id');
                $.post('controller.php', {
                    page: 'MainPage',
                    command: 'DeleteMovie',
                    movieId: movieId
                }, function(response) {
                    alert(response);
                    fetchMovies();
                });
            });

            $('#signOut').click(function() {
                $.post('controller.php', {
                    page: 'MainPage',
                    command: 'SignOut'
                }, function() {
                    window.location.href = 'login.php';
                });
            });
        });
    </script>
</body>

</html>