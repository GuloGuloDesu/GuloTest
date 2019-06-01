<?php
    error_reporting(E_ALL);

#Disable the website from being directly accessed
    #Create an array of the Website location
    $arrSelfParts = explode('/', htmlentities($_SERVER['PHP_SELF']));

    #Create an array of the webpage OS file location
    $arrFileParts = explode('/', __FILE__);

    #Compare the last variable of the arrays to see if they match
    if(end($arrSelfParts) == end($arrFileParts)) {
        echo 'You do not have access to this web page';

        #Clear variables
        unset($arrSelfParts);
        unset($arrFileParts);
        exit;
    }

    #DBCon.php for DB Connections and PHPFunc for PHP Functions
    require 'DBCon.php';
    require 'PHPFunc.php';

    #Define Constants
    $dteDateTime = date('Y-m-d H:i:s');

#Set Session Data
    #Define the Session User Agent Pepper
    define('DontHackMeBro', 'DontHackMeBro');

    #Start the Session
    session_start();

    #Check to see if the Session already exists
    #if it does create a new ID and set the Session
    if(!isset($_SESSION['WebAccess'])) {
        session_regenerate_id();
        $_SESSION['WebAccess'] = TRUE;
    }
    #Check that the Browser Agent has been set,
    #if not then set to te User Agent with a Pepper
    if(!isset($_SESSION['User_Browser_Agent_OS'])) {
        $_SESSION['User_Browser_Agent_OS'] = md5($_SERVER['HTTP_USER_AGENT']
                . DoNotHackMySessions);
    }
    #Check that the Browser Agent matches the User Agent,
    #if not then a Session hijacking may be taking place
    else {
       if($_SESSION["User_Browser_Agent_OS"] != 
         md5($_SERVER["HTTP_USER_AGENT"] . "DoNotHackMySessions")) {
           #Clear Variables
           unset($dteDateTime);
           unset($strStatusLink); 

           #Kill the session
           funcSessionKill();
           exit("Session Hijacking may be in progress");
       }
   }
   #Check the time of the session 
   #and close if the session is older than 30 mins
    if(isset($_SESSION["LastActivity"]) && 
      (time() - $_SESSION["LastActivity"] > 1800)) {
        #Unset all $_SESSION variables
        session_unset();
        #Destroy the Session
        session_destroy();
        #Expire the Cookie
        setcookie(Session_name(), "", time() -3600);
    }
    else {
        $_SESSION["LastActivity"] = time();
    }

    #Determing the current website loading, and build a custom header page
        #Check if the user is on the counting page
    if(strtolower(htmlentities($_SERVER["PHP_SELF"])) == "/countingcards/cardgame.php") {
        #Assign the Page Title
        $strPageTitle = "DCDarknet Card Counting Quest";
        $strHomePage = "<a href='CardGame.php?Shoes=7&Speed=1'>Home</a>";
    }
    #Check if the user is on the FileName_Form page
    if(strtolower(htmlentities($_SERVER["PHP_SELF"])) == "/countingcards/count.php") {
        #Assign the Page Title
        $strPageTitle = "DCDarknet Card Counting Quest Submit";
        $strHomePage = "<a href='CardGame.php?Shoes=7&Speed=1'>Home</a>";
    }
?>
<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='expires' content='0'>
        <title>
            <?php
                echo $strPageTitle;
            ?>
        </title>
        <script src='js/jquery.min.js'>
        </script>
        <style type='text/css'>
            .currentCard {
                z-index:99;
            }
        </style>
        <?php
            echo $strHomePage . "<br>";

            #Clear Variables
            unset($strPageTitle);
            unset($strHomePage);
        ?>
