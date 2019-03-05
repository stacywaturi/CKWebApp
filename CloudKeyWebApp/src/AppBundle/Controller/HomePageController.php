<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2019/03/01
 * Time: 09:18
 */

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class HomePageController extends Controller
{
    /**
     * @Route("/", name="welcome")
     */
    public function showAction(Request $request)
    {
//        $userId = $user->getUsername();

        $certificates = [
            'cert1' => 'pending',
            'cert2' => 'in progress',

        ];

        if(isset($_POST['new'])){
            return $this->redirectToRoute('new_cert');
        }

        elseif(isset($_POST['merge'])){
            return $this->redirectToRoute('merge');
        }

        elseif(isset($_POST['renew'])){
            return $this->redirectToRoute('renew');
        }

        elseif(isset($_POST['view'])){
            return $this->redirectToRoute('view');
        }

        elseif(isset($_POST['download'])){
            return $this->redirectToRoute('download');
        }

        elseif(isset($_POST['delete'])){
            return $this->redirectToRoute('view');
        }

        return $this->render('default/index.html.twig', array('certificates'=> $certificates));
    }
}