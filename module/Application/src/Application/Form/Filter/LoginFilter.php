<?php

/**
 * LoginFilter
 *
 * @author  Diogo Marcos <contato@diogomarcos.com>
 * @version 1.0
 */

namespace Application\Form\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;
use Zend\Validator\NotEmpty;

class LoginFilter extends InputFilter
{
    public function __construct(){

        $isEmpty = NotEmpty::IS_EMPTY;

        $this->add(array(
            'name' => 'username',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            $isEmpty => 'O usuário não pode estar vazio.'
                        )
                    ),
                    'break_chain_on_failure' => true
                )
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            $isEmpty => 'A senha não pode estar vazia.'
                        )
                    )
                )
            )
        ));
    }
}
