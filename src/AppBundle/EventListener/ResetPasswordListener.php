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

/**
 * Class ResetPasswordListener
 * Execute actions when Doctrine work with ResetPassword entities
 *
 * @package AppBundle\EventListener
 */
class ResetPasswordListener
{

    /**
     * When resetting a password a mail is send with reset link
     *
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * ResetPasswordListener constructor.
     * Assign a mailer though depency injection
     *
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer){
        $this->mailer = $mailer;
    }

    /**
     * Generate creationDate and token before persisting a new password reset request
     *
     * @ORM\PrePersist
     */
    public function prePersist(ResetPassword $rp)
    {

        // Generate a new "now" DateTime and assign
        $now =  new \DateTime(
            'now',
            new \DateTimeZone('Europe/Paris')
        );
        $rp->setSubmitDateTime($now);

        // Generate and assign a unique token
        $rp->setToken(sha1(rand()));

        // Set the status of request to enable
        $rp->setDisabled(false);

        // Create and send the reset password mail with the linik
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
