<?php
include('connect.php');

$email = $password = $userName = $phoneNumber = '';
$errorMessage = '';

// Handle form submission
if (isset($_POST['btnSubmit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userName = $_POST['userName'];
    $phoneNumber = $_POST['phoneNumber'];

    // Validate password length
    if (strlen($password) < 8 || strlen($password) > 20) {
        $errorMessage = "Password must be 8-20 characters long.";
    } else {
        // Insert user into the database
        $AppQuery = "INSERT INTO users (email, password, userName, phoneNumber) VALUES ('$email', '$password', '$userName', '$phoneNumber')";
        executeQuery($AppQuery);
        // Reset fields after successful sign-up
        $email = $password = $userName = $phoneNumber = ''; 
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>| Reddish</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="shared/css/style.css">
    <style>
     .body {
            background-image: linear-gradient(to right, rgba(255, 0, 0, 0), rgba(255, 0, 0, 1));
        }
    </style>
</head>

<body class="body">
    
    <div class="container  mt-5 text-center">
        <div class="row mt-5">
            <div class="col t mt-5">
                <h1>Our website is under construction.</h1>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
