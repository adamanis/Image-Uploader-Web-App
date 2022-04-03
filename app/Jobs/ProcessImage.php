<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Helpers\AttachmentHelper;
use Illuminate\Support\Facades\Log;
use App\Events\MessageNotification;
use App\Models\User;
use App\Models\UploadedImage;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user, $url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = 'Upload Image Success';
        $status = 'success';
        $url_headers=get_headers($this->url, 1);
        $type = 'image/jpg';

        if(isset($url_headers['Content-Type'])){
            
            if(is_array($url_headers['Content-Type'])){
                foreach($url_headers['Content-Type'] as $value){
                    if($this->isValidType($value))
                        $type = $value;
                }
            }
            else{
                if($this->isValidType($url_headers['Content-Type'])) 
                    $type = $url_headers['Content-Type'];
            }
        }

        $contents = file_get_contents($this->url);
        $filename = $this->user->id . '_' . uniqid() . '.' . ltrim($type, "image/");

        $setting = [
            'type' => 'uploaded_images',
            'folder' => $this->user->id,
            'filename' => $filename
        ];

        $savedAttachment = AttachmentHelper::save($this->user->id, $contents, $setting);
        
        if(!$savedAttachment){
            $message = 'Upload Image Failed - Unable to save image to server';
            $status = 'error';
        }
        else{
            $newUploadedImage = new UploadedImage();
            $newUploadedImage->user_id = $this->user->id;
            $newUploadedImage->filename = $filename;
            $newUploadedImage->save();
        }

        MessageNotification::dispatch($this->user, $message, $status, $newUploadedImage ?? null);
    }

    public function failed()
    {
        $message = 'Upload Image Failed - Server Error';
        $status = 'error';
        MessageNotification::dispatch($this->user, $message, $status);
    }

    private function isValidType($type){
        $valid_image_type=array();
        $valid_image_type['image/png']='';
        $valid_image_type['image/jpg']='';
        $valid_image_type['image/jpeg']='';
        $valid_image_type['image/jpe']='';
        $valid_image_type['image/gif']='';
        $valid_image_type['image/tif']='';
        $valid_image_type['image/tiff']='';
        $valid_image_type['image/svg']='';
        $valid_image_type['image/ico']='';
        $valid_image_type['image/icon']='';
        $valid_image_type['image/x-icon']='';

        return isset($valid_image_type[$type]);
    }
}
