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

class Fixtures extends Fixture
{

    public function load(ObjectManager $manager){

        $this->loadUsers($manager);

        $this->loadCategories($manager);

        $this->loadTricks($manager);

    }

    private function loadUsers($manager){
        $users = Yaml::parse(file_get_contents(__DIR__ . '/data/user.yml'));

        foreach($users as $value){

            $img = new UserImage();
            $fileName =  $value['img']['name'] . '.jpeg';
            $dest = __DIR__ . '/media/tmp/' . $fileName;
            copy(
                __DIR__ . '/media/user/' . $fileName,
                $dest
            );
            $file = new File($dest, $fileName);
            $img->setFile($file);

            $user = new User();
            $user->setFirstName($value['firstName']);
            $user->setLastName($value['lastName']);
            $user->setUserName($value['userName']);
            $user->setPlainPassword($value['password']);
            $user->setMail($value['mail']);
            $user->setImg($img);

            $manager->persist($user);
        }
        $manager->flush();
    }

    private function loadCategories($manager){
        $categories = Yaml::parse(file_get_contents(__DIR__ . '/data/category.yml'));

        foreach($categories as $value){
            $category = new Category();
            $category->setName($value);
            $manager->persist($category);
        }
        $manager->flush();
    }

    private function loadTricks($manager)
    {
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
            $manager->persist($trick);
            $manager->flush();

            // Images creation
            $i=1;
            foreach ($value['img'] as $img_value) {

                $img = new TrickImage();
                $fileName =  $img_value['name'] . '.' . $img_value['format'];
                $dest = __DIR__ . '/media/tmp/' . $fileName;
                copy(
                    __DIR__ . '/media/trick/' . $fileName,
                    $dest
                );
                $file = new File($dest, $fileName);
                $img->setFile($file);
                $img->setName($img_value['name']);
                $img->setAlt($img_value['alt']);
                $img->addTrick($trick);
                $img->setPosition($i);
                $i++;

                $manager->persist($img);
                $manager->flush();
            }

            // Videos creation
            $i=1;
            foreach ($value['video'] as $video_value) {
                // Video creation
                $video = new TrickVideo();
                $video->setName($video_value['name']);
                $video->setSrc($video_value['src']);
                $video->setAlt($video_value['alt']);
                $video->addTrick($trick);
                $video->setPosition($i);
                $i++;

                $manager->persist($video);
                $manager->flush();
            }
        }
    }
}
