<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Media\TrickImage;
use AppBundle\Entity\Media\TrickVideo;
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

        $form = $this->get('form.factory')->create(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $form->getData();
            $imgs = $trick->getImgs();
            $videos = $trick->getVideos();

            foreach($videos as $video){
                $video->setTrick($trick);
            }

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

}
