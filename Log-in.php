<?php
require_once('includes/connexion.php');

session_start();

if (isset($_POST['login'])) {
    $identifier = $_POST['identifier'];
    $password = $_POST['password'];

    $sqlquery = "SELECT * FROM user WHERE (email = :identifier OR nom = :identifier) AND password = :password";
    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute(['identifier' => $identifier, 'password' => $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['email'] = $user['email'];    
        $_SESSION['Role'] = $user['Role'];
        $_SESSION['user'] = $user['email'];
        if ($user['Role'] == '1') {
            header('Location: admin/index.php');
        } else {
            header('Location: index.php');
        }
        exit();
    } else {
        $loginError = 'Invalid email or password'; 
    } 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>


    <?php
    include('assets/php/topbar.php');
    ?>
    <?php
    include('assets/php/header.php');
    ?>


    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="border border-3 border-primary"></div>
                    <div class="card bg-white shadow-lg">
                        <div class="card-body p-5">
                            <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                            <p class="mb-5">Please enter your login and password!</p>
                            <?php if (isset($loginError)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $loginError; ?>
                            </div>
                            <?php endif; ?>
                            <form action="#" method="post" class="mb-3">
                                <div class="mb-3">
                                    <label for="identifier" class="form-label">Email address or Username</label>
                                    <input type="text" class="form-control" id="identifier" name="identifier"
                                        placeholder="name@example.com" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="*******" required>
                                </div>
                                <p class="small"><a class="text-primary" href="forget-password.html">Forgot
                                        password?</a></p>
                                <div class="d-grid">
                                    <button class="btn btn-outline-dark" type="submit" name="login">Login</button>
                                </div>
                            </form>
                            <div>
                                <p class="mb-0 text-center">Don't have an account? <a href="sign-up.php"
                                        class="text-primary fw-bold">Sign Up</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--footer-->
    <?php
echo '<footer>';
include('assets/php/footer1.php');
echo '</footer>';
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>