// set up basic variables for app

var record = document.querySelector('.record');
var stop   = document.querySelector('.stop');

// disable stop button while not recording

stop.disabled = true;

var audioCtx  = new (window.AudioContext || webkitAudioContext)();
var timer;
var seconds = 0, minutes = 0, hours = 0;
var lastTimerText = '';

//main block for doing the audio recording

if (navigator.mediaDevices.getUserMedia) {
	var constraints = { audio: true };
	var chunks      = [];
	var blobs       = [];
	var blobs_index = 0;

  	var onSuccess = function(stream) {
		var mediaRecorder = new MediaRecorder(stream);

		visualize(stream);

		record.onclick = function() {
			mediaRecorder.start();

			stop.disabled   = false;
			record.disabled = true;

			timer = setInterval(updateTimer, 1000);
			$('#timer').text(timerToText());
		}

		stop.onclick = function() {
			stop.disabled   = true;
			record.disabled = false;

			mediaRecorder.stop();
			clearTimeout(timer);
			lastTimerText = timerToText(true);
			seconds = minutes = hours = 0;
			$('#timer').text('');
		}

		mediaRecorder.onstop = function(e) {
			var clipLabel = document.createElement('p');
			var blob     = new Blob(chunks, { 'type' : 'audio/wav; codecs=wav' });
			chunks       = [];
			var audioURL = window.URL.createObjectURL(blob);
			addAudioElement(audioURL);

			blobs.push(blob);
			blobs_index++;
		}

		mediaRecorder.ondataavailable = function(e) {
		  	chunks.push(e.data);
		}
  	}

  	var onError = function(err) {
		console.log('The following error occured: ' + err);
  	}

  	navigator.mediaDevices.getUserMedia(constraints).then(onSuccess, onError);
} else {
   console.log('getUserMedia not supported on your browser!');
}

function visualize(stream) {
	var source       = audioCtx.createMediaStreamSource(stream);
	var analyser     = audioCtx.createAnalyser();
	analyser.fftSize = 2048;
	var bufferLength = analyser.frequencyBinCount;
	var dataArray    = new Uint8Array(bufferLength);

	source.connect(analyser);
}

function updateTimer(){
	seconds++;

	if(seconds == 60){
		minutes++;
		seconds = 0;

		if(minutes == 60){
			hours++;
			minutes = 0;
		}
	}

	$('#timer').text(timerToText());
}

function timerToText(asResult = false){
	var timerText = '';

	if(asResult){
		timerText = ' [durata = ';
		timerText += hours > 0 ? hours + ' ore - ' : '';
		timerText += minutes > 0 ? minutes + ' minuti - ' : '';
		timerText += seconds + ' secondi]';
	}
	else {
		timerText = hours < 10 ? '0' + hours : hours;
		timerText += minutes < 10 ? ':0' + minutes : ':' + minutes;
		timerText += seconds < 10 ? ':0' + seconds : ':' + seconds;
	}

	return timerText;
}

function addAudioElement(blobUrl)
{
	var desc = new Date().toLocaleString() + ' ' + lastTimerText;
	var newAudio = '<div class="audio-element">' + desc + '<div class="controls"><button type="button" class="btn btn-sm btn-success save-element" data-blob="' + blobUrl + '" data-index="' + blobs_index + '"><i class="ion-ios-checkmark"></i> SALVA</button><button class="btn btn-sm btn-danger delete-element"><i class="ion-ios-close"></i> SCARTA</button></div></div>';

	$('#downloadContainer').append(newAudio);
}

var ajax;

function createAudioElement(url, blob) {
	var data     = new FormData();
	var success  = true;

	data.append('file', blob);

	$('#uploadProgress').css('width', '0%');
	$('#uploadProgress').closest('.progress').removeClass('d-none');

	ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", caricamento, false);
	ajax.addEventListener("load", caricamentoCompletato, false);
	ajax.addEventListener("error", erroreCaricamento, false);
	ajax.addEventListener("abort", caricamentoAnnullato, false);
	ajax.open("POST", location.href + 'index.php/recorder/save_audio',true);
	ajax.send(data);

	return success;
}

$('body').on('click','.save-element',function(){
	var _this = $(this);

	createAudioElement(_this.data('blob'), blobs[_this.data('index')]);

	_this.closest('.controls').html('');
});

$('body').on('click','.delete-element',function(){
	$(this).closest('.audio-element').remove();
});

function caricamento(event)
{
	var percentuale = (event.loaded / event.total) * 100;

	$('#uploadProgress').css('width',percentuale + '%');

	if(percentuale == 100){
		$('#uploadProgress').closest('.progress').addClass('d-none');
		$('.loader-container').removeClass('d-none');
	}
}

function caricamentoCompletato(event)
{
	console.log('caricamento completato');

	$('.loader-container').addClass('d-none');
	location.href = 'https://35.198.80.139/NL/index.php?input=1';
}

function erroreCaricamento(event)
{
	console.log('errore caricamento: ' + event);
}

function caricamentoAnnullato(event)
{
	console.log('caricamento annullato: ' + event);
}

