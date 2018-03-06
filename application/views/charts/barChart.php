<?php defined('BASEPATH') OR exit('No direct script access allowed');

echo '<div class="'. $class .'" align="center"></div>';

echo '<script>new Chartist.Bar(\'.' . $class . '\', {labels: [\'' .$labels .'\'],series: [['. $series .']}, {distributeSeries: true});</script>';

