.PHONY: dev init-app start stop down test phpstan swagger gql-helper routes-list cache-clear tinker nginx pg laravel

dev:
	docker-compose up -d --build

init-app:
	docker exec -it test_task_07292024_app php artisan key:generate
	docker exec -it test_task_07292024_app php artisan migrate --seed
	docker exec -it test_task_07292024_app php artisan lighthouse:ide-helper
	docker exec -it test_task_07292024_app php artisan l5-swagger:generate

start:
	docker-compose up -d

stop:
	docker-compose stop

down:
	docker-compose down

test:
	docker exec -it test_task_07292024_app php artisan test

phpstan:
	docker exec -it test_task_07292024_app ./vendor/bin/phpstan analyse

swagger:
	docker exec -it test_task_07292024_app php artisan l5-swagger:generate

gql-helper:
	docker exec -it test_task_07292024_app php artisan lighthouse:ide-helper

routes-list:
	docker exec -it test_task_07292024_app php artisan route:list

cache-clear:
	docker exec -it test_task_07292024_app php artisan cache:clear
	docker exec -it test_task_07292024_app php artisan config:clear
	docker exec -it test_task_07292024_app php artisan route:clear

tinker:
	docker exec -it test_task_07292024_app php artisan tinker

nginx:
	docker exec -it test_task_07292024_webserver sh

pg:
	docker exec -it test_task_07292024_db bash

laravel:
	docker exec -it test_task_07292024_app bash