<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analyzer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('google_natural_language_helper');
    }

    function index()
    {
        die("OK");
        $text = file_get_contents('../../../text/input.txt');

        $text = utf8_encode($text);

        $content_data = $this->dataReportGenerator($text);

        $data['content'] = $this->load->view('analyzer/main', $content_data, TRUE);

        $this->load->view('template', $data);
    }

    /**
     * @param $string string The text to analyze
     * @return mixed associative array with all the data for the view
     */
    function dataReportGenerator($string){
        $json = json_decode( analyzeText( $string ), TRUE);

        $data['text'] = $json['text'];

        return $data;
    }

}
