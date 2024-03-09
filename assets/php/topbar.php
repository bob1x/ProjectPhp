<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>ShopGrids </title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="../../assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="../../assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <style>
        .topbar {
            background-color: blue;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
        }

        .top-end {
            display: flex;
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
        <!-- Start Topbar -->
        <div class="topbar">
            <div class="container">
                <div class="d-flex justify-content-end align-items-center">
                    <div class="top-end col-lg-4 col-md-4 col-12 ">
                        <?php
                        if (isset($_SESSION['user'])) {
                            echo '<div class="user">';
                            if (isset($_SESSION['user'])) {
                                echo '<i class="lni lni-user"></i>';
                            }
                            echo ' <a href="ModifyUser.php">Modify User</a> | <a href="logout.php">Log Out</a></span>';
                            echo '</div>';
                        } else {
                            echo '<div class="user">';
                            echo '<span><a href="log-in.php">Sign In</a> | <a href="sign-up.php">Sign Up</a></span>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Bottom -->
    </header>

    <!-- ========================= JS here ========================= -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/tiny-slider.js"></script>
    <script src="assets/js/glightbox.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script type="text/javascript"></script>
</body>

</html>
