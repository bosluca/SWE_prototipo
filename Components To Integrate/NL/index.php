
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

# Includes the autoloader for libraries installed with composer
require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Language\LanguageClient;

# Your Google Cloud Platform project ID
$projectId = 'pacific-apex-195814';

# Instantiates a client
$language = new LanguageClient([
    'projectId' => $projectId,
    'keyFilePath' => __DIR__ . '/googleKey.json'
]);

if(isset($_GET['input'])){
	$text = file_get_contents('../prototipo/text/input.txt');
}else {
# The text to analyze
	$text = $_POST['text'];
}

$config = [
    'features'      => ['entities', 'syntax', 'sentiment'],  // entitySentiment and classify not support italian language
    'language'      => 'it',
    'type'          => 'PLAIN_TEXT',
    'encodingType'  => 'UTF8'
];


$annotation = $language->annotateText( utf8_encode( $text ), $config);

#Creazione del file con output della sentiment
$json = $annotation->info();
$file = fopen("../output/output.json","w");
fwrite($file, json_encode($json));
fclose($file);

$sentiment = $annotation->sentiment();

$string = '';
#Print Head
$string .= '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><meta name="description" content=""><meta name="author" content=""><title>Natural Language</title><link rel="shortcut icon" href="https://cloud.google.com/_static/34bc6b5f61/images/cloud/icons/favicons/favicon.ico?hl=it"><!-- Bootstrap core CSS--><link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="bg-dark">';
$string .='<div class="container"><form align="right" action="../output/index.php"><input class="btn btn-primary" type="submit" value="Dashboard"/> </form></div>';

#Print input
$string .= '<div class="container"><div class="card card-login mx-auto mt-5"><div class="card-header">Text:</div><div class="card-body"><div class="text-justify mt-4 mb-5"><p>' .
      $text .
      '</p></div></div></div></div>';

#Print Entities
$string .= '<div class="container"><div class="card card-login mx-auto mt-5"><div class="card-header">Entities:</div><div class="card-body"><div class="text-justify mt-4 mb-5"><p>';
foreach ($annotation->entities() as $entity) {
    $string .= $entity['type'] . '<br/>';
}
$string .= '</p></div></div></div></div>';

#Print Sentiment
$sentiment = $annotation->sentiment();
$string .= '<div class="container"><div class="card card-login mx-auto mt-5"><div class="card-header">Sentiment:</div><div class="card-body"><div class="text-justify mt-4 mb-5"><p>' .
            $sentiment['score'] .
            '</p></div></div></div></div>';

$int = 0;
#Print Sentence
$string .= '<div class="container"><div class="card card-login mx-auto mt-5"><div class="card-header">Sentence:</div><div class="card-body"><div class="text-justify mt-4 mb-5"><p>';
foreach ($annotation->sentences() as $sentence) {
    ++$int;
    $string .= $int .'. ' . $sentence['text']['content'] . '<br/>';
}
$string .= '</p></div></div></div></div>';

#Print Tokens
$string .= '<div class="container"><div class="card card-login mx-auto mt-5"><div class="card-header">Tokens:</div><div class="card-body"><div class="text-justify mt-4 mb-5"><p>';
foreach ($annotation->tokens() as $token) {
    $string .= $token['text']['content'] . '<br/>';
}
$string .= '</p></div></div></div></div>';


echo $string;


#Print full Output
echo '<div class="container"><div class="card card-login mx-auto mt-5"><div class="card-header">Full Output:</div><div class="card-body"><div class="text-justify mt-4 mb-5"><pre>';
print_r($annotation->info() );
echo ' Dashboard </button></pre></div></div></div></div>';
