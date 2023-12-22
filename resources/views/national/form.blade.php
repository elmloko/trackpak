<div class="box box-info padding-1">
    <div class="box-body">
        <h4>Datos del Paquete</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('CODIGO DE RASTEO') }}
                    {{ Form::text('CODIGO', strtoupper($national->CODIGO), ['class' => 'form-control' . ($errors->has('CODIGO') ? ' is-invalid' : ''), 'style' => 'text-transform: uppercase;', 'placeholder' => 'Codigo de Rastreo']) }}
                    {!! $errors->first('CODIGO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TIPO DE SERVICIO') }}
                    {{ Form::select('TIPO', ['EMS' => 'EMS', 'CERTIFICADA' => 'CERTIFICADA', 'ORDINARIA' => 'ORDINARIA', 'ECA' => 'ECA', 'CASILLAS' => 'CASILLAS', 'SUPEREXPRESS' => 'SUPEREXPRESS', 'EXPRESS' => 'EXPRESS', 'AVISO RECIBO' => 'AVISO RECIBO'], $national->TIPOSERVICIO, ['class' => 'form-control' . ($errors->has('TIPOSERVICIO') ? ' is-invalid' : ''), 'placeholder' => 'Tipo de servicio postal nacional']) }}
                    {!! $errors->first('TIPOSERVICIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TIPO DE CORRESPONDENCIA') }}
                    {{ Form::select('TIPO', ['PAQUETE' => 'PAQUETE', 'CARTA' => 'CARTA', 'TARJETA POSTAL' => 'TARJETA POSTAL', 'REVISTA' => 'REVISTA', 'IMPRESO' => 'IMPRESO', 'CECOGRAMA' => 'CECOGRAMA', 'PEQUEÑO PAQUETE' => 'PEQUEÑO PAQUETE', 'SACA M' => 'SACA M', 'ENCOMIENTA' => 'ENCOMIENDA', 'DOCUMENTO' => 'DOCUMENTO'], $national->TIPOCORRESPONDENCIA, ['class' => 'form-control' . ($errors->has('TIPOCORRESPONDENCIA') ? ' is-invalid' : ''), 'placeholder' => 'Tipo de correspondencia']) }}
                    {!! $errors->first('TIPOCORRESPONDENCIA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('CANTIDAD DE ENVIOS') }}
                    {{ Form::number('CANTIDAD', $national->CANTIDAD, ['class' => 'form-control' . ($errors->has('CANTIDAD') ? ' is-invalid' : ''), 'placeholder' => 'Cantidad de envios']) }}
                    {!! $errors->first('CANTIDAD', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('PESO (Kg.)') }}
                    {{ Form::number('PESO', $national->PESO, ['class' => 'form-control' . ($errors->has('PESO') ? ' is-invalid' : ''), 'placeholder' => 'Peso expresado en Kilogramos']) }}
                    {!! $errors->first('PESO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('DESTINO NACIONAL') }}
                    {{ Form::select('DESTINO', ['LA PAZ' => 'LA PAZ', 'COCHABAMBA' => 'COCHABAMBA', 'SANTA CRUZ' => 'SANTA CRUZ', 'ORURO' => 'ORURO', 'POTOSI' => 'POTOSI', 'TARIJA' => 'TARIJA', 'CHUQUISACA' => 'CHUQUISACA', 'BENI' => 'BENI', 'PANDO' => 'PANDO'], $national->DESTINO, ['class' => 'form-control' . ($errors->has('DESTINO') ? ' is-invalid' : ''), 'placeholder' => 'Destino nacional', 'id' => 'ciudad-select']) }}
                    {!! $errors->first('DESTINO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('MUNICIPIO') }}
                    {{ Form::select(
                        'MUNICIPIO',
                        [
                            'Camargo' => 'Camargo',
                            'Camataqui' => 'Camataqui',
                            'Culpina' => 'Culpina',
                            'El Villar' => 'El Villar',
                            'Huacaya' => 'Huacaya',
                            'Icla' => 'Icla',
                            'Incahuasi' => 'Incahuasi',
                            'Las Carreras' => 'Las Carreras',
                            'Macharetí' => 'Macharetí',
                            'Monteagudo' => 'Monteagudo',
                            'Padilla' => 'Padilla',
                            'Poroma' => 'Poroma',
                            'Presto' => 'Presto',
                            'San Lucas' => 'San Lucas',
                            'San Pablo de Huacareta' => 'San Pablo de Huacareta',
                            'Sopachuy' => 'Sopachuy',
                            'Sucre' => 'Sucre',
                            'Tarabuco' => 'Tarabuco',
                            'Tarvita' => 'Tarvita',
                            'Tomina' => 'Tomina',
                            'Villa Alcalá' => 'Villa Alcalá',
                            'Villa Azurduy' => 'Villa Azurduy',
                            'Villa Charcas' => 'Villa Charcas',
                            'Villa Mojocoya' => 'Villa Mojocoya',
                            'Villa Serrano' => 'Villa Serrano',
                            'Villa Vaca Guzmán' => 'Villa Vaca Guzmán',
                            'Villa Zudáñez' => 'Villa Zudáñez',
                            'Yamparáez' => 'Yamparáez',
                            'Yotala' => 'Yotala',
                            'Achacachi' => 'Achacachi',
                            'Achocalla' => 'Achocalla',
                            'Ancoraimes' => 'Ancoraimes',
                            'Andrés de Machaca' => 'Andrés de Machaca',
                            'Apolo' => 'Apolo',
                            'Aucapata' => 'Aucapata',
                            'Ayata' => 'Ayata',
                            'Ayo Ayo' => 'Ayo Ayo',
                            'Batallas' => 'Batallas',
                            'Cairoma' => 'Cairoma',
                            'Cajuata' => 'Cajuata',
                            'Calacoto' => 'Calacoto',
                            'Calamarca' => 'Calamarca',
                            'Caquiaviri' => 'Caquiaviri',
                            'Caranavi' => 'Caranavi',
                            'Catacora' => 'Catacora',
                            'Chacarilla' => 'Chacarilla',
                            'Charaña' => 'Charaña',
                            'Chulumani' => 'Chulumani',
                            'Chuma' => 'Chuma',
                            'Collana' => 'Collana',
                            'Colquencha' => 'Colquencha',
                            'Colquiri' => 'Colquiri',
                            'Comanche' => 'Comanche',
                            'Combaya' => 'Combaya',
                            'Copacabana' => 'Copacabana',
                            'Coripata' => 'Coripata',
                            'Coro Coro' => 'Coro Coro',
                            'Coroico' => 'Coroico',
                            'Curva' => 'Curva',
                            'Desaguadero' => 'Desaguadero',
                            'El Alto' => 'El Alto',
                            'Gral. Juan José Perez (Charazani)' => 'Gral. Juan José Perez (Charazani)',
                            'Guanay' => 'Guanay',
                            'Guaqui' => 'Guaqui',
                            'Ichoca' => 'Ichoca',
                            'Inquisivi' => 'Inquisivi',
                            'Irupana' => 'Irupana',
                            'Ixiamas' => 'Ixiamas',
                            'Jesús de Machaca' => 'Jesús de Machaca',
                            'La Asunta' => 'La Asunta',
                            'La Paz' => 'La Paz',
                            'Laja' => 'Laja',
                            'Licoma Pampa' => 'Licoma Pampa',
                            'Luribay' => 'Luribay',
                            'Malla' => 'Malla',
                            'Mapiri' => 'Mapiri',
                            'Mecapaca' => 'Mecapaca',
                            'Mocomoco' => 'Mocomoco',
                            'Nazacara de Pacajes' => 'Nazacara de Pacajes',
                            'Palca' => 'Palca',
                            'Palos Blancos' => 'Palos Blancos',
                            'Papel Pampa' => 'Papel Pampa',
                            'Patacamaya' => 'Patacamaya',
                            'Pelechuco' => 'Pelechuco',
                            'Pucarani' => 'Pucarani',
                            'Puerto Acosta' => 'Puerto Acosta',
                            'Puerto Carabuco' => 'Puerto Carabuco',
                            'Puerto Pérez' => 'Puerto Pérez',
                            'Quiabaya' => 'Quiabaya',
                            'Quime' => 'Quime',
                            'San Buena Ventura' => 'San Buena Ventura',
                            'San Pedro de Curahuara' => 'San Pedro de Curahuara',
                            'San Pedro de Tiquina' => 'San Pedro de Tiquina',
                            'Santiago de Callapa' => 'Santiago de Callapa',
                            'Santiago de Machaca' => 'Santiago de Machaca',
                            'Sapahaqui' => 'Sapahaqui',
                            'Sica Sica' => 'Sica Sica',
                            'Sorata' => 'Sorata',
                            'Tacacoma' => 'Tacacoma',
                            'Taraco' => 'Taraco',
                            'Teoponte' => 'Teoponte',
                            'Tiahuanacu' => 'Tiahuanacu',
                            'Tipuani' => 'Tipuani',
                            'Tito Yupanqui' => 'Tito Yupanqui',
                            'Umala' => 'Umala',
                            'Viacha' => 'Viacha',
                            'Waldo Ballivián' => 'Waldo Ballivián',
                            'Yaco' => 'Yaco',
                            'Yanacachi' => 'Yanacachi',
                            'Huarina' => 'Huarina',
                            'Santiago de Huata' => 'Santiago de Huata',
                            'Escoma' => 'Escoma',
                            'Humanata' => 'Humanata',
                            'Alto Beni' => 'Alto Beni',
                            'Aiquile' => 'Aiquile',
                            'Alalay' => 'Alalay',
                            'Anzaldo' => 'Anzaldo',
                            'Arani' => 'Arani',
                            'Arbieto' => 'Arbieto',
                            'Arque' => 'Arque',
                            'Bolívar' => 'Bolívar',
                            'Capinota' => 'Capinota',
                            'Chimoré' => 'Chimoré',
                            'Cliza' => 'Cliza',
                            'Cochabamba' => 'Cochabamba',
                            'Colcapirhua' => 'Colcapirhua',
                            'Colomi' => 'Colomi',
                            'Cuchumuela' => 'Cuchumuela',
                            'Entre Ríos (Bulo Bulo)' => 'Entre Ríos (Bulo Bulo)',
                            'Independencia' => 'Independencia',
                            'Mizque' => 'Mizque',
                            'Morochata' => 'Morochata',
                            'Omereque' => 'Omereque',
                            'Pasorapa' => 'Pasorapa',
                            'Pocona' => 'Pocona',
                            'Pojo' => 'Pojo',
                            'Puerto Villarroel' => 'Puerto Villarroel',
                            'Punata' => 'Punata',
                            'Quillacollo' => 'Quillacollo',
                            'Sacaba' => 'Sacaba',
                            'Sacabamba' => 'Sacabamba',
                            'San Benito' => 'San Benito',
                            'Santivañez' => 'Santivañez',
                            'Sicaya' => 'Sicaya',
                            'Sipe Sipe' => 'Sipe Sipe',
                            'Tacachi' => 'Tacachi',
                            'Tacopaya' => 'Tacopaya',
                            'Tapacarí' => 'Tapacarí',
                            'Tarata' => 'Tarata',
                            'Tiquipaya' => 'Tiquipaya',
                            'Tiraque' => 'Tiraque',
                            'Toco' => 'Toco',
                            'Tolata' => 'Tolata',
                            'Totora' => 'Totora',
                            'Vacas' => 'Vacas',
                            'Vila Vila' => 'Vila Vila',
                            'Villa Rivero' => 'Villa Rivero',
                            'Villa Tunari' => 'Villa Tunari',
                            'Vinto' => 'Vinto',
                            'Cocapata ' => 'Cocapata ',
                            'Shinahota ' => 'Shinahota ',
                            'Andamarca' => 'Andamarca',
                            'Antequera' => 'Antequera',
                            'Belén de Andamarca' => 'Belén de Andamarca',
                            'Caracollo' => 'Caracollo',
                            'Carangas' => 'Carangas',
                            'Challapata' => 'Challapata',
                            'Chipaya' => 'Chipaya',
                            'Choquecota' => 'Choquecota',
                            'Coipasa' => 'Coipasa',
                            'Corque' => 'Corque',
                            'Cruz de Machacamarca' => 'Cruz de Machacamarca',
                            'Curahuara de Carangas' => 'Curahuara de Carangas',
                            'El Choro' => 'El Choro',
                            'Escara' => 'Escara',
                            'Esmeralda' => 'Esmeralda',
                            'Eucaliptus' => 'Eucaliptus',
                            'Huachacalla' => 'Huachacalla',
                            'La Rivera' => 'La Rivera',
                            'Machacamarca' => 'Machacamarca',
                            'Oruro' => 'Oruro',
                            'Pampa Aullagas' => 'Pampa Aullagas',
                            'Pazña' => 'Pazña',
                            'Sabaya' => 'Sabaya',
                            'Salinas de Garci Mendoza' => 'Salinas de Garci Mendoza',
                            'Santiago de Huari' => 'Santiago de Huari',
                            'Santiago de Huayllamarca' => 'Santiago de Huayllamarca',
                            'Santuario de Quillacas' => 'Santuario de Quillacas',
                            'Soracachi' => 'Soracachi',
                            'Todos Santos' => 'Todos Santos',
                            'Toledo' => 'Toledo',
                            'Totora' => 'Totora',
                            'Turco' => 'Turco',
                            'Villa Huanuni' => 'Villa Huanuni',
                            'Villa Poopó' => 'Villa Poopó',
                            'Yunguyo del Litoral' => 'Yunguyo del Litoral',
                            'Acasio' => 'Acasio',
                            'Arampampa' => 'Arampampa',
                            'Atocha' => 'Atocha',
                            'Belén de Urmiri' => 'Belén de Urmiri',
                            'Betanzos' => 'Betanzos',
                            'Caiza "D"' => 'Caiza "D"',
                            'Caripuyo' => 'Caripuyo',
                            'Chaquí' => 'Chaquí',
                            'Chayanta' => 'Chayanta',
                            'Colcha "K"' => 'Colcha "K"',
                            'Colquechaca' => 'Colquechaca',
                            'Cotagaita' => 'Cotagaita',
                            'Llallagua' => 'Llallagua',
                            'Llica' => 'Llica',
                            'Mojinete' => 'Mojinete',
                            'Ocurí' => 'Ocurí',
                            'Pocoata' => 'Pocoata',
                            'Porco' => 'Porco',
                            'Potosí' => 'Potosí',
                            'Puna' => 'Puna',
                            'Ravelo' => 'Ravelo',
                            'Sacaca' => 'Sacaca',
                            'San Agustín' => 'San Agustín',
                            'San Antonio de Esmoruco' => 'San Antonio de Esmoruco',
                            'San Pablo de Lipez' => 'San Pablo de Lipez',
                            'San Pedro de Buena Vista' => 'San Pedro de Buena Vista',
                            'San Pedro de Quemes' => 'San Pedro de Quemes',
                            'Tacobamba' => 'Tacobamba',
                            'Tahua' => 'Tahua',
                            'Tinguipaya' => 'Tinguipaya',
                            'Tomave' => 'Tomave',
                            'Toro Toro' => 'Toro Toro',
                            'Tupiza' => 'Tupiza',
                            'Uncía' => 'Uncía',
                            'Uyuni' => 'Uyuni',
                            'Villa de Yocalla' => 'Villa de Yocalla',
                            'Villazón' => 'Villazón',
                            'Vitichi' => 'Vitichi',
                            'Chuquiuta' => 'Chuquiuta',
                            'Ckochas' => 'Ckochas',
                            'Bermejo' => 'Bermejo',
                            'Caraparí' => 'Caraparí',
                            'El Puente' => 'El Puente',
                            'Entre Ríos' => 'Entre Ríos',
                            'Padcaya' => 'Padcaya',
                            'San Lorenzo' => 'San Lorenzo',
                            'Tarija' => 'Tarija',
                            'Uriondo' => 'Uriondo',
                            'Villamontes' => 'Villamontes',
                            'Yacuiba' => 'Yacuiba',
                            'Yunchará' => 'Yunchará',
                        ],
                        $national->MUNICIPIO,
                        [
                            'class' => 'form-control' . ($errors->has('MUNICIPIO') ? ' is-invalid' : ''),
                            'placeholder' => 'Municipio',
                            'id' => 'municipio-select',
                        ],
                    ) }}
                    {!! $errors->first('MUNICIPIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('PROVINCIA') }}
                    {{ Form::select(
                        'PROVINCIA',
                        [
                            'Nor Cinti' => 'Nor Cinti',
                            'Sud Cinti' => 'Sud Cinti',
                            'Tomina' => 'Tomina',
                            'Luis Calvo' => 'Luis Calvo',
                            'Zudañez' => 'Zudañez',
                            'Hernando Siles' => 'Hernando Siles',
                            'Oropeza' => 'Oropeza',
                            'Yamparáez' => 'Yamparáez',
                            'Azurduy' => 'Azurduy',
                            'Zudáñez' => 'Zudáñez',
                            'Belisario Boeto' => 'Belisario Boeto',
                            'Yotala' => 'Yotala',
                            'Villa Charcas' => 'Villa Charcas',
                            'Omasuyos' => 'Omasuyos',
                            'Murillo' => 'Murillo',
                            'Ingavi' => 'Ingavi',
                            'Franz Tamayo' => 'Franz Tamayo',
                            'Muñecas' => 'Muñecas',
                            'Aroma' => 'Aroma',
                            'Los Andes' => 'Los Andes',
                            'Loayza' => 'Loayza',
                            'Inquisivi' => 'Inquisivi',
                            'Pacajes' => 'Pacajes',
                            'Caranavi' => 'Caranavi',
                            'José Manuel Pando' => 'José Manuel Pando',
                            'Gualberto Villarroel' => 'Gualberto Villarroel',
                            'Sud Yungas' => 'Sud Yungas',
                            'Larecaja' => 'Larecaja',
                            'Manco Kapac' => 'Manco Kapac',
                            'Nor Yungas' => 'Nor Yungas',
                            'Bautista Saavedra' => 'Bautista Saavedra',
                            'Abel Iturralde' => 'Abel Iturralde',
                            'Camacho' => 'Camacho',
                            'Campero' => 'Campero',
                            'Mizque' => 'Mizque',
                            'Esteban Arce' => 'Esteban Arce',
                            'Arani' => 'Arani',
                            'Arque' => 'Arque',
                            'Bolívar' => 'Bolívar',
                            'Capinota' => 'Capinota',
                            'Carrasco' => 'Carrasco',
                            'Germán Jordán' => 'Germán Jordán',
                            'Cercado' => 'Cercado',
                            'Quillacollo' => 'Quillacollo',
                            'Chapare' => 'Chapare',
                            'Punata' => 'Punata',
                            'Ayopaya' => 'Ayopaya',
                            'Tapacarí' => 'Tapacarí',
                            'Tiraque' => 'Tiraque',
                            'Sud Carangas' => 'Sud Carangas',
                            'Poopó' => 'Poopó',
                            'Cercado' => 'Cercado',
                            'Puerto de Mejillones' => 'Puerto de Mejillones',
                            'Eduardo Avaroa' => 'Eduardo Avaroa',
                            'Atahuallpa' => 'Atahuallpa',
                            'Carangas' => 'Carangas',
                            'Litoral de Atacama' => 'Litoral de Atacama',
                            'Sajama' => 'Sajama',
                            'Tomas Barrón' => 'Tomas Barrón',
                            'Pantaleón Dalence' => 'Pantaleón Dalence',
                            'Ladislao Cabrera' => 'Ladislao Cabrera',
                            'Sebastián Pagador' => 'Sebastián Pagador',
                            'Nor Carangas' => 'Nor Carangas',
                            'Saucari' => 'Saucari',
                            'San Pedro de Totora' => 'San Pedro de Totora',
                            'Bernardino Bilbao' => 'Bernardino Bilbao',
                            'Rioja' => 'Rioja',
                            'Sur Chichas' => 'Sur Chichas',
                            'Tomas Frías' => 'Tomas Frías',
                            'Cornelio Saavedra' => 'Cornelio Saavedra',
                            'José María Linares' => 'José María Linares',
                            'Alonso de Ibañez' => 'Alonso de Ibañez',
                            'Rafael Bustillo' => 'Rafael Bustillo',
                            'Nor Lípez' => 'Nor Lípez',
                            'Chayanta' => 'Chayanta',
                            'Nor Chichas' => 'Nor Chichas',
                            'Daniel Campos' => 'Daniel Campos',
                            'Sur Lípez' => 'Sur Lípez',
                            'Antonio Quijarro' => 'Antonio Quijarro',
                            'Enrique Baldivieso' => 'Enrique Baldivieso',
                            'Charcas' => 'Charcas',
                            'Modesto Omiste' => 'Modesto Omiste',
                            'Aniceto Arce' => 'Aniceto Arce',
                            'Gran Chaco' => 'Gran Chaco',
                            'Méndez' => 'Méndez',
                            'Burnet O\'Oconnor' => 'Burnet O\'Oconnor',
                            'Cercado' => 'Cercado',
                            'Avilés' => 'Avilés',
                            'Guarayos' => 'Guarayos',
                            'Andrés Ibáñez' => 'Andrés Ibáñez',
                            'Cordillera' => 'Cordillera',
                            'Ichilo' => 'Ichilo',
                            'Germán Busch' => 'Germán Busch',
                            'Sara' => 'Sara',
                            'Manuel María Caballero' => 'Manuel María Caballero',
                            'Ñuflo de Chávez' => 'Ñuflo de Chávez',
                            'Obispo Santiestevan' => 'Obispo Santiestevan',
                            'Florida' => 'Florida',
                            'Vallegrande' => 'Vallegrande',
                            'Warnes' => 'Warnes',
                            'Chiquitos' => 'Chiquitos',
                            'Velasco' => 'Velasco',
                            'Angel Sandoval' => 'Angel Sandoval',
                            'Itenez' => 'Itenez',
                            'Yacuma' => 'Yacuma',
                            'Vaca Diez' => 'Vaca Diez',
                            'Marbán' => 'Marbán',
                            'Mamoré' => 'Mamoré',
                            'José Ballivián' => 'José Ballivián',
                            'Moxos' => 'Moxos',
                            'Cercado' => 'Cercado',
                            'Nicolás Suárez' => 'Nicolás Suárez',
                            'Madre de Dios' => 'Madre de Dios',
                            'Manuripi' => 'Manuripi',
                            'Abuná' => 'Abuná',
                            'Federico Román' => 'Federico Román',
                        ],
                        $national->PROVINCIA,
                        [
                            'class' => 'form-control' . ($errors->has('PROVINCIA') ? ' is-invalid' : ''),
                            'placeholder' => 'Provincia',
                            'id' => 'provincia-select',
                        ],
                    ) }}
                    {!! $errors->first('PROVINCIA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('DIRECCION O DOMICILIO') }}
                    {{ Form::text('DIRECCION', strtoupper($national->DIRECCION), ['class' => 'form-control' . ($errors->has('DIRECCION') ? ' is-invalid' : ''), 'style' => 'text-transform: uppercase;', 'placeholder' => 'Direccion del domicilio remitente']) }}
                    {!! $errors->first('DIRECCION', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('N° DE FACTURA') }}
                    {{ Form::number('FACTURA', $national->FACTURA, ['class' => 'form-control' . ($errors->has('FACTURA') ? ' is-invalid' : ''), 'placeholder' => 'Numero de Factura']) }}
                    {!! $errors->first('FACTURA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('IMPORTE (Bs.)') }}
                    {{ Form::number('IMPORTE', $national->IMPORTE, ['class' => 'form-control' . ($errors->has('IMPORTE') ? ' is-invalid' : ''), 'placeholder' => 'Importe expresado en Bs.']) }}
                    {!! $errors->first('IMPORTE', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h4>Datos del Destinatario</h4>
                <div class="form-group">
                    {{ Form::label('NOMBRES DEL DESTINATARIO') }}
                    {{ Form::text('NOMBRESDESTINATARIO', strtoupper($national->NOMBRESDESTINATARIO), ['class' => 'form-control' . ($errors->has('NOMBRESDESTINATARIO') ? ' is-invalid' : ''), 'placeholder' => 'Nombres y Apellido del Destinatario']) }}
                    {!! $errors->first('NOMBRESDESTINATARIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TELEFONO DEL DESTINATARIO') }}
                    {{ Form::number('TELEFONODESTINATARIO', $national->TELEFONODESTINATARIO, ['class' => 'form-control' . ($errors->has('TELEFONODESTINATARIO') ? ' is-invalid' : ''), 'placeholder' => 'Telefono del Destinatario']) }}
                    {!! $errors->first('TELEFONODESTINATARIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('C.I. DESTINATARIO') }}
                    {{ Form::number('CIDESTINATARIO', $national->CIDESTINATARIO, ['class' => 'form-control' . ($errors->has('CIDESTINATARIO') ? ' is-invalid' : ''), 'placeholder' => 'Celula de Identidad del Destinatario']) }}
                    {!! $errors->first('CIDESTINATARIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <h4>Datos del Remitente</h4>
                <div class="form-group">
                    {{ Form::label('NOMBRE Y APELLIDO DEL REMITENTE') }}
                    {{ Form::text('NOMBRESREMITENTE', strtoupper($national->NOMBRESREMITENTE), ['class' => 'form-control' . ($errors->has('NOMBRESREMITENTE') ? ' is-invalid' : ''), 'placeholder' => 'Nombre y Apellido del Remitente']) }}
                    {!! $errors->first('NOMBRESREMITENTE', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TELEFONO DEL REMITENTE') }}
                    {{ Form::number('TELEFONOREMITENTE', $national->TELEFONOREMITENTE, ['class' => 'form-control' . ($errors->has('TELEFONOREMITENTE') ? ' is-invalid' : ''), 'placeholder' => 'Telefono del Remitente']) }}
                    {!! $errors->first('TELEFONOREMITENTE', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('C.I. REMITENTE') }}
                    {{ Form::number('CIREMITENTE', $national->CIREMITENTE, ['class' => 'form-control' . ($errors->has('CIREMITENTE') ? ' is-invalid' : ''), 'placeholder' => 'Celula de Identidad del Remitente']) }}
                    {!! $errors->first('CIREMITENTE', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
        <div class="box-footer mt20">
            <div class="text-right">
                <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
            </div>
        </div>
    </div>
</div>
