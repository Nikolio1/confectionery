<?php

namespace App\Handlers;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class NewsHandler
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
     * @param UploadedFile $file
     * @param $path
     *
     * @return string
     */
    public function upload(UploadedFile $file, $path)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $safeFilename =md5($originalFilename);

        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        $file->move($this->getTargetDirectory(). $path, $fileName);

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