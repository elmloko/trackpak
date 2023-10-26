Instalar Dependencias 

sudo apt install -y nginx composer git mariadb-server curl 

 

Instalar Complementos 

sudo apt install openssl php-{common,curl,json,mbstring,mysql,xml,zip,opcache,fpm} 

 

Ver estados de servicios 

sudo systemctl status nginx 

sudo systemctl status php8.2-fpmm 

sudo systemctl status mariadb 

composer -v 

git --version 

php -v 

 

Habilitar auto arranque de los servicios 

sudo systemctl enable php8.2-fpm 

sudo systemctl enable mariadb 

sudo systemctl enable nginx 

 

Installar mariadb 

sudo mysql_secure_installation 

y dar todo Y poner contraseñas 

 

Configurara mariadb 

GRANT ALL PRIVILEGES ON trackpak.* To 'root'@'localhost' IDENTIFIED BY 'elmloko'; 

 

Reset Privilegios 

flush privileges; 

 

Instalar nvm 

sudo curl https://raw.githubusercontent.com/creationix/nvm/master/install.sh | bash 

source ~/.profile 

Sudo  

Instalamos node 

nvm install node 

 

Damos permisos  

cd /var/www/ 

sudo chown -R elmloko:elmloko html 

 

Instalamos Laravel 

composer global require laravel/installer 

 

Clonamos nuestro repo 

cd /var/www/html 

git clone https://github.com/elmloko/TrackPak.git 

 

Dar permisos a las carpetas del proyecto  

cd /var/www/html/Trackpak  

sudo chgrp -R www-data bootstrap/cache storage 

sudo chmod -R ug+rw bootstrap/cache storage 

 

Instalar las dependencias del proyecto 

npm install 

composer install --ignore-platform-reqs 

.env 

php artisan migrate 

php artisan key:generate 

 

Entramos al directorio de nginx y configuramos 

cd etc/nginx/sites-available 

sudo nano default 

 

Cambiamos WordPress 
server {
    listen 80;
    listen [::]:80;
    server_name kosmos.test;
    root /var/www/html/Kosmos;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
	include snippets/fastcgi-php.conf;
	fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }
}
Cambiamos Laravel
server {
    listen 80;
    listen [::]:80;
    server_name trackpak.test;
    root /var/www/html/TrackPak/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
	include snippets/fastcgi-php.conf;
	fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }
}

 

Publicamos los cambios y reiniciamos los servicios 

sudo nginx -t 

sudo systemctl restart nginx 

 

Cambiamos los Hosts 

cd /ect/ 

sudo nano hosts 

Añadimos 

127.0.0.2       trackpak.test 

Dar Permisos y propiedades a archivos

touch /var/www/html/TrackPak/storage/logs/laravel.log
sudo chmod 664 /var/www/html/TrackPak/storage/logs/laravel.log
sudo chown www-data:www-data /var/www/html/TrackPak/storage/logs/laravel.log

sudo chmod -R 775 /var/www/html/TrackPak/storage
sudo chmod -R 775 /var/www/html/TrackPak/bootstrap/cache
sudo chown -R www-data:www-data /var/www/html/TrackPak/storage
sudo chown -R www-data:www-data /var/www/html/TrackPak/bootstrap/cache