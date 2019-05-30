@extends('layout.frontLayout')

@section('title')
    Post
@endsection

@section('content')
    <div class="col-md-8">   
          
        <h1 class="mt-4">{{ $singlePost->naslov }}</h1>


        <p class="lead">
          by
          <strong>{{ $singlePost->postKorisnik }}</strong>
        </p>

        <hr>


        <p>Posted on {{ date("F d, Y  H:i", strtotime($singlePost->created_at)) }}</p>

        <hr>
        
        <p>Views: {{$singlePost->views}}</p>
        
        <hr>

        <img class="img-fluid rounded" src="{{ asset($singlePost->putanja)}}" alt="{{ $singlePost->alt}}" width="750px">
        <h3 class="card-header">Comments:</h3>
        @foreach($singleComm as $comm)
            <div class="actionBox">
                <ul class="commentList">
                    <li>
                        <div class="commenterImage">
                            <img src="{{asset($comm->avatar)}}" width="15px"/>                           
                        </div>
                        <div class="commentText">
                            
                            <p>{{ $comm->tekst }}</p> <span class="date sub-text">on {{date("F d, Y  H:i", strtotime($comm->time))}}</span>
                        </div>
                    </li>
                </ul>
            @if(session()->has('user'))
                @if(session()->get('user')[0]->korisnicko_ime == $comm->korisnicko_ime )
                <a href="{{asset('/post/'.$onePost->id_post.'/delete/'.$comm->id_komentar)}}" class="del"><span class="glyphicon glyphicon-trash"></span></a>
                <a href="{{asset('/post/'.$onePost->id_post.'/'.$comm->id_komentar)}}" class="del"><span class="glyphicon glyphicon-edit"></span></a>
                @elseif(session()->get('user')[0]->id_uloga == 1)
                    <a href="{{asset('/post/'.$onePost->id_post.'/delete/'.$comm->id_komentar)}}" class="del"><span class="glyphicon glyphicon-trash"></span></a>
                    <a href="{{asset('/post/'.$onePost->id_post.'/'.$comm->id_komentar)}}" class="del"><span class="glyphicon glyphicon-edit"></span></a>
                @endif
            @endif
            </div>
        @endforeach
        @if(session()->has('user'))

            <div class="card my-4">
                <h5 class="card-header">{{isset($selectedComm) ? 'Change comment:' : 'Leave a Comment:'}}</h5>
                <div class="card-body">
                    <form method="post" action="{{ isset($selectedComm) ? asset('/post/'.$onePost->id_post.'/'.$selectedComm->id_komentar) : asset('/post/'.$onePost->id_post.'/comment')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                          <textarea class="form-control" rows="3" name="comment">{{ isset($selectedComm) ? $selectedComm->tekst : old('comment')}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-info">{{isset($selectedComm) ? 'Update comment' : 'Post comment'}}</button>
                        @if(isset($selectedComm))
                            <a href="{{asset('post/'.$onePost->id_post)}}" class="btn btn-danger">Cancel</a>
                        @endif
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection