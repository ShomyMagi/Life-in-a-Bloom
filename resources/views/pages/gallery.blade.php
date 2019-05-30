@extends('layout.frontLayout')

@section('title')
    Gallery
@endsection

@section('content')
    
    @isset($slike)
            <h2>Gallery</h2>
            <div class="fh5co-spacer fh5co-spacer-sm"></div>
            @foreach($slike as $slika)
            <a href="{{asset($slika->putanja)}}" class="image-popup fh5co-board-img"><img src="{{asset($slika->putanja)}}" alt="{{$slika->alt}}" width="350px" height="300px"></a>
            @endforeach
    @endisset
@endsection