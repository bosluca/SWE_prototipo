<?php defined('BASEPATH') OR exit('No direct script access allowed');

# Includes the autoloader for libraries installed with composer
require  FCPATH . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Storage\StorageClient;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

function upload_file($file_path = false, $file_name = false)
{
	if($file_path && $file_name){
		$CI = & get_instance();
	    $CI->config->load('google_cloud');

		$projectId  = $CI->config->item('project_id');
		$bucketName = $CI->config->item('audio_bucket_name');

		// instantiates a client
		$storage = new StorageClient([
			'projectId'   => $projectId,
			'keyFilePath' =>  FCPATH . 'keys/AJarvis-5bfebda57c5c.json'
		]);

		// open file and instantiate bucket
		$file   = fopen($file_path, 'r');
		$bucket = $storage->bucket($bucketName);
		$metadata = ['contentType' => 'audio/x-flac','uploadType' => 'resumable'];

		if($bucket->upload($file, ['name' => $file_name,'metadata' => $metadata])){
			printf('Uploaded %s to gs://%s/%s' . PHP_EOL, basename($file_path), $bucketName, $file_name);
		}
		else {
			printf('Failed uploaded %s to gs://%s/%s' . PHP_EOL, basename($file_path), $bucketName, $file_name);
		}
	}
}

function debug()
{
	$CI = & get_instance();
    $CI->config->load('google_cloud');

	# Your Google Cloud Platform project ID
	$projectId  = $CI->config->item('project_id');
	$bucketName = $CI->config->item('audio_bucket_name');
	$objectName = 'output.FLAC';

	# Instantiates a client
	$storage = new StorageClient([
		'projectId'   => $projectId,
		'keyFilePath' =>  FCPATH . 'keys/AJarvis-5bfebda57c5c.json'
	]);

	$source   = getcwd() . '/audio_files/output.FLAC';
	$file     = fopen($source, 'r');
	$bucket   = $storage->bucket($bucketName);
	$metadata = ['contentType' => 'audio/x-flac'];

	if($bucket->upload($file, ['name' => $objectName,'metadata' => $metadata])){
		printf('Uploaded %s to gs://%s/%s' . PHP_EOL, basename($source), $bucketName, $objectName);
	}
	else {
		printf('Failed uploaded %s to gs://%s/%s' . PHP_EOL, basename($source), $bucketName, $objectName);
	}

	// create the Silex application
	/*
	$app = new Application();

	$app['storage'] = function () use ($app) {
	    $storage = new StorageClient([
	        'projectId' => $projectId,
	        'keyFilePath' =>  FCPATH . 'keys/AJarvis-5bfebda57c5c.json'
	    ]);

	    return $storage;
	};

	$app->post('/write', function (Request $request) use ($app) {
	    $storage = $app['storage'];
	    $metadata = ['contentType' => 'audio/x-flac'];
	    $storage->bucket($bucketName)->upload($file, [
	        'name'     => $objectName,
	        'metadata' => $metadata,
	    ]);
	});*/
}