<?php

function uploadFile($file, $new_upload_folder, $allowed_file_size = 100000000000000000, $allowed_mime_types = array()) {

    try {
        if (!isset($file['error']) || is_array($file['error'])) {
            throw new RuntimeException('Invalid parameters.');
        }
        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }

        // You should also check filesize here.
        if ($file['size'] > $allowed_file_size) {
            throw new RuntimeException('Exceeded filesize limit.');
        }
        if(empty($allowed_mime_types)) {
            $allowed_mime_types = array(
                "wav" => "audio/x-wav",
                "ogg" => "audio/ogg",
                "wma" => "audio/x-ms-wma",
                "m3u" => "audio/x-mpegurl",
                "wax" => "audio/x-ms-wax",
            );
        }

        // Check MIME Type
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        if (false === $ext = array_search(
                $finfo->file($file['tmp_name']),
                $allowed_mime_types,
                true
            )) {
            throw new RuntimeException('Invalid file format.');
        }

        // You should name it uniquely.
        $file_name = sha1_file($file['tmp_name']);
        if (!move_uploaded_file(
            $file['tmp_name'],
            sprintf('%s%s.%s',
                $new_upload_folder,
                $file_name,
                $ext
            )
        )) {
            throw new RuntimeException('Failed to move uploaded file.');
        }
        return [
            'status'=>'success',
            'file'=>$file_name.".".$ext,
        ];
    } catch (RuntimeException $e) {
        return [
            'status'=>'error',
            'message'=>$e->getMessage(),
        ];
    }
}

