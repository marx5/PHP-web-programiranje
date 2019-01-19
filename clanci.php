<?php 

session_start(); 
require_once "actions/dbConnection.php";
require_once "actions/functions.php";

$kategorija = convertFromUrl(dataFilter("cat", "s", "get"));

if ($kategorija == "Informacijske tehnologije"){
	$desc = "Kategorija informacijskih tehnologija obuhvaća članke vezane uz sam razvoj aplikacija...";
}else {
	$desc = "Kategorija digitalni marketing obuhvaća članke vezane uz sam način komuniciranja putem digitalnih medija, pravila...";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $kategorija; ?> | Portal</title>
		<meta name="description" content="<?php echo $desc; ?>">
        <?php include_once "includes/head.php"; ?>
    </head>
    <body>
        <header id="main-header">
            <?php include_once "includes/main_nav.php"; ?>
        </header>
		<div id="main-page-content">
            <div class="articles articles1">
                <section class="news-recent">
                    <h1 class="category-title"><?php echo $kategorija; ?></h1>
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
								WHERE kc.naziv LIKE '$kategorija'
								ORDER BY datum_vrijeme_objave DESC;";
								
						$stmt = $pdo -> prepare($sql);
						$stmt -> execute();		
						$result = $stmt -> fetchAll(PDO::FETCH_OBJ);
						foreach ($result as $res){
							if ($res -> sati_objave < 1){
								$objavljeno_prije = $res -> minute_objave. ' minuta';
							}else {
								$objavljeno_prije = $res -> sati_objave. ' sata';
							}
							
							if ($res -> pozicija == 2){
								$duljinaNaslova = strlen($res -> naslov);
								$dozvoljenaDuljina = 600 - $duljinaNaslova;
								
								echo '<article class="article-cat-big">
										<a href="clanak.php?naslov='.convertForUrl($res -> naslov).'&id='.$res -> id_clanka.'"><img src="'.$res -> foto_url.'" class="ar-cat-big-img" alt="'.$res -> foto_alt_tag.'"></a>
										<a href="clanak.php?naslov='.convertForUrl($res -> naslov).'&id='.$res -> id_clanka.'"><h2>'.$res -> naslov.'</h2></a>
										<p>'.substr($res -> sadrzaj, 0, $dozvoljenaDuljina).'...</p>
										<footer>
											<address>napisao <a href="https://twitter.com/bornagrilec">'.$res -> ime_korisnika." ".$res -> prezime_korisnika.'</a></address>
											<time datetime="'.$res -> datum_vrijeme_objave.'">prije '.$objavljeno_prije.'.</time>
										</footer>
									</article>';
							}else {
								$duljinaNaslova = strlen($res -> naslov);
								$dozvoljenaDuljina = 370 - $duljinaNaslova;
								echo '<article class="article-cat-small">
										<a href="clanak.php?naslov='.convertForUrl($res -> naslov).'&id='.$res -> id_clanka.'"><img src="'.$res -> foto_url.'" class="ar-cat-small-img" alt="'.$res -> foto_alt_tag.'"></a>
										<div class="article-cat-small-inner">
											<a href="clanak.php?naslov='.convertForUrl($res -> naslov).'&id='.$res -> id_clanka.'"><h2>'.$res -> naslov.'</h2></a>
											<p>'.substr($res -> sadrzaj, 0, $dozvoljenaDuljina).'...</p>
										</div>
										<footer>
											<address>napisao <a href="https://twitter.com/bornagrilec">'.$res -> ime_korisnika." ".$res -> prezime_korisnika.'</a></address>
											<time datetime="'.$res -> datum_vrijeme_objave.'">prije '.$objavljeno_prije.'.</time>
										</footer>
									</article>';
							}
						}
											
					
					?>
                </section>
                <?php include_once "includes/aside_jobs.php"; ?>
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
