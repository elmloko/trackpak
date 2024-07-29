# POSTAL PARCEL TRACKING SYSTEM TO IMPROVE THE CONTROL AND DISPATCH OF SHIPMENTS NATIONWIDE AT THE BOLIVIAN POSTAL AGENCY "TRACKINGBO"

Web systems are essential for any public or private institution, as they allow processing, automating and storing information accessible at all times. This project addresses parcel tracking at the national level, starting at the headquarters of the Agencia Boliviana de Correos (AGBC) and passing through several control points where parcels are verified, monitored and delivered.

The parcel trade, including postal mail, faces problems such as lack of information on the arrival of parcels, which delays deliveries or results in parcels not being picked up. The CBGA suffers from inefficiencies in the control of inbound and outbound parcels due to outdated processes, which can lead to delays and, in the worst case, corruption.

To solve these problems, a modern and efficient system for tracking parcels nationwide was developed. This system will improve the accessibility of the service and make it more empathetic to any type of customer, ensuring a more efficient and transparent management of parcels.

## LANGUAGES, FRAMEWORKS USED AND TOOLS 🛠️

* PHP 8.1.10
* LARAVEL 10
* LIVEWIRE
* COMPOSER
* MYSQL

  https://laravel-excel.com/                                    				maatwebsite/excel
  https://github.com/barryvdh/laravel-dompdf                    		barryvdh/laravel-dompdf
  https://github.com/awais-vteams/laravel-crud-generator        	ibex/crud-generator
  https://github.com/jeroennoten/Laravel-AdminLTE               		jeroennoten/laravel-adminlte
  https://spatie.be/docs/laravel-permission/v5/introduction    		spatie/laravel-permission
  https://laravel-livewire.com/                             				livewire/livewire
  https://github.com/wire-elements/modal/tree/1.0.0     	     		wire-elements/modal
  https://github.com/milon/barcode                               			milon/barcode
  https://github.com/picqer/php-barcode-generator              		picqer/php-barcode-generator
  https://github.com/biscolab/laravel-recaptcha				biscolab/laravel-recaptcha
  https://jwt-auth.readthedocs.io/en/develop/					tymon/jwt-auth
  https://laravel.com/docs/11.x/pulse							laravel/pulse

## Installation

We clone the repository

```bash
git clone https://github.com/elmloko/trackpak
```

We install our dependencies with [XAMMP](https://www.apachefriends.org/es/download.html)

## DataBases

* We import the database to MySQL

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trackpak
DB_USERNAME=root
DB_PASSWORD=
```

* migrate and seed in database

## Credentials

| User  | Pass  |
| ----- | ----- |
| Admin | admin |

## Authors and acknowledgment

Developers of this software

* Marco Antonio Espinoza Rojas

## System installation

* Install Node dependencies:

```bash
npm install
```

* Install Composer dependencies:

```bash
composer install
```

* Copy the environment configuration file:

```bash
cp .env.example .env
```

* Generate the application key:

```bash
php artisan key:generate
```

## System configuration

* System cleanup and optimization:

```bash
php artisan optimize
```

* Generate jwt token:

```bash
php artisan jwt:secret
```
* Capturing Entries:

```bash
php artisan pulse:check
```

## License

[GNU](https://www.gnu.org/licenses/gpl-3.0.en.html)
