<?php
//Include the code
require_once 'phplot.php';

//Define the object
$plot = new PHPlot();

//Define some data

$plot->SetDataValues($example_data);

//Turn off X axis ticks and labels because they get in the way:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');

//Draw it
$plot->DrawGraph();
?>