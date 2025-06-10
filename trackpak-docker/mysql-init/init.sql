-- Asegura que root existe@'%' con la contraseña agbc
ALTER USER 'root'@'%' IDENTIFIED BY 'agbc';

-- Otorga todos los privilegios (incluye GRANT OPTION)
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;

FLUSH PRIVILEGES;
