<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2019/02/28
 * Time: 15:41
 */

namespace  AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends Controller
{

        /**
         * @Route("/register", name="register")
         */
        public function registerAction(Request $request)
        {
            //Create a new blank user and process the form
            $user = new User();
            $form = $this->createForm(UserType::class,$user);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                //Encode new users password
                $encoder = $this->get('security.password_encoder');
                $password = $encoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);

                //Set the role
                $user->setRole('ROLE_USER');

                //Save
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                //Redirect to Login Page
                return $this->redirectToRoute('login');

            }

            return $this->render('auth/register.html.twig', [
                'form' => $form->createView()
            ]);

        }
}
