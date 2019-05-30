@extends('pages.admin.admin')

@section('admin')
    <h2>Menjaj anketu:</h2>
    <hr>
        @isset($showPoll)
        <form method="post" action="{{asset('/admin/poll/update/'.$showPoll[0]->idAnketa)}}">
            {{csrf_field()}}
            <div class="form-group">
                <label>Pitanje:</label>
                <input type="text" class="form-control" name='question' value='{{ $showPoll[0]->pitanje }}'>
            </div>
            <div class="form-group">
                <label>Odgovor 1:</label>
                <input type="text" class="form-control" name='response' value='{{ $showPoll[0]->odgovor }}'>
                <input type="text" class="form-control" value="{{$showPoll[0]->br_glasova}}" disabled=""/>
                <input type="hidden" name="odg" value="{{$showPoll[0]->idOdg}}"/>
            </div>
            <div class="form-group">
                <label>Odgovor 2:</label>
                <input type="text" class="form-control" name='response1' value='{{ $showPoll[1]->odgovor }}'>
                <input type="text" class="form-control" name='num1' value="{{$showPoll[1]->br_glasova}}" disabled=""/>
                <input type="hidden" name="odg1" value="{{$showPoll[1]->idOdg}}"/>
            </div>
            <div class="form-group">
                <input type="submit" name="updatePoll" class="btn btn-info" value="Promeni anketu"/>             
                <a href="{{asset('/admin/poll')}}" class="btn btn-danger">Cancel</a>             
            </div>
        </form>
        @endisset
@endsection