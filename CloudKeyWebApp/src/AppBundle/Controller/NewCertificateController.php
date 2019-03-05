<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2019/03/04
 * Time: 10:19
 */

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\CertificateType;

class NewCertificateController extends Controller
{
    /**
     * @Route("/new", name="new_cert")
     */
    public function showAction(Request $request)
    {
        //Create a new blank user and process the form


        $form = $this->createForm(CertificateType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //Redirect to Login Page
            return $this->redirectToRoute('welcome');

        }

        return $this->render('cert_manager/new_certificate.html.twig', [
            'form' => $form->createView()
        ]);

//        return $this->render('cert_manager/new_certificate.html.twig');
    }

}