<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['num']))
{

    $homepage = file_get_contents('http://176.139.39.51/drawing/xor.data');


    $array = explode(" ",$homepage);
    $num =$array[0] + 1 ;


    $homepage = substr($homepage,strlen($array[0]),-1);
    $homepage = $num. $homepage;




    $binnum = decbin($_POST['num']);
    $num= strlen($binnum);
    if($num == 3){
        $binnum = '0'.$binnum;
    }
    if($num == 2){
        $binnum = '00'.$binnum;
    }
    if($num == 1){
        $binnum = '000'.$binnum;
    }

    $binnum = implode(' ', str_split($binnum));
    $bin='';
    $binarray=array();
    for($i=1;$i<=400;$i++) {

        if (isset($_POST[$i])) {
            array_push($binarray,1);

            $bin .= '1 ';
        }
        else{

            $bin .= '0 ';
            array_push($binarray,0);
        }
    }
    $homepage.="\n";
    foreach($binarray as $bin){
        $homepage .=$bin." ";

    }
    $homepage.="\n";
    $homepage.=$binnum."\n";
   // echo $homepage;
    file_put_contents('xor.data',  $homepage);

    $num_input = 400;
    $num_output = 4;
    $num_layers = 3;
    $num_neurons_hidden = 100;
    $desired_error = 0.001;
    $max_epochs = 500000;
    $epochs_between_reports = 1000;

    $ann = fann_create_standard($num_layers, $num_input, $num_neurons_hidden, $num_output);

    if ($ann) {
        fann_set_activation_function_hidden($ann, FANN_SIGMOID_SYMMETRIC);
        fann_set_activation_function_output($ann, FANN_SIGMOID_SYMMETRIC);

        $filename = dirname(__FILE__) . "/xor.data";
        if (fann_train_on_file($ann, $filename, $max_epochs, $epochs_between_reports, $desired_error))
            fann_save($ann, dirname(__FILE__) . "/xor_float.net");

        fann_destroy($ann);
    }
    ?>
<script>

    document.location.href="index.php";
</script>
<?php
}
