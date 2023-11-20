<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><i class="fas fa-copyright"></i> Généralité</h1>
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
      <div class="col-sm-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Solde</h3>
          </div>
          <div class="card-body" id="soldeOutpout"></div>
        </div>
        <div class="card">
          <div class="card-body" id="resCompta"></div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card listeSomScroll-lg">
          <div class="card-body" id="listeActProduct"></div>
        </div>
      </div>
    </div>
  </div>
</section>
<style type="text/css">
  .listeSomScroll-lg{
    height: 500px;
    overflow-y: scroll;
  }
</style>

<script src="admin/content/jquery/jquery.min.js"></script>
<script type="text/javascript">
  function GetComptabilite() {
      var url = "admin/controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          getCompta: 56,
        }),
        dataType: "text",
        success: function(res) {
          $("#resCompta").html(res)
        },
        error: function(e) {
          alert("Erreur")
          window.location.reload()
        }
      });
  }
  function GetActProduct() {
      var url = "admin/controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          getActProduct: 56,
        }),
        dataType: "text",
        success: function(res) {
          $("#listeActProduct").html(res)
        },
        error: function(e) {
          alert("Erreur")
          window.location.reload()
        }
      });
  }
  function Solde(output) {
      var url = "admin/controller/produit/controller.produit.php";
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
  function Comptabilite() {
   GetActProduct()
   GetComptabilite()
   Solde('soldeOutpout')
  }
  Comptabilite()
</script>