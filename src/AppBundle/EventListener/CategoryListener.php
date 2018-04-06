<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\Trick\Category;
use AppBundle\Service\Sluggifier;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CategoryListener
 * Execute actions when Doctrine work with Trick entities
 *
 * @package AppBundle\EventListener
 */
class CategoryListener
{
    /**
     * @var Sluggifier
     */
    private $sluggifier;

    public function __construct(Sluggifier $sluggifier)
    {
        $this->setSluggifier($sluggifier);
    }

    /**
     * @ORM\PreFlush
     */
    public function preFlush(Category $category)
    {
        $category->setSlugName(
            $this->getSluggifier()->sluggify(
                $category->getName()
            )
        );
    }

    /**
     * @return Sluggifier
     */
    public function getSluggifier(): Sluggifier
    {
        return $this->sluggifier;
    }

    /**
     * @param Sluggifier $sluggifier
     */
    public function setSluggifier(Sluggifier $sluggifier)
    {
        $this->sluggifier = $sluggifier;
    }

}
