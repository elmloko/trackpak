<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Package;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Client;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;

class EventController extends Controller
{
    // Lista de códigos de país y sus traducciones
    private $countryCodes = [
        'AF' => 'AFGHANISTAN',
        'AL' => 'ALBANIA',
        'DZ' => 'ALGERIA',
        'AS' => 'AMERICAN SAMOA',
        'AD' => 'ANDORRA',
        'AO' => 'ANGOLA',
        'AQ' => 'ANTARCTICA',
        'AG' => 'ANTIGUA AND BARBUDA',
        'AR' => 'ARGENTINA',
        'AM' => 'ARMENIA',
        'AW' => 'ARUBA',
        'AU' => 'AUSTRALIA',
        'AT' => 'AUSTRIA',
        'AZ' => 'AZERBAIJAN',
        'BS' => 'BAHAMAS',
        'BH' => 'BAHRAIN',
        'BD' => 'BANGLADESH',
        'BB' => 'BARBADOS',
        'BY' => 'BELARUS',
        'BE' => 'BELGIUM',
        'BZ' => 'BELIZE',
        'BJ' => 'BENIN',
        'BM' => 'BERMUDA',
        'BT' => 'BHUTAN',
        'BO' => 'BOLIVIA',
        'BA' => 'BOSNIA AND HERZEGOVINA',
        'BW' => 'BOTSWANA',
        'BV' => 'BOUVET ISLAND',
        'BR' => 'BRAZIL',
        'IO' => 'BRITISH INDIAN OCEAN TERRITORY',
        'BN' => 'BRUNEI DARUSSALAM',
        'BG' => 'BULGARIA',
        'BF' => 'BURKINA FASO',
        'BI' => 'BURUNDI',
        'KH' => 'CAMBODIA',
        'CM' => 'CAMEROON',
        'CA' => 'CANADA',
        'CV' => 'CAPE VERDE',
        'KY' => 'CAYMAN ISLANDS',
        'CF' => 'CENTRAL AFRICAN REPUBLIC',
        'TD' => 'CHAD',
        'CL' => 'CHILE',
        'CN' => 'CHINA',
        'CX' => 'CHRISTMAS ISLAND',
        'CC' => 'COCOS (KEELING) ISLANDS',
        'CO' => 'COLOMBIA',
        'KM' => 'COMOROS',
        'CG' => 'CONGO',
        'CD' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE',
        'CK' => 'COOK ISLANDS',
        'CR' => 'COSTA RICA',
        'CI' => "CÔTE D'IVOIRE",
        'HR' => 'CROATIA',
        'CU' => 'CUBA',
        'CY' => 'CYPRUS',
        'CZ' => 'CZECH REPUBLIC',
        'DK' => 'DENMARK',
        'DJ' => 'DJIBOUTI',
        'DM' => 'DOMINICA',
        'DO' => 'DOMINICAN REPUBLIC',
        'EC' => 'ECUADOR',
        'EG' => 'EGYPT',
        'SV' => 'EL SALVADOR',
        'GQ' => 'EQUATORIAL GUINEA',
        'ER' => 'ERITREA',
        'EE' => 'ESTONIA',
        'ET' => 'ETHIOPIA',
        'FK' => 'FALKLAND ISLANDS (MALVINAS)',
        'FO' => 'FAROE ISLANDS',
        'FJ' => 'FIJI',
        'FI' => 'FINLAND',
        'FR' => 'FRANCE',
        'GF' => 'FRENCH GUIANA',
        'PF' => 'FRENCH POLYNESIA',
        'TF' => 'FRENCH SOUTHERN TERRITORIES',
        'GA' => 'GABON',
        'GM' => 'GAMBIA',
        'GE' => 'GEORGIA',
        'DE' => 'GERMANY',
        'GH' => 'GHANA',
        'GI' => 'GIBRALTAR',
        'GR' => 'GREECE',
        'GL' => 'GREENLAND',
        'GD' => 'GRENADA',
        'GP' => 'GUADELOUPE',
        'GU' => 'GUAM',
        'GT' => 'GUATEMALA',
        'GN' => 'GUINEA',
        'GW' => 'GUINEA-BISSAU',
        'GY' => 'GUYANA',
        'HT' => 'HAITI',
        'HM' => 'HEARD ISLAND AND MCDONALD ISLANDS',
        'HN' => 'HONDURAS',
        'HK' => 'HONG KONG',
        'HU' => 'HUNGARY',
        'IS' => 'ICELAND',
        'IN' => 'INDIA',
        'ID' => 'INDONESIA',
        'IR' => 'IRAN, ISLAMIC REPUBLIC OF',
        'IQ' => 'IRAQ',
        'IE' => 'IRELAND',
        'IL' => 'ISRAEL',
        'IT' => 'ITALY',
        'JM' => 'JAMAICA',
        'JP' => 'JAPAN',
        'JO' => 'JORDAN',
        'KZ' => 'KAZAKHSTAN',
        'KE' => 'KENYA',
        'KI' => 'KIRIBATI',
        'KP' => 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF',
        'KR' => 'KOREA, REPUBLIC OF',
        'KW' => 'KUWAIT',
        'KG' => 'KYRGYZSTAN',
        'LA' => 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC',
        'LV' => 'LATVIA',
        'LB' => 'LEBANON',
        'LS' => 'LESOTHO',
        'LR' => 'LIBERIA',
        'LY' => 'LIBYAN ARAB JAMAHIRIYA',
        'LI' => 'LIECHTENSTEIN',
        'LT' => 'LITHUANIA',
        'LU' => 'LUXEMBOURG',
        'MO' => 'MACAO',
        'MK' => 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF',
        'MG' => 'MADAGASCAR',
        'MW' => 'MALAWI',
        'MY' => 'MALAYSIA',
        'MV' => 'MALDIVES',
        'ML' => 'MALI',
        'MT' => 'MALTA',
        'MH' => 'MARSHALL ISLANDS',
        'MQ' => 'MARTINIQUE',
        'MR' => 'MAURITANIA',
        'MU' => 'MAURITIUS',
        'YT' => 'MAYOTTE',
        'MX' => 'MEXICO',
        'FM' => 'MICRONESIA, FEDERATED STATES OF',
        'MD' => 'MOLDOVA, REPUBLIC OF',
        'MC' => 'MONACO',
        'MN' => 'MONGOLIA',
        'MS' => 'MONTSERRAT',
        'MA' => 'MOROCCO',
        'MZ' => 'MOZAMBIQUE',
        'MM' => 'MYANMAR',
        'NA' => 'NAMIBIA',
        'NR' => 'NAURU',
        'NP' => 'NEPAL',
        'NL' => 'NETHERLANDS',
        'AN' => 'NETHERLANDS ANTILLES',
        'NC' => 'NEW CALEDONIA',
        'NZ' => 'NEW ZEALAND',
        'NI' => 'NICARAGUA',
        'NE' => 'NIGER',
        'NG' => 'NIGERIA',
        'NU' => 'NIUE',
        'NF' => 'NORFOLK ISLAND',
        'MP' => 'NORTHERN MARIANA ISLANDS',
        'NO' => 'NORWAY',
        'OM' => 'OMAN',
        'PK' => 'PAKISTAN',
        'PW' => 'PALAU',
        'PS' => 'PALESTINIAN TERRITORY, OCCUPIED',
        'PA' => 'PANAMA',
        'PG' => 'PAPUA NEW GUINEA',
        'PY' => 'PARAGUAY',
        'PE' => 'PERU',
        'PH' => 'PHILIPPINES',
        'PN' => 'PITCAIRN',
        'PL' => 'POLAND',
        'PR' => 'PUERTO RICO',
        'QA' => 'QATAR',
        'RE' => 'RÉUNION',
        'RO' => 'ROMANIA',
        'RU' => 'RUSSIAN FEDERATION',
        'RW' => 'RWANDA',
        'SH' => 'SAINT HELENA',
        'KN' => 'SAINT KITTS AND NEVIS',
        'LC' => 'SAINT LUCIA',
        'PM' => 'SAINT PIERRE AND MIQUELON',
        'VC' => 'SAINT VINCENT AND THE GRENADINES',
        'WS' => 'SAMOA',
        'SM' => 'SAN MARINO',
        'ST' => 'SAO TOME AND PRINCIPE',
        'SA' => 'SAUDI ARABIA',
        'SN' => 'SENEGAL',
        'CS' => 'SERBIA AND MONTENEGRO',
        'SC' => 'SEYCHELLES',
        'SL' => 'SIERRA LEONE',
        'SG' => 'SINGAPORE',
        'SK' => 'SLOVAKIA',
        'SI' => 'SLOVENIA',
        'SB' => 'SOLOMON ISLANDS',
        'SO' => 'SOMALIA',
        'ZA' => 'SOUTH AFRICA',
        'GS' => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
        'ES' => 'SPAIN',
        'LK' => 'SRI LANKA',
        'SD' => 'SUDAN',
        'SR' => 'SURINAME',
        'SJ' => 'SVALBARD AND JAN MAYEN',
        'SZ' => 'SWAZILAND',
        'SE' => 'SWEDEN',
        'CH' => 'SWITZERLAND',
        'SY' => 'SYRIAN ARAB REPUBLIC',
        'TW' => 'TAIWAN, PROVINCE OF CHINA',
        'TJ' => 'TAJIKISTAN',
        'TZ' => 'TANZANIA, UNITED REPUBLIC OF',
        'TH' => 'THAILAND',
        'TL' => 'TIMOR-LESTE',
        'TG' => 'TOGO',
        'TK' => 'TOKELAU',
        'TO' => 'TONGA',
        'TT' => 'TRINIDAD AND TOBAGO',
        'TN' => 'TUNISIA',
        'TR' => 'TURKEY',
        'TM' => 'TURKMENISTAN',
        'TC' => 'TURKS AND CAICOS ISLANDS',
        'TV' => 'TUVALU',
        'UG' => 'UGANDA',
        'UA' => 'UKRAINE',
        'AE' => 'UNITED ARAB EMIRATES',
        'GB' => 'UNITED KINGDOM',
        'US' => 'UNITED STATES',
        'UM' => 'UNITED STATES MINOR OUTLYING ISLANDS',
        'UY' => 'URUGUAY',
        'UZ' => 'UZBEKISTAN',
        'VU' => 'VANUATU',
        'VE' => 'VENEZUELA',
        'VN' => 'VIET NAM',
        'VG' => 'VIRGIN ISLANDS, BRITISH',
        'VI' => 'VIRGIN ISLANDS, U.S.',
        'WF' => 'WALLIS AND FUTUNA',
        'EH' => 'WESTERN SAHARA',
        'YE' => 'YEMEN',
        'ZM' => 'ZAMBIA',
        'ZW' => 'ZIMBABWE',
    ];

