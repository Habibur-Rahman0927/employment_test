<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Repositories\FileUpload\IFileUploadRepository;
use App\Services\FileService;
use App\Strategies\LocalFileUploadStrategy;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FileUploadController extends Controller
{
    protected FileService $fileService;

    public function __construct()
    {
        $storageStrategy =  new LocalFileUploadStrategy(new FileUpload);
        $this->fileService = new FileService($storageStrategy);
    }

    public function fileUpload(Request $request): JsonResponse
    {
        try {
            $fileExist = app(IFileUploadRepository::class);
            if($fileExist->findFirstBy('created_by', Auth::id()))
            {
                $this->deleteExistedFile('created_by');
            }
            $file = $request->file('image');
            $directory = 'upload/user_images';
            $fileUrl = $this->fileService->storeFile($file, $directory);

            if ($fileUrl) {
                return $this->success(['file_url' => $fileUrl], "File uploaded successfully");
            }
            return $this->error('File uploaded failed', [], Response::HTTP_ALREADY_REPORTED);
        } catch (Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }

    private function deleteExistedFile($fieldName) :void
    {
        $deleteFiles = app(IFileUploadRepository::class);
        $deleteFiles->deleteAll($fieldName, Auth::id());
    }
}
