<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @param string $class the css class to give at the chart
 * @param string $series a string with the series of data, divided by ,
 */

echo '<div class="'. $class .'" align="center"></div>';

echo '<script>new Chartist.Line(\'.' . $class . '\', {series: [['. $series .']]}, {showArea: true,axisY: {onlyInteger: true},plugins: [Chartist.plugins.ctThreshold({threshold: 0})]});</script>';