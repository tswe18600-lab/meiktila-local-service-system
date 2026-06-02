<?php
require_once "config/db.php"; 
// (admin ဘက်မှာသုံးတဲ့ db.php ကိုပဲ reuse လုပ်)
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meiktila City | Detailed Information</title>
    <style>
        body {
            font-family: Pyidaungsu, Arial, sans-serif;
            background-color: #e2e6ed;
            margin: 0;
            line-height: 1.8;
        }
       header {
    position: relative;
    background-image: url("assets/img/services/information.jpg");
    background-size: cover;
    background-position: center -100px;  /* 🔽 အောက်ဘက်ကို ဆင်း */
    background-repeat: no-repeat;
    color: #ffffff;
    padding: 30px 20px;
    text-align: center;
    min-height: 500px;
}

header * {
    position: relative;
    z-index: 1;
}



header * {
    position: relative;
    z-index: 1;
}


.info-title {
    color: #0d6efd;
    font-weight: bold;
}
.info-title {
    color: #204af3;
    font-weight: 700;
    border-left: none;
    padding-left: 12px;
}
.en-subtitle {
    color: #2976e9;
    font-size: 18px;
    font-weight: 600;
    
}
.en-subtitle {
    background: linear-gradient(90deg, #086796, #2574ec);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 600;
}


        section {
            background-color: #ffffff;
            margin: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.05);
        }
        h2 {
            color: #0d6efd;
            border-bottom: 2px solid #e3e3e3;
            padding-bottom: 5px;
        }
        footer {
            background-color: #e9ecef;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
        .festival-images {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.festival-images figure {
    margin: 0;
    background: #ffffff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.festival-images figure:hover {
    transform: translateY(-5px);
}

.festival-images img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
}

.festival-images figcaption {
    padding: 10px;
    text-align: center;
    font-weight: 600;
    background: #f8f9fa;
}
.chat-section {
    display: flex;
    justify-content: center;
    margin: 40px 0;
}

.chat-container {
    width: 100%;
    max-width: 700px;   /* 420px → 700px */
    font-size: 16px;    /* စာလုံးကြီး */
}


.chat-header {
    background: #0d6efd;
    color: #fff;
    padding: 12px;
    text-align: center;
    font-weight: bold;
}

.chat-messages {
    padding: 15px;
    height: 260px;
    overflow-y: auto;
    background: #f8f9fa;
}

.bot-msg {
    background: #e3f2fd;
    padding: 8px 12px;
    border-radius: 10px;
    margin-bottom: 10px;
    max-width: 85%;
}

.user-msg {
    background: #d1e7dd;
    padding: 8px 12px;
    border-radius: 10px;
    margin-bottom: 10px;
    max-width: 85%;
    margin-left: auto;
    text-align: right;
}

.chat-input {
    display: flex;
    border-top: 1px solid #ddd;
}

.chat-input input {
    flex: 1;
    padding: 10px;
    border: none;
    outline: none;
}

.chat-input button {
    background: #0d6efd;
    color: white;
    border: none;
    padding: 0 18px;
    cursor: pointer;
}

.chat-input button:hover {
    background: #0b5ed7;
}
.chat-container,
.chat-messages,
.bot-msg,
.user-msg,
.chat-input input {
    font-family: "Pyidaungsu", "Padauk", "Noto Sans Myanmar", Arial, sans-serif;
    font-size: 16px;
    line-height: 1.9;
}
.bot-msg {
    letter-spacing: 0.3px;
}
.uni-gallery {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-top: 25px;
}

.uni-item {
    text-align: center;
}

.uni-item img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.12);
}

.uni-item p {
    margin-top: 8px;
    font-weight: bold;
    color: #333;
}
.uni-gallery {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-top: 25px;
}

.uni-item {
    text-align: center;
    text-decoration: none;
    color: inherit;
}

.uni-item img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.12);
    transition: transform 0.3s ease;
}

.uni-item:hover img {
    transform: scale(1.05);
}

.uni-item p {
    margin-top: 8px;
    font-weight: bold;
    color: #333;
}

.official-badge {
    display: inline-block;
    margin-top: 6px;
    padding: 2px 8px;
    font-size: 11px;
    background: #0d6efd;
    color: #fff;
    border-radius: 12px;
}
.home-link {
    position: absolute;
    top: 20px;
    left: 20px;
    background: rgba(255,255,255,0.15);
    color: #fff;
    padding: 8px 14px;
    border-radius: 20px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s ease;
}

