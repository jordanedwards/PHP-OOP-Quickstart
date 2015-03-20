<head>
<link href="../css/select2.css" rel="stylesheet"/>  
      <script src="../../js/jquery-1.7.1.min.js"></script>
      <script src="../../js/jquery-ui-1.8.20.custom.min.js"></script> <!-- for sortable example -->

  <script type="text/javascript" src="../js/select2.js"></script>  
  <script>
$(document).ready(function() {	
	$("#e2_2").select2();


$("#e8_set2").click(function () { 
alert($("#e2_2").select2("val"));

$("#e2_2").select2("data", [{id: "CA", text: "California"},{id:"MA", text: "Massachusetts"}]);
 });


  });
  </script>

 </head>
 
 <body>
<select id="e2_2" multiple="multiple" style="width:300px">
				<option value="ab">AB</option>
				<option value="bc">BC</option>
				</select>
<button type="button" id="e8_set2">&raquo; Add</button>

			</body>