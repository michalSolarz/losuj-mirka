<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 28.01.15
 * Time: 12:53
 */

namespace Lottery\Validator;

use Zend\Validator\AbstractValidator;


class VisibleSelect extends AbstractValidator
{
    const INVALID_VALUE = 'foo';

    private $allowedValues = array(0, 1);

    protected $messageTemplates = array(
        self::INVALID_VALUE => "Given value is invalid.",
    );

    public function isValid($value)
    {
        $this->setValue($value);

        if (!in_array($value, $this->allowedValues)) {
            $this->error(self::INVALID_VALUE);
            return false;
        }

        return true;
    }
}