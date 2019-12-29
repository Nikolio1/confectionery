<?php


namespace App\Handlers;


use App\Entity\Award;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class NewsHandler
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
     * @param $targetDirectory
     */
    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }


    public function upload(UploadedFile $file, $path)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename =md5($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        $file->move($this->getTargetDirectory(). $path, $fileName);


        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}