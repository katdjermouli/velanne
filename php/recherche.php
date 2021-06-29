
<?php

include 'connect_pdo.php';

/*Récupérer la recherche*/



	// $rechercheProprio = isset($_POST['nomproprio']) ? $_POST['nomproprio'] : '';
	// $rechercheNumero = isset($_POST['numconcession']) ? $_POST['numconcession'] : '';

	$r_proprio = $_POST['nomproprio'];
	$r_numero = $_POST['numconcession'];

	$plusInfo = '<a class="plusInfoTable" href="infoConcession.php">plus d\'info</a>';

	$sqlQuest = [];

	if (isset($r_proprio) && isset($r_numero)) {


			if (!empty($r_proprio)) {
				$sqlQuest [] = "nom_concessionnaire like '%$r_proprio%'";
			}
			if (!empty($r_numero)) {
				$sqlQuest [] = "num_concession like '%$r_numero%'";
			}

			$sql = 'select nom_concessionnaire, num_concession from concessionnaire ';
			if (count($sqlQuest)) {
				$sql .= ' where '.implode (' or ', $sqlQuest);
			}

			$sql .= " limit 10";

			$sql1 = $bdd -> query ($sql);

			$tableau = '<table class="rwd-table">
								<thead>
									<tr>
										<th>nom</th>
										<th>numero</th>
										<th>plus d\'info</th>
									</tr>
								</thead>
								<tbody>';
			while ($row = $sql1 -> fetch (PDO::FETCH_ASSOC)) {
				$nom = $row['nom_concessionnaire'];
				$numero = $row['num_concession'];

				$tableau .= '<tr>
														<td>' . $nom . '</td>
														<td>' . $numero . '</td>
														<td>' . $plusInfo . '</td
											</tr>';
			}
			$tableau .= ' </tbody> </table>  ';
			header('Content-type: text/html');
			exit($tableau);


	} else {
		echo "Veuillez définir un de ces champs !";
	}






	?>



