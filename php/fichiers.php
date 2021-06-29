<?php

include 'connect_pdo.php';
include 'fonctions.php';

define ('MAX_WEIGHT_DOC', 500000);
$file_authorized_upload = array ('pdf', 'txt', 'zip', 'xls', 'xlsx', 'rar', 'tar');
copierFichierUploade ($_FILES['fichiers'], '../documents/', MAX_WEIGHT_DOC, true, $file_authorized_upload);

if (isset($_POST['fichiers'])) {
	$sql = ("insert into concession (acte_concession) values ('{$_POST['fichiers']}')");
	$bdd = exec($sql);
} else {
	echo "Veuillez ajouter un fichier";
}
