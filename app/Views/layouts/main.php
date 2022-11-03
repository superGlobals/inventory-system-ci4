<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Invetory System</title>

	<link href="<?= base_url('assets/css/app.css')?>" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    
</head>

<body>
    

<div class="wrapper">

<?= $this->include('layouts/inc/sidebar') ?>
<div class="main">
<?= $this->include('layouts/inc/content') ?>
    
    <?= $this->renderSection('content') ?>


    <?= $this->include('layouts/inc/footer') ?>   
</div>
</div>


<script src="<?= base_url('assets/js/jquery-3.6.1.js') ?>"></script>
<script src="<?= base_url('assets/js/app.js') ?>"></script>
<script src="<?= base_url('assets/js/popper.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>" ></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        
        <?php if(session()->getFlashdata('status')): ?>
            Swal.fire({
                title: "<?= session()->getFlashdata('status') ?>",
                text: "<?= session()->getFlashdata('status_text') ?>",
                icon: "<?= session()->getFlashdata('status_icon') ?>",
                timer: 2000,
                })
        <?php endif; ?>

    });
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>