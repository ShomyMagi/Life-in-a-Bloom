@extends('pages.admin.admin')

@section('admin')
    <div class='table-wrapper'>
        @if(count($users) > 5)
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
                <th>Kor. ime</th>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Email</th>
                <th>Avatar</th>
                <th>Registrovan</th>
                <th>Menjao profil</th>
                <th>Uloga</th>
                <th>Brisi</th>
                <th>Menjaj</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="info">
                <td>{{$user->id_korisnik}}</td>
                <td>{{$user->korisnicko_ime}}</td>
                <td>{{$user->ime}}</td>
                <td>{{$user->prezime}}</td>
                <td>{{$user->email}}</td>
                <td><img src="{{asset($user->avatar)}}" width="150px" height="150px"></td>
                <td>{{date('d.m.Y', strtotime($user->registered_at))}}</td>
                <td>{{(isset($user->korUpdate)) ? date('d.m.Y', strtotime($user->korUpdate)) : 'nije menjan profil'}}</td>
                <td>{{$user->naziv}}</td>
                <td><li><a href="{{asset('/admin/user/'.$user->id_korisnik)}}">Brisi</a></li></td>
                <td><li><a href="{{asset('/admin/show/update/user/'.$user->id_korisnik)}}">Menjaj</a></li></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <li id="buttons"><a href="{{asset('/admin/show/insert/user')}}" class="btn btn-info btn-block">Unesi korisnika</a></li>
    </div>
@endsection