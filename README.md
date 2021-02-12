## Test Melhor Envio

### How to locally deploy
- > $ git clone https://github.com/rafaelbreno/lumen-json-processor.git
- > $ cd lumen-json-processor
- > $ cp .env.example .env
- > $ php artisan key:generate
- Configure `.env` file
- > $ composer install

- Then there are 2 options:
1. Using docker
    - run: `$ docker-compose up -d`
    - `$ docker-compose exec app php artisan migrate `
    - Access `localhost:8000`
2. _"Normal"_ way
    - `$ php artisan serve`
    - Configure your databases

