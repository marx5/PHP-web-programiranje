<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Poslovi | Portal</title>
		<meta name="description" content="Ponuda poslova IT, digitalni marketing i razno...">
        <?php include_once "includes/head.php"; ?>
    </head>
    <body>
        <header id="main-header">
            <?php include_once "includes/main_nav.php"; ?>
        </header>
        <div id="main-page-content">
            <div class="articles articles1">
                <section class="news-recent">
                    <div class="job-grid">
                        <h1 class="job-page-title">Ponuda poslova</h1>
						<?php
						
							require_once "actions/dbConnection.php";
											
							$sql = "SELECT p.id_posla AS id_posla,
										   f.naziv AS naziv_firme,
										   f.logo_url AS logo_firme,
										   p.radno_mjesto AS radno_mjesto,
										   p.mjesto_rada AS mjesto_rada,
										   p.posao_url AS posao_url,
										   p.datum_vrijeme_objave AS datum_vrijeme_objave,
										   DATE_FORMAT(datum_do, '%d-%m-%Y') AS datum_do,
										   p.status AS status
									FROM posao p INNER JOIN firma f ON (p.id_firme = f.id_firme)
									WHERE status=1
									AND DATE(datum_vrijeme_objave) <= DATE(NOW())
									AND DATE(datum_do) >= DATE(CURDATE())
									ORDER BY datum_vrijeme_objave DESC;";
							$stmt = $pdo -> prepare($sql);
							$stmt -> execute();		
							$result = $stmt -> fetchAll(PDO::FETCH_OBJ);
							foreach ($result as $res){
								echo '<article class="job-box">
										<a href="'.$res -> posao_url.'" target="_blank"><img src="'.$res -> logo_firme.'" class="job-logo-box"></a>
										<div class="job-details-box">
											<a href="'.$res -> posao_url.'" target="_blank"><h3>'.$res -> radno_mjesto.'</h3></a>
											<time datetime="'.$res -> datum_vrijeme_objave.'"><b>'.$res -> naziv_firme.'</b> do '.$res -> datum_do.'. '.$res -> mjesto_rada.'</time>
										</div>
									</article>';									
							}
						
						?>
                    </div>                    
                </section>
                <aside class="jobs offer-job-aside">
                    <h2>Nudim posao</h2>
                    <p>Posao je moguće ponuditi samo uz prethodnu registraciju na portal. 
                        Ako ste već registrirani prijavite se i ponudite posao.</p>
                    <a class="btn-reg-log" id="btn-register-modal" onclick="ActivateModal('modal-register', 'close-register');">Registracija</a>
                    <a class="btn-reg-log" id="btn-login-modal" onclick="ActivateModal('modal-login', 'close-login');" >Prijava</a>
                </aside>
            </div>
            <?php 
				include_once "includes/modals/register_mod.php"; 
				include_once "includes/modals/login_mod.php"; 
			?>
        </div>
        <footer id="main-footer">
            <?php include_once "includes/footer.php"; ?>
        </footer>
        <script src="js/script.js"></script>
    </body>
</html>
