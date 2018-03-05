<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
	<div class="col-sm col-md">
		<?php echo $this->load->view('analyzer/sentencesTable', array('sentences'=>$sentences_positive,'type'=>'positive'), TRUE); ?>
	</div>
	<div class="col-sm col-md">
		<?php echo $this->load->view('analyzer/sentencesTable', array('sentences'=>$sentences_neutral,'type'=>'neutral'), TRUE); ?>
	</div>
	<div class="col-sm col-md">
		<?php echo $this->load->view('analyzer/sentencesTable', array('sentences'=>$sentences_negative,'type'=>'negative'), TRUE); ?>
	</div>
</div>
