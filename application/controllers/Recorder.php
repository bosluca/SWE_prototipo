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
		    	$time = exec("ffmpeg -i " . escapeshellarg($path) . " 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");
				
echo $time; die();
				list($hms, $milli) = explode('.', $time);
				list($hours, $minutes, $seconds) = explode(':', $hms);
				$total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;

			    // convert wav to FLAC
			    $command = '/usr/bin/ffmpeg -i ' . $wav_file  . ' -ac 1 ' . $flac_file;
			    exec($command);

			    // upload file to google storage
				if(upload_file($flac_file, $fname . '.FLAC')){
					// delete old file saved on server
					unlink($wav_file);

					if($total_seconds > 59){
						$result = transcribe_async_gcs($fname . '.FLAC');
					}
					else {
						$result = transcribe_sync_gcs($fname . '.FLAC');
					}

					$result = json_decode($result, true);
					$text   = $result['transcript'];
					$output = 'text/input.txt';

					file_put_contents($output, $text);
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
		$text = 'ciao a tutti2';
		$output = 'text/input.txt';
		file_put_contents($output, $text);
		header('Location: https://35.198.80.139/NL/index.php?input=1');
	}
}
