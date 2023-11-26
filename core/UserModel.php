<?php

namespace Tioss\core;

use Tioss\core\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}