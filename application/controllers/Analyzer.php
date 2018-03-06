<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analyzer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('google_natural_language_helper'));
    }

    function index()
    {
        /* DEBUG */
        $string = ' Ieri è andato tutto bene . Oggi devo lavorare perché il cliente vuole nuove interfacce mi ci vorranno 8 ore non so come risolvere . Però il problema dell\'interfaccia web';
        $output = getcwd() . '/text/input.txt';
        file_put_contents($output, utf8_encode($string));

        /* END DEBUG */

        $text = file_get_contents(getcwd() . '/text/input.txt');
        $text = utf8_decode($text);
        $report = json_decode(analyzeText($text), TRUE);

        $content_data = array(
            'sentences_positive' => get_sentences($report, 'positive'),
            'sentences_neutral' => get_sentences($report, 'neutral'),
            'sentences_negative' => get_sentences($report, 'negative'),
            'pieChart' => $this->createTypePieChart($report,'pieChart')
        );

        $data['content'] = $this->load->view('analyzer/main', $content_data, TRUE);
        $data['theme_js'] = array('chartist/chartist.min.js');
        $data['theme_css'] = array('chartist/chartist.min.css');

        $this->load->view('template', $data);
    }

    function createTypePieChart($report, $class)
    {

        if (isset($report['sentences'])) {
            foreach ($report['sentences'] as $sentence) {
                $series = array(0, 0, 0);
                $labels = 'positive\', \'negative\', \'neutral';

                switch (getSimpleType($sentence['sentiment']['score'])) {
                    case 'positive':
                        $series[0]++;
                        break;
                    case 'negative':
                        $series[1]++;
                        break;
                    case 'neutral':
                        $series[2]++;
                        break;
                }

                $series = implode(',',$series);


                return array(
                    'labels' => $labels,
                    'series' => $series,
                    'class' => $class
                );
            }
        }
    }

}
