<?php

namespace App\Strategies;

use App\Models\FileUpload;
use App\Repositories\BaseRepository;
use Exception;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LocalFileUploadStrategy implements FileUploadStrategyInterface
{

    protected $model;

    public function __construct(FileUpload $model)
    {
        $this->model = $model;
    }

    /**
     * @param UploadedFile $file
     * @param $directory
     * @return string
     * @throws Exception
     */
    public function fileUpload(UploadedFile $file, $directory): string
    {
        try {
            // $directory = 'uploads';
            $originalName = $file->getClientOriginalName();
            $filenameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
            $fileName = (microtime(true)*10000) . '_' . Str::slug($filenameWithoutExtension).".".$file->getClientOriginalExtension();
            $path = public_path($directory);

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file->move($path, $fileName);

            $mimeType = $file->getClientMimeType();

            // Set your data attributes
            $this->model->file_name = $file->getClientOriginalName();
            $this->model->file_url = "{$directory}/{$fileName}"; // Save the relative path
            $this->model->file_storage = 'local';
            $this->model->mime_type = $mimeType;
            $this->model->created_by = Auth::id();
            return $this->model->save() ? $this->model->file_url : false;

        } catch (Exception $e) {
            Log::error('File upload failed');
            throw $e;
        }
    }

}

?>
