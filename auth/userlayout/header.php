<header class="p-3 mb-3 border-bottom sticky-top headd">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between">
            <!-- Logo on the left -->
            <a href="/" class="header-logo d-flex align-items-center text-decoration-none">
                <img src="assets/images/logo.png" alt="Logo" height="40">
            </a>

            <!-- Navigation Links for Large Screens -->
            <ul class="header-nav nav nav-pills d-none d-sm-flex justify-content-center align-items-center mb-0">
                <li class="nav-item">
                    <a href="index.php" class="nav-link px-2 text-body-secondary">Dashboard</a>
                </li>
            </ul>

            <!-- Icons and Dropdown Menu -->
            <div class="header-icons d-flex align-items-center">
                <i class="bi bi-globe me-3"></i>
                <div class="dropdown">
                    <a href="#" class="d-block text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="<?php
                                    if (isset($_SESSION["user_id"]) && isset($conn)) {
                                        echo rowInfoByColumn($conn, "profiles", "profile_picture_1", "user_id", $_SESSION["user_id"]);
                                    } ?>"
                            alt="User" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small">
                        <li><a class="dropdown-item" href="showprofile.php?id=<?php echo urlencode($_SESSION['user_id']); ?>">View Profile</a></li>
                        <li><a class="dropdown-item" href="uploadImages.php">Profile Pictures</a></li>
                        <li><a class="dropdown-item" href="editProfile.php">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="editPersonalityInfo.php">Personality Questions</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                    </ul>
                </div>
            </div>

            <!-- Mobile Menu -->
            <!-- <div class="d-block d-sm-none dropdown">
                <a href="#" class="text-decoration-none d-flex align-items-center" data-bs-toggle="dropdown">
                    <img src="uploads/<?php
                                        // if (isset($_SESSION["user_id"]) && isset($conn)) {
                                        //     echo rowInfoByColumn($conn, "profiles", "profile_picture_1", "user_id", $_SESSION["user_id"]);
                                        // } 
                                        ?>"
                        alt="User" width="32" height="32" class="rounded-circle">
                    <span class="ms-2">
                        <span class="hamburger-icon d-flex flex-column justify-content-center">
                            <span class="bg-dark mb-1" style="height: 2px; width: 20px;"></span>
                            <span class="bg-dark mb-1" style="height: 2px; width: 20px;"></span>
                            <span class="bg-dark" style="height: 2px; width: 20px;"></span>
                        </span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-small">
                    <li><a class="dropdown-item" href="showprofile.php?id=<?php echo urlencode($_SESSION['user_id']); ?>">View Profile</a></li>
                    <li><a class="dropdown-item" href="editProfile.php">Edit Profile</a></li>
                    <li><a class="dropdown-item" href="editPersonalityInfo.php">Personality Questions</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                </ul>
            </div> -->
        </div>
    </div>
</header>