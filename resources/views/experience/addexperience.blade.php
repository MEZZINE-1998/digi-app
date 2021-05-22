       
@extends('layouts.app')

@section('content')

    <div class="container">
      <div class="row">
          <div class="col-md-12">

             
               <ul class="list-group">
                <li  class="list-group-item active text-center">
                  ajouter votre experience
                </li>

              <form method="post" action="{{ asset('cvs/'.$cv->id) }}">
                {{ csrf_field() }}
                <i style="float: right;size: 30px" class="fas fa-chevron-up"></i>
                <li  class="list-group-item">
              <div class="form-group ">
                <label for="">Titre</label>
                <input type="text" name="titre"  class="form-control" value="{{ old('titre') }}">
                
              </div>

              <div class="form-group">
                <label for="">Commentaire</label>
                <textarea name="commentaire" class="form-control">{{ old('commentaire') }}</textarea>
              
              </div>
              <div class="row">
                  

                     <div class="col-md-4">
                       <label for="">Lieu</label>
                       <input type="text" name="ville" class="form-control" value="{{ old('ville') }}">
                     </div>
                  
                     <div class="col-md-4">
                       <label for="">Date debut</label>
                       <input type="Date" name="debut" class="form-control" value="{{ old('debut') }}">
                     </div>
                  
                  
                     <div class="col-md-4">
                       <label for="">Date fin</label>
                       <input type="Date" name="fin" class="form-control" value="{{ old('fin') }}">
                     </div>
              </div>
              
              <br>
              <div class="form-group">
                <input type="submit" name="" class="form-control btn btn-primary btn-sm" value="Ajouter">
              </div>
                </li>
              </form>
               </ul>
             </div>
           </div>
         </div>

@endsection
  
