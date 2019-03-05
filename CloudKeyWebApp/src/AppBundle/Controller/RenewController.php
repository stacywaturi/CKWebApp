<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2019/03/04
 * Time: 11:20
 */

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\RenewCertificate;
class RenewController extends Controller
{

    /**
     * @Route("/renew", name="renew")
     */
    public function showAction(Request $request)
    {
        $form = $this->createForm(RenewCertificate::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Redirect to Login Page
            return $this->redirectToRoute('welcome');
        }

        return $this->render('cert_manager/renew.html.twig', [
            'form' => $form->createView()
        ]);

    }
}