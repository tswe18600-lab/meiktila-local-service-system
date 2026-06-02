<?php
session_start();
session_unset(); // Session variables အကုန်ဖျက်မယ်
session_destroy(); // Session ကို အပြီးဖျက်မယ်
header("Location: login.php");
exit();
?>