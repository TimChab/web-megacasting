<?php

require_once __DIR__.'/Models/Repositories/Repositories.Offre.php';
if (isset($_GET['search'])) {
	$AnnonceList = OffreRepository::SearchOffre($_POST['SearchString']);
} else {
	$AnnonceList = OffreRepository::GetAllOffres();
}

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
							<p style="display: block;">Il y a <?php echo count($AnnonceList);?> offre(s)</p>
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
												<a href="https://youtu.be/s6zR2T9vn2c" class="button fit" data-poptrox="youtube,800x400">Voir plus</a>
											</div>
										</div>

										';
									}
							?>

						</div>

					</div>
				</div>

			<!-- Footer -->
				<footer id="footer">
					<div class="inner">
						<h2>Nous contacter</h2>
						<p>Pellentesque eleifend malesuada efficitur. Curabitur volutpat dui mi, ac imperdiet dolor tincidunt nec. Ut erat lectus, dictum sit amet lectus a, aliquet rutrum mauris. Etiam nec lectus hendrerit, consectetur risus viverra, iaculis orci. Phasellus eu nibh ut mi luctus auctor. Donec sit amet dolor in diam feugiat venenatis. </p>

						<ul class="icons">
							<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
							<li><a href="#" class="icon fa-envelope"><span class="label">Email</span></a></li>
						</ul>
						<p class="copyright">&copy; Untitled. Design: <a href="https://templated.co">TEMPLATED</a>. Images: <a href="https://unsplash.com/">Unsplash</a>. Videos: <a href="http://coverr.co/">Coverr</a>.</p>
					</div>
				</footer>

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
