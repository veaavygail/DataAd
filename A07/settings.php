<?php
session_start();
include('connect.php'); 


if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];  

    
    $query = "SELECT userID FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['userID'] = $row['userID']; 
    } else {
        $errorMessage = "User not found.";
    }
} 


if (isset($_POST['btnSubmit'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $birthDay = $_POST['birthDay'];
    $userID = $_SESSION['userID']; 

   
    $_SESSION['firstName'] = $firstName;
    $_SESSION['lastName'] = $lastName;
    $_SESSION['birthDay'] = $birthDay;

    
    $checkQuery = "SELECT * FROM userinfoid WHERE userID = '$userID'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        
        $errorMessage = "You have already submitted your information.";
    } else {
        
        $query = "INSERT INTO userinfoid (userID, firstName, lastName, birthDay) 
                  VALUES ('$userID', '$firstName', '$lastName', '$birthDay')";

        
        if (mysqli_query($conn, $query)) {
            $successMessage = "Your information has been updated successfully!";
        } else {
            $errorMessage = "Error updating information: " . mysqli_error($conn);
        }
    }
}


if (isset($_POST['log-out'])) {
    session_unset();
    session_destroy(); 
    header("Location: log-in.php");
    exit;
}

if (isset($_POST['btnDelete'])) {
    $userID = $_SESSION['userID'];

    $deleteQuery = "DELETE FROM userinfoid WHERE userID = '$userID'";
    if (mysqli_query($conn, $deleteQuery)) {
        $successMessage = "Information deleted successfully.";
    } 

    unset($_SESSION['firstName']);
    unset($_SESSION['lastName']);
    unset($_SESSION['birthDay']);
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
                                <a class="nav-link active" aria-current="page" href="#">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Message</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="settings.php">Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Friends</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Notification</a>
                            </li>
                        </ul>
                        <form method="post">
                            <button type="submit" name="log-out" class="btn btn-secondary mt-auto">Log-out</button>
                        </form>
                    </div>
                </nav>
            </div>

            <div class="col-10 main-content p-4">
                <h2 class="text-center">Settings</h2>

                <?php
                if (isset($successMessage)) {
                    echo "<div class='alert alert-success'>$successMessage</div>";
                }
                if (isset($errorMessage)) {
                    echo "<div class='alert alert-danger'>$errorMessage</div>";
                }
                ?>

                <form method="post">
                    <div class="row">
                        <div class="col my-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required value="<?php echo $_SESSION['firstName'] ?? 'First Name'; ?>">
                        </div>

                        <div class="col my-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required value="<?php echo $_SESSION['lastName'] ?? 'Last Name'; ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="birthdate" class="form-label">Birthdate</label>
                        <input type="date" class="form-control" id="birthdate" name="birthDay" required value="<?php echo $_SESSION['birthDay'] ?? ''; ?>">
                    </div>

                    <button type="submit" name="btnSubmit" class="btn btn-secondary">Submit</button>
                    <button class="btn btn-danger" name="btnDelete">Delete</button>
                    <a href="edit.php" class="btn btn-secondary">Edit</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
