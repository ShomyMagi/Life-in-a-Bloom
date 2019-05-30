@extends('pages.admin.admin')

@section('admin')
    <div class='table-wrapper'>
	@if(count($polls) > 5)
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
            <th>Pitanje</th>
            <th>Aktivacija</th>
            <th>Kreirano</th>
            <th>Menjano</th>
            <th>Brisi</th>
            <th>Menjaj</th>
        </tr>
        </thead>
        <tbody>
            @foreach($polls as $p)
            <tr class="info">
                <td>{{$p->id_anketa}}</td>
                <td>{{$p->pitanje}}</td>
                <td>@if($p->active == 1)<p style="color:green;">ACTIVE</p> @else <a href="{{asset('/admin/poll/active/'.$p->id_anketa)}}">ACTIVATE</a>@endif</td>
                <td>{{$p->active}}</td>
                <td>{{date('d.m.Y', strtotime($p->created_at))}}</td>
                <td>{{(isset($p->updated_at)) ? date('d.m.Y', strtotime($p->updated_at)) : 'nije menjana anketa'}}</td>
                <td><li><a href="{{asset('/admin/poll/'.$p->id_anketa)}}">Brisi</a></li></td>
                <td><li><a href="{{asset('/admin/show/update/poll/'.$p->id_anketa)}}">Menjaj</a></li></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <li id="buttons"><a href="{{asset('/admin/show/insert/poll')}}" class="btn btn-info btn-block">Unesi novu anketu</a></li>
    </div>
@endsection