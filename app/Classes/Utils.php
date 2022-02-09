<?php 

namespace App\Classes;



Class Utils{
    public static function uploadFile($request,$file, $path){
            $file = $request->file("$file");
            $destinationPath = 'file_storage/'.$path;
            $originalFile    = $file->getClientOriginalName();
            $filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
            $file->move($destinationPath, $filename);

            return $destinationPath.'/'.$filename;
    }

    public static function jsredirect($url){
        echo "<script>window.location.href='".$url."';</script>";
    }
    
}