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
                }, function(data) {
                    $('#watchlist').html(data);
                });
            }

            fetchMovies();

            $('#addMovieForm').submit(function(event) {
                event.preventDefault(); 

                const title = $('#movieTitle').val().trim(); 

                if (!title) {
                    alert("Please enter a movie title.");
                    return;
                }

                const postData = {
                    page: 'MainPage',
                    command: 'AddMovie',
                    title: title,
                    rating: 0
                };


                $.ajax({
                    url: 'controller.php', 
                    type: 'POST', 
                    data: postData, 
                    success: function(response) {
                        console.log("Response from controller:", response); 
                        alert(response); // Notify user about the response

                        fetchMovies();
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", {
                            status: status,
                            error: error,
                            xhr: xhr.responseText
                        });
                        alert("An error occurred while adding the movie. Please try again.");
                    }
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