<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
<head>
<meta charset=utf-8 />
<title>Quickstart</title>

<link rel="stylesheet" href="http://necolas.github.io/normalize.css/2.1.3/normalize.css">
<link rel="stylesheet" href="css/jquery.idealforms.css">
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<link href="css/custom.css" rel="stylesheet">

  <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
  <script src="js/out/jquery.idealforms.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>

  <!--<script src="js/out/jquery.idealforms.min.js"></script>-->
<style>
  body {
    max-width: 980px;
    margin: 2em auto;
    font: normal 15px/1.5 Arial, sans-serif;
    color: #353535;
    overflow-y: scroll;
  }
  .content {
    margin: 0 30px;
  }

  .field.buttons button {
    margin-right: .5em;
  }

  #invalid {
    display: none;
    float: left;
    width: 290px;
    margin-left: 120px;
    margin-top: .5em;
    color: #CC2A18;
    font-size: 130%;
    font-weight: bold;
  }

  .idealforms.adaptive #invalid {
    margin-left: 0 !important;
  }

  .idealforms.adaptive .field.buttons label {
    height: 0;
  }
  form.idealforms label.main {
		width: 160px;
	}
	.navbar-inverse .navbar-nav>li>a {
color: #000;
background-color: #DDAB30;
}
.ui-widget {
    font: normal 15px/1.5 Arial, sans-serif;
/* font-size: 1.1em; */
}

</style>

<script>
   function loadProject(projectName) {
          $.getJSON('projects/'+projectName, function(jd) {
             $('#settings_application_name').val(jd.settings_application_name);		
			 $('#settings_email').val(jd.settings_email);		  
			 $('#settings_timezone').val(jd.settings_timezone);
			 $('#settings_framework').val(jd.settings_framework);
			 $('#dev_use').val(jd.dev_use);			 			 		 
			 $('#dev_dbname').val(jd.dev_dbname);			 
			 $('#dev_dbuser').val(jd.dev_dbuser);
			 $('#dev_dbpass').val(jd.dev_dbpass);			 
			 $('#dev_dbhost').val(jd.dev_dbhost);
			 $('#pro_use').val(jd.pro_use);			 			 		 			 			 
			 $('#pro_dbname').val(jd.pro_dbname);			 
			 $('#pro_dbuser').val(jd.pro_dbuser);
			 $('#pro_dbpass').val(jd.pro_dbpass);			 
			 $('#pro_dbhost').val(jd.pro_dbhost);
			 $('#local_use').val(jd.local_use);			 			 		 			 	
			 $('#local_dbname').val(jd.local_dbname);			 
			 $('#local_dbuser').val(jd.local_dbuser);
			 $('#local_dbpass').val(jd.local_dbpass);			 
			 $('#local_dbhost').val(jd.local_dbhost);
			 
			 var selEnvDD = '<select name="selected_environment" id="selected_environment" onChange="updateSelected(this.value)"><option value="" selected="selected"></option>';
			 if (jd.dev_use	== 1){
				 selEnvDD = selEnvDD + "<option value='Development'>Development</option>";
			 }
			 if (jd.pro_use	== 1){
				 selEnvDD = selEnvDD + "<option value='Production'>Production</option>";
			 }			 
			 if (jd.local_use == 1){
				 selEnvDD = selEnvDD + "<option value='Local'>Local</option>";
			 }		
			 selEnvDD = selEnvDD + "</select>";
			 $("#selected_environment").html(selEnvDD);
		});
      };
   </script>
   <script>
	function updateEnvironment(environment) {
		if (environment == "Development"){
			var dbname = $('#dev_dbname').val();
			var dbuser = $('#dev_dbuser').val();
			var dbpass = $('#dev_dbpass').val();
			var dbhost = $('#dev_dbhost').val();
		}else if(environment == "Production"){
			var dbname = $('#pro_dbname').val();
			var dbuser = $('#pro_dbuser').val();
			var dbpass = $('#pro_dbpass').val();
			var dbhost = $('#pro_dbhost'.val());
		}else if(environment == "Local"){
			var dbname = $('#local_dbname').val();
			var dbuser = $('#local_dbuser').val();
			var dbpass = $('#local_dbpass').val();
			var dbhost = $('#local_dbhost').val();
		}
		
		$('#selected_db_name').val(dbname);
		$('#selected_db_user').val(dbuser);
		$('#selected_db_pass').val(dbpass);
		$('#selected_db_host').val(dbhost);
		
		$.ajax({
		url:"ajax/ajax_show_tables.php?db_name="+dbname+"&db_user="+dbuser+"&db_pass="+dbpass+"&db_host="+dbhost,
		success: function (html) {	
			$('#selected_table').html(html);		
		}	
		});
	}
