# Codnity Challenge 2024 #

## Installation ##
1. Clone this repo
2. Make sure you have linux, macOS or wsl2
3. Make sure docker desktop is installed and running
4. Run in terminal - initial laravel sail setup: 
```shell
docker run --rm \
   -u "$(id -u):$(id -g)" \
   -v "$(pwd):/var/www/html" \
   -w /var/www/html \
   laravelsail/php83-composer:latest \
   composer install --ignore-platform-reqs
```
5. Run in terminal - create .env file:
```shell 
cp .env.example .env
```
6. Run in terminal - will boot docker containers:
```shell
./vendor/bin/sail up -d
```
7. Run in terminal - generate app key:
```shell
./vendor/bin/sail artisan key:generate
```
8. Run in terminal - run database migrations:
```shell
./vendor/bin/sail artisan migrate
```

9. Run in terminal - will install frontend packages:
```shell
./vendor/bin/sail npm install
```

10. Run in terminal - will compile frontend
```shell
./vendor/bin/sail npm run build
```

**App is now ready and running in local.**

&nbsp;

&nbsp;

&nbsp;

&nbsp;

&nbsp;
```shell
./vendor/bin/sail artisan scrape:y-combi
```
