<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Početna | Portal</title>
		<meta name="description" content="Portal je namjenjem svim ljubiteljima internetskih tehnologija">
        <?php include_once "includes/head.php"; ?>
    </head>
    <body>
        <header id="main-header">
            <?php include_once "includes/main_nav.php"; ?>
        </header>
        <div id="main-page-content">
            <div id="news-slider">
					<?php
						require_once "actions/dbConnection.php";
						require_once "actions/functions.php";
											
						$sql = "SELECT c.id_clanka AS id_clanka,
									   c.id_kategorije_clanka AS id_kategorije_clanka,
									   kc.naziv AS naziv_kategorije_clanka,
									   c.id_korisnika AS id_korisnika,
									   k.ime AS ime_korisnika,
									   k.prezime AS prezime_korisnika,
									   c.naslov AS naslov,
									   c.sadrzaj AS sadrzaj,
									   c.seo_naslov AS seo_naslov,
									   c.seo_opis AS seo_opis,
									   c.foto_url AS foto_url,
									   c.foto_alt_tag AS foto_alt_tag,
									   DATE_FORMAT(datum_vrijeme_objave, '%d-%m-%Y %H:%i:%s') AS datum_vrijeme_objave,
									   DATE_FORMAT(datum_vrijeme_izmjene, '%d-%m-%Y %H:%i:%s') AS datum_vrijeme_izmjene,
									   TIMESTAMPDIFF (HOUR, datum_vrijeme_objave, NOW()) AS sati_objave,
									   TIMESTAMPDIFF (MINUTE, datum_vrijeme_objave, NOW()) AS minute_objave,
									   c.pozicija AS pozicija,
									   c.broj_pregleda AS broj_pregleda
								FROM clanak c INNER JOIN kategorija_clanka kc ON (c.id_kategorije_clanka = kc.id_kategorije_clanka)
											  INNER JOIN korisnik k ON (c.id_korisnika = k.id_korisnika)
								WHERE c.pozicija = 4
								ORDER BY datum_vrijeme_objave DESC
								LIMIT 1;";
						$stmt = $pdo -> prepare($sql);
						$stmt -> execute();		
						$result = $stmt -> fetchAll(PDO::FETCH_OBJ);
						foreach ($result as $res){
							if ($res -> sati_objave < 1){
								$objavljeno_prije = $res -> minute_objave. ' minuta';
							}else {
								$objavljeno_prije = $res -> sati_objave. ' sata';
							}
							echo '<div id="ns-big">
									<img src="'.$res -> foto_url.'" class="ns-big-img" alt="'.$res -> foto_alt_tag.'">
									<div id="ns-big-details">
										<span class="ns-category nsc-big">'.$res -> naziv_kategorije_clanka.'</span>
										<a href="clanak.php?naslov='.convertForUrl($res -> naslov).'&id='.$res -> id_clanka.'"><h2 class="title title-big">'.$res -> naslov.'</h2></a>
									</div>
									<footer>
										<address>napisao <a href="https://twitter.com/MarxMM">'.$res -> ime_korisnika." ".$res -> prezime_korisnika.'</a></address>
										<time datetime="'.$res -> datum_vrijeme_objave.'">prije '.$res -> sati_objave.' sata.</time>
									</footer>
								</div>';
						}
						
						$sql = "SELECT c.id_clanka AS id_clanka,
									   c.id_kategorije_clanka AS id_kategorije_clanka,
									   kc.naziv AS naziv_kategorije_clanka,
									   c.id_korisnika AS id_korisnika,
									   k.ime AS ime_korisnika,
									   k.prezime AS prezime_korisnika,
									   c.naslov AS naslov,
									   c.sadrzaj AS sadrzaj,
									   c.seo_naslov AS seo_naslov,
									   c.seo_opis AS seo_opis,
									   c.foto_url AS foto_url,
									   c.foto_alt_tag AS foto_alt_tag,
									   DATE_FORMAT(datum_vrijeme_objave, '%d-%m-%Y %H:%i:%s') AS datum_vrijeme_objave,
									   DATE_FORMAT(datum_vrijeme_izmjene, '%d-%m-%Y %H:%i:%s') AS datum_vrijeme_izmjene,
									   TIMESTAMPDIFF (HOUR, datum_vrijeme_objave, NOW()) AS sati_objave,
									   TIMESTAMPDIFF (MINUTE, datum_vrijeme_objave, NOW()) AS minute_objave,
									   c.pozicija AS pozicija,
									   c.broj_pregleda AS broj_pregleda
								FROM clanak c INNER JOIN kategorija_clanka kc ON (c.id_kategorije_clanka = kc.id_kategorije_clanka)
											  INNER JOIN korisnik k ON (c.id_korisnika = k.id_korisnika)
								WHERE c.pozicija = 3
								ORDER BY datum_vrijeme_objave DESC
								LIMIT 2;";
						$stmt = $pdo -> prepare($sql);
						$stmt -> execute();		
						$result = $stmt -> fetchAll(PDO::FETCH_OBJ);
						foreach ($result as $res){
							if ($res -> sati_objave < 1){
								$objavljeno_prije = $res -> minute_objave. ' minuta';
							}else {
								$objavljeno_prije = $res -> sati_objave. ' sata';
							}
							echo '<div class="ns-small">
									<img src="'.$res -> foto_url.'" alt="'.$res -> foto_alt_tag.'">
									<div class="ns-small-details">
										<span class="ns-category">'.$res -> naziv_kategorije_clanka.'</span>
										<a href="clanak.php?naslov='.convertForUrl($res -> naslov).'&id='.$res -> id_clanka.'"><h2 class="title">'.$res -> naslov.'</h2></a>
									</div>
									<footer class="footer-small">
										<address>napisao <a href="https://twitter.com/MarxMM">'.$res -> ime_korisnika." ".$res -> prezime_korisnika.'</a></address>
										<time datetime="'.$res -> datum_vrijeme_objave.'">prije '.$objavljeno_prije.'.</time>
									</footer>
								</div>';
						}
					
					?>
            </div>
            <div class="articles">
                <section class="news-recent">
                    <h2>Nedavno objavljeno</h2>
					<?php
						$sql = "SELECT c.id_clanka AS id_clanka,
									   c.id_kategorije_clanka AS id_kategorije_clanka,
									   kc.naziv AS naziv_kategorije_clanka,
									   c.id_korisnika AS id_korisnika,
									   k.ime AS ime_korisnika,
									   k.prezime AS prezime_korisnika,
									   c.naslov AS naslov,
									   c.sadrzaj AS sadrzaj,
									   c.seo_naslov AS seo_naslov,
									   c.seo_opis AS seo_opis,
									   c.foto_url AS foto_url,
									   c.foto_alt_tag AS foto_alt_tag,
									   DATE_FORMAT(datum_vrijeme_objave, '%d-%m-%Y %H:%i:%s') AS datum_vrijeme_objave,
									   DATE_FORMAT(datum_vrijeme_izmjene, '%d-%m-%Y %H:%i:%s') AS datum_vrijeme_izmjene,
									   TIMESTAMPDIFF (HOUR, datum_vrijeme_objave, NOW()) AS sati_objave,
									   TIMESTAMPDIFF (MINUTE, datum_vrijeme_objave, NOW()) AS minute_objave,
									   c.pozicija AS pozicija,
									   c.broj_pregleda AS broj_pregleda
								FROM clanak c INNER JOIN kategorija_clanka kc ON (c.id_kategorije_clanka = kc.id_kategorije_clanka)
											  INNER JOIN korisnik k ON (c.id_korisnika = k.id_korisnika)
								WHERE c.pozicija = 1
								OR c.pozicija = 2
								ORDER BY datum_vrijeme_objave DESC
								LIMIT 6;";
						$stmt = $pdo -> prepare($sql);
						$stmt -> execute();		
						$result = $stmt -> fetchAll(PDO::FETCH_OBJ);
						foreach ($result as $res){
							if ($res -> sati_objave < 1){
								$objavljeno_prije = $res -> minute_objave. ' minuta';
							}else {
								$objavljeno_prije = $res -> sati_objave. ' sata';
							}
							
							$duljinaNaslova = strlen($res -> naslov);
							$dozvoljenaDuljina = 170 - $duljinaNaslova;
							
							echo '<article class="article-recent">
									<a href="clanak.php?naslov='.convertForUrl($res -> naslov).'&id='.$res -> id_clanka.'"><img src="'.$res -> foto_url.'" class="ar-img" alt="'.$res -> foto_alt_tag.'"></a>
									<div class="ar-content">
										<a href="clanak.php?naslov='.convertForUrl($res -> naslov).'&id='.$res -> id_clanka.'"><h2>'.$res -> naslov.'</h2></a>
										<p>'.substr($res -> sadrzaj, 0, $dozvoljenaDuljina).'...</p>
									</div>
									<footer>
										<address>napisao <a href="https://twitter.com/MarxMM">'.$res -> ime_korisnika." ".$res -> prezime_korisnika.'</a></address>
										<time datetime="'.$res -> datum_vrijeme_objave.'">prije '.$objavljeno_prije.'.</time>
									</footer>
									<span class="ns-category nsc-nr">'.$res -> naziv_kategorije_clanka.'</span>
								</article>';
						}
					?>
					
                </section>
                <section class="news-popular">
                    <h2>Popularni članci</h2>
					<?php
						$sql = "SELECT c.id_clanka AS id_clanka,
									   c.id_kategorije_clanka AS id_kategorije_clanka,
									   kc.naziv AS naziv_kategorije_clanka,
									   c.id_korisnika AS id_korisnika,
									   k.ime AS ime_korisnika,
									   k.prezime AS prezime_korisnika,
									   c.naslov AS naslov,
									   c.sadrzaj AS sadrzaj,
									   c.seo_naslov AS seo_naslov,
									   c.seo_opis AS seo_opis,
									   c.foto_url AS foto_url,
									   c.foto_alt_tag AS foto_alt_tag,
									   DATE_FORMAT(datum_vrijeme_objave, '%d-%m-%Y %H:%i:%s') AS datum_vrijeme_objave,
									   DATE_FORMAT(datum_vrijeme_izmjene, '%d-%m-%Y %H:%i:%s') AS datum_vrijeme_izmjene,
									   TIMESTAMPDIFF (HOUR, datum_vrijeme_objave, NOW()) AS sati_objave,
									   TIMESTAMPDIFF (MINUTE, datum_vrijeme_objave, NOW()) AS minute_objave,
									   c.pozicija AS pozicija,
									   c.broj_pregleda AS broj_pregleda
								FROM clanak c INNER JOIN kategorija_clanka kc ON (c.id_kategorije_clanka = kc.id_kategorije_clanka)
											  INNER JOIN korisnik k ON (c.id_korisnika = k.id_korisnika)
								WHERE c.pozicija = 1
								OR c.pozicija = 2
								ORDER BY c.broj_pregleda DESC
								LIMIT 6;";
						$stmt = $pdo -> prepare($sql);
						$stmt -> execute();		
						$result = $stmt -> fetchAll(PDO::FETCH_OBJ);
						foreach ($result as $res){
							if ($res -> sati_objave < 1){
								$objavljeno_prije = $res -> minute_objave. ' minuta';
							}else {
								$objavljeno_prije = $res -> sati_objave. ' sata';
							}
							
							$duljinaNaslova = strlen($res -> naslov);
							$dozvoljenaDuljina = 150 - $duljinaNaslova;
						
							echo '<article class="article-popular ap-shadow">
									<span class="ns-category">'.$res -> naziv_kategorije_clanka.'</span>
									<img src="'.$res -> foto_url.'" class="ap-img" alt="'.$res -> foto_alt_tag.'">
									<div class="ap-details">
										<a href="clanak.php?naslov='.convertForUrl($res -> naslov).'&id='.$res -> id_clanka.'"><h2>'.$res -> naslov.'</h2></a>
										<p>'.substr($res -> sadrzaj, 0, $dozvoljenaDuljina).'...</p>
									</div>
									<footer>
										<address>napisao <a href="https://twitter.com/MarxMM">'.$res -> ime_korisnika." ".$res -> prezime_korisnika.'</a></address>
										<time datetime="'.$res -> datum_vrijeme_objave.'">prije '.$objavljeno_prije.'.</time>
									</footer>
								</article>';
						}
					?>
                </section>
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
