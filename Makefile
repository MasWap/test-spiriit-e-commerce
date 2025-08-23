.PHONY: help build up down restart logs shell install fixtures migrate assets test

help:
	@echo "🎸 LAYRAC Guitar Shop - Commandes Docker"
	@echo ""
	@echo "  up        - Démarrer l'application"
	@echo "  down      - Arrêter l'application"
	@echo "  restart   - Redémarrer l'application"
	@echo "  logs      - Afficher les logs"
	@echo "  shell     - Accéder au shell du conteneur"
	@echo "  install   - Installer les dépendances"
	@echo "  fixtures  - Charger les fixtures"
	@echo "  migrate   - Appliquer les migrations"
	@echo "  watch     - Webpack en hot-reload"
	@echo "  assets    - Compiler les assets"
	@echo "  test      - Exécuter les tests"

up:
	docker compose up -d
	@echo "Application disponible sur http://localhost:8000"

down:
	docker compose down

restart: down up

logs:
	docker compose logs -f

shell:
	docker compose exec app bash

install:
	docker compose exec app composer install
	docker compose exec app npm install

fixtures:
	docker compose exec app php bin/console doctrine:database:create --if-not-exists
	docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction
	docker compose exec app php bin/console doctrine:fixtures:load --no-interaction

migrate:
	docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction

watch:
	docker compose exec app npm run watch

assets:
	docker compose exec app npm run build

test:
	docker compose exec app php bin/phpunit
