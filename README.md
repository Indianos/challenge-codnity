# Codnity Challenge 2024 #

## Installation ##
1. Clone this repo
2. Make sure you have linux, macOS or wsl2
3. Make sure docker desktop is installed and running
4. Run in terminal: 
```shell
docker run --rm \
   -u "$(id -u):$(id -g)" \
   -v "$(pwd):/var/www/html" \
   -w /var/www/html \
   laravelsail/php83-composer:latest \
   composer install --ignore-platform-reqs
   ```
5. Run in terminal - will boot docker containers:
```shell
./vendor/bin/sail up -d
```

For additional sail commands, please see its [documentation](https://laravel.com/docs/11.x/sail).

6. Run in terminal - will compile frontend:
```shell
./vendor/bin/sail npm run build
```
