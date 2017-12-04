<?php
namespace AppBundle\Entity\Media;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Trick;

/**
 * TrickMedia
 *
 * @ORM\Table(name="trick_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrickImageRepository")
 */
class TrickImage extends TrickMedia
{

    /**
     * @ORM\ManyToOne(
     *     targetEntity="\AppBundle\Entity\Trick",
     *     inversedBy="imgs",
     *     cascade={"persist"}
     * )
     */
    protected $trick;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\Image(
     *     mimeTypes={ "image/jpeg", "image/png" }
     * )
     */
    public $file;

    /**
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    // CONSTS
    const WEB_DIRECTORY = '/media/img/tricks/';
    const VALID_FORMATS = ['jpeg', 'jpg', 'png'];

    public function getFile(){
        return $this->file;
    }
    public function setFile($file){
        $this->file = $file;
    }

    public function setPosition($position){
        $this->position = $position;
    }
    public function getPosition(){
        return $this->position;
    }

}