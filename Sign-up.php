<?php
include('includes/connexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    $checkUserQuery = "SELECT id_user FROM user WHERE email = :email";
    $stmtCheckUser = $pdo->prepare($checkUserQuery);
    $stmtCheckUser->execute(['email' => $email]);

    if ($stmtCheckUser->rowCount() > 0) {
        header('Location: log-in.php');
        exit();
    }

    if ($password !== $confirmPassword) {
        $passwordError = "Passwords do not match.";
    }

    if (!isset($passwordError)) {
        $insertQuery = "INSERT INTO user (nom, email, password) VALUES (:name, :email, :password)";
        $stmtInsert = $pdo->prepare($insertQuery);
        $stmtInsert->execute(['name' => $name, 'email' => $email, 'password' => $password]);

        header('Location: log-in.php');
        exit();
    }
}

$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-up</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="includes/sign-up.css"> 
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />

    <style>
        .vh-100 {
            height: 100vh;
        }

        .container {
            margin-top: 5%;
        }

        .border-primary {
            border-color: #007bff !important;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 2rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-outline-dark {
            color: #343a40;
            border-color: #343a40;
        }

        .text-primary {
            color: #007bff;
        }
    </style>
</head>

<body>

    <?php include('assets/php/topbar.php'); ?>
    <?php include('assets/php/header.php'); ?>

    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="border border-3 border-primary"></div>
                    <div class="card bg-white shadow-lg">
                        <div class="card-body p-5">
                            <h2 class="fw-bold mb-2 text-uppercase">Sign Up</h2>
                            <?php if (isset($passwordError)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $passwordError; ?>
                                </div>
                            <?php endif; ?>
                            <form method="post">
                                <div class="mb-3">
                                    <label for="nom" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                            </form>
                            <div class="text-center mt-3">
                                <p>Already have an account? <a href="log-in.php">Log In</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('assets/php/footer1.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

</body>


</html>
