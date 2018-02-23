<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
	<head>
	    <title>Ajarvis Recorder</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta charset="UTF-8" />
	    <meta name="author" content="Pippo.swe group" />
	    <meta http-equiv="cache-control" content="max-age=0" />
	    <meta http-equiv="cache-control" content="no-cache" />
	    <meta http-equiv="expires" content="0" />
	    <meta http-equiv="pragma" content="no-cache" />
	    <link rel="icon" href="<?php echo site_url('assets/images/favicon.ico'); ?>">
	    <!-- Bootstrap -->
    	<link rel="stylesheet" href="<?php echo site_url('assets/css/bootstrap/bootstrap.min.css'); ?>" />
    	<link rel="stylesheet" href="<?php echo site_url('assets/css/ionicons/ionicons.min.css'); ?>" />
    	<link rel="stylesheet" href="<?php echo site_url('assets/css/theme.css'); ?>" />
	    <?php
	        if(isset($theme_css))
	        {
	            foreach($theme_css as $css)
	            {
	                echo '<link href="' . site_url('assets/' . $css) . '?v=' . $this->config->item('site_version') .'" rel="stylesheet" />';
	            }
	        }
	    ?>
	</head>
	<body>
		<div class="container">
			<?php echo $content; ?>
		</div>
		<!-- Load script -->
		<script src="<?php echo site_url('assets/js/jquery/jquery.js'); ?>"></script>
		<script src="<?php echo site_url('assets/js/bootstrap/bootstrap.min.js'); ?>"></script>
		<?php
	        if(isset($theme_js))
	        {
	            foreach($theme_js as $js)
	            {
	                echo '<script src="' . site_url('assets/js/' . $js) . '?v=' . $this->config->item('site_version') . '"></script>';
	            }
	        }
        ?>
	</body>
</html>