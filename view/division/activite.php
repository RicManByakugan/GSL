<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><i class="fas fa-arrow-circle-right"></i> Activite</h1>
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
            <h3 class="card-title">Activité de vente</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div> 
          <div class="card-body collapse">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="bg-light">
                  <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Personne</th>
                    <th>Description</th>
                    <th>Stock</th>
                    <th>Espece</th>
                  </tr>
                </thead>
                <tbody id="activiteVenteOutput"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Activité de stock</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div> 
          <div class="card-body collapse">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="bg-light">
                  <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Description</th>
                    <th>Stock</th>
                  </tr>
                </thead>
                <tbody id="soldeOutpoutActivite2"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Activité d'espece</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div> 
          <div class="card-body collapse">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="bg-light">
                  <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Personne</th>
                    <th>Description</th>
                    <th>Nouvelle espece</th>
                  </tr>
                </thead>
                <tbody id="soldeOutpoutActivite"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="content/jquery/jquery.min.js"></script>
<script type="text/javascript">
  function ActiviteSolde(output) {
      var url = "controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          activiteSolde: 56,
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
  }ActiviteSolde('soldeOutpoutActivite')
  function ActiviteSolde2(output) {
      var url = "controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          activiteSolde2: 56,
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
  }ActiviteSolde2('soldeOutpoutActivite2')
  function ActiviteVente(output) {
      var url = "controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          activiteVente: 56,
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
  }ActiviteVente('activiteVenteOutput')
  function SoldeActivite(output) {
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
  }SoldeActivite('soldeAffichageActivite')
</script>