DOCKER_COMPOSE=docker-compose
SERVICE_NAME=php-app

start:
	@echo "Subindo os containers..."
	$(DOCKER_COMPOSE) up -d

stop:
	@echo "Parando os containers..."
	$(DOCKER_COMPOSE) down

restart: stop start

logs:
	$(DOCKER_COMPOSE) logs -f

build:
	$(DOCKER_COMPOSE) up --build -d
	@docker exec -it ${SERVICE_NAME} chmod -R 775 /var/www/html
	@docker exec -it ${SERVICE_NAME} php ./bin/composer.phar install
	@docker exec -it ${SERVICE_NAME} php artisan migrate

bash:
	docker exec -it $(SERVICE_NAME) bash

migrate:
	@echo "Executando as migrations..."
	@docker exec -it ${SERVICE_NAME} php artisan migrate

undo-migrate:
	@echo "Desfazendo as migrations..."
	@docker exec -it ${SERVICE_NAME} php artisan migrate:rollback

test:
	@docker exec -it ${SERVICE_NAME} php artisan test --testdox