<?php
require_once __DIR__.'/../Models/Repositories/Repositories.Offre.php';
require_once __DIR__.'/Footer.php';

$Annonce = OffreRepository::GetOffre($_GET['id']);
$Annonce = $Annonce[0];
?>

<!DOCTYPE HTML>
<!--
	Full Motion by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Mega Casting</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />
	</head>
	<body id="top">

			<!-- Banner -->
			<!--
				To use a video as your background, set data-video to the name of your video without
				its extension (eg. images/banner). Your video must be available in both .mp4 and .webm
				formats to work correctly.
			-->
				<section id="banner" data-video="../assets/images/banner">
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

					<!-- Boxes -->
						<div class="thumbnails">



										<div class="box">
											<div class="inner desc" >
												<h3><?php echo $Annonce->Intitule; ?></h3>
												<p><?php echo $Annonce->Description_Poste; ?></p>
                        <p><h5>Date de début du contrat : </h5><?php  echo substr($Annonce->Date_Debut_Contrat, 0, 10); ?></p>
                        <p><h5>Nombre de poste(s) à pouvoir : </h5><?php  echo $Annonce->Nombre_Poste; ?></p>
                        <p><h5>Lieu : </h5><?php  echo $Annonce->Localisation; ?></p>
                        <p><h5>Profil recherché : </h5><?php  echo $Annonce->Description_Profil; ?></p>
											</div>
										</div>

						</div>

					</div>
				</div>

<?php echo $footer;?>

		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/jquery.scrolly.min.js"></script>
			<script src="../assets/js/jquery.poptrox.min.js"></script>
			<script src="../assets/js/skel.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<script src="../assets/js/main.js"></script>

	</body>
</html>
