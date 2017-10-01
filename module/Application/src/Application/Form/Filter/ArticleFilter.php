<?php
/**
 * ArticleFilter
 *
 * @author  Diogo Marcos <contato@diogomarcos.com>
 * @version 1.0
 */

namespace Application\Form\Filter;


use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class ArticleFilter extends InputFilter
{
    /**
     * ArticleFilter constructor.
     */
    public function __construct()
    {

        $isEmpty = NotEmpty::IS_EMPTY;

        $this->add(array(
            'name' => 'title',
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
                            $isEmpty => 'O título não pode estar vazio.'
                        )
                    ),
                    'break_chain_on_failure' => true
                )
            ),
        ));

        $this->add(array(
            'name' => 'subtitle',
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
                            $isEmpty => 'O subtítulo não pode estar vazio.'
                        )
                    ),
                    'break_chain_on_failure' => true
                )
            ),
        ));

        $this->add(array(
            'name' => 'text',
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
                            $isEmpty => 'O texto não pode estar vazio.'
                        )
                    ),
                    'break_chain_on_failure' => true
                )
            ),
        ));
    }
}
