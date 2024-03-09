<?php
include('includes/connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = $_POST['new_name'];
    $new_email = $_POST['new_email'];
    $new_password = $_POST['new_password'];
    $new_role = $_POST['new_role'];

    $newImageFileName = null;
    if ($_FILES['new_image_user']['size'] > 0) {
        $newImageFileName = $_FILES['new_image_user']['name'];
        $newImageTempPath = $_FILES['new_image_user']['tmp_name'];
        $uploadPath = '../assets/image/User/' . $newImageFileName;
        move_uploaded_file($newImageTempPath, $uploadPath);
    }

    $sqlInsert = "INSERT INTO user (nom, email, password, image_user, Role) VALUES (:new_name, :new_email, :new_password, :new_image_user, :new_role)";
    $stmtInsert = $pdo->prepare($sqlInsert);

    $params = [
        'new_name' => $new_name,
        'new_email' => $new_email,
        'new_password' => $new_password,
        'new_image_user' => $newImageFileName,
        'new_role' => $new_role
    ];

    if ($stmtInsert->execute($params)) {
        $succmsg = 'User added successfully';
    } else {
        $errmsg = 'Error adding user';
    }
    header('Location: ListeUsers.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Users</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <style>
        .container {
            margin-top: 50px;
        }

        .btn-action {
            padding: 5px 10px;
            margin-right: 5px;
        }

        .user-image {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="mb-4">Add User</h1>
        <?php if (isset($succmsg)): ?>
            <div class="alert alert-success"><?= $succmsg ?></div>
        <?php endif; ?>
        <?php if (isset($errmsg)): ?>
            <div class="alert alert-danger"><?= $errmsg ?></div>
        <?php endif; ?>
        <form method="POST" action="Createuser.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="new_name" class="form-label">User Name</label>
                <input type="text" class="form-control" id="new_name" name="new_name" required>
            </div>
            <div class="mb-3">
                <label for="new_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="new_email" name="new_email" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="new_image_user" class="form-label">User Image</label>
                <input type="file" class="form-control" id="new_image_user" name="new_image_user">
            </div>
            <div class="mb-3">
                <label for="new_role" class="form-label">Role</label>
                <select class="form-control" id="new_role" name="new_role" required>
                    <option value="1">Admin</option>
                    <option value="2">Normal User</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
        <div class="mt-3">
            <a href="createuser.php" class="btn btn-secondary">Go to Create User Page</a>
        </div>
    </div>

    <?php include('includes/return.php'); ?>


</body>

</html>
