@extends('layouts.app')

@section('content')

   <br><br>

   <div class="container">
   	  <div class="row">

   	  		<div class="col-md-8">
            <li class="list-group-item" style="background-color: #f7f7f7">
              update profile informations
            </li>
            <li class="list-group-item ">
   	  			<form action="{{ url('cvs/'.$cv->id) }}" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="_method" value="PUT">
   	  				{{ csrf_field() }}
                 <br>
                    <div class="form-group row">                  
                      <label class="col-md-3 col-form-label text-md-right" for="">name</label>
                      <input type="text" name="name" required="required" class="form-control col-md-8" value="{{$cv->name}}">
                    </div>

                    <div class="form-group row">
                      <label class="col-md-3 col-form-label text-md-right" for="">title</label>
                      <input type="text" name="titre" required="required"  class="form-control col-md-8" value="{{$cv->titre}}">
                    </div>

                     <div class="form-group row">                  
                        <label class="col-md-3 col-form-label text-md-right" for="">description</label>
                        <textarea name="description" required="required" class="form-control col-md-8" rows="5">{{$cv->description}}</textarea>
                     </div>

                     <div class="row form-group ">
                        <label class="col-md-3 col-form-label text-md-right" for="">email</label>
                        <input type="text" name="email" required="required" class="form-control col-md-8" value="{{$cv->email}}">
                     </div>
               

                     <div class="row form-group ">
                        <label class="col-md-3 col-form-label text-md-right" for="">phone</label>
                        <input type="text" name="telephone" required="required" class="form-control col-md-8" value="{{$cv->telephone}}">
                     </div>

                     <div class="row form-group ">
                        <label class="col-md-3 col-form-label text-md-right" for="">address</label>
                        <input type="text" name="adresse" required="required" class="form-control col-md-8" value="{{$cv->adresse}}">
                     </div>

                     @if(Auth::user()->post == "Ingenieur")

                     <div class="row form-group ">
                        <label class="col-md-3 col-form-label text-md-right" for="">age</label>
                        <input type="text" name="age" required="required" class="form-control col-md-8" value="{{$cv->age}}">
                     </div>

                     @endif

                     @if(Auth::user()->post == "admin" && $cv->post == "Ingenieur")

                     <div class="row form-group ">
                        <label class="col-md-3 col-form-label text-md-right" for="">rate</label>
                        <input type="text" name="tarif" required="required" class="form-control col-md-8" value="{{$cv->tarif}}">
                     </div>

                     @endif
                     
                     <div class="form-group row">
                        <label class="col-md-3 col-form-label text-md-right" for="">Image</label><br>
                        <input class="btn btn-light col-md-8" type="file" name="photo"  value="{{$cv->image}}">
                        <br>
                     </div>
                     <br>
   	  				    <div class="form-group">
   	  					<input type="submit" name="" class="form-control btn btn-info" value="Update">
   	  				</div>
   	  			</form>  	  			
   	  		</div>


          <div id="appSubmitEdit" class="col-md-4">
            <li class="list-group-item" style="background-color: #f7f7f7">
              Update the Password
            </li>
            <li class="list-group-item ">
              <br>
              <div class="form-group row">                  
                <input type="password" required="required" class="form-control col-md-10 offset-md-1" v-model="cv.password" placeholder="New password">
              </div>
              <div class="form-group row">                  
                <input type="password" required="required" class="form-control col-md-10 offset-md-1" v-model="passwordconfirm" placeholder="Confirm password">
              </div>
              <dir>
                <small style="color: red;">@{{alertmessage}}</small>
                <small style="color: green;">@{{successmessage}}</small>
              </dir>
              <div>
                <span class="form-control btn btn-info" @click="update_password">Update</span>
              </div>
            </li>
          </div>


        </li>
   	  </div>
   </div>



@endsection


@section('javascripts')

<script src="{{ asset('js/vue.min.js') }}"></script>
<script src="{{ asset('https://unpkg.com/axios/dist/axios.min.js') }}"></script>


<script>
  window.Laravel ={!! json_encode([
      'csrfToken' => csrf_token(),
      'cv' => $cv,
      'url'   =>  url('/')
    ]) !!};
</script>

<script>
  
    var app = new Vue({
      el : '#appSubmitEdit',
      data :{
        cv: window.Laravel.cv,
        passwordconfirm : '',
        alertmessage: '',
        successmessage: '',
      },
      methods:{

        update_password: function() {
          
          if (this.cv.password != this.passwordconfirm) {
            this.successmessage = '';
            this.alertmessage = 'Passwords are not compatible';
            console.log(this.cv.password);

            return;
          }

          axios.post("/updatepassword",this.cv)
          .then(response =>{
            this.alertmessage = "";
            this.successmessage = 'your password has been changed successfully';
          })
          .then(error =>{
            console.log(error);
          })

        },


      },

    });


</script>

@endsection
