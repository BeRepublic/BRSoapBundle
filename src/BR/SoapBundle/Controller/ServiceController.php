<?php
namespace BR\SoapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{

    /**
     * Controlador del Webservice
     * @param Request $request
     * @return mixed
     */
    public function indexAction(Request $request)
    {
        $baseUrl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
        $wsdl = $request->get('wsdl', false);

        $core = $this->get('soap_core');

        if($wsdl !== false){
            $core->generateWSDL($baseUrl);
        }

        $response = $core->response($baseUrl);

        return $response;
    }

    /**
     * Controlador de pruebas del Webservice
     * @param Request $request
     * @return Response
     */
    public function testAction(Request $request)
    {
        $baseUrl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();

        $client = new \soapclient($baseUrl.'/soap/?wsdl', array("trace" => true, "exception" => 0));
        //var_dump($client->__getFunctions());
        $response = new Response();
        //$response->setContent($client->__soapCall('update', array('id' => 1, 'name' => $request->get('name'))));
        $response->setContent($client->__soapCall('getList', array()));

        return $response;
    }
}