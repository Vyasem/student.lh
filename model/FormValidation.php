<?php
namespace model;

class FormValidation
{
    private $formArray = array();
    private $formFields = array();
    private $validationRules = array();

    public function __construct($validData, $formFields, $validationRules)
    {
        $this->formArray = $validData;
        $this->formFields = $formFields;
        $this->validationRules = $validationRules;
    }

    public function checkData($edit)
    {
        $checkEmpty = $this->checkEmpty($edit);
        if($checkEmpty === true)
            return $this->checkCorrect($edit);
        else
            return $checkEmpty;

    }

    private function checkEmpty($edit)
    {
        $formArray = $this->formArray;
        $formFields = $this->formFields;
        $rules = $this->validationRules;

        //Если редактирование и поле с паролем пусто, то пароль на пустоту не проверять
        if($edit && empty($formArray['PASS']))
            $rules['PASS']['check_empty'] = false;

        foreach($formArray as $key => $val)
        {
            if(empty($val) && $rules[$key]['check_empty'])
            {
                $fieldEmpty[strtolower($key) . '_group']['TEXT'] = "Поле $formFields[$key] не может быть пустым";
                $fieldEmpty[strtolower($key) . '_group']['STATUS'] = "is-invalid";
                unset($formArray[$key]);
            }
        }

        $this->formArray = $formArray;

        if(empty($fieldEmpty))
            return true;
        else
            return $fieldEmpty;
    }

    private function checkCorrect($edit)
    {
        $formArray = $this->formArray;
        $formFields = $this->formFields;
        $rules = $this->validationRules;
        foreach($formArray as $key => $val)
        {
            if($edit && empty($val ))
                continue;

            $length = strlen($val);
            if($length < $rules[$key]['min_length'])
            {
                $checkResult[strtolower($key) . '_group']['TEXT'] = "Поле $formFields[$key] должно содержать не менее " .  $rules[$key]['min_length'] . "  символов. У вас $length символов";
                $checkResult[strtolower($key) . '_group']['STATUS'] = "is-invalid";
            }
            else if($length > $rules[$key]['max_length'])
            {
                $checkResult[strtolower($key) . '_group']['TEXT'] = "Поле $formFields[$key] должно содержать не более " . $rules[$key]['max_length'] . " символов. У вас $length символов";
                $checkResult[strtolower($key) . '_group']['STATUS'] = "is-invalid";
            }
            else
            {
               (count($rules[$key]['rule']) > 1) ? $checkNumber = 0 : $checkNumber = 1;

                foreach($rules[$key]['rule'] as $rKey => $value)
                {
                    if(is_numeric($value))
                    {
                        if($rKey == 0 && $val < $value)
                        {
                            $checkResult[strtolower($key) . '_group']['TEXT'] = "Поле $formFields[$key] " .  $rules[$key]['text'];
                            $checkResult[strtolower($key) . '_group']['STATUS'] = "is-invalid";
                        }
                        else if($rKey == 1 && $val > $value)
                        {
                            $checkResult[strtolower($key) . '_group']['TEXT'] = "Поле $formFields[$key] " .  $rules[$key]['text'];
                            $checkResult[strtolower($key) . '_group']['STATUS'] = "is-invalid";
                        }

                        continue;
                    }

                        $checkRule = preg_match($value, $val, $result);
                        if($checkRule == $checkNumber)
                        {
                            $checkResult[strtolower($key) . '_group']['TEXT'] = "Поле $formFields[$key] " .  $rules[$key]['text'];
                            $checkResult[strtolower($key) . '_group']['STATUS'] = "is-invalid";
                        }
                }
            }
        }

        if(empty($checkResult))
            return true;
        else
            return $checkResult;
    }
}