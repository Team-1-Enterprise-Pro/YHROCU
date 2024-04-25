<?php
function checkLoggedIn($session) {
    // Check if user is already logged in
    if(isset($session["staffNumber"])) {
        return true;
    }
    else{
    return false;
    }
}



