@extends('pages.admin.admin')

@section('admin')
    <h2>Unesi korisnika:</h2>
    <hr>
        <form method="post" action="{{asset('/admin/user/insert')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <label>Uloga:</label>
                <select name="ddlUloga">
                    <option value="0">Izaberite</option>

                    @foreach($roles as $role)
                        <option value="{{ $role->id_uloga }}"> {{ $role->naziv }} </option>
                    @endforeach

                </select>
            </div>
            <div class="form-group">
                <label>Korisnicko ime:</label>
                <input type="text" name="korisnickoIme" class="form-control" />
            </div>
            <div class="form-group">
                <label>Ime:</label>
                <input type="text" name="ime" class="form-control" />
            </div>
            <div class="form-group">
                <label>Prezime:</label>
                <input type="text" name="prezime" class="form-control" />
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" />
            </div>
            <div class="form-group">
                <label>Lozinka:</label>
                <input type="password" name="lozinka" class="form-control" />
            </div>
            <div class="form-group">
                <label>Avatar:</label>
                <input type="file" name="slika"/>
            </div>
            <div class="form-group">
                <input type="submit" name="insertUser" class="btn btn-default" value="Unesi korisnika"/>
            </div>
        </form>
@endsection