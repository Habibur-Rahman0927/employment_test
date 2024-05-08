<?php

namespace App\Services;

use App\Strategies\FileUploadStrategyInterface;

class FileService
{
    protected $fileUploadStrategy;

    /**
     * @param FileUploadStrategyInterface $fileUploadStrategy
     */
    public function __construct(FileUploadStrategyInterface $fileUploadStrategy)
    {
        $this->fileUploadStrategy = $fileUploadStrategy;
    }


    public function storeFile($file, $directory): ?string
    {
        $fileName = $this->fileUploadStrategy->fileUpload($file, $directory);
        return $fileName ? $this->getFullUrl($fileName) : null;
    }

    /**
     * @param $filePath
     * @return string
     */

    public function getFullUrl($filePath): string
    {
        return asset($filePath);
    }

}
