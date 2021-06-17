## Example laravel project

Just a small example project written to test **Laravel** + **Inertia** + **React** stack

### Setup
There are two ways to set up the project locally. Using local server or using docker.

#### The Docker way
For this approach you need to have `docker` and `docker-compose` installed on your machine. 

- Install composer dependencies  
`docker run --rm --interactive --tty --volume $PWD:/app composer install`
  

- Install node dependencies  
`docker run --rm --interactive --tty --volume "$PWD":/usr/src/app -w /usr/src/app node:slim npm install`


- Copy environment variables file  
`cp .env.dev.example .env`


- Run docker containers  
`./sail up`


- Generate application key  
`./sail php artisan key:generate`


- Create database file  
`./sail php artisan db:sqlite.create`


- Run database migrations  
`./sail php artisan migrate`


- Seed database  
`./sail php artisan db:seed`


- Create public link to storage  
`./sail php artisan storage:link`

You now should be able to access the app on http://localhost  
All sent emails are being stored in Mailhog and could be found at http://localhost:8025.

If your 80 port is in use by other process set the `APP_PORT` in your .env file to some other port, 
then stop sail (`ctrl + c` or `sail stop` if running in background) and start it again (`sail up`).

#### The local server way
For this approach you need to have `composer`, `php`, `node` and `npm` installed on your machine.
You will also need some php extensions. Such as `sqlite3`, `gd` and all the extensions that are required by Laravel.

- Install composer dependencies  
`composer install`
  

- Install node dependencies  
`npm install`
  

- Copy env file  
`cp .env.dev.example .env`
  

- Generate application key  
`php artisan key:generate`
  

- Create database file  
`php artisan db:sqlite.create`
  

- Run database migrations  
`php artisan migrate`
  

- Seed database  
`php artisan db:seed`
  

- Create public link to storage  
`php artisan storage:link`
  

- Run the server  
`php artisan serve`

You now should be able to access the app on http://localhost:8000  
All sent emails are being stored in Laravel's log file.

## Description

It's a simple books database. There are 3 types of users: guests, users and admins.

As a guest you can:
- list books
- open a detailed book page where you get more info about
a particular book
- list authors
- open a detailed author page where you get more info about
  a particular author
- register as a user

As a user you can:
- do everything a guest can do
- add a book to wishlist
- show wishlist
- send wishlist to an email

As an admin you can:
- do everything a user can do
- add, edit or delete a book 
- add, edit or delete an author

## How to use
Example user credentials:  
login: `user@test.com`  
pass: `test1234`  

Example admin credentials:  
login: `admin@test.com`  
pass: `test1234`
