<?php

// define ('MAX_WEIGHT_IMG', 500000);

$target_dir = "../photos/";
$target_file = $target_dir . basename($_FILES["photo"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 include 'connect_pdo.php';

 $result = $bdd -> query ("select nom_concessionnaire, id_concession from concessionnaire, concession WHERE id_concession = id_concessionnaire");

		while ($row = $result -> fetch (PDO::FETCH_ASSOC)) {
			$nom_concessionnaire = $row['nom_concessionnaire'];
			$id_concession = $row['id_concession'];
			$nomSansEspace = preg_replace( "# #", "_", $nom_concessionnaire);

			$nouvelle_image = $nomSansEspace . "_" . $id_concession . "." . $imageFileType ;

		}



// include 'fonctions.php';

// $file_authorized_upload = array ('jpg', 'jpeg', 'png', 'gif');

// copierFichierUploade ('photo', '../photos/', MAX_WEIGHT_IMG, true, $file_authorized_upload);

// if (isset($_POST['envoyerFichier'])) {
// 	$sql = ("insert into concession (acte_concession) values ('{$_POST['photo']}')");
// 	$bdd = exec($sql);
// } else {
// 	echo "Veuillez ajouter une image";
// }




// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["photo"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Le fichier existe déjà.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["photo"]["size"] > 500000) {
  echo "Le fichier est trop gros.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Seules les extensions suivantes sont autorisées: JPG, JPEG, PNG & GIF.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Le fichier n'a pas été chargé.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
		$sql = ("insert into concession (photo) values ('{$nouvelle_image}')");
	 	$bdd = exec($sql);
    echo "Le fichier ". htmlspecialchars( basename( $_FILES["photo"]["name"])). " a été chargé.";
  } else {
    echo "Erreur de chargement du fichier.";
  }
}