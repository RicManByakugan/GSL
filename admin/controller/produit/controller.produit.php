<?php 


	if (isset($_POST['getProDetaille']) && !empty($_POST['getProDetaille'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			include '../../modele/personnel/modele.personnel.php';
			$modele = new ProduitAdmin();
			$modelePerso = new Personnel();
			$donne = $modele->GetAllProductId($_POST['getProDetaille']);
			if ($donne) {
				$resPerso = $modelePerso->GetPersonneBySomething('idPerso',$donne['Admin']);
				if ($resPerso) {
					$somme = $donne['PrixProduit']*$donne['NombreProduit'];
					echo "
						<div class='row'>
							<div class='col-sm-12'>
								<h3>".$donne['NameProduit']."</h3>
								<small>Ajouté par ".$resPerso['nom']." ".$resPerso['prenom']."</small>
								<hr>
			                    <p>
				                    <b>
					                    Nombre : ".number_format($donne['NombreProduit'])."
					                    <br>
					                    Prix unitaire : ".number_format($donne['PrixProduit'])." Ar
					                    <br>
					                    Total : ".number_format($somme)." Ar
				                    </b>
			                    </p>
								<hr>
								<div class='row'>
									<div class='col-sm-6'>
										<button class='btn btn-primary btn-block' data-target='#modifDetaille' data-toggle='collapse'>Modifier <i class='fa fa-edit'></i></button>
									</div>
									<div class='col-sm-6'>
										<button class='btn btn-danger btn-block' onclick='DeleteProduct(".$donne['idProduit'].",this)'>Supprimer <i class='fa fa-times'></i></button>
									</div>
								</div>
								<hr>
								<span class='collapse' id='modifDetaille'>
									<div class='row'>
										<div class='col-sm-12'>
											<div class='form-group'>
												<label>Nom du produit</label>
												<input type='text' class='form-control' id='nameModif' value='".$donne['NameProduit']."' />
											</div>
										</div>
									</div>
									<div class='row'>
										<div class='col-sm-6'>
											<div class='form-group'>
												<label>Nombre</label>
												<input type='number' class='form-control' id='nombreModif' value='".$donne['NombreProduit']."' min='0' />
											</div>
										</div>
										<div class='col-sm-6'>
											<div class='form-group'>
												<label>Prix unitaire</label>
												<input type='number' class='form-control' id='prixModif' value='".$donne['PrixProduit']."' min='0' />
											</div>
										</div>
									</div>
									<div class='row'>
										<div class='col-sm-12'>
											<button class='btn btn-block btn-primary' onclick='ModifProduct(".$donne['idProduit'].",this)'>Modifier</button>
										</div>
									</div>
								</span>
							</div>
						</div>
					";
				}else{
					echo "Erreur de l'affichage";
				}
			}else{
				echo "Produit n'existe plus";
			}
		}
	}


	if (isset($_POST['delProduct']) && !empty($_POST['delProduct'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
			$donne = $modele->GetAllProductId($_POST['delProduct']);
			if ($donne) {
				if ($donne && $donne['Admin'] == $_SESSION['idAdmin']) {
					$res = $modele->DelProduct($_POST['delProduct']);
					if ($res == "ok") {
						echo "ok";
					}else{
						echo $res;
						// echo "Erreur de suppression";
					}
				}else{
					echo "Erreur de suppression";
				}
			}else{
				echo "Erreur de suppression";
			}
		}
	}


	if (isset($_POST['modifProduct']) && !empty($_POST['modifProduct'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
			$donne = $modele->GetAllProductId($_POST['modifProduct']);
			if ($donne && $donne['Admin'] == $_SESSION['idAdmin']) {
				$res = $modele->UpdateProduct($_POST['modifProduct'],$_POST['nameModif'],$_POST['nombreModif'],$_POST['prixModif']);
				if ($res == "ok") {
					echo "ok";
				}else{
					echo "Erreur de modification";
				}
			}else{
				echo "Erreur de modification";
			}
		}
	}


	if (isset($_POST['addEspece']) && !empty($_POST['addEspece'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
			$res = $modele->AddSolde($_POST['addEspece']);
			if ($res == "ok") {
				$ss = $_POST['addEspece'];
				$activite = $modele->AddActivite($_SESSION['idAdmin'],"AJOUT $ss Ar",$_POST['motifADD']);
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
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
			$res = $modele->SubSolde($_POST['subEspece']);
			if ($res == "ok") {
				$ss = $_POST['subEspece'];
				$activite = $modele->AddActivite($_SESSION['idAdmin'],"RETIRE $ss Ar",$_POST['motifADDSub']);
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


	if (isset($_POST['getCompta']) && !empty($_POST['getCompta'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
			$donne = $modele->GetAllProduct();
			$sommeFunction = $modele->GetSoldeAct();
			if ($donne) {
				$tableAffiche = "";
				foreach ($donne as $key => $value) {
					$tableAffiche = $tableAffiche."
						<tr onclick=\"ModalDetailleProductGet(".$value['idProduit'].")\" data-target='#ModalDetailleProduct' data-toggle='modal'>
		                    <td>".$value['NameProduit']."</td>
		                    <td>".number_format($value['PrixProduit'])."</td>
		                    <td>".number_format($value['NombreProduit'])."</td>
		                    <th>".number_format($value['PrixProduit']*$value['NombreProduit'])."</th>
	                  	</tr>
					";
				}
				echo "
		            <div class='table-responsive listeSomScroll'>
		              <table class='table table-hover'>
		                <thead class='bg-light'>
		                  <tr>
		                    <th>Nom Produit</th>
		                    <th>Prix unitaire</th>
		                    <th>Nombre</th>
		                    <th>Total</th>
		                  </tr>
		                </thead>
		                <tbody>
	                	  ".$tableAffiche."
		                </tbody>
		              </table>
		            </div>
				";
			}else{
				echo "
					<h5>Somme stock : ".number_format($sommeFunction['Stock'])."Ar</h5>
		            <hr>
		            <div class='table-responsive listeSomScroll'>
		              <table class='table table-hover'>
		                <thead class='bg-light'>
		                  <tr>
		                    <th>Nom Produit</th>
		                    <th>Prix unitaire</th>
		                    <th>Nombre</th>
		                    <th>Total</th>
		                  </tr>
		                </thead>
		              </table>
		            </div>
				";
			}
		}
	}

	if (isset($_POST['getStockageProduct']) && !empty($_POST['getStockageProduct'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
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
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
			$donne = $modele->GetAllProductSearch($_POST['getStockageProductSearch']);
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

	if (isset($_POST['getActProduct']) && !empty($_POST['getActProduct'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			include '../../modele/personnel/modele.personnel.php';
			$modele = new ProduitAdmin();
			$modelePerso = new Personnel();
			$donne = $modele->GetActiviteProduct();
			if ($donne) {
				foreach ($donne as $key => $value) {
					list($h,$m,$s) = explode(":", $value['heureACP']);
					$Admin = $modelePerso->GetPersonneBySomething('idPerso',$value['idPerso']);
					if ($Admin) {
						echo "
							<div class='toast' style='opacity: 2;' onclick=\"ModalDetailleProductGet(".$value['idProduitA'].")\" data-target='#ModalDetailleProduct' data-toggle='modal'>
				              <div class='toast-header'>
				                ".$Admin['nom']." ".$Admin['prenom']."
				              </div>
				              <div class='toast-body'>
				                <div class='p-2'>
				                  <p>".nl2br($value['descAP'])." <br> ".$value['dateACP']." à ".$h.":".$m."</p>
				                  <small>Nouvelle somme stock : ".number_format($value['SoldeT'])."Ar</small>
				                </div>
				              </div>
				            </div>
						";	
					}
				}
			}
		}
	}

	if (isset($_POST['getPro']) && !empty($_POST['getPro'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
			$donne = $modele->GetAllProduct();
			if ($donne) {
				foreach ($donne as $key => $value) {
					echo "
						<div class='mb-3 col-sm-3' onclick=\"ModalDetailleProductGet(".$value['idProduit'].")\" data-target=\"#ModalDetailleProduct\" data-toggle=\"modal\">
			                <div class='m-0 small-box bg-info'>
			                  <div class='inner'>
			                    <h3>".$value['NombreProduit']."</h3>
			                    <p>".$value['NameProduit']."</p>
			                  </div>
			                </div>
		              	</div>
					";
				}
			}else{
				echo "Vide";
			}
		}
	}



	if (isset($_POST['addPro']) && !empty($_POST['addPro'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
			if (empty($_POST['nameProduct']) || empty($_POST['prixProduct']) || empty($_POST['nombreProduct'])) {
				echo "Remplissez les données";
			}else{
				$res = $modele->AddProduct($_POST['nameProduct'],$_POST['prixProduct'],$_POST['nombreProduct'],$_SESSION['idAdmin']);
				if ($res == "ok") {
					echo "ok";
				}else{
					echo "Nom du produit ".$_POST['nameProduct']." existe déjà, changez de nom";
				}
			}
		}
	}

	if (isset($_POST['activiteVente']) && !empty($_POST['activiteVente'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
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
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			include '../../modele/personnel/modele.personnel.php';
			$modele = new ProduitAdmin();
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
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
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

	if (isset($_POST['RapportVenteTotal']) && !empty($_POST['RapportVenteTotal'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
			$donne = $modele->GetRapportToday();
			if ($donne) {
				$total = 0;
				foreach ($donne as $key => $value) {
					$donneVente = $modele->GetActiviteVenteDetaille($value['IdVenteAct']);
					$sommeTA = 0;
					foreach ($donneVente as $key => $valueVente) {
						$sommeTA += ($valueVente['PrixProduit']*$valueVente['QtV']);
					}
					$total += $sommeTA;
				}
				echo "
					Vente : ".number_format($total)."Ar
				";
			}
		}

	}
	if (isset($_POST['RapportToday']) && !empty($_POST['RapportToday'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
			$donne = $modele->GetRapportToday();
			if ($donne) {
				foreach ($donne as $key => $value) {
					$donneVente = $modele->GetActiviteVenteDetaille($value['IdVenteAct']);
					$sommeTA = 0;
					foreach ($donneVente as $key => $valueVente) {
						$sommeTA += ($valueVente['PrixProduit']*$valueVente['QtV']);
					}
					echo "
						<tr data-toggle='modal' data-target='#ModalVenteProduct' onclick=\"ModalVente('".$value['IdVenteAct']."')\">
		                    <td>".$value['dateActC']."</td>
		                    <td>".$value['heureActC']."</td>
		                    <td>".$value['prenom']."</td>
		                    <td>".$value['Description']."</td>
		                    <td>".$sommeTA."</td>
		                    <td>".$value['Stock']."</td>
		                    <td>".$value['Espece']."</td>
	                  	</tr>
					";
				}
			}
		}

	}

	if (isset($_POST['RapportTodayEspece']) && !empty($_POST['RapportTodayEspece'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
			$donne = $modele->GetActiviteSoldeToday();
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



	if (isset($_POST['listeSolde']) && !empty($_POST['listeSolde'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
			$solde = $modele->GetSoldeAct();
			if ($solde) {
				echo "
					<h6 data-target='#AddEspece' data-toggle='modal'>Espece : ".number_format($solde['Espece'])."Ar</h6>
		            <h6>Solde Stock : ".number_format($solde['Stock'])."Ar</h6>
				";
			}
		}
	}

	if (isset($_POST['PDFgetGSL']) && !empty($_POST['PDFgetGSL'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
			$solde = $modele->GetSoldeAct();


			$donneProduct = $modele->GetAllProductPDF();
			$listeProduct = "";
			if ($solde) {
				$s1 = $solde['Stock'];
				$e1 = $solde['Espece'];
			}
			if ($donneProduct) {
				foreach ($donneProduct as $key => $valueProduct) {
					$sa = ($valueProduct['PrixProduit']*$valueProduct['NombreProduit']);
					$listeProduct = $listeProduct."
						<tr>
			              <td>".$valueProduct['NameProduit']."</td>
			              <td>".number_format($valueProduct['PrixProduit'])."Ar</td>
			              <td>".number_format($valueProduct['NombreProduit'])."</td>
			              <td>".number_format($sa)."Ar</td>
			            </tr>
					";
				}
			}

			$donneActVent = $modele->GetActiviteVente();
			$listeActVent = "";
			if ($donneActVent) {
				foreach ($donneActVent as $key => $valueVentA) {
					$listeActVent = $listeActVent."
						<tr>
		                    <td>".$valueVentA['dateActC']."</td>
		                    <td>".$valueVentA['heureActC']."</td>
		                    <td>".$valueVentA['prenom']."</td>
		                    <td>".$valueVentA['Description']."</td>
		                    <td>".$valueVentA['Stock']."</td>
		                    <td>".$valueVentA['Espece']."</td>
	                  	</tr>
					";
				}
			}


			$donneEspece = $modele->GetActiviteSolde();
			$listeActEspece = "";
			if ($donneEspece) {
				foreach ($donneEspece as $key => $valueEspece) {
					$listeActEspece = $listeActEspece."
						<tr>
		                    <td>".$valueEspece['dateActSolde']."</td>
		                    <td>".$valueEspece['heureActSolde']."</td>
		                    <td>".$valueEspece['prenom']."</td>
		                    <td>".$valueEspece['titreComs']."<br>".$valueEspece['descriptionActSolde']."</td>
		                    <td>".$valueEspece['NewEspece']."</td>
	                  	</tr>
					";
				}
			}
			echo "	
				<div class='container'>
				    <div class='card'>
				      <div class='card-body'>
				        <h5>Activite GSL</h5><hr>
				        
				        <div class='row'>
				          <div class='col-sm-6 text-left'>
				            <h6>Solde : ".number_format($s1)."Ar </h6>
				            <h6>Espece : ".number_format($e1)."Ar </h6>
				          </div>
				          <div class='col-sm-6 text-right'>
				            <h6>".date('d-m-Y')."</h6>
				            <h6>".date('h:i')."</h6>
				          </div>
				        </div>

				        <hr><hr>

				        <h5>Stock disponible</h5><hr>

				        <table class='table'>
				          <thead class='bg-light'>
				            <tr>
				              <th>Produit</th>
				              <th>Prix</th>
				              <th>Nombre</th>
				              <th>Total</th>
				            </tr>
				          </thead>
				          <tbody>
				          	".$listeProduct."
				          </tbody>
				        </table>

				        <hr><hr>

				        <h5>Activite</h5><hr>
				        <div class='row'>
				          <div class='col-sm-12'>
				            <div class='card'>
				              <div class='card-header'>
				                <h3 class='card-title'>Vente</h3>
				              </div>
				              <div class='card-body'>
				                <table class='table'>
				                   <thead class='bg-light'>
				                      <tr>
				                        <th>Date</th>
				                        <th>Heure</th>
				                        <th>Personne</th>
				                        <th>Description</th>
				                        <th>Stock</th>
				                        <th>Espece</th>
				                      </tr>
				                    </thead>
				                    <tbody>
				                      ".$listeActVent."
				                    </tbody>
				                </table>
				              </div>
				            </div>
				          </div>
				          <div class='col-sm-12'>
				            <div class='card'>
				              <div class='card-header'>
				                <h3 class='card-title'>Espece</h3>
				              </div>
				              <div class='card-body'>
				                <table class='table'>
				                   <thead class='bg-light'>
				                      <tr>
				                        <th>Date</th>
				                        <th>Heure</th>
				                        <th>Personne</th>
				                        <th>Description</th>
				                        <th>Espece</th>
				                      </tr>
				                    </thead>
				                    <tbody>
				                      ".$listeActEspece."
				                    </tbody>
				                </table>
				              </div>
				            </div>
				          </div>
				        </div>

				      </div>
				    </div>
			  	</div>
			";
		}
	}


	if (isset($_POST['getModalVente']) && !empty($_POST['getModalVente'])) {
		session_start();
		if (isset($_SESSION['idAdmin'])) {
			include '../../config/connex.php';
			include '../../modele/produit/modele.produit.php';
			$modele = new ProduitAdmin();
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


 ?>