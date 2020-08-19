<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploadsHelper
{
    private Filesystem $filesystem;
    private SluggerInterface $slugger;

    public function __construct(
        SluggerInterface $slugger,
        Filesystem $filesystem
    ) {
        $this->filesystem = $filesystem;
        $this->slugger = $slugger;
    }
    public function saveFileToDirectoryAndReturnNewFileName(UploadedFile $fileType, string $directory): string
    {
        $originalFilename = pathinfo($fileType->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $fileType->guessExtension();

        $fileType->move(
            $directory,
            $newFilename
        );

        return $newFilename;
    }

    public function removeFileFromDirectory(string $filename, string $directory): void
    {
        $this->filesystem->remove($directory . "/" . $filename);
    }
}