    public function index()
    {
        $events = Event::paginate();

        return view('event.index', compact('events'))
            ->with('i', (request()->input('page', 1) - 1) * $events->perPage());
    }

    public function create()
    {
        $event = new Event();
        return view('event.create', compact('event'));
    }

    public function store(Request $request)
    {
        request()->validate(Event::$rules);

        $event = Event::create($request->all());

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show($id)
    {
        $event = Event::find($id);

        return view('event.show', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::find($id);

        return view('event.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        request()->validate(Event::$rules);

        $event->update($request->all());

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully');
    }

    public function destroy($id)
    {
        $event = Event::find($id)->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully');
    }

    public function search(Request $request)
    {
        $request->validate([
            'codigo' => 'required|size:13',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        $codigo = $request->input('codigo');

        if (empty($codigo)) {
            return redirect()->back()->withErrors(['codigo' => 'El campo código no puede estar vacío.']);
        }

        $lastTwoChars = substr($codigo, -2);
        $country = $this->countryCodes[$lastTwoChars] ?? 'Unknown Country';

        $packages = Package::where('CODIGO', $codigo)
            ->take(5)
            ->withTrashed()
            ->get();

        $event = Event::where('codigo', $codigo)
            ->where('action', '!=', 'ESTADO')
            ->orderBy('created_at', 'desc')
            ->get();

        // $client = new Client(['base_uri' => 'http://172.65.10.37/']);
        // $response = $client->post('api/Autenticacion/Validar', [
        //     'json' => [
        //         'correo' => 'Correos',
        //         'clave' => 'AGBClp2020'
        //     ]
        // ]);
        // $body = json_decode($response->getBody());
        // $token = $body->token;

        // $response = $client->post('api/O_MAIL_OBJECTS/buscar', [
        //     'headers' => [
        //         'Authorization' => 'Bearer ' . $token,
        //         'Accept' => 'application/json',
        //     ],
        //     'json' => [
        //         'id' => $codigo
        //     ]
        // ]);

        // $results = json_decode($response->getBody());

        // // Mapear los eventos
        // foreach ($results as $result) {
        //     $result->eventType = $this->mapEventType($result->eventType);
        // }

        // usort($results, function ($a, $b) {
        //     return strtotime($b->eventDate) - strtotime($a->eventDate);
        // });

        return view('search', compact('results', 'packages', 'event', 'codigo', 'country'));
    }

    private function mapEventType($eventType)
    {
        $eventMappings = [
            "Recibir envío del cliente (salida)" => "Paquete recibido del cliente.",
            "Enviar envío a ubicación nacional (salida)" => "Paquete en camino a ubicación nacional.",
            "Recibir envío en oficina de cambio (salida)" => "Paquete recibido en oficina de tránsito.",
            "Enviar envío a aduana (salida)" => "Paquete enviado a aduana.",
            "Recibir envío en ubicación (salida)" => "Paquete recibido en centro de procesamiento.",
            "Registrar motivo de retención de envío por parte de aduana (Sal)" => "Paquete retenido en aduana.",
            "Devolver envío desde aduana (salida)" => "Paquete en devolución desde la aduana.",
            "Insertar envío en saca (salida)" => "Paquete incluido en la saca de envío.",
            "Eliminar envío de saca (salida)" => "Paquete eliminado del la saca de envío.",
            "Registrar detalles del envío (salida)" => "Detalles del paquete registrados.",
            "Registrar detalles del envío en oficina de cambio (salida)" => "Detalles del paquete registrados en oficina de tránsito.",
            "Enviar envío al extranjero (recibido por EDI)" => "Paquete enviado al extranjero.",
            "Insertar envío en saca nacional" => "Paquete incluido en la saca nacional.",
            "Eliminar envío de saca nacional" => "Paquete eliminado de la saca nacional.",
            "Cancelar exportación de envío" => "Exportación del paquete cancelada.",
            "Recibir envío en oficina de cambio (entrada)" => "Paquete recibido en oficina de tránsito.",
            "Enviar envío a aduana (entrada)" => "Paquete en camino a aduana.",
            "Recibir envío en oficina de entrega (entrada)" => "Paquete recibido en oficina de entrega(Listo para entregar).",
            "Recibir envío en ubicación (entrada)" => "Paquete recibido en ubicación específica.",
            "Registrar información de aduanas sobre el envío (entrada)" => "Información de aduana del paquete registrada.",
            "Enviar envío a ubicación nacional (entrada)" => "Paquete en camino a ubicación nacional.",
            "Intento fallido de entrega de envío (entrada)" => "Intento fallido de entrega del paquete.",
            "Entregar envío (entrada)" => "Paquete entregado exitosamente.",
            "Devolver envío desde aduana (entrada)" => "Paquete en devolución desde aduana.",
            "Transferir envío al agente de entrega (entrada)" => "Paquete transferido al agente de entrega.",
            "Recibir envío desde el extranjero (recibido por EDI)" => "Paquete recibido desde el extranjero.",
            "Registrar información del destinatario (entrada)" => "Información del destinatario del paquete registrada.",
            "Recibir envío en oficina de cambio (entrada-int.-recon.)" => "Paquete recibido en oficina de tránsito internacional.",
            "Recibir envío en oficina de cambio (entrada-nac.-recon.)" => "Paquete recibido en oficina de tránsito nacional.",
            "Recepción automatizada de envío en oficina de cambio (entrada)" => "Paquete recibido automáticamente en oficina de tránsito.",
            "Creación automática de envío faltante (entrada)" => "Paquete creado automáticamente.",
            "Actualizar envío (salida)" => "Paquete actualizado",
            "Actualizar envío (entrada)" => "Paquete actualizado",
            "Rectificar acontecimiento de PSD de envío (salida)" => "Corrección de datos del paquete",
            "Rectificar acontecimiento de PSD de envío (entrada)" => "Corrección de datos del paquete",
            "Envío de manifiesto enviado a ubicación (entrada)" => "Saca registrado en ubicación.",
            "Envío de manifiesto enviado a aduana (entrada)" => "Saca enviado a aduana para revisión.",
            "Envío de manifiesto recibido en ubicación (entrada)" => "Saca recibido en ubicación.",
            "Envío de manifiesto transferido a agente de entrega (entrada)" => "Saca transferido al agente de entrega.",
            "Recepción automática de envío: sin digitalización" => "Paquete recibido automáticamente: pendiente de digitalización.",
            "Retener envío en oficina de cambio (salida)" => "Paquete retenido en oficina de tránsitos.",
            "Retener envío en oficina de cambio (entrada)" => "Paquete retenido en oficina de tránsito.",
            "Recibir envío en centro de clasificación (entrada)" => "Paquete recibido en centro de clasificación.",
            "Enviar envío desde centro de clasificación (entrada)" => "Paquete procesado en centro de clasificación.",
            "Retener envío en punto de entrega (entrada)" => "Paquete retenido en punto de entrega.",
            "Enviar envío para entrega física (entrada)" => "Paquete en camino para entrega física.",
            "Recibir envío en punto de recogida (entrada)" => "Paquete recibido en punto de recogida.",
            "Detener importación de envío (entrada)" => "Importación del paquete detenida.",
            "Envío insertado en un envase externo (salida)" => "Paquete incluido en una saca externo.",
            "Recoger el artículo del cliente (Otb)" => "Paquete recogido por el cliente.",
            "Registrar detalles del envío (entrada)" => "Detalles del paquete registrados.",
            "Artículo eliminado de contenedor externo (Otb)" => "Paquete eliminado del contenedor externo.",
            "Detener envío al remitente" => "Retorno del paquete al remitente detenido.",
            "Crear envase (salida)" => "Contenedor del paquete creado.",
            "Cerrar envase (salida)" => "Contenedor del paquete cerrado.",
            "Reabrir envase (salida)" => "Contenedor del paquete reabierto.",
            "Enviar envase a ubicación nacional (salida)" => "Contenedor del paquete enviado a ubicación nacional.",
            "Recibir envase desde oficina (salida)" => "Contenedor del paquete recibido desde oficina postal.",
            "Cambiar embarque del envase (salida)" => "Transporte del contenedor del paquete modificado.",
            "Enviar envase al extranjero (salida)" => "Contenedor del paquete enviado al extranjero.",
            "Enviar envase al extranjero (recibido por PREDES EDI)" => "Contenedor del paquete enviado al extranjero (confirmado electrónicamente).",
            "Enviar envase al extranjero (recibido por PRECON EDI)" => "Contenedor del paquete enviado al extranjero (confirmado electrónicamente).",
            "Recibir envase desde el extranjero (entrada)" => "Contenedor del paquete recibido desde el extranjero.",
            "Abrir envase (entrada)" => "Contenedor del paquete abierto en destino.",
            "Enviar envase a ubicación nacional (entrada)" => "Contenedor del paquete enviado a ubicación nacional.",
            "Recibir envase en ubicación nacional (entrada)" => "Contenedor del paquete recibido en ubicación nacional.",
            "Recibir envase desde el extranjero (recibido por RESDES EDI)" => "Contenedor del paquete recibido desde el extranjero.",
            "Recibir envase desde el extranjero (recibido por RESCON EDI)" => "Contenedor del paquete recibido desde el extranjero.",
            "Digitalización de envase no finalizada" => "Digitalización del contenedor del paquete incompleta.",
            "Digitalización de envase finalizada" => "Digitalización del contenedor del paquete finalizada.",
            "Marcar envase como eliminado" => "Contenedor del paquete marcado como eliminado.",
            "Tratar envase en el transportista (recibido por EDI)" => "Contenedor del paquete gestionado por transportista.",
            "Actualizar envase (salida)" => "Contenedor del paquete actualizado (salida).",
            "Actualizar envase (entrada)" => "Contenedor del paquete actualizado (entrada).",
            "Rectificar acontecimiento de PSD del envase (salida)" => "Corrección de datos del contenedor del paquete (salida).",
            "Rectificar acontecimiento de PSD del envase (entrada)" => "Corrección de datos del contenedor del paquete (entrada).",
            "Rectificar acontecimiento de PSD del envase (entrada)" => "Corrección de datos del contenedor (entrada).",
            "Envase de manifiesto recibido (entrada)" => "Manifiesto del contenedor recibido.",
            "Envase de manifiesto enviado (entrada)" => "Manifiesto del contenedor enviado.",
            "RESDIT aceptado (creación)" => "Solicitud RESDIT aceptada.",
            "Cambiar contenedor de envase (salida)" => "Contenedor cambiado.",
            "Cambiar embarque nacional" => "Cambio en embarque nacional.",
            "Envase evaluado para muestreo" => "Contenedor evaluado para muestreo.",
            "Recibir envase de trasbordo directo desde el extranjero (Ent)" => "Contenedor recibido desde trasbordo directo extranjero.",
            "Marcar como transportado fuera de un embarque" => "Marcado como transportado fuera de embarque.",
            "Envase pesado desde la báscula" => "Contenedor pesado en báscula.",
            "Envase seleccionado para muestreo" => "Contenedor seleccionado para muestreo.",
            "Comprobación por rayos X" => "Inspección por rayos X realizada.",
            "Crear despacho (salida)" => "Despacho creado (salida).",
            "Cerrar despacho (salida)" => "Despacho cerrado (salida).",
            "Reabrir despacho (salida)" => "Despacho reabierto (salida).",
            "Cambiar embarque del despacho (salida)" => "Cambio en embarque del despacho (salida).",
            "Enviar despacho al extranjero (recibido por EDI)" => "Despacho enviado al extranjero (confirmado electrónicamente).",
            "Recibir despacho desde el extranjero (recibido por EDI)" => "Despacho recibido desde el extranjero.",
            "Marcar despacho como eliminado" => "Despacho marcado como eliminado.",
            "Actualizar despacho (salida)" => "Despacho actualizado (salida).",
            "Actualizar despacho (entrada)" => "Despacho actualizado (entrada).",
            "Crear embarque (salida)" => "Embarque creado (salida).",
            "Cerrar embarque (salida)" => "Embarque cerrado (salida).",
            "Reabrir embarque (salida)" => "Embarque reabierto (salida).",
            "Enviar embarque al extranjero (recibido por EDI)" => "Embarque enviado al extranjero (confirmado electrónicamente).",
            "Recibir embarque desde el extranjero (recibido por EDI)" => "Embarque recibido desde el extranjero.",
            "Tratar embarque en el transportista (recibido por EDI)" => "Embarque gestionado por transportista.",
            "Actualizar embarque (salida)" => "Embarque actualizado (salida).",
            "Marcar emb como eliminado" => "Embarque marcado como eliminado.",
            "Actualizar embarque (entrada)" => "Embarque actualizado (entrada).",
            "Crear saca interna (salida)" => "Saca interna creada (salida).",
            "Cerrar saca interna (salida)" => "Saca interna cerrada (salida).",
            "Agregar saca interna al envase (salida)" => "Saca interna añadida al contenedor (salida).",
            "Eliminar saca interna de envase (salida)" => "Saca interna eliminada del contenedor (salida).",
            "Reabrir saca interna (salida)" => "Saca interna reabierta (salida).",
            "Recibir saca interna (entrada)" => "Saca interna recibida (entrada).",
            "Abrir saca interna (entrada)" => "Saca interna abierta (entrada).",
            "Marcar saca interna como eliminada" => "Saca interna marcada como eliminada.",
            "Crear BV propio" => "BV propio creado.",
            "Enviar BV a corresponsal" => "BV enviado al corresponsal.",
            "Recibir BV aceptado por corresponsal" => "BV aceptado por corresponsal.",
            "Recibir BV anotado por corresponsal" => "BV anotado por corresponsal recibido.",
            "Actualizar BV propio" => "BV propio actualizado.",
            "Recibir BV de corresponsal" => "BV recibido del corresponsal.",
            "Aceptar BV" => "BV aceptado.",
            "Anotar BV" => "BV anotado.",
            "Actualizar BV recibido" => "BV recibido actualizado.",
            "Aceptar BV electrónico recibido" => "BV electrónico aceptado.",
            "Importado de XML" => "Datos importados desde XML.",
            "Marcar BV como eliminado" => "BV marcado como eliminado.",
            "Crear envase nacional" => "Saca nacional creado.",
            "Cerrar envase nacional" => "Saca nacional cerrado.",
            "Reabrir envase nacional" => "Saca nacional reabierto.",
            "Enviar envase nacional a ubicación" => "Saca nacional enviado a ubicación.",
            "Recibir envase nacional en ubicación" => "Saca nacional recibido en ubicación.",
            "Cambiar embarque nacional" => "Cambio en embarque nacional.",
            "Crear despacho nacional" => "Saca nacional creado.",
            "Cerrar despacho nacional" => "Saca nacional cerrado.",
            "Reabrir despacho nacional" => "Saca nacional reabierto.",
            "Marcar despacho nacional como eliminado" => "Saca nacional marcado como eliminado.",
            "Crear embarque nacional" => "Expedición nacional creado.",
            "Cerrar embarque nacional" => "Expedición nacional cerrado.",
            "Reabrir embarque nacional" => "Expedición nacional reabierto.",
            "Marcar emb como eliminado" => "Expedición nacional marcado como eliminado.",
            "Recibido por EDI" => "Paquete: datos recibidos por EDI.",
            "Crear/actualizar contenedor" => "Saca creada o actualizada.",
            "Recibir contenedor (entrada)" => "Saca recibida.",
            "Abrir contenedor (entrada)" => "Saca abierta.",
            "Digitalizar para transporte" => "Paquete: datos digitalizados para transporte.",
            "Creación/actualización automática a partir de proceso de salida" => "Paquete: creado o actualizado automáticamente desde proceso de salida.",
            "Creación/actualización desde especificación de documento" => "Paquete: creado o actualizado desde especificación de documento.",
            "Modificar por BV" => "Modificado según BV.",
            "Marcar como eliminado" => "Paquete: marcado como eliminado.",
            "Documento de cuenta con formulario oficial" => "Paquete: documento oficial registrado.",
            "Modificación administrativa por especificación de documento" => "Paquete: modificado administrativamente según documento.",
            "Creación/actualización automática desde PREDES" => "Paquete: creado o actualizado automáticamente desde PREDES.",
            "Creación automática a partir de estimación" => "Paquete: creado automáticamente desde estimación.",
            "Modificación administrativa por BV" => "Paquete: modificado administrativamente por BV.",
            "Explicable: no formado" => "Paquete: registro no formado.",
            "Validar documento" => "Paquete: documento validado.",
            "Invalidar documento" => "Paquete: documento invalidado.",
            "Modificar identificador" => "Paquete: identificador modificado.",
            "Creación automática de PREDES no validados" => "PREDES no validado creado automáticamente.",
            "Crear declaración" => "Declaración creada.",
            "Enviar declaración" => "Declaración enviada.",
            "Reconocer declaración" => "Declaración reconocida.",
            "Pago recibido" => "Paquete: pago recibido.",
            "Marcar declaración como eliminada" => "Declaración marcada como eliminada.",
            "Actualizar declaración" => "Declaración actualizada."
        ];
        return $eventMappings[$eventType] ?? $eventType;
    }

    public function eventspdf()
    {
        $events = Event::orderByDesc('created_at')->get();
        $pdf = PDF::loadview('event.pdf.eventspdf', ['events' => $events]);
        return $pdf->stream();
    }
}
