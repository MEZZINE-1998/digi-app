@extends('layouts.app')

@section('content')

<div id="app" style="margin-top: 20px; width: 90%; margin-left: 5%">
    <div class="main-body">
    
          <div class="row gutters-sm">
            <div class="col-md-3 mb-3">
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
                      <a href="{{url('admin/'.$user->id.'/edit')}}" style="color: green">Update your profile !</a>
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


            <!-- Recrutement -->

            <div class="col-md-6">
              <div class="card mb-3">
                <div class="card-body">
                  <h5>Recruitments</h5>

                  <dev v-for="Recrutement in Recrutements">
                    <hr>
                    <div class="row">
                      <div class="col-md-12">
                         <b>@{{ Recrutement.nom_entreprise }} | @{{ Recrutement.post }}</b><br>
                         <small>@{{ Recrutement.description }}</small>
                         <br><br>
                         <small>Interview </small>

                         <div v-for="condidat in Recrutement.id_condidats">
                           <b>@{{ condidat.name }}</b>
                           <small style="margin-left: 10px">@{{ condidat.date_entretien }}</small>
                           <small style="margin-left: 10px">@{{ Recrutement.duree_entretien }} (duration)</small>
                           @{{ finEntretien(condidat, Recrutement) }}
                           <small>
                             <span v-if="condidat.fin_entretien == 1" class="entretien_termine">interview completed</span>
                             <span v-else class="entretien_encore">Ongoing</span>
                            </small>
                          <br>
                         </div><br>

                         <small>
                          Validation deadline : @{{ Recrutement.date_validation }}
                          <span v-if="Recrutement.valide == 1" class="entretien_termine"> Onboarding validated</span>
                          <span v-else class="entretien_encore"> Onboarding not validated</span>
                         </small>
                      </div>
                    </div>
                  </dev>
                </div>
              </div>
              </div>

              <!-- requests -->

            <div class="col-md-3 mb-3">
              <div class="card">
                <div class="card-body">
                  <h5>Requests</h5>
                  <div v-for="Demande in Demandes">
                    <hr>
                    <b>@{{Demande.nom_entreprise}}</b><br>
                    <small>@{{Demande.commentaire}}</small>
                    <br>
                    <small>created at @{{Demande.created_at}}</small>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
  </div>




<style type="text/css">

.entretien_termine{
  background-color: #ddffdd;
  color:  #4a874b;
  padding: 2px 8px;
  border:1px solid black;
  border-radius: 10px;
  margin-left: 10px;
}

.entretien_encore{
  background-color: #ffdddd;
  color: #914949;
  padding: 2px 8px;
  border:1px solid black;
  border-radius: 10px;
  margin-left: 10px;
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
        fin_entretien: '0',
        Recrutements: [],
        Demandes: [],
      },
      methods:{

        getRecrutement: function(){
          axios.get(window.Laravel.url+"/getRecrutementAdmin/"+window.Laravel.iduser)
          .then(response => {
            this.Recrutements = response.data.Recrutements;
            this.Demandes = response.data.Demandes;
          })
          .catch(error => {
            console.log('errors: ',error);
          })
        },

        finEntretien(condidat, recrutement){

          var actual_time = new Date(); 

          var t = condidat.date_entretien.split(/[- T :]/);
          var date_entr = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4]));

          var t2 = recrutement.duree_entretien.split(/[:]/);
          var date_fin = date_entr;

          date_fin.setHours(date_entr.getHours() + parseInt(t2[0]) + date_entr.getTimezoneOffset()/60);
          date_fin.setMinutes(date_entr.getMinutes() + parseInt(t2[1]));
          date_fin.setSeconds(date_entr.getSeconds() + parseInt(t2[2]));

          console.log("date fin"+date_entr);

          console.log('------------------------')

          if (date_fin.getTime() < actual_time.getTime()) {
            condidat.fin_entretien = 1;

          }

        },

      },
      created:function(){
        this.getRecrutement();
      },

    });


</script>

@endsection
