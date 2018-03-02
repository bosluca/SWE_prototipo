<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recorder extends CI_Controller {
	function __construct()
    {
        parent::__construct();
        $this->load->helper(array('google_storage_helper','google_speech_helper'));
    }

	function index()
	{
		$data['theme_js'] = array('recorder/recorder.js','recorder/mediaDevices.js');

		$content_data = array();

		$data['content']  = $this->load->view('recorder/main', $content_data, TRUE);

		$this->load->view('template', $data);
	}

	function save_audio()
	{
		if(isset($_FILES['file']) && !$_FILES['file']['error']){
			$fname     = date('Y-m-d_H-i-s');
			$path      = getcwd() . '/audio_files';
			$wav_file  = $path . '/' . $fname . ".wav";
			$flac_file = $path . '/' . $fname . ".FLAC";

			// save wav file
		    if(move_uploaded_file($_FILES['file']['tmp_name'], 'audio_files/' . $fname . '.wav')){
			    // convert wav to FLAC
			    $command = '/usr/bin/ffmpeg -i ' . $wav_file  . ' -r 16000'. ' -ac 1 ' . $flac_file;
			    echo $command . '<br>';
			    exec($command);

			    // upload file to google storage
				if(upload_file($flac_file, $fname . '.FLAC')){
					// delete old file saved on server
					unlink($wav_file);

					$result = transcribe_async_gcs($fname . '.FLAC');
					$result = json_decode($result, true);
					$text   = '';

					if(isset($result['transcript'])){
						$text = $result['transcript'];
					}
				}
				else {
					echo 'unable to upload file on google-storage';
				}
		    }
		    else {
		    	echo 'unable to save file on local server';
		    }
		}
	}

	function debug()
	{
		$text = 'ciao a tutti';
		$url = 'https://35.198.80.139/NL/index.php';
		$host = "https://35.198.80.139/NL/";
		$path = "index.php";
		$data = "text=" . $text;
		$data = urlencode($data);

		header("POST $path HTTP/1.1\\r\
		" );
		header("Host: $host\\r\
		" );
		header("Content-type: application/x-www-form-urlencoded\\r\
		" );
		header("Content-length: " . strlen($data) . "\\r\
		" );
		header("Connection: close\\r\
		\\r\
		" );
		header($data);
	}
}
