<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2019/03/01
 * Time: 09:18
 */

namespace AppBundle\Controller;

use AppBundle\Form\MergeCertificate;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\CertificateType;
use AppBundle\Form\RenewCertificate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class HomePageController extends Controller
{
    /**
     * @Route("/", name="welcomeCertificate")
     *
     */
    public function showAction(Request $request)
    {


//        $userId = $user->getUsername();


        $certificates = array(
            '0' => array('cert1','pending' , '-','-','-','-','-'),
            '1' => array('cert2','complete' , '1/12/2018','12/12/2020','2BDD37FD86DD31F5A..','example1.com','iSolv Technologies'),
            '2' => array('cert4','in progress' , '12/12/2018','-','-','domain.net','-')

        );


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
            return $this->redirectToRoute('delete');
        }

        return $this->render('default/index.html.twig', array('certificates'=> $certificates));
    }

    /**
     * @Route("/new", name="new_cert")
     */
    public function createCertificate(Request $request)
    {

        $form = $this->createForm(CertificateType::class);


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //Redirect to Home Page
            return $this->redirectToRoute('welcome');

        }

        return $this->render('cert_manager/new_certificate.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/merge", name="merge")
     */
    public function merge(Request $request)
    {
        $form = $this->createForm(MergeCertificate::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Redirect to Login Page
            return $this->redirectToRoute('welcome');
        }

        return $this->render('cert_manager/merge.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/renew", name="renew")
     */
    public function renew(Request $request)
    {
        $form = $this->createForm(RenewCertificate::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Redirect to Login Page
            return $this->redirectToRoute('welcome');
        }

        return $this->render('cert_manager/renew.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/view", name="view")
     */
    public function view(Request $request)
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

    /**
     * @Route("/view_cert", name="view_cert")
     */
    public function view_cert(Request $request)
    {
        $certificate = [
            'created' => '7/31/2018, 3:39:10 PM',
            'updated' => '7/31/2018, 3:39:10 PM',
            'subject'=> 'CN=cert4',
            'issuer' => 'C=ZA, ST=Gauteng, O=iSolv Technologies, CN=isolvtech.com, E=info@isolvtech.com',
            'serial_number'=>'1011',
            'X.509 SHA-1 Thumbprint '=> '07A8451FF5F902ED55C4DA3B218AA040',

        ];
        $cert_id = 'https://tf-test-vault.vault.azure.net/certificates/cert4/81cb3610b94c4950b7b8223b1574be3c';
        $key_id = 'https://tf-test-vault.vault.azure.net/keys/cert4/81cb3610b94c495                     0b7b8223b1574be3c';



        if(isset($_POST['download'])){
            return $this->redirectToRoute('download');
        }

        elseif(isset($_POST['merge'])){
            return $this->redirectToRoute('merge');
        }

        elseif(isset($_POST['download_csr'])){
            return $this->redirectToRoute('download');
        }

        elseif(isset($_POST['download_cer'])){
            return $this->redirectToRoute('download');
        }

        elseif(isset($_POST['download_pfx'])){
            return $this->redirectToRoute('download');
        }

        elseif(isset($_POST['delete'])){
            return $this->redirectToRoute('delete');
        }

        return $this->render('cert_manager/view_cert.html.twig',
            array('certificate'=>$certificate,'cert_id'=>$cert_id, 'key_id'=>$key_id));

    }

    /**
     * @Route("/view_key", name="view_key")
     */
    public function view_key(Request $request)
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

    }


}