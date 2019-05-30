@extends('pages.admin.admin')

@section('admin')
    <h2>Unesi anketu:</h2>
    <hr>
        <form method="post" action="{{asset('/admin/poll/insert')}}">
            {{csrf_field()}}
            <div class="form-group">
                <label>Anketa:</label>
                <input type="text" class="form-control" name='question'>
            </div>
            <div class="form-group">
                <label>Odgovor 1:</label>
                <input type="text" class="form-control" name='response'>
            </div>
            <div class="form-group">
                <label>Odgovor 2:</label>
                <input type="text" class="form-control" name='response1'>
            </div>
            <div class="form-group">
                <input type="submit" name="insertPoll" class="btn btn-default" value="Unesi anketu"/>
            </div>
        </form>
@endsection