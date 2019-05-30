@extends('layout.frontLayout')

@section('title')
    About
@endsection

@section('content')
    @isset($me)
    <div class="col-md-8 col-md-offset-2">
        <h2>Personal Bio</h2>
        <div class="fh5co-spacer fh5co-spacer-sm"></div>
        <p><img src="{{asset($me->slika)}}" alt="{{$me->alt}}" class="img-rounded img-responsive"></p><hr>
        <p>{{$me->text}}</p><hr>
        @if(session()->has('user'))
        <div id="aboutAnketa" class="aboutAnketa"></div>
        <input type='hidden' value='{{session()->get('user')[0]->id_korisnik}}' id='idUser'></input>
        @isset($rez)
            <input type='hidden' value='1' id='postoji'></input>
        @else
            <input type='hidden' value='0' id='postoji'></input>
        @endisset
        <div id="feedback"></div>
        @endif
    </div>
    @endisset
    
    @section('ajax')
        @parent
        <script src="{{asset('/')}}js/ajax.js"></script>
    @endsection
@endsection