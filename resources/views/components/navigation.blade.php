<div id="fh5co-offcanvass">
		<a href="#" class="fh5co-offcanvass-close js-fh5co-offcanvass-close">Menu <i class="icon-cross"></i> </a>
		<h1 class="fh5co-logo"><a class="navbar-brand" href="{{asset('/')}}">Life in Bloom</a></h1>
		<ul>
            @if(session()->has('user'))
                @if(session()->get('user')[0]->naziv == 'admin')
                    @isset($admin)
                        @foreach($admin as $adm)
                    <li class="{{ Request::is($adm->putanja) ? 'active' : null }}"><a href="{{url($adm->putanja)}}">{{$adm->naziv}}</a></li>
                        @endforeach
                    @endisset
                @elseif(session()->get('user')[0]->naziv == 'user')
                    @isset($user)
                        @foreach($user as $u)
                    <li class="{{ Request::is($u->putanja) ? 'active' : null }}"><a href="{{url($u->putanja)}}">{{$u->naziv}}</a></li>
                        @endforeach
                    @endisset
                @endif
                @else
                    @isset($all)
                        @foreach($all as $a)
                        <li class="{{ Request::is($a->putanja) ? 'active' : null }}"><a href="{{url($a->putanja)}}">{{$a->naziv}}</a></li>
                        @endforeach
                    @endisset
            @endif
		</ul>
                @if(session()->has('user'))
                    Logged in as:&nbsp<strong>{{session()->get('user')[0]->korisnicko_ime}}</strong>
                @endif
		<h3 class="fh5co-lead">Connect with us</h3>
		<p class="fh5co-social-icons">
			<a href="#"><i class="icon-twitter"></i></a>
			<a href="#"><i class="icon-facebook"></i></a>
			<a href="#"><i class="icon-instagram"></i></a>
			<a href="#"><i class="icon-dribbble"></i></a>
			<a href="#"><i class="icon-youtube"></i></a>
		</p>
                
                <a href="{{asset('/download')}}"><h4>Dokumentacija</h4></a>
	</div>
	<header id="fh5co-header" role="banner">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<a href="#" class="fh5co-menu-btn js-fh5co-menu-btn">Menu <i class="icon-menu"></i></a>
                                        <a class="navbar-brand" href="{{asset('/')}}">Life in bloom</a>		
				</div>
			</div>
		</div>
	</header>