<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Recrutement;
use App\Demande;
use Auth;

use App\Http\Requests\cvRequest;

class AdminController extends Controller
{
    public function index($id){
    	$user = User::find($id);
        return view('cv.admin',['user'=>$user, 'id' => $user->id]);
    }

    public function edit($id){
    	$cv = User::find($id);

        if ($id == Auth::user()->id) {
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
        $cv->age=$request->input('age');


    	if($request->hasFile('photo')){
    	$cv->image = $request->photo->store('image');
    	}

        if ($request->input('password') != null) {
            $cv->password=Hash::make($request->input('password'));
        }


    	$cv->save();
    	return redirect('cvs');
    }

    public function getRecrutement($id){
        $Recrutements = Recrutement::orderBy('created_at','desc')->get();
        $Demandes = Demande::orderBy('created_at','desc')->get();

        return Response()->json(['Recrutements' => $Recrutements, 'Demandes' => $Demandes]);
    }

    public function getPartners(){
        $partners = User::where('post', "Entreprise")->get();
        return view('cv.partners',['partners' => $partners]);
    }

    public function make_Ing_Available(Request $request){
        $user = User::find($request->id);
        $user->dispo = 1;
        $user->valide_id_ent = null;
        $user->add_to_cart_id_ent = null;
        $user->save();

        return Response()->json(['ing' => $user]);
    }

    
}
