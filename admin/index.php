<?php 
include('includes/connexion.php');
session_start();
if ( $_SESSION['Role']  == '2 ') {
    header('Location: ../index.php');
}
if(!$_SESSION['Role']){
    header('location: ../Log-in.php');
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>admin </title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="../assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="../assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />

</head>

<body>

<?php
include('../assets/php/topbar.php');
?>


    <div class="container-fluid">
        <div class="row">

            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="bi bi-house-door"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manageProduit.php">
                                <i class="bi bi-box"></i>
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manageCat.php">
                                <i class="bi bi-list"></i>
                                Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manageSub.php">
                                <i class="bi bi-tags"></i>
                                Subcategories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="ListeUsers.php">
                                <i class="bi bi-person"></i>
                                Users
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <!-- ... (previous code) ... -->

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Products</h5>
                                <?php
                                // number of categories i have in the db
                                $sql = "SELECT COUNT(*) AS total FROM produit";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo '<p class="card-text">'.$result['total'].'</p>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Categories</h5>
                                <?php
                                // number of categories i have in the db
                                $sql = "SELECT COUNT(*) AS total FROM categorie";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo '<p class="card-text ">'.$result['total'].'</p>';
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <?php
                                // number of categories i have in the db
                                $sql = "SELECT COUNT(*) AS total FROM user";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo '<p class="card-text ">'.$result['total'].'</p>';
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="Container">
                    <div class="mt-4">
                        <?php   
                            include('includes/ListeCat.php');
                        ?>
                    </div>
                </div>

                <div class="Container">
                    <div class="mt-4">
                        <?php   
                            include('includes/ListeSCat.php');
                        ?>
                    </div>
                </div>

                <div class="Container">
                    <div class="mt-4">
                        <?php   
                            include('afficherprod.php');
                        ?>
                    </div>
                </div>


            </main>

            <!-- ... (remaining code) ... -->


            <!-- Additional content goes here -->

            </main>
        </div>
    </div>


      <!-- ========================= scroll-top ========================= -->
      <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>


    <!-- ========================= JS here ========================= -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/tiny-slider.js"></script>
    <script src="../assets/js/glightbox.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>