<?php
require_once 'function.php';
require_once 'Audio.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//check with your logic
if (isset($_FILES)) {

    //can request db log

    $target_folder = 'files/';
    $convertedMp3Files = 'convertedMp3Files/';
    $convertedMp3Name = md5(date('Y-m-d H:i:s:u')).".mp3";


    $response = uploadFile($_FILES['audioFile'],$target_folder);

    if($response['status'] ==='success'){


        $source_path = $target_folder.$response['file'];  //source path
        $target_path = $convertedMp3Files.$convertedMp3Name;  //target mp3 file path

        $response = Audio::convertAudioFileToMp3($source_path,$target_path);
    }

    //can response db log

} else {
    $response=[
        'status'=>'error',
        'message'=>'No file sent.'
    ];
}

echo json_encode($response);


