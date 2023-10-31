<html>
<title>
    <?= $page_title; ?>
</title>
<link rel="icon" href="<?= base_url('assets\img\logo.jpg')  ?>" type="image/icon type">
<meta charset=" utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<title>Dashboard - Tabler </title>
<?php
$this->load->view('admin/include/header');
?>

<body>
    <script src="<?= base_url('assets/dist/'); ?>js/demo-theme.min.js?1692870487"></script>
    <div class="page">
        <?php $this->load->view('admin/include/topbar'); ?>

        <?php $this->load->view($page_name); ?>
    </div>
    </div>
</body>

<script src="<?= base_url('assets/dist/'); ?>libs/apexcharts/dist/apexcharts.min.js?1692870487" defer></script>
<script src="<?= base_url('assets/dist/'); ?>libs/jsvectormap/dist/js/jsvectormap.min.js?1692870487" defer></script>
<script src="<?= base_url('assets/dist/'); ?>libs/jsvectormap/dist/maps/world.js?1692870487" defer></script>
<script src="<?= base_url('assets/dist/'); ?>libs/jsvectormap/dist/maps/world-merc.js?1692870487" defer></script>
<!-- Tabler Core -->
<script src="<?= base_url('assets/dist/'); ?>js/tabler.min.js?1692870487" defer></script>
<script src="<?= base_url('assets/dist/'); ?>js/demo.min.js?1692870487" defer></script>
<!-- data tables script -->
<script src="<?= base_url("assets/") ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url("assets/") ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/datatables/dataTables.checkboxes.min.js"></script>
<script href="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- data table in jquery -->
<script>
    $(document).ready(function() {

        $("#example1").DataTable({
            processing: true,
        });

        $(' .select2').select2({
            placeholder: "-- Select --",
            allowClear: true,
        });
    });
</script>



<?php
$this->load->view('admin/include/footer');
?>

</html>