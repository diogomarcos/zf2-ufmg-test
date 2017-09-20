<?php
/**
 * Created by PhpStorm.
 * User: diogo
 * Date: 20/09/2017
 * Time: 02:50
 */

namespace Application\Form;


use Application\Form\Filter\AddArticleFilter;
use Zend\Form\Form;

class AddArticleForm extends Form
{
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setInputFilter(new AddArticleFilter());

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'title',
            'type' => 'text',
            'options' => array(
                'label' => 'Título',
                'id' => 'username',
                'required'=>'required'
            )
        ));

        $this->add(array(
            'name' => 'subtitle',
            'type' => 'text',
            'options' => array(
                'label' => 'Subtítulo',
                'id' => 'username',
                'required'=>'required'
            )
        ));

        $this->add(array(
            'name' => 'text',
            'type' => 'text',
            'options' => array(
                'label' => 'Texto',
                'id' => 'username',
                'required'=>'required'
            )
        ));

        $this->add(array(
            'name' => 'password',
            'options' => array(
                'label' => 'Contraseña: ',
            ),
            'attributes' => array(
                'type' => 'password',
                'class' => 'input form-control',
                'required'=>'required'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Enviar',
                'title' => 'Enviar',
                'class' => 'btn btn-success'
            ),
        ));


    }
}