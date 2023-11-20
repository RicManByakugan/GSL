<?php 
	if (isset($_SESSION['idAdmin'])) {
		require_once('admin/view/accueil.php');
	}else{
		require_once('admin/view/login.php');
	}
 ?>