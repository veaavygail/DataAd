<?php
session_start(); 

include('connect.php');

$email = $password = $userName = $phoneNumber = '';
$errorMessage = '';

if (isset($_POST['btnSubmit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userName = $_POST['userName'];
    $phoneNumber = $_POST['phoneNumber'];

    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $_SESSION['userName'] = $userName;
    $_SESSION['phoneNumber'] = $phoneNumber;

    if (strlen($password) < 8 || strlen($password) > 20) {
        $errorMessage = "Password must be 8-20 characters long.";
    } else {
        $AppQuery = "INSERT INTO users (email, password, userName, phoneNumber) VALUES ('$email', '$password', '$userName', '$phoneNumber')";
        executeQuery($AppQuery);
    }
}$_SESSION['email'] = $_SESSION['password'] = $_SESSION['userName'] = $_SESSION['phoneNumber'] = '';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>| Sign-in</title>
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
<div class="container text-center">
    <div class="row mt-5">
        <div class="col">
            <h1 class="display-3">Sign-in</h1>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body shadow rounded-4" style="background-color: rgba(236, 231, 231, 0.984);">
                    <?php if ($errorMessage): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $errorMessage; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="my-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required value="<?php echo $_SESSION['email']; ?>">
                        </div>

                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto">
                                <label for="inputPassword" class="col-form-label">Password</label>
                            </div>
                            <div class="col-auto">
                                <input type="password" id="inputPassword" class="form-control" name="password" required>
                                <span id="passwordHelpInline" class="form-text">Must be 8-20 characters long.</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="09*********" required value="<?php echo $_SESSION['phoneNumber']; ?>">
                        </div>

                        <div class="input-group flex-nowrap mb-3">
                            <span class="input-group-text" id="addon-wrapping">Username</span>
                            <input type="text" class="form-control" name="userName" placeholder="Username" required value="<?php echo $_SESSION['email']; ?>">
                        </div>

                        <button type="submit" name="btnSubmit" class="btn btn-secondary">Submit</button>

                        <div class="row mt-3">
                            <div class="col">
                                <div class="btn-group">
                                    <a href="index.php" class="btn btn-dark">Sign-in</a>
                                    <a href="log-in.php" class="btn btn-dark">Log-in</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
