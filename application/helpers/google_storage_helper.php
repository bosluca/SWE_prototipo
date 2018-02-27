<?php defined('BASEPATH') OR exit('No direct script access allowed');

# Includes the autoloader for libraries installed with composer
require  FCPATH . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Storage\StorageClient;

function upload_file($file_path = false)
{
	if($file_path){
		# Your Google Cloud Platform project ID
		$projectId = 'pacific-apex-195814';

		# Instantiates a client
		$storage = new StorageClient([
			'projectId'   => $projectId,
			'keyFilePath' =>  FCPATH . '/keys/AJarvis-5bfebda57c5c.json'
		]);


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
		'keyFilePath' =>  FCPATH . '/keys/AJarvis-5bfebda57c5c.json'
	]);

	echo FCPATH . '/keys/AJarvis-5bfebda57c5c.json';

	$source  = getcwd() . '/audio_files/output.FLAC';
	$storage = new StorageClient();
	$file    = fopen($source, 'r');
	$bucket  = $storage->bucket($bucketName);
    $object  = $bucket->upload($file, [
        'name' => $objectName
    ]);
    printf('Uploaded %s to gs://%s/%s' . PHP_EOL, basename($source), $bucketName, $objectName);

}