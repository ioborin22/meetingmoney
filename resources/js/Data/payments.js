// payments.js
const paymentOptions = {
    "cryptocurrencies": {
        "Bitcoin": false,
        "Ethereum": false,
        "Ripple": false,
        // Другие криптовалюты...
    },
    "banks": {
        "Chase": true,
        "Bank of America": true,
        "Wells Fargo": true,
        // Другие банки...
    },
    "paymentSystems": {
        "PayPal": true,
        "Skrill": true,
        "Neteller": true,
        // Другие платежные системы...
    },
    "moneyTransfers": {
        "Western Union": true,
        "MoneyGram": true,
        "Ria Money Transfer": true,
        // Другие системы денежных переводов...
    },
};

export default paymentOptions;
