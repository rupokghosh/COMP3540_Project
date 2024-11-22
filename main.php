<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Watchlist</title>
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
        <h1>MovieList</h1>
        <a href="">watched movies</a>
        <a href="">profile</a>
    </div>
    <div class="content">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>

        <h2>Add a Movie</h2>
        <form id="addMovieForm">
            <input type="text" id="movieTitle" placeholder="Enter movie title" required>
            <button type="submit">Add Movie</button>
        </form>

        <h2>Your Watchlist</h2>
        <ul id="watchlist">
            <!-- Movies will be dynamically loaded here -->
        </ul>

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
                    console.log("Parsed Movies: ", movies);
                    const watchlist = $('#watchlist');
                    watchlist.empty();

                    // Render each movie with buttons
                    movies.forEach((movie) => {
                        const listItem = $(`
                <li>
                    ${movie.title}
                    <button class="watched-btn" data-id="${movie.id}" data-status="${movie.status}">
                        ${movie.status == 1 ? "Watched" : "Mark as Watched"}
                    </button>
                    <button class="delete-btn" data-id="${movie.id}">Delete</button>
                </li>
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
                    console.log(response); // Log the response for debugging
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