<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2019/03/01
 * Time: 09:18
 */

namespace AppBundle\Controller;

use AppBundle\Form\MergeCertificate;
use Doctrine\ORM\Query\Printer;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\CertificateType;
use AppBundle\Form\RenewCertificate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Unirest;

class DocumentManagerController extends Controller
{
    public $file;

    /**
     * @Route("/a", name="welcome")
     */
    public function showAction(Request $request)
    {
        if(isset($_POST['new'])){
            return $this->redirectToRoute('new_doc');
        }

        elseif(isset($_POST['sign'])){
            return $this->redirectToRoute('sign');
        }


        elseif(isset($_POST['download'])){
            return $this->redirectToRoute('download');
        }

        elseif(isset($_POST['delete'])){
            return $this->redirectToRoute('delete');
        }

        return $this->render('doc_manager/index.html.twig');

    }

    /**
     * @Route("/new", name="new_doc")
     */
    public function newDocument(Request $request)
    {

        $form = $this->createForm(MergeCertificate::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Redirect to Login Page

            $file= $form['attachment']->getData();

            $this->container->get('session')->set('file', $file);
            return $this->redirectToRoute('doc_viewer');
//            return $this->documentViewer($request, $file);
        }

        return $this->render('doc_manager/merge.html.twig', [
            'form' => $form->createView()
        ]);



    }

    /**
     * @Route("/documents", name="doc_viewer")
     */
    public function documentViewer(Request $request)
    {

        $file = $this->container->get('session')->get('file');

        $headers = array('Content-Type' => 'application/json');
//        $query = array('id' => 'C:\\Users\\Stacy\\Desktop\\Document signer\\test_sign2.docx');
        $query = array('id' => $file);

        $response = Unirest\Request::get("http://localhost:5000/cloud_key/api/documents", $headers, $query);
//        $response = Unirest\Request::get("http://localhost:5000/cloud_key/api/keys" );


        $document_details = json_decode($response->raw_body, true);
//        $document_details = json_encode($document_details, JSON_PRETTY_PRINT );



        if($response->raw_body != "")
        {
            $arr2 = array_map(function($blocks) {
                return $blocks['id'];
            }, $document_details);

           // $arr3 =  array_flip($arr2);


            $formBuilder = $this->createFormBuilder()
                ->add('blocks', ChoiceType::class,[
                     'choices'=> $arr2,
                    'choices_as_values' => true,
                    'choice_value' => function($value)
                    {

                        return $value;
                    }]);

            $form = $formBuilder->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                //Redirect to Login Page

                $block  = $form['blocks']->getData();
                $this->container->get('session')->set('block', $block);
                return $this->redirectToRoute('sign');

            }
            return $this->render('doc_manager/viewer.html.twig', array('documents'=> $document_details, 'form' => $form->createView()));

        }

        return $this->redirectToRoute('new_doc');

    }
    /**
     * @Route("/sign", name="sign")
     */
    public function sign(Request $request)
    {


        $headers = array('Content-Type' => 'application/json');
//        $query = array('id' => 'C:\\Users\\Stacy\\Desktop\\Document signer\\test_sign2.docx');


        $response = Unirest\Request::get("http://localhost:5000/cloud_key/api/certificates?", $headers);
//        $response = Unirest\Request::get("http://localhost:5000/cloud_key/api/keys" );

        $certificate_details = json_decode($response->raw_body, true);

        if($response->raw_body != "") {
            $arr2 = array_map(function ($extract) {
                return $extract['name'];
            }, $certificate_details['certificates']);



//            $arr3 = array_flip($arr2);

            $formBuilder = $this->createFormBuilder()
                ->add('certs', ChoiceType::class,[
                    'choices'=> $arr2,
                ]);

            $form = $formBuilder->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                //Redirect to Login Page

                $certificate  = $form['certs']->getData();



              $this->container->get('session')->set('certificate', $certificate);
                return $this->redirectToRoute('sign_doc');

            }
        }



        return $this->render('doc_manager/sign.html.twig', array('form' => $form->createView()));

    }

    /**
     * @Route("/signDocument", name="sign_doc")
     */

    public function signDocument(Request $request)
    {

        $document_reference= $this->container->get('session')->get('file');
        $signature_setup_id= $this->container->get('session')->get('block');
        $certificate_name = $this->container->get('session')->get('certificate');

        $headers = array('Content-Type' => 'application/json');
        $query = array('signature_setup_id' => $signature_setup_id,
                        'document_reference' => $document_reference,
                        'certificate_name' => $certificate_name);


        $response = Unirest\Request::put("http://localhost:5000/cloud_key/api/certificates?", $headers, $query);

        $certificate_details = json_decode($response->raw_body, true);
        var_dump($certificate_details);
    }
