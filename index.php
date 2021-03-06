<?php
//require
require_once ('vendor/autoload.php');
require_once ('model/db-functions.php');

session_start();

//connect to database
$dbh = connect();
if(!$dbh){
    exit;
}

//error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);


//create an instance of the Base class
$f3 = Base::instance();

//create states array
$f3->set('states', array(
    'select'=>'Select',
    'CA'=>"California",
    'OR'=>"Oregon",
    'WA'=>"Washington",
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
    $firstName="";
    $lastName="";
    $age="";
    $gender="";
    $phoneNumber="";

    if(isset($_POST['firstName'])){
        $firstName = $_POST['firstName'];
        if(validName($firstName)){
            $_SESSION['firstName'] = $firstName;
            $isValid = true;
        }else{
            $isValid = false;
            $f3->set("errors['first']", "Please enter a first name.");
        }
    }
    if(isset($_POST['lastName'])){
        $lastName = $_POST['lastName'];
        if(validName($lastName)){
            $_SESSION['lastName'] = $lastName;
            $isValid = true;
        }else{
            $isValid = false;
            $f3->set("errors['last']", "Please enter a last name");
        }
    }
    if(isset($_POST['age'])){
        $age = $_POST['age'];
        if(validAge($age)){
            $_SESSION['age'] = $age;
            $isValid = true;
        }else{
            $isValid = false;
            $f3->set("errors['age']", "Please enter an age 18 or older.");
        }
    }
    if(isset($_POST['gender'])){
        $gender = $_POST['gender'];
        if($gender == 'Male'){
            $f3->set("male","checked=checked");
            $f3->set("female","");
        }
        if($gender == 'Female'){
            $f3->set("female","checked=checked");
            $f3->set("male","");
        }
        $isValid = true;
    }
    if(isset($_POST['phoneNumber'])){
        $phoneNumber = $_POST['phoneNumber'];
        if(validPhone($phoneNumber)){
            $_SESSION['phoneNumber'] = $phoneNumber;
            $isValid = true;
        }else{
            $isValid = false;
            $f3->set("errors['number']", "Please enter an correct phone number.");
        }
    }


    if($isValid){
        if(isset($_POST['premium'])){
            $member = new PremiumMember($firstName,$lastName,$age, $gender, $phoneNumber);
            $_SESSION['member']  = $member;
        }else{
            $member = new Member($firstName,$lastName,$age, $gender, $phoneNumber);
            $_SESSION['member'] = $member;
        }
        $f3 -> reroute('/profile');
    }
    $template = new Template();
    echo $template->render('views/personalinfo.html');
});




$f3->route('GET|POST /profile', function($f3){
    $isValid = false;
    $member = $_SESSION['member'];

    if(isset($_POST['email'])){
        $email = $_POST['email'];
        $member->setEmail($email);
        $isValid = true;
        if($email==""){
            $isValid = false;
            $f3->set("errors['email']","Please enter an email address");
        }
    }

    if(isset($_POST['seeking'])){
        $seeking = $_POST['seeking'];
        $member->setSeeking($seeking);
        $isValid = true;
        if($seeking == 'Male'){
            $f3->set("seekingMale","checked=checked");
            $f3->set("female","");
        }
        if($seeking == 'Female'){
            $f3->set("seekingFemale","checked=checked");
            $f3->set("male","");
        }
    }

    if(isset($_POST['biography'])){
        $biography = $_POST['biography'];
        $member->setBio($biography);
        $isValid = true;
    }

    if(isset($_POST['states'])){
        $states = $_POST['states'];
        $member->setState($states);
        $isValid = true;
    }

    if($_POST['states'] == 'Select'){
        $isValid  = false;
        $f3->set("errors['states']", "Please select a state.");
    }

    if($isValid){
        $_SESSION['member'] = $member;
        if($member instanceof PremiumMember){
            $f3 -> reroute('/interests');
        }else{
            $f3 -> reroute('/summary');
        }
    }
    $template = new Template();
    echo $template->render('views/profile.html');
});




$f3->route('GET|POST /interests', function($f3){
    $member = $_SESSION['member'];
    if(isset($_POST['submit'])){
        if(empty($_POST['indoor']) && empty($_POST['outdoor'])){
            $f3 -> reroute('/summary');
        }else{
            $isValid = false;
            if(isset($_POST['indoor'])){
                $indoor = $_POST['indoor'];
                $indoorString = implode(", ", $indoor);
                $_SESSION['indoorActivities'] = $indoorString;
                $member->setInDoorInterests($indoor);
                $isValid = true;
                foreach($indoor as $activity){
                    if(!(validateIndoor($activity))){
                        $isValid = false;
                        $f3->set("errors['indoor']", "Please choose a correct interest.");
                    }
                }
            }
            if(isset($_POST['outdoor'])){
                $outdoor = $_POST['outdoor'];
                $outdoorString = implode(", ", $outdoor);
                $_SESSION['outdoorActivities'] = "$outdoorString";
                $member->setOutDoorInterests($outdoor);
                $isValid = true;
                if($outdoor==""){
                    return;
                }
                foreach($outdoor as $activity){
                    if(!(validateOutdoor($activity))){
                        $isValid = false;
                        $f3->set("errors['outdoor']", "Please choose a correct interest.");
                    }
                }
            }
            if($isValid){
                $_SESSION['member'] = $member;
                $f3->reroute('/summary');
            }
        }
    }

    $template = new Template();
    echo $template->render('views/interests.html');
});




$f3->route('GET|POST /summary', function(){
    $member = $_SESSION['member'];
    if(!empty($_SESSION['indoorActivities']))
    {
        $_SESSION['outdoorActivities'] = $_SESSION['outdoorActivities'] . ", ";
    }
    if($member instanceof PremiumMember){
        $premium = 1;
        $interests = $_SESSION['outdoorActivities'] . $_SESSION['indoorActivities'];
    }else{
        $premium = 0;
        $interests ="";
    }

    insertMember($member->getFname(),$member->getLname(),$member->getAge(),$member->getGender(),
        $member->getPhone(),$member->getEmail(),$member->getState(),$member->getSeeking(),
        $member->getBio(), $premium, null, $interests);


    $template = new Template();
    echo $template->render('views/summary.html');
});


//show admin page
$f3->route('GET|POST /admin', function($f3){
    $members = getMembers();
    $f3->set('members',$members);

   $template = new Template();
   echo $template->render('views/admin.html');
});

//Define a route to view a student summary
$f3->route('GET|POST /admin/@id', function($f3, $params) {
    $id = $params['id'];
    $member = getMember($id);
    $f3->set('member', $member);

    //load a template
    $template = new Template();
    echo $template->render('views/view-member.html');
});
//run fat free
$f3->run();