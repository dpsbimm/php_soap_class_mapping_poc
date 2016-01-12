<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BusinessObject;
use AppBundle\Processor\SoapProcessor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SoapClient;
use SoapServer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Zend\Soap\AutoDiscover;
use Zend\Soap\Wsdl\ComplexTypeStrategy\ArrayOfTypeComplex;

class DefaultController extends Controller
{
    /**
     * @Route("/server", name="soap_server")
     *
     * @param Request $request
     */
    public function soapServerAction(Request $request)
    {
        if ($request->query->get('wsdl') !== null) {
            $complexTypeStrategy = new ArrayOfTypeComplex();

            $autoDiscover = new AutoDiscover($complexTypeStrategy);
            $autoDiscover->setClass(SoapProcessor::class);
            $autoDiscover->setUri(
                $this->generateUrl('soap_server', array(), UrlGeneratorInterface::ABSOLUTE_URL)
            );

            $wsdl = $autoDiscover->generate();
            echo $wsdl->toXml();

            exit;
        }

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
