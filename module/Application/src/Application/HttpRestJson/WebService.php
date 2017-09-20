<?php
/**
 * WebService
 *
 * @author  Diogo Marcos <contato@diogomarcos.com>
 * @version 1.0
 */

namespace Application\HttpRestJson;


use Application\Controller\LoginController;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;

class WebService
{
    # Constantes com endereços da API
    const API = 'http://150.164.180.61:9999/';
    const URL_AUTHENTICATE = 'authenticate';
    const URL_ACCOUNT = 'account';
    const URL_NEWS = 'news';

    const GRANT_TYPE = 'password';
    const CLIENT_ID = 'cms';

    /**
     * @param $form_data
     *
     * @return mixed
     *
     * @throws \Zend\Http\Exception\InvalidArgumentException
     */
    public static function authenticate($form_data)
    {
        $parameters = array(
            'grant_type' => self::GRANT_TYPE,
            'client_id' => self::CLIENT_ID,
            'username' => $form_data['username'],
            'password' => $form_data['password']
        );

        $result = self::dispatchRequestAndDecodeResponse(
            self::API . self::URL_AUTHENTICATE,
            Request::METHOD_POST,
            $parameters
        );

        return $result;
    }

    public static function account()
    {
        $result = null;
        if (LoginController::getSession()->offsetExists( 'access_token' )) {
            $access_token = LoginController::getSession()->offsetGet('access_token');

            $header = array(
                'Authorization' => 'Bearer ' . $access_token
            );

            $result = self::dispatchRequestAndDecodeResponse(
                self::API . self::URL_ACCOUNT,
                Request::METHOD_POST,
                null,
                $header
            );
        }

        return $result;
    }

    public static function NewsList($page =  1, $page_size = 30)
    {
        $result = null;
        if (LoginController::getSession()->offsetExists( 'access_token' )) {
            $access_token = LoginController::getSession()->offsetGet('access_token');

            $header = array(
                'Authorization' => 'Bearer ' . $access_token
            );

            $result = self::dispatchRequestAndDecodeResponse(
                self::API . self::URL_NEWS . '?page=' . $page . '&page_size=' . $page_size,
                Request::METHOD_POST,
                null,
                $header
            );
        }

        return $result;
    }

    public static function addArticle($form_data)
    {
        $result = null;
        if (LoginController::getSession()->offsetExists( 'access_token' )) {
            $access_token = LoginController::getSession()->offsetGet('access_token');

            $header = array(
                'Authorization' => 'Bearer ' . $access_token
            );

            $parameters = array(
                'title' => $form_data['title'],
                'subtitle' => $form_data['subtitle'],
                'text' => $form_data['text'],
                'password' => $form_data['password']
            );

            $result = self::dispatchRequestAndDecodeResponse(
                self::API . self::URL_NEWS,
                Request::METHOD_POST,
                $parameters,
                $header
            );
        }

        return $result;
    }

    /**
     * @param string $url
     * @param string $method
     * @param null | array $parameters
     * @param null | array $header
     *
     * @return mixed
     *
     * @throws \Zend\Http\Exception\InvalidArgumentException
     */
    private static function dispatchRequestAndDecodeResponse($url, $method, $parameters = null, $header = null)
    {
        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'
        ));
        $request->setUri($url);
        $request->setMethod($method);
        if ($parameters) {
            $request->setPost(new Parameters($parameters));
        }
        if ($header) {
            $request->getHeaders()->addHeaders($header);
        }

        $client = new Client();
        $response = $client->dispatch($request);

        return json_decode($response->getBody(), true);
    }
}