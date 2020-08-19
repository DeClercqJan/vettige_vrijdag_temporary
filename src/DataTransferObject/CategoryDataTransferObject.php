<?php

namespace App\DataTransferObject;

use App\Validator\Contraints\IsUniqueCategoryNameOrSameCategory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @IsUniqueCategoryNameOrSameCategory (
 *     message="Deze categorienaam bestaat al voor een andere categorie. Kies een andere"
 * )
 */
class CategoryDataTransferObject
{
    /**
     * @Assert\NotBlank(message="Je moet een naam kiezen")
     */
    public ?string $name = null;

    /**
     * @Assert\NotBlank(message="Je moet een icoon kiezen")
     * @Assert\Image(mimeTypes={"image/svg", "image/svg+xml"}, mimeTypesMessage="Je moet een svg uploaden")
     */
    public ?UploadedFile $icon = null;

    /**
     * @Assert\NotBlank(message="Je moet een afbeelding kiezen")
     * @Assert\Image(mimeTypes={"image/svg", "image/svg+xml"}, mimeTypesMessage="Je moet een svg uploaden")
     */
    public ?UploadedFile $image = null;
}
