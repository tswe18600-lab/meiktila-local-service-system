<?php
// Meiktila City ID သို့မဟုတ် နာမည်ကို သုံးပါ
$city = "Meiktila";
$api_key = "YOUR_API_KEY_HERE"; // https://openweathermap.org/ မှာ အလကား register လုပ်ပြီး ယူပါ
$url = "https://api.openweathermap.org/data/2.5/weather?q=$city&units=metric&appid=$api_key";

$response = @file_get_contents($url);
if ($response) {
    $data = json_decode($response, true);
    $temp = round($data['main']['temp']);
    $desc = $data['weather'][0]['description'];
    $icon = $data['weather'][0]['icon'];
} else {
    $temp = "N/A";
    $desc = "မိုးလေဝသ အချက်အလက် မရနိုင်ပါ";
}
?>