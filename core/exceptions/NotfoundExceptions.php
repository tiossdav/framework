<?php
namespace Tioss\core\exceptions;

class NotfoundExceptions extends \Exception
{
    protected $message = 'Page not found';
    protected $code = 404;
}