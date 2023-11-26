<?php
namespace Tioss\core\exceptions;

class ForbiddenException extends \Exception
{
    protected $message = 'You don\'t have access to the requested page';
    protected $code = 403;
}