<?php 

session_start(); 
require_once "actions/dbConnection.php";
require_once "actions/functions.php";

$id_clanka = dataFilter("id", "i", "get");

$sql = "UPDATE clanak
		SET broj_pregleda = broj_pregleda + 1
		WHERE id_clanka = $id_clanka";
$stmt = $pdo -> prepare($sql);
$stmt -> execute();		

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
			   DATE_FORMAT(datum_vrijeme_objave, '%d.%m.%Y. %H:%i') AS datum_vrijeme_objave_front,
			   DATE_FORMAT(datum_vrijeme_izmjene, '%d-%m-%Y %H:%i:%s') AS datum_vrijeme_izmjene,
			   TIMESTAMPDIFF (HOUR, datum_vrijeme_objave, NOW()) AS sati_objave,
			   TIMESTAMPDIFF (MINUTE, datum_vrijeme_objave, NOW()) AS minute_objave,
			   c.pozicija AS pozicija,
			   c.broj_pregleda AS broj_pregleda
		FROM clanak c INNER JOIN kategorija_clanka kc ON (c.id_kategorije_clanka = kc.id_kategorije_clanka)
					  INNER JOIN korisnik k ON (c.id_korisnika = k.id_korisnika)
		WHERE c.id_clanka = $id_clanka
		LIMIT 1;";
		
$stmt = $pdo -> prepare($sql);
$stmt -> execute();		
$result = $stmt -> fetchAll(PDO::FETCH_OBJ);
foreach ($result as $res){
	$naslov = $res -> naslov;
	$seo_naslov = $res -> seo_naslov;
	$seo_opis = $res -> seo_opis;
	$datum_vrijeme_objave = $res -> datum_vrijeme_objave;
	$datum_vrijeme_objave_front = $res -> datum_vrijeme_objave_front;
	$ime_prezime = $res -> ime_korisnika .' '. $res -> prezime_korisnika;
	$foto_url = $res -> foto_url;
	$foto_alt_tag = $res -> foto_alt_tag;
	$sadrzaj = $res -> sadrzaj;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $seo_naslov; ?> | Portal</title>
		<meta name="description" content="<?php echo $seo_opis; ?>">
        <?php include_once "includes/head.php"; ?>
    </head>
    <body>
        <header id="main-header">
            <?php include_once "includes/main_nav.php"; ?>
        </header>
		<div id="main-page-content">
            <div class="articles articles1">
                <section class="news-recent">
                    <article class="article-cat-big article-full">
                        <h1 class="article-title"><?php echo $naslov; ?></h1>
                        <div class="article-details">
                            <time datetime="<?php echo $datum_vrijeme_objave; ?>"><?php echo $datum_vrijeme_objave_front .'h'; ?> -</time>
                            <address><a href="https://twitter.com/bornagrilec"><?php echo $ime_prezime; ?></a></address>
                        </div>
                        <img src="<?php echo $foto_url; ?>" class="ar-cat-big-img" alt="<?php echo $foto_alt_tag; ?>">
                        <p><?php echo $sadrzaj; ?></p>
                    </article>
                    <div class="comments">
                    <hr class="article-comments-line">
                        <h2>Komentari</h2>
                        <dialog id="refresh-dialog">
						<?php
							$sql = "SELECT komentar,
										   ime_prezime,
										   DATE_FORMAT(datum_vrijeme_objave, '%d-%m-%Y %H:%i:%s') AS datum_vrijeme_objave,
										   DATE_FORMAT(datum_vrijeme_objave, '%d.%m.%Y. %H:%i') AS datum_vrijeme_objave_front
									FROM komentar
									WHERE id_clanka = $id_clanka
									AND status = 1
									ORDER BY datum_vrijeme_objave DESC;";
									
							$stmt = $pdo -> prepare($sql);
							$stmt -> execute();		
							$result = $stmt -> fetchAll(PDO::FETCH_OBJ);
							foreach ($result as $res){
								echo '<div class="dialog-content">
											<i class="ion-ios-list-outline"></i>
											<dt>
												<a href="">'.$res -> ime_prezime.'</a>
												<time datetime="'.$res -> datum_vrijeme_objave.'">'.$res -> datum_vrijeme_objave_front.'h</time>
											</dt>
											<dd>'.$res -> komentar.'</dd>
										</div>';
							}
						?>
                        </dialog>                    
                    </div>
                    <form id="comment-form" onsubmit = "return false">
                        <h3>Vaš komentar</h3>
                        <textarea placeholder=" Komentar..." id="c_comment"></textarea>
                        <div class="comment-form-inputs">
                            <div class="comment-form-row">
                                <label for="c_name">Ime<span class="req"> *</span></label>
                                <input type="text" id="c_name" placeholder=" Ime i prezime">
                            </div>
                            <div class="comment-form-row">
                                <label for="c_email">Email<span class="req"> *</span> (nije vidljiv čitateljima)</label>
                                <input type="text" id="c_email" placeholder=" Email">
                            </div>
                            <a class="btn-comment btn-comment-form" onclick="commentBlogPost('<?php echo $id_clanka; ?>');">Komentiraj</a>
                        </div>
                    </form>
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
