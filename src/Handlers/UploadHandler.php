<?php

namespace App\Handlers;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class UploadHandler
 *
 * @package App\Handlers
 */
class UploadHandler
{
    /**
     * @var
     */
    private $targetDirectory;

    /**
     * UploadHandler constructor.
     *
     * @param $targetDirectory
     */
    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * @param $fileName
     * @param $path
     */
    public function removeFile($fileName, $path)
    {
        $pathFile = $this->getTargetDirectory() . $path . '/' . $fileName;

        if (file_exists($pathFile)) {
            unlink($pathFile);
        }
    }

    /**
     * @param UploadedFile $file
     * @param $path
     *
     * @return string
     */
    public function upload(UploadedFile $file, $path)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $safeFilename = md5($originalFilename);

        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        $file->move($this->getTargetDirectory() . $path, $fileName);

        return $fileName;
    }

    /**
     * @return mixed
     */
    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}