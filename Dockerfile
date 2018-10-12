### update compose vendor libraries
FROM crunchgeek/composer:7.2 as composer
ARG TOKEN=
ENV TOKEN=$TOKEN
COPY ./ /src/
WORKDIR /src
RUN [ -z "$var" ] || echo "{\"github-oauth\": {\"github.com\": \"$TOKEN\"}}" > /tmp/auth.json
RUN composer install

### compile js & css assets
FROM node:latest as node
ARG MIX_PUSHER_APP_KEY=
ARG MIX_PUSHER_APP_CLUSTER=
ENV MIX_PUSHER_APP_KEY=$MIX_PUSHER_APP_KEY
ENV MIX_PUSHER_APP_CLUSTER=$MIX_PUSHER_APP_CLUSTER
WORKDIR /node
COPY --from=composer /src /node
RUN npm i cross-env -S && \
	npm i && \
	npm audit fix && \
	npm run production
RUN rm -rf /node/node_modules


### build app container
FROM alpine:3.5
WORKDIR /app
COPY --from=node /node /app

RUN mkdir -p /app/storage/app/public && \
	mkdir -p /app/storage/framework/cache && \
	mkdir -p /app/storage/framework/session && \
	mkdir -p /app/storage/framework/testing && \
	mkdir -p /app/storage/framework/views && \
	mkdir -p /app/storage/logs

RUN chown -R 9000:9000 storage && \
	chown -R 9000:9000 bootstrap/cache && \
	chmod -R ug+rwx    bootstrap/cache && \
	chgrp -R 9000      bootstrap/cache && \
	chmod +x artisan


# create a sh script to copy application into EmptyDir for K8s
RUN echo '#!/bin/sh'                      > /init.sh && \
	echo 'echo "app init started!"'      >> /init.sh && \
	echo 'mv /app/* /src/'               >> /init.sh && \
	echo 'mv /src/k8s/* /config/'        >> /init.sh && \
	echo 'cp -rp /src/public/* /public/' >> /init.sh && \
	echo 'echo "app init completed!"'    >> /init.sh && \
	chmod +x /init.sh

CMD [ '/init.sh' ]
