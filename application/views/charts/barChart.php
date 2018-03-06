/**
* @param string $class the css class to give at the chart
* @param string $labels a string with all the label names, divided by ,
* @param string $series a string with the series of data, divided by ,
*/
<?php defined('BASEPATH') OR exit('No direct script access allowed');

echo '<div class="'. $class .'" align="center"></div>';

echo '<script>new Chartist.Bar(\'.' . $class . '\', {labels: [\'' .$labels .'\'],series: ['. $series .']}, {distributeSeries: true});</script>';

