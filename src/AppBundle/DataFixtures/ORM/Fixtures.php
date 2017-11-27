<?php
namespace AppBundle\DataFixtures\ORM;

// Uses
use AppBundle\Entity\User;
use AppBundle\Entity\Trick;
use AppBundle\Entity\Category;

use AppBundle\Entity\TrickVideo;
use AppBundle\Entity\TrickImage;
use AppBundle\Entity\CoverImage;
use AppBundle\Entity\UserImage;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{

    public function load(ObjectManager $manager){

        $this->usersLoad($manager);

        $this->loadCategories($manager);

        $this->tricksLoad($manager);

    }

    private function usersLoad($manager){
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
            $img->setPath('/img/users/');

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
                'Style One',
                'Style Two'
            ];

        foreach($categories as $value){
            $category = new Category();
            $category->setName($value);
            $manager->persist($category);
        }
        $manager->flush();
    }

    private function tricksLoad($manager)
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
                    'category' => 'Style One',
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
                                'format' => 'mp4',
                                'cover' =>
                                    [
                                        'name' => 'Front_Vid1_Trick1',
                                        'format' => 'jpg',
                                        'alt' => 'Représente X'
                                    ]
                            ],
                            [
                                'name' => 'Vid2_Trick1',
                                'alt' => 'Vidéo 2 de la figure 1',
                                'format' => 'mp4',
                                'cover' =>
                                    [
                                        'name' => 'Front_Vid2_Trick1',
                                        'format' => 'jpg',
                                        'alt' => 'Représente X'
                                    ]
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
                    'category' => 'Style One',
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
                                'format' => 'mp4',
                                'cover' =>
                                    [
                                        'name' => 'Front_Vid1_Trick2',
                                        'format' => 'jpg',
                                        'alt' => 'Représente X'
                                    ]
                            ],
                            [
                                'name' => 'Vid2_Trick2',
                                'alt' => 'Vidéo 2 de la figure 2',
                                'format' => 'mp4',
                                'cover' =>
                                    [
                                        'name' => 'Front_Vid2_Trick2',
                                        'format' => 'jpg',
                                        'alt' => 'Représente X'
                                    ]
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
                    'category' => 'Style Two',
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
                                'format' => 'mp4',
                                'cover' =>
                                    [
                                        'name' => 'Front_Vid1_Trick3',
                                        'format' => 'jpg',
                                        'alt' => 'Représente X'
                                    ]
                            ],
                            [
                                'name' => 'Vid2_Trick3',
                                'alt' => 'Vidéo 2 de la figure 3',
                                'format' => 'mp4',
                                'cover' =>
                                    [
                                        'name' => 'Front_Vid2_Trick3',
                                        'format' => 'jpg',
                                        'alt' => 'Représente X'
                                    ]
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
            foreach ($value['images'] as $img_value) {
                $img = new TrickImage();
                $img->setName($img_value['name']);
                $img->setFormat($img_value['format']);
                $img->setPath('/img/tricks/');
                $img->setAlt($img_value['alt']);
                $img->setTrick($trick);

                $manager->persist($img);
                $manager->flush();
            }

            // Videos creation
            foreach ($value['videos'] as $video_value) {
                // CoverImage creation
                $img = new CoverImage();
                $img->setName($video_value['cover']['name']);
                $img->setFormat($video_value['cover']['format']);
                $img->setPath('/img/tricks/video_covers/');
                $img->setAlt($video_value['cover']['alt']);

                $manager->persist($img);
                $manager->flush();

                // Video creation
                $video = new TrickVideo();
                $video->setName($video_value['name']);
                $video->setFormat($video_value['format']);
                $video->setPath('/videos/tricks/');
                $video->setAlt($video_value['alt']);
                $video->setCover($img);
                $video->setTrick($trick);

                $manager->persist($video);
                $manager->flush();
            }
        }
    }

}
