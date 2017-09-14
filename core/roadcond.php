<?php
		session_start();
		$roadcondStart = $_SESSION['startstep'];
		$stepLength = 6;
		$data[] = array();
		$i=0;
		$f=false;
		$handle = fopen("data.txt", "r");
		$vel_last = 0;
		if ($handle) {
		    while (($line = fgets($handle)) !== false and $f==false) {
		    	$i = $i + 1;
		    	if($i>($roadcondStart*$stepLength+510)) $f=true;
		        $row = explode("	", $line);
		        $row[0] = explode(" ", $row[0]);

		        $acc = ($row[3] - $vel_last) * 0.0447;
		        $vel_last = $row[3];
		        $k = $row[2] / $row[3] * 360;
		        $kt = $k * $row[6] / 100;
		        $roadcond = 55 / $row[3];
		        $emm = $kt*((0.0095*($acc*$acc)+(0.0022*$acc)+
		        	(5*0.000001*($row[3]*$row[3]))-(0.0005*$row[3])+0.0245));

		        array_push($row,$acc,$k,$kt,$roadcond,$emm);	
		        array_push($data,$row);
		      
		    }
/* DATA FILE CONVENTION
    0	    1	 2		3	4	5	6	  7			  8   9 10 11       12
    DATE	LANE VOLUME	VEL	OCC	MID	LARGE SENSOR-TIME ACC K KT ROADCOND EMM
    0       1       2
    Date    Hour    AM/PM
*/

		    fclose($handle);
		} else {
			print_r("Error opening the sensor data file.");
		    // error opening the file.
		} 


		$plotdata = array();
		$plotentry[] = array();
		$labelwidth = 50;

		//smooth
		$smooth = array();



		for($i=$roadcondStart * $stepLength; $i<(500 + $roadcondStart * $stepLength); $i++){
			if(($i + 2)%$labelwidth == 0){ // time stamp
			$plotentry = array($data[$i][0][1]);}
			else {
			$plotentry = array("");

			}


			// SMOOTH ALGORITHM
			array_push($smooth, $data[$i][11]);
			$smoothsize = sizeof($smooth);
			if($smoothsize>10){
				for($c=1;$c<=10;$c++){
					$smoothedvalue = $smoothedvalue + $smooth[$smoothsize-$c];
				}
				$smoothedvalue = $smoothedvalue / 10;
				array_push($plotentry,$smoothedvalue);
			} else {
				array_push($plotentry,$data[$i][11]);
			}


			array_push($plotdata,$plotentry);


			
		}

		// Cut out first few unsmoothed points
		$plotdata = array_slice($plotdata, 20);



		require_once 'phplot.php';
		$plot1 = new PHPlot(600,400);
		$plot1->SetTitle("");

		$plot1->SetFontTTF('title', '../fonts/SF.ttf', 12);
		$plot1->SetFontTTF('x_label', '../fonts/SF.ttf', 12);
		$plot1->SetFontTTF('y_label', '../fonts/SF.ttf', 12);
		$plot1->SetPlotType('lines');
		$plot1->SetDataType('text-data');
		$plot1->SetDataColors(array('maroon', 'green', 'blue'));

		$plot1->SetDataValues($plotdata);
		$plot1->SetXTickPos('none');
		$plot1->SetXTickLabelPos('none');
		$plot1->DrawGraph();