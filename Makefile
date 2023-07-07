bash:
	docker exec -it --user www-data quickstart_app bash

up:
	docker-compose up -d

down:
	docker-compose down
