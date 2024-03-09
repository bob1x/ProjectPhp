<?php
require_once('includes/connexion.php');

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: log-in.php');
    exit();
}

$userID = $_SESSION['user_id'];
$imageError = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['updateEmail'])) {
        $newEmail = $_POST['newEmail'];

        $updateEmailQuery = "UPDATE user SET email = :email WHERE id_user = :id";
        $stmtUpdateEmail = $pdo->prepare($updateEmailQuery);
        $stmtUpdateEmail->execute(['email' => $newEmail, 'id' => $userID]);
    }

    if (isset($_POST['updateName'])) {
        $newName = $_POST['newName'];

        $updateNameQuery = "UPDATE user SET nom = :nom WHERE id_user = :id";
        $stmtUpdateName = $pdo->prepare($updateNameQuery);
        $stmtUpdateName->execute(['nom' => $newName, 'id' => $userID]);
    }

    if (isset($_POST['updateImage'])) {
        if ($_FILES['newImage']['size'] > 0) {
            $targetDirectory = 'assets/image/User/'; 
            $targetFile = $targetDirectory . basename($_FILES['newImage']['name']);

            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            

            if (in_array($imageFileType, $allowedExtensions)) {
                if (move_uploaded_file($_FILES['newImage']['tmp_name'], $targetFile)) {
                    $updateImageQuery = "UPDATE user SET image_user = :image WHERE id_user = :id";
                    $stmtUpdateImage = $pdo->prepare($updateImageQuery);
                    $stmtUpdateImage->execute(['image' => $targetFile, 'id' => $userID]);

                    header('Location: index.php');
                    exit();
                } else {
                    $imageError = 'Failed to upload image.';
                }
            } else {
                $imageError = 'Invalid file type. Please upload a valid image.';
            }
        } else {
            $imageError = 'Please choose an image to upload.';
        }
    }
}

$userQuery = "SELECT * FROM user WHERE id_user = :id";
$stmtUser = $pdo->prepare($userQuery);
$stmtUser->execute(['id' => $userID]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

$pdo = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />


    <style>
        .card-body {
            margin-bottom: 50px;
        }

        .card {
            margin-bottom: 50px;
        }
        .custom-topbar {
            background-color: #3498db;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
        }

        .top-end {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user i {
            font-size: 24px;
            color: #333;
        }

        .user span {
            font-size: 14px;
            color: #555;
        }

        .user a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }
    </style>

</head>

<body>
    <header class="header navbar-area">
        <!-- Start Custom Topbar -->
        <div class="custom-topbar">
            <div class="container">
                <div class="top-end col-lg-4 col-md-4 col-12">
                    <?php
                    if (isset($_SESSION['user'])) {
                        echo '<div class="user">';
                        echo '<i class="lni lni-user"></i>';
                        echo '<span>Hello, <a href="logout.php">Log Out</a></span>';
                        echo '</div>';
                    } else {
                        echo '<div class="user">';
                        echo '<i class="lni lni-user"></i>';
                        echo '<span><a href="log-in.php">Sign In</a> | <a href="sign-up.php">Sign Up</a></span>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- End Custom Topbar -->
    </header>

<?php include('assets/php/header.php'); ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Modify User Information</h2>
                        <form method="post" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label for="newEmail" class="form-label">New Email address</label>
                                <input type="email" class="form-control" id="newEmail" name="newEmail"
                                    value="<?= $user['email'] ?>" required>
                                <button type="submit" class="btn btn-primary mt-2" name="updateEmail"><i
                                        class="far fa-envelope"></i> Update Email</button>
                            </div>

                            <div class="mb-3">
                                <label for="newName" class="form-label">New Username</label>
                                <input type="text" class="form-control" id="newName" name="newName"
                                    value="<?= $user['nom'] ?>" required>
                                <button type="submit" class="btn btn-primary mt-2" name="updateName"><i
                                        class="far fa-user"></i> Update Username</button>
                            </div>

                            <div class="mb-3">
                                <label for="newImage" class="form-label">New Image</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="newImage" name="newImage">
                                    <button type="submit" class="btn btn-primary" name="updateImage"><i
                                            class="far fa-image"></i> Update Image</button>
                                </div>
                                <?php if (isset($imageError)): ?>
                                <p class="text-danger"><?= $imageError ?></p>
                                <?php endif; ?>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    echo '<footer>';
    include('assets/php/footer1.php');
    echo '</footer>';
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/tiny-slider.js"></script>
    <script src="assets/js/glightbox.min.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>
