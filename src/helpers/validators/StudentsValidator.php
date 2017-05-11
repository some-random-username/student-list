<?php
namespace src\helpers\validators;
/*
 * переделать
 */

class StudentsValidator extends Validator 
{
    public function __construct($container) {
        parent::__construct($container);        
    }
    
    public function checkEmail($email) {
        $email = trim($email);
        $stmt = $this->db->run('SELECT * FROM students WHERE email = ?', array($email));
        if($stmt->rowCount() > 0) {
            return $errors[] = 'Студент с таким email уже зарегистрирован.';
        }
    }
    
    public function validate($values) {
        $errors = [];
        if(isset($values['name']) and isset($values['lastname'])) {
            if(strlen($values['name']) > 200 or strlen($values['lastname']) > 200) {
                $errors[] = 'Имя или фамилия не должны содержать больше 300 символов.';
            }
            if(!preg_match("/^[а-яА-ЯёЁa-zA-Z0-9-]+$/iu", $values['name'])) {
                $errors[] = 'Недопустимые символы в введенном имени.';
            }
            if(!preg_match("/^[а-яА-ЯёЁa-zA-Z0-9]+$/iu", $values['lastname'])) {
                $errors[] = 'Недопустимые символы в введенной фамилии. Можно использовать только цифры и буквы';
            }
        } else {
            $errors[] = 'Введите имя и фамилию';
        }
        
        if(isset($values['gender'])) {
            if(!($values['gender'] == 'female' or $values['gender'] = 'male')) {
                echo "Ошибка";
            }
        } else {
            $errors[] = 'Пол не выбран';
        }
        
        if(isset($values['groupnum'])) {
            if(strlen($values['groupnum']) < 2  or strlen($values['groupnum']) > 5) {
                $errors[] = 'Название группы должно содержать от 2 до 5 букв или цифр.';
            }
            if(!preg_match("/^[а-яА-ЯёЁa-zA-Z0-9]+$/iu", $values['groupnum'])) {
                $errors[] = 'Недопустимые символы в введенном номере группы. Можно использовать только цифры и буквы';
            }
        } else {
            $errors[] = 'Введите номер группы';
        }
        
        if(isset($values['email'])) {
            if(!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Введите корректный email';
            }           
        } else {
            $errors[] = 'Введите email';
        }
        
        if(isset($values['ege'])) {
            if(is_int($values['ege'])) {
                $error[] = 'Количество баллов должно состоять только из цифр';
            }
            if($values['ege'] > 300) {
                $errors[] = 'Введите корректное количество баллов.';
            }
        } else {
            $errors[] = 'Введите баллы';
        }
        
        if(isset($values['birth'])) {
            if(is_int($values['birth'])) {
                $error[] = 'Год рождения должен состоять из цифр';
            }
            if(($values['birth'] > 2017) or ($values['birth'] < 1900)) {
                $error[] = 'Введите адекватную дату рождения';
            }
        } else {
            $errors[] = 'Введите год рождения';
        }
        
        if(isset($values['local'])) {
            if(!($values['local'] == 'local' or $values['local'] = 'foreign')) {
                echo "Ошибка";
            }
        } else {
            $errors[] = 'Введите статус';
        }
        
        if(!empty($errors)) {
            return $errors;
        }
    }
    
}
