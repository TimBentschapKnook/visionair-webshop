<?php


namespace app\controller;


class Validate
{
    private bool $passed = false;
    private array $errors = array();
    private ?Database $database = null;

    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    public function check($source, $items = array()) {
        foreach($items as $item => $rules) {
            foreach($rules as $rule => $rule_value) {
                $value = $source[$item];
                $item = $this->escape($item);

                if($rule === 'required' && empty($value)) {
                    $this->addError("{$item} is required");
                } else if (!empty($value)) {
                    switch($rule) {
                        case 'min':
                            if(strlen($value) < $rule_value) {
                                $this->addError("{$item} must be a minimum of {$rule_value} characters.");
                            }
                            break;

                        case 'max':
                            if(strlen($value) > $rule_value) {
                                $this->addError("{$item} must be a maximum of {$rule_value} characters.");
                            }
                            break;
                        case 'matches':
                            if($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} must match {$item}.");
                            }
                            break;
                        case 'unique':
                            $check = $this->database->get($rule_value, array($item, '=', $value));

                            if($check->count()) {
                                $this->addError("{$item} already exists.");
                            }
                            break;
                    }
                }
            }
        }

        if(empty($this->errors)) {
            $this->passed = true;
        }
    }

    private function addError($error) {
        $this->errors[] = $error;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function passed(): bool
    {
        return $this->passed;
    }

    public function escape(string $string): string
    {
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }
}