</script>
<?php
 
function generate_timezone_list()
{
    static $regions = array(
        DateTimeZone::AFRICA,
        DateTimeZone::AMERICA,
        DateTimeZone::ANTARCTICA,
        DateTimeZone::ASIA,
        DateTimeZone::ATLANTIC,
        DateTimeZone::AUSTRALIA,
        DateTimeZone::EUROPE,
        DateTimeZone::INDIAN,
        DateTimeZone::PACIFIC,
    );
 
    $timezones = array();
    foreach( $regions as $region )
    {
        $timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
    }
 
    $timezone_offsets = array();
    foreach( $timezones as $timezone )
    {
        $tz = new DateTimeZone($timezone);
        $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
    }
 
    // sort timezone by timezone name
    ksort($timezone_offsets);
 
    $timezone_list = array();
    foreach( $timezone_offsets as $timezone => $offset )
    {
       
        $t = new DateTimeZone($timezone);
        $c = new DateTime(null, $t);
        $current_time = $c->format('g:i A');
 
        $timezone_list[$timezone] = "$timezone - $current_time";
    }
 
    return $timezone_list;
}
?>
<script>

function add_another_input() 
{
	
	var i = $(".line_item").length+1;
    var table_name = document.getElementById('table_name').value;

  var newElement = "<tr><td><span class='table_prefix'>"+table_name+"_</span><input name='field_"+i+"' type='text' class='line_item'></td><td><select class='column_type' name='type_"+i+"' style='display:block; width:auto'><option selected='selected'></option><option>INT</option><option>VARCHAR</option><option>TEXT</option><option>DATE</option><optgroup label='NUMERIC'><option>TINYINT</option><option>SMALLINT</option><option>MEDIUMINT</option><option>INT</option><option>BIGINT</option><option disabled='disabled'>-</option><option>DECIMAL</option><option>FLOAT</option><option>DOUBLE</option><option>REAL</option><option disabled='disabled'>-</option><option>BIT</option><option>BOOLEAN</option><option>SERIAL</option></optgroup><optgroup label='DATE and TIME'><option>DATE</option><option>DATETIME</option><option>TIMESTAMP</option><option>TIME</option><option>YEAR</option></optgroup><optgroup label='STRING'><option>CHAR</option><option>VARCHAR</option><option disabled='disabled'>-</option><option>TINYTEXT</option><option>TEXT</option><option>MEDIUMTEXT</option><option>LONGTEXT</option><option disabled='disabled'>-</option><option>BINARY</option><option>VARBINARY</option><option disabled='disabled'>-</option><option>TINYBLOB</option><option>MEDIUMBLOB</option><option>BLOB</option><option>LONGBLOB</option><option disabled='disabled'>-</option><option>ENUM</option><option>SET</option></optgroup><optgroup label='SPATIAL'><option>GEOMETRY</option><option>POINT</option><option>LINESTRING</option><option>POLYGON</option><option>MULTIPOINT</option><option>MULTILINESTRING</option><option>MULTIPOLYGON</option><option>GEOMETRYCOLLECTION</option></optgroup></select></td></tr>";
  
	$("#field_list").append(newElement);

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
	
	$('.table_prefix').html(new_table_name+"_");
	
}

</script>
</head>
<body>
<?php require("header_boot.php");

