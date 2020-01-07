<?php
require_once __DIR__.'/Models/Repositories/Repositories.Offre.php';
require_once __DIR__.'/Public/Footer.php';

if (isset($_GET['search'])) {
	$AnnonceList = OffreRepository::SearchOffre($_POST['SearchString']);
} else {
	$AnnonceList = OffreRepository::GetAllOffres();
}

$nbOffre2 = OffreRepository::CountOffre();
$nbOffre = $nbOffre2["nbOffre"];
$nbElementParPage = 9;
$nbPages =ceil($nbOffre/$nbElementParPage);
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Mega Casting</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body id="top">

			<!-- Banner -->
			<!--
				To use a video as your background, set data-video to the name of your video without
				its extension (eg. images/banner). Your video must be available in both .mp4 and .webm
				formats to work correctly.
			-->
				<section id="banner" data-video="assets/images/banner">
					<div class="inner">
						<header>
							<h1>MegaCasting</h1>
							<p>Tout ce que vous recherchez dans le monde de l'audio-visuel<br />
						</header>
						<a href="#main" class="more">Voir plus</a>
					</div>
				</section>

			<!-- Main -->
				<div id="main">
					<div class="inner">
						<form class="form" action="?search=true" method="post">
							<div class="form-group search-bar">
								<input type="text" name="SearchString" placeholder="Rechercher une offre"/>
								<input type="submit" value="Rechercher"/>
							</div>
							<p style="display: block;">Il y aura <?php echo $nbPages; ?> pages</p>
							<p style="display: block;">Il y a <?php echo count($AnnonceList);?> offre(s) <?php if(isset($_GET['search'])){ echo ' pour "'.$_POST['SearchString'].'"'; }?></p>
						</form>
						<div class="">
							<?php
								if (isset($_GET['search'])) {
									echo '	<p>
														Résultat(s) de la recherche :
													</p>';
								}

							?>
						</div>
					<!-- Boxes -->
						<div class="thumbnails">



							<?php


									foreach ($AnnonceList as $key => $Annonce) {
										echo '
										<div class="box">
											<div class="image fit"><img src="assets/images/pic01.jpg" alt="" /></div>
											<div class="inner desc" >
												<h3>'. $Annonce->Intitule .'</h3>
												<p>'.$Annonce->Description_Poste.'</p>
												<a href="/Public/Offre.php?id='.$Annonce->Identifiant.'" target="_blank" class="button fit" data-poptrox="youtube,800x400">Voir plus</a>
											</div>
										</div>

										';
									}
							?>

						</div>

						<div class="">
							<a href="?page=1">début</a>
							<a href="?page=<?php echo  $nbPages ?>">Fin</a>
						</div>

					</div>
				</div>

<?php
echo $footer;
?>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.poptrox.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
<style media="screen">
	.search-bar {
		display: inline-flex;
		position: absolute;
		right: 1%;
	}
</style>
