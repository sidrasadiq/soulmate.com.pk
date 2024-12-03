<header class="p-3 mb-3 border-bottom sticky-top headd">
    <div class="container-fluid d-none d-sm-block">
        <div class="d-flex align-items-center">
            <!-- Logo on the left -->
            <a href="/" class="header-logo d-flex align-items-center mb-2 mb-lg-0 text-decoration-none">
                <img src="assets/images/logo.png" alt="Logo" height="40">
            </a>
            <ul class="header-nav nav nav-pills d-flex justify-content-between mb-2 mb-md-0">
                <li class="nav-item"><a href="#" class="nav-link px-3 link-body-emphasis">Online</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-3 link-body-emphasis">Matches</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-3 link-body-emphasis">Search</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-3 link-body-emphasis">Message</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-3 link-body-emphasis">Activity</a></li>
            </ul>


            <!-- Icons and dropdown menu on the right -->
            <div class="header-icons d-flex align-items-center">
                <i class="bi bi-globe me-3"></i>
                <div class="dropdown">
                    <a href="#" class="d-block text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="uploads/<?php
                                            if (isset($_SESSION["user_id"]) && isset($conn)) {
                                                echo rowInfoByColumn($conn, "profiles", "profile_picture", "user_id", $_SESSION["user_id"]);
                                            }
                                            ?>" alt="User" width="32" height="32" class="rounded-circle" alt="User" width="32" height="32" class="rounded-circle">

                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small">
                        <li><a class="dropdown-item" href="#">Make The First Move</a></li>
                        <li><a class="dropdown-item" href="showprofile.php?id=<?php echo urlencode($_SESSION['user_id']); ?>">View Profile</a></li>
                        <li><a class="dropdown-item" href="editprofile.php">Edit Profile</a></li>
                        <!-- <li><a class="dropdown-item" href="#">Photo</a></li>
                         <li><a class="dropdown-item" href="#">Matches</a></li>
                         <li><a class="dropdown-item" href="#">Hobbies & Interests</a></li> -->

                        <li><a class="dropdown-item" href="editPersonalityInfor.php">Personality Questions</a></li>
                        <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Switch Off Profile</a></li>
                    </ul>
                </div>
                <i class="bi bi-gear ms-3"></i>
            </div>
        </div>
    </div>

    <!-- for the mobile screen -->

    <div class="container-fluid d-block d-sm-none">
        <div class="d-flex align-items-center">
            <!-- Logo on the left -->
            <a href="/" class="header-logo d-flex align-items-center mb-2 mb-lg-0 text-decoration-none">
                <img src="assets/images/logo.png" alt="Logo" height="40">
            </a>

            <!-- Icons and dropdown menu on the right -->
            <div class="header-icons d-flex align-items-center ">
                <div class="dropdown">
                    <!-- Custom dropdown toggle with three-line icon -->
                    <a href="#" class="d-block text-decoration-none" data-bs-toggle="dropdown">
                        <img src="uploads/<?php
                                            if (isset($_SESSION["user_id"]) && isset($conn)) {
                                                echo rowInfoByColumn($conn, "profiles", "profile_picture", "user_id", $_SESSION["user_id"]);
                                            }
                                            ?>" alt="User" width="32" height="32" class="rounded-circle" alt="User" width="35" height="35" class="rounded-circle">

                        <span class="hamburger-icon " style="display: inline-block; width: 24px; height: 24px; position: relative;">
                            <span style="background-color: #000; height: 2px; width: 100%; position: absolute; top: 10px; left:3px;"></span>
                            <span style="background-color: #000; height: 2px; width: 100%; position: absolute; top: 16px; left:3px;"></span>
                            <span style="background-color: #000; height: 2px; width: 100%; position: absolute; top: 22px; left:3px;"></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small">
                        <li><a class="dropdown-item" href="#">Make The First Move</a></li>
                        <li><a class="dropdown-item" href="showprofile.php?id=<?php echo urlencode($_SESSION['user_id']); ?>">View Profile</a></li>
                        <li><a class="dropdown-item" href="editprofile.php">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="">Personality Questions</a></li>
                        <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Switch Off Profile</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


</header>