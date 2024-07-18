<script src="./src/assets/js/core/popper.min.js"></script>
<script src="./src/assets/js/core/bootstrap.min.js"></script>
<script src="./src/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="./src/assets/js/plugins/smooth-scrollbar.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

    new DataTable('#table');
</script>



<script async defer src="https://buttons.github.io/buttons.js"></script>

<script src="./src/assets/js/material-dashboard.min.js?v=3.1.0"></script>