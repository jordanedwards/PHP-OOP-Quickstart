<?php
// For this to work:
// Data Manager class needs to be located here: $_SERVER['DOCUMENT_ROOT']/classes/class_data_manager.php
// The id field of the table needs to be "table name"_id

/* $_SERVER['DOCUMENT_ROOT'] */
include("../includes/init.php");
require_once('../classes/class_data_manager.php');
$dbname = "orchardc_jordanedwards";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SQL, Class, and Action creator</title>
<!--<link href='//fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>-->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all">
<link href="css/jquery-ui.css" rel="stylesheet">
<link href="css/jquery.idealforms.min.css" rel="stylesheet" media="screen"/>

<script src="https://code.jquery.com/jquery-1.11.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="js/jquery.idealforms.min.js"></script>

<script>



  var options = {

    onFail: function() {
      alert( $myform.getInvalid().length +' invalid fields.' )
    },

    inputs: {
      'lastname': {
        filters: 'required lastname',
      },
      'firstname': {
        filters: 'required firstname',
        data: {
          //ajax: { url:'validate.php' }
        }
      },
      'file': {
       // filters: 'extension',
      //  data: { 
	//	extension: ['jpg']	
		// }
      },

      'comments': {
     //   filters: 'min max',
      //  data: { min: 50, max: 200 }
      },
      'states': {
        filters: 'exclude',
        data: { exclude: ['default'] },
        errors : {
          exclude: 'Select a State.'
        }
      },
      'langs[]': {
        filters: 'min max',
        data: { min: 2, max: 3 },
        errors: {
          min: 'Check at least <strong>2</strong> options.',
          max: 'No more than <strong>3</strong> options allowed.'
        }
      }
    }
  };

  var $myform = $('#my-form').idealforms(options).data('idealforms');

  $('#reset').click(function(){ $myform.reset().fresh().focusFirst() });
  $myform.focusFirst();

</script>

<script>

function add_another_input() 
{
//$("#field_last").append("<p>Test</p>");

    var element = document.getElementById('field_list');
	var i = element.children.length;
	i = i+1;

    var element = document.createElement('input');
    var td = document.getElementById('field_list');
    var table_name = document.getElementById('table_name').value;

    element.type="text";
    element.setAttribute("name", "field_"+i);
    element.setAttribute("value", table_name+"_");
    element.setAttribute("style", "display:block");

    td.appendChild(element);

}

function remove_input() 
{

    var td = document.getElementById('field_list');
	td.removeChild( td.childNodes[ td.childNodes.length - 1 ] );

}

function update_table_name(){
    var table_name = document.getElementById('table_name').value;
	// Underscores not allowed - it messes things up:
	
	var new_table_name = table_name.replace("_", "");
	if (new_table_name.length < table_name.length){
		document.getElementById('err_msg').innerHTML="<i> Underscores not permitted</i>";
	} else {
		document.getElementById('err_msg').innerHTML="";
	}
		
	document.getElementById('table_name').value = new_table_name;

	
	var nodes = document.getElementById('field_list').childNodes;
		for(i=0; i<nodes.length; i++) {
			var str = new_table_name+nodes[i].value;
			nodes[i].value = str;
			nodes[i].size = str.length+15;
		}

}
function trigger_download(source){
	x =document.getElementById("selected_table").value;
	source = source+x;
	window.location.assign(source);
}
function updateSelected(selectedTable){
	$('#fieldDropdown').load("ajax/ajax_db_fields.php?table="+selectedTable);
}
</script>
<script>
  $(function() {
    $( "#class_create" ).dialog({
		autoOpen: false,
		width: 450,	
		modal: true,
		buttons: {
			"Continue": function(){
				trigger_download('action_class_creator.php?selected_table='+$('#selected_table').val()+"&name_field="+$('#name_field').val())
	          	$( this ).dialog( "close" );				
			},
			Cancel: function() {
          	$( this ).dialog( "close" );
        }
        }
	});
  });
  </script>

</head>
<body>

<div id="class_create" title="Create Class" style="display:none">
<table>
<tr>
<td>
  <p><label>Choose NAME field:</label><br>
  <span style="font-size:10px">(For dynamic drop down function)</span></p>
</td>
<td id="fieldDropdown">
<p>
	<select id="name_field">
	<option value="">None</option>
		<?php
		/*	$dm = new DataManager();

			$sql = "Show fields from equipment";
			$result = $dm->queryRecords($sql);
			while ($row = mysql_fetch_row($result)) {
				 echo '<option value="'. $row[0] . '">' . $row[0] . '</option>';
			}*/
