<?php 
	
	if (isset($_POST['getProDetaille']) && !empty($_POST['getProDetaille'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			include '../../modele/personnel/modele.personnel.php';
			$modele = new Produit();
			$modelePerso = new Personnel();
			$donne = $modele->GetAllProductId($_POST['getProDetaille']);
			if ($donne) {
				$somme = $donne['PrixProduit']*$donne['NombreProduit'];
				echo "
					<div class='row'>
						<div class='col-sm-12'>
							<h3>".$donne['NameProduit']."</h3>
		                    <b>Prix unitaire : ".number_format($donne['PrixProduit'])." Ar</b>
							<hr>
		                    <small>
				                    Nombre : ".number_format($donne['NombreProduit'])."
				                    <br>
				                    Total : ".number_format($somme)." Ar
		                    </small>
						</div>
					</div>
				";
			}else{
				echo "Produit n'existe plus";
			}
		}
	}

	if (isset($_POST['updateQtPan']) && !empty($_POST['updateQtPan'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new Produit();
			$res = $modele->UpdateQtPanier($_POST['updateQtPan'],$_POST['valeur']);
			echo $res;
		}
	}

	if (isset($_POST['delQtPan']) && !empty($_POST['delQtPan'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new Produit();
			$res = $modele->DeletePanier($_POST['delQtPan']);
			echo $res;
		}
	}



	if (isset($_POST['videPan']) && !empty($_POST['videPan'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new Produit();
			$res = $modele->VidePanier();
			echo $res;
		}
	}


	if (isset($_POST['listeSolde']) && !empty($_POST['listeSolde'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new Produit();
			$solde = $modele->GetSoldeAct();
			if ($solde) {
				echo "
					<h6 data-target='#AddEspece' data-toggle='modal'>Espece : ".number_format($solde['Espece'])."Ar</h6>
		            <h6>Solde Stock : ".number_format($solde['Stock'])."Ar</h6>
				";
			}
		}
	}


	if (isset($_POST['addEspece']) && !empty($_POST['addEspece'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new Produit();
			$res = $modele->AddSolde($_POST['addEspece']);
			if ($res == "ok") {
				$activite = $modele->AddActivite($_SESSION['idPerso'],"AJOUT",$_POST['motifADD']);
				if ($activite == "ok") {
					echo "ok";
				}else{
					echo "Erreur de l'action";
				}
			}else{
				echo $res;
			}
		}
	}

	if (isset($_POST['subEspece']) && !empty($_POST['subEspece'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new Produit();
			$res = $modele->SubSolde($_POST['subEspece']);
			if ($res == "ok") {
				$activite = $modele->AddActivite($_SESSION['idPerso'],"RETIRE",$_POST['motifADDSub']);
				if ($activite == "ok") {
					echo "ok";
				}else{
					echo "Erreur de l'action";
				}
			}else{
				echo $res;
			}
		}
	}


	if (isset($_POST['listePanier']) && !empty($_POST['listePanier'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new Produit();
			$donne = $modele->GetPanier();
			if ($donne) {
				$prAff = "";
				$sommeAmbony = 0;
				foreach ($donne as $key => $value) {
					$sommeT = $value['Quantite']*$value['PrixProduit'];
					$sommeAmbony += $sommeT;
					$prAff = $prAff."
						<tr>
		                    <td>".$value['NameProduit']."</td>
		                    <td>".number_format($value['PrixProduit'])."Ar</td>
		                    <td><input type='number' value='".$value['Quantite']."' class='form-quantite text-center' min='0' max='10' onchange=\"UpdateQuantitePan(".$value['idVent'].",this.value)\"></td>
		                    <td>".number_format($sommeT)." Ar</td>
		                    <td>
		                        <button class='btn btn-light' onclick='DelPanier(".$value['idVent'].")'><i class='fa fa-trash'></i></button>
		                    </td>
	                  	</tr>
					";
				}
				echo "
					<div class='row'>
		              <div class='col-sm-6 text-center'>
		                <h3><u>Total : ".number_format($sommeAmbony)."Ar</u></h3>
		              </div>
		              <div class='col-sm-6 text-center'>
		                <button class='btn btn-success' onclick='ValiderPanier()'><i class='fa fa-check'></i> Valider</button>
		                <button class='btn btn-danger' onclick='VidePanier()'><i class='fa fa-times'></i> Annuler</button>
		              </div>
		            </div>
		            <hr>
		            <div class='table-responsive'>
		              <table class='table'>
		                <thead class='bg-light'>
		                  <tr>
		                    <th>Nom Produit</th>
		                    <th>Prix unitaire</th>
		                    <th>Quantite</th>
		                    <th>Total</th>
		                    <th></th>
		                  </tr>
		                </thead>
		                <tbody>".$prAff."</tbody>
		              </table>
		            </div>
				";
			}else{
				echo "
					<div class='row'>
		              <div class='col-sm-6 text-center'>
		                <h3><u>Total : 0Ar</u></h3>
		              </div>
		              <div class='col-sm-6 text-center'>
		                <button class='btn btn-success' disabled><i class='fa fa-check'></i> Valider</button>
		                <button class='btn btn-danger' disabled><i class='fa fa-times'></i> Annuler</button>
		              </div>
		            </div>
		            <hr>
		            <div class='table-responsive'>
		              <table class='table'>
		                <thead class='bg-light'>
		                  <tr>
		                    <th>Nom Produit</th>
		                    <th>Prix unitaire</th>
		                    <th>Quantite</th>
		                    <th>Total</th>
		                    <th></th>
		                  </tr>
		                </thead>
		              </table>
		            </div>
				";
			}
		}
	}


	if (isset($_POST['validePanier']) && !empty($_POST['validePanier'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new Produit();
			$numVente = rand(0,100000);
			$testTest = $modele->TestIC($numVente);
			$donne = $modele->GetPanier();
			$Description = "Nouvelle vente";
			if ($donne) {
				if ($testTest) {
					$numVenteI = rand(0,100000).rand(0,100000);
					$sommeAmbony = 0;
					foreach ($donne as $key => $valueI) {
						$modele->AddVenteFaite($numVenteI,$_SESSION['idPerso'],$valueI['idProduitVent'],$valueI['Quantite']);
						$activiteStockEspece = $modele->ActiviteGSL($valueI['idProduitVent'],$valueI['Quantite']);
						$sommeT = $valueI['Quantite']*$valueI['PrixProduit'];
						$sommeAmbony += $sommeT;
					}
					$donneSolde = $modele->GetSoldeAct();
					$modele->AddSolde($sommeAmbony);
					$modele->AddActiviteVenteFaite($_SESSION['idPerso'],$numVenteI,$Description,$donneSolde['Stock'],$donneSolde['Espece']);
				}else{
					$sommeAmbony = 0;
					foreach ($donne as $key => $value) {
						$modele->AddVenteFaite($numVente,$_SESSION['idPerso'],$value['idProduitVent'],$value['Quantite']);
						$activiteStockEspece = $modele->ActiviteGSL($value['idProduitVent'],$value['Quantite']);
						$sommeT = $value['Quantite']*$value['PrixProduit'];
						$sommeAmbony += $sommeT;
					}
					$donneSolde = $modele->GetSoldeAct();
					$modele->AddSolde($sommeAmbony);
					$modele->AddActiviteVenteFaite($_SESSION['idPerso'],$numVente,$Description,$donneSolde['Stock'],$donneSolde['Espece']);
				}

				$modele->VidePanier();
				echo "ok";
			}else{
				echo "Erreur";
			}
		}
	}


	if (isset($_POST['addProductPan']) && !empty($_POST['addProductPan'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new Produit();
			$donne = $modele->GetAllProductId($_POST['addProductPan']);
			if ($donne) {
				$res = $modele->AddProductPan($_POST['addProductPan']);
				echo $res;
			}
		}
	}

	if (isset($_POST['getModalVente']) && !empty($_POST['getModalVente'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new Produit();
			$donne = $modele->GetActiviteVenteDetaille($_POST['getModalVente']);
			if ($donne) {
				$sommeTA = 0;
				$personnel = 0;
				$resListe = "";
				foreach ($donne as $key => $value) {
					$sommeTA += ($value['PrixProduit']*$value['QtV']);
					$sommeTotal = $value['PrixProduit']*$value['QtV'];
					$personnel = $value['idComs'];
					$resListe = $resListe."
						<tr>
			              <td>".$value['NameProduit']."</td>
			              <td>".$value['PrixProduit']."</td>
			              <td>".$value['QtV']."</td>
			              <td>".number_format($sommeTotal)."</td>
			            </tr>
					";
				}
				$personnelA = $modele->GetPersonnel($personnel);
				if ($personnelA) {
					echo "
						<div class='row'>
				          <div class='col-sm-6 text-left'>
				            <h6>Numéro de commande : ".$_POST['getModalVente']."</h6>
				          </div>
				          <div class='col-sm-6 text-right'>
				            <h6>".$personnelA['nom']." ".$personnelA['prenom']."</h6>
				          </div>
				        </div>
				        <hr>
				        <div class='row'>
				          <div class='col-sm-4'>
				            <h4>
				              <img src='data/money.jpg' width='30' height='25'>
				              ".number_format($sommeTA)."Ar
				            </h4>
				          </div>
				        </div><hr>
				        <table class='table'>
				          <thead class='bg-light'>
				            <tr>
				              <th>Produit</th>
				              <th>Prix</th>
				              <th>Nombre</th>
				              <th>Total</th>
				            </tr>
				          </thead>
				          <tbody>".$resListe."</tbody>
				        </table>
					";
				}
			}
		}
	}


	if (isset($_POST['activiteVente']) && !empty($_POST['activiteVente'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new Produit();
			$donne = $modele->GetActiviteVente();
			if ($donne) {
				foreach ($donne as $key => $value) {
					echo "
						<tr data-toggle='modal' data-target='#ModalVenteProduct' onclick=\"ModalVente('".$value['IdVenteAct']."')\">
		                    <td>".$value['dateActC']."</td>
		                    <td>".$value['heureActC']."</td>
		                    <td>".$value['prenom']."</td>
		                    <td>".$value['Description']."</td>
		                    <td>".$value['Stock']."</td>
		                    <td>".$value['Espece']."</td>
	                  	</tr>
					";
				}
			}
		}
	}

	if (isset($_POST['activiteSolde2']) && !empty($_POST['activiteSolde2'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			include '../../modele/personnel/modele.personnel.php';
			$modele = new Produit();
			$modelePerso = new Personnel();
			$donne = $modele->GetActiviteProduct();
			if ($donne) {
				foreach ($donne as $key => $value) {
					list($h,$m,$s) = explode(":", $value['heureACP']);
					echo "
			            <tr>
		                    <td>".$value['dateACP']."</td>
		                    <td>".$value['heureACP']."</td>
		                    <td>".nl2br($value['descAP'])."</td>
		                    <td>".number_format($value['SoldeT'])."Ar</td>
	                  	</tr>
					";	
				}
			}
		}

	}
	if (isset($_POST['activiteSolde']) && !empty($_POST['activiteSolde'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new Produit();
			$donne = $modele->GetActiviteSolde();
			if ($donne) {
				foreach ($donne as $key => $value) {
					echo "
						<tr>
		                    <td>".$value['dateActSolde']."</td>
		                    <td>".$value['heureActSolde']."</td>
		                    <td>".$value['prenom']."</td>
		                    <td>".$value['titreComs']."<br>".$value['descriptionActSolde']."</td>
		                    <td>".$value['NewEspece']."</td>
	                  	</tr>
					";
				}
			}
		}

	}


	if (isset($_POST['getVendreProduct']) && !empty($_POST['getVendreProduct'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new Produit();
			$donne = $modele->GetAllProduct();
			if ($donne) {
				foreach ($donne as $key => $value) {
					echo "
						<div class='mb-3 col-sm-4'>
			                <div class='small-box bg-info'>
			                  <div class='inner' onclick=\"ModalDetailleProductGet(".$value['idProduit'].")\" data-target=\"#ModalDetailleProduct\" data-toggle=\"modal\">
			                    <h3>".$value['NombreProduit']."</h3>
			                    <p>".$value['NameProduit']."</p>
			                  </div>
		                      <a class='small-box-footer' onclick=\"AddProductToVent(".$value['idProduit'].")\">Ajoutez <i class='fas fa-arrow-circle-right'></i></a>
			                </div>
		              	</div>
					";
				}
			}
		}
	}

	if (isset($_POST['getStockageProduct']) && !empty($_POST['getStockageProduct'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new Produit();
			$donne = $modele->GetAllProduct();
			if ($donne) {
				foreach ($donne as $key => $value) {
					echo "
						<div class='mb-3 col-sm-3' onclick=\"ModalDetailleProductGet(".$value['idProduit'].")\" data-target=\"#ModalDetailleProduct\" data-toggle=\"modal\">
			                <div class='small-box bg-info'>
			                  <div class='inner'>
			                    <h3>".$value['NombreProduit']."</h3>
			                    <p>".$value['NameProduit']."</p>
			                  </div>
			                </div>
		              	</div>
					";
				}
			}
		}
	}

	if (isset($_POST['getStockageProductSearch']) && !empty($_POST['getStockageProductSearch'])) {
		session_start();
		if (isset($_SESSION['idPerso'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new Produit();
			$donne = $modele->GetAllProductSearch($_POST['getStockageProductSearch']);
			if ($donne) {
				foreach ($donne as $key => $value) {
					echo "
						<div class='mb-3 col-sm-3'>
			                <div class='small-box bg-info'>
			                  <div class='inner' onclick=\"ModalDetailleProductGet(".$value['idProduit'].")\" data-target=\"#ModalDetailleProduct\" data-toggle=\"modal\">
			                    <h3>".$value['NombreProduit']."</h3>
			                    <p>".$value['NameProduit']."</p>
			                  </div>
			                  <a class='small-box-footer' onclick=\"AddProductToVent(".$value['idProduit'].")\">Ajoutez <i class='fas fa-arrow-circle-right'></i></a>
			                </div>
		              	</div>
					";
				}
			}
		}
	}





 ?>