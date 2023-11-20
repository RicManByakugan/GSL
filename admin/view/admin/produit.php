<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><i class="fas fa-book"></i> Produit</h1>
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
      <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Remplissez le formulaire</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Nom</label>
                  <input type="text" class="form-control" id="nameProduct">
                </div>
              </div>
            </div>  
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Prix unitaire</label>
                  <input type="number" class="form-control" min="0" id="prixProduct">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Nombre</label>
                  <input type="number" class="form-control" min="0" id="nombreProduct">
                </div>
              </div>
            </div>  
            <div class="row">
              <div class="col-sm-12">
                <span id="resAddProduct"></span>
                <button class="btn btn-primary btn-block" onclick="AddProduit(this)">Ajouter</button>
              </div>
            </div>  
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Liste de stock disponible</h3>
          </div>      
          <div class="card-body">
            <div class="row" id="listProductAdd"></div>
          </div>      
        </div>
      </div>
    </div>
  </div>
</section>

<script src="admin/content/jquery/jquery.min.js"></script>
<script type="text/javascript">
  function AddProduit(container) {
      var url = "admin/controller/produit/controller.produit.php";
      if (confirm("Confirmez l'ajout de nouvelle produit ?")) {
        container.disabled = true;
        container.innerHTML = "Ajout en cours ...";
        $.ajax({
          type: "POST",
          url: url,
          data: ({
            addPro: 21,
            nameProduct: $("#nameProduct").val(),
            prixProduct: $("#prixProduct").val(),
            nombreProduct: $("#nombreProduct").val()
          }),
          dataType: "text",
          success: function(res) {
            if (res == "ok") {
              $("#resAddProduct").html("")
              $("#nameProduct").val("")
              $("#prixProduct").val("")
              $("#nombreProduct").val("")
              container.disabled = false;
              container.innerHTML = "Ajouter";
              GetListProduct('listProductAdd')
            }else{
              $("#resAddProduct").html(res)
              container.disabled = false;
              container.innerHTML = "Ajouter";
            }
          },
          error: function(e) {
            alert("Erreur")
            window.location.reload()
          }
        });
      }
  }
  function GetListProduct(output) {
      var url = "admin/controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          getPro: 56,
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
  GetListProduct('listProductAdd')
</script>