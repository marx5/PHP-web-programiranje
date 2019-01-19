<?php

	session_start();
	
	if(isset($_SESSION['firm'])){
		$id = $_SESSION['firm']['id_firme'];
		$savefolder = "img/firm_logos";
		$name = "firmaId_".$id.".";
	}

	if(isset($_SESSION['user'])){
		$id = round(microtime(true));
		$savefolder = "img/blog_photos";
		$name = "post_".$id.".";
	}

	$allowedtypes = array("image/jpeg", "image/pjpeg", "image/png", "image/gif");
	
	if (isset($_FILES['myfile'])){
		if (in_array($_FILES['myfile']['type'], $allowedtypes)){
			if ($_FILES['myfile']['error'] == 0 && $_FILES['myfile']['size'] <= 500000){
				$temp = explode(".", $_FILES['myfile']['name']);
				$newFileName = $name . end($temp);
				$thefile = $savefolder ."/". $newFileName;
				if (!move_uploaded_file($_FILES['myfile']['tmp_name'], $thefile)){
					echo "Prijenos nije uspio";
				}else {
					?>
					<!DOCTYPE html>
					<html>
						<head>
							<script src = "js/script.js"></script>
						</head>
						<body onload = "doneloading(parent, '<?php echo $thefile; ?>')">
							<img src = "<?php echo $thefile; ?>"/> 
						</body>
					</html>
					<?php
				}
			}else {
				echo "Logo ne smije biti veći od 500 kilobajta!";
			}
		}
	}
	
?>