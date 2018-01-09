<?php
namespace AppBundle\DataFixtures\ORM;

// Uses
use AppBundle\Entity\Trick\Category;
use AppBundle\Entity\Trick\Trick;
use AppBundle\Entity\Trick\TrickImage;
use AppBundle\Entity\Trick\TrickVideo;
use AppBundle\Entity\User\User;
use AppBundle\Entity\User\UserImage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Fixtures
 * Permit to load a initial set of snow tricks
 *
 * @package AppBundle\DataFixtures\ORM
 */
class Fixtures extends Fixture
{

    /**
     * Main method used by fixture feature in order to load datas in DB
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager){

        // Call the users load property
        $this->loadUsers($manager);

        // Call the categories load property
        $this->loadCategories($manager);

        // Call the tricks load property
        $this->loadTricks($manager);

    }

    /**
     * Used to parse users yalm file and load content in DB
     *
     * @param $manager
     */
    private function loadUsers($manager){
        // First get and parse the yaml file
        $users = Yaml::parse(file_get_contents(__DIR__ . '/data/user.yml'));

        // Loop on get data
        foreach($users as $value){

            // First create and hydrate the user's profile image
            $img = new UserImage();

            // Copy the image to a temp folder, in order to upload it in web root dir
            $fileName =  $value['img']['name'] . '.jpeg'; // Image path definition
            $dest = __DIR__ . '/media/tmp/' . $fileName;  // Destination path definition
            copy(                                         // Copy of the file to a temp dir
                __DIR__ . '/media/user/' . $fileName,
                $dest
            );

            // Create and assign the copied user image
            $file = new File($dest, $fileName);
            $img->setFile($file);

            // Create and hydrate the user from the parsed data
            $user = new User();
            $user->setFirstName($value['firstName']);
            $user->setLastName($value['lastName']);
            $user->setUserName($value['userName']);
            $user->setPlainPassword($value['password']);
            $user->setMail($value['mail']);
            $user->setImg($img);

//            $manager->persist($img);
            $manager->persist($user); // Persist the created user
        }

        // After the loop, flush the persisted users and userImages
        $manager->flush();
    }

    /**
     * Used to parse categories yalm file and load content in DB
     *
     * @param $manager
     */
    private function loadCategories($manager){
        // Load and parse the categories yalm file
        $categories = Yaml::parse(file_get_contents(__DIR__ . '/data/category.yml'));

        // Loop on results
        foreach($categories as $value){
            // Create and hydrate the category
            $category = new Category();
            $category->setName($value);

            // Persist the category
            $manager->persist($category);
        }

        // Once loop is done, flush the persisted categories
        $manager->flush();
    }

    /**
     * Used to parse tricks yalm file and load content in DB
     *
     * @param $manager
     */
    private function loadTricks($manager)
    {
        // Load and parse the tricks yalm file
        $tricks = Yaml::parse(file_get_contents(__DIR__ . '/data/trick.yml'));

        foreach ($tricks as $value) {
            // Author find
            $em = $manager->getRepository('AppBundle:User\User');
            $author = $em->findOneBy(['userName' => $value['author']]);

            // Category find
            $em = $manager->getRepository('AppBundle:Trick\Category');
            $category = $em->findOneBy(['name' => $value['category']]);

            // Figure creation
            $trick = new Trick();
            $trick->setName($value['name']);
            $trick->setDescription($value['description']);
            $trick->setAuthor($author);
            $trick->setCategory($category);

            // Persist trick in order to assign it to related imgs and videos
            $manager->persist($trick);

            // Images creation
            $i=1;  // Creation of index for images position
            foreach ($value['img'] as $img_value) {

                // Creation of a new TrickImage
                $img = new TrickImage();

                // Copy of the related img to a temp file (in order to upload it)
                $fileName =  $img_value['name'] . '.' . $img_value['format'];  // Generate filename to founded img file
                $dest = __DIR__ . '/media/tmp/' . $fileName;                   // Generate a temp filename for the upload
                copy(                                                          // Copy the file to temp directory
                    __DIR__ . '/media/trick/' . $fileName,
                    $dest
                );
                $file = new File($dest, $fileName);                            // Creation of a File Object from the temp copied image file

                // Hydratation of TrickImage object from fetched yalm data
                $img->setFile($file);
                $img->setName($img_value['name']);
                $img->setAlt($img_value['alt']);
                $img->addTrick($trick);
                $img->setPosition($i);
                $i++;  // Incrementation of index for position

                // Persist the created TrickImage
                $manager->persist($img);
            }

            // Videos creation
            $i=1;  // Creation of index for videos position
            if(!empty($value['video'])){
                foreach ($value['video'] as $video_value) {

                    // Video creation and hydration from yalm's fetched data
                    $video = new TrickVideo();
                    $video->setName($video_value['name']);
                    $video->setSrc($video_value['src']);
                    $video->setAlt($video_value['alt']);
                    $video->addTrick($trick);
                    $video->setPosition($i);
                    $i++;  // Incrementation of index for position

                    // Persist the TrickVideo
                    $manager->persist($video);
                }
            }

            // Flush at end
            $manager->flush();
        }
    }
}
