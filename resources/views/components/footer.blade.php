<footer id="fh5co-footer">
		
		<div class="container">
			<div class="row row-padded">
				<div class="col-md-12 text-center">
					<p class="fh5co-social-icons">
						<a href="#"><i class="icon-twitter"></i></a>
						<a href="#"><i class="icon-facebook"></i></a>
						<a href="#"><i class="icon-instagram"></i></a>
						<a href="#"><i class="icon-dribbble"></i></a>
						<a href="#"><i class="icon-youtube"></i></a>
					</p>
					<p><small>&copy; Hydrogen Free HTML5 Template. All Rights Reserved. <br>Designed by: <a href="http://freehtml5.co/" target="_blank">FREEHTML5.co</a> | Images by: <a href="http://pexels.com" target="_blank">Pexels</a></small></p>
                                        <p>Milos Simic 113/13</p>
				</div>
			</div>
		</div>
	</footer>

        @section('ajax')
	<!-- jQuery -->
	<script src="{{asset('/')}}js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="{{asset('/')}}js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="{{asset('/')}}js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="{{asset('/')}}js/jquery.waypoints.min.js"></script>
	<!-- Magnific Popup -->
	<script src="{{asset('/')}}js/jquery.magnific-popup.min.js"></script>
	<!-- Salvattore -->
	<script src="{{asset('/')}}js/salvattore.min.js"></script>
	<!-- Main JS -->
	<script src="{{asset('/')}}js/main.js"></script>
        <script src="{{asset('/')}}js/mine.js"></script>
        <script>
                const baseUrl = '{{asset("/")}}';
                const token = '{{csrf_token()}}';
        </script>
        @show