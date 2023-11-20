<?php 


	/**
	 * 
	 */
	class ProduitAdmin
	{
		
		private $bdd;
	
		function __construct()
		{
			$co = new Connexion();
			$this->bdd = $co->connectBD();
		}

		public function AddProduct($nom,$prix,$nombre,$admin)
		{
			$ver = $this->GetProduct($nom);
			if ($ver) {
				return "ko";
			}else{
				$sql = "INSERT INTO produit(NameProduit,PrixProduit,NombreProduit,Admin,DateProduit,HeureProduit) VALUES('$nom','$prix','$nombre',$admin,NOW(),NOW())";
				$this->bdd->exec($sql);

				$idProduct = $this->GetMaxProduct();
				$sommeS = $this->GetSommeAllProduct();
				$sqlActivite = "INSERT INTO productactivite(idProduitA,idPerso,descAP,SoldeT,dateACP,heureACP) VALUES($idProduct,$admin,'AJOUT DE NOUVEAU PRODUIT',$sommeS,NOW(),NOW())";
				$this->bdd->exec($sqlActivite);
				
				$this->UpdateSoldeStock();

				return "ok";
			}
		}

		public function GetSoldeAct()
		{
			$sql = "SELECT * FROM solde WHERE idSolde=1";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetch();
		}

		public function AddSolde($valeur)
		{
			if ($valeur > 0) {
				$lastSolde = $this->GetSoldeAct();
				$sommeupdate = $lastSolde['Espece'] + $valeur;
				$sql = "UPDATE solde SET Espece='$sommeupdate' WHERE idSolde=1";
				$this->bdd->exec($sql);
				return "ok";
			}else{
				return "Valeur inférieure à 0";
			}
		}

		public function AddActivite($admin,$titre,$motif)
		{
			$NewSolde = $this->GetSoldeAct();
			$espece = $NewSolde['Espece'];

			$sql = "INSERT INTO activitesolde(coms,titreComs,descriptionActSolde,NewEspece,dateActSolde,heureActSolde) VALUES($admin,'$titre','$motif',$espece,NOW(),NOW())";
			$this->bdd->exec($sql);
			return "ok";
		}

		public function SubSolde($valeur)
		{
			if ($valeur > 0) {
				$lastSolde = $this->GetSoldeAct();
				$sommeupdate = $lastSolde['Espece'] - $valeur;
				if ($sommeupdate >= 0) {
					$sql = "UPDATE solde SET Espece='$sommeupdate' WHERE idSolde=1";
					$this->bdd->exec($sql);
					return "ok";
				}else{
					return "Espece insuffisant";
				}
			}else{
				return "Valeur inférieure à 0";
			}
		}


		public function UpdateSoldeStock()
		{
			$sommeS = $this->GetSommeAllProduct();
			$sql = "UPDATE solde SET Stock=$sommeS WHERE idSolde=1";
			$this->bdd->exec($sql);
		}

		public function GetActiviteProduct()
		{
			$sql = "SELECT * FROM productactivite ORDER BY idProductAct DESC";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetchall();
		}

		public function GetPersonnel($perso)
		{
			$sql = "SELECT * FROM personnel WHERE idPerso=$perso";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetch();
		}

		public function GetActiviteVenteDetaille($vente)
		{
			$sql = "SELECT * FROM ventfaite INNER JOIN produit ON ventfaite.idProduitV=produit.idProduit WHERE ventfaite.numVente='$vente'";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetchall();
		}

		public function GetActiviteVente()
		{
			$sql = "SELECT * FROM activitecoms INNER JOIN personnel ON activitecoms.idComs=personnel.idPerso ORDER BY activitecoms.idActiviteC DESC";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetchall();
		}

		public function GetRapportToday()
		{
			$today = date("Y-m-d");
			$sql = "SELECT * FROM activitecoms INNER JOIN personnel ON activitecoms.idComs=personnel.idPerso WHERE activitecoms.dateActC='$today' ORDER BY activitecoms.idActiviteC DESC";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetchall();
		}

		public function GetActiviteSolde()
		{
			$sql = "SELECT * FROM activitesolde INNER JOIN personnel ON activitesolde.coms=personnel.idPerso ORDER BY activitesolde.idActSolde DESC";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetchall();
		}

		public function GetActiviteSoldeToday()
		{
			$today = date("Y-m-d");
			$sql = "SELECT * FROM activitesolde INNER JOIN personnel ON activitesolde.coms=personnel.idPerso WHERE activitesolde.dateActSolde='$today' ORDER BY activitesolde.idActSolde DESC";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetchall();
		}

		public function DelProduct($product){
			$Produitt = $this->GetAllProductId($product);
			$admin = $Produitt['Admin'];
			$historyOld = "
				Ancien nom  de produit : ".$Produitt['NameProduit']."
				Ancien nombre  de produit : ".$Produitt['NombreProduit']."
				Ancien prix  de produit : ".$Produitt['PrixProduit']."
			";

			$sqlDel = "DELETE FROM produit WHERE idProduit='$product'";
			$this->bdd->exec($sqlDel);

			$text = "SUPPRESSION DE PRODUIT".$historyOld;

			$sommeS = $this->GetSommeAllProduct();
			$sqlActivite = "INSERT INTO productactivite(idProduitA,idPerso,descAP,SoldeT,dateACP,heureACP) VALUES($product,$admin,'$text',$sommeS,NOW(),NOW())";
			$this->bdd->exec($sqlActivite);

			$this->UpdateSoldeStock();

			return "ok";
		}
		public function UpdateProduct($product,$name,$nombre,$price)
		{
			$ProduitOld = $this->GetAllProductId($product);
			$admin = $ProduitOld['Admin'];
			$historyOld = "
				Ancien nom  de produit : ".$ProduitOld['NameProduit']."
				Ancien nombre  de produit : ".$ProduitOld['NombreProduit']."
				Ancien prix  de produit : ".$ProduitOld['PrixProduit']."
			";

			if ($name!="" || $name!=NULL) {
				$sql = "UPDATE produit SET NameProduit='$name' WHERE idProduit='$product'";
				$this->bdd->exec($sql);
			}
			if ($nombre!="" || $nombre!=NULL) {
				$sql = "UPDATE produit SET NombreProduit='$nombre' WHERE idProduit='$product'";
				$this->bdd->exec($sql);
			}
			if ($price!="" || $price!=NULL) {
				$sql = "UPDATE produit SET PrixProduit='$price' WHERE idProduit='$product'";
				$this->bdd->exec($sql);
			}

			$sommeS = $this->GetSommeAllProduct();
			$ProduitNew = $this->GetAllProductId($product);
			$historyNew = "
				Nouveu nom  de produit : ".$ProduitNew['NameProduit']."
				Nouveu nombre  de produit : ".$ProduitNew['NombreProduit']."
				Nouveu prix  de produit : ".$ProduitNew['PrixProduit']."
			";

			$text = "MODIFICATION DE PRODUIT".$historyOld.$historyNew;

			$sqlActivite = "INSERT INTO productactivite(idProduitA,idPerso,descAP,SoldeT,dateACP,heureACP) VALUES($product,$admin,'$text',$sommeS,NOW(),NOW())";
			$this->bdd->exec($sqlActivite);

			$this->UpdateSoldeStock();

			return "ok";
		}

		public function GetSommeAllProduct()
		{
			$donneP = $this->GetAllProduct();
			$somme = 0;
			if ($donneP) {
				foreach ($donneP as $key => $value) {
					$somme += ($value['PrixProduit']*$value['NombreProduit']);
				}
			}
			return $somme;
		}

		public function GetProduct($valeur)
		{
			$sql = "SELECT * FROM produit WHERE NameProduit LIKE '%$valeur%'";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetchall();
		}

		public function GetMaxProduct()
		{
			$sql = "SELECT MAX(idProduit) AS maximumId FROM produit";
			$recup = $this->bdd->query($sql);
			$donne = $recup->fetch();
			return $donne['maximumId'];
		}

		public function GetAllProductPDF()
		{
			$sql = "SELECT * FROM produit WHERE NombreProduit > 0 ORDER BY idProduit DESC";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetchall();
		}
		
		public function GetAllProduct()
		{
			$sql = "SELECT * FROM produit ORDER BY idProduit DESC";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetchall();
		}
		public function GetAllProductSearch($search)
		{
			$sql = "SELECT * FROM produit WHERE NameProduit LIKE '%$search%'";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetchall();
		}
		
		public function GetAllProductId($id)
		{
			$sql = "SELECT * FROM produit WHERE idProduit=$id";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetch();
		}

	}










 ?>