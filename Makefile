docker-up:
	sudo docker-compose up -d

docker-down:
	sudo docker-compose down

docker-build:
	sudo docker-compose up --build -d

test:
	sudo docker-compose exec php-cli vendor/bin/phpunit --colors=always

assets-install:
	sudo docker-compose exec node yarn install

assets-dev:
	sudo docker-compose exec node yarn run dev

assets-watch:
	sudo docker-compose exec node yarn run watch

perm:
	sudo chown ${USER}:${USER} bootstrap/cache -R
	sudo chown ${USER}:${USER} storage -R
	if [ -d "node_modules" ]; then sudo chown ${USER}:${USER} node_modules -R; fi
	if [ -d "public/build" ]; then sudo chown ${USER}:${USER} public/build -R; fi