.home-link:hover {
    background: rgba(255,255,255,0.3);
}
.btn-back {
            background: rgba(97, 92, 149, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            padding: 8px 25px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-decoration: none;
            transition: 0.3s;
            margin-bottom: 20px;
            display: inline-block;
        }

        .btn-back:hover {
            background: blue ;
            color: var(--primary-navy);
        }

 .home-icon {
            color: blue;
            font-size: 24px;
            text-decoration: none;
            transition: 0.3s;
        }
        .home-icon:hover {
            color: #ffcc00; /* Mouse တင်ရင် အရောင်ပြောင်းမယ် */
        }
        .back-home-btn {
    display: table;      /* inline-block အစား table သုံးရင် margin auto နဲ့ အလုပ်လုပ်ပါတယ် */
    margin: 40px auto;   /* auto က ဘယ်/ညာ ကို အလယ်ရောက်စေပါတယ် */
    padding: 12px 25px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-size: 14px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
    </style>
</head>
<body>

<header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
            <a href="index.php" class="home-icon">
            <i class="fa-solid fa-house"></i>
        </a>
    <h1 class="info-title">မိတ္ထီလာမြို့ အချက်အလက်အသေးစိတ်</h1>
    <p class="en-subtitle">Detailed Information of Meiktila City</p>

</header>


    <section>
    <h2>📍မိတ္ထီလာမြို့ တည်နေရာ</h2>
    <p>
        မိတ္ထီလာမြို့၏ တည်နေရာကို အောက်ပါမြေပုံမှ ကြည့်ရှုနိုင်ပါသည်။
    </p>

    <iframe 
        src="https://www.google.com/maps?q=Meiktila,+Myanmar&output=embed"
        allowfullscreen=""
        loading="lazy" style="width:100%;height:350px;border-radius:12px;border:0">
    </iframe>
</section>

<section>
  
</div>

<div class="section">
    <h2>🏢မြို့နယ်အုပ်ချုပ်ရေးရုံး</h2>
    
    <p>
        မိတ္ထီလာမြို့နယ်အုပ်ချုပ်ရေးရုံးမှ
        ပြည်သူ့ဝန်ဆောင်မှုများ၊ စာရွက်စာတမ်းများနှင့်
        အုပ်ချုပ်ရေးဆိုင်ရာကိစ္စများကို တာဝန်ယူဆောင်ရွက်ပါသည်။ရပ်ကွက်အုပ်ချုပ်ရေး၊ လုံခြုံရေးနှင့်တရားရေးကိစ္စများ၏အချက်အလက်များသည် မကြာခဏ ပြောင်းလဲတတ်သောကြောင့် အတိအကျသိလိုလျှင် အောက်ပါဖုန်းနံပါတ်(သို့မဟုတ်)Gmailသို့တရားဝင်စာတင်ပြီး မေးမြန်းနိုင်ပါသည်။
    </p>
    <div class="contact-info">
    <p>📞 <strong>Phone:</strong> <a href="tel:064222117">064-222117</a></p>
    <p>📧 <strong>Email:</strong> <a href="mailto:meiktilagad@gmail.com">meiktilagad@gmail.com</a></p>
</div>

</div>


</section>


<section>
    <h2>🎓ပညာရေး</h2>
    <p>
        မိတ္ထီလာမြို့တွင် အခြေခံပညာကျောင်းများ၊ အလယ်တန်းနှင့် အထက်တန်းကျောင်းများစွာ တည်ရှိပါသည်။
        ထို့အပြင် မိတ္ထီလာတက္ကသိုလ်နှင့် ပညာရေးဆိုင်ရာ သင်တန်းကျောင်းများလည်း ရှိပြီး
        ဒေသခံကျောင်းသားများအတွက် ပညာရေးအခွင့်အလမ်းများ ပံ့ပိုးပေးလျက်ရှိသည်။ မိတ္ထီလာ အခြေခံပညာသင်တန်းကျောင်းအရေအတွက်မှာ (၂၀) မှ (၃၀) ကြားခန့်တွင်ရှိပြီး၊ အခြေခံပညာအထက်တန်းကျောင်း(၄)ခု၊ တက္ကသိုလ် အားဖြင့် (၇)ခုရှိပါသည်။

    </p>
    <div class="uni-gallery">

    <a href="#"
   class="uni-item"
   onclick="openOfficial(
     'https://en.wikipedia.org/wiki/Meiktila_University',
     'မိတ္ထီလာတက္ကသိုလ်'
   )">

    <img src="assets/image/service/meiktilauniversity.jpg" alt="မိတ္ထီလာတက္ကသိုလ်">

    <span>
        မိတ္ထီလာတက္ကသိုလ်
        <small class="official-badge">Official Website</small>
    </span>

</a>
<a href="#"
   class="uni-item"
   onclick="openOfficial(
  'https://www.facebook.com/search/top?q=ပညာရေးကောလိပ်%20မိတ္ထီလာ',
  'ပညာရေးကောလိပ် (မိတ္ထီလာ)'
)"
>

    <img src="assets/image/service/Screenshot 2026-01-23 190134.png" alt="ပညာရေးကောလိပ်(မိတ္ထီလာ)">

    <span>
        ပညာရေးကောလိပ်(မိတ္ထီလာ)
        <small class="official-badge">Official Website</small>
    </span>

