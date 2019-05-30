@extends('pages.admin.admin')

@section('admin')
    <div class='table-wrapper'>
	@if(count($allNav) > 5)
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
            <th>Putanja</th>
            <th>Napravljeno</th>
            <th>Menjano</th>
            <th>Brisi</th>
            <th>Menjaj</th>
        </tr>
        </thead>
        <tbody>
            @foreach($allNav as $n)
            <tr class="info">
                <td>{{$n->id_navigacija}}</td>
                <td>{{$n->naziv}}</td>
                <td>{{$n->putanja}}</td>
                <td>{{date('d.m.Y', strtotime($n->created_at))}}</td>
                <td>{{(isset($n->updated_at)) ? date('d.m.Y', strtotime($n->updated_at)) : 'nije menjan meni'}}</td>
                <td><li><a href="{{asset('/admin/nav/'.$n->id_navigacija)}}">Brisi</a></li></td>
                <td><li><a href="{{asset('/admin/show/update/nav/'.$n->id_navigacija)}}">Menjaj</a></li></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <li id="buttons"><a href="{{asset('/admin/show/insert/navigation')}}" class="btn btn-info btn-block">Unesi novi meni</a></li>
    </div>
@endsection