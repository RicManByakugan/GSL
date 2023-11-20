<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><i class="fas fa-cube"></i> Rapport aujourd'hui</h1>
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
  <div class="row">
    <div class="col-sm-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" id="sommmeVenteTodayOutpout"></h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="bg-light">
                <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Personne</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Espece</th>
                </tr>
              </thead>
              <tbody id="rapportTodayOutput"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Espece</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="bg-light">
                <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Personne</th>
                    <th>Description</th>
                    <th>Espece</th>
                </tr>
              </thead>
              <tbody id="rapportTodayOutputEspece"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="admin/content/jquery/jquery.min.js"></script>
<script type="text/javascript">
  function RapportToday(output) {
      var url = "admin/controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          RapportToday: 56,
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
  }RapportToday('rapportTodayOutput')
  function RapportTodayEspece(output) {
      var url = "admin/controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          RapportTodayEspece: 56,
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
  }RapportTodayEspece('rapportTodayOutputEspece')
  function RapportVenteTotal(output) {
      var url = "admin/controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          RapportVenteTotal: 56,
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
  }RapportVenteTotal('sommmeVenteTodayOutpout')
</script>