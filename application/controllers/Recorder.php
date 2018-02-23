<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recorder extends CI_Controller {
	function __construct()
    {
        parent::__construct();

        // $this->load->model('');
        // $this->lang->load('task');
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
		    $fname = date('Y-m-d_H-i-s') . ".wav";

		    move_uploaded_file($_FILES['file']['tmp_name'], 'audio_files/' . $fname);
		}
	}
}
