<head>
	<meta charset="utf-8" />
	<title>Panel | Dashboard</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<?php $assetsRoot = "vendor/lighty/kernel/src/Dashboard/"; ?>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->

	<!-- To add sub path like plugin path -->
	<?php if($page=="plugin") Dashboard::$assets = "../".Dashboard::$assets; ?>

	<link href="<?php echo Dashboard::$assets ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo Dashboard::$assets ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo Dashboard::$assets ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo Dashboard::$assets ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<link href="<?php echo Dashboard::$assets ?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo Dashboard::$assets ?>assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo Dashboard::$assets ?>assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo Dashboard::$assets ?>assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN THEME GLOBAL STYLES -->
	<link href="<?php echo Dashboard::$assets ?>assets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
	<link href="<?php echo Dashboard::$assets ?>assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
	<!-- END THEME GLOBAL STYLES -->
	<!-- BEGIN THEME LAYOUT STYLES -->
	<link href="<?php echo Dashboard::$assets ?>assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo Dashboard::$assets ?>assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
	<link href="<?php echo Dashboard::$assets ?>assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo Dashboard::$assets ?>assets/css/glob.css" rel="stylesheet" type="text/css" />
	<!-- END THEME LAYOUT STYLES -->
	<link rel="shortcut icon" href="favicon.ico" />
</head>