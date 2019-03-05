<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2019/03/05
 * Time: 16:35
 */

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\MergeCertificate;

class DownloadController extends Controller
{
    /**
     * @Route("/download", name="download")
     */
    public function showAction(Request $request)
    {
        if(isset($_POST['download_pub_key'])){
//            return $this->redirectToRoute('download_pub_key');
        }

        elseif(isset($_POST['download_csr'])){
//            return $this->redirectToRoute('download_csr');
        }

        elseif(isset($_POST['download_cert'])){
//            return $this->redirectToRoute('download_cert');
        }

        elseif(isset($_POST['back'])){
            return $this->redirectToRoute('welcome');
        }

        return $this->render('cert_manager/download.html.twig');
    }

}