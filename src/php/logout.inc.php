<?php

session_start();
session_unset();
session_destroy();

// goin back to the home page
header("Location: ../index.php?logout=success");
