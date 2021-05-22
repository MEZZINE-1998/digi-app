@extends('layouts.app')

@section('content')


<div id="app" class="container" style="margin-top: 20px">
    <div class="main-body">
    
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="{{ asset('storage/'.$cv->image) }}" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4>{{ $cv->name }}</h4>
                      <b style="color: black">{{ $cv->titre }}</b><br>
                      <small class="text-muted font-size-sm">{{ $cv->description }}</small>
                    </div>
                    @if(Auth::user()->id == $cv->id || Auth::user()->post == "admin")
                    <div>
                      <br>
                      <a href="{{url('cvs/'.$cv->id.'/edit')}}" style="color: green">Cofigurez le profile !</a>
                    </div>
                    <br>

                    <i v-if="notif == 0" @click="notif = 1" style="color: red; cursor: pointer;" class="fas fa-bell notification"></i>
                    <i v-if="notif == 1" @click="notif = 0" style="color: grey; cursor: pointer;" class="fas fa-bell notification"></i>

                    @endif

                    <!-- hidden notifications  -->

                    <span v-if="notif == 1" v-for="Recrutement in Recrutements" class="text-left">
                      <span v-for="condidat in Recrutement.id_condidats">
                        <a v-if="condidat.id == iding && Recrutement.valide == 0"><hr>
                         <span>Interview with <b>@{{ Recrutement.nom_entreprise }}</b> for <b>@{{ Recrutement.post }}</b> position</span><br>
                         <small>@{{ Recrutement.description }}</small>
                         <br>
                         <small>
                          <span v-for="x in Recrutement.id_condidats">
                            <span v-if="x.id == ing.id">
                              interview date : @{{ x.date_entretien }}<br>
                            </span>
                          </span>
                          time : @{{ Recrutement.duree_entretien }}
                        </small>
                        </a>

                        <a v-if="condidat.id == iding && Recrutement.valide == 1"><hr>
                         <b style="color: green">Congratulations !!!!!</b><br>
                         <small>Your interview with <b>@{{ Recrutement.nom_entreprise }}</b> has been <b>validated</b> for @{{ Recrutement.post }} position</small>
                        </a>
                      </span>
                    </span>


                  </div>
                </div>
              </div>


              <!-- contacts -->

              <div class="card mt-3">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Rate</h6>
                    <span class="text-secondary">{{ $cv->tarif }}<b> €/day</b></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">User</h6>
                    <span class="text-secondary">{{ $cv->post }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Email</h6>
                    <span class="text-secondary">{{ $cv->email }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Phone</h6>
                    <span class="text-secondary">{{ $cv->telephone }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Address</h6>
                    <span class="text-secondary">{{ $cv->adresse }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Age</h6>
                    <span class="text-secondary">{{ $cv->age }}</span>
                  </li>
                </ul>
              </div>

            </div>
            <div class="col-md-8">

              <!-- dispo -->

              @if(Auth::user()->post == "admin")
              <br>              
              <div v-if="ing.dispo == 0" class="row">
                <div class="col-md-6">
                  <h6 style="color: red; margin-left: 10px"><i style="margin-right: 6px" class="fas fa-circle"></i>Not available</h6>
                </div>
                <div class="col-md-6 text-right">
                 <span @click="make_Ing_Available(ing)" style="margin-right: 10px" class="btn btn-success btn-sm">Available</span>
                </div>
              </div>
              <div v-else>
                <div class="col-md-6">
                  <h6 style="color: green; margin-left: 10px"><i style="margin-right: 6px" class="fas fa-circle"></i>Available</h6>
                </div>
              </div>
              <br>
              @endif

              <!-- experiences -->

              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <h5>Experiences</h5>
                    </div>
                    @if(Auth::user()->post == "Entreprise")
                      <div class="col-md-6 text-right">
                       <span v-if="ing.add_to_cart == 0" @click="addtocart(ing)" class="btn btn-success btn-sm">Select</span>
                       <span v-if="ing.add_to_cart == 1" @click="deletefromcart(ing)" class="btn btn-danger btn-sm">Unselect</span>
                      </div>
                    @endif
                    @if(Auth::user()->id == $cv->id)
                    <div class="col-md-6 text-right">
                      <i class="fa fa-plus-square" v-if="open == 0" @click="open = 1"></i>
                      <i class="fa fa-chevron-circle-up" v-if="open == 1" @click="open = 0"></i>
                    </div>
                    @endif
                  </div>

                  <div v-if="open == 1">
                    <form>
                      {{ csrf_field() }}
                      <li  class="list-group-item">
                        <div class="form-group ">
                          <label for="">Title</label>
                          <input type="text" required="required"   class="form-control" v-model="experience.titre">
                        </div>

                        <div class="form-group">
                          <label for="">Description</label>
                          <textarea  class="form-control" required="required"  v-model="experience.commentaire"></textarea>
                        </div>
                        <div class="row">
                           <div class="col-md-4">
                             <label for="">location</label>
                             <input type="text" required="required" class="form-control"  v-model="experience.ville">
                           </div>
                        
                           <div class="col-md-4">
                             <label for="">Start date</label>
                             <input type="Date" required="required" class="form-control"  v-model="experience.debut">
                           </div>
                        
                        
                           <div class="col-md-4">
                             <label for="">Stop date</label>
                             <input type="Date" required="required" class="form-control" v-model="experience.fin">
                           </div>
                        </div>
                        <br>
                        <div class="form-group">
                          <span v-if="edit==1" class="form-control btn btn-danger btn-sm" @click="editExperience">Update</span>
                          <span v-else class="form-control btn btn-primary btn-sm" @click="addExperience">Add</span>
                        </div>
                      </li>
                    </form>
                  </div>

                  <dev v-for="experience in experiences">
                    <hr>
                    <div class="row">
                      <div class="col-md-12">
                         <h5>@{{ experience.titre }}</h5>
                         @{{ experience.commentaire }}
                         <small><br>location : @{{ experience.ville }}<br>@{{ experience.debut }} - @{{ experience.fin }}</small>
                         @if(Auth::user()->id == $cv->id)
                         <span @click="deleteExperience(experience)" style="float: right;font-size: 15px;color: red"><i class="fas fa-trash-alt"></i></span>
                        <span @click="edit_tmp_Experience(experience)" style="font-size: 15px;margin-right: 8px;float: right;" ><i class="fas fa-edit"></i></span>
                        @endif
                      </div>
                    </div>
                  </dev>

                </div>
              </div>


              <!-- formations -->

              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <h5>Formation</h5>
                    </div>
                    @if(Auth::user()->id == $cv->id)
                    <div class="col-md-6 text-right">
                      <i class="fa fa-plus-square" v-if="openformation == 0" @click="openformation = 1"></i>
                      <i class="fa fa-chevron-circle-up" v-if="openformation == 1" @click="openformation = 0"></i>
                    </div>
                    @endif
                  </div>
                  
                  <div v-if="openformation == 1">
                     <form>
                      {{ csrf_field() }}

                      <i style="float: right;size: 30px" class="fas fa-chevron-up"></i>
                      <li  class="list-group-item">
                        <div class="form-group ">
                          <label for="">Title</label>
                          <input type="text" required="required"  class="form-control" v-model="formation.titref">
                          
                        </div>

                        <div class="form-group">
                          <label for="">Description</label>
                          <textarea  class="form-control" required="required" v-model="formation.commentairef"></textarea>
                        
                        </div>
                        <div class="row">
                            

                               <div class="col-md-4">
                                 <label for="">location</label>
                                 <input type="text"  class="form-control" required="required" v-model="formation.villef">
                               </div>
                            
                               <div class="col-md-4">
                                 <label for="">Start date</label>
                                 <input type="Date"  class="form-control" required="required" v-model="formation.debutf">
                               </div>
                            
                            
                               <div class="col-md-4">
                                 <label for="">Stop Date</label>
                                 <input type="Date" class="form-control" required="required" v-model="formation.finf">
                               </div>
                        </div>
                        
                        <br>
                        <div class="form-group">
                          <span v-if="editformation == 1" class="form-control btn btn-danger btn-sm" @click="editFormation">Update</span>
                          <span v-else class="form-control btn btn-primary btn-sm" @click="addFormation">Add</span>
                        </div>
                      </li>
                    </form>
                  </div>

                  <dev v-for="formation in formations">
                    <hr>
                    <div class="row">
                      <div class="col-md-12">
                         <h5>@{{ formation.titref }}</h5>
                         @{{ formation.commentairef }}
                         <small><br>location : @{{ formation.villef }}<br>@{{ formation.debutf }} - @{{ formation.finf }}</small>
                         @if(Auth::user()->id == $cv->id)
                         <span @click="deleteFormation(formation)" style="float: right;font-size: 15px;color: red"><i class="fas fa-trash-alt"></i></span>
                        <span @click="edit_tmp_Formation(formation)" style="font-size: 15px;margin-right: 8px;float: right;" ><i class="fas fa-edit"></i></span>
                        @endif
                      </div>
                    </div>
                  </dev>


                </div>
              </div>


              <!-- skills  -->

              <div class="card mb-3">
                <div class="card-body">

                  <div class="row">
                    <div class="col-md-6">
                      <h5>Skills</h5>
                    </div>
                    @if(Auth::user()->id == $cv->id)
                    <div class="col-md-6 text-right">
                      <i class="fa fa-plus-square" v-if="opencompetence == 0" @click="opencompetence = 1"></i>
                      <i class="fa fa-chevron-circle-up" v-if="opencompetence == 1" @click="opencompetence = 0"></i>
                    </div>
                    @endif
                  </div>

                  <div v-if="opencompetence == 1">
                    <form>
                      {{ csrf_field() }}
                      <i style="float: right;size: 30px" class="fas fa-chevron-up"></i>
                      <li  class="list-group-item">
                    
                    <div class="form-group">
                      <label for=""></label>
                      <textarea  class="form-control" required="required" v-model="competence.commentaire"></textarea>
                    
                    </div>
                    <br>
                    <div class="form-group">
                      <span v-if="editcompetence==1" class="form-control btn btn-danger btn-sm" @click="editCompetence">Modifier</span>
                      <span v-else class="form-control btn btn-primary btn-sm" @click="addCompetence">Ajouter</span>
                    </div>
                      </li>
                    </form>
                  </div>

                  <dev v-for="competence in competences">
                    <hr>
                    <div class="row">
                      <div class="col-md-12">
                        @{{ competence.commentaire}}
                        @if(Auth::user()->id == $cv->id)
                        <br>
                        <span @click="deleteCompetence(competence)" style="float: right;font-size: 15px;color: red"><i class="fas fa-trash-alt"></i></span>
                        <span @click="edit_tmp_Competence(competence)" style="font-size: 15px;margin-right: 8px;float: right;" ><i class="fas fa-edit"></i></span>
                        @endif
                      </div>
                    </div>
                  </dev>

                </div>
              </div>

              
              </div>
            </div>
          </div>
        </div>
    </div>




<style type="text/css">

.main-body {
    padding: 15px;
}
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}

.gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}
.h-100 {
    height: 100%!important;
}
.shadow-none {
    box-shadow: none!important;
}






.dropbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 300px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}

</style>

@endsection


@section('javascripts')

<script src="{{ asset('js/vue.min.js') }}"></script>
<script src="{{ asset('https://unpkg.com/axios/dist/axios.min.js') }}"></script>
<script src="{{ asset('https://unpkg.com/jspdf@latest/dist/jspdf.min.js') }}"></script>
<script src="{{ asset('https://code.jquery.com/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js_pdf/html2canvas.min.js') }}"></script>

<script>
  window.Laravel ={!! json_encode([
      'csrfToken' => csrf_token(),
      'idcv' => $id,
      'url'   =>  url('/'),
      'ing' => $cv,
    ]) !!};
</script>

<script>
  
    var app = new Vue({
      el : '#app',
      data :{
        notif : '0',
        ing: window.Laravel.ing,
        theme:'1',
        open : '0',
        openformation: '0',
        opencompetence : '0',
        openloisir : '0',
        openlangue : '0',
        edit : '0',
        editformation: '0',
        editcompetence : '0',
        editloisire : '0',
        editlangue : '0',
        iding : window.Laravel.idcv,
        experiences: [],
        experience :{
          id:0,
          cv_id:window.Laravel.idcv,
          titre:'',
          commentaire:'',
          ville:'',
          debut:'',
          fin:''
        },

        EmptyExperience :{
          id:0,
          cv_id:window.Laravel.idcv,
          titre:'',
          commentaire:'',
          ville:'',
          debut:'',
          fin:''
        },

        formations: [],
        formation :{
          id:0,
          cv_id:window.Laravel.idcv,
          titref:'',
          commentairef:'',
          villef:'',
          debutf:'',
          finf:''
        },

        EmptyFormation :{
          id:0,
          cv_id:window.Laravel.idcv,
          titref:'',
          commentairef:'',
          villef:'',
          debutf:'',
          finf:''
        },

        competences: [],
        competence :{
          id:0,
          cv_id:window.Laravel.idcv,
          commentaire:''
        },

        EmptyCompetence :{
          id:0,
          cv_id:window.Laravel.idcv,
          commentaire:'',
        },

        Recrutements: [],
      },
      methods:{

        deleteExperience:function(experience){
          axios.delete(window.Laravel.url+"/deleteexperience/"+experience.id)
          .then(response =>{
            this.experiences = response.data.experiences;  
          })
          .then(error =>{
            console.log(error);
          })
        },
        deleteFormation:function(formation){
          axios.delete(window.Laravel.url+"/deleteformation/"+formation.id)
          .then(response =>{
            this.formations = response.data.formations;
          })
          .then(error =>{
            console.log(error);
          })
        },
        deleteCompetence:function(competence){
          axios.delete(window.Laravel.url+"/deletecompetence/"+competence.id)
          .then(response =>{
            this.competences = response.data.competences;
          })
          .then(error =>{
            console.log(error);
          })
        },




        
        edit_tmp_Experience:function(experience){
          this.open = 1;
          this.edit = 1;
          this.experience = experience;
        },
        editExperience: function(){
          axios.put(window.Laravel.url+"/editexperience",this.experience)
          .then(response =>{
            this.experiences = response.data.experiences;
            this.open = 0;
            this.edit = 0;
            this.experience = this.EmptyExperience;
          })
        },

        edit_tmp_Competence:function(competence){
          this.opencompetence = 1;
          this.editcompetence = 1;
          this.competence = competence;
        },
        editCompetence: function(){
          axios.put(window.Laravel.url+"/editcompetence",this.competence)
          .then(response =>{
            this.competences = response.data.competences;
            this.opencompetence = 0;
            this.editcompetence = 0;
            this.competence = this.EmptyCompetence;
          })
        },

        edit_tmp_Formation:function(formation){
          this.openformation = 1;
          this.editformation = 1;
          this.formation = formation;
        },
        editFormation: function(){
          axios.put(window.Laravel.url+"/editformation",this.formation)
          .then(response =>{
            this.formations = response.data.formations;
            this.openformation = 0;
            this.editformation = 0;
            this.formation = this.EmptyFormation;
          })
        },



        addExperience: function(){
          axios.post(window.Laravel.url+"/addexperience",this.experience)
          .then(response =>{
            this.experience.id = response.data.ide;
            this.experiences = response.data.experiences;
            this.experience = this.EmptyExperience;
          })  
        },
        addFormation: function(){
          axios.post(window.Laravel.url+"/addformation",this.formation)
          .then(response =>{
            this.formation.id = response.data.idf;
            this.formations = response.data.formations;
            this.formation = this.EmptyFormation;
          }) 
        },
        addCompetence: function(){
          axios.post(window.Laravel.url+"/addcompetence",this.competence)
          .then(response =>{
            this.competence.id = response.data.idc;
            this.competences = response.data.competences;
            this.competence = this.EmptyCompetence;
          }) 
        },


        getExperience: function(){
          axios.get(window.Laravel.url+"/getexperience/"+window.Laravel.idcv)
          .then(response => {
            this.experiences = response.data;
          })
          .catch(error => {
            console.log('errors: ',error);
          })
        },
        getFormation: function(){
          axios.get(window.Laravel.url+"/getformation/"+window.Laravel.idcv)
          .then(response => {
            this.formations = response.data;
          })
          .catch(error => {
            console.log('errors: ',error);
          })
        },
        getCompetence: function(){
          axios.get(window.Laravel.url+"/getcompetence/"+window.Laravel.idcv)
          .then(response => {
            this.competences = response.data;
          })
          .catch(error => {
            console.log('errors: ',error);
          })
        },





        getRecrutement: function(){
          axios.get(window.Laravel.url+"/getRecrutementIngenieur/"+window.Laravel.idcv)
          .then(response => {
            this.Recrutements = response.data;
            console.log(response.data);
          })
          .catch(error => {
            console.log('errors: ',error);
          })
        },


        addtocart(ing){
          axios.post(window.Laravel.url+'/addtocart',ing)
          .then(res => {
            console.log(res.data.ing);
            this.ing = res.data.ing;
          })
        },

        deletefromcart(ing){
          axios.post(window.Laravel.url+'/deletefromcart',ing)
          .then(res => {
            console.log(res.data.ing);
            this.ing = res.data.ing;
          })
        },

        make_Ing_Available(ing){
          axios.post(window.Laravel.url+'/makeIngAvailable',ing)
          .then(res => {
            console.log(res.data.ing);
            this.ing = res.data.ing;
          })
        },



      },
      created:function(){
        this.getExperience();
        this.getFormation();
        this.getCompetence();
        this.getRecrutement();
      },

    });


</script>

@endsection
