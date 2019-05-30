@extends('pages.admin.admin')

@section('admin')
    <h2>Menjaj post:</h2>
    <hr>
        @isset($showPost)
        <form method="POST" action="{{asset('/admin/post/update/'.$showPost->id_post)}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <label>Naziv:</label>
                <input type="text" name="naslov" class="form-control" value="{{$showPost->naslov}}"/>
            </div>
            <div class="form-group">
                <label>Slika:</label>
                <img src="{{asset($showPost->putanja)}}" width="150px" height="150px">
                <input type="file" name="slika"/>
            </div>
            <div class="form-group">
                <input type="submit" name="updatePost" class="btn btn-info" value="Promeni post"/>
                <a href="{{asset('/admin/post')}}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
        @endisset
@endsection