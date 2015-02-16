<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 21.01.15
 * Time: 13:21
 */

namespace Lottery\Form;

use Zend\Form\Form;

class DrawForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('draw-setup');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'baseLink',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Link do wpisu',
                'class' => 'form-control',
            ),
            'options' => array(

            ),
        ));
        $this->add(array(
            'name' => 'lastUpVoter',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'placeholder' => 'Ostatni plusujący mirek',
            ),
        ));
        $this->add(array(
            'name' => 'numbersAmount',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'placeholder' => 'Ilość mirków do wylosowania',
            ),
        ));
        $this->add(array(
            'type' => 'Select',
            'name' => 'visible',
            'options' => array(
                'label' => 'Czy losowanie ma być widoczne?',
                'value_options' => array(
                    '0' => 'Nie',
                    '1' => 'Tak',
                ),

            ),
            'attributes' => array(
                'value' => '1',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 600
                )
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'class' => 'form-control',
                'value' => 'Losuj!',
                'id' => 'submit-button',
            ),
        ));
    }
}