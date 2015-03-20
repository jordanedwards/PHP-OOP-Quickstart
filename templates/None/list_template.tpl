<table><tr><?php
foreach($this->field_names as $key => $val){
	if ($key == $this->index_name){
		echo '<th class="nosort"></th>';
	} else {
		echo '<th class="sort_column" id="' . $key  . '" nowrap="nowrap">' . ucfirst($val) . '</th>';
	}
}	
?><th></th></tr>
<tr><?php
foreach($this->field_names as $key => $val){
	if ($key == $this->index_name){
		echo '<td align="left"><a href="' . $this->selected_table . '_edit.php?id={' . $key . '}"><img src="/invoices/images/edit.png" alt="Edit" border="0" /></a></td>';
	} else {
		echo '<td>{' . $key . '}</td>';
	}
}
echo '<td align="center"><a href="/invoices/actions/action_' . $this->selected_table . '_edit.php?action=delete&id={' . $this->index_name . '}" onclick="return confirm(\'You are about to delete a ' . $this->selected_table . ' from the system. Do you want to continue?\');"><img src="/invoices/images/delete.gif" alt="Delete" border="0" /></a></td>';
?></tr>
</table><br />