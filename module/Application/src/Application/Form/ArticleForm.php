<?php
/**
 * ArticleForm
 *
 * @author  Diogo Marcos <contato@diogomarcos.com>
 * @version 1.0
 */

namespace Application\Form;


use Application\Form\Filter\ArticleFilter;
use Zend\Form\Form;

class ArticleForm extends Form
{
    /**
     * ArticleForm constructor.
     *
     * @param int|null|string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setInputFilter(new ArticleFilter());

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'title',
            'type' => 'text',
            'options' => array(
                'label' => 'Título',
                'required' => 'required'
            ),
            'attributes' => array(
                'size' => 60,
                'class' => 'form-control',
                'placeholder' => 'Informe o título'
            )
        ));

        $this->add(array(
            'name' => 'subtitle',
            'type' => 'text',
            'options' => array(
                'label' => 'Subtítulo',
                'required' => 'required'
            ),
            'attributes' => array(
                'size' => 60,
                'class' => 'form-control',
                'placeholder' => 'Informe o subtítulo'
            )
        ));

        $this->add(array(
            'name' => 'text',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Conteúdo',
                'required' => 'required',
                'label_attributes' => array(
                    'class' => 'control-label'
                ),
            ),
            'attributes' => array(
                'id' => 'editor',
                'class' => 'form-control',
                'cols' => 62,
                'rows' => 15
            ),
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
