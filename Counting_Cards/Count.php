<?php
    include 'Includes/Header.php';
?>
    </head>
    <body>

<?php
    #Verify that only Yes or No has been submitted
    switch($_SESSION['Points']) {
        case 'Yes':
            $clnstrPoints = 'Yes';
            break;
        case 'No':
            $clnstrPoints = 'No';
            break;
        default:
            funcSessionKill();
            exit("Quit hacking my card game, pricks");
    }

    #Verify that the Count submitted is an integer
    $arrCount = validInt($_POST['CardCount']);
    if($arrCount[0] == 0) {
        #Assign verified Count Integer
        $clnintCount = $_POST['CardCount'];
        
        #Clear Variables
        unset($arrCount);
    }
    elseif($arrCount[0] == 1) {
        #Print Error Message
        print $arrCount[1];

        #Clear variables and exit
        unset($arrCount);
        exit;
    }
    if($_SESSION['ActualCount'][0] == funcPasswordVerify($clnintCount, 
          $_SESSION['ActualCount'][1])) {
        if($clnstrPoints == 'Yes') {
            print "Darknet Code:  <br> Dolla Dolla Bill Yall<br><br>";
        }
        else {
            print "Congratulations, you were successfully able to count" .
                    " the cards.  But I am afraid your shoe count or " . 
                    " speed was too low to receive Darknet points. " . 
                    " Please go back and try increasing the shoe size " .
                    " and decreasing the speed to earn Darknet points." .
                    "<br><br>";
        }
    }
    else {
        print "While counting cards may sound like a daunting task" .
                ", it is actually quite simple.  As long as you are " .
                "able to do basic addition and subtraction, then you " .
                "can count cards. <br><br>Any face card (Ace, King, " .
                "Queen, Jack) along with Ten is is a -1. So you will " .
                "subtract 1 from the current count.<br>Any Nine, Eight, " .
                "or Seven is a 0. Any Six, Five, Four, Three or Two is a " .
                "+1.<br><br>As an example, you will always start off " .
                "at 0.<br>If a King comes out your count would be 1.<br>" .
                "If a Ten comes out then the count would increase to 2." .
                "<br>Then a Seven comes out, and your count would still " .
                "be 2.<br>If a Jack comes out you would increase the " .
                "count to 3.<br>And finally if a Five comes out you would" .
                " decrease the count to 2. <br>The final count would be 2.";
    }
?>
