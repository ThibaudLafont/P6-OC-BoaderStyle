<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Trick\Trick;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * FigureRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrickRepository extends \Doctrine\ORM\EntityRepository
{

    public function findWithMessages($slugName, $page)
    {
        $trick = $this->getEntityManager()->getRepository(Trick::class)
            ->findOneBy(['slugName' => $slugName]);

        // Getting the messages set from given chat page
        $all = $trick->getMessages();  // Get all messages
        $allCount = $all->count();     // Define number of messages

        if($allCount <= 10){
            $messages = $all;     // If there is under 10 messages store it
        }
        else // Else messages needs to be paginate
        {
            $start = ($page-1) * 10;          // Define witch is the first message
            if($start <= $allCount){
                $messages = $trick->getMessages($start);    // If message exists get the slice
            }else{                                          // If it doesn't get last 10 messages
                $messages = $trick->getMessages($allCount - 10);
            }
        }

        return ['trick' => $trick, 'messages'=> $messages];
    }

}
