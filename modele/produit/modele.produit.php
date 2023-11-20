<?php 
	/**
	 * 
	 */
	class Produit
	{
		
		private $bdd;
	
		function __construct()
		{
			$co = new Connexion();
			$this->bdd = $co->connectBD();
		}

		public function AddProductPan($produit)
		{
			$ver = $this->GetAllProductId($produit);
			$verPanier = $this->GetPanierProduit($produit);
			if ($verPanier) {
				return "Déjà dans le panier";
			}else{
				$sommeTotal = $ver['PrixProduit'];
				$sql = "INSERT INTO vendrecoms(idProduitVent,Quantite,TotalVent) VALUES($produit,1,$sommeTotal)";
				$this->bdd->exec($sql);
				return "ok";
			}
		}
		public function AddVenteFaite($num,$admin,$product,$QtV)
		{
			$sql = "INSERT INTO ventfaite(numVente,idComs,idProduitV,QtV,DateVF,heureVF) VALUES('$num',$admin,$product,$QtV,NOW(),NOW())";
			$this->bdd->exec($sql);
			return "ok";
		}
		public function AddActiviteVenteFaite($admin,$IdVenteAct,$Description,$stock,$espece)
		{
			$sql = "INSERT INTO activitecoms(idComs,IdVenteAct,Description,Stock,Espece,dateActC,heureActC) VALUES($admin,$IdVenteAct,'$Description',$stock,$espece,NOW(),NOW())";
			$this->bdd->exec($sql);
			return "ok";
		}
		public function AddActivite($admin,$titre,$motif)
		{
			$NewSolde = $this->GetSoldeAct();
			$espece = $NewSolde['Espece'];

			$sql = "INSERT INTO activitesolde(coms,titreComs,descriptionActSolde,NewEspece,dateActSolde,heureActSolde) VALUES($admin,'$titre','$motif',$espece,NOW(),NOW())";
			$this->bdd->exec($sql);
			return "ok";
		}

		public function ActiviteGSL($product,$quantite)
		{
			$produit = $this->GetAllProductId($product);
			if ($produit) {
				$solde = $this->GetSoldeAct();
				if ($solde) {
					if ($produit['NombreProduit'] >= $quantite) {
						$newQt = $produit['NombreProduit'] - $quantite;
						$this->UpdateQuantiteProduct($produit['idProduit'],$newQt);
						$this->UpdateSoldeStock();
					}
				}
			}
		}

		public function UpdateSoldeStock()
		{
			$sommeS = $this->GetSommeAllProduct();
			$sql = "UPDATE solde SET Stock=$sommeS WHERE idSolde=1";
			$this->bdd->exec($sql);
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

		public function UpdateQuantiteProduct($product,$newQt)
		{
			$sql = "UPDATE produit SET NombreProduit=$newQt WHERE idProduit=$product";
			$this->bdd->exec($sql);
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
		public function TestIC($numVente)
		{
			$sql = "SELECT * FROM ventfaite WHERE numVente=$numVente";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetch();
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

		public function GetActiviteProduct()
		{
			$sql = "SELECT * FROM productactivite ORDER BY idProductAct DESC";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetchall();
		}


		public function GetSoldeAct()
		{
			$sql = "SELECT * FROM solde WHERE idSolde=1";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetch();
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

		public function GetActiviteSolde()
		{
			$sql = "SELECT * FROM activitesolde INNER JOIN personnel ON activitesolde.coms=personnel.idPerso ORDER BY activitesolde.idActSolde";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetchall();
		}

		public function GetAllProduct()
		{
			$sql = "SELECT * FROM produit WHERE NombreProduit > 0 ORDER BY idProduit DESC";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetchall();
		}

		public function GetPanier()
		{
			$sql = "SELECT * FROM vendrecoms INNER JOIN produit ON vendrecoms.idProduitVent=produit.idProduit ORDER BY vendrecoms.idVent DESC";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetchall();
		}

		public function UpdateQtPanier($panier,$quantiteNew)
		{
			$verPanier = $this->GetPanierProduitId($panier);
			if ($verPanier) {
				if ($quantiteNew > 0) {
					$produit = $this->GetAllProductId($verPanier['idProduitVent']);
					if ($produit) {
						if ($produit['NombreProduit'] >= $quantiteNew) {
							$sql = "UPDATE vendrecoms SET Quantite='$quantiteNew' WHERE idVent='$panier'";
							$this->bdd->exec($sql);
							return "ok";
						}else{
							$qthight = $produit['NombreProduit'];
							$sql = "UPDATE vendrecoms SET Quantite='$qthight' WHERE idVent='$panier'";
							$this->bdd->exec($sql);
							return "Nombre inférieure au quantité";
						}
					}else{
						return "Erreur";
					}
				}else{
					return "Quantite incorrecte";
				}
			}else{
				return "Erreur";
			}
		}

		public function VidePanier()
		{
			$sql = "DELETE FROM vendrecoms";
			$this->bdd->exec($sql);
			return 'ok';
		}

		public function DeletePanier($panier)
		{
			$verPanier = $this->GetPanierProduitId($panier);
			if ($verPanier) {
				$sql = "DELETE FROM vendrecoms WHERE idVent='$panier'";
				$this->bdd->exec($sql);
				return "ok";
			}else{
				return "Erreur";
			}
		}	


		public function GetPanierProduitId($panier)
		{
			$sql = "SELECT * FROM vendrecoms WHERE idVent='$panier'";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetch();
		}

		public function GetPanierProduit($product)
		{
			$sql = "SELECT * FROM vendrecoms WHERE idProduitVent='$product'";
			$recup = $this->bdd->query($sql);
			return $donne = $recup->fetch();
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