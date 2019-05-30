@extends('pages.admin.admin')

@section('admin')
    <div class='table-wrapper'>
	@if(count($roles) > 5)
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
                <th>Napravljeno</th>
                <th>Menjano</th>
                <th>Brisi</th>
                <th>Menjaj</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr class="info">
                <td>{{$role->id_uloga}}</td>
                <td>{{$role->naziv}}</td>
                <td>{{date('d.m.Y', strtotime($role->created_at))}}</td>
                <td>{{(isset($role->updated_at)) ? date('d.m.Y', strtotime($role->updated_at)) : 'nije menjana uloga'}}</td>
                <td><li><a href="{{asset('/admin/role/'.$role->id_uloga)}}">Brisi</a></li></td>
                <td><li><a href="{{asset('/admin/show/update/role/'.$role->id_uloga)}}">Menjaj</a></li></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <li id="buttons"><a href="{{asset('/admin/show/insert/role')}}" class="btn btn-info btn-block">Unesi novu ulogu</a></li>
    </div>
@endsection