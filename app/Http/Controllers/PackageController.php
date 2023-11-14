<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Event;
use App\Exports\VentanillaExport;
use App\Exports\ClasificacionExport;
use App\Exports\ReencaminarExport;
use App\Exports\InventarioExport;
use App\Exports\PackageExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use \Milon\Barcode\DNS1D;
use Picqer;

/**
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
        $request->validate(Package::$rules);

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
            'action' => 'ADMITIDO',
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
        request()->validate(Package::$rules);

        // Obtener el código del paquete antes de la actualización
        $codigo = $package->CODIGO;

        $package->update($request->all());
        Event::create([
            'action' => 'ESTADO',
            'descripcion' => 'Edición de Paquete',
            'user_id' => auth()->user()->id,
            'codigo' => $codigo, // Utiliza el código obtenido previamente
        ]);
        return redirect()->route('packages.clasificacion')
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
    public function formularioentrega(Request $request, $id)
    {
        $package = Package::find($id);
        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        $code = $generator->getBarcode($package->CODIGO, $generator::TYPE_CODE_128);
        $pdf = PDF::loadView('package.pdf.formularioentrega', compact('package', 'request'));
        return $pdf->stream();
        // Descargar el PDF o mostrarlo en el navegador
        // return $pdf->download('formularioentrega.pdf');
    }
    public function abandono(Request $request, $id)
    {
        $package = Package::find($id);
        $pdf = PDF::loadView('package.pdf.abandono', compact('package', 'request'));
        return $pdf->stream();
        // Descargar el PDF o mostrarlo en el navegador
        // return $pdf->download('formularioentrega.pdf');
    }

    public function delete($id)
    {
        $package = Package::find($id);

        if ($package) {
            Event::create([
                'action' => 'ENTREGADO',
                'descripcion' => 'Entrega de paquete en ventanilla en Oficina Postal Regional(ENTREGADO)',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            // Cambia el estado del paquete a "ENTREGADO"
            $package->estado = 'ENTREGADO';

            // Guarda el paquete actualizado
            $package->save();

            // Luego, elimina el paquete
            $package->delete();

            return back()->with('success', 'Paquete se dio de Baja y cambió su estado a ENTREGADO con éxito.');
        } else {
            return back()->with('error', 'No se pudo encontrar el paquete para dar de baja.');
        }
    }
    public function deleteado()
    {
        // $packages = Package::where('ESTADO', 'ENTREGADO')->paginate(20);
        $packages = Package::onlyTrashed()->paginate(20);
        return view('package.deleteado', compact('packages'));
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
            $package->cuidadre = $request->input('cuidadre');

            // Obtén la fecha y hora actual y guárdala en el campo 'fecha_hora_redirigido'
            $package->date_redirigido = now();

            // Guarda el paquete actualizado
            $package->save();

            return back()->with('success', 'Paquete redirigido con éxito.');
        } else {
            return back()->with('error', 'No se pudo encontrar el paquete para redirigir.');
        }
    }

    public function redirigidos()
    {
        $package = Package::where('redirigido', true)->paginate(20);

        return view('package.redirigidos', compact('package'));
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

            return back()->with('success', 'Paquete redirigido con éxito.');
        } else {
            return back()->with('error', 'No se pudo encontrar el paquete para redirigir.');
        }
    }
    public function ventanilla()
    {
        $packages = Package::paginate(10);

        return view('package.ventanilla', compact('packages'))
            ->with('i', (request()->input('page', 1) - 1) * $packages->perPage());
    }
    public function clasificacion()
    {
        $packages = Package::paginate(10);

        return view('package.clasificacion', compact('packages'))
            ->with('i', (request()->input('page', 1) - 1) * $packages->perPage());
    }

    public function buscarPaquete(Request $request)
    {
        $codigo = $request->input('codigo');
        $package = Package::where('CODIGO', $codigo)->first(); // Usar el nombre del modelo correctamente

        if ($package) {
            Event::create([
                'action' => 'DISPONIBLE',
                'descripcion' => 'Paquete a la espera de ser recogido',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            Event::create([
                'action' => 'EN ENTREGA',
                'descripcion' => 'Paquete Recibido en Oficina Postal Regional(VENTANILLA)',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);

            // Cambiar el estado del paquete a "VENTANILLA"
            $package->ESTADO = 'VENTANILLA';
            $package->save();

            return redirect()->back()->with('success', 'El paquete ha sido movido a VENTANILLA.');
        } else {
            return redirect()->back()->with('error', 'El paquete no se encuentra en clasificación.');
        }
    }
    public function buscarPaqueteCartero(Request $request)
    {
        $codigo = $request->input('codigo');
        $package = Package::where('CODIGO', $codigo)->first();

        if ($package) {
            if ($package->ESTADO === 'VENTANILLA') {
                Event::create([
                    'action' => 'EN ENTREGA',
                    'descripcion' => 'Paquete Destinado por envío con Cartero',
                    'user_id' => auth()->user()->id,
                    'codigo' => $package->CODIGO,
                ]);
                // Cambiar el estado del paquete a "CARTERO"
                $package->ESTADO = 'CARTERO';
                $package->save();

                return redirect()->back()->with('success', 'El paquete ha sido movido a Cartero.');
            } else {
                return redirect()->back()->with('error', 'El paquete no se encuentra en estado "VENTANILLA".');
            }
        } else {
            return redirect()->back()->with('error', 'El paquete no se encuentra en Clasificación.');
        }
    }

    public function carteros()
    {
        $packages = Package::paginate(10);

        return view('package.carteros', compact('packages'))
            ->with('i', (request()->input('page', 1) - 1) * $packages->perPage());
    }
    public function carteropdf()
    {
        $packages = Package::where('ESTADO', 'CARTERO')->get();
        $pdf = PDF::loadview('package.pdf.carteropdf', ['packages' => $packages]);
        return $pdf->stream();
    }
    public function inventariocartero()
    {
        $packages = Package::where('ESTADO', 'DOMICILIO')->paginate(20);
        return view('package.inventariocartero', compact('packages'));
    }
    public function deletecartero($id)
    {
        $package = Package::find($id);

        if ($package) {
            Event::create([
                'action' => 'ENTREGADO',
                'descripcion' => 'Entrega de paquete con Cartero(DOMICILIO)',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            // Cambia el estado del paquete a "ENTREGADO"
            $package->estado = 'DOMICILIO';

            // Guarda el paquete actualizado
            $package->save();

            // Luego, elimina el paquete
            $package->delete();

            return back()->with('success', 'Paquete se dio de Baja y cambió su estado a ENTREGADO con éxito.');
        } else {
            return back()->with('error', 'No se pudo encontrar el paquete para dar de baja.');
        }
    }
    public function deleteadocarteropdf()
    {
        $packages = Package::withTrashed()->where('ESTADO', 'DOMICILIO')->get(); // Obtener registros eliminados
        $pdf = PDF::loadView('package.pdf.deleteadocarteropdf', ['packages' => $packages]);
        return $pdf->stream();
    }

    //REPORTES
    public function packagesallexcel()
    {
        return Excel::download(new PackageExport, 'Almacen.xlsx');
    }
    public function clasificacionexcel()
    {
        $packages = Package::where('ESTADO', 'CLASIFICACION')->get();
        return Excel::download(new ClasificacionExport($packages), 'Clasificacion.xlsx');
    }
    public function reencaminarexcel()
    {
        $packages = Package::where('ESTADO', 'REENCAMINADO')->get();
        return Excel::download(new ReencaminarExport($packages), 'Rencaminar.xlsx');
    }
    public function inventarioexcel()
    {
        $packages = Package::withTrashed()->where('ESTADO', 'ENTREGADO')->get();
        return Excel::download(new InventarioExport($packages), 'Inventario.xlsx');
    }
    public function ventanillaexcel()
    {
        $packages = Package::where('ESTADO', 'VENTANILLA')->where('redirigido', 0)->get();
        return Excel::download(new VentanillaExport($packages), 'ventanilla.xlsx');
    }
    public function packagesallpdf()
    {
        $packages = Package::all();
        $pdf = PDF::loadview('package.pdf.packagesall', ['packages' => $packages]);
        return $pdf->stream();
    }
    public function clasificacionpdf()
    {
        $packages = Package::where('ESTADO', 'CLASIFICACION')->get();
        $pdf = PDF::loadview('package.pdf.clasificacionpdf', ['packages' => $packages]);
        return $pdf->stream();
    }
    public function redirigidospdf()
    {
        $packages = Package::where('ESTADO', 'REENCAMINADO')->get();
        $pdf = PDF::loadview('package.pdf.redirigidospdf', ['packages' => $packages]);
        return $pdf->stream();
    }
    public function ventanillapdf()
    {
        $packages = Package::where('ESTADO', 'VENTANILLA')->where('redirigido', 0)->get();
        $pdf = PDF::loadView('package.pdf.ventanillapdf', ['packages' => $packages]);
        return $pdf->stream();
    }
    public function deleteadopdf()
    {
        $packages = Package::withTrashed()->where('ESTADO', 'ENTREGADO')->get(); // Obtener registros eliminados
        $pdf = PDF::loadView('package.pdf.deleteadopdf', ['packages' => $packages]);
        return $pdf->stream();
    }
    
}
