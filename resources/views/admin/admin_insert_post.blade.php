@extends('pages.admin.admin')

@section('admin')
    <h2>Unesi post:</h2>
    <hr>
        <form method="post" action="{{asset('/admin/post/insert')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <label>Korisnik:</label>
                <select name="ddlKorisnik">
                    <option value="0">Izaberite</option>

                    @foreach($allUsers as $oneUser)
                        <option value="{{ $oneUser->id_korisnik }}"> {{ $oneUser->korisnicko_ime }} </option>
                    @endforeach

                </select>
            </div>
            <div class="form-group">
                <label>Naziv post-a:</label>
                <input type="text" name="naziv" class="form-control" />
            </div>
            <div class="form-group">
                <label>Slika:</label>
                <input type="file" name="slika"/>
            </div>
            <div class="form-group">
                <input type="submit" name="insertPost" class="btn btn-default" value="Unesi post"/>
            </div>
        </form>
@endsection