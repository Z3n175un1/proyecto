<?php
session_start();
session_destroy();
header("Location: ../Model/index.html");
exit();
?>