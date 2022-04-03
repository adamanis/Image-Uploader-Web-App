<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\AttachmentHelper;
use Carbon\Carbon;

class UploadedImage extends Model
{
    use HasFactory;

    protected $appends = ['image_file', 'created_at_display'];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageFileAttribute(){
        $id = $this->user_id;
        $setting = [
            'type' => 'uploaded_images',
            'folder' => $id,
            'filename' => $this->filename,
        ];

        return AttachmentHelper::get($id, $setting);
    }

    public function getCreatedAtDisplayAttribute(){
        return Carbon::parse($this->created_at)->toFormattedDateString();
    }
}