?>
<div class="container">
      <div class="row">
        <div class="col-md-12">
  <div class="content">

    <div class="idealsteps-container">

      <nav class="idealsteps-nav"></nav>


        <div class="idealsteps-wrap">

          <!-- Step 1 -->
		        <form action="actions/config_action.php" novalidate autocomplete="on" class="idealforms" method="post">


          <section class="idealsteps-step" name="Settings">
            <div class="field">
              <label class="main">Application name:</label>
              <input name="settings_application_name" id="settings_application_name" type="text" >
              <span class="error"></span>
            </div>

            <div class="field">
              <label class="main">Admin Email:</label>
              <input name="settings_email" id="settings_email" type="email">
              <span class="error"></span>
            </div>

            <div class="field">
              <label class="main">Timezone:</label>
              <select name="settings_timezone" id="settings_timezone">
				<?php 
				$tz_array = generate_timezone_list();
				foreach ($tz_array as $key => $val){
					if (ini_get('date.timezone') == $key){
						echo '<option value="' . $key . '" selected=selected>' . $val . '</option>
					';} else {
						echo '<option value="' . $key . '">' . $val . '</option>
					';}
				}?>
				</optgroup>
              </select>
              <span class="error"></span>
            </div>

            <div class="field">
              <label class="main">Framework:</label>
              <p class="group">
                <label><input name="settings_framework" id="settings_framework" type="radio" value="oop" checked>Object-Oriented PHP</label>
                <label><input name="settings_framework" id="settings_framework" type="radio" value="zend">Zend</label>
              </p>
              <span class="error"></span>
            </div>

  <div class="field">
                <label class="main">Database set up:</label>
<label>
<div id="accordion">
           <h3>Development Environment:</h3>
		   <div>
                <label><input name="dev_use" id="dev_use" type="checkbox" value="1">Use</label><br>		  
				<label style="line-height:1">DB Name:&nbsp;<input name="dev_dbname" id="dev_dbname" type="text" style="width:150px"></label><br>
				<label style="line-height:1">DB User:&nbsp;<input name="dev_dbuser" id="dev_dbuser" type="text" style="width:150px"></label><br>
				<label style="line-height:1">DB Pass:&nbsp;<input name="dev_dbpass" id="dev_dbpass" type="text" style="width:150px"></label><br>
				<label style="line-height:1">DB Host:&nbsp;<input name="dev_dbhost" id="dev_dbhost" type="text" style="width:150px"></label>
</div>
   
            <h3>Production Environment:</h3>
              <div>
                <label><input name="pro_use" id="pro_use" type="checkbox" value="1">Use</label><br>			  
				<label style="line-height:1">DB Name:&nbsp;<input name="pro_dbname" id="pro_dbname" type="text" style="width:150px"></label><br>
				<label style="line-height:1">DB User:&nbsp;<input name="pro_dbuser" id="pro_dbuser" type="text" style="width:150px"></label><br>
				<label style="line-height:1">DB Pass:&nbsp;<input name="pro_dbpass" id="pro_dbpass" type="text" style="width:150px"></label><br>
				<label style="line-height:1">DB Host:&nbsp;<input name="pro_dbhost" id="pro_dbhost" type="text" style="width:150px"></label>				
            </div>

            <h3>Local Environment:</h3>
              <div>
                <label><input name="local_use" id="local_use" type="checkbox" value="1">Use</label><br>			  
				<label style="line-height:1">DB Name:&nbsp;<input name="local_dbname" id="local_dbname" type="text" style="width:150px"></label><br>
				<label style="line-height:1">DB User:&nbsp;<input name="local_dbuser" id="local_dbuser" type="text" style="width:150px" value="root"></label><br>
				<label style="line-height:1">DB Pass:&nbsp;<input name="local_dbpass" id="local_dbpass" type="text" style="width:150px"></label><br>
				<label style="line-height:1">DB Host:&nbsp;<input name="local_dbhost" id="local_dbhost" type="text" style="width:150px" value="localhost"></label>				

            </div
>
<input type="hidden" name="selected_db_name" id="selected_db_name">
<input type="hidden" name="selected_db_user" id="selected_db_user">
<input type="hidden" name="selected_db_pass" id="selected_db_pass">
<input type="hidden" name="selected_db_host" id="selected_db_host">

</div>
</label>

</div>
            <div class="field buttons">
			<br>
              <label class="main">&nbsp;</label>
              <button type="submit" name="Generate" value="1">Save Project &raquo;</button>
            </div>

          </section>

          <!-- Step 2 -->

          <section class="idealsteps-step" name="SQL Generator">

            <div class="field">
              <label class="main">Table name:</label>
              <input name="table_name" id="table_name" type="text" onChange="update_table_name();" >
			  <span id="err_msg"></span>
              <span class="error"></span>
            </div>

            <div class="field">
              <label class="main">Fields:</label>
			  <table id="field_list">
			  	<tr><td><span class="table_prefix"></span><input name="field_1" value="id" disabled="disabled" class='line_item'></td><td><select class="column_type" name="type_1" style="display:block; width:auto" disabled="disabled">
<option selected="selected">INT</option><option>VARCHAR</option><option>TEXT</option><option>DATE</option><optgroup label="NUMERIC"><option>TINYINT</option><option>SMALLINT</option><option>MEDIUMINT</option><option>INT</option><option>BIGINT</option><option disabled="disabled">-</option><option>DECIMAL</option><option>FLOAT</option><option>DOUBLE</option><option>REAL</option><option disabled="disabled">-</option><option>BIT</option><option>BOOLEAN</option><option>SERIAL</option></optgroup><optgroup label="DATE and TIME"><option>DATE</option><option>DATETIME</option><option>TIMESTAMP</option><option>TIME</option><option>YEAR</option></optgroup><optgroup label="STRING"><option>CHAR</option><option>VARCHAR</option><option disabled="disabled">-</option><option>TINYTEXT</option><option>TEXT</option><option>MEDIUMTEXT</option><option>LONGTEXT</option><option disabled="disabled">-</option><option>BINARY</option><option>VARBINARY</option><option disabled="disabled">-</option><option>TINYBLOB</option><option>MEDIUMBLOB</option><option>BLOB</option><option>LONGBLOB</option><option disabled="disabled">-</option><option>ENUM</option><option>SET</option></optgroup><optgroup label="SPATIAL"><option>GEOMETRY</option><option>POINT</option><option>LINESTRING</option><option>POLYGON</option><option>MULTIPOINT</option><option>MULTILINESTRING</option><option>MULTIPOLYGON</option><option>GEOMETRYCOLLECTION</option></optgroup>
</select></td></tr>
			  	<tr><td><span class="table_prefix"></span><input name="field_2" value="date_created" disabled="disabled" class='line_item'></td><td><select class="column_type" name="type_2" style="display:block; width:auto" disabled="disabled">
<option>INT</option><option>VARCHAR</option><option>TEXT</option><option>DATE</option><optgroup label="NUMERIC"><option>TINYINT</option><option>SMALLINT</option><option>MEDIUMINT</option><option>INT</option><option>BIGINT</option><option disabled="disabled">-</option><option>DECIMAL</option><option>FLOAT</option><option>DOUBLE</option><option>REAL</option><option disabled="disabled">-</option><option>BIT</option><option>BOOLEAN</option><option>SERIAL</option></optgroup><optgroup label="DATE and TIME"><option selected="selected">DATE</option><option>DATETIME</option><option>TIMESTAMP</option><option>TIME</option><option>YEAR</option></optgroup><optgroup label="STRING"><option>CHAR</option><option>VARCHAR</option><option disabled="disabled">-</option><option>TINYTEXT</option><option>TEXT</option><option>MEDIUMTEXT</option><option>LONGTEXT</option><option disabled="disabled">-</option><option>BINARY</option><option>VARBINARY</option><option disabled="disabled">-</option><option>TINYBLOB</option><option>MEDIUMBLOB</option><option>BLOB</option><option>LONGBLOB</option><option disabled="disabled">-</option><option>ENUM</option><option>SET</option></optgroup><optgroup label="SPATIAL"><option>GEOMETRY</option><option>POINT</option><option>LINESTRING</option><option>POLYGON</option><option>MULTIPOINT</option><option>MULTILINESTRING</option><option>MULTIPOLYGON</option><option>GEOMETRYCOLLECTION</option></optgroup>
</select></td></tr>
			  	<tr><td><span class="table_prefix"></span><input name="field_3" value="last_updated" disabled="disabled" class='line_item'></td><td><select class="column_type" name="type_3" style="display:block; width:auto" disabled="disabled">
<option>INT</option><option>VARCHAR</option><option>TEXT</option><option>DATE</option><optgroup label="NUMERIC"><option>TINYINT</option><option>SMALLINT</option><option>MEDIUMINT</option><option>INT</option><option>BIGINT</option><option disabled="disabled">-</option><option>DECIMAL</option><option>FLOAT</option><option>DOUBLE</option><option>REAL</option><option disabled="disabled">-</option><option>BIT</option><option>BOOLEAN</option><option>SERIAL</option></optgroup><optgroup label="DATE and TIME"><option selected="selected">DATE</option><option>DATETIME</option><option>TIMESTAMP</option><option>TIME</option><option>YEAR</option></optgroup><optgroup label="STRING"><option>CHAR</option><option>VARCHAR</option><option disabled="disabled">-</option><option>TINYTEXT</option><option>TEXT</option><option>MEDIUMTEXT</option><option>LONGTEXT</option><option disabled="disabled">-</option><option>BINARY</option><option>VARBINARY</option><option disabled="disabled">-</option><option>TINYBLOB</option><option>MEDIUMBLOB</option><option>BLOB</option><option>LONGBLOB</option><option disabled="disabled">-</option><option>ENUM</option><option>SET</option></optgroup><optgroup label="SPATIAL"><option>GEOMETRY</option><option>POINT</option><option>LINESTRING</option><option>POLYGON</option><option>MULTIPOINT</option><option>MULTILINESTRING</option><option>MULTIPOLYGON</option><option>GEOMETRYCOLLECTION</option></optgroup>
</select></td></tr>
			  	<tr><td><span class="table_prefix"></span><input name="field_4" value="last_updated_user" disabled="disabled" class='line_item'></td><td><select class="column_type" name="type_4" style="display:block; width:auto" disabled="disabled">
<option>INT</option><option selected="selected">VARCHAR</option><option>TEXT</option><option>DATE</option><optgroup label="NUMERIC"><option>TINYINT</option><option>SMALLINT</option><option>MEDIUMINT</option><option>INT</option><option>BIGINT</option><option disabled="disabled">-</option><option>DECIMAL</option><option>FLOAT</option><option>DOUBLE</option><option>REAL</option><option disabled="disabled">-</option><option>BIT</option><option>BOOLEAN</option><option>SERIAL</option></optgroup><optgroup label="DATE and TIME"><option >DATE</option><option>DATETIME</option><option>TIMESTAMP</option><option>TIME</option><option>YEAR</option></optgroup><optgroup label="STRING"><option>CHAR</option><option>VARCHAR</option><option disabled="disabled">-</option><option>TINYTEXT</option><option>TEXT</option><option>MEDIUMTEXT</option><option>LONGTEXT</option><option disabled="disabled">-</option><option>BINARY</option><option>VARBINARY</option><option disabled="disabled">-</option><option>TINYBLOB</option><option>MEDIUMBLOB</option><option>BLOB</option><option>LONGBLOB</option><option disabled="disabled">-</option><option>ENUM</option><option>SET</option></optgroup><optgroup label="SPATIAL"><option>GEOMETRY</option><option>POINT</option><option>LINESTRING</option><option>POLYGON</option><option>MULTIPOINT</option><option>MULTILINESTRING</option><option>MULTIPOLYGON</option><option>GEOMETRYCOLLECTION</option></optgroup>
</select></td></tr>
			  	<tr><td><span class="table_prefix"></span><input name="field_5" type="text" class='line_item'></td><td><select class="column_type" name="type_5" style="display:block; width:auto"><option selected="selected"></option>
<option>INT</option><option>VARCHAR</option><option>TEXT</option><option>DATE</option><optgroup label="NUMERIC"><option>TINYINT</option><option>SMALLINT</option><option>MEDIUMINT</option><option>INT</option><option>BIGINT</option><option disabled="disabled">-</option><option>DECIMAL</option><option>FLOAT</option><option>DOUBLE</option><option>REAL</option><option disabled="disabled">-</option><option>BIT</option><option>BOOLEAN</option><option>SERIAL</option></optgroup><optgroup label="DATE and TIME"><option>DATE</option><option>DATETIME</option><option>TIMESTAMP</option><option>TIME</option><option>YEAR</option></optgroup><optgroup label="STRING"><option>CHAR</option><option>VARCHAR</option><option disabled="disabled">-</option><option>TINYTEXT</option><option>TEXT</option><option>MEDIUMTEXT</option><option>LONGTEXT</option><option disabled="disabled">-</option><option>BINARY</option><option>VARBINARY</option><option disabled="disabled">-</option><option>TINYBLOB</option><option>MEDIUMBLOB</option><option>BLOB</option><option>LONGBLOB</option><option disabled="disabled">-</option><option>ENUM</option><option>SET</option></optgroup><optgroup label="SPATIAL"><option>GEOMETRY</option><option>POINT</option><option>LINESTRING</option><option>POLYGON</option><option>MULTIPOINT</option><option>MULTILINESTRING</option><option>MULTIPOLYGON</option><option>GEOMETRYCOLLECTION</option></optgroup>
</select></td></tr>
			  </table>
			  </div>
			  	
            <div class="field buttons">
              <label class="main">&nbsp;</label>
				<button type="button" onClick="add_another_input();">Add another field</button>
				<button type="button" onClick="remove_input();">Remove last field</button>
				<button type="button" class="next">Create SQL &raquo;</button>
            </div>

          </section>

          <!-- Step 3 -->

          <section class="idealsteps-step" name="Class, Action, View files">

            <div class="field">
			<label class="main">Select Environment:</label>
			<select name="selected_environment" id="selected_environment" onChange="updateEnvironment(this.value)">
				<option value="" selected="selected"></option>
				</select>
              <span class="error"></span>
            </div>
			
            <div class="field">
			<label class="main">Select Table:</label>
			<select name="selected_table" id="selected_table" onChange="updateSelected(this.value)">
				<option value="" selected="selected"></option>
				<?php
		/*		$dm = new DataManager();

				$sql = "Show tables from " . $dbname;
				$result = $dm->queryRecords($sql);
				while ($row = mysql_fetch_row($result)) {
 					echo '<option value="'. $row[0] . '">' . $row[0] . '</option>';
				}*/
				?>
			</select>
              <span class="error"></span>
            </div>


            <div class="field">
              <label class="main">Create files:</label>
			  <table><tr><td>
				<button type="button" class="prev" onClick='$( "#base_create" ).dialog( "open" )' style="background: rgb(238, 163, 149); margin-bottom:10px;">&raquo; Project Base</button><button type="button" class="prev" style="background: rgb(194, 194, 221); margin-bottom:10px;">&raquo; Create All Files</button><br>			  
				<button type="button" class="prev" onClick='$( "#class_create" ).dialog( "open" )'>&raquo; Create Class File</button><br>
				<button type="button" class="prev" onClick="trigger_download('action_edit_form_creator.php?selected_table=')">&raquo; Create List View</button><br>
				<button type="button" class="prev">&raquo; Create Edit Form</button><br>
				<button type="button" class="prev" onClick="trigger_download('action_action_edit_creator.php?selected_table=')">&raquo; Create Edit Action File</button>	<br>					
				<button type="button" class="prev" onClick="trigger_download('action_action_delete_creator.php?selected_table=')">&raquo; Create Delete Action File</button><br><br>
				
				</td></tr></table>									
            </div>

<!--            <div class="field buttons">
              <label class="main">&nbsp;</label>
              <button type="button" class="prev">&laquo; Prev</button>
              <button type="submit" class="submit">Submit</button>
            </div>-->

          </section>

        </div>

        <span id="invalid"></span>

      </form>

    </div>

  </div>
	  	</div>
	</div>
</div>
<script>

    $('form.idealforms').idealforms({

      silentLoad: false,

  /*    rules: {
        'settings_application_name': 'required',
        'table_name': 'required',
        'selected_table': 'required',
        'selected_environment': 'required'	
      },*/

      errors: {
        'username': {
          ajaxError: 'Username not available'
        }
      },

	steps: {
  MY_stepsItems: ['Configuration', 'SQL Generator', 'Class, Action, View files'],
  buildNavItems: function(i) {
    return this.opts.steps.MY_stepsItems[i];
  }
}
    /*  , onSubmit: function(invalid, e) {
        e.preventDefault();
        $('#invalid')
          .show()
          .toggleClass('valid', ! invalid)
          .text(invalid ? (invalid +' invalid fields') : 'All good!');
      }*/
    });

    $('form.idealforms').find('input, select, textarea').on('change keyup', function() {
      $('#invalid').hide();
    });

    $('.prev').click(function(){
      $('.prev').show();
      $('form.idealforms').idealforms('prevStep');
    });
    $('.next').click(function(){
      $('.next').show();
      $('form.idealforms').idealforms('nextStep');
    });

  </script>
  <script>
  $(function() {
    $( "#accordion" ).accordion();
  });
  </script>
</body>
</html>
