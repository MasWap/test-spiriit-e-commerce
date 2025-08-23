# Makefile simple pour LAYRAC Guitar Shop

.PHONY: build up down restart logs shell

# Construire l'image
build:
	docker compose build

# Démarrer l'application
up:
	docker compose up -d
	@echo "Application disponible sur http://localhost:8080"

# Arrêter l'application
down:
	docker compose down

# Redémarrer
restart: down up

# Voir les logs
logs:
	docker compose logs -f

# Accéder au shell
shell:
	docker compose exec app bash

# Nettoyer
clean:
	docker compose down -v
	docker system prune -f
