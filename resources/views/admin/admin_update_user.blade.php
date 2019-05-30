@extends('pages.admin.admin')

@section('admin')
    <h2>Menjaj korisnika:</h2>
    <hr>
        @isset($showKor)
        <form method="post" action="{{asset('/admin/user/update/'.$showKor->id_korisnik)}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <label>Trenutna uloga: {{$showKor->naziv}}</label> <br>
                <label>Nova uloga:</label>
                <select name="ddlUloga">
                    <option value="0">Izaberite</option>

                    @foreach($roles as $role)
                        <option value="{{ $role->id_uloga }}"> {{ $role->naziv }} </option>
                    @endforeach

                </select>
            </div>
            <div class="form-group">
                <label>Korisnicko ime:</label>
                <input type="text" name="korisnickoIme" class="form-control" value="{{$showKor->korisnicko_ime}}"/>
            </div>
            <div class="form-group">
                <label>Ime:</label>
                <input type="text" name="ime" class="form-control" value="{{$showKor->ime}}"/>
            </div>
            <div class="form-group">
                <label>Prezime:</label>
                <input type="text" name="prezime" class="form-control" value="{{$showKor->prezime}}"/>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" value="{{$showKor->email}}"/>
            </div>
            <div class="form-group">
                <label>Lozinka:</label>
                <input type="password" name="lozinka" class="form-control" value="{{$showKor->lozinka}}"/>
            </div>
            <div class="form-group">
                <label>Avatar:</label>
                <img src="{{asset($showKor->avatar)}}" width="150px" height="150px">
                <input type="file" name="avatar"/>
            </div>
            <div class="form-group">
                <input type="submit" name="updateUser" class="btn btn-info" value="Promeni korisnika"/>
                <a href="{{asset('/admin')}}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
        @endisset
@endsection