<?php
$bin='';
$binarray=array();
for($i=1;$i<=400;$i++) {
    
    if (isset($_GET[$i])) {
        array_push($binarray,1);

$bin .= '1 ';
    }
    else{

        $bin .= '0 ';
        array_push($binarray,0);
    }
}
$train_file = (dirname(__FILE__) . "/xor_float.net");
if (!is_file($train_file))
    die("The file xor_float.net has not been created! Please run simple_train.php to generate it");

$ann = fann_create_from_file($train_file);
if (!$ann)
    die("ANN could not be created");


$calc_out = fann_run($ann, $binarray);


$reponse = '';
foreach ($calc_out as $out){
    if($out > 0.5){
        $out = 1;
    }
    else{
        $out = 0;
    }

    $reponse .= $out;
}
$rep=bindec($reponse);
if(bindec($reponse)>9){
    $rep='?';
}
echo '<h1>'.$rep.'</h1>';

fann_destroy($ann);

?>