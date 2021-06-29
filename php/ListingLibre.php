<?php

include 'connect_pdo.php';

$number = 12;

$result = $bdd->query("select nom_concessionnaire, num_concessionnaire from concessionnaire where num_concessionnaire='{$number}'");
$row = $result->fetch (PDO::FETCH_ASSOC);
echo '<table border=2>
				<thead>
					<tr>nom</tr>
					<tr>num</tr>
				</thead>
				<tbody>
					<td>'.$row['nom_concessionnaire'].'</td>
					<td>'.$row['num_concessionnaire'].'</td>
				</tbody>
			</table>';
