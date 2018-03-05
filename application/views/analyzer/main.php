<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
	<?php if(count($sentences_positive) > 0 || true) : ?>
		<div class="col-sm col-md">
			<p class="h3">Frasi positive:</p>
			<?php echo $this->load->view('analyzer/sentencesTable', array('sentences'=>$sentences_positive,'type'=>'positive'), TRUE); ?>
		</div>
	<?php endif; ?>
	<?php if(count($sentences_neutral) > 0) : ?>
		<div class="col-sm col-md">
			<p class="h3">Frasi neutrali:</p>
			<?php echo $this->load->view('analyzer/sentencesTable', array('sentences'=>$sentences_neutral,'type'=>'neutral'), TRUE); ?>
		</div>
	<?php endif; ?>
	<?php if(count($sentences_negative) > 0) : ?>
		<div class="col-sm col-md">
			<p class="h3">Frasi negative:</p>
			<?php echo $this->load->view('analyzer/sentencesTable', array('sentences'=>$sentences_negative,'type'=>'negative'), TRUE); ?>
		</div>
	<?php endif; ?>
</div>
