<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieList - Main</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <p class="text-muted">You are logged in. Start managing your movie watchlist.</p>
        <form method="POST" action="controller.php">
            <input type="hidden" name="page" value="MainPage">
            <input type="hidden" name="command" value="SignOut">
            <button type="submit" class="btn btn-danger">Log Out</button>
        </form>
    </div>
</body>
</html>
