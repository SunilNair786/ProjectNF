<?php 
include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Fullscreen - Sidebar Menu</title>

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
					
		<!-- Font Awesome CSS -->
		<link href="css/font-awesome.min.css" rel="stylesheet">
		
		<!-- Simple Line Icons -->
		<link href="css/simple-line-icons.css" rel="stylesheet">
		
		<!-- google font -->
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
		
		<!-- owl-carousel -->
		<link href="plugins/owl.carousel.css" rel="stylesheet">
		<link href="plugins/owl.theme.css" rel="stylesheet">
		
		<!-- magnific-popup -->
		<link href="plugins/magnific-popup.css" rel="stylesheet">
		
		<!-- animate -->
		<link href="css/animate.css" rel="stylesheet">
		
		<!-- style -->
		<link href="css/style.css" rel="stylesheet">
		
	 

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="slider-background">
	
	
		<!-- Preloader -->
		<div id="preloader">
			<div id="status">&nbsp;</div>
		</div>
		<!-- ./Preloader -->
		
		<!-- pattern -->
		<div id="bg_pattern"></div>
		<!-- ./pattern -->
		
		<!-- scrollToTop -->	
		<a href="#" class="scrollToTop">
			<i class="fa fa-angle-up fa-2x"></i>
		</a>
		<!-- ./scrollToTop -->
		
		
		<!-- sidebar -->	
		<nav class="sidebar">
			
			<a class="logo" href="index.html">
				<img src="img/logo.png" alt="">
			</a>
			
			<a href="#" class="menu-toggle"><i class="fa fa-navicon"></i></a>
		
			<ul class="menu">
				<li><a data-scroll href="#services">Home</a></li>

				<li><a data-scroll href="#gallery">Gallery</a></li>
				<li><a data-scroll href="#portfolio">Portfolio</a></li>
				<li><a data-scroll href="#team">About Us</a></li>
				<li><a data-scroll href="#news">News</a></li>
				<li><a data-scroll href="#pricing">Pricing</a></li>
				<li><a data-scroll href="#testimonial">Testimonials</a></li>
				<li><a data-scroll href="#contact">Contact</a></li>	
			</ul>
						
		</nav>
		<!-- ./sidebar -->
		
		
		<!-- right-content -->
		<div class="right-content">
				
			<!-- slider-banner -->	
			<section id="slider-banner" class="section wow fadeInUp">
				<div class="container-fluid">										
					<!-- slider -->	
					<div id="slider" class="owl-carousel">
						<div class="item">	
							<i class="fa fa-mobile"></i>
							<h2>RESPONSIVE</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ullamcorper diam nec augue semper, in dignissim elit hendrerit. Quisque tempus arcu vulputate metus convallis elementum. Aenean rhoncus rutrum quam ut semper. </p>								
							<a href="#" class="btn btn-custom btn-lg">Learn More</a>											
						</div>	
						<div class="item">	
							<i class="icon-chemistry"></i>
							<h2>LOTS OF OPTIONS</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ullamcorper diam nec augue semper, in dignissim elit hendrerit. Quisque tempus arcu vulputate metus convallis elementum. Aenean rhoncus rutrum quam ut semper. </p>								
							<a href="#" class="btn btn-custom btn-lg">Learn More</a>											
						</div>
						<div class="item">	
							<i class="fa fa-support"></i>
							<h2>100% SUPPORT</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ullamcorper diam nec augue semper, in dignissim elit hendrerit. Quisque tempus arcu vulputate metus convallis elementum. Aenean rhoncus rutrum quam ut semper. </p>								
							<a href="#" class="btn btn-custom btn-lg">Learn More</a>											
						</div>

					</div>	
					<!-- ./slider -->						
				</div>		
			</section>
			<!-- ./slider-banner -->
		
		
			<!-- services -->
			<section id="services" class="section wow fadeInUp">
				<div class="container-fluid">	
				
					<div class="section-heading">
						<h2>Services</h2>
						<div class="separator"></div>	
					</div>
					
					<div class="row">
						<div class="col-md-4 col-sm-4">
							<div class="services style2">
								<i class="fa fa-android circle"></i>
								<h4>Android icon</h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing metus elit Quisque rutrum pellentesque imperdiet.</p>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="services style2">
								<i class="fa fa-apple circle"></i>
								<h4>Apple icon</h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing metus elit Quisque rutrum pellentesque imperdiet.</p>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="services style2">
								<i class="fa fa-windows circle"></i>
								<h4>windows icon</h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing metus elit Quisque rutrum pellentesque imperdiet.</p>
							</div>
						</div>
					</div><!-- ./row -->
					
					<div class="row">
						<div class="col-md-4 col-sm-4">
							<div class="services style2">
								<i class="fa fa-github circle"></i>
								<h4>github icon</h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing metus elit Quisque rutrum pellentesque imperdiet.</p>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="services style2">
								<i class="fa fa-foursquare circle"></i>
								<h4>foursquare icon</h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing metus elit Quisque rutrum pellentesque imperdiet.</p>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="services style2">
								<i class="fa fa-dropbox circle"></i>
								<h4>dropbox icon</h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing metus elit Quisque rutrum pellentesque imperdiet.</p>
							</div>
						</div>
					</div><!-- ./row -->
					
				</div>
			</section>
			<!-- ./services -->
			
			<!-- gallery -->
			<section id="gallery" class="section wow fadeInUp">
				<div class="container-fluid">	
				
					<div class="section-heading">
						<h2>Gallery</h2>
						<div class="separator"></div>	
					</div>
					
					<div class="row">
						<?php 
						$gallery_imgs = mysql_query("SELECT * FROM add_articles WHERE art_cat = '2'");
						while($gall_view = mysql_fetch_assoc($gallery_imgs))
						{							
						?>									
						<div class="col-md-3 col-sm-6">
							<div class="gallery">
								<figure><img src="article_image/<?php echo $gall_view['art_image']; ?>" alt="image" class="img-responsive"></figure>
								<div class="overlay">								
									<a class="info circle popup-link" href="article_image/<?php echo $gall_view['art_image']; ?>"><i class="fa fa-search"></i></a>
									<a class="info circle" data-toggle="modal" data-target="#modal-popup"><i class="fa fa-link"></i></a>
								</div>
							</div>
						</div>
						<?php } ?>
						
					</div><!-- ./row -->
																															
				</div>
			</section>
			<!-- ./gallery -->
			
			<!-- portfolio -->
			<section id="portfolio" class="section wow fadeInUp">
				<div class="container-fluid">
				
					<div class="section-heading">
						<h2>portfolio</h2>
						<div class="separator"></div>	
					</div>
				
					<div class="text-center padd-tb-10">
						<ul id="filter">
						  <li class="current"><a href="#">All</a></li>
						  	<?php 
							$portfo_cat = mysql_query("SELECT * FROM article_category WHERE art_id != '1'");
							while($portfo_view = mysql_fetch_assoc($portfo_cat))
							{							
							?>	
						  		<li><a href="#"><?php echo $portfo_view['art_name']; ?></a></li>
						  	<?php } ?>
						  
						</ul>
					</div>
					
					<div class="row">
						<ul id="portfolio-filter">									
						<?php 
						$portfo_gal = mysql_query("SELECT * FROM add_articles WHERE art_cat != '1'");
						while($portfo_gal_view = mysql_fetch_assoc($portfo_gal))
						{	
							$portfo_catname = mysql_fetch_assoc(mysql_query("SELECT * FROM article_category WHERE art_id = ".$portfo_gal_view['art_cat'].""));
						?>						  
							<li class="<?php echo strtolower($portfo_catname['art_name']);?> ">
								<div class="col-sm-6 col-md-3">	
									<div class="gallery">
										<figure><img src="article_image/<?php echo $portfo_gal_view['art_image']; ?>" alt="image" class="img-responsive"></figure>
										<div class="overlay">								
										<a class="info circle popup-link" href="article_image/<?php echo $portfo_gal_view['art_image']; ?>"><i class="fa fa-search"></i></a>
										<a class="info circle" data-toggle="modal" data-target="#modal-popup"><i class="fa fa-link"></i></a>
										</div>
									</div>
								</div> 
							</li>
						<?php } ?>
							
						</ul>  
					</div>
				
				</div><!-- ./container -->					

			</section>
			<!-- ./portfolio-->
			
			<!-- team -->
			<section id="team" class="section wow fadeInUp">
				<div class="container-fluid">
				
					<div class="section-heading">
						<h2>Our Team</h2>
						<div class="separator"></div>						
					</div>
					
					<div class="row">
						<div class="col-md-3 col-sm-6">
							<div class="team-box1">
								<img src="img/team1.jpg" alt="image" class="img-responsive">
								<h4>Jason Statam</h4>
								<span>CEO, Founder</span>
								<hr>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing metus elit Quisque rutrum pellentesque.</p>
								<ul class="social">
									<li><a href="#" class="circle"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#" class="circle"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#" class="circle"><i class="fa fa-google"></i></a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="team-box1">
								<img src="img/team2.jpg" alt="image" class="img-responsive">
								<h4>Mike Strong</h4>
								<span>Lead Designer</span>
								<hr>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing metus elit Quisque rutrum pellentesque.</p>
								<ul class="social">
									<li><a href="#" class="circle"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#" class="circle"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#" class="circle"><i class="fa fa-google"></i></a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="team-box1">
								<img src="img/team3.jpg" alt="image" class="img-responsive">
								<h4>Alden Richards</h4>
								<span>Backend Developer</span>
								<hr>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing metus elit Quisque rutrum pellentesque.</p>
								<ul class="social">
									<li><a href="#"	target="_blank" class="circle"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#" target="_blank" class="circle"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#" target="_blank" class="circle"><i class="fa fa-google"></i></a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="team-box1">
								<img src="img/team4.jpg" alt="image" class="img-responsive">
								<h4>Kevin Durant</h4>
								<span>Marketing Specialist</span>
								<hr>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing metus elit Quisque rutrum pellentesque.</p>
								<ul class="social">
									<li><a href="#" class="circle"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#" class="circle"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#" class="circle"><i class="fa fa-google"></i></a></li>
								</ul>
							</div>
						</div>
					</div><!-- ./row -->
				</div>
		
			</section>
			<!-- ./team -->
			
			<!-- news -->
			<section id="news" class="section wow fadeInUp">
				<div class="container-fluid">
				
					<div class="section-heading">
						<h2>News</h2>
						<div class="separator"></div>						
					</div>
					
					<!-- blog-carousel2 -->	
					<div id="blog-carousel2" class="owl-carousel">
						<div class="item">	
							<div class="blog-box2">
								<figure>
									<img src="img/img1.jpg" alt="image" class="img-responsive">
									<ul>
										<li><i class="fa fa-calendar"></i> <span>Jan 3, 2016</span></li>
										<li><i class="fa fa-comment"></i> <span>180</span></li>
									</ul>
								</figure>
								<h4>Snowy Forest</h4>
								<p> Lorem ipsum dolor sit amet Maecenas ullamcorper diam nec augue semper ...</p>		
								<a href="blog-single.html" class="link">Read more...</a>	
							</div>	
						</div>
						<div class="item">	
							<div class="blog-box2">
								<figure>
									<img src="img/img2.jpg" alt="image" class="img-responsive">
									<ul>
										<li><i class="fa fa-calendar"></i> <span>Feb 16, 2016</span></li>
										<li><i class="fa fa-comment"></i> <span>16</span></li>
									</ul>
								</figure>
								<h4>Nice View</h4>
								<p> Lorem ipsum dolor sit amet Maecenas ullamcorper diam nec augue semper ...</p>		
								<a href="blog-single.html" class="link">Read more...</a>	
							</div>	
						</div>
						<div class="item">	
							<div class="blog-box2">
								<figure>
									<img src="img/img3.jpg" alt="image" class="img-responsive">
									<ul>
										<li><i class="fa fa-calendar"></i> <span>March 8, 2016</span></li>
										<li><i class="fa fa-comment"></i> <span>280</span></li>
									</ul>
								</figure>
								<h4>Cool Waves</h4>
								<p> Lorem ipsum dolor sit amet Maecenas ullamcorper diam nec augue semper ...</p>		
								<a href="blog-single.html" class="link">Read more...</a>	
							</div>	
						</div>
						<div class="item">	
							<div class="blog-box2">
								<figure>
									<img src="img/img4.jpg" alt="image" class="img-responsive">
									<ul>
										<li><i class="fa fa-calendar"></i> <span>April 11, 2016</span></li>
										<li><i class="fa fa-comment"></i> <span>95</span></li>
									</ul>
								</figure>
								<h4>Plane View</h4>
								<p> Lorem ipsum dolor sit amet Maecenas ullamcorper diam nec augue semper ...</p>		
								<a href="blog-single.html" class="link">Read more...</a>	
							</div>	
						</div>
						<div class="item">	
							<div class="blog-box2">
								<figure>
									<img src="img/img5.jpg" alt="image" class="img-responsive">
									<ul>
										<li><i class="fa fa-calendar"></i> <span>May 18, 2016</span></li>
										<li><i class="fa fa-comment"></i> <span>35</span></li>
									</ul>
								</figure>
								<h4>Skie Rides</h4>
								<p> Lorem ipsum dolor sit amet Maecenas ullamcorper diam nec augue semper ...</p>		
								<a href="blog-single.html" class="link">Read more...</a>	
							</div>	
						</div>
							

					</div>	
					<!-- ./blog-carousel2 -->	
						
				</div>
					
			</section>
			<!-- ./news -->
			
			<!-- pricing -->
			<section id="pricing" class="section wow fadeInUp">
				<div class="container-fluid">
				
					<div class="section-heading">
						<h2>Pricing</h2>
						<div class="separator"></div>						
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<div class="price-box2">
								<h2>Beginner Savers</h2>
								<div class="separator"></div>
								<p>For people who are starting out in the water saving business</p>
								<div class="price">
									<span>$</span>19
									<div class="month">/ month</div>	
								</div>
								<ul>
									<li>Free water saving e-book</li>
									<li>Free access to forums</li>
									<li>Beginners tips</li>
								</ul>							
								<a href="#" class="btn btn-dark btn-lg btn-block">Choose Plan</a>							
							</div>
						</div>
						<div class="col-md-4">
							<div class="price-box2">
								<h2>Advanced Savers</h2>
								<div class="separator"></div>
								<p>For experienced water savers who'd like to push their limits</p>
								<div class="price">
									<span>$</span>29
									<div class="month">/ month</div>	
								</div>
								<ul>
									<li>Free water saving e-book</li>
									<li>Free access to forums</li>
									<li>Advanced saving tips</li>
								</ul>							
								<a href="#" class="btn btn-dark btn-lg btn-block">Choose Plan</a>							
							</div>
						</div>
						<div class="col-md-4">
							<div class="price-box2">
								<h2>Pro Savers</h2>
								<div class="separator"></div>
								<p>For all the professionals who'd like to educate others, too</p>
								<div class="price">
									<span>$</span>79
									<div class="month">/ month</div>	
								</div>
								<ul>
									<li>Access to all books</li>
									<li>Unlimited board topics</li>
									<li>Beginners tips</li>
								</ul>							
								<a href="#" class="btn btn-dark btn-lg btn-block">Choose Plan</a>							
							</div>
						</div>								
					</div><!-- ./row -->
						
				</div>
		
			</section>
			<!-- ./pricing -->
			
			<!-- testimonial -->	
			<section id="testimonial" class="section wow fadeInUp">
				<div class="container-fluid">	

					<div class="section-heading">
						<h2>Testimonials</h2>
						<div class="separator"></div>						
					</div>
					
					<!-- testimonial-carousel -->	
					<div id="testimonial-carousel" class="owl-carousel">
						<div class="item">	
							<div class="testimonial-box3">
								<p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ullamcorper diam nec augue semper, in dignissim elit hendrerit. Quisque tempus arcu vulputate metus convallis elementum. Aenean rhoncus rutrum quam ut semper. <i class="fa fa-quote-right"></i> </p>								
								<img src="img/team1.jpg" alt="image" class="img-responsive circle">	
								<p><span>Jane Doe</span>, CEO X Company</p>
							</div>	
						</div>
						<div class="item">	
							<div class="testimonial-box3">
								<p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ullamcorper diam nec augue semper, in dignissim elit hendrerit. Quisque tempus arcu vulputate metus convallis elementum. Aenean rhoncus rutrum quam ut semper. <i class="fa fa-quote-right"></i> </p>								
								<img src="img/team2.jpg" alt="image" class="img-responsive circle">	
								<p><span>James Smith</span>, Founder Y Company</p>
							</div>	
						</div>
						<div class="item">	
							<div class="testimonial-box3">
								<p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ullamcorper diam nec augue semper, in dignissim elit hendrerit. Quisque tempus arcu vulputate metus convallis elementum. Aenean rhoncus rutrum quam ut semper. <i class="fa fa-quote-right"></i> </p>								
								<img src="img/team3.jpg" alt="image" class="img-responsive circle">	
								<p><span>Erick White</span>, Writter Z Company</p>
							</div>	
						</div>

					</div>	
					<!-- ./testimonial-carousel -->					
				</div>	
			
			</section>
			<!-- ./testimonial-->
			
			<!-- contact -->
			<section id="contact" class="section wow fadeInUp">
				<div class="container-fluid">
				
					<div class="section-heading">
						<h2>Contact Us</h2>
						<div class="separator"></div>	
					</div>
					
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
						
							<!-- Working Contact Form -->
							<form  name="sentMessage" id="contactForm" novalidate>
								<div class="row">
									<div class="control-group form-group col-sm-6">
										<div class="controls">
											<label>Name</label>
											<input type="text" class="form-control dark" id="name" placeholder="" required data-validation-required-message="Please enter your name.">
											<p class="help-block"></p>
										</div>
									</div>
									<div class="control-group form-group col-sm-6">
										<div class="controls">
											<label>Email</label>
											<input type="email" class="form-control dark" id="email" placeholder="" required data-validation-required-message="Please enter your email address.">
											<p class="help-block"></p>
										</div>
									</div>
								</div>	
								<div class="control-group form-group">
									<div class="controls">
										<label>Message</label>
										<textarea class="form-control dark" rows="7" id="message" placeholder="" required data-validation-required-message="Please enter your message" maxlength="999" style="resize:none"></textarea>
										<p class="help-block"></p>
									</div>
								</div>
								<div id="success"></div>
								
								<div class="padd-tb-10">
									<button type="submit" class="btn btn-success btn-lg btn-block">Submit</button>
								</div>	
								
							</form>
							<div class="clearfix"></div>
							<!-- Working Contact Form -->
							
							<!-- contact-info -->
							<div class="row">
								<div class="col-md-4 col-sm-4">
									<div class="contact-info">			
										<i class="fa fa-map-marker"></i> Silicon Valley California, USA
									</div>
								</div>
								<div class="col-md-4 col-sm-4">
									<div class="contact-info">			
										<i class="fa fa-envelope-o"></i> Support@mysite.com
									</div>
								</div>
								<div class="col-md-4 col-sm-4">
									<div class="contact-info">			
										<i class="fa fa-phone"></i> (+93) 123 456 78
									</div>
								</div>
							</div>
							<!-- ./contact-info -->
							
						</div>
					</div>
				
				</div>
		
			</section>
			<!-- ./contact -->
			
			
			<!-- footer -->
			<footer id="footer">
				<div class="container-fluid">
					<ul class="list-inline">
						<li><a href="#"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#"><i class="fa fa-twitter"></i></a></li>
						<li><a href="#"><i class="fa fa-google"></i></a></li>
					</ul>
					<div class="copyright">&copy; 2016 Fullscreen | <a href="http://www.Bootstrapwizard.info" target="_blank">Bootstrapwizard</a></div>
				</div>
			</footer>
			<!-- ./footer -->

		</div>
		<!-- ./right-content -->
		
		 
	
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->		
		<script src="js/jquery-1.11.3.min.js"></script>	
		<script src="js/bootstrap.min.js"></script>
		
		<!-- smooth-scroll -->
		<script src="js/smooth-scroll.js"></script>
		
		<!-- backstretch -->
		<script src="js/backstretch.min.js"></script>
		
		<!-- owl-carousel -->
		<script src="js/owl.carousel.js"></script>
		
		<!-- wow -->
		<script src="js/wow.js"></script>
		
		<!-- typed -->
		<script src="js/typed.min.js"></script>
						
		<!-- magnific-popup -->
		<script src="js/jquery.magnific-popup.js"></script>
		
		<!-- jqBootstrapValidation -->
		<script src="js/jqBootstrapValidation.js"></script>
		
	 
					
		<!-- main js -->
		<script src="js/main.js"></script>
		
	</body>
</html>