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
			    $command = '/usr/bin/ffmpeg -i ' . $wav_file . ' -ac 1 ' . $flac_file;
			    exec($command);

			    // upload file to google storage
				if(upload_file($flac_file, $fname . '.FLAC')){
					// delete old file saved on server
					unlink($wav_file);

					echo transcribe_async_gcs($fname . '.FLAC');
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
		echo ini_get('post_max_size');
		echo '<br>';
		echo ini_get('upload_max_filesize');
	}
}
