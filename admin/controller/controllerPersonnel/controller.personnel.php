<?php 
	if (isset($_POST['connexionPerso'])) {
		include '../../config/connex.php';
		include '../../modele/personnel/modele.personnel.php';
		$modelePerso = new Personnel();
		$pseudo = $_POST['pseudo'];
		$mdp = $_POST['mdp'];

		if (empty($pseudo) || empty($mdp)) {
			echo "Remplissez les données";
		}else{
			$donne = $modelePerso->GetPersonneBySomething('login',$pseudo);
				if ($donne) {
					if ($donne['mdp']==md5($mdp)) {
						session_start();
						$modelePerso->ChangeStatusConnexion($donne['idPerso'],"ok");
						$_SESSION['idAdmin'] = $donne['idPerso'];
						echo "OK";
					}	
					else{
						echo "Mot de passe incorrecte";
					}
				}else{
					echo "Login introuvable";
				}

		}
	}

	if (isset($_POST['new_mdpbtn'])) {
		include '../../modele/personnel/modele.personnel.php';
		include '../../config/connex.php';
		$modele = new Personnel();

	 	$idAdmin = $_POST['idPerso'];
	 	$old_mdp = $_POST['old_mdp'];
	 	$new_mdp1 = $_POST['new_mdp1'];
	 	$new_mdp2 = $_POST['new_mdp2'];


	 	$val = $modele->GetPersonneBySomething('idPerso',$idAdmin);

	 	if (empty($new_mdp1) || empty($new_mdp2)) {
	 		echo "Entrer le nouveau mot de passe, puis conformer";	
	 	}else{
			if ($new_mdp1==$new_mdp2) {
				if ($val['mdp']==md5($old_mdp)) {
		 			$modele->UpdateaAdminMdp($idAdmin,md5($new_mdp2));
		 			echo "OK";
		 		}else{
		 			echo "Ancien mot de passe incorrecte";
		 		}	
			}else{
				echo "Les deux mot de passe incorrecte";
			}
		}
	}


	if (isset($_POST['deconnexion'])) {
		include '../../modele/personnel/modele.personnel.php';
		include '../../config/connex.php';
		$modele = new Personnel();
		session_start();
		$idAdmin = $_SESSION['idAdmin'];
		$modele->ChangeStatusConnexion($idAdmin,"ko");
		session_unset();
		session_destroy();
		echo "ok";
	}






 ?>