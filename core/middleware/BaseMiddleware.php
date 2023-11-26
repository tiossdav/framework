<?php
namespace Tioss\core\middleware;

abstract class BaseMiddleware
{
    abstract public function execute();
}