<?php require_once './app/init.php'; ?>
<?php if ($session->get('id')) : ?>
    <?php require_once './src/partials/head.php'; ?>

    <body class="g-sidenav-show  bg-gray-100">
        <?php require_once './src/partials/side-bar.php'; ?>
        <main class="main-content border-radius-lg ">
            <div class="container-fluid py-4">
                <?php require_once './src/partials/nav-bar.php'; ?>
                <br>

                <!-- start contents -->
                <?php
                $pages = $_GET['views'] ?? "Dashboard";
                switch ($pages) {
                    case $pages:
                        require_once "./src/views/" . $pages . ".php";
                        break;

                    default:
                        require_once "./src/views/Dashboard.php";
                        break;
                }
                ?>
                <!-- end contents -->

                <?php require_once './src/partials/footer.php'; ?>
            </div>
        </main>
        <?php require_once './src/partials/script.php'; ?>
    </body>

    </html>

<?php else : ?>
    <?php
    $pages = $_GET['views'] ?? null;
    if ($pages === "sign-up") : ?>
        <?php require_once './src/pages/sign-up.php'; ?>
        <?php exit; ?>
    <?php endif ?>
    <?php require_once './src/pages/sign-in.php'; ?>
<?php endif ?>