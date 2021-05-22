<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Recrutement;
use App\Demande;
use Auth;

use App\Http\Requests\cvRequest;

class EntrepriseController extends Controller
{
    public function index($id){
    	$user = User::find($id);
        $ings = User::where([["add_to_cart", 1], ["add_to_cart_id_ent", Auth::user()->id]])->get();
        return view('cv.entreprise',['user'=>$user, 'id' => $user->id, 'nom_entreprise'=> $user->name, "ings" => $ings]);
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


    public function addRecrutement(Request $request){
    	$Recrutement = new Recrutement;

        $Recrutement->post=$request->post;
    	$Recrutement->description=$request->description;
        $Recrutement->duree_entretien = $request->duree_entretien;
    	$Recrutement->date_validation=$request->date_validation;
    	$Recrutement->id_entreprise = $request->user_id;
    	$Recrutement->nom_entreprise = $request->nom_entreprise;
        $Recrutement->id_condidats = $request->ings;

        

    	$Recrutement->save();

        for ($i=0; $i < count($request->ings); $i++) { 

            $user = User::find($request->ings[$i]['id']);
            $user->add_to_cart = 0;
            $user->save();
        }

        $Recs = Recrutement::where('id_entreprise', $request->user_id)->orderBy('date_validation','desc')->get();

        // session()->flash('success','l`éxperience a été ajouté');
    	return Response()->json(['etate' => true , 'idr' => $Recrutement->id, "Recrutements" => $Recs]);
    	
    }


    public function editRecrutement(Request $request){
        $Recrutement = Recrutement::find($request->id);

        $Recrutement->post=$request->post;
    	$Recrutement->description=$request->description;
        $Recrutement->duree_entretien = $request->duree_entretien;
    	$Recrutement->date_validation=$request->date_validation;
        $Recrutement->id_condidats = $request->id_condidats;

        $Recrutement->save();

        $Recs = Recrutement::where('id_entreprise', $request->id_entreprise)->orderBy('date_validation','desc')->get();

        return Response()->json(['etate' => true,'ide' => $request->id, 'Recrutements' => $Recs]);
        
    }

    
    public function getRecrutement($id){
        return Recrutement::where('id_entreprise', $id)->orderBy('created_at','desc')->get();
    }


    public function deleteRecrutement($id){
        $Recrutements = Recrutement::find($id);
        $id_entreprise = $Recrutements->id_entreprise;
        $Recrutements->delete();

        $Recs = Recrutement::where('id_entreprise', $id_entreprise)->orderBy('date_validation','desc')->get();
        return Response()->json(['etatl' => true, "Recrutements" => $Recs]);
    }


    public function add_to_cart(Request $request){
        $user = User::find($request->id);
        $user->add_to_cart = 1;
        $user->add_to_cart_id_ent = Auth::user()->id;
        $user->save();

        $ings = User::where('post', "Ingenieur")->get();
        return Response()->json(['ings' => $ings, 'ing' => $user]);
    }

    public function delete_from_cart(Request $request){
        $user = User::find($request->id);
        $user->add_to_cart = 0;
        $user->save();
        
        $ings = User::where('post', "Ingenieur")->get();
        return Response()->json(['ings' => $ings, 'ing' => $user]);
    }





    public function editDispoIngs(Request $request){

        $Recrutement = Recrutement::find($request->RecrutementId);
        $Recrutement->valide = 1;
        $Recrutement->id_condidats = $request->final_ings;
        $Recrutement->save();


        for ($i=0; $i < count($request->list_condidats_id); $i++) { 

            $user = User::find($request->list_condidats_id[$i]);
            $user->dispo = 0;
            $user->valide_id_ent = Auth::user()->id;
            $user->save();
        }

        $Recs = Recrutement::where('id_entreprise', $Recrutement->id_entreprise)->orderBy('date_validation','desc')->get();

        return Response()->json(["request" => $request->RecrutementId, 'Recrutements' => $Recs]);
    }





    public function send_Request_Ings(Request $request){

        $Demande = new Demande;
        $Demande->commentaire = $request->commentaire;
        $Demande->id_entreprise = $request->id_entreprise;

        $entreprise = User::find($request->id_entreprise);

        $Demande->nom_entreprise = $entreprise->name;

        $Demande->save();

        return Response()->json(["demande" => $Demande]);
    }


}
