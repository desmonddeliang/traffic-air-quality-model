<?php 
	require_once("core/init.php");
	session_start();

	if(!$_SESSION['graphopt']){
		$graphopt = "emm";
	} else {
		$graphopt = $_SESSION['graphopt'];
	}
	
?>
<head>
<link href="css/style.css" rel="stylesheet">
</head>
<body>
<br>
	<h2>Road Condition</h2>
	(if 0 to 1 = free flow, if =1 at speed limit, if >1 road congestion)<br>
      <img src="core/roadcond.php" class="plot"><br>
		

      <br><br><br>

<?php
	switch ($graphopt) {
		case 'occ':
			echo "<h2>Road Occupancy</h2> (%)<br>";
			echo "<img src='core/occ.php' class='plot'></body>";
			break;
		case 'trafficvol':
			echo "<h2>Traffic Volume</h2> (Vehicle/10 seconds)<br>";
			echo "<img src='core/trafficvol.php' class='plot'></body>";
			break;
		case 'speed':
			echo "<h2>Vehicle Speed</h2> (mph)<br>";
			echo "<img src='core/speed.php' class='plot'></body>";
			break;
		default:
			echo "<h2>Emmision Factors</h2> (Trucks PM2.5 Emission Factors per road segment [g/mi] at every sensor-record)<br>";
			echo "<img src='core/emm.php' class='plot'></body>";

			break;
	}

?>

<br><br>
<div class="static">
Website refresh rate: every 5 seconds <br>
Data displayed for lane #1 on I-465 S (Indianapolis, IN), September 2006 <br>
Traffic Sensor collection rate: 1 record every 10 seconds <br>
Traffic Sensor: Wavetronix <br>
Plots are smoothed using "Moving Average" (period = 6 records) <br>
Trucks: defined as vehicles > 30 ft in length, measured by the sensor <br>
</div>
</body>

     