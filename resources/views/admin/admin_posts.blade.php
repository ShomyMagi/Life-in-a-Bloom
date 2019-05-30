@extends('pages.admin.admin')

@section('admin')
    <div class='table-wrapper'>
	@if(count($posts) > 5)
        <div class='wrapper-paging'>
          <ul>
            <li><a class='paging-back'><span class="glyphicon glyphicon-arrow-left"></span></a></li>
            <li><a class='paging-this'><strong>0</strong> of <span>x</span></a></li>
            <li><a class='paging-next'><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></a></li>
          </ul>
        </div>
        @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naziv</th>
                <th>Slika</th>
                <th>Korisnicko ime</th>
                <th>Postavljeno</th>
                <th>Menjano</th>
                <th>Brisi</th>
                <th>Menjaj</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr class="info">
                <td>{{$post->id_post}}</td>
                <td>{{$post->naslov}}</td>
                <td><img src="{{asset($post->putanja)}}" width="150px" height="150px"></td>
                <td>{{$post->korisnicko_ime}}</td>
                <td>{{date('d.m.Y H:i:s', strtotime($post->postCreated))}}</td>
                <td>{{(isset($post->postUpdated)) ? date('d.m.Y', strtotime($post->postUpdated)) : 'nije menjan post'}}</td>
                <td><li><a href="{{asset('/admin/post/'.$post->id_post)}}">Brisi</a></li></td>
                <td><li><a href="{{asset('/admin/show/update/post/'.$post->id_post)}}">Menjaj</a></li></td>
            </tr>
        </tbody>
        @endforeach
    </table>
    <li id="buttons"><a href="{{asset('/admin/show/insert/post')}}" class="btn btn-info btn-block">Unesi post</a></li>
    </div>
@endsection