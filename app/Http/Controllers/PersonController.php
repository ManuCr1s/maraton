<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Person;
use App\Models\Level;
use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
    public $token = 'apis-token-5761.59ZzjNAOFWADmBfvLbj8DvX98Yv1FDPH';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_count()
    {
        $result = DB::table('persons')
        ->rightJoin('levels', 'levels.id_level', '=', 'persons.id_level')
        ->select('levels.nombre', DB::raw('COUNT(persons.id_level) as total'), 'levels.cod')
        ->groupBy('persons.id_level', 'levels.nombre','levels.cod')
        ->where('persons.status', '=', '1')
        ->get();
        return json_encode($result);
    }

    public function register(){
        $result = DB::table('persons')
        ->Join('levels', 'levels.id_level', '=', 'persons.id_level')
        ->Join('regions', 'regions.id_region', '=', 'persons.id_region')
        ->Join('provinces', 'provinces.id_province', '=', 'persons.id_province')
        ->Join('districts', 'districts.id_district', '=', 'persons.id_district')
        ->select('persons.number_doc','persons.name','persons.lastname','levels.nombre','persons.number','regions.nombre as region','provinces.nombre as provincia','districts.nombre as distrito')
        ->where('persons.number', '!=', null)
        ->where('persons.status', '=', '1')
        ->get();
        return datatables()->of($result)->toJson();
    }
    public function inscription(){
        $result = DB::table('persons')
        ->Join('levels', 'levels.id_level', '=', 'persons.id_level')
        ->select('persons.number_doc','persons.name','persons.lastname','levels.nombre','persons.number_ins','persons.born')
        ->where('persons.number', '=', null)
        ->where('persons.status', '=', '1')
        ->get();
        return datatables()->of($result)->toJson();
    }
    public function file(Request $request)
    {
        
        $validator = Validator::make($request->all(),$this->rules,$this->message);
        if($validator->fails())return json_encode($validator->errors());
        
        $old = self::show($request->input('numero'));
    
        if($old){
            return json_encode(array('status'=>false,'message' =>'El usuario ya se encuentra registrado'));
        }else{
            
                $person = self::create(
                    $request->input('numero'),
                    $request->input('nombres'),
                    $request->input('apellidos'),
                    $request->input('genrs'),
                    $request->input('tipo'),
                    $request->input('fecha'),
                    $request->input('direccion'),
                    $request->input('celular'),
                    $request->input('pais'),
                    $request->input('region'),
                    $request->input('provincia'),
                    $request->input('distrito'),
                    $request->input('level')
                );
                $pdf = self::generarPdf($person['codigo']);
                $pdf['status']=true;
                $pdf['message'] = 'Ud. se ha registrado Satifactoriamente, por favor haga click en el boton para descargar su codigo';
                return json_encode($pdf);         
        } 
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($numero,$name,$lastanme,$genders,$type,$fecha,$direccion,$phone,$pais,$region,$provincia,$distrito,$level)
    {
        try {
            $codigo = self::show_number($level);
            $user = new Person;
            $user->number_doc  = $numero;
            $user->name  = $name;
            $user->lastname  = $lastanme;
            $user->genders  = ($genders == 2);
            $user->number_ins = $codigo;
            $user->type_doc = $type;
            $user->born = $fecha;
            $user->addresd = $direccion;
            $user->phone = $phone;
            $user->id_country  = $pais;
            $user->id_region  = $region;
            $user->id_province = $provincia;
            $user->id_district = $distrito;
            $user->id_level = $level;
            $user->save();
            return array("success" => true ,"codigo" => $codigo);
        } catch (\Throwable $th) {
            echo $th->getMessage();
            return array("success" => false ,"message" => "No se puede ingresar al usuario en la tabla");
        }
    }
    private $rules = [
        'pais'=>'not_in:0',
        'tipo'=>'not_in:0',
        'numero' => 'required|min:8|max:25',
        'nombres' => 'required',
        'apellidos' => 'required',
        'region'=> 'required_if:pais,1',
        'provincia'=> 'required_if:pais,1',
        'distrito'=> 'required_if:pais,1',
        'level' => 'not_in:0',
        'genrs'=>   'not_in:0',
        'fecha' => 'required',
        'direccion' => 'required',
        'celular' => 'required',
    ];
    private $message =[
        'pais.not_in' =>['status'=>'false','message'=>'Por favor seleccione Pais de Procedencia'],
        'tipo.not_in' =>['status'=>'false','message'=>'Por favor seleccione Tipo de documento'],
        'numero.required' => ['status'=>'false','message'=>'Por favor ingrese numero de documento'],
        'numero.min' => ['status'=>'false','message'=>'Por favor ingrese numero de documento valido'],
        'numero.max' => ['status'=>'false','message'=>'Por favor ingrese numero de documento valido'],
        'nombres.required' => ['status'=>'false','message'=>'Por favor ingrese Nombre'],
        'apellidos.required' => ['status'=>'false','message'=>'Por favor ingrese Apellidos'],
        'region.required_if'=> ['status'=>'false','message'=>'Por favor seleccione Region'],
        'provincia.required_if'=> ['status'=>'false','message'=>'Por favor seleccione Provincia'],
        'distrito.required_if'=> ['status'=>'false','message'=>'Por favor seleccione Distrito'],
        'level.not_in' => ['status'=>'false','message'=>'Por favor seleccione Categoria'],
        'genrs.not_in'=>['status'=>'false','message'=>'Por favor seleccione genero'],
        'fecha.required' => ['status'=>'false','message'=>'Por favor ingrese fecha de Nacimiento'],
        'direccion.required' => ['status'=>'false','message'=>'Por favor ingrese Direccion'],
        'celular.required' => ['status'=>'false','message'=>'Por favor ingrese Celular'],
    ];
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validacion = self::validateInput($request->input('tipo'),$request->input('numero'),$request->input('pais'));
        if(!$validacion['status']) return json_encode($validacion);
        $old = self::show($request->input('numero'));
        if($old){
            return json_encode(array('status'=>false,'message' =>'El usuario ya se encuentra registrado'));
        }else{
            if($request->input('tipo') == 1){
                $response = self::store_dni($request->input('numero'),$this->token);
                return  json_encode($response);
            }
        }
    }
    public function validateInput($tipo,$dni,$pais){
        if($pais == 0) return array('status'=>false,'message'=>'Por favor seleccione Pais');
        if($tipo == 0) return array('status'=>false,'message'=>'Por favor tipo de Documento');
        if(strlen($dni) < 8 || strlen($dni) > 8 ) return array('status'=>false,'message'=>'Por favor numero de Documento Valido');
        return array('status'=>true);
    }
    public function store_dni($id,$tok)
    {
        $curl = curl_init();
        // Buscar dni
        curl_setopt_array($curl, array(
        // para user api versión 2
        CURLOPT_URL => 'https://api.apis.net.pe/v2/reniec/dni?numero=' . $id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 2,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Referer: https://apis.net.pe/consulta-dni-api',
            'Authorization: Bearer ' . $tok
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $persona = json_decode($response);       
        if($persona == null){
            $persona = array('status'=>false,'message'=>'Por favor verifique su conexion a internet');
        }else if(property_exists($persona,'nombres')){
            $persona->status = true;
        }else if($persona->message == 'dni no valido'){
            $persona->status = false;
            $persona->message = 'Por favor ingrese un DNI valido';
        }else if($persona->message == 'not found'){
            $persona->status = false;
            $persona->message = 'Por favor registre sus nombres y apellidos';
            $persona->active = false;
        }
        return $persona;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $persona = new Person;
        $persona =Person::where('number_doc', $id)->exists(); 
        return $persona;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_number($level){
        $persona = new Person;
        $persona = Person::where('id_level', $level)->count(); 
        return self::show_level($level).'-'.$persona;
    }
    public function show_level($level){
        $cat = new Level;
        $cat = Level::select('cod')->where('id_level', $level)->first(); 
        return $cat->cod;
    }
    public function generarPdf($id)
    {
        $data = $id; // Puedes pasar datos a tu vista si es necesari
        $pdf = PDF::loadView('pdf.numero', compact('data')); // Nombre de la vista y datos
        $nombre = $data.'.pdf';
        $pdf->save(public_path('pdfs/' . $nombre));
        return ['url' => asset('pdfs/' . $nombre)];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(mb_strlen($request->input('numero')) == 0 ) return json_encode(['status'=>false,'message'=>'Ingrese numero']);
        $flight = Person::find($request->input('dni'));
        $flight->number = $request->input('numero');
        $flight->user = $request->input('user');
        $flight->save();
        return json_encode(['status'=>true,'message'=>'Se ingreso correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
