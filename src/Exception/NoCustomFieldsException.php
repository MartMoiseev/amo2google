<?php

namespace App\Exception;

use DomainException;

/**
 * Class NoCustomFieldsException
 * @package App\Exception
 */
class NoCustomFieldsException extends DomainException
{
    /**
     * @var string
     */
    protected $message = 'No custom fields';
}
