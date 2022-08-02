### start
- set up a local server
- git clone https://github.com/konstvax/post-api.git
- cp .env.example .env
- create db and set into .env file
- composer install
- php artisan key:generate
- php artisan storage:link


### front routes
- GET api/v1/categories/{slug}
- GET api/v1/posts/{slug}
### back routes (with bearer authorization token)
- GET api/v1/dashboard/categories
- GET api/v1/dashboard/categories/{id}
- PUT api/v1/dashboard/categories/{id}
- POST api/v1/dashboard/categories
- DELETE api/v1/dashboard/categories/{id}

<hr>

- GET api/v1/dashboard/posts
- GET api/v1/dashboard/posts/{id}
- PUT api/v1/dashboard/posts/{id}
- POST api/v1/dashboard/posts
- DELETE api/v1/dashboard/posts/{id}
