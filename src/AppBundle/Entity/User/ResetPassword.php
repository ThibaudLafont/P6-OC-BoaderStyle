<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ResetPassword
 *
 * @ORM\Table(name="user_reset_password")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\ResetPasswordRepository")
 * @ORM\EntityListeners({"AppBundle\EventListener\ResetPasswordListener"})
 */
class ResetPassword
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="submit_datetime", type="datetime")
     * @Assert\DateTime()
     */
    private $submitDateTime;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="User",
     *     inversedBy="resetPwd"
     * )
     */
    private $user;

    /**
     * @var bool
     *
     * @ORM\Column(name="disabled", type="boolean")
     * @Assert\Type("boolean")
     */
    private $disabled;


    public function getUrl(){
        $url = '/user/reset-password/' . $this->getToken();
        return $url;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return ResetPassword
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return ResetPassword
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set submitDateTime
     *
     * @param \DateTime $submitDateTime
     *
     * @return ResetPassword
     */
    public function setSubmitDateTime($submitDateTime)
    {
        $this->submitDateTime = $submitDateTime;

        return $this;
    }

    /**
     * Get submitDateTime
     *
     * @return \DateTime
     */
    public function getSubmitDateTime()
    {
        return $this->submitDateTime;
    }

    /**
     * Set pass
     *
     * @param boolean $bool
     *
     * @return ResetPassword
     */
    public function setDisabled($bool)
    {
        $this->disabled = $bool;

        return $this;
    }

    /**
     * Get pass
     *
     * @return bool
     */
    public function getDisabled()
    {
        return $this->disabled;
    }
}

