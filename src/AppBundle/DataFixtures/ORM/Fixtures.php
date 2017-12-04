<?php
namespace AppBundle\DataFixtures\ORM;

// Uses
use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use AppBundle\Entity\Trick;
use AppBundle\Entity\Category;

use AppBundle\Entity\Media\TrickVideo;
use AppBundle\Entity\Media\TrickImage;
use AppBundle\Entity\Media\UserImage;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{

    public function load(ObjectManager $manager){

        $this->loadUsers($manager);

        $this->loadCategories($manager);

        $this->loadTricks($manager);

        $this->loadMessages($manager);

    }

    private function loadUsers($manager){
        $users =
            [
                [
                    'FirstName' => 'Thibaud',
                    'LastName' => 'Lafont',
                    'UserName' => 'BoucheBee',
                    'Password' => 'pomme'
                ],
                [
                    'FirstName' => 'Marie',
                    'LastName' => 'Johannot',
                    'UserName' => 'Marie',
                    'Password' => 'password'
                ],
                [
                    'FirstName' => 'Adrien',
                    'LastName' => 'Matcheret',
                    'UserName' => 'Barbichel',
                    'Password' => 'pomme'
                ]
            ];

        foreach($users as $value){

            $imgName = $value['FirstName'] . $value['LastName'];
            $imgAlt  = 'Photo de ' . $value['FirstName'] . ' ' . $value['LastName'];

            $img = new UserImage();
            $img->setName($imgName);
            $img->setAlt($imgAlt);
            $img->setFormat('jpg');

            $user = new User();
            $user->setFirstName($value['FirstName']);
            $user->setLastName($value['LastName']);
            $user->setUserName($value['UserName']);
            $user->setPassword($value['Password']);
            $user->setImg($img);

            $manager->persist($user);
        }
        $manager->flush();
    }

    private function loadCategories($manager){
        $categories =
            [
                'One',
                'Two'
            ];

        foreach($categories as $value){
            $category = new Category();
            $category->setName($value);
            $manager->persist($category);
        }
        $manager->flush();
    }

    private function loadTricks($manager)
    {

        $tricks =
            [
                // Trick One
                [
                    'name' => 'Trick One',
                    'description' =>
                        'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                    'author' => 'BoucheBee',
                    'category' => 'One',
                    'images' =>
                        [
                            [
                                'name' => 'Pic1_Trick1',
                                'format' => 'jpg',
                                'alt' => 'Description de la photo 1 de la figure 1'
                            ],
                            [
                                'name' => 'Pic2_Trick1',
                                'format' => 'jpg',
                                'alt' => 'Description de la photo 2 de la figure 1'
                            ],
                            [
                                'name' => 'Pic3_Trick1',
                                'format' => 'jpg',
                                'alt' => 'Description de la photo 3 de la figure 1'
                            ]
                        ],
                    'videos' =>
                        [
                            [
                                'name' => 'Vid1_Trick1',
                                'alt' => 'Vidéo 1 de la figure 1',
                                'src' => 'https://www.youtube.com/watch?v=eRsRIgepQtM'
                            ],
                            [
                                'name' => 'Vid2_Trick1',
                                'alt' => 'Vidéo 2 de la figure 1',
                                'src' => 'https://www.youtube.com/watch?v=eRsRIgepQtM'
                            ]
                        ]
                ],

                // Trick Two
                [
                    'name' => 'Trick Two',
                    'description' =>
                        'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                    'author' => 'Barbichel',
                    'category' => 'One',
                    'images' =>
                        [
                            [
                                'name' => 'Pic1_Trick2',
                                'format' => 'jpg',
                                'alt' => 'Description de la photo 1 de la figure 2'
                            ]
                        ],
                    'videos' =>
                        [
                            [
                                'name' => 'Vid1_Trick2',
                                'alt' => 'Vidéo 1 de la figure 2',
                                'src' => 'https://www.youtube.com/watch?v=eRsRIgepQtM'
                            ],
                            [
                                'name' => 'Vid2_Trick2',
                                'alt' => 'Vidéo 2 de la figure 2',
                                'src' => 'https://www.youtube.com/watch?v=eRsRIgepQtM'
                            ],
                        ]
                ],

                // Trick Three
                [
                    'name' => 'Trick Three',
                    'description' =>
                        'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                    'author' => 'Marie',
                    'category' => 'Two',
                    'images' =>
                        [
                            [
                                'name' => 'Pic1_Trick3',
                                'format' => 'jpg',
                                'alt' => 'Description de la photo 1 de la figure 3'
                            ],
                            [
                                'name' => 'Pic2_Trick3',
                                'format' => 'jpg',
                                'alt' => 'Description de la photo 2 de la figure 3'
                            ],
                            [
                                'name' => 'Pic3_Trick3',
                                'format' => 'jpg',
                                'alt' => 'Description de la photo 3 de la figure 3'
                            ]
                        ],
                    'videos' =>
                        [
                            [
                                'name' => 'Vid1_Trick3',
                                'alt' => 'Vidéo 1 de la figure 3',
                                'src' => 'https://www.youtube.com/watch?v=eRsRIgepQtM'
                            ],
                            [
                                'name' => 'Vid2_Trick3',
                                'alt' => 'Vidéo 2 de la figure 3',
                                'src' => 'https://www.youtube.com/watch?v=eRsRIgepQtM'
                            ]
                        ]
                ]
            ];

        foreach ($tricks as $value) {
            // Author find
            $em = $manager->getRepository('AppBundle:User');
            $author = $em->findOneBy(['userName' => $value['author']]);

            // Category find
            $em = $manager->getRepository('AppBundle:Category');
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
            foreach ($value['images'] as $img_value) {
                $img = new TrickImage();
                $img->setName($img_value['name']);
                $img->setFormat($img_value['format']);
                $img->setAlt($img_value['alt']);
                $img->setTrick($trick);
                $img->setPosition($i);
                $i++;

                $manager->persist($img);
                $manager->flush();
            }

            // Videos creation
            $i=1;
            foreach ($value['videos'] as $video_value) {
                // Video creation
                $video = new TrickVideo();
                $video->setName($video_value['name']);
                $video->setSrc($video_value['src']);
                $video->setAlt($video_value['alt']);
                $video->setTrick($trick);
                $video->setPosition($i);
                $i++;

                $manager->persist($video);
                $manager->flush();
            }
        }
    }

    private function loadMessages($manager){
        // Users find
        $em = $manager->getRepository('AppBundle:User');
        $users = $em->findAll();
        $userMax = count($users) - 1;


        // Tricks find
        $em = $manager->getRepository('AppBundle:Trick');
        $tricks = $em->findAll();
        $trickMax = count($tricks) - 1;

        for($i=0; $i<25; $i++){
            $user = $users[mt_rand(0, $userMax)];
            $trick = $tricks[mt_rand(0, $trickMax)];
            $date = new \DateTime('now', new \DateTimeZone('Europe/Paris'));

            $message = new Message();
            $message->setTrick($trick);
            $message->setUser($user);
            $message->setContent('lorem ipsum et blabla bla blablabla');
            $message->setCreationDate($date);

            $manager->persist($message);
        }

        $manager->flush();
    }

}
