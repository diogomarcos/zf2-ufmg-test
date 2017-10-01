<?php
/**
 * ArticleController
 *
 * @author  Diogo Marcos <contato@diogomarcos.com>
 * @version 1.0
 */

namespace Application\Controller;


use Application\Form\ArticleForm;
use Application\Form\Filter\ArticleFilter;
use Application\HttpRestJson\WebService;
use Zend\Hydrator\ObjectProperty;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ArticleController extends AbstractActionController
{
    /**
     * indexAction: Exibir as relações de notícias
     *
     * @return ViewModel
     *
     * @throws \Zend\Session\Exception\InvalidArgumentException
     * @throws \Zend\Http\Exception\InvalidArgumentException
     */
    public function indexAction()
    {
        $this->viewAccount();

        $page = $this->params()->fromQuery('page', 1);

        $web_service = WebService::newsList($page);

        $articles = $web_service['items'];
        $total = $web_service['total'];

        if (array_key_exists('status', $web_service)) {
            $articles = array();
        }

        return new ViewModel(array(
            'articles' => $articles,
            'total' => $total,
            'page_size' => WebService::PAGE_SIZE
        ));
    }

    /**
     * addAction: Adicionar uma nova notícia
     *
     * @return \Zend\Http\Response|ViewModel
     *
     * @throws \Zend\Session\Exception\InvalidArgumentException
     * @throws \Zend\Http\Exception\InvalidArgumentException
     * @throws \Zend\Form\Exception\DomainException
     * @throws \Zend\Form\Exception\InvalidArgumentException
     */
    public function addAction()
    {
        $this->viewAccount();

        $request = $this->getRequest();

        $view = new ViewModel();
        $add_article_form = new ArticleForm('ArticleForm');
        $add_article_form->setInputFilter(new ArticleFilter());

        if ($request->isPost()) {
            $form_data = $request->getPost();
            $add_article_form->setData($form_data);

            if ($add_article_form->isValid()) {
                //$form_data = $add_article_form->getData();

                $web_service = WebService::addArticle($form_data);

                if (is_array($web_service) && !empty($web_service)) {
                    $this->flashMessenger()->addMessage(array('success' => 'Notícia adicionada com sucesso.'));
                } else {
                    $this->flashMessenger()->addMessage(array('error' => 'Houve um erro ao adicionar a notícia.'));
                }

                return $this->redirect()->toUrl('/article');
            }
        }

        $view->setVariable('addArticleForm', $add_article_form);
        return $view;
    }

    /**
     * viewAction: Visualizar a notícia
     *
     * @return \Zend\Http\Response|ViewModel
     *
     * @throws \Zend\Session\Exception\InvalidArgumentException
     * @throws \Zend\Http\Exception\InvalidArgumentException
     * @throws \Zend\Mvc\Exception\DomainException
     * @throws \Zend\Mvc\Exception\RuntimeException
     */
    public function viewAction()
    {
        $this->viewAccount();

        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('article', array(
                'action' => 'index'
            ));
        }

        $web_service = WebService::viewArticle($id);

        return new ViewModel(array(
            'article' => $web_service
        ));
    }

    /**
     * editAction: Editar uma notícia
     *
     * @return \Zend\Http\Response|ViewModel
     *
     * @throws \Zend\Session\Exception\InvalidArgumentException
     * @throws \Zend\Http\Exception\InvalidArgumentException
     * @throws \Zend\Form\Exception\DomainException
     * @throws \Zend\Form\Exception\InvalidArgumentException
     * @throws \Zend\Mvc\Exception\DomainException
     * @throws \Zend\Mvc\Exception\RuntimeException
     */
    public function editAction()
    {
        $this->viewAccount();

        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('article', array(
                'action' => 'index'
            ));
        }

        $web_service = WebService::viewArticle($id);

        $request = $this->getRequest();

        $view = new ViewModel();
        $edit_article_form = new ArticleForm('ArticleForm');
        $edit_article_form->setInputFilter(new ArticleFilter());
        $edit_article_form->setHydrator(new ObjectProperty());
        $edit_article_form->bind((object)$web_service);
        $edit_article_form->setOption('escape', true);

        if ($request->isPost()) {
            $form_data = $request->getPost();
            $edit_article_form->setData($form_data);

            if ($edit_article_form->isValid()) {
                //$form_data = $edit_article_form->getData();

                $web_service = WebService::editArticle($id, $form_data);

                if (is_array($web_service) && !empty($web_service)) {
                    $this->flashMessenger()->addMessage(array('success' => 'Notícia editado com sucesso.'));
                } else {
                    $this->flashMessenger()->addMessage(array('error' => 'Houve um erro ao editar a notícia.'));
                }

                return $this->redirect()->toUrl('/article');
            }

        }

        $view->setVariable('editArticleForm', $edit_article_form);
        return $view;
    }

    /**
     * viewAccount: Exibir as informações do usuário logado
     *
     * @throws \Zend\Http\Exception\InvalidArgumentException
     * @throws \Zend\Session\Exception\InvalidArgumentException
     */
    private function viewAccount()
    {
        $message = 'Olá Visitante';

        $web_service = WebService::account();
        if ($web_service) {
            $message = 'Olá ' . $web_service['name'] . ' (' . $web_service['email'] . ')';
        }
        $this->layout()->setVariable('message', $message);
    }
}
