// set up basic variables for app

var record = document.querySelector('.record');
var stop   = document.querySelector('.stop');

// disable stop button while not recording

stop.disabled = true;

var audioCtx  = new (window.AudioContext || webkitAudioContext)();

//main block for doing the audio recording

if (navigator.mediaDevices.getUserMedia) {
	var constraints = { audio: true };
	var chunks      = [];

  	var onSuccess = function(stream) {
		var mediaRecorder = new MediaRecorder(stream);

		visualize(stream);

		record.onclick = function() {
			mediaRecorder.start();

			stop.disabled   = false;
			record.disabled = true;
		}

		stop.onclick = function() {
			stop.disabled   = true;
			record.disabled = false;

			mediaRecorder.stop();
		}

		mediaRecorder.onstop = function(e) {
			var clipLabel     = document.createElement('p');
			var audio         = document.createElement('audio');
			var deleteButton  = document.createElement('button');

			audio.setAttribute('controls', '');

			audio.controls = true;

			var blob = new Blob(chunks, { 'type' : 'audio/ogg; codecs=opus' });
			chunks = [];
			var audioURL = window.URL.createObjectURL(blob);
			addAudioElement(audioURL);
			audio.src = audioURL;
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

function addAudioElement(blobUrl)
{
	var newAudio = '<div class="audio-element" data-blob="' + blobUrl + '"><button type="button" class="btn btn-sm btn-success">salva</button><button class="btn btn-sm btn-danger">scarta</button></div>';
	$('#downloadContainer').append(newAudio);
	/*const downloadEl     = document.createElement('a');
	downloadEl.href      = blobUrl;
	// downloadEl.dataset.blob = blobUrl;
	const sourceEl       = document.createElement('source');
	sourceEl.src         = blobUrl;
	sourceEl.type        = 'audio/FLAC';
	document.getElementById('downloadContainer').appendChild(downloadEl);*/
}

function createAudioElement(blob) {
	var url = (window.URL || window.webkitURL).createObjectURL(blob);

	var filename = 'audio_file.wav';
	var data = new FormData();
	data.append('file', blob);

	$.ajax({
		url :  location.origin + '/recorder/save_audio',
		type: 'POST',
		data: data,
		contentType: false,
		processData: false,
		success: function(data) {
			console.log(data);
		},
		error: function() {
			console.log('failed');
		}
	});
}