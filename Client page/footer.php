		
		<footer class="footer_section">
			<div class="container">
				<div class="row">
					<div class="col-md-6 xs-padding">
						<div class="copyright">
							© 
							<script type="text/javascript"> 
								document.write(new Date().getFullYear())
							</script>
							Barber Shop Powered by Amaury de Guillebon
						</div>
					</div>
					<div class="col-md-6 xs-padding">
						<ul class="footer_social">
							<li><a href="#">Orders</a></li>
							<li><a href="#">Terms</a></li>
							<li><a href="#">Report Problem</a></li>
						</ul>
					</div>
				</div>
			</div>
		</footer>

	
		<!-- INCLUDE JS SCRIPTS -->
			
		<script>
			$('#appointment_form').submit(function() {
				
				document.getElementsByClassName('loadingGif').style.display = "flex";
				setTimeout(function() {
				document.getElementsByClassName('loadingGif').style.display = "none";
				},2000);
			});

		</script>
		<script src="Design/js/loading.js"></script>
		<script src="Design/js/jquery.min.js"></script>
		<script src="Design/js/bootstrap.min.js"></script>
		<script src="Design/js/bootstrap.bundle.min.js"></script>
		<script src="Design/js/main.js"></script>


	</body>

	<!-- END BODY TAG -->

</html>

<!-- END HTML TAG -->