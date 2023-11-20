<?php 
	/**
	 * 
	 */
	class Personnel
	{
		private $bdd;
	
		function __construct()
		{
			$co = new Connexion();
			$this->bdd = $co->connectBD();
		}

		public function GetPersonneBySomething($champs,$valeur)
		{
			$sql = "SELECT * FROM personnel WHERE $champs='$valeur' AND post='ADMIN'";
			$recup = $this->bdd->query($sql);
			if ($recup==true) {
				return $donne = $recup->fetch();
			}
		}
		public function ChangeStatusConnexion($idPerso,$value)
		{
			$now = time();
			if ($value == "ok") {
				$sql = "UPDATE personnel SET status='OK' WHERE idPerso='$idPerso' AND post='ADMIN'";
					$this->bdd->exec($sql);
				$sql2 = "UPDATE personnel SET dernierCo='$now' WHERE idPerso='$idPerso' AND post='ADMIN'";
				$this->bdd->exec($sql2);
			}else{
				$sql = "UPDATE personnel SET status='KO' WHERE idPerso='$idPerso' AND post='ADMIN'";
					$this->bdd->exec($sql);
				$sql2 = "UPDATE personnel SET dernierCo='$now' WHERE idPerso='$idPerso' AND post='ADMIN'";
				$this->bdd->exec($sql2);
			}
		}

		public function UpdateaAdminMdp($idPerso,$mdp)
		{
			$sql = "UPDATE personnel SET mdp='$mdp' WHERE idPerso='$idPerso' AND post='ADMIN'";
			$this->bdd->exec($sql);
		}

		



	}


 ?>