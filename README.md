# Laravel Single Page Application

Laravel single page application build with VUE & [VuetifyJs](https://vuetifyjs.com/en/) features integrations:
- [Docker](https://www.docker.com/) & [docker-compose](https://docs.docker.com/compose/)
- [Kubernetes](https://kubernetes.io/) deployment
- A separate [worker node](https://laravel.com/docs/5.7/queues) to process queued jobs and auto scale independently from the main application containers
- Laravel [horizon](https://laravel.com/docs/5.7/horizon)
- [Pusher](https://pusher.com/) push notifications
- [MongoDB](https://www.mongodb.com/) to forget database migrations and move on

### Local deployment

```bash
# clone this repository
git clone https://github.com/markhilton/laravel-spa

# go into the project
cd laravel-spa

# create a .env file
cp .env.example .env

# generate a key for your application & JWT server secret
php artisan key:generate
php artisan jwt:secret

# deploy stack with docker compose
docker-compose up
```

give it some time after first, initial deployment for [Composer](https://getcomposer.org/)
and [NPM](https://www.npmjs.com/) to download all required vendor libraries and packages.
The node container will watch for file changes as you work with VUE components and automatically
mix `app.js`, `app.css` files as needed and create new `mix-manifest.json`.

You can watch progress on docker-compose log output.

### Production deployment

I work with [Google Cloud](https://cloud.google.com/) [GKE](https://cloud.google.com/kubernetes-engine/) and usually leverage
[Google Cloud Build](https://cloud.google.com/cloud-build/) to automatically build my app images when the code is pushed to repository and tagged,
so I share my `cloudbuild.yaml` here too and can post integration instructions if anybody asks.

I will add my [Helm](https://helm.sh/) chart for Kubernetes deployment soon.

## Credits

[Afik Deri](https://github.com/AfikDeri),
his [repository](https://github.com/AfikDeri/Vue-Laravel-SPA]) which I forked
and some great [YouTube tutorials](https://www.youtube.com/watch?v=Jd1RW-0lQOs&t=13s)

## FAQ

### Why use own docker images instead [Laradock](https://github.com/laradock/laradock)?
I've build my own [Nginx](https://github.com/markhilton/docker-nginx-pagespeed) and
[PHP](https://github.com/markhilton/docker-php-fpm) Docker containers because I wanted to have out of the box,
full-blown images I can control just with environment variables without having to build them every time I start a new project.
They are not light-weight, rather have all necessary PHP extensions or Nginx modules I ever needed.


## Troubleshooting

Don't worry about [Laravel route error](https://stackoverflow.com/questions/45266254/laravel-unable-to-prepare-route-for-serialization-uses-closure) during containers initialization.
```
LogicException  : Unable to prepare route [{any}] for serialization. Uses Closure.
```
