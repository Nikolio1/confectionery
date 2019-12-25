<?php


namespace App\Handlers;


use App\Entity\News;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class NewsHandler
 * @package App\Handlers
 */
class NewsHandler
{
    private $targetDirectory;

    /**
     * @var BaseHandler
     */
    public $baseHandler;

    public function __construct(BaseHandler $baseHandler, $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
        $this->baseHandler = $baseHandler;
    }


    public function upload(UploadedFile $file, $path)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(). $path, $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}