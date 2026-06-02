<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Team - Meiktila Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary-color: #2c3e50; --accent-color: #f39c12; }
        body { font-family: 'Pyidaungsu', sans-serif; background-color: #f8f9fa; }
        
        /* Hero Section */
        .about-hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('assets/img/services/htla1.jpg');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
       .content-section { padding: 80px 0; }
        .section-title { font-weight: 800; color: var(--primary-color); margin-bottom: 40px; position: relative; }
        .section-title::after { content: ''; width: 60px; height: 4px; background: var(--accent-color); position: absolute; bottom: -10px; left: 0; }
        
        /* City Icon Grid */
        .city-feature { background: white; padding: 30px; border-radius: 15px; border-bottom: 5px solid var(--accent-color); height: 100%; transition: 0.3s; }
        .city-feature:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        .city-feature i { font-size: 2.5rem; color: var(--accent-color); margin-bottom: 20px; }

        /* Statistics Section */
        .stat-box { background: var(--primary-color); color: white; padding: 50px 0; }
        .stat-number { font-size: 2.5rem; font-weight: bold; color: var(--accent-color); }
    </style>
</head>
<body class="bg-light">

   <section class="content-section bg-light">
        <div class="container-fluid px-lg-5">
                 <a href="About.php" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm me-4">
                <i class="fas fa-arrow-left me-1"></i> နောက်သို့
            </a>
            
            <div class="text-center mb-5">
                <h2 class="fw-bold section-title d-inline-block">ကျွန်ုပ်တို့၏ အဖွဲ့ဝင်များ</h2>
                <p class="text-muted mt-3">Meiktila Hub ကို အကောင်းဆုံးဖြစ်အောင် ဖန်တီးခဲ့ကြသူများ</p>
            </div>
            
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
                <div class="col">
                    <div class="card border-0 shadow-sm text-center p-4 h-100 city-feature" style="border-bottom: 5px solid #2ecc71;">
                        <img src="assets/img/team/member1.jpg" class="rounded-circle mx-auto mb-3 shadow" 
                             style="width: 130px; height: 130px; object-fit: cover;" alt="Developer">
                        <h5 class="fw-bold">Wai Phyo Kyaw</h5>
                        <p class="text-primary fw-bold">Developer</p>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <a href="https://www.facebook.com/share/1QbgeW6Pru/" class="text-muted"><i class="fab fa-facebook"></i></a>
                            <a href="https://www.tiktok.com/@b.007576?_r=1&_t=ZS-93klcVxp0S1" class="text-muted"><i class="fab fa-tiktok"></i></a>
                            <a href="t.me/Zymase7" class="text-muted"><i class="fab fa-telegram"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-0 shadow-sm text-center p-4 h-100 city-feature" style="border-bottom: 5px solid #2ecc71;">
                        <img src="assets/img/team/member2.jpg" class="rounded-circle mx-auto mb-3 shadow" 
                             style="width: 130px; height: 130px; object-fit: cover;" alt="Developer">
                        <h5 class="fw-bold">Naing Win Aung</h5>
                        <p class="text-danger fw-bold">Developer</p>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <a href="#" class="text-muted"><i class="fab fa-facebook"></i></a>
                            <a href="https://www.tiktok.com/@naingwinaung044?_r=1&_t=ZS-93kklCdkwSO" class="text-muted"><i class="fab fa-tiktok"></i></a>
                            <a href="https://youtube.com/@aungnaingwin-m1o?si=S2CAUqgOhCjzJ10o" class="text-muted"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                

                <div class="col">
                    <div class="card border-0 shadow-sm text-center p-4 h-100 city-feature" style="border-bottom: 5px solid #2ecc71;">
                        <img src="assets/img/team/member3.jpg" class="rounded-circle mx-auto mb-3 shadow" 
                             style="width: 130px; height: 130px; object-fit: cover;" alt="Developer">
                        <h5 class="fw-bold">Aung Myo Zaw</h5>
                        <p class="text-success fw-bold">Developer</p>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <a href="t.me/Aungmyozaw123" class="text-muted"><i class="fab fa-telegram"></i></a>
                            <a href="https://www.tiktok.com/@aungmyozaw2901?_r=1&_t=ZS-93km4EVvRoY" class="text-muted"><i class="fab fa-tiktok"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>

                </div>
                                <div class="col">
                    <div class="card border-0 shadow-sm text-center p-4 h-100 city-feature" style="border-bottom: 5px solid #2ecc71;">
                        <img src="assets/img/team/member4.jpg" class="rounded-circle mx-auto mb-3 shadow" 
                             style="width: 130px; height: 130px; object-fit: cover;" alt="Developer">
                        <h5 class="fw-bold">Aung Myo Myint</h5>
                        <p class="text-primary fw-bold">Developer</p>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <a href="#" class="text-muted"><i class="fab fa-facebook"></i></a>
                            <a href="tiktok.com/@aungmyomyint805" class="text-muted"><i class="fab fa-tiktok"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-0 shadow-sm text-center p-4 h-100 city-feature" style="border-bottom: 5px solid #2ecc71">
                        <img src="assets/img/team/member5.jpg" class="rounded-circle mx-auto mb-3 shadow" 
                             style="width: 130px; height: 130px; object-fit: cover;" alt="Developer">
                        <h5 class="fw-bold">Thae Su Aung</h5>
                        <p class="text-danger fw-bold">Developer</p>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <a href="https://t.me/ThaeThae20052025" class="text-muted"><i class="fab fa-telegram"></i></a>
                            <a href="https://www.tiktok.com/@thae.su.aung249?_r=1&_t=ZS-94I3LO5j9of" class="text-muted"><i class="fab fa-tiktok"></i></a>
                            <a href="https://youtube.com/@thaesuaung-e3e5g?si=Ia-pHhS3eQ6mO8L7" class="text-muted"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                

                <div class="col">
                    <div class="card border-0 shadow-sm text-center p-4 h-100 city-feature" style="border-bottom: 5px solid #2ecc71;">
                        <img src="assets/img/team/member6.jpg" class="rounded-circle mx-auto mb-3 shadow" 
                             style="width: 130px; height: 130px; object-fit: cover;" alt="Developer">
                        <h5 class="fw-bold">Yoon Nadi Maung</h5>
                        <p class="text-success fw-bold">Developer</p>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <a href="t.me/yoon258035" class="text-muted"><i class="fab fa-telegram"></i></a>
                            <a href="https://www.facebook.com/share/1FLm76t2Ec/" class="text-muted"><i class="fab fa-facebook"></i></a>
                            <a href="https://www.tiktok.com/@yoonnadi3599?_r=1&_t=ZS-93mTCUh9VA1" class="text-muted"><i class="fab fa-tiktok"></i></a>
                        </div>
                    </div>

                </div>
                                <div class="col">
                    <div class="card border-0 shadow-sm text-center p-4 h-100 city-feature" style="border-bottom: 5px solid #2ecc71;">
                        <img src="assets/img/team/member7.jpg" class="rounded-circle mx-auto mb-3 shadow" 
                             style="width: 130px; height: 130px; object-fit: cover;" alt="Developer">
                        <h5 class="fw-bold">May Zin Phyo</h5>
                        <p class="text-primary fw-bold">Developer</p>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <a href="https://www.facebook.com/share/14UCQwmxCi3/" class="text-muted"><i class="fab fa-facebook"></i></a>
                            <a href="tiktok.com/@shinningstar123456789" class="text-muted"><i class="fab fa-tiktok"></i></a>
                            <a href="https://youtube.com/@mayzin-n6r?si=M-gqMqag8rBYLWUo" class="text-muted"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-0 shadow-sm text-center p-4 h-100 city-feature" style="border-bottom: 5px solid #2ecc71;">
                        <img src="assets/img/team/member8.jpg" class="rounded-circle mx-auto mb-3 shadow" 
                             style="width: 130px; height: 130px; object-fit: cover;" alt="Developer">
                        <h5 class="fw-bold">Nwe Ni Win</h5>
                        <p class="text-danger fw-bold">Developer</p>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <a href="https://www.facebook.com/share/1APiRXa94K/" class="text-muted"><i class="fab fa-facebook"></i></a>
                            <a href="https://www.tiktok.com/@user1297801045454?_r=1&_t=ZS-93lWRqfiPwe" class="text-muted"><i class="fab fa-tiktok"></i></a>
                            <a href="https://youtube.com/@pyaetphyokyaw?si=Mf5dv8eBjQNFoPLb" class="text-muted"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                

                <div class="col">
                    <div class="card border-0 shadow-sm text-center p-4 h-100 city-feature" style="border-bottom: 5px solid #2ecc71;">
                        <img src="assets/img/team/member9.jpg" class="rounded-circle mx-auto mb-3 shadow" 
                             style="width: 130px; height: 130px; object-fit: cover;" alt="Developer">
                        <h5 class="fw-bold">Chan Myae Thwe</h5>
                        <p class="text-success fw-bold">Developer</p>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <a href="#" class="text-muted"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-tiktok"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>

                </div>
                                <div class="col">
                    <div class="card border-0 shadow-sm text-center p-4 h-100 city-feature" style="border-bottom: 5px solid #2ecc71;">
                        <img src="assets/img/team/member10.jpg" class="rounded-circle mx-auto mb-3 shadow" 
                             style="width: 130px; height: 130px; object-fit: cover;" alt="Developer">
                        <h5 class="fw-bold">Hmwe Hmwe</h5>
                        <p class="text-primary fw-bold">Developer</p>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <a href="https://www.facebook.com/share/1DAV2BPokY/" class="text-muted"><i class="fab fa-facebook"></i></a>
                            <a href="https://www.tiktok.com/@hmwe.hmwe8472?_r=1&_t=ZS-93kqicelebt" class="text-muted"><i class="fab fa-tiktok"></i></a>
                            <a href="https://youtube.com/@hmwehmwe-g4q?si=FalntmHFYXhZzoq0" class="text-muted"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-0 shadow-sm text-center p-4 h-100 city-feature" style="border-bottom: 5px solid #2ecc71;">
                        <img src="assets/img/team/member11.jpg" class="rounded-circle mx-auto mb-3 shadow" 
                             style="width: 130px; height: 130px; object-fit: cover;" alt="Developer">
                        <h5 class="fw-bold">Khin Soe Myint</h5>
                        <p class="text-danger fw-bold">Developer</p>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <a href="https://www.facebook.com/share/1cDS5eySi2" class="text-muted"><i class="fab fa-facebook"></i></a>
                            <a href="https://www.tiktok.com/@khinsoemyint32?_r=1&_t=ZS-93eqgPpNJnE" class="text-muted"><i class="fab fa-tiktok"></i></a>
                            <a href="https://youtube.com/@khinsoemyint-c4u?si=NqfblYdn3Yagrwjn" class="text-muted"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                

                <div class="col">
                    <div class="card border-0 shadow-sm text-center p-4 h-100 city-feature" style="border-bottom: 5px solid #2ecc71;">
                        <img src="assets/img/team/member12.jpg" class="rounded-circle mx-auto mb-3 shadow" 
                             style="width: 130px; height: 130px; object-fit: cover;" alt="Developer">
                        <h5 class="fw-bold">Ei Thazin</h5>
                        <p class="text-success fw-bold">Developer</p>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <a href="https://www.facebook.com/share/17o2hn96iW/" class="text-muted"><i class="fab fa-facebook"></i></a>
                            <a href="https://www.tiktok.com/@jamejoker363?_r=1&_t=ZS-93eqXeEzKy4" class="text-muted"><i class="fab fa-tiktok"></i></a>
                            <a href="https://youtube.com/@eithazin-u7w?si=8eUjhI8gx8sXa4mq" class="text-muted"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>

                </div>
                                <div class="col">
                    <div class="card border-0 shadow-sm text-center p-4 h-100 city-feature" style="border-bottom: 5px solid #2ecc71;">
                        <img src="assets/img/team/member13.jpg" class="rounded-circle mx-auto mb-3 shadow" 
                             style="width: 130px; height: 130px; object-fit: cover;" alt="Developer">
                        <h5 class="fw-bold">Yamin Soe</h5>
                        <p class="text-primary fw-bold">Developer</p>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <a href="https://www.facebook.com/share/1B5ESHFnyx/" class="text-muted"><i class="fab fa-facebook"></i></a>
                            <a href="https://www.tiktok.com/@ya.min.soe16?_r=1&_t=ZS-93mLpEofwO2" class="text-muted"><i class="fab fa-tiktok"></i></a>
                            <a href="https://youtube.com/@soeyamin-t2l8f?si=E-7PtWmzD5OOlhq_" class="text-muted"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-0 shadow-sm text-center p-4 h-100 city-feature" style="border-bottom: 5px solid #2ecc71;">
                        <img src="assets/img/team/member14.jpg" class="rounded-circle mx-auto mb-3 shadow" 
                             style="width: 130px; height: 130px; object-fit: cover;" alt="Developer">
                        <h5 class="fw-bold">Yamin Aung</h5>
                        <p class="text-danger fw-bold">Developer</p>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <a href="#" class="text-muted"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-tiktok"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                

                <div class="col">
                    <div class="card border-0 shadow-sm text-center p-4 h-100 city-feature" style="border-bottom: 5px solid #2ecc71;">
                        <img src="assets/img/team/member15.jpg" class="rounded-circle mx-auto mb-3 shadow" 
                             style="width: 130px; height: 130px; object-fit: cover;" alt="Developer">
                        <h5 class="fw-bold">Theingi Swe</h5>
                        <p class="text-success fw-bold">Developer</p>
                            <div class="d-flex justify-content-center gap-3 mt-2">
                            <a href="https://www.facebook.com/share/14VVZsiFNqa/" class="text-muted"><i class="fab fa-facebook"></i></a>
                            <a href="https://tiktok.com/@theingiswe449" class="text-muted"><i class="fab fa-tiktok"></i></a>
                            <a href="https://www.youtube.com/@TheingiSwe-vw6uu" class="text-muted"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>

                </div>
                                

                
            </div>
        </div>
    </section>
</body>
</html>