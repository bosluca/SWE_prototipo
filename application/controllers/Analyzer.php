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
        /* DEBUG */
        $string = ' Ieri è andato tutto bene . Oggi devo lavorare perché il cliente vuole nuove interfacce mi ci vorranno 8 ore non so come risolvere . Però il problema dell\'interfaccia web';
        $output = getcwd() . '/text/input.txt';
        file_put_contents($output, utf8_encode($string));

        /* END DEBUG */

        $text         = file_get_contents(getcwd() . '/text/input.txt');
        $text         = utf8_decode($text);
        $content_data = $this->dataReportGenerator($text);

        $data['content'] = $this->load->view('analyzer/main', $content_data, TRUE);

        $this->load->view('template', $data);
    }

    /**
     * @param $string string The text to analyze
     * @return mixed associative array with all the data for the view
     */
    function dataReportGenerator($string){
        $json = json_decode(analyzeText($string), TRUE);

echo '<pre>';
print_r($json);
echo '</pre>';
die();
        $data['text'] = $json['text'];

        return $data;
    }

}
