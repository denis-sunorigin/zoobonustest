<?php

    require_once('helpers.php');

    session_destroy();
    header("Location: index.php");

?>