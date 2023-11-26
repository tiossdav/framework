<?php

namespace Tioss\core;
abstract class model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_USERNAME = 'user_name';
    public const RULE_USERMAIL = 'user';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    
    public function loadData($data)
    {
        foreach($data as $key => $value)
        {
            if(property_exists($this, $key))
            {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public function label(): array
    {
        return [];
    }

    public function setLabel($aattribute, $value)
    {
        
        return $this->label()[$aattribute] = $value;
    }

    public function getLabel($aattribute)
    {
        
        return $this->label()[$aattribute] ?? $aattribute;
    }

   
    public array $errors = [];
    public string $value = '';

    public function validate()
    {
        foreach($this->rules() as $aattribute => $rules)
        {
            $value = $this->{$aattribute};
           
            foreach($rules as $rule)
            {
                $ruleName = $rule;
                if(!is_string($ruleName))
                {
                    $ruleName = $rule[0];
                }
                if($ruleName === self::RULE_REQUIRED && !$value)
                {
                    $this->addErrorForRule($aattribute, self::RULE_REQUIRED);
                }
                if($ruleName === self::RULE_USERNAME && !preg_match("/^[a-zA-Z0-9]*$/", $value))
                {
                    $this->addErrorForRule($aattribute, self::RULE_USERNAME);
                }
                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))
                {
                    $this->addErrorForRule($aattribute, self::RULE_EMAIL );
                }
                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min'] )
                {
                    $this->addErrorForRule($aattribute, self::RULE_MIN, $rule);
                }
                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max'] )
                {
                    $this->addErrorForRule($aattribute, self::RULE_MAX, $rule);
                }
                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']} )
                {   
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addErrorForRule($aattribute, self::RULE_MATCH, $rule);
                }
                if($ruleName === self::RULE_UNIQUE )
                {
                    $className = $rule['class'];
                    // exit;
                   
                    $uniqueAttribute = $rule['aattribute'] ?? $aattribute;
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttribute = :$uniqueAttribute ");
                    $statement->bindValue(":$uniqueAttribute", $value );
                    $statement->execute();
                    $record = $statement->fetchObject();

                    if($record)
                    {
                        $this->addErrorForRule($aattribute, self::RULE_UNIQUE, ['field' => $this->getLabel($aattribute)]);
                    }
                }
            }
        }
                
        return empty($this->errors);
    }
    
    private function addErrorForRule(string $aattribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach($params as $key => $value)
        {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$aattribute][] = $message;
    }

    public function addError(string $aattribute, string $message)
    { 
        $this->errors[$aattribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_USERNAME => 'Invalid Username',
            self::RULE_USERMAIL => 'User not found',
            self::RULE_EMAIL    => 'This field must be valid email address',
            self::RULE_MIN      => 'Min length of this field must be {min}',
            self::RULE_MAX      => 'Max lenght of this field must be {max}',
            self::RULE_MATCH    => 'This field must be the same as {match}',
            self::RULE_UNIQUE   => 'Record with this {field} already exist ',
        ];
    }

    public function hasError($aattribute){
        return $this->errors[$aattribute] ?? false;
    }
    public function getFirstError($aattribute){
      
        return $this->errors[$aattribute][0] ?? false; 
    }

}