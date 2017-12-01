<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Media\TrickImage;
use AppBundle\Entity\Trick;
use AppBundle\Form\TrickType;
use AppBundle\Form\TrickImageType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/add/trick", name="trick_add")
     */
    public function addAction(Request $request)
    {
        $trick = new Trick();

        $img = new TrickImage();
//        $img2 = new TrickImage();
//        $img3 = new TrickImage();

        $trick->setImgs($img);
//        $trick->setImgs($img2);
//        $trick->setImgs($img3);

        $form = $this->get('form.factory')->create(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $form->getData();
            $imgs = $trick->getImgs();

            foreach($imgs as $img){
                $file = $img->getFile();
                $img->setFormat($file->guessExtension());
                $img->setTrick($trick);

                $file->move(
                    $this->getParameter('trick_image_directory'),
                    $img->getFullFileName()
                );
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($trick);
            $em->flush();
        }

        return $this->render('form/_trick.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/edit/{id}", name="trick_edit")
     */
    public function editAction(Request $request, $id)
    {

        $trick = $this->getDoctrine()->getRepository('AppBundle:Trick')->find($id);

        $form = $this->get('form.factory')->create(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            return $this->redirectToRoute('trick_list');
        }

        return $this->render('form/_trick.html.twig', ['form' => $form->createView(), 'task' => $trick]);

    }

    /**
     * @Route("/add/img/", name="img_add")
     */
    public function imgAction(Request $request)
    {
        $img = new TrickImage();
        $form = $this->get('form.factory')->create(TrickImageType::class, $img);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Récupération des données fournies
            $img = $form->getData();
            $file = $img->getFile();

            // Traitement de l'upload
            $fileFormat = $file->guessExtension();
            $filename = md5(uniqid()).'.'.$fileFormat;        // On donne un nom aléatoire à l'image
            $file->move(                                      // On enregistre le fichier
                $this->getParameter('trick_image_directory'),
                $filename
            );

            // MAJ de l'objet TrickImage
            $img->setFile($filename);                         // Enregistrement du nom aléatoire pour retrouver le fichier
            $img->setFormat($fileFormat);                     // Enregistrement du format de l'image

            // Enregistrement en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($img);
            $em->flush();

        }

        return $this->render('form/_trick_image.html.twig', ['form' => $form->createView()]);

    }

}
