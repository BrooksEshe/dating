<?php

//function to validate first and last name
function validName($name){
    if(1 === preg_match('~[0-9]+~', $name) OR $name == null)
    {
        return false;
    }
    return true;
}

//function to validate that age is a number and 18 or older
function validAge($age){
    if($age < 18){
        return false;
    }
    else if(is_numeric($age)){
        return true;
    }
    return false;
}

//validate that the phone input is phone number format
function validPhone($phone){
    if(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone)) {
        return true;
    }
    return false;
}

function validateIndoor($indoor){
    $activities = array('TV','Puzzles','Movies','Reading','Cooking','Playing cards',
        'Board games','Video games');
        if (in_array($indoor,$activities)){
            return true;
        }else{
            return false;
        }
}

function validateOutdoor($outdoor){
    $activities = array('Hiking','Walking','Biking','Climbing','Swimming','Collecting');
        if (in_array($outdoor,$activities)){
            return true;
        }else{
            return false;
        }

}