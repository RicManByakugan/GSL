<?php 
	include 'admin/modele/personnel/modele.personnel.php';
	
	$modelePerso = new Personnel();

	if (isset($_SESSION['idAdmin'])) {
		$idAdmin = $_SESSION['idAdmin'];
		$user = $modelePerso->GetPersonneBySomething('idPerso',$idAdmin);
		if ($user['image']==NULL || $user['image']=="") {
			$img = "data/user/profile.png";
		}else{
			$img = "data/user/".$user['imageA'];
		}
		require_once('admin/view/accueil.php');
	}else{
		require_once('admin/view/login.php');
	}
 ?>