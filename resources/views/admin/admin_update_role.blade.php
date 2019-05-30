@extends('pages.admin.admin')

@section('admin')
    <h2>Menjaj ulogu:</h2>
    <hr>
        @isset($showRole)
        <form method="post" action="{{asset('/admin/role/update/'.$showRole->id_uloga)}}">
            {{csrf_field()}}
            <div class="form-group">
                <label>Naziv:</label>
                <input type="text" name="naziv" class="form-control" value="{{$showRole->naziv}}"/>
            </div>
            <div class="form-group">
                <input type="submit" name="updateRole" class="btn btn-info" value="Promeni ulogu"/>
                <a href="{{asset('/admin/role')}}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
        @endisset
@endsection