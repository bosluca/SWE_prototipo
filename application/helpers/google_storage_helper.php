<?php defined('BASEPATH') OR exit('No direct script access allowed');

function upload_file($file_path = false)
{
	if($file_path){
		# Includes the autoloader for libraries installed with composer
		require __DIR__ . '/vendor/autoload.php';

		# Imports the Google Cloud client library
		use Google\Cloud\Storage\StorageClient;

		# Your Google Cloud Platform project ID
		$projectId = 'pacific-apex-195814';

		# Instantiates a client
		$storage = new StorageClient([
			'projectId'   => $projectId
			'keyFile'     => json_decode(file_get_contents(__DIR__ . '/keys/AJarvis-5bfebda57c5c.json'), true),
			'keyFilePath' => __DIR__ . '/keys/AJarvis-5bfebda57c5c.json'
		]);

		echo 'ok';
	}
}