</a>
<a href="#"
   class="uni-item"
   onclick="openOfficial(
  'https://en.wikipedia.org/wiki/Meiktila_University',
  'နည်းပညာတက္ကသိုလ်(မိတ္ထီလာ)'
)"
>

    <img src="assets/image/service/meiktilatu.jpg" alt="နည်းပညာတက္ကသိုလ်(မိတ္ထီလာ)">

    <span>
        နည်းပညာတက္ကသိုလ်(မိတ္ထီလာ)
        <small class="official-badge">Official Website</small>
    </span>

</a>



<a href="#"
   class="uni-item"
  onclick="openOfficial(
  'https://ucsmtla.edu.mm/',
  'ကွန်ပျူတာတက္ကသိုလ် (မိတ္ထီလာ)'
)"
>

    <img src="assets/image/service/photo_2026-01-23_19-35-38.jpg" alt="ကွန်ပျူတာတက္ကသိုလ် (မိတ္ထီလာ)">

    <span>
        ကွန်ပျူတာတက္ကသိုလ် (မိတ္ထီလာ)
        <small class="official-badge">Official Website</small>
    </span>

</a>
<a href="#"
   class="uni-item"
   onclick="openOfficial(
  'https://www.facebook.com/search/top?q=မိတ္ထီလာ%20သူနာပြု%20သားဖွား%20သင်တန်းကျောင်း',
  'သူနာပြုနှင့် သားဖွားသင်တန်းကျောင်း'
)"
>

    <img src="assets/image/service/nurse.jpg" alt="သူနာပြုနှင့် သားဖွားသင်တန်းကျောင်း">

    <span>
        သူနာပြုနှင့် သားဖွားသင်တန်းကျောင်း
        <small class="official-badge">Official Website</small>
    </span>

</a>
    
<a href="#"
   class="uni-item"
   onclick="openOfficial(
  'https://maeu.edu.mm/',
  'လေကြောင်းနှင့်အာကာသပညာတက္ကသိုလ်'
)"
>

    <img src="assets/image/service/meiktilaair.jpg" alt="လေတပ်တက္ကသိုလ်">

    <span>
        မြန်မာနိုင်ငံလေကြောင်းနှင့်အာကာသပညာတက္ကသိုလ်
        <small class="official-badge">Official Website</small>
    </span>

</a>
   <a href="#"
   class="uni-item"
  onclick="openOfficial(
  'http://www.mtlaeco.edu.mm/',
  'စီးပွားရေးတက္ကသိုလ် (မိတ္ထီလာ)'
)"
>

    <img src="assets/image/service/meiktilaeco.jpg" alt="စီးပွားရေးတက္ကသိုလ် (မိတ္ထီလာ)">

    <span>
        စီးပွားရေးတက္ကသိုလ် (မိတ္ထီလာ)
        <small class="official-badge">Official Website</small>
    </span>

</a> 
 
