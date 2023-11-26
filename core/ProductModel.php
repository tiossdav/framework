<?php

namespace Tioss\core;

use Tioss\core\DbModel;

abstract class ProductModel extends DbModel
{
    abstract public function getProductId(): string;
}