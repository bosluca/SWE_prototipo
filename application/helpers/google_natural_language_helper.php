<?php defined('BASEPATH') OR exit('No direct script access allowed');

# Includes the autoloader for libraries installed with composer
require FCPATH . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Language\LanguageClient;

/**
 * @param $string string The text to analyze. Should be in UTF-8 encoding for avoid error
 * @param null $config array with a configuration for a LanguageClient Client object
 * @return string JSON with the full response from the API.
 */
function analyzeText($string, $config = null)
{
    $CI = &get_instance();
    $CI->config->load('google_cloud');

    $keyFilePath = $CI->config->item('key_file_path');

    $language = new LanguageClient([
        'keyFilePath' => $keyFilePath
    ]);

    if ($config === null)
        $config = loadDefaultConfig('it');

    return json_encode($language->annotateText($string, $config)->info());
}

/**
 * @param $language string  The language of the document. Both ISO and BCP-47 language codes are accepted.
 * @return array The configuration for a LanguageClient Client object that run entities, syntax and sentiment analysis
 */
function loadDefaultConfig($language)
{
    return [
        'features' => ['entities', 'syntax', 'sentiment'],
        'language' => $language,
        'type' => 'PLAIN_TEXT',
        'encodingType' => 'UTF8'
    ];
}