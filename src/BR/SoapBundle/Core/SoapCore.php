<?php
namespace BR\SoapBundle\Core;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

use BR\SoapBundle\PHP2WSDL\PHPClass2WSDL;

class SoapCore
{
    private $container;

    /**
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Genera el archivo WSDL
     * @param $baseUrl url del wsdl
     */
    public function generateWSDL($baseUrl){
        $wsdlGenerator = new PHPClass2WSDL('BR\SoapBundle\Services\ApiService', $baseUrl.'/soap');

        $wsdlGenerator->generateWSDL(true);
        $actual = $wsdlGenerator->dump();

        $basePath = $this->container->get('kernel')->getRootDir();

        $fs = new Filesystem();

        if(!$fs->exists($basePath.'/../web/soap.wsdl')){
            $fs->touch($basePath.'/../web/soap.wsdl');
            $fs->chmod($basePath.'/../web/soap.wsdl', 0777);
        }
        file_put_contents($basePath.'/../web/soap.wsdl', $actual);
    }

    /**
     * Devuelve la respuesta del Webservice
     * @param $baseUrl url del wsdl
     * @return Response respuesta del Webservice
     */
    public function response($baseUrl){
        $server = new \SoapServer($baseUrl.'/web/soap.wsdl', array('cache_wsdl' => WSDL_CACHE_NONE));
        $server->setObject($this->container->get('br_soap_service'));

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $server->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }
}