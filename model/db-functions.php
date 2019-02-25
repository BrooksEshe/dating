<?php
/**
 * CREATE Table Members(
        member_id int AUTO_INCREMENT PRIMARY KEY,
        fname varchar(20),
        lname varchar(20),
        age int,
        gender varchar(10),
        phone char(12),
        email varchar(30),
        state varchar(20),
        seeking varchar(10),
        bio varchar(255),
        premium tinyint,
        image varchar(20),
        interests varchar (255)
    );
 */

require_once ('/home/beshegre/config.php');

function connect(){
    try{
        $dbh = new PDO(DB_DSN,DB_USERNAME,DB_PASSWORD);
        return $dbh;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
}

function getMembers(){
    global $dbh;

    $sql = "SELECT * FROM Member ORDER BY last, first";
    $statement = $dbh->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getMember($id){
    global $dbh;

    $sql = "SELECT * FROM Member WHERE member_id = :id";
    $statement = $dbh->prepare($sql);
    $statement->bindParam(':id',$id,PDO::PARAM_STR);

    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    return $row;
}



function insertMember($fname,$lname,$age,$gender,$phone,$email,
                        $state, $seeking, $bio, $premium,$image,$interests)
{
    global $dbh;

    $sql = "INSERT INTO Member VALUES(:fname, :lname, :age, :gender, :phone, :email,
                                    :state, :seeking, :bio, :premium, :image, :interests)";

    $statement = $dbh->prepare($sql);

    //bind parameters
    $statement->bindParam(':fname',$fname,PDO::PARAM_STR);
    $statement->bindParam(':lname',$lname,PDO::PARAM_STR);
    $statement->bindParam(':age',$age,PDO::PARAM_STR);
    $statement->bindParam(':gender',$gender,PDO::PARAM_STR);
    $statement->bindParam(':phone',$phone,PDO::PARAM_STR);
    $statement->bindParam(':email',$email,PDO::PARAM_STR);
    $statement->bindParam(':state',$state,PDO::PARAM_STR);
    $statement->bindParam(':seeking',$seeking,PDO::PARAM_STR);
    $statement->bindParam(':bio',$bio,PDO::PARAM_STR);
    $statement->bindParam(':premium',$premium,PDO::PARAM_STR);
    $statement->bindParam(':image',$image,PDO::PARAM_STR);
    $statement->bindParam(':interests',$interests,PDO::PARAM_STR);

    $success = $statement->execute();
    return $success;

}
