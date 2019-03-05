<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2019/03/05
 * Time: 11:14
 */

namespace AppBundle\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ViewKeyController extends Controller
{
    /**
     * @Route("/view_key", name="view_key")
     */
    public function showAction(Request $request)
    {
        $key = [
        'key_type' => 'RSA',
        'key_size' => 2048,
        'created' => '7/31/2018, 3:39:10 PM',
        'updated' => '7/31/2018, 3:39:10 PM',

        ];

        $key_id = 'https://tf-test-vault.vault.azure.net/keys/cert4/81cb3610b94c4950b7b8223b1574be3c';

        $operations=[
            'Encrypt',
            'Sign',

        ];

        if(isset($_POST['download'])){
            return $this->redirectToRoute('download');
        }

        return $this->render('cert_manager/view_key.html.twig',
            array('key'=>$key,'key_id'=>$key_id,'operations'=>$operations));
//            'key_id'=>$key_id,
//            array('operations'=>$operations)]);
    }

}