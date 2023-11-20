<div class="modal fade" id="ModalDetailleProduct">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">GSL</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body" id="resDetailleMP"></div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalVenteProduct">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">GSL</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body" id="outPutModalVente"></div>
    </div>
  </div>
</div>

<div class="container mt-3">
    <div class="modal fade" id="AddEspece">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Contrôle Espèce</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12" id="soldeOutpoutModal"></div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-12">
                  <div class="row">
                    <div class="col-sm-12">
                    <div class="form-group">
                      <label>Espece à ajouté</label>
                      <input type="number" class="form-control" id="valEspece">
                    </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Motif</label>
                        <textarea class="form-control" id="motifADD"></textarea>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <button class="btn btn-primary btn-block" onclick="AddEspece(this)">Ajouter</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
</div>

<script src="content/jquery/jquery.min.js"></script>
<script type="text/javascript">
  function ModalDetailleProductGet(product) {
      var url = "controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          getProDetaille: product,
        }),
        dataType: "text",
        success: function(res) {
          $("#resDetailleMP").html(res)
        },
        error: function(e) {
          alert("Erreur")
          window.location.reload()
        }
      });
  }
  function ModalVente(numvente) {
      var url = "controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          getModalVente: numvente,
        }),
        dataType: "text",
        success: function(res) {
          $("#outPutModalVente").html(res)
        },
        error: function(e) {
          alert("Erreur")
          window.location.reload()
        }
      });
  }
  function AddEspece(container) {
      var url = "controller/produit/controller.produit.php";
      if (confirm("Poursuivre l'action ?")) {
        if ($("#valEspece").val() != "" || $("#valEspece").val() != undefined) {
          container.disabled = true;
          $.ajax({
            type: "POST",
            url: url,
            data: ({
              addEspece: $("#valEspece").val(),
              motifADD: $("#motifADD").val()
            }),
            dataType: "text",
            success: function(res) {
              if (res == "ok") {
                $("#valEspece").val("")
                $("#motifADD").val("")
                SoldeModal('soldeOutpoutModal')
              }else{
                alert(res)
              }
              container.disabled = false;
            },
            error: function(e) {
              alert("Erreur")
              window.location.reload()
            }
          });
        }
      }
  }
  function SoldeModal(output) {
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
  }SoldeModal('soldeOutpoutModal')
</script>