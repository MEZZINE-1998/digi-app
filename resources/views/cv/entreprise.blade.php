@extends('layouts.app')

@section('content')

<div id="app" class="container" style="margin-top: 20px">
    <div class="main-body">
    
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="{{ asset('storage/'.$user->image) }}" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4>{{ $user->name }}</h4>
                      <b style="color: black">{{ $user->titre }}</b><br>
                      <small class="text-muted font-size-sm">{{ $user->description }}</small>
                    </div>
                    <div>
                      <br>
                      @if(Auth::user())
                      <a href="{{url('user/'.$user->id.'/edit')}}" style="color: green">Update your profile !</a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>

              <!-- contacts -->

              <div class="card mt-3">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">User</h6>
                    <span class="text-secondary">{{ $user->post }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Email</h6>
                    <span class="text-secondary">{{ $user->email }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Phone</h6>
                    <span class="text-secondary">{{ $user->telephone }}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Address</h6>
                    <span class="text-secondary">{{ $user->adresse }}</span>
                  </li>
                </ul>
              </div>

            </div>
            <div class="col-md-8">

              <!-- Recrutement -->

              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <h5>Recruitments</h5>
                    </div>
                    @if(Auth::user()->id == $user->id)
                    <div class="col-md-6 text-right">
                      <i class="fa fa-plus-square" v-if="open == 0" @click="open = 1"></i>
                      <i class="fa fa-chevron-circle-up" v-if="open == 1" @click="open = 0, edit = 0"></i>
                    </div>
                    @endif
                  </div>

                  <div v-if="open == 1">
                    <form>
                      {{ csrf_field() }}
                      <li class="list-group-item" v-if="edit==0">
                        <p>Step 1 : Select ingineers abd make dates for interview</p>
                        
                        <!-- list of selected ings -->
                        <span v-for="inger in Recrutement.ings" class="table">
                          <div class="row" style="margin-bottom: 10px">
                            <div class="col-md-4">
                              @{{ inger.name }}
                            </div>
                            <div class="col-md-8">
                              <input v-model="inger.date_entretien" type="datetime-local" required="required" class="form-control">
                            </div>
                          </div>
                        </span>
                        <a href="{{url('cvs')}}">Add more ingineers !!!</a><br><br>
                      </li>

                      <li class="list-group-item" v-if="edit==1">
                        <p>Step 1 : interview dates for selected engineers</p>
                        
                        <!-- list of ings to edit -->
                        <span v-for="inger in Recrutement.id_condidats" class="table">
                          <div class="row" style="margin-bottom: 10px">
                            <div class="col-md-4">
                              @{{ inger.name }}
                            </div>
                            <div class="col-md-8">
                              <input v-model="inger.date_entretien" type="datetime-local" required="required" class="form-control">
                            </div>
                          </div>
                        </span>
                      </li>


                      <li  class="list-group-item">
                        <p>Step 2 : more information</p>
                        <div class="form-group ">
                          <label for="">Role</label>
                          <input type="text" required="required"   class="form-control" v-model="Recrutement.post">
                        </div>

                        <div class="form-group">
                          <label for="">Description</label>
                          <textarea  class="form-control" required="required"  v-model="Recrutement.description"></textarea>
                        </div>
                        <div class="row">  
                          <div class="col-md-6">
                             <label for="">interview time (per candidate)</label>
                             <input type="time" required="required" class="form-control" v-model="Recrutement.duree_entretien">
                           </div>                      
                        
                           <div class="col-md-6">
                             <label for="">Validation date</label>
                             <input type="datetime-local" required="required" class="form-control" v-model="Recrutement.date_validation">
                           </div>
                        </div>
                        <br>
                        <div class="form-group">
                          <span v-if="edit==1" class="form-control btn btn-danger btn-sm" @click="editRecrutement">Update</span>
                          <span v-else class="form-control btn btn-primary btn-sm" @click="addRecrutement">Add</span>
                        </div>
                      </li>
                    </form>
                  </div>

                  <dev v-for="Recrutement in Recrutements">
                    <hr>
                    <div class="row">
                      <div class="col-md-12">
                         <b>@{{ Recrutement.post }}</b><br>
                         <small>@{{ Recrutement.description }}</small>
                         <br><br>

                         <b>interviews</b>
                         <div v-for="condidat in Recrutement.id_condidats">
                           <b>@{{ condidat.name }}</b>
                           <small style="margin-left: 10px">@{{ condidat.date_entretien }}</small>
                           <small style="margin-left: 10px">@{{ Recrutement.duree_entretien }} (time)</small><br>
                         </div><br>

                         <b>Validation</b>
                           <br>
                           <dev v-for="condidat in Recrutement.id_condidats">
                            <span v-if="Recrutement.valide == 0">
                              <i  v-if="list_condidats_id.includes(condidat.id)" @click="reverse_reply_click(condidat)" style="color: green; float: right;" class="fas fa-check-circle"> selected</i>
                              <i v-else :id="condidat.id" @click="reply_click(condidat)" style="color: grey; float: right;" class="far fa-circle"> unselected</i>
                            </span>
                              @{{ condidat.name }}<br>
                           </dev>
                           <small v-if="Recrutement.valide == 0">
                            <span @click="send_validated_condidats(Recrutement)" class="send_valid">click here</span> to validate checked candidates
                           </small>

                         <br><br>
                         <small style="color: red">
                          Validation deadline : @{{ Recrutement.date_validation }}

                          <!-- appel de la methode validation condidats -->
                          <span v-if="Recrutement.valide == 0">
                            @{{ valid_condidats(Recrutement.date_validation, Recrutement.post) }}
                          </span>

                         </small>
                         @if(Auth::user()->id == $user->id)
                          
                          <span @click="deleteRecrutement(Recrutement)" style="float: right;font-size: 15px;color: red"><i class="fas fa-trash-alt"></i></span>
                          <span @click="edit_tmp_Recrutement(Recrutement)" style="font-size: 15px;margin-right: 8px;float: right;" ><i class="fas fa-edit"></i></span>
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

.send_valid{
  background-color: #d1e2f0;
  color:  #426480;
  padding: 0 10px;
  border:1px solid black;
  border-radius: 10px;
  margin: 0 6px 0 0;
  font-size: 14px;
  cursor: pointer;
}

.valid{
  background-color: #ddffdd;
  color:  #4a874b;
  padding: 1px 8px;
  border:1px solid black;
  border-radius: 10px;
  margin-right: 15px;
  font-size: 11px;
  cursor: pointer;
}

.invalid{
  background-color: #e8e8e8;
  color: #636363;
  padding: 1px 8px;
  border:1px solid black;
  border-radius: 10px;
  margin-right: 15px;
  font-size: 11px;
  cursor: pointer;
}

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
      'iduser' => $id,
      'ings' => $ings,
      'nom_entreprise' => $nom_entreprise,
      'url'   =>  url('/')
    ]) !!};
