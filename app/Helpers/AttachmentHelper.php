<?php
namespace App\Helpers;

class AttachmentHelper
{
    public static function save(int $refer_id, $file, array $setting)
    {
        $type = $setting['type'];
        $folder = $setting['folder'];
        $filename = $setting['filename'];

        $folder_level = self::folder_level($refer_id);

        $save_path = 'public/attachment/' . $type . '/' . $folder_level . '/' . $folder . '/' . $filename;

        if(!$file){
            return false;
        }

        \Storage::put($save_path, $file);
        
        return $save_path;
    }

    public static function get(int $refer_id, array $setting)
    {
        $type = $setting['type'];
        $folder = $setting['folder'];
        $filename = $setting['filename'];
        
        $folder_level = self::folder_level($refer_id);

        $url = \Storage::url('public/attachment/' . $type . '/' . $folder_level . '/' . $folder . '/' . $filename);

        return $url;
    }

    private static function folder_level(int $refer_id){
        return $folder = ceil($refer_id / 1000);
    }
}