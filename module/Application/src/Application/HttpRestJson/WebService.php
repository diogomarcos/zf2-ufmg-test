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

    const PAGE_SIZE = 30;

    /**
     * authenticate: Realizar a autenticação no sistema
     *
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

    /**
     * account: Retorna as informações do usuário logado
     *
     * @return mixed|null
     *
     * @throws \Zend\Http\Exception\InvalidArgumentException
     * @throws \Zend\Session\Exception\InvalidArgumentException
     */
    public static function account()
    {
        $result = null;
        if (LoginController::getSession()->offsetExists('access_token')) {
            $header = self::addHeader();

            $result = self::dispatchRequestAndDecodeResponse(
                self::API . self::URL_ACCOUNT,
                Request::METHOD_POST,
                null,
                $header
            );
        }

        return $result;
    }

    /**
     * newsList: Retorna a listagens com as notícias
     *
     * @param int $page
     *
     * @return mixed|null
     *
     * @throws \Zend\Http\Exception\InvalidArgumentException
     * @throws \Zend\Session\Exception\InvalidArgumentException
     */
    public static function newsList($page)
    {
        $result = null;
        if (LoginController::getSession()->offsetExists('access_token')) {
            $header = self::addHeader();

            $result = self::dispatchRequestAndDecodeResponse(
                self::API . self::URL_NEWS . '?page=' . $page . '&page_size=' . self::PAGE_SIZE,
                Request::METHOD_GET,
                null,
                $header
            );
        }

        return $result;
    }

    /**
     * addArticle: Adicionar uma nova notícia
     *
     * @param array $form_data
     *
     * @return mixed|null
     *
     * @throws \Zend\Http\Exception\InvalidArgumentException
     * @throws \Zend\Session\Exception\InvalidArgumentException
     */
    public static function addArticle($form_data)
    {
        $result = null;
        if (LoginController::getSession()->offsetExists('access_token')) {
            $header = self::addHeader();

            $parameters = array(
                'title' => $form_data['title'],
                'subtitle' => $form_data['subtitle'],
                'text' => $form_data['text']
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
     * viewArticle: Visualizar as informações de uma notícia
     *
     * @param int $id
     *
     * @return mixed|null
     *
     * @throws \Zend\Http\Exception\InvalidArgumentException
     * @throws \Zend\Session\Exception\InvalidArgumentException
     */
    public static function viewArticle($id)
    {
        $result = null;
        if (LoginController::getSession()->offsetExists('access_token')) {
            $header = self::addHeader();

            $result = self::dispatchRequestAndDecodeResponse(
                self::API . self::URL_NEWS . '/' . $id,
                Request::METHOD_GET,
                null,
                $header
            );
        }

        return $result;
    }

    /**
     * editArticle: Editar as informações de uma notícia
     *
     * @param int $id
     * @param object $form_data
     *
     * @return mixed|null
     *
     * @throws \Zend\Http\Exception\InvalidArgumentException
     * @throws \Zend\Session\Exception\InvalidArgumentException
     */
    public static function editArticle($id, $form_data)
    {
        $result = null;
        if (LoginController::getSession()->offsetExists('access_token')) {
            $header = self::addHeader();

            $parameters = array(
                'title' => $form_data->title,
                'subtitle' => $form_data->subtitle,
                'text' => $form_data->text
            );

            $result = self::dispatchRequestAndDecodeResponse(
                self::API . self::URL_NEWS . '/' . $id,
                Request::METHOD_PUT,
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

    /**
     * addHeader: Adicionar o cabeçalho Authorization
     *
     * @return array
     *
     * @throws \Zend\Session\Exception\InvalidArgumentException
     */
    private static function addHeader()
    {
        $header = array(
            'Authorization' => 'Bearer ' . LoginController::getSession()->offsetGet('access_token')
        );

        return $header;
    }
}
