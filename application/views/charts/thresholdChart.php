<?php defined('BASEPATH') OR exit('No direct script access allowed');

echo '<div class="'. $class .'" align="center"></div>';

echo '<script>new Chartist.Line(\'.ct-chart\', {series: [['. $series .']]}, {showArea: true,axisY: {onlyInteger: true},plugins: [Chartist.plugins.ctThreshold({threshold: 0})]});</script>';