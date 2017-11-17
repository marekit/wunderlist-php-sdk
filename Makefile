ARGS = $(filter-out $@,$(MAKECMDGOALS))
MAKEFLAGS += --silent

list:
	sh -c "echo; $(MAKE) -p no_targets__ | awk -F':' '/^[a-zA-Z0-9][^\$$#\/\\t=]*:([^=]|$$)/ {split(\$$1,A,/ /);for(i in A)print A[i]}' | grep -v '__\$$' | grep -v 'Makefile'| sort"

#############################
# Docker machine states
#############################

up:
	docker-compose up -d

destroy:
	docker-compose down

start:
	docker-compose start

stop:
	docker-compose stop

restart: stop start

state:
	docker-compose ps

#############################
# General
#############################

build:
	docker-compose build

rebuild:
	docker-compose stop
	docker-compose pull
	docker-compose rm --force nginx_proxy engine server
	docker-compose build --no-cache --pull
	docker-compose up -d --force-recreate

bash: shell

shell:
    #TODO add user
	docker-compose exec engine /bin/bash

root:
	docker-compose exec --user root engine /bin/bash

db-shell:
	docker-compose exec db mysql -uroot -proot wunderlist

db:
	docker-compose exec db /bin/bash

#############################
# Argument fix workaround
#############################
%:
	@:
