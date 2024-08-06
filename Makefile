nginx:
	docker exec -it test_task_07292024_webserver sh

pg:
	docker exec -it test_task_07292024_db bash

laravel:
	docker exec -it test_task_07292024_app bash

tinker:
	docker exec -it test_task_07292024_app php artisan tinker

routes-list:
	docker exec -it test_task_07292024_app php artisan route:list

cache-clear:
	docker exec -it test_task_07292024_app php artisan cache:clear
	docker exec -it test_task_07292024_app php artisan config:clear
	docker exec -it test_task_07292024_app php artisan route:clear

test:
	docker exec -it test_task_07292024_app php artisan test

gql-helper:
	docker exec -it test_task_07292024_app php artisan lighthouse:ide-helper