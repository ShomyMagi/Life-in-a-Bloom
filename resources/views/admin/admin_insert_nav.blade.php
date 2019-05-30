@extends('pages.admin.admin')

@section('admin')
    <h2>Unesi meni:</h2>
    <hr>
        <form method="post" action="{{asset('/admin/nav/insert')}}">
            {{csrf_field()}}
            <div class="form-group">
                <label>Naziv:</label>
                <input type="text" name="naziv" class="form-control" />
            </div>
            <div class="form-group">
                <label>Putanja:</label>
                <input type="text" name="putanja" class="form-control" />
            </div>
            <div class="form-group">
                <input type="submit" name="insertMeni" class="btn btn-default" value="Unesi meni"/>
            </div>
        </form>
@endsection