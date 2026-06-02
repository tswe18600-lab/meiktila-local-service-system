<?php
session_start();

// User က Login ဝင်ထားသလား စစ်ဆေးခြင်း
// 'user_id' ဆိုသည်မှာ Login ဝင်ချိန်တွင် တည်ဆောက်ခဲ့သော Session name ဖြစ်သည်
if (isset($_SESSION['user_id'])) {
    
    // Login ဝင်ထားပြီးသားဆိုလျှင် Categories Page သို့ ပို့မည်
    header("Location: all_categories.php");
    exit();

} else {
    
    // Login မဝင်ရသေးလျှင် Login Page သို့ ပို့မည်
    // (အကယ်၍ Register Page သို့ ပို့ချင်လျှင် register.php ဟု ပြောင်းပါ)
    header("Location: login.php");
    exit();
}
?>