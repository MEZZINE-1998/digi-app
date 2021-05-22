<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\UploadedFile;

use Illuminate\Support\Facades\Hash;
use App\Cv;
use App\User;

use App\Recrutement;

use App\Experience;
use App\Formation;
use App\Competence;
use App\Loisire;
use App\Langue;

use Auth;

use App\Http\Requests\cvRequest;

class CvController extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

    public function index(){
    	$listcv = User::where('post',"ingenieur")->get();
    	return view('cv.index',['cvs' => $listcv]);

    }

    public function create(){
    	return view('cv.create');
    }

    public function store(Request $request){
    	$cv=new User();
    	$cv->name=$request->input('name');
    	$cv->email=$request->input('email');
        $cv->post=$request->input('post');
        $cv->password=Hash::make($request->input('password'));
       
    	$cv->save();
    	return redirect('cvs');
    }

    public function edit($id){


    	$cv = User::find($id);

        if ($id == Auth::user()->id || Auth::user()->post == "admin") {
            return view('cv.edit',['cv' => $cv]);
        }
        else{
            return view('errors.403',['cv' => $cv]);
        }

    	
    }

    public function update(Request $request,$id){
    	$cv = User::find($id);
    	$cv->name=$request->input('name');
        $cv->titre=$request->input('titre');
        $cv->description=$request->input('description');
        $cv->email=$request->input('email');
        $cv->telephone=$request->input('telephone');
        $cv->adresse=$request->input('adresse');
        
        if (Auth::user()->post == "Ingenieur") {
            $cv->age=$request->input('age');
        }
        if (Auth::user()->post == "admin" && $cv->post == "Ingenieur") {
            $cv->tarif=$request->input('tarif');
        }
        


    	if($request->hasFile('photo')){
    	$cv->image = $request->photo->store('image');
    	}

    	$cv->save();

        if (Auth::user()->id == $id) {
            if (Auth::user()->post == "Ingenieur") {
                return redirect('cvs/'.$id);
            }
            if (Auth::user()->post == "Entreprise") {
                return redirect('user/'.$id);
            }
            if (Auth::user()->post == "admin") {
                return redirect('admin/'.$id);
            }
        }
        else{
            return redirect('cvs/'.$id);
        }
    	
    }

     public function destroy(Request $request,$id){
        $cv = User::find($id);
        $cv->delete();
        return redirect('cvs');
    }


    public function show($id){
    	$cv = User::find($id);
        return view('cv.details',['cv'=>$cv, 'id' => $cv->id]);
    }

   
  	public function addExperience(Request $request){
    	$experiences = new Experience;

        $experiences->titre=$request->titre;
    	$experiences->commentaire=$request->commentaire;
    	$experiences->cv_id = $request->cv_id;
    	$experiences->ville=$request->ville;
    	$experiences->debut=$request->debut;
    	$experiences->fin=$request->fin;

    	$experiences->save();

        $Exps = Experience::where('cv_id', $request->cv_id)->orderBy('debut','desc')->get();
        // session()->flash('success','l`éxperience a été ajouté');
    	return Response()->json(['etate' => true , 'ide' => $experiences->id, 'experiences' => $Exps]);
    	
    }


    public function editExperience(Request $request){
        $experiences = Experience::find($request->id);

        $experiences->titre=$request->titre;
        $experiences->commentaire=$request->commentaire;
        $experiences->cv_id = $request->cv_id;
        $experiences->ville=$request->ville;
        $experiences->debut=$request->debut;
        $experiences->fin=$request->fin;

        $experiences->save();

        $Exps = Experience::where('cv_id', $request->cv_id)->orderBy('debut','desc')->get();

        return Response()->json(['etate' => true,'id' => $request->id, 'experiences' => $Exps]);
        
    }

    public function addFormation(Request $request){
        $formations = new Formation;

        $formations->titref=$request->titref;
        $formations->commentairef=$request->commentairef;
        $formations->cv_id = $request->cv_id;
        $formations->villef=$request->villef;
        $formations->debutf=$request->debutf;
        $formations->finf=$request->finf;

        $formations->save();

        $Fors = Formation::where('cv_id', $request->cv_id)->orderBy('debutf','desc')->get();

        return Response()->json(['etatf' => true , 'idf' => $formations->id, 'formations' => $Fors]);
        
    }

    public function editFormation(Request $request){
        $formations = Formation::find($request->id);

        $formations->titref=$request->titref;
        $formations->commentairef=$request->commentairef;
        $formations->cv_id = $request->cv_id;
        $formations->villef=$request->villef;
        $formations->debutf=$request->debutf;
        $formations->finf=$request->finf;

        $formations->save();

        $Fors = Formation::where('cv_id', $request->cv_id)->orderBy('debutf','desc')->get();

        return Response()->json(['etatf' => true, 'formations' => $Fors]);
        
    }

    public function addCompetence(Request $request){
        $competences = new Competence;

        $competences->commentaire=$request->commentaire;
        $competences->cv_id = $request->cv_id;

        $competences->save();

        $Coms = Competence::where('cv_id', $request->cv_id)->get();

        return Response()->json(['etatc' => true , 'idc' => $competences->id, 'competences' => $Coms]);
        
    }

    public function editCompetence(Request $request){
        $competences =  Competence::find($request->id);

        $competences->commentaire=$request->commentaire;
        $competences->cv_id = $request->cv_id;

        $competences->save();

        $Coms = Competence::where('cv_id', $request->cv_id)->get();

        return Response()->json(['etatc' => true, 'competences' => $Coms]);
        
    }




    
    public function getExperience($id){
        return Experience::where('cv_id', $id)->orderBy('debut','desc')->get();
    }


    public function getFormation($id){
        return Formation::where('cv_id', $id)->orderBy('debutf','desc')->get();
    }

    public function getCompetence($id){
        return Competence::where('cv_id', $id)->get();
    }

    





    public function deleteExperience($id){
        $experiences = Experience::find($id);
        $cv_id = $experiences->cv_id;
        $experiences->delete();
        $Exps = Experience::where('cv_id', $cv_id)->orderBy('debut','desc')->get();
        return Response()->json(['etatl' => true, 'experiences' => $Exps]);
    }
    public function deleteFormation($id){
        $experiences = Formation::find($id);
        $cv_id = $experiences->cv_id;
        $experiences->delete();
        $Fors = Formation::where('cv_id', $cv_id)->orderBy('debutf','desc')->get();
        return Response()->json(['etatl' => true, 'formations' => $Fors]);
    }
    public function deleteCompetence($id){
        $experiences = Competence::find($id);
        $cv_id = $experiences->cv_id;
        $experiences->delete();
        $Coms = Competence::where('cv_id', $cv_id)->get();
        return Response()->json(['etatl' => true, 'competences' => $Coms]);
    }


    public function getIngs(Request $request)
    {

        $ings = User::where('post',"ingenieur")->get();
        
        $experiences = Experience::all();
        $formations = formation::all();
        $skills = Competence::all();

        return response()->json([
            'ings' => $ings,
            'exps' => $experiences,
            'forms' => $formations,
            'skis' => $skills
        ]); 
    }


    public function getRecrutement($id){
        return Recrutement::orderBy('created_at','desc')->get();
    }


    public function update_password(Request $request){

        $user = User::find($request->id);
        $user->password=Hash::make($request->password);
        $user->save();
    }



}

