@extends('pages.admin.admin')

@section('admin')
    <h2>Menjaj meni u navigaciji:</h2>
    <hr>
        @isset($showNav)
        <form method="post" action="{{asset('/admin/nav/update/'.$showNav->id_navigacija)}}">
            {{csrf_field()}}
            <div class="form-group">
                <label>Naziv:</label>
                <input type="text" name="naziv" class="form-control" value="{{$showNav->naziv}}"/>
            </div>
            <div class="form-group">
                <label>Putanja:</label>
                <input type="text" name="putanja" class="form-control" value="{{$showNav->putanja}}"/>
            </div>
            <div class="form-group">
                <input type="submit" name="updateNavigation" class="btn btn-info" value="Promeni meni"/>             
                <a href="{{asset('/admin/navigation')}}" class="btn btn-danger">Cancel</a>             
            </div>
        </form>
        @endisset
@endsection