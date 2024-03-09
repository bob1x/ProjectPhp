<?php
include('includes/connexion.php');

// Fetch users from the database
$sqlSelect = "SELECT id_user, nom, email, image_user, Role FROM user";
$stmtSelect = $pdo->prepare($sqlSelect);
$stmtSelect->execute();
$users = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['delete_user'])) {
    $id_user = $_POST['id_user'];

    $sqlDelete = "DELETE FROM user WHERE id_user = :id_user";
    $stmtDelete = $pdo->prepare($sqlDelete);
    $stmtDelete->execute(['id_user' => $id_user]);

    // Redirect after deletion
    header('Location: ListeUsers.php');
    exit();
}

if (isset($_POST['update_user'])) {
    $id_user = $_POST['id_user'];
    $new_name = $_POST['new_name'];
    $new_email = $_POST['new_email'];
    $new_password = $_POST['new_password'];

    $newImageFileName = null;

    // Check if a new image is uploaded
    if ($_FILES['new_image_user']['size'] > 0) {
        $newImageFileName = $_FILES['new_image_user']['name'];
        $newImageTempPath = $_FILES['new_image_user']['tmp_name'];
        $uploadPath = '../assets/image/User/' . $newImageFileName;

        // Move the uploaded image to the destination folder
        move_uploaded_file($newImageTempPath, $uploadPath);
    }

    // Update the user record with the new information
    $sqlUpdate = "UPDATE user SET nom = :new_name, email = :new_email, password = :new_password";
    if ($newImageFileName) {
        $sqlUpdate .= ", image_user = :new_image_user";
    }
    $sqlUpdate .= " WHERE id_user = :id_user";

    $stmtUpdate = $pdo->prepare($sqlUpdate);

    $params = [
        'new_name' => $new_name,
        'new_email' => $new_email,
        'new_password' => password_hash($new_password, PASSWORD_DEFAULT),
        'id_user' => $id_user,
    ];

    // Add new image parameter if a new image is provided
    if ($newImageFileName) {
        $params['new_image_user'] = $newImageFileName;
    }

    if ($stmtUpdate->execute($params)) {
        $succmsg = 'Utilisateur mis à jour avec succès';
    } else {
        $errmsg = 'Erreur lors de la mise à jour de l\'utilisateur';
    }

    // Redirect after update
    header('Location: ListeUsers.php');
    exit();
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
    <!-- Bootstrap JS (Bundle includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
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
        <h1 class="mb-4">List of Users</h1>
        <a href="Createuser.php" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Add User
        </a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id_user'] ?></td>
                    <td><?= $user['nom'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><img src="../assets/image/User/<?= $user['image_user'] ?>" alt="User Image" class="user-image">
                    </td>
                    <td><?= $user['Role'] ?></td>
                    <td>
                        <!-- Delete user form -->
                        <form method="POST" action="#">
                            <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                            <button type="submit" name="delete_user" class="btn btn-danger btn-action">
                                Delete
                            </button>
                        </form>
                        <!-- Edit user form -->
                        <button type="button" class="btn btn-primary btn-action" data-bs-toggle="modal"
                            data-bs-target="#editUser<?= $user['id_user'] ?>">
                            Edit
                        </button>
                    </td>
                </tr>

                <!-- Edit User Modal -->
                <div class="modal fade" id="editUser<?= $user['id_user'] ?>" tabindex="-1"
                    aria-labelledby="editUserLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserLabel">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="ListeUsers.php" enctype="multipart/form-data">
                                    <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                    <div class="mb-3">
                                        <label for="userEditName" class="form-label">User Name</label>
                                        <input type="text" class="form-control" id="userEditName" name="new_name"
                                            value="<?= $user['nom'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userEditEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="userEditEmail" name="new_email"
                                            value="<?= $user['email'] ?>" required>
                                    </div>
                                    <div class="mb-3">  
                                        <label for="userEditPassword" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="userEditPassword"
                                            name="new_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userEditImage" class="form-label">New Image</label>
                                        <input type="file" class="form-control" id="userEditImage"
                                            name="new_image_user">
                                    </div>
                                    <button type="submit" name="update_user" class="btn btn-primary">Save
                                        Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
   <?php include('includes/return.php'); ?>


    <!-- Bootstrap JS and other dependencies -->
    <!-- Include your scripts here -->

</body>

</html>