<?php 

	if (!isset($_SESSION['user'])){
		session_start();
	}
	
	if (!isset($_SESSION['user'])){
		header ("location: index.php");
		die();
	}
	
	require_once "actions/functions.php";
	require_once "actions/dbConnection.php";
	
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin profil | Portal</title>
		<meta name="description" content="Administratorsko sučelje">
        <?php include_once "includes/head.php"; ?>
    </head>
    <body>
        <header id="main-header">
            <?php include_once "includes/main_nav.php"; ?>
        </header>
        <nav class="admin-top-menu">
            <ul>
                <li><a onclick="refreshContent('includes/page_components/addPostAdmin.php', 'main-page-content-admin');">Nova vijest</a></li>
                <li><a onclick="refreshContent('includes/page_components/newsAdmin.php', 'main-page-content-admin')">Vijesti</a></li>
                <li><a onclick="refreshContent('includes/page_components/jobsAdmin.php', 'main-page-content-admin')">Poslovi</a></li>
                <li><a onclick="refreshContent('includes/page_components/commentsAdmin.php', 'main-page-content-admin')">Komentari</a></li>
                <li><a onclick="refreshContent('includes/page_components/usersAdmin.php', 'main-page-content-admin')">Korisnici</a></li>
            </ul>
        </nav>
        <div id="main-page-content-admin">
            <?php include_once "includes/page_components/addPostAdmin.php"; ?>
        </div>
		<?php 
			include_once "includes/modals/addUser_mod.php";
		    include_once "includes/modals/firmData_mod.php"; 
			include_once "includes/modals/changeJobAdmin_mod.php"; 
			include_once "includes/modals/uploadImg_mod.php";
			include_once "includes/modals/changeBlogPost_mod.php";
			include_once "includes/modals/changeCommentAdmin_mod.php";
		?>
        <footer id="main-footer">
            <?php include_once "includes/footer.php"; ?>
        </footer>
        <script src="js/script.js"></script>
    </body>
</html>
