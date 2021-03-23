<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");

class Validator{
    
    public static function isEmpty($string = "", $fieldName = "Input"){
        $string = htmlspecialchars($string);
        if(strlen($string) == 0){
            return $fieldName . " can't be empty!";
        }else{
            return "";
        }
    }
    
    public static function isEmail($email = ""){
        $email = htmlspecialchars($email);
        return (strlen(Validator::isEmpty($email))!=0) ? "Email can't be empty!" : ((!filter_var($email, FILTER_VALIDATE_EMAIL)) ? "The email is invalid!" : "");
    }
    
    public static function isPassword($password = ""){
        $password = htmlspecialchars($password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        return (strlen(Validator::isEmpty($password))!=0) ? "Password can't be empty!" :((!$uppercase || !$lowercase || !$number || strlen($password) < 8) ? "Minimum 8 characters, 1 number, 1 uppercase, 1 lowercase" : "");
    }

    public static function isPasswordMatch($string1="", $string2=""){
        $password1 = htmlspecialchars($string1);
        $password2 = htmlspecialchars($string2);
        if( $password1 == $password2 ) return "";
        else return " Passwords do not match";

    }
    
    public static function isNumber($value = "", $fieldName = "Input"){
        $value = htmlspecialchars($value);
        $fieldName = htmlspecialchars($fieldName);
        $number    = preg_match('@[0-9]@', $value);
        return (strlen($value) == 0) ? $fieldName . " can't be empty" : ((!$number) ? $fieldName . " can only contain numbers" : "");
    }
    
    public static function isNumeric($value = ""){
        $value = htmlspecialchars($value);
        if( is_numeric($value) ) return "";
        else return "Only numeric values are allowed";
    }

    public static function isCorrectCredential($email = "", $password = "",$api=false){
        
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
        
        if(strlen($email) == 0) return "Email or Username can't be empty!";
        if(strlen($password) == 0) return "Password can't be empty!";
        
        $dao = new DAO();

        $errorMessage = "Your credentials do not match";
        
            $user = $dao->get("User",$email, "email");

            if(!$user->userId)
            {
                return "Invalid username or password (Error 101)";
            }
            else if($user->userRole == 2 && !$api)
            {
                return "You are not Admin.";
            }
            else if($user->userRole == 1 && $api)
            {
                return "You are not User.";
            }
            else if(strcmp($user->password,  $password ) == 0)
            {
                //the password matches
                return "";
            }
            else
            {
                //the password doesn't match
                return $errorMessage." Invalid username or password (Error 102)";
            }
        

        //Try to see if the input matches the username of a user
        $user = $dao->get("User", $email, "email");
        
        if( $user->userId != null)
        {
            if($user->userRole != "1")
            {
                return "You are not Admin.";
            }
            else if(strcmp($user->password,  $password) == 0)
            {
                //the password matches
                return "";
            }
            else
            {
                //the password doesn't match
                return $errorMessage." (Error 301)";
            }
        }
        $dao->close();
        //For safety return error
        return $errorMessage;
    }

    
    public static function check(){
        $args = func_get_args();
        foreach($args as $arg){
            if(strlen($arg) != 0){
                return false;
            }
        }
        return true;
    }
    
    
}

