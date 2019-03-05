<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2019/03/01
 * Time: 10:10
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
       return $this->render(
          'auth/login.html.twig',
          array(
              'last_username' => $authenticationUtils->getLastUsername(),
              'error' => $authenticationUtils->getLastAuthenticationError()
          )
        );
    }

    /**
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {
//        return $this->render(
//            'auth/login.html.twig',
//            array(
//                'last_username'
//            );
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

    }
}