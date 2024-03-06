<?php
/**
 * Get the base path
 * 
 * @param string $path
 * @return $string
 */

 function basePath($path=''){
    return __DIR__.'/'.$path;

 }
/**
 * Load a view 
 * 
 * @param string $name
 * @return void
 */
function loadView($name, $data=[]){

    $viewPath= basePath("views/{$name}.view.php");
    // inspectExit($viewPath);
    if(file_exists("$viewPath")){
        extract($data);
        require_once($viewPath);
    } else {
        echo "view '{$name} not found!' ";
    }

}

/**
 * Load a view 
 * 
 * @param string $name
 * @return void
 */
function loadPartial($name){
$partialview=basePath("views/partials/{$name}.php");
       
if(file_exists("$partialview")){
    require_once($partialview);
} else {
    echo "Partial '{$name} not found!' ";
}
}
/**
 * Inspect a values and die
 * 
 * @param mixed $value
 * 
 * @return void 
 * 
 */

 function inspect($value){
    echo '<pre>';
    die(var_dump($value));

    echo '</pre>';

 }
 
function salary($salary){
    return '$'. number_format(floatval($salary));
}

?>

