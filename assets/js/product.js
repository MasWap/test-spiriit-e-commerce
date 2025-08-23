// Gestion des quantités sur la page produit

// Fonction pour augmenter la quantité
function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const hiddenInput = document.getElementById('hidden-quantite');
    const currentValue = parseInt(quantityInput.value);
    const maxValue = parseInt(quantityInput.max);
    
    if (currentValue < maxValue) {
        quantityInput.value = currentValue + 1;
        hiddenInput.value = quantityInput.value; // Synchroniser avec l'input caché
    }
}

// Fonction pour diminuer la quantité
function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const hiddenInput = document.getElementById('hidden-quantite');
    const currentValue = parseInt(quantityInput.value);
    const minValue = parseInt(quantityInput.min);
    
    if (currentValue > minValue) {
        quantityInput.value = currentValue - 1;
        hiddenInput.value = quantityInput.value; // Synchroniser avec l'input caché
    }
}

// Initialisation des fonctionnalités produit
function initProductPage() {
    const quantityInput = document.getElementById('quantity');
    const hiddenInput = document.getElementById('hidden-quantite');
    
    if (quantityInput && hiddenInput) {
        // Empêcher la saisie de valeurs invalides et synchroniser
        quantityInput.addEventListener('input', function() {
            const value = parseInt(this.value);
            const min = parseInt(this.min);
            const max = parseInt(this.max);
            
            if (value < min) this.value = min;
            if (value > max) this.value = max;
            
            // Synchroniser avec l'input caché
            hiddenInput.value = this.value;
        });

        // Synchroniser au chargement de la page
        hiddenInput.value = quantityInput.value;
    }
}

// Exposer les fonctions globalement pour les boutons onclick
window.increaseQuantity = increaseQuantity;
window.decreaseQuantity = decreaseQuantity;

// Initialiser quand le DOM est chargé
document.addEventListener('DOMContentLoaded', initProductPage);
