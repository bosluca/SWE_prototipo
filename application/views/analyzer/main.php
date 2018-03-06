<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
	<div class="col-sm-12">
		<?php echo $plain_text; ?>
	</div>
</div>
<div class="row">
	<?php if(count($sentences_positive['sentences']) > 0) : ?>
		<div class="col-sm col-md">
			<p class="h3">Frasi positive:</p>
			<?php echo $this->load->view('analyzer/sentencesTable', array('sentences'=>$sentences_positive,'type'=>'positive'), TRUE); ?>
		</div>
	<?php endif; ?>
	<?php if(count($sentences_neutral['sentences']) > 0) : ?>
		<div class="col-sm col-md">
			<p class="h3">Frasi neutrali:</p>
			<?php echo $this->load->view('analyzer/sentencesTable', array('sentences'=>$sentences_neutral,'type'=>'neutral'), TRUE); ?>
		</div>
	<?php endif; ?>
	<?php if(count($sentences_negative['sentences']) > 0) : ?>
		<div class="col-sm col-md">
			<p class="h3">Frasi negative:</p>
			<?php echo $this->load->view('analyzer/sentencesTable', array('sentences'=>$sentences_negative,'type'=>'negative'), TRUE); ?>
		</div>
	<?php endif; ?>
</div>
<div class="row">
	<div class="col-sm-12">
	    <p class="h3">Grafio dei tipi:</p>
	    <?php echo $this->load->view('charts/barChart.php', $barChart, TRUE); ?>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
    	<p class="h3">Grafio dei tipi con maggiore dettaglio:</p>
    	<?php echo $this->load->view('charts/barChart.php', $strictBarChart, TRUE); ?>
    </div>
</div>

<div class="row">
	<div class="col-sm-12">
    	<p class="h3">Andamento del discorso:</p>
    	<?php echo $this->load->view('charts/thresholdChart.php', $speechThreshold, TRUE); ?>
    </div>
</div>


