<?php
    include 'Includes/Header.php';

    #Example of working URL
    #http://127.0.0.1:8080/CountingCards/CardGame.php?Shoes=2&Speed=2

    #Define Constants
    $strPoints = "<br>";

    #Check first load for Shoes and Speed
    if(!isset($_GET["Shoes"])) {
        $_GET["Shoes"] = 1;
    }
    if(!isset($_GET["Speed"])) {
        $_GET["Speed"] = 1;
    }

    #Verify the shoe number is an integer
    $verifyIntegers = validInt($_GET["Shoes"]);
    if($verifyIntegers[0] == 0) {
        #Assign a verified integer
        $cleanShoe = $verifyIntegers[2];

        #Clear Variables
        unset($verifyIntegers);
    }
    elseif($verifyIntegers[0] == 1) {
        #Print Error Message
        print $verifyIntegers[1];

        #Clear variables
        unset($verifyIntegers);
        exit;
    }

    #Verify that the shoes are not greater than 10
    if($cleanShoe > 10) {
        print "Please keep the amount of shoes below 10";

        #Clear variables
        unset($cleanShoe);
        exit;
    }

    #Verify the speed number is an integer
    $verifyIntegers = validInt($_GET["Speed"]);
    if($verifyIntegers[0] == 0) {
        #Assign a verified integer
        $cleanSpeed = $verifyIntegers[2];

        #Clear Variables
        unset($verifyIntegers);
    }
    elseif($verifyIntegers[0] == 1) {
        #Print Error Message
        print $verifyIntegers[1];

        #Clear variables
        unset($verifyIntegers);
        unset($cleanShoe);
        exit;
    }

    #Verify that the speed is not greater than 5 
    if($cleanSpeed > 5) {
        print "Please keep the speed below 5 seconds.";

        #Clear variables
        unset($cleanSpeed);
        unset($cleanShoe);
        exit;
    }

    #Set the time to a time that jQuery accepts
    $cleanSpeed = $cleanSpeed * 1000;
?>
        <script>
            function cardSwap() {
                var $currentImage = $('div#imageChange IMG.currentCard');
                var $next = $currentImage.next();
            
                $next.addClass('currentCard');

                $currentImage.removeClass('currentCard');
            }
<?php       
    print str_repeat($tab, 3) . "$(function() {\n";
        print str_repeat($tab, 4) . "setInterval('cardSwap()', "
            . $cleanSpeed . ");\n";
    print str_repeat($tab, 3) . "});\n";
?>
        </script>       

    </head>
    <body>
<?php
    #If Speed and Shoe size is greater than X
    #Create a POST variable to submit for points
    #if ($cleanSpeed == 1000 AND $cleanShoe > 6) {
    #        print str_repeat($tab, 2) . "<br>Speed and Shoe size meet " . 
    #                "the mininum requirements for points. Good " . 
    #                "luck!<br><br>\n";
    #    $_SESSION['Points'] = 'Yes';
    #}
    #else {
    #        print str_repeat($tab, 2) . "<br>Please increase the shoe " . 
    #                "size to at least 7 and decrease the speed to at " .
    #                "least 1 to get points.<br><br>\n";  
    #        $_SESSION['Points'] = 'No';
    #}

    #Buttons to increase and decrease shoe size and speed
    print "<a href='" . $_SERVER['PHP_SELF'] . "?Shoes=" . 
            ($cleanShoe + 1) . "&Speed=" . ($cleanSpeed / 1000) . 
            "'>Shoe +1</a><br>\n ";
    print "<a href='" . $_SERVER['PHP_SELF'] . "?Shoes=" . 
            ($cleanShoe - 1) . "&Speed=" . ($cleanSpeed / 1000) . 
            "'>Shoe -1</a><br><br>\n";
    print "<a href='" . $_SERVER['PHP_SELF'] . "?Shoes=" . 
            $cleanShoe . "&Speed=" . (($cleanSpeed / 1000) + 1) . 
            "'>Speed +1</a><br>\n ";
    print "<a href='" . $_SERVER['PHP_SELF'] . "?Shoes=" . 
            $cleanShoe . "&Speed=" . (($cleanSpeed / 1000) - 1) . 
            "'>Speed -1</a><br><br>\n";

    #Pull a list of all picture names from directory
    $shoe = pullDirectory("Pics/");

    #Pre-populate the fullShoe
    $fullShoe = $shoe;

    #Random card count multiplier between 10 and 25
    $randMultiplier = rand(10, 25);

    #Select the amount of cards based on shoe x Random card multiplier
    $cardCount = $randMultiplier * $cleanShoe; 

    #Create a giant array that contains the full shoe
    for ($x=0; $x<=$cleanShoe; $x++) {
        $fullShoe = array_merge($shoe, $fullShoe);
    }

    #Create a randomized array of cards based on the full Shoe and CardCount
    $playerCards = random($cardCount, $fullShoe);

    #Set the starting value of the count
    $count = 0;

    #Create image changer div
    print str_repeat($tab, 2) . "<div id='imageChange'>\n";

    #Loop through all of the playercards to determine values and add pics
    foreach ($playerCards as $playerKey=>$playerCard) {
        #If it is the first card, define the image class
        if ($playerKey == 0) {
            print str_repeat($tab, 3) . "<img src='Pics/" . $playerCard . "' style='" 
                  . "position:absolute' class='currentCard'/>\n";
        }
        else {
            print str_repeat($tab, 3) . "<img src='Pics/" . $playerCard . "' style='" 
                  . "position:absolute'/>\n";

            #Using a case rather than a bunch of if thens to assign point values
            switch (explode("_", $playerCard)[0]) {
                case "Ace":
                    $count = $count - 1;
                    break;
                case "King":
                    $count = $count - 1;
                    break;
                case "Queen":
                    $count = $count - 1;
                    break;
                case "Jack":
                    $count = $count - 1;
                    break;
                case "Ten":
                    $count = $count - 1;
                    break;
                case "Six":
                    $count = $count + 1;
                    break;
                case "Five":
                    $count = $count + 1;
                    break;
                case "Four":
                    $count = $count + 1;
                    break;
                case "Three":
                    $count = $count + 1;
                    break;
                case "Two":
                    $count = $count + 1;
                    break;
                default:
                    break;
            }
        }
    }

    print str_repeat($tab, 2) . "</div>\n";

    #Encrypt the count and assign the random salt to a session
    $passwordHash = passwordHash($count);
    $_SESSION['ActualCount'] = $passwordHash;
    #print "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
    #print "<br>Count:  " . $count . "<br>\n";
?>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <div id='FormBox'>
            <form id='Count' name='Count' action='Count.php' method='post'>
                <fieldset>
                    <p>
                        <label for='CardCount'>
                            Card Count
                        </label>
                        <input 
                            id='CardCount' type='text' name='CardCount'
                            class='text' placeholder='Card Count'>
                        <input type='submit' value='Check'>
                    </p>
                </fieldset>
            </form>
        </div>
    </body>
</html>    
