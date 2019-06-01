<?php
    #Disable the website from being directly accessed
    #Create an array of the Website location
     $selfParts = explode('/', htmlentities($_SERVER['PHP_SELF']));

     #Create an array of the webpage OS file location
     $fileParts = explode('/',  __FILE__);

     #Compare the last variable of the arrays to see if they match
     if(end($selfParts) == end($fileParts)) {
        print "You do not have access to this web page";

        #Clear variables
        unset($selfParts);
        unset($fileParts);
        exit;
     }

     #Clean variables for HTML and SQL
     function cleanHTMLSQL($cleanVar) {
         $cleanVar = mysql_real_escape_string($cleanVar);
         $cleanVar = htmlspecialchars($clearVar);

         #Return the cleaned string
         return $cleanVar;
     }

     #Verify that an integer has been submitted
     function validInt($integer) {
         $integer = intval($integer);
         if(!filter_var($integer, FILTER_VALIDATE_INT)) {
             #Create an array, (Error Code, Error Message, Value)
             $integers = array(1, "Only numbers are allowed to be submitted" . 
                " to this form field", $integer);
         }
         else {
             #Create an array, (Error Code, Error Message, Value)
             $integers = array(0, '', $integer);
         }
         #Clear variables
         unset($integer);

         #Return an array
         return $integers;
     }

     #Random Generator
     function random($length, $vars) {
         #Define function constants
         $randVars = array();

         #Loop through the random generator the amount of times specified
         while(count($randVars) < $length) {
             $randVars[] = $vars[mt_rand(0, (count($vars) -1))];
         }

         #Clear variables
         unset($vars);
         unset($length);

         #Return the array of random characters
         return $randVars;
     }

     #Function to kill sessions
     function killSession() {
         #Unset all $_SESSION variables
         session_unset();
         #Destroy the session
         session_destroy();
         #Expire the cookie
         setcookie(session_name(), '', time() - 3600);
     }

     #Function to pull all files in a directory
     function pullDirectory($pathDirectory) {
         if(!file_exists($pathDirectory)) {
             print "File path does not exist";

             #Clear variables
             unset($pathDirectory);
             exit;
         }
         #Pull all files in a directory (Non-recursive)
         $allFiles = scandir($pathDirectory);

         #Clear out . and .. from the array
         unset($allFiles[0]);
         unset($allFiles[1]);

         return($allFiles);
     }

     #Function for salting and hasing passwords
     function funcPasswordSalt($strPassword) {
        #Hash the password to avoid any character incompatibilities
        $strHash = hash("sha256", $strPassword);

        #Generate a pseudo random IV size
        $intMCryptSize = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);

        #Generate a random salt based on the pseudo random IV size
        #You must remove the + otherwise BCrypt will fail
        $strSalt = str_replace("+", ".", base64_encode(
          mcrypt_create_iv($intMCryptSize, MCRYPT_DEV_URANDOM)));

        #Generate the hashed and salted password
        $strPasswordHash = crypt($strHash, "$2y$13$" . $strSalt);

        #Clear variables
        unset($strHash);
        unset($intMCryptSize);

        #Verify there were no errors in generating the hash
        if(strlen($strPasswordHash) < 5) {
            exit("Salting failure<br>Please try again.");
        }

        return array($strPasswordHash, $strSalt);
    }

     #Function to verify a password
     function funcPasswordVerify($strPassword, $strSalt) {
        #Hash the password to avoid any character incompatibilities
        $strHash = hash("sha256", $strPassword);

        #Generate the hashed and salted password
        $strPasswordHash = crypt($strHash, "$2y$13$" . $strSalt);

        #Verify there were no errors in generating the hash
        if(strlen($strPasswordHash) < 5) {
            exit("Salting failure<br>Please try again.");
        }

        #Clear variables
        unset($strHash);

        return $strPasswordHash;
    }



    #Define constant variables to be used
    $tab = "    ";
