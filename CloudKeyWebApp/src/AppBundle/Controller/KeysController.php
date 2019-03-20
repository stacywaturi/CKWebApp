<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2019/03/18
 * Time: 10:08
 */


namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\MergeCertificate;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\CertificateType;
use AppBundle\Form\RenewCertificate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Unirest;


class KeysController extends Controller
{
    /**
     * @Route("/keys", name="create_key")
     * @Method("POST")
     */
    public function createKey(Request $request)
    {
        $data  = json_decode($request->getContent(), true);


        $data = array_merge( $data, array( "user_id" =>$this->getUser()->getId()) );

        $response = $this->makeRequest(json_encode($data));

        var_dump($data);
        return new JsonResponse( $response, 200);
    }

    /**
     * @Route("/keys", name="get_keys")
     * @Method("GET")
     */
    public function getKeys(Request $request)
    {



    }

    public function makeRequest($query)
    {
        $headers = array('Content-Type' => 'application/json');
//        $query = array('id' => 'C:\\Users\\Stacy\\Desktop\\Document signer\\test_sign2.docx');

      //  var_dump($query);
        $response = Unirest\Request::post("http://localhost:5000/cloud_key/api/keys", $headers, $query);
//        $response = Unirest\Request::get("http://localhost:5000/cloud_key/api/keys" );


        $response_body = json_decode($response->raw_body, true);
        return $response_body;
//        $document_details = json_encode($document_details, JSON_PRETTY_PRINT );

    }

}