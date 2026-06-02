<?php
// =====================
// BASIC SETUP
// =====================
header("Content-Type: application/json; charset=UTF-8");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// =====================
// DB CONNECT
// =====================
$conn = new mysqli("localhost", "root", "", "meiktila_service_db");
if ($conn->connect_error) {
    echo json_encode(["reply" => "ဒေတာဘေ့စ် ချိတ်ဆက်မရပါ ❌"]);
    exit;
}
$conn->set_charset("utf8mb4");

// =====================
// GET USER MESSAGE
// =====================
$data = json_decode(file_get_contents("php://input"), true);
$userMessage = trim($data["message"] ?? "");

if ($userMessage === "") {
    echo json_encode(["reply" => "မေးခွန်းတစ်ခု ရိုက်ထည့်ပါ 🙂"]);
    exit;
}

// =====================
// NORMALIZE TEXT
// =====================
$question = mb_strtolower($userMessage, "UTF-8");

// =====================
// DATABASE SEARCH
// =====================
$sql = "SELECT keyword, answer FROM meiktila_facts ORDER BY LENGTH(keyword) DESC";
$result = $conn->query($sql);

$found = false;
while ($row = $result->fetch_assoc()) {
    if (mb_stripos($question, $row['keyword']) !== false) {
        echo json_encode([
            "reply"  => $row["answer"],
            "source" => "database"
        ]);
        $found = true;
        exit; // ✅ Database answer ရှိရင် process ရပ်
    }
}

// =====================
// FALLBACK TO OPENAI API
// =====================
if (!$found) {
    $api_key = "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"; // ← သင့် OpenAI API key ထည့်ပါ
    $prompt = "User: $userMessage\nBot:";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/completions");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $api_key"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        "model" => "text-davinci-003",
        "prompt" => $prompt,
        "max_tokens" => 150,
        "temperature" => 0.7
    ]));

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        $api_reply = "API call မှာ အမှားတက်နေပါသည် ❌";
    } else {
        $res_data = json_decode($response, true);
        $api_reply = $res_data["choices"][0]["text"] ?? "မေးခွန်းကို ဖြေရှင်း၍ မရသေးပါ 🙏";
    }
    curl_close($ch);

    echo json_encode([
        "reply" => trim($api_reply),
        "source" => "api"
    ]);
}
?>