//
//    /**
//     * @Route("/merge", name="merge")
//     */
//    public function merge(Request $request)
//    {
//        $form = $this->createForm(MergeCertificate::class);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            //Redirect to Login Page
//            return $this->redirectToRoute('welcome');
//        }
//
//        return $this->render('cert_manager/merge.html.twig', [
//            'form' => $form->createView()
//        ]);
//    }
//
//    /**
//     * @Route("/renew", name="renew")
//     */
//    public function renew(Request $request)
//    {
//        $form = $this->createForm(RenewCertificate::class);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            //Redirect to Login Page
//            return $this->redirectToRoute('welcome');
//        }
//
//        return $this->render('cert_manager/renew.html.twig', [
//            'form' => $form->createView()
//        ]);
//
//    }
//
//    /**
//     * @Route("/view", name="view")
//     */
//    public function view(Request $request)
//    {
//
//        $certificates = array(
//            '0' => array(123,'05/08/2019','05/08/2020'),
//            '1' => array(456,'01/02/2019','01/02/2021'),
//            '3' => array(789,'22/01/2019','22/01/2020')
//
//        );
//
//        if(isset($_POST['renew'])){
//            return $this->redirectToRoute('renew');
//        }
//
//        elseif(isset($_POST['view_key'])){
//            return $this->redirectToRoute('view_key');
//        }
//        elseif(isset($_POST['view_cert'])){
//            return $this->redirectToRoute('view_cert');
//        }
//
//        elseif(isset($_POST['delete'])){
//            return $this->redirectToRoute('delete');
//        }
//
//        return $this->render('cert_manager/view.html.twig', array('certificates'=> $certificates));
//
//    }
//
//    /**
//     * @Route("/view_cert", name="view_cert")
//     */
//    public function view_cert(Request $request)
//    {
//        $certificate = [
//            'created' => '7/31/2018, 3:39:10 PM',
//            'updated' => '7/31/2018, 3:39:10 PM',
//            'subject'=> 'CN=cert4',
//            'issuer' => 'C=ZA, ST=Gauteng, O=iSolv Technologies, CN=isolvtech.com, E=info@isolvtech.com',
//            'serial_number'=>'1011',
//            'X.509 SHA-1 Thumbprint '=> '07A8451FF5F902ED55C4DA3B218AA040',
//
//        ];
//        $cert_id = 'https://tf-test-vault.vault.azure.net/certificates/cert4/81cb3610b94c4950b7b8223b1574be3c';
//        $key_id = 'https://tf-test-vault.vault.azure.net/keys/cert4/81cb3610b94c4950b7b8223b1574be3c';
//
//
//
//        if(isset($_POST['download'])){
//            return $this->redirectToRoute('download');
//        }
//
//        elseif(isset($_POST['merge'])){
//            return $this->redirectToRoute('merge');
//        }
//
//        elseif(isset($_POST['download_csr'])){
//            return $this->redirectToRoute('download');
//        }
//
//        elseif(isset($_POST['download_cer'])){
//            return $this->redirectToRoute('download');
//        }
//
//        elseif(isset($_POST['download_pfx'])){
//            return $this->redirectToRoute('download');
//        }
//
//        elseif(isset($_POST['delete'])){
//            return $this->redirectToRoute('delete');
//        }
//
//        return $this->render('cert_manager/view_cert.html.twig',
//            array('certificate'=>$certificate,'cert_id'=>$cert_id, 'key_id'=>$key_id));
//
//    }
//
//    /**
//     * @Route("/view_key", name="view_key")
//     */
//    public function view_key(Request $request)
//    {
//        $key = [
//            'key_type' => 'RSA',
//            'key_size' => 2048,
//            'created' => '7/31/2018, 3:39:10 PM',
//            'updated' => '7/31/2018, 3:39:10 PM',
//
//        ];
//
//        $key_id = 'https://tf-test-vault.vault.azure.net/keys/cert4/81cb3610b94c4950b7b8223b1574be3c';
//
//        $operations=[
//            'Encrypt',
//            'Sign',
//
//        ];
//
//        if(isset($_POST['download'])){
//            return $this->redirectToRoute('download');
//        }
//
//        return $this->render('cert_manager/view_key.html.twig',
//            array('key'=>$key,'key_id'=>$key_id,'operations'=>$operations));
//
//    }
//

}