@extends('pages.admin.admin')

@section('admin')
    <h2>Unesi ulogu:</h2>
    <hr>
        <form method="post" action="{{asset('/admin/role/insert')}}">
            {{csrf_field()}}
            <div class="form-group">
                <label>Naziv uloge:</label>
                <input type="text" name="naziv" class="form-control" />
            </div>
            <div class="form-group">
                <input type="submit" name="insertRole" class="btn btn-default" value="Unesi ulogu"/>
            </div>
        </form>
@endsection