<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Event;
use App\Exports\ReencaminarExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Picqer;

class PackageController extends Controller
{
    public function index()
    {
        // Obtener la regional del usuario actual (puedes ajustar esto según tu lógica de autenticación)
        $userCuidad = auth()->user()->Regional;

        // Filtrar los paquetes por la regional del usuario
        $packages = Package::where('CUIDAD', $userCuidad)->paginate(20);

        return view('package.index', compact('packages'))
            ->with('i', (request()->input('page', 1) - 1) * $packages->perPage());
    }

    public function create()
    {
        // Crear una instancia de Package
        $package = new Package();

        return view('package.create', compact('package'));
    }

    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            // 'CODIGO' => 'required|string|max:20',
            'DESTINATARIO' => 'required|string|max:255',
            'TELEFONO' => 'required|numeric|regex:/^[0-9]+$/',
            'CUIDAD' => 'required',
            'VENTANILLA' => 'required|in:DND,DD,ECA,CASILLAS,UNICA,ENCOMIENDAS',
            // 'ZONA' => 'required_if:VENTANILLA,DD,ECA,CASILLAS|string|max:255',
            'PESO' => 'required|numeric|regex:/^\d+(\.\d{1,3})?$/|between:0.001,10.000',
            'TIPO' => 'required|string',
            'ADUANA' => 'required|string',
            'foto' => 'nullable|string',
            // 'nrocasilla' => 'required|numeric|regex:/^[0-9]+$/',
        ]);

        // Obtener el nombre de usuario del cartero actualmente autenticado
        $userCartero = auth()->user()->name;

        // Agregar el nombre del cartero al request antes de crear el paquete
        $request->merge(['usercartero' => $userCartero]);

        // Calcular el precio basado en el peso
        $peso = $request->input('PESO');
        $precio = 0;

        if ($peso >= 0.001 && $peso <= 0.5) {
            $precio = 5;
        } elseif ($peso > 0.5) {
            $precio = 10;
        } // Puedes agregar más condiciones según tus requerimientos

        // Agregar el precio al request antes de crear el paquete
        $request->merge(['PRECIO' => $precio]);

        // Crear el paquete
        $package = Package::create($request->all());

        // Extraer el ISO del país y traducción del código del país
        $iso = substr($request->input('CODIGO'), -2); // Obtener las dos últimas letras
        $countryTranslation = $this->getCountryTranslation($iso);

        // Actualizar el paquete con el ISO del país y la traducción del código del país
        $package->update([
            'PAIS' => $iso,
            'ISO' => $countryTranslation,
        ]);

        // Crear eventos relacionados con el paquete
        Event::create([
            'action' => 'CLASIFICACION',
            'descripcion' => 'Clasificación del Paquete en Oficina Postal Regional',
            'user_id' => auth()->user()->id,
            'codigo' => $package->CODIGO,
        ]);

        Event::create([
            'action' => 'ADMISION',
            'descripcion' => 'Llegada de Paquete en Oficina Postal Regional',
            'user_id' => auth()->user()->id,
            'codigo' => $package->CODIGO,
        ]);

        // Redireccionar con mensaje de éxito
        return redirect()->route('packages.clasificacion')
            ->with('success', 'Paquete Creado Con Éxito!');
    }

    // Función para obtener la traducción del código del país
    private function getCountryTranslation($iso)
    {
        // Aquí puedes implementar la lógica para traducir el código del país, por ejemplo, usando un array asociativo
        $translations = [
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
            // Agrega más traducciones según sea necesario
        ];

        // Devolver la traducción o el mismo ISO si no se encuentra la traducción
        return isset($translations[$iso]) ? $translations[$iso] : $iso;
    }

    public function show($id)
    {
        $package = Package::find($id);

        return view('package.show', compact('package'));
    }

    public function edit($id)
    {
        $package = Package::find($id);
        return view('package.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'DESTINATARIO' => 'nullable|string|max:255',
            'TELEFONO' => 'nullable|integer|max:99999999999',
            'PAIS' => 'nullable|string|max:255',
            'CUIDAD' => 'nullable|string|max:255',
            'ZONA' => 'nullable|string|max:255',
            'VENTANILLA' => 'nullable|string|max:255',
            'PESO' => 'nullable|string|max:50',
            'TIPO' => 'nullable|string|max:255',
            'ADUANA' => 'nullable|string|max:255',
            'ESTADO' => 'nullable|string|max:255',
            'ISO' => 'nullable|string',
            'PRECIO' => 'nullable|string',
            'OBSERVACIONES' => 'nullable|string|max:255',
            'FACTURA' => 'nullable|integer|max:99999999999',
            'datedespachoclasificacion' => 'nullable|date',
            'date_redirigido' => 'nullable|date',
            'redirigido' => 'nullable|boolean',
            'cuidadre' => 'nullable|string',
            'REENCAMINAR' => 'nullable|string',
            'usercartero' => 'nullable|string',
            'dateprerezago' => 'nullable|date',
            'daterezago' => 'nullable|date',
            'nrocasilla' => 'nullable|integer|max:99999999999',
        ]);

        $package->update($request->all());

        Event::create([
            'action' => 'ESTADO',
            'descripcion' => 'Edición de Paquete',
            'user_id' => auth()->user()->id,
            'codigo' => $package->CODIGO,
        ]);

        return redirect()->route('packages.index')
            ->with('success', 'Paquete Actualizado Con Éxito!');
    }

    public function dirigido($id)
    {
        $package = Package::find($id);

        if ($package) {
            // Cambia el estado del paquete a "redirigido"
            $package->redirigido = false;

            Event::create([
                'action' => 'PRE-ENTREGA',
                'descripcion' => 'Paquete encaminado con exito a Oficina Postal Regional',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);

            $package->estado = 'VENTANILLA';

            // Obtén la fecha y hora actual y guárdala en el campo 'fecha_hora_redirigido'
            $package->date_redirigido = now();

            // Guarda el paquete actualizado
            $package->save();

            return back()->with('success', 'Paquete se dio de Redirigio con exito y cambió su estado a VENTANILLA con éxito.');
        } else {
            return back()->with('error', 'No se pudo encontrar el paquete para redirigir.');
        }
    }

    public function buscarPaquete(Request $request)
    {
        $codigo = $request->input('codigo');
        $zona = $request->input('zona');
        $package = Package::where('CODIGO', $codigo)->first();

        if (!$package) {
            return redirect()->back()->with('error', 'No se pudo encontrar el paquete.');
        }

        // Verificar que el estado del paquete sea 'DESPACHO' o 'RETORNO'
        if (!in_array($package->ESTADO, ['DESPACHO', 'RETORNO'])) {
            return redirect()->back()->with('error', 'El paquete no está en un estado válido para ser movido a ventanilla.');
        }

        // Verificar que el destino sea igual a la regional del usuario
        if (auth()->user()->Regional !== $package->CUIDAD) {
            return redirect()->back()->with('error', 'El paquete no está destinado a la regional del usuario.');
        }

        // Si el estado es 'DESPACHO', generar eventos
        if ($package->ESTADO === 'DESPACHO') {
            Event::create([
                'action' => 'DISPONIBLE',
                'descripcion' => 'Paquete a la espera de ser recogido en ventanilla ' . $package->VENTANILLA,
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            Event::create([
                'action' => 'EN ENTREGA',
                'descripcion' => 'Paquete Recibido en Oficina Postal Regional ' . $package->CUIDAD,
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
        }

        // Cambiar el estado del paquete a 'VENTANILLA'
        $package->ZONA = $zona;
        $package->ESTADO = 'VENTANILLA';
        $package->save();

        return redirect()->back()->with('success', 'Paquete se movió a Ventanilla con éxito y cambió su estado a VENTANILLA con éxito.');
    }

    public function buscarPaqueteunica(Request $request)
    {
        $codigo = $request->input('codigo');
        $zona = $request->input('zona');
        $package = Package::where('CODIGO', $codigo)->first();

        if (!$package) {
            return redirect()->back()->with('error', 'No se pudo encontrar el paquete.');
        }

        // Verificar que el estado del paquete sea 'DESPACHO' o 'RETORNO'
        if (!in_array($package->ESTADO, ['DESPACHO', 'RETORNO'])) {
            return redirect()->back()->with('error', 'El paquete no está en un estado válido para ser recibido.');
        }

        // Verificar que el destino sea igual a la regional del usuario
        if (auth()->user()->Regional !== $package->CUIDAD) {
            return redirect()->back()->with('error', 'El paquete no está destinado a la regional del usuario.');
        }

        // Si el estado es 'DESPACHO', generar eventos
        if ($package->ESTADO === 'DESPACHO') {
            Event::create([
                'action' => 'DISPONIBLE',
                'descripcion' => 'Paquete a la espera de ser recogido en ventanilla ' . $package->VENTANILLA,
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            Event::create([
                'action' => 'EN ENTREGA',
                'descripcion' => 'Paquete Recibido en Oficina Postal Regional ' . $package->CUIDAD,
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
        }

        // Cambiar el estado del paquete a 'RECIBIDO'
        $package->ZONA = $zona;
        $package->ESTADO = 'RECIBIDO';
        $package->save();

        return redirect()->back()->with('success', 'Paquete se recibió con éxito y cambió su estado a RECIBIDO con éxito.');
    }

    public function buscarPaquetecasilla(Request $request)
    {
        $codigo = $request->input('codigo');
        $zona = $request->input('zona');

        // Buscar el paquete con los criterios de código, estado 'DESPACHO', y ventanilla 'CASILLAS'
        $package = Package::where('CODIGO', $codigo)
            ->where('ESTADO', 'DESPACHO')
            ->where('VENTANILLA', 'CASILLAS')
            ->first();

        if (!$package) {
            return redirect()->back()->with('error', 'No se pudo encontrar el paquete con estado DESPACHO y ventanilla CASILLAS.');
        }

        // Verificar que la regional del usuario coincide con la regional del paquete
        if (auth()->user()->Regional !== $package->CUIDAD) {
            return redirect()->back()->with('error', 'El paquete no está destinado a la regional del usuario.');
        }

        // Crear eventos si el estado es 'DESPACHO'
        Event::create([
            'action' => 'DISPONIBLE',
            'descripcion' => 'Paquete a la espera de ser recogido en Casillero Postal ' . $package->nrocasilla,
            'user_id' => auth()->user()->id,
            'codigo' => $package->CODIGO,
        ]);
        Event::create([
            'action' => 'EN ENTREGA',
            'descripcion' => 'Paquete Recibido en Oficina Postal Regional ' . $package->CUIDAD,
            'user_id' => auth()->user()->id,
            'codigo' => $package->CODIGO,
        ]);

        // Cambiar el estado del paquete a 'VENTANILLA'
        $package->ZONA = $zona;
        $package->ESTADO = 'VENTANILLA';
        $package->save();

        return redirect()->back()->with('success', 'Paquete se movió a Ventanilla con éxito y cambió su estado a VENTANILLA con éxito.');
    }

    public function buscarPaqueteeca(Request $request)
    {
        $codigo = $request->input('codigo');
        $zona = $request->input('zona');

        // Buscar el paquete con los criterios de código, estado 'DESPACHO', y ventanilla 'ECA'
        $package = Package::where('CODIGO', $codigo)
            ->where('ESTADO', 'DESPACHO')
            ->where('VENTANILLA', 'ECA')
            ->first();

        if (!$package) {
            return redirect()->back()->with('error', 'No se pudo encontrar el paquete con estado DESPACHO y ventanilla ECA.');
        }

        // Verificar que la regional del usuario coincide con la regional del paquete
        if (auth()->user()->Regional !== $package->CUIDAD) {
            return redirect()->back()->with('error', 'El paquete no está destinado a la regional del usuario.');
        }

        // Crear eventos si el estado es 'DESPACHO'
        Event::create([
            'action' => 'DISPONIBLE',
            'descripcion' => 'Paquete a la espera de ser recogido en Casillero Postal ' . $package->nrocasilla,
            'user_id' => auth()->user()->id,
            'codigo' => $package->CODIGO,
        ]);
        Event::create([
            'action' => 'EN ENTREGA',
            'descripcion' => 'Paquete Recibido en Oficina Postal Regional ' . $package->CUIDAD,
            'user_id' => auth()->user()->id,
            'codigo' => $package->CODIGO,
        ]);

        // Cambiar el estado del paquete a 'VENTANILLA'
        $package->ZONA = $zona;
        $package->ESTADO = 'VENTANILLA';
        $package->save();

        return redirect()->back()->with('success', 'Paquete se movió a Ventanilla con éxito y cambió su estado a VENTANILLA con éxito.');
    }

    //VISTAS 
    public function clasificacion()
    {
        return view('package.clasificacion');
    }
    public function entregasclasificacion()
    {
        return view('package.entregasclasificacion');
    }
    public function redirigidos()
    {
        return view('package.redirigidos');
    }
    public function ventanilla()
    {
        return view('package.ventanilla');
    }
    public function ventanilladnd()
    {
        return view('package.ventanilladnd');
    }
    public function ventanillaunica()
    {
        return view('package.ventanillaunica');
    }
    public function ventanillaunicarecibir()
    {
        return view('package.ventanillaunicarecibir');
    }
    public function ventanilladdrecibir()
    {
        return view('package.ventanilladdrecibir');
    }
    public function deleteado()
    {
        return view('package.deleteado');
    }
    public function deleteadodnd()
    {
        return view('package.deleteadodnd');
    }
    public function deleteadounica()
    {
        return view('package.deleteadounica');
    }
    public function carteros()
    {
        return view('package.carteros');
    }
    public function carterosgeneral()
    {
        return view('package.carterosgeneral');
    }
    public function inventariocartero()
    {
        return view('package.inventariocartero');
    }
    public function distribuicioncartero()
    {
        return view('package.distribuicioncartero');
    }
    public function rezago()
    {
        return view('package.rezago');
    }
    public function prerezago()
    {
        return view('package.prerezago');
    }
    public function generalcartero()
    {
        return view('package.generalcartero');
    }
    public function despachocartero()
    {
        return view('package.despachocartero');
    }
    public function despachocarterogeneral()
    {
        return view('package.despachocarterogeneral');
    }
    public function casillas()
    {
        return view('package.casillas');
    }
    public function casillasinventario()
    {
        return view('package.casillasinventario');
    }
    public function eca()
    {
        return view('package.eca');
    }
    public function ecainventario()
    {
        return view('package.ecainventario');
    }
    public function encomiendas()
    {
        return view('package.ventanillaencomiendas');
    }
    public function encomiendasinventario()
    {
        return view('package.encomiendasinventario');
    }

    public function packagesallpdf(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $query = Package::query();

        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        }

        $packages = $query->get();
        $pdf = PDF::loadview('package.pdf.packagesall', ['packages' => $packages]);
        return $pdf->download('Almacen.pdf');
    }
    public function clasificacionpdf(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $ciudad = $request->input('ciudad');
        $ventanilla = $request->input('ventanilla');

        $query = Package::where('ESTADO', 'DESPACHO')
            ->where('CUIDAD', $ciudad)
            ->where('VENTANILLA', $ventanilla);

        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('datedespachoclasificacion', [$fechaInicio, $fechaFin]);
        }

        $packages = $query->get();
        $pdf = PDF::loadview('package.pdf.clasificacionpdf', ['packages' => $packages]);
        return $pdf->download('Clasificacion.pdf');
    }

    public function redirigidospdf(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $ciudad = $request->input('ciudad');

        $query = Package::where('ESTADO', 'REENCAMINADO');

        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('date_redirigido', [$fechaInicio, $fechaFin]);
        }

        if ($ciudad) {
            $query->where('CUIDAD', $ciudad);
        }

        $packages = $query->get();
        $pdf = PDF::loadview('package.pdf.redirigidospdf', ['packages' => $packages]);
        return $pdf->download('Reencaminado.pdf');
    }
    public function ventanillapdf(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $ventanilla = $request->input('ventanilla');
        $regional = auth()->user()->Regional;

        $query = Package::where('ESTADO', 'VENTANILLA');

        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('updated_at', [$fechaInicio, $fechaFin]);
        }

        // Añade la condición de la ventanilla según la regional
        if ($regional == 'LA PAZ') {
            $query->whereIn('VENTANILLA', ['DD', 'DND', 'CASILLAS', 'ECA']);
        } else {
            $query->where('VENTANILLA', 'UNICA');
        }

        $packages = $query->get();

        $pdf = PDF::loadView('package.pdf.ventanillapdf', ['packages' => $packages]);
        return $pdf->download('Ventanilla.pdf');
    }
    public function deleteadopdf(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $query = Package::withTrashed()->where('ESTADO', 'ENTREGADO');

        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('deleted_at', [$fechaInicio, $fechaFin]);
        }

        $packages = $query->get();
        $pdf = PDF::loadView('package.pdf.deleteadopdf', ['packages' => $packages]);
        return $pdf->download('Entregados.pdf');
    }
    public function formularioentrega(Request $request, $id)
    {
        $package = Package::find($id);
        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        $code = $generator->getBarcode($package->CODIGO, $generator::TYPE_CODE_128);
        $pdf = PDF::loadView('package.pdf.formularioentrega', compact('package', 'request'));
        $pdf->setPaper(9.5, 24);
        return $pdf->stream();
    }
    public function formularioentrega2(Request $request, $id)
    {
        $package = Package::find($id);
        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        $code = $generator->getBarcode($package->CODIGO, $generator::TYPE_CODE_128);
        $pdf = PDF::loadView('package.pdf.formularioentrega2', compact('package', 'request'));
        $pdf->setPaper(9.5, 24);
        return $pdf->stream();
    }
    public function carteropdf()
    {
        $packages = Package::where('ESTADO', 'CARTERO')->get();
        $pdf = PDF::loadview('package.pdf.carteropdf', ['packages' => $packages]);
        return $pdf->stream();
    }
    public function deleteadocarteropdf(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $usuarioActual = auth()->user()->name;

        $query = Package::withTrashed()
            ->where('ESTADO', 'REPARTIDO')
            ->where('usercartero', '=', trim($usuarioActual));

        if ($fechaInicio && $fechaFin) {
            // Assuming 'deleted_at' is a timestamp field
            $query->whereBetween('deleted_at', [$fechaInicio, $fechaFin]);
        }

        // Fetch the records
        $packages = $query->get();

        // Generate and return PDF
        $pdf = PDF::loadView('package.pdf.deleteadocarteropdf', ['packages' => $packages]);
        return $pdf->download('Entregados Cartero.pdf');
    }
    public function deleteadogeneralcarteropdf(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $query = Package::withTrashed()
            ->where('ESTADO', 'REPARTIDO');

        if ($fechaInicio && $fechaFin) {
            // Assuming 'deleted_at' is a timestamp field
            $query->whereBetween('deleted_at', [$fechaInicio, $fechaFin]);
        }

        // Fetch the records
        $packages = $query->get();

        // Generate and return PDF
        $pdf = PDF::loadView('package.pdf.deleteadogeneralcarteropdf', ['packages' => $packages]);
        return $pdf->download('Entregados Cartero.pdf');
    }
}
