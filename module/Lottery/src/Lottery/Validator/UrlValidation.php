<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 23.01.15
 * Time: 12:42
 */

namespace Lottery\Validator;

use Zend\Validator\AbstractValidator;


class UrlValidation extends AbstractValidator
{
    const INVALID_URL = 'foo';

    private $pattern = "/^(http:\\/\\/www.wykop.pl|http:\\/\\/wykop.pl|www.wykop.pl|wykop.pl)\\/(wpis)\\/([0-9]*)\\/([a-zA-Z0-9-]*)/";

    protected $messageTemplates = array(
        self::INVALID_URL => "Given url doesn't match wykop url pattern.",
    );

    public function isValid($value)
    {
        $this->setValue($value);

        if (!preg_match($this->pattern, $value)) {
            $this->error(self::INVALID_URL);
            return false;
        }

        return true;
    }
}