<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><i class="fas fa-table"></i> Stockage</h1>
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
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Liste de stock disponible</h3>
          </div>      
          <div class="card-body">
            <div class="form-group">
              <input type="text" placeholder="Recherche Produit" class="form-control" onchange="GetListProductStockageSearch(this.value)">
            </div>
            <hr>
            <div class="row" id="listProductStockage"></div>
          </div>      
        </div>
      </div>
    </div>
  </div>
</section>
<script src="admin/content/jquery/jquery.min.js"></script>
<script type="text/javascript">
  function GetListProductStockageSearch(valeur) {
      if (valeur != "") {
        var url = "controller/produit/controller.produit.php";
        $.ajax({
          type: "POST",
          url: url,
          data: ({
            getStockageProductSearch: valeur,
          }),
          dataType: "text",
          success: function(res) {
            $("#listProductStockage").html(res)
          },
          error: function(e) {
            alert("Erreur")
            window.location.reload()
          }
        });
      }else{
        GetListProductStockage('listProductStockage')
      }
  }
  function GetListProductStockage(output) {
      var url = "controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          getStockageProduct: 56,
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
  GetListProductStockage('listProductStockage')
</script>