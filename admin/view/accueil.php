<!DOCTYPE html>
<html>
<head>
  	<title>GSL</title>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="content/plugins/fontawesome-free/css/all.min.css">
  	<link rel="stylesheet" href="content/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  	<link rel="stylesheet" href="content/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  	<link rel="stylesheet" href="content/plugins/jqvmap/jqvmap.min.css">
  	<link rel="stylesheet" href="content/css/adminlte.min.css">
  	<link rel="stylesheet" href="content/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  	<link rel="stylesheet" href="content/plugins/daterangepicker/daterangepicker.css">
  	<link rel="stylesheet" href="content/plugins/summernote/summernote-bs4.min.css">
    <link rel="icon" href="data/logo.png">
    <script src="content/jquery/jquery.min.js"></script>
    <script type="text/javascript">
      function Deco() {
            var url = "admin/controller/controllerPersonnel/controller.personnel.php";
            if (confirm("Se deconnecter ?")) {
              $.ajax({
                type: "POST",
                url: url,
                data: ({
                  deconnexion: "go"
                }),
                dataType: "text",
                success: function(res) {
                  if (res=="ok") {
                    window.location.reload();
                  }else{
                    alert(res);
                  }
                }
              });
            }
      }
      $(document).ready(function(){
        $("#new_mdpbtn").click(function(e) {
            e.preventDefault();
            $.post(
              'admin/controller/controllerPersonnel/controller.personnel.php',
              {
                new_mdpbtn: "go",
                idPerso: $("#idPerso").val(),
                old_mdp: $("#old_mdp").val(),
                new_mdp1: $("#new_mdp1").val(),
                new_mdp2: $("#new_mdp2").val()
              },
              function(data) {
                if (data=="OK") {
                  $("#success").html("Effectuer"); 
                  $("#error").html(""); 
                  window.location.reload();
                }
                else{
                   $("#error").html(data); 
                }
              }
            );    
        });
      });
    </script>
</head>

