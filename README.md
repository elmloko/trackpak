
1.- Instalación de Servidor y Herramientas PHP MariaDB
sudo yum install -y nginx php php-fpm mariadb-server

2.- Configurar Servicio php-fpm
sudo nano /etc/php-fpm.d/www.conf

3.- Cambiar el directorio de escucha y ejecuta

user=nginx
group=nginx

4.-cambiar el socket unix
listen = /var/run/php-fpm/php-fpm.sock

5.- Descomentar y cambiar parametros 

listen.owner = nginx
listen.group = nginx
listen.mode = 0660

6.- Iniciamos Servicio PHP

sudo systemctl star php-fpm
sudo systemctl enable php-fpm

7.-  Configurar servidor nginx
sudo nano /ect/nginx/nginx.conf

8.- Cambiar PHPfmp

en el bloque de server{
    //cambiar esta lineas de codigo
    root  /var/www/html;
    index  index.php;
    //comentamos esta linea
    #include /ect/nginx/default.d/*.conf;
    #location{
    }
}
 9.- agregamos debajo de error_page 500 502....
location ~ \.php$ {
    fastcgi_pass unix:/var/run/php-fpm/php-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
}

10.-Iniciamos servicio nginx 
sudo nginx -t
sudo systemctl restart nginx
sudo systemctl enable nginx

11.- PHP Packages Laravel nesesarios

sudo yum -y install php-{common,curl,json,mbstring,mysqlnd,xml,zip,opcache,fpm}

12.- NVM (Versión a la fecha de publicación del video)

wget qO https://raw.githubusercontent.com/nvm... | bash
source ~/.bashrc

13.- en listamos versiones
nvm ls-remote 

14.- Elegimos la mas resiente LTS y utilizamos esa version
nvm install VERSIONELEGIDA
nvm use VERSIONELEGIDA

15.- Composer Install
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

16.- Configurar composer de manera global
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
composer -V

17.-Inicamos MariaDB
sudo systemctl start mariadb
sudo systemctl enable mariadb

18.-Configuramos MariaDB y a todo le damos Y
sudo mysql_secure_installation

19.-Nos logeamos en MariaDB
mysql -u root -p

20.- Creas Base de Datos y permitir conexion 

GRANT ALL PRIVILEGES ON NOMBREDB.* To 'user'@'localhost' IDENTIFIED BY 'password';
flush privileges;

21.- dar privilegios para composer en html
cd /var/www/
sudo  chown -R agbc:agbc html

22.-copiamos el proyecto

23.-dar permisos al proyecto para ejecucion con nginx
sudo chown -R agbc:nginx bootstrap/cache storage
sudo chown ug+rw agbc:nginx bootstrap/cache storage

24.- Installar las dependencias de composer
composer install

25.- Copiar .env y configurar
cp .env.example .env

APP_NAME=TrackPak
DB_DATABASE=trackpak
DB_USERNAME=root
DB_PASSWORD=

26.- Generamos la llave 
php artisan key:generate

27.- Instalamos los paquetes npm y Compliamos
npm install && npm run dev

29.- Migramos
php artisan migrate

30.- Ajustamos Selinux
sudo semanage permissive -a httpd_t
 
yt
https://www.youtube.com/watch?v=pWy59Dn-pB0
https://www.youtube.com/watch?v=ok96RMlWTnQ

