<?php
session_start(); 
include('connect.php');


$email = $password = '';
$errorMessage = '';

if (isset($_COOKIE['rememberMeEmail'])) {
    $email = $_COOKIE['rememberMeEmail'];
}


if (isset($_POST['btnSubmit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = executeQuery($query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['password'] === $password) {
           
            if (isset($_POST['rememberMe'])) {
                setcookie('rememberMeEmail', $email, time() + (86400 * 30), "/"); // 30 days
                $updateQuery = "UPDATE users SET willRemember='yes' WHERE email='$email'";
                executeQuery($updateQuery);
            } else {
                $updateQuery = "UPDATE users SET willRemember='no' WHERE email='$email'";
                executeQuery($updateQuery);

            }

            header('Location: dashboard.php'); 
            exit;
        } else {
            $errorMessage = "Incorrect password.";
        }
    } else {
        $errorMessage = "Account does not exist.";
    }

    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>| Log-in</title>
    <link rel="icon" href="R.ico" type="image/x-icon">
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
            <h1 class="display-3">Log-in</h1>
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
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required value="<?php echo $_SESSION['email'] ?? ''; ?>">
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

                        <div class="form-check mx-3 d-flex align-items-center mb-3">
                            <input class="form-check-input me-1" type="checkbox" name="rememberMe" id="rememberMe" <?php echo isset($_COOKIE['rememberMeEmail']) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="rememberMe">
                                Remember Me
                            </label>
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

<script>
    document.getElementById('rememberMe').addEventListener('change', function() {
        if (this.checked) {
            alert('Your account will be remembered for future logins.');
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>