<body>
    <?php include 'admin/modal.php'; ?>
    <div class="container mt-3">
      <div class="modal fade" id="Params">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Paramètre <i class="fas fa-cog"></i></h4>
              <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col">
                    <h6 align="left">Mot de passe</h6>
                  </div>
                  <div class="col">
                    <h6 align="right"><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#ConModal">Modifier</button></h6>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container mt-3">
        <div class="modal fade" id="ConModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Changement mot de passe <i class="typcn typcn-cog"></i></h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>Ancien mot de passe</label>
                    <input type="text" id="idPerso" hidden value="<?php echo $idAdmin; ?>">
                  <input type="password" id="old_mdp" class="form-control">
                </div>
                <div class="form-group">
                  <label>Nouveau mot de passe</label>
                  <input type="password" id="new_mdp1" class="form-control">
                </div>
                <div class="form-group">
                  <label>Confirmer le nouveau mot de passe</label>
                  <input type="password" id="new_mdp2" class="form-control">
                </div>
              </div>
              <small id="error" style="color: red;text-align: center;"></small>
              <small id="success" style="color: green;text-align: center;"></small>
              <div class="modal-footer">
                  <button class="btn btn-sm btn-primary" id="new_mdpbtn">Modifier</button>
                  <small class="btn btn-sm btn-primary" data-dismiss="modal">Annuler</small>
               </div>
            </div>
          </div>
        </div>
    </div>

		<div class="wrapper">
  			<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="margin-top: -20px;">
  			    <ul class="navbar-nav">
  			      <li class="nav-item">
  			        <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
  			      </li>
  			    </ul>

  			    <ul class="navbar-nav ml-auto">			   

              <li class="nav-item" onclick="LoadFacture('<?= date("Y-m-d") ?>')">
                <a class="nav-link" role="button">
                  <i class="fas fa-upload"></i>
                </a>
              </li>

  			      <li class="nav-item">
  			        <a href="admin.php" class="nav-link" role="button">
  			          <i class="fas fa-undo"></i>
  			        </a>
  			      </li>

  			      <li class="nav-item">
  			        <a class="nav-link" data-widget="fullscreen" role="button">
  			          <i class="fas fa-expand-arrows-alt"></i>
  			        </a>
  			      </li>
  			      
  			      <li class="nav-item dropdown">
  			      	<a class="nav-link" data-toggle="dropdown">
  			          <i class="far fa-user"></i>
  			        </a>
  			         <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
  			          	<span class="dropdown-item dropdown-header"><?php echo $user['nom']." ".$user['prenom']; ?></span>
  			         	<div class="dropdown-divider"></div>
  			         	<span class="dropdown-item" style="text-align: center;">
  				         	<small class="btn btn-primary" data-toggle="modal" data-target="#Params">Paramètre</small>
  				         	<a><small class="btn btn-primary" onclick="Deco();">Déconnexion</small></a>
  			         	</span>
  			          	<div class="dropdown-divider"></div>
  			        </div>
  			      </li>
  			    
  			    </ul>
  		  </nav>

  			<aside class="main-sidebar sidebar-dark-primary elevation-4">

  			    <div class="sidebar">

  			      <div class="mt-3 user-panel">
                <span class="info text-white">
                  <h3 align="center">ADMIN GSL</h3>   
                </span>
              </div>
              <div class="user-panel mt-3 pb-3 mb-3 d-flex text-center">
  			        <div class="image">
                    <img src="data/user/profile.png" class="img-circle elevation-2">
  			        </div>
  			        <div class="info">
  			          <a class="users-list-name"><?php echo $user['nom']." ".$user['prenom']; ?></a>
  			        </div>
  			      </div>


  			      <nav class="mt-2">
  			        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
  			         	<li class="nav-item" onclick="ChangeIt('comptabilite','produit','stockage','activite','historique','rapport')">
                    <a class="nav-link">
                      <i class="nav-icon fas fa-copyright"></i>
                      <p>
                        Généralité
                      </p>
                    </a>
                  </li>
                  <li class="nav-item" onclick="ChangeIt('produit','comptabilite','stockage','activite','historique','rapport')">
                    <a class="nav-link">
                      <i class="nav-icon fas fa-book"></i>
                      <p>
                        Produit contrôle
                      </p>
                    </a>
                  </li>
                  <li class="nav-item" onclick="ChangeIt('stockage','produit','produit','activite','historique','rapport')">
                    <a class="nav-link">
                      <i class="nav-icon fas fa-table"></i>
                      <p>
                        Stockage officiel
                      </p>
                    </a>
                  </li>
                  <li class="nav-item" onclick="ChangeIt('activite','produit','stockage','comptabilite','historique','rapport')">
                    <a class="nav-link">
                      <i class="nav-icon fa fa-bullhorn"></i>
                      <p>
                        Activité commerçant
                      </p>
                    </a>
                  </li>
                  <li class="nav-item" onclick="ChangeIt('rapport','produit','stockage','comptabilite','historique','activite')">
                    <a class="nav-link">
                      <i class="nav-icon fa fa-cube"></i>
                      <p>
                        Rapport
                      </p>
                    </a>
                  </li>
                  <!-- <li class="nav-item" onclick="ChangeIt('historique','produit','stockage','activite','comptabilite')">
                    <a class="nav-link">
                      <i class="nav-icon fas fa-user"></i>
                      <p>
                        Personnel
                      </p>
                    </a>
                  </li> -->
  			        </ul><br>

  			      </nav>
  			    </div>
  		  </aside>

    		<div class="content-wrapper">
          <span style="display: none;" id="pdfOut"><?php include 'admin/pdf.php'; ?></span>
          <span style="display: block;" id="comptabilite"><?php include 'admin/comptabilite.php'; ?></span>
          <span style="display: none;" id="produit"><?php include 'admin/produit.php'; ?></span>
          <span style="display: none;" id="stockage"><?php include 'admin/stockage.php'; ?></span>
          <span style="display: none;" id="activite"><?php include 'admin/activite.php'; ?></span>
          <span style="display: none;" id="historique"><?php include 'admin/historique.php'; ?></span>
    			<span style="display: none;" id="rapport"><?php include 'admin/rapport.php'; ?></span>
    		</div>
    </div>

		<script src="content/plugins/jquery/jquery.min.js"></script>
		<script src="content/plugins/jquery-ui/jquery-ui.min.js"></script>
		<script>
		  $.widget.bridge('uibutton', $.ui.button)
		</script>
		<script src="content/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="content/plugins/chart.js/Chart.min.js"></script>
		<script src="content/plugins/sparklines/sparkline.js"></script>
		<script src="content/plugins/jqvmap/jquery.vmap.min.js"></script>
		<script src="content/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
		<script src="content/plugins/jquery-knob/jquery.knob.min.js"></script>
		<script src="content/plugins/moment/moment.min.js"></script>
		<script src="content/plugins/daterangepicker/daterangepicker.js"></script>
		<script src="content/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
		<script src="content/plugins/summernote/summernote-bs4.min.js"></script>
		<script src="content/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
		<script src="content/js/adminlte.js"></script>
		<script src="content/js/demo.js"></script>
		<script src="content/js/pages/dashboard.js"></script>


    <script src="content/pdf/jquery.min.js"></script>
    <script src="content/pdf/jszip.min.js"></script>
    <script src="content/pdf/kendo.all.min.js"></script>
    <script type="text/javascript">
      function ChangeIt(id1,id2,id3,id4,id5,id6) {
        var id1 = document.getElementById(id1)
        var id2 = document.getElementById(id2)
        var id3 = document.getElementById(id3)
        var id4 = document.getElementById(id4)
        var id5 = document.getElementById(id5)
        var id6 = document.getElementById(id6)
        id1.style.display = "block"
        id2.style.display = "none"
        id3.style.display = "none"
        id4.style.display = "none"
        id5.style.display = "none"
        id6.style.display = "none"
      }
      function LoadFacture(dateee) {
        if (confirm("Télécharger le PDF ?")) {
          var pdfOut = document.getElementById('pdfOut');
          pdfOut.style.display = "block";
          kendo.drawing
          .drawDOM("#pdfOut", 
          { 
            paperSize: "A3",
            margin: { top: "1cm", bottom: "1cm" },
            scale: 0.8,
            height: 500
          })
          .then(function(group){
              kendo.drawing.pdf.saveAs(group, "GSL"+dateee+".pdf")
              pdfOut.style.display = "none";
          });
        }
      }
    </script>


</body>
</html>