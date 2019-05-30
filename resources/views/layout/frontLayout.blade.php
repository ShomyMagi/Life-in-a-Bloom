<!DOCTYPE html>
    @include('components.header')
    <body>
        @include('components.navigation')
        @empty(!session('success'))
        <div class="alert alert-success fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong> {{ session('success') }} </strong> </div>
        @endempty

        @empty(!session('error'))
        <div class="alert alert-danger fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong> {{ session('error') }} </strong> </div>
        @endempty

        @isset($errors)

        <div class="errors">
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong> {{ $error }} </strong> </div>
                @endforeach
            @endif
        </div>

        @endisset
	<div id="fh5co-main">
		<div class="container">

			<div class="row">
                                                        
                            @yield('content')
                                                       
                        </div>
                </div>
	</div>
        @include('components.footer')
    </body>
</html>