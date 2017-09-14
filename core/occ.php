<?php
/* DATA FILE CONVENTION
    0	    1	 2		3	4	5	6	  7			  8   9 10 11       12
    DATE	LANE VOLUME	VEL	OCC	MID	LARGE SENSOR-TIME ACC K KT ROADCOND EMM
    0       1       2
    Date    Hour    AM/PM
*/

		session_start();
		$emmStart = $_SESSION['startstep'];
		$stepLength = 6;
		$data[] = array();
		$i=0;
		$f=false;
		$handle = fopen("data.txt", "r");
		$vel_last = 0;
		if ($handle) {
		    while (($line = fgets($handle)) !== false and $f==false) {
		    	$i = $i + 1;
		    	if($i>($emmStart*$stepLength+510)) $f=true;
		        $row = explode("	", $line);
		        $row[0] = explode(" ", $row[0]);

		        //Calculations
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



		    fclose($handle);
		} else {
			print_r("Error opening the sensor data file.");
		    // error opening the file.
		} 


		$plotdata = array();
		$plotentry[] = array();
		$labelwidth = 50;
		$smooth = array();


		$shit = $emmStart * D_STEP;
		for($i=$emmStart * $stepLength; $i<(500 + $emmStart * $stepLength); $i++){
			if(($i + 2)%$labelwidth == 0){
			$plotentry = array($data[$i][0][1]);}
			else {
			$plotentry = array("");

			}
			// SMOOTH ALGORITHM
			array_push($smooth, $data[$i][4]);
			$smoothsize = sizeof($smooth);
			if($smoothsize>20){
				for($c=1;$c<=20;$c++){
					$smoothedvalue = $smoothedvalue + $smooth[$smoothsize-$c];
				}
				$smoothedvalue = $smoothedvalue / 20;
				array_push($plotentry,$smoothedvalue);
			} else {
				array_push($plotentry,$data[$i][4]);
			}
			array_push($plotdata,$plotentry);


			
		}

		// Cut out first few unsmoothed points
		$plotdata = array_slice($plotdata, 20);



		require_once 'phplot.php';

		$plot2 = new PHPlot(600,400);
		$plot2->SetTitle("");

		$plot2->SetFontTTF('title', '../fonts/SF.ttf', 12);
		$plot2->SetFontTTF('x_label', '../fonts/SF.ttf', 12);
		$plot2->SetFontTTF('y_label', '../fonts/SF.ttf', 12);
		$plot2->SetPlotType('lines');
		$plot2->SetDataType('text-data');

		$plot2->SetDataValues($plotdata);
		$plot2->SetXTickPos('none');
		$plot2->SetXTickLabelPos('none');
		$plot2->DrawGraph();
