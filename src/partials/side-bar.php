<?php $permission = isset($_COOKIE['remember_me']) ? (new \App\Https\Controllers\LoginController)->remember($_COOKIE['remember_me']) : null; ?>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">

    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="?views=dashboard">
            <img src="./src/assets/img/sd-removebg-preview.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">SDN 07 WOJA</span>
        </a>
    </div>


    <hr class="horizontal light mt-0 mb-2">

    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white " href="?views=Dashboard">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>

                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <?php if ($permission['role'] !== 'guest') : ?>
                <li class="nav-item">
                    <a class="nav-link text-white " href="?views=Data-buku">

                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>

                        <span class="nav-link-text ms-1">Data Buku</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link text-white " href="?views=Data-kategori">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Data Kategori</span>
                    </a>
                </li>

            <?php endif ?>


            <li class="nav-item">
                <a class="nav-link text-white " href="?views=Data-user">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Data Users</span>
                </a>
            </li>

            <?php if ($permission['role'] === 'guest') : ?>
                <li class="nav-item">
                    <a class="nav-link text-white " href="?views=List-buku">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">book</i>
                        </div>
                        <span class="nav-link-text ms-1">List Buku</span>
                    </a>
                </li>
            <?php endif ?>


            <li class="nav-item">
                <a class="nav-link text-white " href="?views=History">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">assignment</i>
                    </div>
                    <span class="nav-link-text ms-1">History</span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link text-white " href="./app/init.php?proses=log-out">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">logout</i>
                    </div>
                    <span class="nav-link-text ms-1">Log out</span>
                </a>
            </li>

        </ul>
    </div>

</aside>