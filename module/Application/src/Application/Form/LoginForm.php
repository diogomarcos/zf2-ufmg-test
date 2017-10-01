<?php
/**
 * LoginForm
 *
 * @author  Diogo Marcos <contato@diogomarcos.com>
 * @version 1.0
 */

namespace Application\Form;


use Zend\Form\Form;

class LoginForm extends Form
{
    /**
     * LoginForm constructor.
     *
     * @param int|null|string $name
     */
    public function __construct($name)
    {

        parent::__construct($name);
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'username',
            'type' => 'text',
            'options' => array(
                'label' => 'Usuário',
                'id' => 'username',
                'placeholder' => 'example@example'
            )
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'options' => array(
                'label' => 'Senha',
                'id' => 'password',
                'placeholder' => '**********'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Entrar',
                'class' => 'btn btn-success'
            ),
        ));
    }
}
