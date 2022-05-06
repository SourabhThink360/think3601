@extends('master')

@section('content')

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Think 360</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link text-white"> Welcome: {{ ucfirst(Auth()->user()->first_name) }} </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('logout') }}"> Logout </a>
        </li>
      </ul>
    </div>

  </nav>
  <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
             @include('common.notifications')
        </div>
        <div class="col-md-2">
        </div>
</div>
       <div class="container-fluid text-center">
        <div class="card" style="width: 18rem;">
            <div class="card-header">
              User Info
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Name :{{ $userInfo['name'] ? $userInfo['name'] : '' }}  </li>
              <li class="list-group-item">Email : {{ $userInfo['email'] ? $userInfo['email'] : '' }}</li>
            </ul>
          </div>
        </div>
@endsection
