<?php

    /* Remove the cookies */
    unset($_COOKIE["name_first"]);
    unset($_COOKIE["name_last"]);
    unset($_COOKIE["name_email"]);

    setcookie("name_first", null, time() - (86400 * 30), "/"); // 86400 = 1 day
    setcookie("name_last", null, time() - (86400 * 30), "/"); // 86400 = 1 day
    setcookie("email", null, time() - (86400 * 30), "/"); // 86400 = 1 day

?>