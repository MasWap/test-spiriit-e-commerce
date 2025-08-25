#!/bin/bash

# Script de déploiement automatisé

echo "Démarrage du déploiement automatique..."

# Vérifier que nous sommes sur la bonne branche
CURRENT_BRANCH=$(git branch --show-current)
echo "Branche actuelle: $CURRENT_BRANCH"

# Récupérer les dernières modifications
echo "Récupération des dernières modifications..."
git pull origin $CURRENT_BRANCH

# Arrêter l'application actuelle
echo "Arrêt de l'application actuelle..."
docker-compose -f compose.prod.yaml down

# Nettoyer les anciennes images
echo "Nettoyage des anciennes images..."
docker image prune -f

# Construire la nouvelle image
echo "Construction de la nouvelle image..."
docker-compose -f compose.prod.yaml build --no-cache

# Démarrer l'application
echo "Démarrage de l'application..."
docker-compose -f compose.prod.yaml up -d

# Attendre que l'application soit prête
echo "Attente du démarrage de l'application..."
sleep 10

# Vérifier que l'application fonctionne
if curl -f https://test-spiriit.lilol.ovh > /dev/null 2>&1; then
    echo "Déploiement réussi ! L'application est accessible sur https://test-spiriit.lilol.ovh"
else
    echo "Erreur lors du déploiement ! Vérifiez les logs avec: docker-compose -f compose.prod.yaml logs"
    exit 1
fi

echo "Déploiement terminé avec succès !"
