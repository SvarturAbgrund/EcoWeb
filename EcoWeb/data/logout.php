<?php
session_start();
session_destroy();
header("Location: ../presentation/index.php");
exit();
