<?php
namespace Tioss\core\form;

use Tioss\core\model;

class Field 
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_FILE = 'file';
    public const TYPE_HIDDEN = 'hidden';
    public const INPUT_TYPE = 'input';

    public string $type;

    public Model $model;
    public string $aattribute;
    public string $value;

    public function __construct(Model $model, string $aattribute , $value = '')
    {
        $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->aattribute = $aattribute;
        $this->value = $value;
    }

    public function __toString()
    {
        return sprintf('
            <div class="input-box">
                <label>%s</label>
                <input type="%s" name="%s" value="%s" class="%s" >
            </div>
            <div class= "invalid-feedback">
                %s
            </div>'
        ,  
            $this->model->getLabel($this->aattribute),
            $this->type,
            $this->aattribute,
            $this->value ?? $this->model->{$this->aattribute} ,
            $this->model->hasError($this->aattribute) ? ' is-invalid' : '',
            $this->model->getFirstError($this->aattribute)  
        );
    }
    

    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function fileField()
    {
        $this->type = self::TYPE_FILE;
        return $this;
    }
    public function hiddenField()
    {
        $this->type = self::TYPE_HIDDEN;
        return $this;
    }

   
}