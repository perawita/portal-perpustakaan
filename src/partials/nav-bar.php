<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <?php if ($_GET['views'] === "From-data-buku" || $_GET['views'] === "From-data-kategori") : ?>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                        <?= $_GET['views'] === 'From-data-buku' ? 'Data buku' : 'Data kategori'; ?>
                    </li>
                <?php endif; ?>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    <?php
                    $views = $_GET['views'] ?? "Dashboard";
                    $views = preg_replace('/[^a-zA-Z0-9 ]/', ' ', $views);
                    echo $views;
                    ?></li>
            </ol>
            <h6 class="font-weight-bolder mb-0">
                <?php
                $views = $_GET['views'] ?? "Dashboard";
                $views = preg_replace('/[^a-zA-Z0-9 ]/', ' ', $views);
                echo $views;
                ?></h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                
                </div>
            <ul class="navbar-nav  justify-content-end">
                <?php if ($_GET['views'] === "Data-buku" || $_GET['views'] === "Data-kategori") : ?>
                    <li class="nav-item d-flex align-items-center">
                        <a class="btn btn-outline-primary btn-sm mb-0 me-3" href="?views=<?= $_GET['views'] === "Data-buku" ? 'From-data-buku' : "From-data-kategori"; ?>">From
                            <?php
                            $views = $_GET['views'] ?? "Dashboard";
                            $views = preg_replace('/[^a-zA-Z0-9 ]/', ' ', $views);
                            echo $views;
                            ?></a>
                    </li>
                <?php endif; ?>

                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>