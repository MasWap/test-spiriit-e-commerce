/*
 * Welcome to your app's main JavaScript file!
 */

import './styles/app.scss';

// Import Bootstrap JavaScript
import 'bootstrap';

// Import our custom JS modules
import './js/product.js';
import './js/cart.js';

// Initialisation quand le DOM est chargé
document.addEventListener('DOMContentLoaded', function() {
    console.log('LAYRAC Guitar Shop - Application loaded with Webpack Encore!');
});

// Activation du live reload en mode dev
if (process.env.NODE_ENV === 'development') {
    console.log('Mode développement activé');
}
