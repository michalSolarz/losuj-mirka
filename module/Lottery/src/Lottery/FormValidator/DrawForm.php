<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 23.01.15
 * Time: 18:05
 */


namespace Lottery\FormValidator;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class DrawForm implements InputFilterAwareInterface
{
    protected $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'baseLink',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 20,
                            'max' => 100,),
                    ),
                    array(
                        'name' => 'Lottery\Validator\UrlValidation',
                    ),
                ))));

            $inputFilter->add($factory->createInput(array(
                'name' => 'lastUpVoter',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 4,
                            'max' => 40,),
                    ),
                ))));
            $inputFilter->add($factory->createInput(array(
                'name' => 'numbersAmount',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Digits',
                    ),
                    array(
                        'name' => 'Lottery\Validator\NumberSize',
                    ),
                ))));

            $inputFilter->add($factory->createInput(array(
                'name' => 'visible',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Lottery\Validator\VisibleSelect',
                    ),
                ))));

            $this->inputFilter = $inputFilter;

        }
        return $this->inputFilter;
    }
}