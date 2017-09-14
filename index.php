

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DesCam powered by DeStagram">
    <meta name="author" content="Desmond Liang">
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart']});
      google.charts.setOnLoadCallback(drawChart);
    </script>
    <title>Traffic Air Quailty Model</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

  </head>

  <body>

    <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar black"></span>
            <span class="icon-bar black"></span>
            <span class="icon-bar black"></span>
          </button>
          <a class="navbar-brand" href="https://cam.desliang.com">
          	The Traffic Air Quality Model
          </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
          <ul class="nav navbar-nav">
            <li class="active"><a href="">Sensors</a></li>
            <li><a href="">Maps</a></li>
            <li><a href="">About</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
      <?php 
        // Descriptive Information
        $date = date('m/d/Y h:i:s a', time());
        echo "Current Date: ". $date . "<br>";
        echo "Sensor Location: Indianapolis";
      ?>
      <br>

      <br>
      Graphing Options
      <div class="btn-group" role="group" aria-label="...">
        <a href="./core/graphopt.php?graphopt=speed" class="btn btn-default">Speed</a>
        <a href="./core/graphopt.php?graphopt=trafficvol" class="btn btn-default">Traffic Volume</a>
        <a href="./core/graphopt.php?graphopt=occ" class="btn btn-default">Occupancy</a>
        <a href="./core/graphopt.php?graphopt=emm" class="btn btn-default">Emission</a>
        <a href="./core/endSession.php" class="btn btn-default">Reset Animation</a>
      </div>
      
      <br><br>
      Data Options
      <div class="btn-group" role="group" aria-label="...">
        <a href="" class="btn btn-default">Collect Data</a>
        <a href="" class="btn btn-default">Save Data</a>
      </div>

      <br> 
      <iframe src="graphs.php" id='myFrame1'></iframe> 
      <iframe src="" id='myFrame2'></iframe>


  </div>

</div>


    </div><!-- /.container -->


    <footer>2017 (c) Model developed by Dr. Ahmad Soliman, interface developed by Desmond Liang, All Rights Reserved.</footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
      var f1 = document.getElementById('myFrame1');
      var f2 = document.getElementById('myFrame2');
      var f  = 0;

      document.getElementById('myFrame1').onload = function() {
        f1.style.display="block"; 
        f2.style.display="none";

      }

      document.getElementById('myFrame2').onload = function() {
        f2.style.display="block";
        f1.style.display="none";
      }

      setInterval(reloadIFrame, 5000);

      function reloadIFrame() {
        if (f==0){
          f1.src="graphs.php";
          f=1;
        } else {
          f2.src="graphs.php";
          f=0;
        }
        
      }


    </script>

  

</body></html>