Laravel 10
nombre clave TRACKPAK
nombre del sistema TRACKINGBO

Credenciales
caleb.conde@correos.gob.bo              CCH12767384LP   Urbano
wike.mamani@correos.gob.bo              WMA6841118LP    Auxiliar Urbano
omar.quispe@correos.gob.bo              12345678        Clasificacion
rodrigo.villa@correos.gob.bo            RVS9883740      Auxiliar Clasificacion

Utilize

 https://laravel-excel.com/                                     maatwebsite/excel
 https://github.com/barryvdh/laravel-dompdf                     barryvdh/laravel-dompdf
 https://github.com/awais-vteams/laravel-crud-generator         ibex/crud-generator
 https://github.com/jeroennoten/Laravel-AdminLTE                jeroennoten/laravel-adminlte
 https://spatie.be/docs/laravel-permission/v5/introduction      spatie/laravel-permission
 https://laravel-livewire.com/                                  livewire/livewire
 https://github.com/wire-elements/modal/tree/1.0.0              wire-elements/modal
 https://github.com/milon/barcode                               milon/barcode
 https://github.com/picqer/php-barcode-generator                picqer/php-barcode-generator

SQL
 UPDATE `trackpak`.`packages`
 SET `ESTADO` = 'VENTANILLA';

UPDATE packages
SET ESTADO = 'VENTANILLA', created_at = '2023-11-23 12:00:00'
WHERE CUIDAD = 'LA PAZ';

DELETE FROM packages
WHERE CUIDAD = 'LA PAZ';

DELETE FROM packages
WHERE CUIDAD = 'LA PAZ' AND updated_at IS NULL;

git pull origin main

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
