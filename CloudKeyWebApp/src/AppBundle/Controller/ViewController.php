<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2019/03/04
 * Time: 11:38
 */

namespace AppBundle\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ViewController extends Controller
{

    /**
     * @Route("/view", name="view")
     */
    public function showAction(Request $request)
    {

         $certificates = array(
             '0' => array(123,'05/08/2019','05/08/2020'),
             '1' => array(456,'01/02/2019','01/02/2021'),
             '3' => array(789,'22/01/2019','22/01/2020')

         );

        if(isset($_POST['renew'])){
            return $this->redirectToRoute('renew');
        }

        elseif(isset($_POST['view_key'])){
            return $this->redirectToRoute('view_key');
        }
        elseif(isset($_POST['view_cert'])){
            return $this->redirectToRoute('view_cert');
        }

        elseif(isset($_POST['delete'])){
            return $this->redirectToRoute('delete');
        }


        return $this->render('cert_manager/view.html.twig', array('certificates'=> $certificates));

    }


}