<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 09/12/17
 * Time: 14:52
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\User\ResetPassword;
use Doctrine\ORM\Mapping as ORM;

class ResetPasswordListener
{

    private $mailer;

    public function __construct(\Swift_Mailer $mailer){
        $this->mailer = $mailer;
    }

    /** @ORM\PrePersist */
    public function prePersist(ResetPassword $rp)
    {
        $now =  new \DateTime(
            'now',
            new \DateTimeZone('Europe/Paris')
        );

        $rp->setToken(sha1(rand()));
        $rp->setSubmitDateTime($now);
        $rp->setDisabled(false);

        $message = (new \Swift_Message('Oubli de mot de passe - SnowTricks'))
            ->setFrom('test@test.fr')
            ->setTo($rp->getUser()->getMail())
            ->setBody(
                'Ré-initialisez votre mot de passe <a href="http://snow.lan'.$rp->getUrl().'">ici</a>',
                'text/html'
            );

        $this->mailer->send($message);

    }
}
