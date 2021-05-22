@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px">
      <table class="table">
        <thead>
          <tr>
            <th scope="col"></th>
            <th scope="col">name</th>
            <th class="text-center" scope="col">title</th>
            <th class="text-center" scope="col">email</th>
            <th class="text-right" scope="col">phone</th>
            <!-- <th scope="col" class="text-right">action</th> -->
          </tr>
        </thead>
        <tbody>
          @foreach($partners as $partner)
          <tr>
            <th scope="row"><img src="{{ asset('storage/'.$partner->image) }}" alt="Admin" class="rounded-circle" width="30"></th>
            <td>{{ $partner->name }}</td>
            <td class="text-center">{{ $partner->titre }}</td>
            <td class="text-center">{{ $partner->email }}</td>
            <td class="text-right">{{ $partner->telephone }}</td>
            <!-- <td class="text-right">
              <form method="post" action="#">   
               {{csrf_field()}}
               {{method_field('DELETE')}}
               <a href="#" style="font-size: 15px;margin-right: 5px; color: green"><i class="fas fa-eye"></i></a>
               <button type="submit" style="color: #d30707;font-size: 15px;background: none;border:none;outline: none;cursor: pointer;"><i class="fas fa-trash-alt"></i></button>
              </form>
            </td> -->
          </tr>
          @endforeach
        </tbody>
      </table>
</div>


@endsection
