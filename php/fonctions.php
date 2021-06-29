<?php


	/**
	 * @access public
	 * @param string $str_data
	 * @param boolean $bool_display
	 * @return void
	 */

	function debug($str_data, $bool_display = true, $bool_backtrace = true) {
			if ($bool_display){
				echo '<pre>';
				print_r($str_data);
				if ($bool_backtrace){ $debug_backtrace = debug_backtrace();
					print('<br /><small style="color: #999; font-style: italic; font-size: 10px;">'.$debug_backtrace[0]['file'].' - line '.$debug_backtrace[0]['line'].'</small>');
				}
				echo '</pre>';
			} elseif ($fp=fopen(ROOT_DIR . '/logs/misc_' . date('Ymd') . '.log', 'a')){
				if ($bool_backtrace){
					$debug_backtrace = debug_backtrace();
					$debugBT = ' - '.$debug_backtrace[0]['file'].' - line '.$debug_backtrace[0]['line'];
				} else
					$debugBT = '';
				fputs($fp, date('H:i:s'). $debugBT. "\n" . var_export($str_data, true) . "\n-------------------------------\n") ;
				fclose($fp);
			}
	}


/**
	 * @access public
	 * @param string $str_string
	 * @return string
	 */

function cleanString($str_string, $bool_keepInnerSpace = false) {
	// on commence par supprimer les espaces à gauche et à droite
	$string = trim($str_string);
	// nettoyage des caractères accentués et divers
	$searches = array() ;
	$searches[] = array('à', 'â', 'ä', 'ã', 'á', 'å', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å') ;
	$searches[] = array('æ', 'Æ') ;
	$searches[] = array('ç', 'Ç') ;
	$searches[] = array('é', 'è', 'ê', 'ë', 'É', 'È', 'Ê', 'Ë') ;
	$searches[] = array('î', 'ï', 'ì', 'í', 'Ì', 'Í', 'Î', 'Ï') ;
	$searches[] = array('ñ', 'Ñ') ;
	$searches[] = array('ô', 'ö', 'ð', 'ò', 'ó', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö') ;
	$searches[] = array('?', '?') ;
	$searches[] = array('ù', 'ú', 'û', 'ü', 'Ù', 'Ú', 'Û', 'Ü') ;
	$searches[] = array('ý', 'ÿ', 'Ý', '?') ;
	$searches[] = array("'", '"', '&', '#', ':', ',', ';', '!', '?'/*, '.'*/, '/', '§', '$', '¤', '£', '^', '¨', '%', '*', 'µ', '+', '*', '{', '(', '[', '|', '\\', '^', '@', ')', ']', '°', '}', '=', '<', '>', '`', '«', '»') ;
	$searches[] = array("\r", "\n") ;
	//$searches[] = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9') ;
	//if ($notiret)
	//  $searches[] = '-' ;

	$replaces = array() ;
	$replaces[] = 'a';
	$replaces[] = 'ae';
	$replaces[] = 'c';
	$replaces[] = 'e';
	$replaces[] = 'i';
	$replaces[] = 'n';
	$replaces[] = 'o';
	$replaces[] = 'oe';
	$replaces[] = 'u';
	$replaces[] = 'y';
	$replaces[] = ' ' ;
	$replaces[] = ' ' ;
	//$replaces[] = '' ;
	//if ($notiret)
	//  $replaces[] = '' ;

	for($i=0; $i<count($replaces); $i++)
		$string = str_replace($searches[$i], $replaces[$i], $string) ;

	$string = trim($string);
	if (!$bool_keepInnerSpace) // on vire tous les espaces qui se suivent
		$string = preg_replace("/([[:space:]])+/", '-', $string) ;
	return $string ;
}

/**
	 * retourne false en cas d'échec, un objet Fichier en cas de succès
* @access public
	 * @param array $arr_infosFichier
	 * @param string $str_dirPath
	 * @param int $int_poidsMax
	 * @param boolean $bool_overwrite
	 * @return mixed
	 */

function copierFichierUploade($arr_infosFichier, $str_dirPath, $int_poidsMax, $bool_overwrite, $file_authorized_upload) {
	$file_authorized_upload = array ('pdf', 'txt', 'zip', 'xls', 'xlsx', 'rar', 'tar', 'jpg', 'jpeg', 'png', 'gif') ; // tableau des extensions autorisées
	$name = $arr_infosFichier['name'] ;
	$type = $arr_infosFichier['type'] ;
	$tmp_name = $arr_infosFichier['tmp_name'] ;
	$error = $arr_infosFichier['error'] ;
	$size = $arr_infosFichier['size'] ;

	if ($error == 4)
		return ('Aucun fichier n\'a été téléchargé.') ;

	if ($error || ($int_poidsMax &&  $int_poidsMax < $size))
		return ("Erreur $error | Problème de poids");

	$fileExtension = strtolower(pathinfo($name, PATHINFO_EXTENSION)) ;

	if (!in_array($fileExtension, $file_authorized_upload))
		return ("Extension non autorisée") ;

	$cleanFileName = substr(Misc::cleanString(substr($name, 0, 0-strlen($fileExtension))), 0, 93-strlen($fileExtension)) /*. '.'*/ . $fileExtension ;

	//if (file_exists(ROOT_DIR . $str_dirPath . $cleanFileName)){
		// on regarde si on doit écraser ou renommer
		if (!$bool_overwrite){ // on renomme
			$tmp_fileName = substr(strrchr($tmp_name, '/'), 1) ;//substr(md5('siHmdY'), 0, 5);//substr(strrchr($tmp_name, '/'), 1) ;
			if (strlen( $cleanFileName ) > 99 - strlen( $tmp_fileName ))
				$cleanFileName = $tmp_fileName . '_' . substr($cleanFileName, -(99 - strlen( $tmp_fileName ))) ;
			else
				$cleanFileName = $tmp_fileName . '_' . $cleanFileName ;
		} /*else { // on écrase
			// on fait une petite sauvegarde au cas où
			rename( ROOT_DIR . $str_dirPath . $cleanFileName, ROOT_DIR . $str_dirPath . $cleanFileName . '.old' ) ;
		}
	}*/

	if (! move_uploaded_file($tmp_name, $str_dirPath . $cleanFileName))
		return ("Impossible de copier le fichier");
	@chmod($str_dirPath . $cleanFileName, octdec('0777'));

	$arr_fichier = [$cleanFileName, $str_dirPath, strtolower(pathinfo($cleanFileName, PATHINFO_EXTENSION)), $size];

	return $arr_fichier ;
}