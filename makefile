DOCKER_CONTAINER_ID=$$(docker ps --filter name=aoc-php --format {{.ID}})
DOCKER_EXEC=docker exec -it -u ape ${DOCKER_CONTAINER_ID} bash
DOCKER_COMPOSE=docker compose

.PHONY: *
up:
	${DOCKER_COMPOSE} up -d
down:
	${DOCKER_COMPOSE} down
stop:
	${DOCKER_COMPOSE} stop
rebuild:
	${DOCKER_COMPOSE} up -d --build
ssh:
	${DOCKER_EXEC}
logs:
	docker logs -f ${DOCKER_CONTAINER_ID}
ci:
	${DOCKER_EXEC} -c 'composer install -o -n'
fix:
	${DOCKER_EXEC} -c './vendor/bin/php-cs-fixer fix --allow-risky=yes'