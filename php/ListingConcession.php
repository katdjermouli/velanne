<?php

include 'connect_pdo.php';

$sqlQuery = "SELECT * FROM concessionnaire, concession, possede WHERE concessionnaire.id_concessionnaire = possede.id_concessionnaire AND concession.id_concession = possede.id_concession";

$result = $bdd -> query ($sqlQuery);

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

