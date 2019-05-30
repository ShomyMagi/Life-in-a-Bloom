@extends('layout.frontLayout')

@section('title')
    User update
@endsection

@section('content')

        <h2>Change profile:</h2>
        @isset($showUser)
            <form method="post" action="{{asset('/user/update/'.$showUser->id_korisnik)}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label>Username:</label>
                    <input type="text" name="korisnickoIme" class="form-control" value="{{$showUser->korisnicko_ime}}"/>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" value="{{$showUser->email}}"/>
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" value="{{$showUser->lozinka}}"/>
                </div>
                <div class="form-group">
                    <label>Avatar:</label>
                    <img src="{{asset($showUser->avatar)}}" width="150px" height="150px"/>
                    <input type="file" name="slika"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="updateUser" class="btn btn-default" value="Promeni"/>
                </div>
            </form>
        @endisset
@endsection