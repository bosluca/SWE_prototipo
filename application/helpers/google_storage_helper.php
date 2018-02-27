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

		echo 'ok';
	}
}