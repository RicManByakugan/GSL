<?php 
	session_start();
	try{
		if (isset($_SESSION['idAdmin'])) {
			require_once('admin/controller/controller.accueil.php');
		}else{
			require_once('admin/controller/controller.login.php');
		}
	}catch(Exception $e){
		require_once('admin/view/404.php');
	}
 ?>