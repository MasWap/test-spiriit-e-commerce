// Gestion des quantités dans le panier

function increaseCartQuantity(productId) {
    const input = document.getElementById('quantity-' + productId);
    if (parseInt(input.value) < 10) {
        input.value = parseInt(input.value) + 1;
        input.form.submit();
    }
}

function decreaseCartQuantity(productId) {
    const input = document.getElementById('quantity-' + productId);
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        input.form.submit();
    }
}

// Exposer les fonctions globalement pour les boutons onclick
window.increaseCartQuantity = increaseCartQuantity;
window.decreaseCartQuantity = decreaseCartQuantity;