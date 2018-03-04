<!DOCTYPE html>
<html>
     <link rel="stylesheet" type="text/css" href="style.css">
  <head>
  
  <title>My first Chartist Tests</title>
  <!--CHARTIST-->

  <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css"> 
  <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
  
  <!-- BOOTSRAP -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
  	
  </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
	integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" 
 crossorigin="anonymous"></script>



  </head>
  <body>

  	<!-- Parisg the Json file -->
<?php
    $file_content = file_get_contents("output.json");
    #echo "<h1>Output parse JSon</h1>";
    $DecJSon = json_decode($file_content, TRUE);
    $documentSentiment = array(    "score"     => $DecJSon['documentSentiment']['score'],
                                "magnitude" => $DecJSon['documentSentiment']['magnitude']);
    #echo "<table border='1'><tr><th>Frase</th><th>Magnitude</th></tr>";
    $sentences           = array();
    $sentences_magnitude = array();
    $i = 0;
    foreach ($DecJSon['sentences'] as $sentence) {
        $sentences[$i]           = $sentence['text']['content'];
        $sentences_magnitude[$i] = $sentence['sentiment']['magnitude'];
     #   echo "<tr><td>".$sentence['text']['content']."</td>";
     #   echo "<td>".$sentence['sentiment']['magnitude']."</td></tr>";

        $i++;
    }
   # echo "</table>";
?>

	<!--Printing Graph and Table -->

  	<div class="container">
  		<div class="row">
  			<div class="col-6">
  				<h3 align="center"> Dati Grafici </h3>
        		<div class="ct-chart" id="chart1" align="center"></div> 	<!-- ct-golden-section in calss div se si fukka tutto-->
        	</div>
        		<div class="col-6">
        			<h3 align="center"> Dati Analizzati </h3>
        				<table class="table table-bordered table-hover">
        					<thead class="thead-light">
        					<tr>	
        						<th scope="col"> Frase </th>
        						<th scope="col"> Magnitude </th>
        					</tr>	
        					</thead>
        					<tbody>
		        					<?php 
			        					$frasi=count($sentences);
			        					for($j=0; $j<$frasi; $j++){
			        						echo "<tr>";
			        						echo "<td align='center'>$sentences[$j]</td>";
			        						echo "<td align='center'>$sentences_magnitude[$j]</td></tr>";
			        					} 
        							?>
        					</tbody>
        				</table>
        		</div>
        	</div>
        </div>
    </div>

<script>
   
	var x = new Array("<?= join('","',$sentences_magnitude)?>");
	var y = new Array("<?= join('","',$sentences)?>");
  var data = {
  labels: y,
  className: 'first-series',
  series: [x]
};

var options = {
 
  width:400,
  height:400
};

var responsiveOptions = [
  ['screen and (max-width: 900px)', {
    seriesBarDistance: 5,
    axisX: {
      labelInterpolationFnc: function (value) {
        return value[0];
      }
    }
  }]
];
new Chartist.Bar('#chart1', data, options, responsiveOptions);


</script>
   
 </body>
</html>
