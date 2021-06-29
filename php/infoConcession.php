<?php

	include ("connect_pdo.php");

	header('Content-type: text/html');

	$reg = $_GET['idTombe'];

	if (isset($reg)) {


		//$result = $bdd -> query ("SELECT nom_concessionnaire, concessionnaire.num_concession, date_engagement, date_fin, personnes_enterrees, type_concession, date_renouvellement, prix_concession, surface, nb_place, Observations, photo, acte_concession from concessionnaire, concession WHERE id_concessionnaire = '{$reg}'");
		$result = $bdd -> query ("SELECT nom_concessionnaire, concessionnaire.num_concession, date_engagement, date_fin, personnes_enterrees, type_concession, date_renouvellement, prix_concession, surface, nb_place, Observations, photo, acte_concession FROM concessionnaire LEFT JOIN possede ON concessionnaire.id_concessionnaire = '{$reg}' LEFT JOIN concession ON concession.id_concession = possede.id_concession");
		$row = $result -> fetch (PDO::FETCH_ASSOC);
		$numero_concession = $row['num_concession'];

		// requête qui récupère le nombre de concessions par concessionnaire
		$count_numero_sql = "SELECT COUNT(*) AS nombre_concessions FROM concessionnaire LEFT JOIN possede ON concessionnaire.id_concessionnaire = possede.id_concessionnaire LEFT JOIN concession ON concession.id_concession = possede.id_concession WHERE concessionnaire.id_concessionnaire = '{$reg}'";
		$result_count = $bdd -> query ($count_numero_sql);
		$res = $result_count -> fetch (PDO::FETCH_ASSOC);
		print_r($res);


// 		SELECT *
// FROM concessionnaire
// LEFT JOIN possede ON concessionnaire.id_concessionnaire = possede.id_concessionnaire
// LEFT JOIN concession ON concession.id_concession = possede.id_concession


	// while ($res = $result_count -> fetch (PDO::FETCH_ASSOC)) {
	//
	// }

	}//end isset








	?>


		<h3>Informations de la concession</h3>
		<a class="retour_accueil" href="../index.php" style="color: #345e5e; margin-top: 20px 0;">Retour sur la page d'accueil</a>
			<div class="container" style="max-width:600px;margin:30px auto;">
			<form role="form">
			   <div class="form-group"></label>
					<label for="nomConcessionnaire">Nom du concessionnaire</label>
						<input type="text" class="infoConcessions" name="nom_concession" value="<?php echo $row['nom_concessionnaire']; ?>">
			   </div>

				 <!-- <div class="form-group">
								<label for="numero">Numéro de concession</label>
								<input type="text" class="infoConcessions" name="num_concession" size="4" value="<?php echo $row['num_concession']; ?>">
							 <a class="supprimer_numero" href="#" style="display: inline;"><img id="trash_img" src="../images/trash.png" style="width: 15px; height: 20px; max-width: 100%;" alt="Supprimer le concession"></a>
								<button type="submit" name="trash_button" style="display: inline; border: none;"><img id="trash_img" src="../images/trash.png" style="width: 15px; height: 20px; max-width: 100%;" alt="Supprimer le concession"></button>
				   		</div> -->
			   <div class="form-group">
					<label for="dateConcession">Date d'engagement</label>
						<input type="text" class="infoConcessions" name="date_engagement" id="C_Date_Engagement" value="<?php echo $row['date_engagement']; ?>" onblur="calculRenouvellement()">
			   </div>
				 <div class="form-group">
					<label for="date">Date de fin de concession
						<input type="text" class="infoConcessions" name="dateFin" id="dateFin" value="<?php echo $row['date_fin']; ?>">
				 	</label>
			   </div>
			   <div class="form-group">
					<label for="Penterrees">Personnes enterrées</label>
						<textarea class="infoConcessions" name="personnes_enterrees" rows="5" cols="33" value="<?php echo $row['personnes_enterrees']; ?>"></textarea>
			   </div>
				 <div class="form-group">
					<label for="typeConcession">Type de concession</label>
						<select class="infoConcessions" name="typeConcession" id="typeConcession" value="<?php echo $row['type_concession']; ?>">
						 <option value="simple">Simple</option>
						 <option value="double">Double</option>
						 <option value="cavurne">Cavurne</option>
						</select>
			   </div>
				 <div class="form-group">
					<label for="duree">Durée de la concession</label>
						<select type="text" class="infoConcessions" name="C_Duree" id="C_Duree" onblur="calculRenouvellement()" value="<?php echo $row['duree_concession']; ?>">
							 <option value="15ans">15 ans</option>
							<option value="30ans">30 ans</option>
							<option value="50ans">50 ans</option>
							<option value="100ans">100 ans</option>
							<option value="perpetuelle">Perpétuelle</option>
						 </select>
			   </div>
				 <div class="form-group">
					<label for="dateRenew">Date de renouvellement
						<input type="text" class="infoConcessions" name="C_Renew" id="C_Renew" value="<?php echo $row['date_renouvellement']; ?>">
					</label>
			   </div>
				 <div class="form-group">
					<label for="prix">Prix
						<input type="text" class="infoConcessions" name="prixConcession" id="prixConcession" onblur="calculPrix()" value="<?php echo $row['prix_concession']; ?>">
				 </label>
			   </div>
				 <div class="form-group">
					<label for="surface">Surface en m²
						<input type="text" class="infoConcessions" name="surface" value="<?php echo $row['surface']; ?>">
				 </label>
			   </div>
				 <div class="form-group">
					<label for="nb_place">Nombre de place
						<input type="text" class="infoConcessions" name="nb_place" value="<?php echo $row['nb_place']; ?>">
				 </label>
				 <div class="form-group">
					<label for="observations">Observations</label>
						<textarea class="infoConcessions" name="observations" rows="5" cols="33" value="<?php echo $row['Observations']; ?>"></textarea>
			   </div>
			   </div>
			     <button type="submit" class="boutonR">Mettre à jour</button>
			</form>

		</div>
		<div  class="container" style="max-width:600px;margin:60px -900px;">
			<form method="POST" action="php/images.php" enctype="multipart/form-data">
				<input type="file" name="photo">
				<input type="submit" name="envoyerImage" value="Ajouter une image">
			</form>
		</div>

		<div  class="container" style="max-width:600px;margin:60px -900px;">
			<form method="POST" action="fichiers.php" enctype="multipart/form-data">
				<input type="file" name="fichiers[]">
				<input type="submit" name="envoyerFichier" value="Ajouter un fichier">
			</form>

			<form method="POST" action="fichiers.php" enctype="multipart/form-data">
				<input type="file" name="fichiers[]">
				<input type="submit" name="envoyerFichier" value="Ajouter un fichier">
			</form>

			<form method="POST" action="fichiers.php" enctype="multipart/form-data">
				<input type="file" name="fichiers[]">
				<input type="submit" name="envoyerFichier" value="Ajouter un fichier">
			</form>
		</div>
		<div class="supprimer_c">
					<a href="#" class="supprimer_c">Supprimer le concessionnaire</a>
		</div>


	<!-- SELECT *
	 FROM `concessionnaire`
	 LEFT JOIN `possede` ON `concessionnaire`.`id_concessionnaire`=`possede`.`id_concessionnaire`
	 LEFT JOIN `concession` ON `possede`.`id_concession`=`concession`.`id_concession`; -->






