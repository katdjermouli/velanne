<?php

// function connect_pdo () {
// 	$servername = "localhost";
// 	$username = "root";
// 	$password = "eftf";
// 	$dbname = "cimetiere_velanne";

// 	try {
// 	  $bdd = new PDO ("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password,array (PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
// 	  // set the pdo mode to exception
// 	} catch (PDOException $e) {
// 	  echo "Error: " . $e -> getMessage ();
// 	}
// 	return $bdd;

// }
include 'php/connect_pdo.php';


	function getConcessionnaire($db) {

		$resValue = array();
		$result = $db -> query ("select nom_concessionnaire, concessionnaire.num_concession, id_concessionnaire, id_concession, coords from concessionnaire, concession WHERE id_concession = id_concessionnaire");

		while ($row = $result -> fetch (PDO::FETCH_ASSOC)) {
    	$resValue [] = $row;
		}

		return $resValue;
	}

	//$connexion = connect_pdo();
	$liste_concessions = getConcessionnaire($bdd);
	?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Gestion du cimetière de Velanne</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="js/jquery.rwdImageMaps.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/maphilight/1.4.0/jquery.maphilight.min.js"></script>
		<script type="text/javascript" src="highslide/highslide.js"></script>
		<link rel="stylesheet" type="text/css" href="highslide/highslide.css">
		<link rel="stylesheet" href="styles/style.css" type="text/css">
		<link rel="shortcut icon" href="#">
		<script type="text/javascript">
			hs.graphicsDir = 'highslide/graphics/';
			hs.wrapperClassName = 'wide-border';
		</script>
	</head>

<body>


	<h2 id="titre_gen">Mairie de Velanne - Gestion du Cimetière</h2>
	<div class="bloc-image">
		<img src="images\VA_cimetiere_recadrage.jpg" alt="Plan du cimetière de Velanne" usemap="#emplacement" class="map">
			<map name="emplacement">
				<?php foreach ($liste_concessions as $concession) {
					$coords_explode = explode(",", $concession['coords']);

						if ($concession['nom_concessionnaire'] == "") {?>
							<area class="tombeLibre" shape="rect" title="<?php echo $concession['num_concession'] . ": ". "LIBRE"; ?>" coords="<?php echo $concession['coords']; ?>" href="php/infoConcession.php?idTombe=<?php echo $concession['id_concessionnaire']?>&TOPIndex=<?php echo $coords_explode[0]?>&LEFTIndex=<?php echo $coords_explode[1]?>">
						<?php } else { ?>
							<area class="tombeOccupee" shape="rect" title="<?php echo $concession['num_concession'] . ": ". $concession['nom_concessionnaire']; ?>" coords="<?php echo $concession['coords']; ?>" href="php/infoConcession.php?idTombe=<?php echo $concession['id_concessionnaire']?>&TOPIndex=<?php echo $coords_explode[0]?>&LEFTIndex=<?php echo $coords_explode[1]?>">
						<?php } // end else
					} // end foreach ?>
			</map>

		<a href="images/VA_cimetiere_aide.jpg" class="PlusInfo" onclick="return hs.expand(this)">Aide zonage du cimetière</a>
		<div class="highslide-caption">Aide zonage du cimetière</div>

	</div>
	<div id="infoConcession"></div>


<div class="left-container">
	<div class="formulaire-de-recherche">
		<h3>Menu Général</h3>
		<br>
		<h4 id="titre_accueil">Rechercher un emplacement par:</h4>
		<form class="form_recherche" action="php/recherche.php" method="post">
			<label>Nom du Propriétaire</label>
			<input type="text" name="nomproprio"/>
			<br><label>Numéro de Concession</label>
			<input type="text" name="numconcession"/>
			<br><input class="boutonR" type="submit" name="submit" value="Rechercher"/>
			<div id="resRecherche" ></div>
		</form>
	</div>


	<div class="listing_info">
	<h4 id="titre_accueil">Trier les données du cimetière par :</h4>
	<br>
	<ul id="liste_liens">
		<li><a class="liens" id="lien0" href="php/ListingProprio.php">- Noms de propriétaires</a></li>
		<br>
		<li><a class="liens" id="lien1" href="php/ListingConcession.php">- Noms de concessions</a></li>
		<br>
		<li><a class="liens" id="lien2" href="php/ListingLibre.php">- Emplacements libres</a></li>
		<br>
		<li><a class="liens" id="lien3" href="php/ListingDate.php">- Date de renouvellement</a></li>
	</ul>
	<br>
	<br>
	<h4><strong>Informations complémentaires</strong></h4>
	<br>
	<ul id="liste_liens">
		<li><a class="liens" id="lien4" href="tarifs_concessions.html">- Tarifs</a></li>
		<li><a class="liens" id="lien5" href="notice_logiciel.html">- Notice d'utilisation du logiciel</a></li>
		<div id="resInfoSup"></div>
	</ul>
	<div id="resInfoSup"></div>
	</div>
</div>

<script>
	$( document ).ready(function() { //************************* document ready *************************//
			console.log("ready to go");

			$('map').rwdImageMaps(); // works just fine



				// formulaire de recherche
		$(".form_recherche").submit(function (event) {
			event.preventDefault ();

			var form_url = $(this).attr("action");
			var form_method = $(this).attr("method");
			var form_data = $(this).serialize (); // encoder les élements du formulaire pour la soumission.

			$.ajax ({
				url : form_url,
				type: form_method,
				data: form_data
			}).done (function (response) {
				$("#resRecherche").html(response);
			});
		});

		$("#lien4").on("click", function (e) {
			e.preventDefault();
			var form_url = "tarifs_concessions.html";

			$.ajax ({
				url : form_url,
				type: "post",

			}).done (function (response) {
				$("#resInfoSup").html(response);
			});
		});



		$(function() {
    	$('.map').maphilight();
		});

		// clicked area
		$('area').on('click', function(event){
			event.preventDefault();
			$(this).data('maphilight', {'alwaysOn': true}).trigger('alwaysOn.maphilight');

			var url_info = $(this).attr('href');
			$.ajax ({
				url : url_info,
				type: "post",
			}).done (function (response) {
				$(".left-container").html(response);
			});
		});

	});





</script>

</body>
</html>







