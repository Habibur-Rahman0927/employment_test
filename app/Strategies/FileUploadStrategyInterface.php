<?php

namespace App\Strategies;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

interface FileUploadStrategyInterface
{
    /**
     * @param UploadedFile $file
     * @param $directory
     * @return string
     */
    public function fileUpload(UploadedFile $file, $directory): string;
}

?>
