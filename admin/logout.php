<?php
session_start();
session_unset(); // Session variables တွေကို အကုန်ဖျက်မယ်
session_destroy(); // Session ကို အပြီးတိုင် ဖျက်ဆီးမယ်

header("Location: login.php"); // Login စာမျက်နှာကို ပြန်ပို့မယ်
exit();
?>