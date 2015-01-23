<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 23.01.15
 * Time: 20:08
 */

namespace Lottery\Validator;

use Zend\Validator\AbstractValidator;


class NumberSize extends AbstractValidator
{
    const MSG_MINIMUM = 'msgMinimum';
    const MSG_MAXIMUM = 'msgMaximum';

    public $minimum = 1;
    public $maximum = 15;
    protected $messageVariables = array(
        'min' => 'minimum',
        'max' => 'maximum'
    );
    protected $messageTemplates = array(
        self::MSG_MINIMUM => "You have to draw at least '%min%' up voter.",
        self::MSG_MAXIMUM => "You cannot draw more than '%max%' up voters."
    );

    public function isValid($value)
    {
        $this->setValue($value);

        if ($value < $this->minimum) {
            $this->error(self::MSG_MINIMUM);
            return false;
        }

        if ($value > $this->maximum) {
            $this->error(self::MSG_MAXIMUM);
            return false;
        }

        return true;
    }
}