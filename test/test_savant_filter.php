<?php
require '../Savant3/Savant3/Filter.php';
class Savant3_Filter_num2words extends Savant3_Filter {
  public static function filter($buffer) {
    $search = array("<dynamic>","</dynamic>");
    $replace = array('<?php ',' ?>');
    $buffer = str_replace($search, $replace, $buffer);
    return $buffer;
  }
}

// include class
require '../Savant3/Savant3.php';

// set options
$options = array(
  'template_path' => '../templates/Bootstrap',
);

// initialize template engine
$savant = new Savant3($options);

// add filter
$savant->addFilters(array('Savant3_Filter_num2words', 'filter'));

  header('Content-disposition: attachment; filename=test_list.php');
  header ("Content-Type:text/php");  
  
// set template variable and render template
$savant->display('list.tpl');
?>