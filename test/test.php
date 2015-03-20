
<?php
//print_r(glob("../*.*"));
echo $_SERVER['HTTP_HOST'];
?>
<br />
<select>
<?php
/*function listFolderFiles($dir){
$ffs = scandir($dir);
//echo '<ol>';
foreach($ffs as $ff){
    if($ff != '.' && $ff != '..' && is_dir($dir.'/'.$ff)){
        if(is_dir($dir.'/'.$ff)) {
			//echo '<optgroup label="'. $ff . '">';
	        echo '<option>'.$ff . '</option>';			
			listFolderFiles($dir.'/'.$ff);
			//echo '</optgroup>';
		}
    }
}
//echo '</ol>';
}

listFolderFiles('..');*/


?>
</select>

<?php
function listFolderFiles($dir){
$ffs = scandir($dir);
echo '<ul>';
foreach($ffs as $ff){
    if($ff != '.' && $ff != '..'){

        if(is_dir($dir.'/'.$ff)) {
        	echo '<li class="title">'.$ff . '</li>';
			listFolderFiles($dir.'/'.$ff);
		}
        
    }
}
echo '</ul>';
}

listFolderFiles('..');

?>