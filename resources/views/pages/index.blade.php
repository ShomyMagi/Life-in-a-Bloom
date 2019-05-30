@extends('layout.frontLayout')

@section('title')
    Home
@endsection

@section('content')
    <div id="fh5co-board" data-columns>
    @isset($posts)
        @foreach($posts as $post)
        	<div class="item">
                    <img src="{{asset($post->avatar)}}" width="20" height="15" alt="">
                    <span>{{$post->korisnicko_ime}}</span>
        		<div class="animate-box">
	        		<a href="{{asset('/post/'.$post->id_post)}}"><img src="{{asset($post->putanja)}}" alt="{{$post->alt}}"></a>
        		</div>
        		<div class="fh5co-desc">{{$post->naslov}}</div>
                        <div class="fh5co-desc">{{ date("F d, Y", strtotime($post->created_at)) }}</div>
        	</div>
        @endforeach
    </div>
    @endisset
@endsection