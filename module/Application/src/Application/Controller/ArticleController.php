<?php
/**
 * ArticleController
 *
 * @author  Diogo Marcos <contato@diogomarcos.com>
 * @version 1.0
 */

namespace Application\Controller;


use Application\Form\AddArticleForm;
use Application\Form\Filter\AddArticleFilter;
use Application\HttpRestJson\WebService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ArticleController extends AbstractActionController
{
    public function indexAction()
    {

        $message = 'Olá Visitante';

        $web_service = WebService::account();
        if($web_service) {
            $message = 'Olá ' . $web_service['name'] . ' (' . $web_service['email'] . ')';
        }
        $this->layout()->setVariable('message' , $message);

        $web_service = WebService::NewsList();

        if (array_key_exists('status', $web_service)) {
            $web_service = array();
        }

        return new ViewModel(array(
            'articles' => $web_service
        ));
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $view = new ViewModel();
        $add_article_form = new AddArticleForm('AddArticleForm');
        $add_article_form->setInputFilter(new AddArticleFilter());

        if($request->isPost()){
            $form_data = $request->getPost();
            $add_article_form->setData($form_data);

            if($add_article_form->isValid()) {
                $form_data = $add_article_form->getData();

                $web_service = WebService::addArticle($form_data);

                if(is_array($web_service) && !empty($web_service)){
                    if (array_key_exists('status', $web_service)) {
                        $this->flashMessenger()->addMessage(array('error' => 'invalid credentials.'));
                    } elseif (array_key_exists('access_token', $web_service)) {
                        self::getSession()->offsetSet('access_token', $web_service['access_token']);
                        $this->flashMessenger()->addMessage(array('success' => 'Login Success.'));
                    }
                }


                return $this->redirect()->toUrl('/article');
            }
        }

        $view->setVariable('addArticleForm', $add_article_form);
        return $view;
    }
}