<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="styles/style.css" type="text/css">
	<link rel="shortcut icon" href="#">
	<script type="text/javascript">
		hs.graphicsDir = 'highslide/graphics/';
		hs.wrapperClassName = 'wide-border';



		// calcul automatique de la date de renouvellement
		function calculRenouvellement() {
					var ConcessionSaisie 		= document.getElementById("C_Date_Engagement").value;
					var AnneeConcessionSaisie 	= Number(ConcessionSaisie.substring(6,10));

					var DureeConcession 			= document.getElementById("C_Duree").value;
					var CalculAnneeRenouvelle 	= 0;

					if (DureeConcession == "15ans") {
						 		CalculAnneeRenouvelle = (AnneeConcessionSaisie + 15);
					}
					if (DureeConcession == "30ans") {
						 		CalculAnneeRenouvelle = (AnneeConcessionSaisie + 30);
					}
					if (DureeConcession == "50ans") {
						 	CalculAnneeRenouvelle = (AnneeConcessionSaisie + 50);
					}
					if (DureeConcession == "100ans") {
								CalculAnneeRenouvelle = (AnneeConcessionSaisie + 100);
					}
					if (DureeConcession == "Perpétuelle") {
						 		CalculAnneeRenouvelle = "";
					}
					if (DureeConcession == "") {
								CalculAnneeRenouvelle = "";
					}
					if (AnneeConcessionSaisie == "") {
							CalculAnneeRenouvelle = "";
					}

				document.getElementById("C_Renew").value = CalculAnneeRenouvelle;
	 }

	 // calcul automatique du prix
	 function calculPrix () {
		var ConcessionSaisie 		= document.getElementById("C_Date_Engagement").value;
		var AnneeConcessionSaisie 	= Number(ConcessionSaisie.substring(6,10));

		var DureeConcession 			= document.getElementById("C_Duree").value;
		var TypeConcession 			= document.getElementById("TypeConcession").value;
		var prix_concession = 0;

		if (AnneeConcessionSaisie > 2001) {
			switch (TypeConcession) {
					case 'simple':
						if (DureeConcession == "15ans") {
							prix_concession = 200,00;
						} else if (DureeConcession == "30ans") {
							prix_concession = 400,00;
						} else {
							prix_concession = 0;
						}
						break;
					case 'double':
						if (DureeConcession == "15ans") {
							prix_concession = 400,00;
						} else if (DureeConcession == "30ans") {
							prix_concession = 800,00;
						} else {
							prix_concession = 0;
						}
						break;
					case 'cavurne':
						if (DureeConcession == "15ans") {
							prix_concession = 300,00;
						} else if (DureeConcession == "30ans") {
							prix_concession = 500,00;
						} else {
							prix_concession = 0;
						}
						break;
					default:
						console.log ("Type de concession incorrecte");
			}

		}
	 }


</script>
</head>

<body>

</body>


</html>