?>
    </select>
  </p>
</td>
</tr>
</table>
</div>

<div align="center" class="content" style=" width:50%">
<table>
<tr>
<td colspan="3" align="center">
<h1>Create a: sql import, OOP class, & php action file</h1></td>
</tr>

<tr valign="top">
<td>
<h3>Create SQL table:</h3>
<form method="post" action="action_sql_creator.php">

Table Name:<br>
<input name="table_name" id="table_name" value="" onChange="update_table_name();"><span id="err_msg"></span><br><br>



<table><tr valign="top" style="line-height:14px"><td>
List fields:<br>
<div id="field_list">
<input name="field_1" value="_id" style="display:block; width:auto">
<input name="field_5" id="field_last" class="field_last" value="_" style="display:block; width:auto">

<input name="field_2" value="_date_created"  style="display:block; width:auto" disabled="disabled">
<input name="field_3" value="_last_updated"  style="display:block; width:auto" disabled="disabled">
<input name="field_4" value="_last_updated_user"  style="display:block; width:auto" disabled="disabled">
</div>
</td>
<td>
Type:<br>
<select class="column_type" name="type_1" id="type_1" style="display:block; width:auto">
<option>INT</option>
</select>

<select class="column_type" name="type_1" id="type_1" style="display:block; width:auto">
<option>DATE</option>
</select>

<select class="column_type" name="type_1" id="type_1" style="display:block; width:auto">
<option>TIMESTAMP</option>
</select>

<select class="column_type" name="type_1" id="type_1" style="display:block; width:auto">
<option>INT</option><option>VARCHAR</option><option>TEXT</option><option>DATE</option><optgroup label="NUMERIC"><option>TINYINT</option><option>SMALLINT</option><option>MEDIUMINT</option><option>INT</option><option>BIGINT</option><option disabled="disabled">-</option><option>DECIMAL</option><option>FLOAT</option><option>DOUBLE</option><option>REAL</option><option disabled="disabled">-</option><option>BIT</option><option>BOOLEAN</option><option>SERIAL</option></optgroup><optgroup label="DATE and TIME"><option>DATE</option><option>DATETIME</option><option>TIMESTAMP</option><option>TIME</option><option>YEAR</option></optgroup><optgroup label="STRING"><option>CHAR</option><option>VARCHAR</option><option disabled="disabled">-</option><option>TINYTEXT</option><option>TEXT</option><option>MEDIUMTEXT</option><option>LONGTEXT</option><option disabled="disabled">-</option><option>BINARY</option><option>VARBINARY</option><option disabled="disabled">-</option><option>TINYBLOB</option><option>MEDIUMBLOB</option><option>BLOB</option><option>LONGBLOB</option><option disabled="disabled">-</option><option>ENUM</option><option>SET</option></optgroup><optgroup label="SPATIAL"><option>GEOMETRY</option><option>POINT</option><option>LINESTRING</option><option>POLYGON</option><option>MULTIPOINT</option><option>MULTILINESTRING</option><option>MULTIPOLYGON</option><option>GEOMETRYCOLLECTION</option></optgroup>
</select>
</td></tr></table>
<br>
<input type="button" onClick="add_another_input();" value="Add another field">
<input type="button" onClick="remove_input();" value="Remove last field">

<input name="Submit" type="Submit" value="Submit">

</form>
</td>
<td>&nbsp;&nbsp;</td>

<td>
<h3>Select a database table to create from:</h3>
<form action="action_class_creator.php" method="post">


<select name="selected_table" id="selected_table" onChange="updateSelected(this.value)">
<option value="" selected="selected"></option>
<?php
$dm = new DataManager();

$sql = "Show tables from " . $dbname;
	$result = $dm->queryRecords($sql);
while ($row = mysql_fetch_row($result)) {
 echo '<option value="'. $row[0] . '">' . $row[0] . '</option>';
}
?>
</select>
<br>
<input type="button" value="Create Class File" onClick='$( "#class_create" ).dialog( "open" )' /><br>
<input type="button" value="Create Edit Form" onClick="trigger_download('action_edit_form_creator.php?selected_table=')" /><br>
<input type="button" value="Create ACTION EDIT File" onClick="trigger_download('action_action_edit_creator.php?selected_table=')" /><br>
<input type="button" value="Create ACTION DELETE File" onClick="trigger_download('action_action_delete_creator.php?selected_table=')" /><br>


<!--<input name="Submit" type="Submit" value="Submit">-->

</form>
</td>
</tr>
</table>

</div>
</body>
</html>
