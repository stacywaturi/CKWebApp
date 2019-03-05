<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2019/03/04
 * Time: 10:39
 */

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\MergeCertificate;

class MergeController extends Controller
{
    /**
     * @Route("/merge", name="merge")
     */
    public function showAction(Request $request)
    {
        $form = $this->createForm(MergeCertificate::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Redirect to Login Page
            return $this->redirectToRoute('welcome');
        }

        return $this->render('cert_manager/merge.html.twig', [
            'form' => $form->createView()
        ]);
    }

}