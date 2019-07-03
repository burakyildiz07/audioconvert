<?php


class Audio
{

    public static function convertAudioFileToMp3($source_path,$target_path){


        $code = 'ffmpeg -i '. dirname(__FILE__)."/".$source_path.' -vn -ar 44100 -ac 2 -b:a 192k '.dirname(__FILE__).'/'.$target_path;

        //convert audio file to mp3 with ffpmeg
        try{

            shell_exec(
                $code
            );

            if (file_exists(dirname(__FILE__)."/".$source_path)) {
                unlink(dirname(__FILE__)."/".$source_path);
            }

            $response = [
                'status'=>'success',
                'message'=>$target_path
            ];

        }catch(Exception $exception){
            $response =[
                'status'=>'error',
                'message'=>$exception->getMessage()
            ];
        }

        return $response;

    }
}