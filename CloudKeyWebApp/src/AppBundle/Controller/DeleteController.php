<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2019/03/06
 * Time: 12:16
 */

namespace AppBundle\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DeleteController extends Controller
{

    /**
     * @Route("/delete", name="delete")
     */
    public function showAction(Request $request)
    {


        if(isset($_POST['yes'])){
            return $this->redirectToRoute('welcome');
        }

        elseif(isset($_POST['no'])){
            return $this->redirectToRoute('welcome');
        }


        return $this->render('cert_manager/delete.html.twig');

    }


}