<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *  Entity witch represent a registed user
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
     * First name of user
     *
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     * @Assert\NotBlank(message="Le prénom est obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le prénom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le prénom doit faire moins de {{ limit }} caractères"
     * )
     */
    private $firstName;

    /**
     * Last name of user
     *
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     * @Assert\NotBlank(message="Le nom de famille est obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom doit faire moins de {{ limit }} caractères"
     * )
     */
    private $lastName;

    /**
     * Username, used to login
     *
     * @var string
     *
     * @ORM\Column(name="userName", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Le nom d'utilisateur est obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le nom d'utilisateur doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom d'utilisateur doit faire moins de {{ limit }} caractères"
     * )
     */
    private $userName;

    /**
     * Email address of the user
     *
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     * @Assert\NotBlank(message="Le mail est obligatoire")
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas valide.",
     *     checkMX = true
     * )
     */
    private $mail;

    /**
     * Bcrypt password, witch is persisted in DB
     *
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * Plainpassword is used to store the non-crypt password during login, register or resetting password
     *
     * @Assert\NotBlank(message="Veuillez entrer un mot de passe")
     * @Assert\Length(
     *      min = 7,
     *      max = 55,
     *      minMessage = "Le mot de passe doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le mot de passe doit faire moins de {{ limit }} caractères"
     * )
     */
    private $plainPassword;

    /**
     * Profil image of the user
     *
     * @ORM\OneToOne(
     *     targetEntity="UserImage",
     *     cascade={"persist", "remove"}
     * )
     * @Assert\Valid()
     */
    private $img;

    /**
     * User's posted messages
     *
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Message\Message",
     *     mappedBy="user"
     * )
     * @Assert\Valid()
     */
    private $messages;

    /**
     * User's posted tricks
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Trick\Trick", mappedBy="author")
     */
    private $tricks;

    /**
     * Reset password request
     *
     * @ORM\OneToMany(
     *     targetEntity="ResetPassword",
     *     mappedBy="user"
     * )
     */
    private $resetPwd;


    /**
     * Set a ResetPassword Object to the resetPwd attribute
     *
     * @param ResetPassword $rp
     */
    public function setResetPwd(ResetPassword $rp){
        $this->resetPwd = $rp;
    }

    /**
     * Return user's reset password request
     *
     * @return mixed
     */
    public function getResetPwd(){
        return $this->resetPwd;
    }

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
     * @return User
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

    public function setMail($mail){
        if(filter_var($mail, FILTER_VALIDATE_EMAIL)) $this->mail = $mail;
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

    public function getMail(){
        return $this->mail;
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
