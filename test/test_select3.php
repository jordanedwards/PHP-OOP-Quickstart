<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
  <head>
    <meta charset="utf-8">
    <title>Select2 3.5.1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Select2 JQuery Plugin">
    <meta name="author" content="Igor Vaynberg">

    <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet"/>

      <script src="../../js/json2.js"></script>
      <script src="../../js/jquery-1.7.1.min.js"></script>
      <script src="../../js/jquery-ui-1.8.20.custom.min.js"></script> <!-- for sortable example -->
      <script src="../../bootstrap/js/bootstrap.min.js"></script>

      <script>
          $(document).ready(function() {

              function setupExampleCode(id) {
                  var s = $("#script_"+id).html();
                  s = s.replace(/</g, "&lt;");
                  s = s.substr(s.indexOf("\n") + 1);
                  s = s.substr(s.indexOf("\n") + 1);
                  s = s.substr(0, s.lastIndexOf("\n"));
                  s = s.substr(0, s.lastIndexOf("\n"));
                  $("#code_"+id).html(s);
              }

              var i, e;
              for (i = 2; ; i++) {
                  e = $("#script_e" + i);
                  if (e.length == 0) break;
                  setupExampleCode("e" + i);
              }

          });
      </script>


  </head>

  <body>


    <div class="container">


<link href="../../js/select2/select2.css" rel="stylesheet"/>
<script src="../../js/select2/select2.js"></script>

<script id="script_e1">

$(function() {
   var opts=$("#source").html(), opts2="<option></option>"+opts;
   $("select.populate").each(function() { var e=$(this); e.html(e.hasClass("placeholder")?opts2:opts); });
   $(".examples article:odd").addClass("zebra");
});

</script>
     

        <article class="row" id="programmatic">
<script id="script_e8">
$(document).ready(function() {
$("#e8_2").select2({placeholder: "Select a state"});
$("#e8_2_get2").click(function () { alert("Selected value is: "+$("#e8_2").select2("val"));});
$("#e8_2_set").click(function () { $("#e8_2").select2("val", ["CA","MA"]); });
$("#e8_2_get").click(function () { alert("Selected value is: "+JSON.stringify($("#e8_2").select2("data")));});
$("#e8_2_set2").click(function () { $("#e8_2").select2("data", [{id: "CA", text: "California"},{id:"MA", text: "Massachusetts"}]); });
$("#e8_2_cl").click(function() { $("#e8_2").select2("val", ""); });
$("#e8_2_open").click(function () { $("#e8_2").select2("open"); });
$("#e8_2_close").click(function () { $("#e8_2").select2("close"); });
});
</script>
            <div class="span4">
            <h3><label for="e8">Programmatic Access</label></h3>

                <p>
                  <input type="button" class="btn-primary" id="e8_2_get2" value="Alert selected value"/>				
                  <input type="button" class="btn-info" id="e8_2_set2" value="Set to California and Massachusetts using data"/>
                    <input type="button" class="btn-info" id="e8_2_cl" value="Clear"/>
                    <input type="button" class="btn-warning" id="e8_2_open" value="Open"/>
                  <input type="button" class="btn-warning" id="e8_2_close" value="Close"/>
                </p>
             <label for="e8_2">Populate</label>

              <p>
                  <select id="e8_2" multiple style="width:300px" class="populate"><option></option></select><br/>
              </p>
          </div>
          
        </article>


    </div> <!-- /container -->
  </body>
</html>