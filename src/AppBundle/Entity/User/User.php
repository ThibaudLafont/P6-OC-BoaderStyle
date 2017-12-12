<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="userName", type="string", length=255, unique=true)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToOne(
     *     targetEntity="UserImage",
     *     cascade={"persist", "remove"}
     * )
     */
    private $img;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Message\Message",
     *     mappedBy="user"
     * )
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Trick\Trick", mappedBy="author")
     */
    private $tricks;


      ///////////////////
     ///// SPECIFIC ////
    ///////////////////

    /**
     * Concat and return Firstname + lastname
     *
     * @return string
     */
    public function getFullName(){
        return $this->getFirstName() . ' ' . $this->getLastName();
    }


      ///////////////////
     ///// SETTERS /////
    ///////////////////

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return UserImage
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return UserImage
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return UserImage
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return UserImage
     */
    public function setPassword($password)
    {
        $password = sha1($password);

        $this->password = $password;

        return $this;
    }

    /**
     * @param UserImage $img
     */
    public function setImg(UserImage $img){
        $this->img = $img;
    }


    ///////////////////
    ///// GETTERS /////
    ///////////////////

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
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return UserImage
     */
    public function getImg(){
        return $this->img;
    }

}

