<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\EntityListeners({"AppBundle\EventListener\UserListener"})
 */
class User implements UserInterface, \Serializable
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
     * @Assert\NotBlank()
     */
    private $plainPassword;

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

    public function setPlainPassword($plainPassword){
        $this->plainPassword = $plainPassword;
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

    public function getPlainPassword(){
        return $this->plainPassword;
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

    public function getTricks(){
        return $this->tricks;
    }

    public function getMessages(){
        return $this->messages;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->getId(),
            $this->getUserName(),
            $this->getPassword()
        ]);
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->userName,
            $this->password,
            ) = unserialize($serialized);
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->setPlainPassword(null);
    }
}
