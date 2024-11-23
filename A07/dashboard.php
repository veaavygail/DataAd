<?php
session_start(); 
include('connect.php'); 

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];  

    $query = "SELECT userName FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['userName'] = $row['userName']; 
    } else {
        $errorMessage = "User not found.";
    }
} else {
    $errorMessage = "Please log in first.";
}

if (isset($_POST['log-out'])) {
    header("Location: log-in.php");
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>| Reddish</title>
    <link rel="icon" href="R.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="shared/css/style.css">
    <style>
        .body {
            background-image: linear-gradient(to right, rgba(255, 0, 0, 0), rgba(255, 0, 0, 1));
        }
        .sidebar {
            background-color: #FA8072;
            height: 100vh;
        }
        .main-content {
            background-color: #fdc3bc;
            height: 100vh;
        }
    </style>
</head>
<body class="body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 sidebar p-3 d-flex flex-column" style="height: 100vh;">
                <nav class="navbar navbar-expand-lg navbar-light flex-column">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse flex-column" id="navbarSupportedContent">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="dashboard.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#" disabled aria-label="Close">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" disabled aria-label="Close">Message</a>
                            </li>
                          <li class="nav-item">
    <a class="nav-link" href="settings.php">Settings</a>
</li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" disabled aria-label="Close">Friends</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" disabled aria-label="Close">Notification</a>
                            </li>
                        </ul>
                        <form method="post">
                            <button type="submit" name="log-out" class="btn btn-secondary mt-auto">Log-out</button>
                        </form>
                    </div>
                </nav>
            </div>

            <div class="col-10 main-content p-4">
                <div class="container">
                    <h2 class="text-center">Home</h2>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Username: @ <?php echo $_SESSION['userName']; ?></label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">  What's on your mind? </textarea>
                        <div class="d-flex justify-content-end mt-2">
                            <button type="submit" name="btnSubmit" class="btn btn-secondary">Submit</button>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
