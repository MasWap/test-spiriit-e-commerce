# ID du conteneur PHP
PHP_CONTAINER = php8-sf6
CONN_CONTAINER = docker exec -it $(PHP_CONTAINER)

help:
	@echo ""
	@echo "┌──────────────────────┬───────────────────────────────────────────────────────────────────────────────┐"
	@echo "│ Commande             │ Description                                                                   │"
	@echo "├──────────────────────┼───────────────────────────────────────────────────────────────────────────────┤"
	@echo "│ make help            │ Affiche les commandes                                                         │"
	@echo "│ make start           │ Build, démarre les conteneurs, installe les dépendances, migrations, fixtures │"
	@echo "│ make stop            │ Arrête les conteneurs                                                         │"
	@echo "│ make clean-all       │ Supprime conteneurs et volumes                                                │"
	@echo "│ make bash            │ Accède au conteneur PHP en bash                                               │"
	@echo "│ make install         │ Installe les dépendances PHP (Composer)                                       │"
	@echo "│ make serve           │ Lance le serveur PHP                                                          │"
	@echo "│ make watch           │ Lance Webpack en mode watch                                                   │"
	@echo "│ make db-create       │ Génère la base de données                                                     │" 
	@echo "│ make migration       │ Lance les migrations Doctrine                                                 │"
	@echo "│ make fixtures        │ Charge les fixtures Doctrine                                                  │"
	@echo "│ make cache-clear     │ Vide le cache Symfony                                                         │"
	@echo "│ make cache-clean     │ Nettoie le cache de manière agressive                                         │"
	@echo "│ make test            │ Lance tous les tests                                                          │"
	@echo "│ make test-unit       │ Lance uniquement les tests unitaires                                          │"
	@echo "│ make test-func       │ Prépare et lance les tests fonctionnels                                       │"
	@echo "│ make csv-export      │ Exporte les produits au format CSV                                            │"
	@echo "└──────────────────────┴───────────────────────────────────────────────────────────────────────────────┘"

start:
	docker-compose build
	docker-compose up -d
	@echo "Démarrage du conteneur PHP"
	@echo "3 ..."
	@sleep 1
	@echo "2 ..."
	@sleep 1
	@echo "1 ..."
	@sleep 1
	make cache-clean
	$(CONN_CONTAINER) npm install
	$(CONN_CONTAINER) composer install
	$(CONN_CONTAINER) php bin/console doctrine:migrations:migrate --no-interaction
	$(CONN_CONTAINER) php bin/console doctrine:fixtures:load --no-interaction
	@echo ""
	@echo " ============================================================"
	@echo " |         Application démarrée et disponible sur           |"
	@echo " |         http://localhost:9000                            |"
	@echo " ============================================================"
	@echo ""
	$(CONN_CONTAINER) npm run dev
	$(CONN_CONTAINER) php -S 0.0.0.0:8000 -t public

# Arrêter les conteneurs
stop:
	docker-compose down

# Nettoyer l'environnement (conteneurs, volumes)
clean-all:
	docker-compose down -v --remove-orphans

# Accéder au conteneur PHP
bash:
	docker exec -it $(PHP_CONTAINER) bash

# Installer les dépendances Symfony (via Composer)
install:
	docker exec -it $(PHP_CONTAINER) composer install

# Lancer le serveur PHP (depuis le conteneur)
serve:
	docker exec -it $(PHP_CONTAINER) php -S 0.0.0.0:8000 -t public -d

# Lancer le webpack en mode watch
watch:
	docker exec -it $(PHP_CONTAINER) npm run watch

db-create:
	docker exec -it $(PHP_CONTAINER) php bin/console doctrine:database:create	

# Lancer les migrations Doctrine
migration:
	docker exec -it $(PHP_CONTAINER) php bin/console doctrine:migrations:migrate --no-interaction

fixtures:
	docker exec -it $(PHP_CONTAINER) php bin/console doctrine:fixtures:load --no-interaction

# Nettoyer le projet (cache Symfony)
cache-clear:
	docker exec -it $(PHP_CONTAINER) php bin/console cache:clear

# Nettoyer le cache de manière agressive (suppression manuelle)
cache-clean:
	docker exec -it $(PHP_CONTAINER) rm -rf var/cache/*
	docker exec -it $(PHP_CONTAINER) rm -rf var/log/*
	docker exec -it $(PHP_CONTAINER) mkdir -p var/cache var/log
	docker exec -it $(PHP_CONTAINER) chmod -R 777 var/

# Lancer les tests PHPUnit
test: test-unit test-func
	
# Lancer uniquement les tests unitaires
test-unit:
	docker exec -it $(PHP_CONTAINER) php bin/phpunit tests/Unit
# Lancer uniquement les tests fonctionnels (et préparer la BDD de test)
test-func:
	docker exec -it $(PHP_CONTAINER) php bin/console doctrine:database:create --env=test
	docker exec -it $(PHP_CONTAINER) php bin/console doctrine:migrations:migrate --env=test --no-interaction
	docker exec -it $(PHP_CONTAINER) php bin/console doctrine:fixtures:load --env=test --no-interaction
	docker exec -it $(PHP_CONTAINER) php bin/phpunit tests/Functional

# Export des produits au format CSV
csv-export:
	docker exec -it $(PHP_CONTAINER) php bin/console app:export-produits
