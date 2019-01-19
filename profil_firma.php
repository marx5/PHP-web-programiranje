<?php session_start(); 

	if (!isset($_SESSION['firm'])){
		header ("location: index.php");
		die();
	}
	
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Firma profil | Portal</title>
		<meta name="description" content="Firma profil">
        <?php include_once "includes/head.php"; ?>
    </head>
    <body>
        <header id="main-header">
            <?php include_once "includes/main_nav.php"; ?>
        </header>
        <div id="main-page-content">
            <?php require_once "includes/page_components/refreshFirmPageData.php"; ?>
        </div>
		<?php 
		    include_once "includes/modals/changefirmData_mod.php"; 
			include_once "includes/modals/changePass_mod.php";
			include_once "includes/modals/offerJob_mod.php";
			include_once "includes/modals/changeJob_mod.php";
			include_once "includes/modals/uploadImg_mod.php";

		?>
        <footer id="main-footer">
            <?php include_once "includes/footer.php"; ?>
        </footer>
        <script src="js/script.js"></script>
    </body>
</html>
