<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BusinessObject;
use AppBundle\Processor\SoapProcessor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SoapClient;
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

    /**
     * @Route("/", name="soap_client")
     */
    public function soapClientAction()
    {
        $soapClientOptions = array(
            'classmap' => array(
                'BusinessObject' => BusinessObject::class,
            ),
            'trace' => true,
            'cache_wsdl' => WSDL_CACHE_NONE,
        );

        $soapClient = new SoapClient(
            $this->generateUrl('soap_server', array('wsdl' => ''), UrlGeneratorInterface::ABSOLUTE_URL),
            $soapClientOptions
        );

        $response = $soapClient->getBusinessObject();

        echo 'Response to getBusinessObject:';
        var_dump($response);
        echo '<br />' . PHP_EOL;

        $businessObject = new BusinessObject();
        $businessObject->setFirstValue('i have a first value');
        $businessObject->setSecondValue('i have a second value');

        $response = $soapClient->getFirstValueFromBusinessObject($businessObject);

        echo 'Response to getFirstValueFromBusinessObject:';
        var_dump($response);
        echo '<br />' . PHP_EOL;

        exit;
    }
}