</script>

<script>
  
    var app = new Vue({
      el : '#app',
      data :{
        theme:'1',
        open : '0',
        edit : '0',
        validDone: '0',
        list_condidats_id: [],
        final_ings: [],
        Recrutements: [],
        Recrutement :{
          id:0,
          user_id:window.Laravel.iduser,
          nom_entreprise:window.Laravel.nom_entreprise,
          ings : window.Laravel.ings,
          post:'',
          description:'',
          duree_entretien: '',
          date_validation:'',
        },
        EmptyRecrutement :{
          id:'',
          user_id:window.Laravel.iduser,
          nom_entreprise:window.Laravel.nom_entreprise,
          ings : [],
          post:'',
          description:'',
          duree_entretien: '',
          date_validation:'',
        },
      },
      methods:{

        deleteRecrutement:function(Recrutement){
          axios.delete(window.Laravel.url+"/deleteRecrutement/"+Recrutement.id)
          .then(response =>{
            this.Recrutements = response.data.Recrutements;
          })
          .then(error =>{
            console.log(error);
          })
        },


        
        edit_tmp_Recrutement:function(Recrutement){
          this.open = 1;
          this.edit = 1;
          this.Recrutement = Recrutement;
        },
        editRecrutement: function(){
          axios.put(window.Laravel.url+"/editRecrutement",this.Recrutement)
          .then(response =>{
            this.Recrutement.id = response.data.ide;
            this.Recrutements = response.data.Recrutements;
            this.edit = 0;
            this.open = 0;
            this.Recrutement = this.EmptyRecrutement;
            console.log(this.Recrutement);
          })
        },


        addRecrutement: function(){
          axios.post(window.Laravel.url+"/addRecrutement",this.Recrutement)
          .then(response =>{
            this.Recrutement.id = response.data.idr;
            this.Recrutements = response.data.Recrutements;
            this.open = 0;
            this.Recrutement = this.EmptyRecrutement;
          })
          .catch(error => {
            console.log('errors: ',error);
          })
        },

        getRecrutement: function(){
          axios.get(window.Laravel.url+"/getRecrutement/"+window.Laravel.iduser)
          .then(response => {
            this.Recrutements = response.data;
          })
          .catch(error => {
            console.log('errors: ',error);
          })
        },

        // onSubmit(e) {
        //   const n = this.Recrutement.ings.length;
          
        //   if (n == 0) {
        //     e.preventDefault();
        //     alert('allez chercher vos ingénieurs');
        //     return;
        //   }
        // },

        valid_condidats(date_validation, post){

          // send notification to Entreprise --> missing validation condidats.
          var actual_time = new Date(); 
          var t = date_validation.split(/[- :]/);
          var date_vali = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3]-1, t[4], t[5]));

          if(date_vali < actual_time){
            Swal.fire({
              title: 'validation condidats',
              text: 'The validation date for candidates for position ' + post + " has passed" ,
            })
          }

        },

        reply_click(condidat){
          this.list_condidats_id.push(parseInt(event.srcElement.id));
          this.final_ings.push(condidat);
          console.log(this.list_condidats_id);
          // console.log(this.final_ings);
        },


        reverse_reply_click(condidat){
          var index = this.list_condidats_id.indexOf(condidat.id);
          if (index > -1) {
            this.list_condidats_id.splice(index, 1);
          }

          index = this.final_ings.indexOf(condidat);
          if (index > -1) {
            this.final_ings.splice(index, 1);
          }

          console.log(this.list_condidats_id);
        
        },



        send_validated_condidats:function(Recrutement){
          this.validDone = 1;
          axios.post(window.Laravel.url+"/editDispoIngs", {RecrutementId : Recrutement.id, final_ings: this.final_ings, list_condidats_id: this.list_condidats_id})
          .then(response =>{
            console.log(response.data);
            this.Recrutements = response.data.Recrutements;
            this.list_condidats_id =[];
            this.final_ings = [];
          })
        }, 

      },


      created:function(){
        this.getRecrutement();       
      },




    });

</script>

@endsection
