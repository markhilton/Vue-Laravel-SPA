## Laravel Single Page Application

Laravel SPA features integrations:
- docker containers
- kubernetes deployment
- workers to process queued jobs
- pushed notifications

After you clone this project, do the following:

```bash
# go into the project
cd Vue-Laravel-SPA

# create a .env file
cp .env.example .env

# generate a key for your application & JWT server secret
php artisan key:generate
php artisan jwt:secret

# configure Laravel to use MongoDB, Redis for queues, sessions and cache
sed -i '/DB_CONNECTION/c\DB_CONNECTION=mongodb' .env
sed -i '/CACHE_DRIVER/c\CACHE_DRIVER=redis'     .env
sed -i '/SESSION_DRIVER/c\SESSION_DRIVER=redis' .env
sed -i '/QUEUE_DRIVER/c\QUEUE_DRIVER=redis'     .env
sed -i '/REDIS_HOST/c\REDIS_HOST=redis'         .env

# deploy stack with docker compose
docker-compose up -d
```

# Based on...

[Youtube Tutorial link](https://www.youtube.com/watch?v=Jd1RW-0lQOs&t=13s)

#### [@WeCodeTutorials](https://twitter.com/WeCodeTutorials)
[![Logo](https://cdn.pbrd.co/images/HdwCut8.png)](https://www.youtube.com/channel/UCj9VatwdukZjNOnIKcpWcsA)

This project is made for my youtube tutorial on "Create a SPA with Vue.JS 2, Vue-Router, Vuex and Laravel 5.6".

![App Example](https://media.giphy.com/media/9JkdzNeLr0Jos5CYQk/giphy.gif)

# Troubleshooting

Don't worry about Laravel route error during containers initialization.
```
LogicException  : Unable to prepare route [{any}] for serialization. Uses Closure.
```
