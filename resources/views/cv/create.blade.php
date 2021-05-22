@extends('layouts.app')

@section('content')


 <br><br>

<div class="container" id="appSubmit">
      <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-10">

              <li class="list-group-item" style="background-color: #f7f7f7">
                  create new account
              </li>
              <li class="list-group-item ">
            <form @submit="onSubmit" action="{{ url('cvs') }}" method="post" enctype="multipart/form-data">

              {{ csrf_field() }}
                    <br>
                     
                     <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="post" class="col-md-4 col-form-label text-md-right">{{ __('Post') }}</label>

                            <div class="col-md-6">
                                <input id="post" list="browsers" type="post" class="form-control @error('post') is-invalid @enderror" name="post" value="{{ old('post') }}" required>
                                <datalist id="browsers">
                                  <option value="Admin">Administrator</option>
                                  <option value="Ingenieur">Engineer</option>
                                  <option value="Entreprise">Partner</option>
                                </datalist>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" v-model="password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" v-model="passwordconfirm">
                            </div>
                        </div>
                       

                        <br><br>


                       <!-- <div class="form-group row">
                          <label class="col-md-5 col-form-label text-md-right" for="">Image</label><br>
                          <input @click="image" class="btn btn-light col-md-6" required="required" type="file" name="photo">
                          <br>
                       </div>
                      <br>  --> 
               
              <div style="background-color: #a8deb5" class="form-group">
                <input  type="submit" name="" class="form-control btn btn-primary" value="Enregistrer">
              </div>
            </form>
              </li> 
      

               
   	  		</div>
   	  </div>
   </div>

@endsection


@section('javascripts')

<script src="{{ asset('js/vue.min.js') }}"></script>

<script>
  
    var app = new Vue({
      el : '#appSubmit',
      data :{
        password: '',
        passwordconfirm : '',
      },
      methods:{

        onSubmit(e) {
          
          if (this.password != this.passwordconfirm) {
            e.preventDefault();
            alert('Passwords are not compatible');
            return;
          }
        },


      },

    });


</script>

@endsection
