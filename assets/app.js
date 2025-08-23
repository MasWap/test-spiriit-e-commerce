/*
 * Welcome to your app's main JavaScript file!
 */

import './styles/app.scss';

// Import our custom JS modules
import './js/product';
import './js/cart';

// Initialisation quand le DOM est chargé
document.addEventListener('DOMContentLoaded', function() {
    console.log('LAYRAC Guitar Shop - Application loaded with Webpack Encore!');
});

// Activation du live reload en mode dev
if (process.env.NODE_ENV === 'development') {
    console.log('Mode développement activé');
}
