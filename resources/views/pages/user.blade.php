@extends('layout.frontLayout')

@section('title')
    User
@endsection

@section('content')

    @section('css')
        @parent
        <link rel="stylesheet" href="{{asset('/')}}css/hoverImage.css">
        
    @endsection
    
        @isset($showKor)    
        <h2>Your posts:</h2><hr>
            @if(count($showKor) == 0)
                <h3>You haven't posted yet.</h3>
            @else
                @foreach($showKor as $show)
                    <div class="overlay">
                        <img src="{{$show->putanja}}" alt="{{$show->alt}}" width="280px" height="180px" class="image"/>
                        <li class="middle"><a href="{{asset('/user/delete/'.$show->id_post)}}"><h2>Delete</h2></a></li>
                    </div>
                @endforeach
                <hr>
            @endif
        @endisset
        @isset($showAbout)
            <h2>Your profile:</h2>
            <table class="table">
                <thead>
                    <tr>
                        <td>Avatar:</td>
                        <td>Username:</td>
                        <td>Email:</td>
                        <td>Updated at:</td>
                        <td>Promeni:</td>
                    </tr>
                </thead>
                    <tr>
                        <td><img src="{{asset($showAbout->avatar)}}" width="150px" height="130px"/></td>
                        <td>{{$showAbout->korisnicko_ime}}</td>
                        <td>{{$showAbout->email}}</td>
                        <td>{{(isset($showAbout->updated_at)) ? date('d.m.Y', strtotime($showAbout->updated_at)) : 'nije menjan profil'}}</td>
                        <td><li><a href="{{asset('/user/show/'.$showAbout->id_korisnik)}}">Menjaj</a></li></td>
                    </tr>
            </table><hr>
        @endisset
            <h2>Upload post:</h2><hr>
            <form method="post" action="{{asset('/user/insert')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label>Naziv post-a:</label>
                    <input type="text" name="naziv" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Sika:</label>
                    <input type="file" name="slika"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="insertPost" class="btn btn-default" value="Unesi"/>
                </div>
            </form>
@endsection