</div>
<p>အခြေခံပညာသင်တန်းကျောင်း၊ အထက်တန်းကျောင်းများသည် ၎င်းတို့၏အရေအတွက်၊ အချက်အလက်များအား လူထုဆီသို့ တရားဝင်ထုတ်ပြန်ပြသထားခြင်းမရှိသောကြောင့် ပိုမိုသိရှိလိုလျှင် မြို့နယ်ပညာရေးမှူးရုံးသို့ သွားရောက်ဆက်သွယ်မေးမြန်းနိုင်ပါသည်။</p>


</section>

<section>
    <h2>🏥 ကျန်းမာရေး ဝန်ဆောင်မှု</h2>
    <p>
        မိတ္ထီလာပြည်သူ့ဆေးရုံကြီးနှင့်
        ပုဂ္ဂလိက ဆေးခန်းများမှ
        အရေးပေါ်နှင့် ပုံမှန် ဝန်ဆောင်မှုများ ရရှိနိုင်ပါသည်။
    </p>

    <!-- ဆေးရုံနှင့် ဆေးခန်းများ (category id = 53) -->
    <a href="category_details.php?id=53&from=information"
   style="display:inline-block;
          margin-top:12px;
          font-weight:bold;
          color:#0d6efd;
          text-decoration:none;
          font-size:16px;">
    🏥 ဆေးရုံနှင့် ဆေးခန်းများ
</a>

</section>

<section>
<h2>🚌 သယ်ယူပို့ဆောင်ရေး</h2>
<ul>
<li><a href="category_details.php?id=24&from=information"
   style="display:inline-block;
          margin-top:12px;
          font-weight:bold;
          color:#0d6efd;
          text-decoration:none;
          font-size:16px;">
    အဝေးပြေးကားဂိတ်များ
</a></li>
<li><a href="category_details.php?id=54&from=information"
   style="display:inline-block;
          margin-top:12px;
          font-weight:bold;
          color:#0d6efd;
          text-decoration:none;
          font-size:16px;">
    ရထားဘူတာ
</a></li>
<li>မြို့တွင်း ယာဉ်လိုင်းများ</li>
</ul>
</section>

<section>
<h2>🚨 အရေးပေါ် ဆက်သွယ်ရန်</h2>
<ul>
<li>ရဲ – 199</li>
<li>မီးသတ် – 191</li>
<li>ဆေးရုံ အရေးပေါ်ဌာနများ</li>
</ul>
</section>
<section class="chat-section">
    

    <div class="chat-container">
        <div class="chat-header">မိတ္ထီလာနှင့်ပတ်သက်၍ ပိုမိုသိရှိလိုသည်များကို မေးမြန်းရန် (Chat)</div>

        <div id="chatMessages" class="chat-messages">
            <div class="bot-msg">မိတ္ထီလာမြို့အချက်အလက်များကို မေးနိုင်ပါတယ် 😊</div>
        </div>

        <div class="chat-input">
            <input type="text" id="userInput" placeholder="မေးချင်တာ ရိုက်ပါ..." />
            <button onclick="sendMessage()">ပို့မယ်</button>
        </div>
    </div>
</section>
<a href="index.php" class="back-home-btn">
            <i class="fa-solid fa-arrow-left"></i> ပင်မစာမျက်နှာသို့ ပြန်သွားမည်
        </a>


<script>
async function sendMessage() {
    const input = document.getElementById("userInput");
    const message = input.value.trim();
    if (!message) return;

    const chat = document.getElementById("chatMessages");
    chat.innerHTML += `<div class="user-msg">${message}</div>`;
    input.value = "";

    const res = await fetch("chatbot.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message })
    });

    const data = await res.json();
    chat.innerHTML += `<div class="bot-msg">${data.reply}</div>`;
    chat.scrollTop = chat.scrollHeight;
}
</script>

<script>
function openOfficial(url, name) {
    if (confirm(
        name + " ရဲ့ official / reference website ကိုသွားမှာဖြစ်ပါတယ်。\n\n" +
        "လိုင်းမကောင်းရင် ဝင်ဖို့ကြာနိုင်ပါတယ်。\n\n" +
        "ဆက်သွားမလား?"
    )) {
        window.open(url, "_blank");
    }
}
</script>
<script>
document.getElementById("userInput").addEventListener("keydown", function (e) {
    if (e.key === "Enter") {
        e.preventDefault(); // newline မဝင်အောင်
        sendMessage();      // message ပို့
    }
});
</script>



</body>
</html>