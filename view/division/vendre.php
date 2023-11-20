<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><i class="fas fa-book"></i> Vendre</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a><?php echo $user['nom']." ".$user['prenom']; ?></a></li>
          </ol>
        </div>
      </div>
    </div>
    <hr>
</div>

<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-sm-5">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Solde</h3>
              </div>
              <div class="card-body" id="soldeAffichage"></div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Rechercher des produits</h3>
          </div>      
          <div class="card-body">
            <div class="form-group">
              <input type="text" placeholder="Recherche Produit" class="form-control" onchange="GetListProductVenteSearch(this.value)">
            </div>
            <hr>
            <div class="row listeSomScroll" id="listProductStockageVendre"></div>
          </div>      
        </div>
      </div>
      <div class="col-sm-7">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Activité</h3>
            <div class="card-tools">
              <button class="btn btn-light" onclick="Panier('listePanier')"><i class="fa fa-undo"></i></button>
            </div>
          </div>  
          <div class="card-body" id="listePanier"></div>  
        </div>
      </div>
    </div>
  </div>
</section>
<style type="text/css">
  .listeSomScroll{
    height: 300px;
    overflow-y: scroll;
  }
  .listeSomScroll-lg{
    height: 400px;
    overflow-y: scroll;
  }
  .form-quantite{
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    box-shadow: inset 0 0 0 transparent;
    transition: border-color .15s
  }
</style>
<script src="admin/content/jquery/jquery.min.js"></script>
<script type="text/javascript">
  function GetListProductVenteSearch(valeur) {
      var url = "controller/produit/controller.produit.php";
      if (valeur == "") {
        GetListProductVente('listProductStockageVendre') 
      }else{
        $.ajax({
          type: "POST",
          url: url,
          data: ({
            getStockageProductSearch: valeur,
          }),
          dataType: "text",
          success: function(res) {
            $("#listProductStockageVendre").html(res)
          },
          error: function(e) {
            alert("Erreur")
            window.location.reload()
          }
        });
      }
  }
  function GetListProductVente(output) {
      var url = "controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          getVendreProduct: 56,
        }),
        dataType: "text",
        success: function(res) {
          $("#"+output).html(res)
        },
        error: function(e) {
          alert("Erreur")
          window.location.reload()
        }
      });
  }

  function Panier(output) {
      var url = "controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          listePanier: 56,
        }),
        dataType: "text",
        success: function(res) {
          $("#"+output).html(res)
        },
        error: function(e) {
          alert("Erreur")
          window.location.reload()
        }
      });
  }
  function Solde(output) {
      var url = "controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          listeSolde: 56,
        }),
        dataType: "text",
        success: function(res) {
          $("#"+output).html(res)
        },
        error: function(e) {
          alert("Erreur")
          window.location.reload()
        }
      });
  }

  function UpdateQuantitePan(product,quantiteUpdate) {
      var url = "controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          updateQtPan: product,
          valeur: quantiteUpdate
        }),
        dataType: "text",
        success: function(res) {
          if (res == "ok") {
            Vendre()
          }else{
            alert(res)
            Vendre()
          }
        },
        error: function(e) {
          alert("Erreur")
          window.location.reload()
        }
      });
  }
  function DelPanier(product) {
      var url = "controller/produit/controller.produit.php";
      if (confirm("Confirmez la suppression ?")) {
        $.ajax({
          type: "POST",
          url: url,
          data: ({
            delQtPan: product,
          }),
          dataType: "text",
          success: function(res) {
            if (res == "ok") {
              Vendre()
            }else{
              alert(res)
            }
          },
          error: function(e) {
            alert("Erreur")
            window.location.reload()
          }
        });
      }
  }
  function ValiderPanier() {
      var url = "controller/produit/controller.produit.php";
      if (confirm("Confirmez la vente ?")) {
        $.ajax({
          type: "POST",
          url: url,
          data: ({
            validePanier: 404,
          }),
          dataType: "text",
          success: function(res) {
            if (res == "ok") {
              Vendre()
            }else{
              alert(res)
            }
          },
          error: function(e) {
            alert("Erreur")
            window.location.reload()
          }
        });
      }
  }
  function VidePanier() {
      var url = "controller/produit/controller.produit.php";
      if (confirm("Videz le panier ?")) {
        $.ajax({
          type: "POST",
          url: url,
          data: ({
            videPan: 10,
          }),
          dataType: "text",
          success: function(res) {
            if (res == "ok") {
              Vendre()
            }else{
              alert(res)
            }
          },
          error: function(e) {
            alert("Erreur")
            window.location.reload()
          }
        });
      }
  }

  function AddProductToVent(product) {
      var url = "controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          addProductPan: product,
        }),
        dataType: "text",
        success: function(res) {
          if (res == "ok") {
            Vendre()
          }else{
            alert(res)
          }
        },
        error: function(e) {
          alert("Erreur")
          window.location.reload()
        }
      });
  }

  function Vendre() {
    Panier('listePanier')
    Solde('soldeAffichage')
    GetListProductVente('listProductStockageVendre') 
  }
  Vendre()
</script>