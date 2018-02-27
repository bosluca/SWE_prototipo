<?php defined('BASEPATH') OR exit('No direct script access allowed');

# Includes the autoloader for libraries installed with composer
require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Storage\StorageClient;

function upload_file($file_path = false)
{
	if($file_path){
		echo $file_path; die();
		
		# Your Google Cloud Platform project ID
		$projectId = 'pacific-apex-195814';

		# Instantiates a client
		$storage = new StorageClient([
			'projectId'   => $projectId,
			'keyFilePath' => __DIR__ . '/keys/AJarvis-5bfebda57c5c.json'
		]);

		echo 'ok';
	}
}