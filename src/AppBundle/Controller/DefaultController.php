<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BusinessObject;
use AppBundle\Processor\SoapProcessor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SoapServer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/server", name="soap_server")
     */
    public function soapServerAction()
    {
        $soapServerOptions = array(
            'classmap' => array(
                'BusinessObject' => BusinessObject::class,
            ),
        );

        $soapServer = new SoapServer(
            $this->generateUrl('soap_server', array('wsdl' => ''), UrlGeneratorInterface::ABSOLUTE_URL),
            $soapServerOptions
        );

        $soapServer->setObject(new SoapProcessor());

        $soapServer->handle();

        exit;
    }
}
