<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
	$bg_color = "";
	switch($type){
		case 'positive': $bg_color = 'bg-success'; break;
		case 'neutral':  $bg_color = 'bg-info';    break;
		case 'negative': $bg_color = 'bg-danger';  break;
	}
?>

<table class="table table-hover table-striped">
	<thead>
		<tr class="<?php echo $bg_color ?>">
			<th>Frase</th>
			<th>Score</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($sentences['sentences'] as $index => $sentence) : ?>
			<td><?php echo $sentence; ?></td>
			<td><?php echo $sentences['scores'][$index]; ?></td>
		<?php endforeach; ?>
	</tbody>
</table>