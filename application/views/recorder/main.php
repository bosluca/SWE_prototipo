<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row justify-content-center">
	<div class="col-sm-12 col-lg-6">
		<form>
			<div class="form-group">
				<label for="project-name">Scegli il progetto:</label>
				<select id="project-name" class="form-control">
					<option value="primo">primo</option>
					<option value="secondo">secondo</option>
					<option value="terzo">terzo</option>
				</select>
			</div>
		</form>
	</div>
</div>
<div class="row justify-content-center mt-3">
	<div class="col-sm-12 col-lg-6">
		<div class="progress">
	  		<div class="progress-bar" id="uploadProgress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
	</div>
</div>
<div class="row justify-content-center mt-3">
	<div class="col-sm-12 col-lg-6">
		<button class="record btn btn-primary"><i class="ion-android-microphone mr-1"></i> registra</button>
		<button class="stop btn btn-outline-danger"><i class="ion-stop mr-1"></i> stop</button>
		<div id="timer"></div>
	</div>
</div>
<div class="row justify-content-center mt-3">
	<div class="col-sm-12 col-lg-6" id="downloadContainer">
	</div>
</div>