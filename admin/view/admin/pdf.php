<div id="pdfOutput"></div>

<script src="admin/content/jquery/jquery.min.js"></script>
<script type="text/javascript">
  function PDFgetGSL(output) {
      var url = "admin/controller/produit/controller.produit.php";
      $.ajax({
        type: "POST",
        url: url,
        data: ({
          PDFgetGSL: 68,
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
  }PDFgetGSL('pdfOutput')
</script>