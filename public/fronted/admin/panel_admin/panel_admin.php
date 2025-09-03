<?php include __DIR__ . '/../../../backend/admin/panel_admin.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin</title>
	<link href="../vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
	<link rel="stylesheet" href="../vendor/nouislider/nouislider.min.css">
	<link href="../css/style.css" rel="stylesheet">
</head>

<body>
	<!-- Preloader -->
	<?php include "preloader.php"; ?>

	<div id="main-wrapper">
		<!-- Navbar header -->
		<?php include "navbar_header.php"; ?>

		<!-- Header -->
		<?php include "header.php"; ?>

		<!-- Sidebar -->
		<?php include "navbar.php"; ?>

		<!-- Content -->
		<div class="content-body">
			<div class="container-fluid">
				<?php include $archivoIncluir; ?>
			</div>
		</div>
	</div>
</body>

</html>

<!--**********************************
        Footer start
***********************************-->
<!--**********************************
        Footer end
***********************************-->
</div>
<!--**********************************
    Main wrapper end
***********************************-->

<!-- Required vendors -->
<script src="../vendor/global/global.min.js"></script>
<script src="../vendor/chart.js/Chart.bundle.min.js"></script>
<script src="../vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="../vendor/apexchart/apexchart.js"></script>
<script src="../vendor/nouislider/nouislider.min.js"></script>
<script src="../vendor/wnumb/wNumb.js"></script>
<script src="/Panel de Administración/js/dashboard/dashboard-1.js"></script>
<script src="../js/custom.min.js"></script>
<script src="../js/dlabnav-init.js"></script>
<script src="../js/demo.js"></script>
<script src="../js/styleSwitcher.js"></script>
<script src="script/obtener_datos.js"></script>
<script src="/Panel de Administración/panel_admin/Inicio/script/datos_grafica.js"></script>
<script src="script.js"></script>

<?php
ob_end_flush();
?>