<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Event;
use App\Exports\VentanillaExport;
use App\Exports\VentanilladndExport;
use App\Exports\CasillasExport;
use App\Exports\EcaExport;
use App\Exports\ClasificacionExport;
use App\Exports\ReencaminarExport;
use App\Exports\InventarioExport;
use App\Exports\InventarioDDExport;
use App\Exports\InventarioDNDExport;
use App\Exports\InventarioECAExport;
use App\Exports\InventarioCASIExport;
use App\Exports\InventarioUNICAExport;
use App\Exports\EcainventarioExport;
use App\Exports\EncomiendasExport;
use App\Exports\PackageExport;
use App\Exports\CarteroExport;
use App\Exports\CarteroGeneralExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use \Milon\Barcode\DNS1D;
use Picqer;

/**
 * 
 * 
 * Class PackageController
 * @package App\Http\Controllers
 */
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
            'VENTANILLA' => 'required|in:DND,DD,ECA,CASILLAS,UNICA',
            // 'ZONA' => 'required_if:VENTANILLA,DD,ECA,CASILLAS|string|max:255',
            'PESO' => 'required|numeric|regex:/^\d+(\.\d{1,3})?$/|between:0.001,10.000',
            'TIPO' => 'required|string',
            'ADUANA' => 'required|string',
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
    public function destroy($id)
    {
        $package = Package::find($id); // Encuentra el paquete
        $codigo = $package->CODIGO; // Obtiene el código antes de eliminar el paquete
        $package->forceDelete(); // Elimina el paquete

        Event::create([
            'action' => 'ESTADO',
            'descripcion' => 'Eliminación de Paquete',
            'user_id' => auth()->user()->id,
            'codigo' => $codigo, // Utiliza el código obtenido previamente
        ]);

        return redirect()->route('packages.clasificacion')
            ->with('success', 'Paquete Eliminado Con Éxito!');
    }

    public function delete(Request $request, $id)
    {
        $package = Package::find($id);

        if ($package) {
            // Registra el evento de entrega
            Event::create([
                'action' => 'ENTREGADO',
                'descripcion' => 'Entrega de paquete en ventanilla en Oficina Postal Regional',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);

            // Cambia el estado del paquete a "ENTREGADO"
            $package->estado = 'ENTREGADO';

            // Guarda el paquete actualizado
            $package->save();

            // Determina qué formulario cargar según el valor de la variable ADUANA
            $formulario = ($package->ADUANA == 'SI') ? 'package.pdf.formularioentrega' : 'package.pdf.formularioentrega2';

            // Genera el PDF del formulario correspondiente
            $pdf = PDF::loadView($formulario, compact('package', 'request'));

            // Abre el PDF en una nueva pestaña
            $pdf->stream('Formulario de Entrega.pdf');

            // Elimina el paquete
            $package->delete();

            return $pdf->stream('Formulario de Entrega.pdf');
            // return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'No se pudo encontrar el paquete para dar de baja o generar el PDF.']);
        }
    }

    public function restoring($id)
    {
        // Restaura el paquete con el ID dado
        $package = Package::withTrashed()->find($id);
        // Verifica si se encontró un paquete eliminado con ese ID
        if ($package) {
            Event::create([
                'action' => 'ESTADO',
                'descripcion' => 'Alta de Paquete',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            $package->update(['ESTADO' => 'VENTANILLA']);
            // Restaura el paquete
            $package->restore();
            return redirect()->route('packages.ventanilla')
                ->with('success', 'El paquete ha sido restaurado exitosamente');
        } else {
            return redirect()->route('packages.ventanilla')
                ->with('error', 'El paquete no pudo ser encontrado o restaurado');
        }
    }
    public function redirigir(Request $request, $id)
    {
        $package = Package::find($id);

        if ($package) {
            // Cambia el estado del paquete a "redirigido"
            $package->redirigido = true;
            Event::create([
                'action' => 'PRE-ENTREGA',
                'descripcion' => 'Correccion de Destino de paquete a Oficina Postal Regional',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);

            $package->estado = 'REENCAMINADO';

            // Obtén la fecha y hora actual y guárdala en el campo 'fecha_hora_redirigido'
            $package->date_redirigido = now();

            // Guarda el paquete actualizado
            $package->save();

            return back()->with('success', 'Paquete se dio de Reencamino con exito y cambió su estado a REENCAMINADO con éxito.');
        } else {
            return back()->with('error', 'No se pudo encontrar el paquete para redirigir.');
        }
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
    public function reencaminar($packageId)
    {
        $package = Package::find($packageId);

        if ($package) {
            // Cambia el estado del paquete a "redirigido"
            $package->redirigido = true;
            Event::create([
                'action' => 'PRE-ENTREGA',
                'descripcion' => 'Correccion de Destino de paquete a Oficina Postal Regional',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);

            $package->estado = 'REENCAMINADO';
            $package->date_redirigido = now();
            $package->save();

            // Emitir evento para abrir el modal
            // $this->emit('abrirModal', [
            //     'codigo' => $package->CODIGO,
            //     'destinatario' => $package->DESTINATARIO,
            //     'cuidad' => $package->CUIDAD,
            //     'ventanilla' => $package->VENTANILLA,
            // ]);

            return back()->with('success', 'Paquete se dio de Reencamino con éxito y cambió su estado a REENCAMINADO.');
        } else {
            return back()->with('error', 'No se pudo encontrar el paquete para redirigir.');
        }
    }


    public function deletecartero($id, Request $request)
    {
        $package = Package::find($id);

        if ($package) {
            // Obtén el valor seleccionado del select
            $nuevoEstado = $request->input('estado');

            // Guarda el nuevo estado en el paquete
            $package->estado = $nuevoEstado;

            // Verifica si el estado es "VENTANILLA"
            if ($nuevoEstado == 'RETORNO') {
                // Obtén la razón seleccionada desde el segundo select
                $razonSeleccionada = $request->input('razon');

                // Llena la variable OBSERVACIONES con la razón seleccionada
                $package->OBSERVACIONES = $razonSeleccionada;
                Event::create([
                    'action' => 'DEVUELTO',
                    'descripcion' => 'El Cartero devolvio el paquete a Ventanilla',
                    'user_id' => auth()->user()->id,
                    'codigo' => $package->CODIGO,
                ]);
                $package->save();
            } elseif ($nuevoEstado == 'PRE-REZAGO') {
                // Obtén la razón seleccionada desde el tercer select
                $razonSeleccionada = $request->input('razon');

                // Llena la variable OBSERVACIONES con la razón seleccionada
                $package->OBSERVACIONES = $razonSeleccionada;
                Event::create([
                    'action' => 'PRE-REZAGO',
                    'descripcion' => 'El Cartero devolvio el paquete a Ventanilla y Ingreso a Almacen',
                    'user_id' => auth()->user()->id,
                    'codigo' => $package->CODIGO,
                ]);
                $package->update(['dateprerezago' => now()]);
                $package->save();
            } else {
                // Si el estado no es "VENTANILLA", deja OBSERVACIONES en blanco
                $package->OBSERVACIONES = "";
                // Guarda el paquete actualizado
                $package->save();

                // Crea un registro de evento solo si el estado 
                Event::create([
                    'action' => 'ENTREGADO',
                    'descripcion' => 'Entrega de paquete con Cartero',
                    'user_id' => auth()->user()->id,
                    'codigo' => $package->CODIGO,
                ]);

                // Luego, elimina el paquete
                $package->delete();
            }
            return back()->with('success', 'Paquete se dio de Baja y cambió su estado con éxito.');
        } else {
            return back()->with('error', 'No se pudo encontrar el paquete para dar de baja.');
        }
    }

    public function buscarPaquete(Request $request)
    {
        $codigo = $request->input('codigo');
        $zona = $request->input('zona');
        $package = Package::where('CODIGO', $codigo)->first();

        if ($package) {

            // Verificar que el estado del paquete sea 'DESPACHO' o 'RETORNO'
            if ($package->ESTADO === 'DESPACHO' || $package->ESTADO === 'RETORNO') {
                // Verificar que el destino sea igual a la regional del usuario
                if (auth()->user()->Regional == $package->CUIDAD) {
                    if ($package->ESTADO === 'DESPACHO') {
                        Event::create([
                            'action' => 'DISPONIBLE',
                            'descripcion' => 'Paquete a la espera de ser recogido en ventanilla ' . $package->VENTANILLA,
                            'user_id' => auth()->user()->id,
                            'codigo' => $package->CODIGO,
                        ]);
                        Event::create([
                            'action' => 'EN ENTREGA',
                            'descripcion' => 'Paquete Recibido en Oficina Postal Regional.' . $package->CUIDAD,
                            'user_id' => auth()->user()->id,
                            'codigo' => $package->CODIGO,
                        ]);
                    }

                    // Cambiar el estado del paquete a "VENTANILLA"
                    $package->ZONA = $zona;
                    $package->ESTADO = 'VENTANILLA';
                    $package->save();

                    return redirect()->back()->with('success', 'Paquete se movió a Ventanilla con éxito y cambió su estado a VENTANILLA con éxito.');
                } else {
                    return redirect()->back()->with('error', 'El paquete no está destinado a la regional del usuario.');
                }
            } else {
                // Si el estado es 'RETORNO', cambiar el estado a 'VENTANILLA' sin eventos adicionales
                $package->ESTADO = 'VENTANILLA';
                $package->save();

                return redirect()->back()->with('success', 'Paquete se movió a Ventanilla con éxito y cambió su estado a VENTANILLA con éxito.');
            }
        } else {
            return redirect()->back()->with('error', 'No se pudo encontrar el paquete.');
        }
    }
    public function buscarPaqueteunica(Request $request)
    {
        $codigo = $request->input('codigo');
        $zona = $request->input('zona');
        $package = Package::where('CODIGO', $codigo)->first();

        if ($package) {

            // Verificar que el estado del paquete sea 'DESPACHO' o 'RETORNO'
            if ($package->ESTADO === 'DESPACHO' || $package->ESTADO === 'RETORNO') {
                // Verificar que el destino sea igual a la regional del usuario
                if (auth()->user()->Regional == $package->CUIDAD) {
                    if ($package->ESTADO === 'DESPACHO') {
                        Event::create([
                            'action' => 'DISPONIBLE',
                            'descripcion' => 'Paquete a la espera de ser recogido en ventanilla ' . $package->VENTANILLA,
                            'user_id' => auth()->user()->id,
                            'codigo' => $package->CODIGO,
                        ]);
                        Event::create([
                            'action' => 'EN ENTREGA',
                            'descripcion' => 'Paquete Recibido en Oficina Postal Regional.' . $package->CUIDAD,
                            'user_id' => auth()->user()->id,
                            'codigo' => $package->CODIGO,
                        ]);
                    }

                    // Cambiar el estado del paquete a "VENTANILLA"
                    $package->ZONA = $zona;
                    $package->ESTADO = 'RECIBIDO';
                    $package->save();

                    return redirect()->back()->with('success', 'Paquete se Recibio con éxito y cambió su estado a RECIBIDO con éxito.');
                } else {
                    return redirect()->back()->with('error', 'El paquete no está destinado a la regional del usuario.');
                }
            } else {
                // Si el estado es 'RETORNO', cambiar el estado a 'VENTANILLA' sin eventos adicionales
                $package->ESTADO = 'RECIBIDO';
                $package->save();

                return redirect()->back()->with('success', 'Paquete se movió a Ventanilla con éxito y cambió su estado a VENTANILLA con éxito.');
            }
        } else {
            return redirect()->back()->with('error', 'No se pudo encontrar el paquete.');
        }
    }
    public function buscarPaquetecasilla(Request $request)
    {
        $codigo = $request->input('codigo');
        $zona = $request->input('zona');
        $package = Package::where('CODIGO', $codigo)
            ->where('ESTADO', 'DESPACHO')
            ->where('VENTANILLA', 'CASILLAS')
            ->first();

        if ($package) {
            // Verificar que la regional del usuario coincide con la regional del paquete
            if (auth()->user()->Regional == $package->CUIDAD) {
                // Crear eventos solo si el estado es 'DESPACHO'
                if ($package->ESTADO === 'DESPACHO') {
                    Event::create([
                        'action' => 'DISPONIBLE',
                        'descripcion' => 'Paquete a la espera de ser recogido en Casillero Postal ' . $package->nrocasilla,
                        'user_id' => auth()->user()->id,
                        'codigo' => $package->CODIGO,
                    ]);
                    Event::create([
                        'action' => 'EN ENTREGA',
                        'descripcion' => 'Paquete Recibido en Oficina Postal Regional.' . $package->CUIDAD,
                        'user_id' => auth()->user()->id,
                        'codigo' => $package->CODIGO,
                    ]);
                }

                // Cambiar el estado del paquete a "VENTANILLA"
                $package->ZONA = $zona;
                $package->ESTADO = 'VENTANILLA';
                $package->save();

                return redirect()->back()->with('success', 'Paquete se movió a Ventanilla con éxito y cambió su estado a VENTANILLA con éxito.');
            } else {
                return redirect()->back()->with('error', 'El paquete no está destinado a la regional del usuario.');
            }
        } else {
            return redirect()->back()->with('error', 'No se pudo encontrar el paquete con estado DESPACHO y ventanilla CASILLAS.');
        }
    }
    public function buscarPaqueteeca(Request $request)
    {
        $codigo = $request->input('codigo');
        $zona = $request->input('zona');
        $package = Package::where('CODIGO', $codigo)
            ->where('ESTADO', 'DESPACHO')
            ->where('VENTANILLA', 'ECA')
            ->first();

        if ($package) {
            // Verificar que la regional del usuario coincide con la regional del paquete
            if (auth()->user()->Regional == $package->CUIDAD) {
                // Crear eventos solo si el estado es 'DESPACHO'
                if ($package->ESTADO === 'DESPACHO') {
                    Event::create([
                        'action' => 'DISPONIBLE',
                        'descripcion' => 'Paquete a la espera de ser recogido en Casillero Postal ' . $package->nrocasilla,
                        'user_id' => auth()->user()->id,
                        'codigo' => $package->CODIGO,
                    ]);
                    Event::create([
                        'action' => 'EN ENTREGA',
                        'descripcion' => 'Paquete Recibido en Oficina Postal Regional.' . $package->CUIDAD,
                        'user_id' => auth()->user()->id,
                        'codigo' => $package->CODIGO,
                    ]);
                }

                // Cambiar el estado del paquete a "VENTANILLA"
                $package->ZONA = $zona;
                $package->ESTADO = 'VENTANILLA';
                $package->save();

                return redirect()->back()->with('success', 'Paquete se movió a Ventanilla con éxito y cambió su estado a VENTANILLA con éxito.');
            } else {
                return redirect()->back()->with('error', 'El paquete no está destinado a la regional del usuario.');
            }
        } else {
            return redirect()->back()->with('error', 'No se pudo encontrar el paquete con estado DESPACHO y ventanilla CASILLAS.');
        }
    }

    public function deletecasillas(Request $request, $id)
    {
        $package = Package::find($id);

        if ($package) {
            // Registra el evento de entrega
            Event::create([
                'action' => 'ENTREGADO',
                'descripcion' => 'Entrega de paquete en Casillero Postal en Oficina Regional',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);

            // Cambia el estado del paquete a "ENTREGADO"
            $package->estado = 'CASILLA';

            // Guarda el paquete actualizado
            $package->save();

            // Determina qué formulario cargar según el valor de la variable ADUANA
            $formulario = ($package->ADUANA == 'SI') ? 'package.pdf.formularioentrega' : 'package.pdf.formularioentrega2';

            // Genera el PDF de abandono
            $pdf = PDF::loadView($formulario, compact('package', 'request'));

            // Abre el PDF en una nueva pestaña
            $pdf->stream('Formulario de Entrega.pdf');

            // Elimina el paquete
            $package->delete();

            return $pdf->stream('Formulario de Entrega.pdf');
            // return response()->json(['success' => true]);

            return back()->with('success', 'Paquete se dio de Baja y cambió su estado con éxito.');
        } else {
            return redirect()->back()->with('error', 'No se pudo encontrar el paquete para dar de baja o generar el PDF.');
        }
    }
    public function deleteeca(Request $request, $id)
    {
        $package = Package::find($id);

        if ($package) {
            // Registra el evento de entrega
            Event::create([
                'action' => 'ENTREGADO',
                'descripcion' => 'Entrega de paquete en Casillero Postal en Oficina Regional',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);

            // Cambia el estado del paquete a "ENTREGADO"
            $package->estado = 'ENTREGADO';

            // Guarda el paquete actualizado
            $package->save();

            // Determina qué formulario cargar según el valor de la variable ADUANA
            $formulario = ($package->ADUANA == 'SI') ? 'package.pdf.formularioentrega' : 'package.pdf.formularioentrega2';

            // Genera el PDF de abandono
            $pdf = PDF::loadView($formulario, compact('package', 'request'));

            // Abre el PDF en una nueva pestaña
            $pdf->stream('Formulario de Entrega.pdf');

            // Elimina el paquete
            $package->delete();

            return $pdf->stream('Formulario de Entrega.pdf');
            // return response()->json(['success' => true]);

            return back()->with('success', 'Paquete se dio de Baja y cambió su estado con éxito.');
        } else {
            return redirect()->back()->with('error', 'No se pudo encontrar el paquete para dar de baja o generar el PDF.');
        }
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

    //REPORTES EXCEL Y PDF
    public function packagesallexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $ciudad = $request->input('ciudad');

        return Excel::download(new PackageExport($fechaInicio, $fechaFin, $ciudad), 'Almacen.xlsx');
    }

    public function clasificacionexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $ciudad = $request->input('ciudad');
        $ventanilla = $request->input('ventanilla');

        $packages = Package::where('ESTADO', 'CLASIFICACION')
            ->where('CUIDAD', $ciudad)
            ->where('VENTANILLA', $ventanilla)
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->get();

        return Excel::download(new ClasificacionExport($fechaInicio, $fechaFin), 'Clasificacion.xlsx');
    }

    public function reencaminarexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $ciudad = $request->input('ciudad');
        return Excel::download(new ReencaminarExport($fechaInicio, $fechaFin, $ciudad), 'Rencaminar.xlsx');
    }
    public function inventarioexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $packages = Package::withTrashed()->where('ESTADO', 'ENTREGADO')->get();
        return Excel::download(new InventarioExport($fechaInicio, $fechaFin), 'Inventario Encomiendas.xlsx');
    }
    public function inventarioDDexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $packages = Package::withTrashed()->where('ESTADO', 'ENTREGADO')->get();
        return Excel::download(new InventarioDDExport($fechaInicio, $fechaFin), 'Inventario DD.xlsx');
    }
    public function inventarioDNDexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $packages = Package::withTrashed()->where('ESTADO', 'ENTREGADO')->get();
        return Excel::download(new InventarioDNDExport($fechaInicio, $fechaFin), 'Inventario DND .xlsx');
    }
    public function inventarioCASIexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $packages = Package::withTrashed()->where('ESTADO', 'ENTREGADO')->get();
        return Excel::download(new InventarioCASIExport($fechaInicio, $fechaFin), 'Inventario CASILLAS.xlsx');
    }
    public function inventarioECAexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $packages = Package::withTrashed()->where('ESTADO', 'ENTREGADO')->get();
        return Excel::download(new InventarioECAExport($fechaInicio, $fechaFin), 'Inventario ECA.xlsx');
    }
    public function inventarioUNICAexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        return Excel::download(new InventarioUNICAExport($fechaInicio, $fechaFin), 'Inventario UNICA.xlsx');
    }
    public function ecainventarioexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $packages = Package::withTrashed()->where('ESTADO', 'ENTREGADO')->get();
        return Excel::download(new EcainventarioExport($fechaInicio, $fechaFin), 'Inventario. xlsx');
    }
    public function ventanillaexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $regional = $request->input('regional');
        return Excel::download(new VentanillaExport($fechaInicio, $fechaFin, $regional), 'ventanillaUNICA.xlsx');
    }
    public function encomiendasexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $regional = $request->input('regional');
        return Excel::download(new EncomiendasExport($fechaInicio, $fechaFin, $regional), 'ventanillaencomiendas.xlsx');
    }
    public function ventanilladndexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $regional = $request->input('regional');
        return Excel::download(new VentanilladndExport($fechaInicio, $fechaFin, $regional), 'ventanilladnd.xlsx');
    }
    public function casillasexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $regional = $request->input('regional');
        return Excel::download(new CasillasExport($fechaInicio, $fechaFin, $regional), 'casillas.xlsx');
    }
    public function ecaexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $regional = $request->input('regional');
        return Excel::download(new EcaExport($fechaInicio, $fechaFin, $regional), 'eca.xlsx');
    }
    public function carteroexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $user = auth()->user();
        $packages = Package::withTrashed()->where('ESTADO', 'REPARTIDO')->get();
        return Excel::download(new CarteroExport($fechaInicio, $fechaFin, $user), 'Cartero.xlsx');
    }
    public function carterogeneralexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $packages = Package::withTrashed()->where('ESTADO', 'REPARTIDO')->get();
        return Excel::download(new CarteroGeneralExport($fechaInicio, $fechaFin), 'Cartero General.xlsx');
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
    // public function abandono(Request $request, $id)
    // {
    //     $package = Package::find($id);
    //     $pdf = PDF::loadView('package.pdf.abandono', compact('package', 'request'));
    //     return $pdf->stream();
    // }
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
