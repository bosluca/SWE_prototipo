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
        $text   = file_get_contents(getcwd() . '/text/input.txt');
        $text   = utf8_decode($text);
        $report = json_decode(analyzeText($text), TRUE);

        $content_data = array(
            'plain_text'         => $text,
            'sentences_positive' => get_sentences($report, 'positive'),
            'sentences_neutral'  => get_sentences($report, 'neutral'),
            'sentences_negative' => get_sentences($report, 'negative'),
            'barChart'           => $this->createTypeBarChart($report, 'barChart'),
            'pieChart'           => $this->createTypeBarChart($report, 'pieChart'),
            'strictBarChart'     => $this->createTypeBarChart($report, 'strictPieChart', true),
            'speechThreshold'    => $this->createSpeechGoing($report, 'speechThreshold')
        );

        $data['content']      = $this->load->view('analyzer/main', $content_data, TRUE);
        $data['theme_js_top'] = array('chartist/chartist.min.js','chartist/chartist-plugin-threshold.min.js');
        $data['theme_css']    = array('chartist/chartist.min.css');

        $this->load->view('template', $data);
    }

    /**
     * @param array $report result (as array) from analyzeText
     * @param string $class the css class to give at the chart
     * @param bool $useStrict if true it will give a more accurate analyze. Default false.
     * @return array create an array for thresholdChart view
     */
    function createTypeBarChart($report, $class, $useStrict = false)
    {
        if ($useStrict) {
            $series = array(0, 0, 0, 0, 0, 0);
            $labels = 'Positive\', \'Negative\', \'Neutrali\', \'Sicuramene Positive\', \'Sicuramente Negative\',\'Miste';
        } else {
            $series = array(0, 0, 0);
            $labels = 'Positive\', \'Negative\', \'Neutrali';
        }

        if (isset($report['sentences'])) {

            foreach ($report['sentences'] as $sentence) {

                if ($useStrict)
                    $type = getStrictType($sentence['sentiment']['score'], $sentence['sentiment']['magnitude']);
                else
                    $type = getSimpleType($sentence['sentiment']['score']);

                switch ($type) {
                    case 'positive':
                        $series[0]++;
                        break;
                    case 'negative':
                        $series[1]++;
                        break;
                    case 'neutral':
                        $series[2]++;
                        break;
                    case 'clearly positive':
                        $series[3]++;
                        break;
                    case 'clearly negative':
                        $series[4]++;
                        break;
                    case 'mixed':
                        $series[5]++;
                        break;

                }
            }

            $series = implode(',', $series);
        }

        return array(
            'labels' => $labels,
            'series' => $series,
            'class'  => $class
        );
    }

    /**
     * @param array $report result (as array) from analyzeText
     * @param string $class the css class to give at the chart
     * @return array create an array for thresholdChart view
     */
    function createSpeechGoing($report, $class)
    {
        $series = array();

        if (isset($report['sentences'])) {

            foreach ($report['sentences'] as $sentence) {
                array_push($series, $sentence['sentiment']['score']);
            }

            $series = implode(',', $series);
        }

        return array(
            'series' => $series,
            'class' => $class
        );
    }

}
