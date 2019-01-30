<?php
session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);

//require
require_once ('vendor/autoload.php');

//create an instance of the Base class
$f3 = Base::instance();

//create states array
$f3->set('states', array(
    'AL'=>"Alabama",
    'AK'=>"Alaska",
    'AZ'=>"Arizona",
    'AR'=>"Arkansas",
    'CA'=>"California",
    'CO'=>"Colorado",
    'CT'=>"Connecticut",
    'DE'=>"Delaware",
    'DC'=>"District Of Columbia",
    'FL'=>"Florida",
    'GA'=>"Georgia",
    'HI'=>"Hawaii",
    'ID'=>"Idaho",
    'IL'=>"Illinois",
    'IN'=>"Indiana",
    'IA'=>"Iowa",
    'KS'=>"Kansas",
    'KY'=>"Kentucky",
    'LA'=>"Louisiana",
    'ME'=>"Maine",
    'MD'=>"Maryland",
    'MA'=>"Massachusetts",
    'MI'=>"Michigan",
    'MN'=>"Minnesota",
    'MS'=>"Mississippi",
    'MO'=>"Missouri",
    'MT'=>"Montana",
    'NE'=>"Nebraska",
    'NV'=>"Nevada",
    'NH'=>"New Hampshire",
    'NJ'=>"New Jersey",
    'NM'=>"New Mexico",
    'NY'=>"New York",
    'NC'=>"North Carolina",
    'ND'=>"North Dakota",
    'OH'=>"Ohio",
    'OK'=>"Oklahoma",
    'OR'=>"Oregon",
    'PA'=>"Pennsylvania",
    'RI'=>"Rhode Island",
    'SC'=>"South Carolina",
    'SD'=>"South Dakota",
    'TN'=>"Tennessee",
    'TX'=>"Texas",
    'UT'=>"Utah",
    'VT'=>"Vermont",
    'VA'=>"Virginia",
    'WA'=>"Washington",
    'WV'=>"West Virginia",
    'WI'=>"Wisconsin",
    'WY'=>"Wyoming"
));

$f3->set('interests',array('TV','Puzzles','Movies','Reading','Cooking','Cards',
        'Board games','Video games','Hiking','Walking','Biking','Climbing','Swimming','Collecting'));

require_once('model/validation.php');
//define a default route
$f3->route('GET /', function(){
    $view = new View;
    echo $view->render('views/home.html');
});

$f3->route('GET|POST /personalinfo', function($f3){
    $_SESSION = array();
    $isValid = false;
    if(isset($_POST['firstName'])){
        $firstName = $_POST['firstName'];
        if(validName($firstName)){
            $_SESSION['firstName'] = $firstName;
            $isValid = true;
        }
    }
    if(isset($_POST['lastName'])){
        $lastName = $_POST['lastName'];
        if(validName($lastName)){
            $_SESSION['lastName'] = $lastName;
            $isValid = true;
        }
    }
    if(isset($_POST['age'])){
        $age = $_POST['age'];
        if(validAge($age)){
            $_SESSION['age'] = $age;
            $isValid = true;
        }
    }
    if(isset($_POST['gender'])){
        $gender = $_POST['gender'];
        $_SESSION['gender'] = $gender;
        $isValid = true;
    }
    if(isset($_POST['phoneNumber'])){
        $phoneNumber = $_POST['phoneNumber'];
        if(validPhone($phoneNumber)){
            $_SESSION['phoneNumber'] = $phoneNumber;
            $isValid = true;
        }else{
            $isValid = false;
        }
    }
    if($isValid){
        $f3 -> reroute('/profile');
    }
    $template = new Template();
    echo $template->render('views/personalinfo.html');
});

$f3->route('GET|POST /profile', function($f3){
    $isValid = false;
    if(isset($_POST['email'])){
        $email = $_POST['email'];
        $_SESSION['email'] = $email;
        $isValid = true;
    }
    if(isset($_POST['seeking'])){
        $seeking = $_POST['seeking'];
        $_SESSION['seeking'] = $seeking;
        $isValid = true;
    }
    if(isset($_POST['biography'])){
        $biography = $_POST['biography'];
        $_SESSION['biography'] = $biography;
        $isValid = true;
    }
    if(isset($_POST['states'])){
        $states = $_POST['states'];
        $_SESSION['states'] = $states;
        $isValid = true;
    }
    if($isValid){
        $f3 -> reroute('/interests');
    }
    $template = new Template();
    echo $template->render('views/profile.html');
});

$f3->route('GET|POST /interests', function($f3){
    $isValid = null;
    if(isset($_POST['indoor'])){
        $indoor = $_POST['indoor'];
        $indoorString = implode(", ", $indoor);
        $_SESSION['indoorActivities'] = $indoorString;
        foreach($indoor as $activity){
            if(validateIndoor($activity)){
                $isValid = true;
            }else{
                $isValid = false;
            }
        }
    }
    if(isset($_POST['outdoor'])){
        if(isset($_POST['outdoor'])){
            $outdoor = $_POST['outdoor'];
            $outdoorString = implode(", ", $outdoor);
            $_SESSION['outdoorActivities'] = $outdoorString;
            foreach($outdoor as $activity){
                if(validateoutdoor($activity)){
                    $isValid = true;
                }else{
                    $isValid = false;
                }
            }
        }
    }
    if($isValid){
        $f3 -> reroute('/summary');
    }

    $template = new Template();
    echo $template->render('views/interests.html');
});

$f3->route('GET|POST /summary', function(){

    $template = new Template();
    echo $template->render('views/summary.html');
});




//run fat free
$f3->run();