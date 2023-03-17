<?php

namespace App\Entity;

use App\Repository\MyProfileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MyProfileRepository::class)]
#[Vich\Uploadable]
class MyProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    /**
     * @Vich\UploadableField(mapping="my_profile_images", fileNameProperty="image")
     * @Assert\Image(maxSize="5M")
     * @var File|null
     */
    private ?string $image = null;

    // #[ORM\Column(length: 255, nullable: true)]

    // private $imageFile;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function setImageFile(File $imageFile = null)
    // {
    //     $this->imageFile = $imageFile;

    //     // VERY IMPORTANT:
    //     // It is required that at least one field changes if you are using Doctrine,
    //     // otherwise the event listeners won't be called and the file is lost
    //     if (null !== $imageFile) {
    //         // if 'updatedAt' is not defined in your entity, use another property
    //         $this->updatedAt = new \DateTime('now');
    //     }
    // }

    // public function getImageFile(): ?File
    // {
    //     return $this->imageFile;
    // }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
