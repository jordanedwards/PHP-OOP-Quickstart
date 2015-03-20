<?php
// DROPDOWN CLASS
// This dropdown class allows the easy creation of a form select populated from a database table
// You may create one object, then call the method for each drop down in the page, supplying different arguments to each.
// You may pass a class name in the constructor.

// get_dropdown arguments: (there are lots, but you only have to put in the first 4 if you want)
// 1) Name you want for the select element.
// 2) Id you want for the select element.
// 3) Database table name.
// 4) Database table field that you would like to use as the text for your select options. This also populates the order by. Currently, only one field may be used.
// 5) Selected value: pass the current value of the field to show the correct option selected. (optional)
// 6) true/false argument for whether you want to show ALL records, or just those flagged as active. (optional)
// 7) true/false argument for whether you would like the field to be a required input. (optional)
// 8) onchange event: Just put in here whatever you would like as the onchange event (optional)
// 9) Order By direction. Default is ASC, but you may want DESC, it's a free country.
// 10) Custom SQL statement. If you need a table join or something funky, write it yourself and stick it in. just_show_active, order, and table_name arguments won't matter (because you overwrote them)

// Syntax:
//  require_once($class_folder . "/class_drop_downs.php");
//  $dd_session = New DropDown();
//	echo $dd_session->get_dropdown("testDropdown","testDropDownId","user","user_first_name","6",false,false,"goto(here);","DESC");

// To use, cut and paste this in as a template:
// echo $dd_object->get_dropdown("drop-down-name","drop-down-id","table-name","display-field","selected-value", Just show active? true or false, Required? true or false, "onchange text", "order ASC or DESC", "custom SQL statement");

// Notes:
//  - Please be aware that to use the "just_show_active" argument, there must be a field in the table called "is_active" with a simple 1/0 or boolean value 
//  - This function finds the index field to get the unique ID to pass as the selected value. That means your table must have an index (duh), and if you wanted to pass a different field as the selected value I can't help you for now.

class DropDown {

	private $className;
	
	function __construct($class_name="", $preset="") {
      $this->className = $class_name;
	}

	public function get_dropdown($name, $id, $table_name, $name_field, $selected_value="None", $just_show_active=false, $required=false, $onchange = '', $order="ASC", $customSQL=""){
	if (isset($table_name)):
		try{
			//Find index field:
			$dm = new DataManager();
			$sql = 'SHOW INDEXES FROM ' . $table_name . ' WHERE Key_name = "PRIMARY" OR Key_name = "UNIQUE"';
			$indexResult = $dm->queryRecords($sql);
			$num_rows_index = mysql_num_rows($indexResult);
			
			if ($num_rows_index > 0){
			while ($row = mysql_fetch_array($indexResult, MYSQL_ASSOC)) {
				$index_name = $row['Column_name'];
			}
			} else {
				$index_name	= $table_name . "_id";
			}
		
			$strSQL = "SELECT * FROM " . $table_name;
			// Just show active records: requires a field named "is_active";
			$strSQL .= ($just_show_active ? " WHERE is_active = 1" : "");
			// Order by field is set:
			$strSQL .= ($name_field != "" ? " ORDER BY " . $name_field . " " . $order : "");
			
			if ($customSQL != ""){
				$strSQL = $customSQL;
			}
			
			$cssClass = ($required ? ' class="{validate:{required:true}} ' . $this->className .' "' : " class='". $this->className . "'");

			$dm = new DataManager();
			$result = $dm->queryRecords($strSQL);	
			$num_rows = mysql_num_rows($result);	
			if ($num_rows != 0){
				
				$ddl = '<select id="'.$id.'" name="'.$name.'" ' . $cssClass. ' onchange="'.$onchange.'" ">';
				$ddl .= "<option value=''></option>";
				
				while($row = mysql_fetch_assoc($result)) {
					$ddl .= '<option value="'.$row[$index_name].'" ';
					if($row[$index_name]==$selected_value){
						$ddl .= 'selected="selected"';
					}
					$ddl .= '>'.$row[$name_field].'</option>';
				}
				$ddl .= '</select>';
				
				return $ddl;
			}else{
				return null;
				exit;
			}			
		}
		catch(Exception $e) {
			// CATCH EXCEPTION HERE -- DISPLAY ERROR MESSAGE & EMAIL ADMINISTRATOR
			include_once($classes_folder . '/class_error_handler.php');
			$errorVar = new ErrorHandler();
			$errorVar->notifyAdminException($e);
			exit;
		}	
	endif;		
	}  

}

?>