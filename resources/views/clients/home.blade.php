@extends('clients.layout')

@section('content')
	<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('clients/images/bg_5.jpg') }}');">
		<div class="overlay"></div>
		<div class="container">
			<div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
				<div class="col-md-7 ftco-animate">
					<span class="subheading">Welcome to Pacific</span>
					<h1 class="mb-4">Cùng bạn khám phá những miền đất yêu thương</h1>
					<p class="caps">Khám phá muôn nơi, hành trình gọn gàng – trọn vẹn</p>
				</div>
				<a href="https://www.youtube.com/watch?v=Au6LqK1UH8g" class="icon-video popup-vimeo d-flex align-items-center justify-content-center mb-4">
					<span class="fa fa-play"></span>
				</a>
			</div>
		</div>
	</div>

	<section class="ftco-section ftco-no-pb ftco-no-pt">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="ftco-search d-flex justify-content-center">
						<div class="row">
							<div class="col-md-12 nav-link-wrap">
								<div class="nav nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
									<a class="nav-link active mr-md-1" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Search Tour</a>

									

								</div>
							</div>
							<div class="col-md-12 tab-wrap">
								
								<div class="tab-content" id="v-pills-tabContent">

									<div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-nextgen-tab">
										<form action="#" class="search-property-1">
											<div class="row no-gutters">
												<div class="col-md d-flex">
													<div class="form-group p-4 border-0">
														<label for="#">điểm đến</label>
														<div class="form-field">
															<div class="icon"><span class="fa fa-search"></span></div>
															<input type="text" class="form-control" placeholder="Search place">
														</div>
													</div>
												</div>
												<div class="col-md d-flex">
													<div class="form-group p-4">
														<label for="#">Ngày khởi hành</label>
														<div class="form-field">
															<div class="icon"><span class="fa fa-calendar"></span></div>
															<input type="text" class="form-control checkin_date" placeholder="Chọn ngày đi">
														</div>
													</div>
												</div>
												<div class="col-md d-flex">
													<div class="form-group p-4">
														<label for="#">Ngày kết thúc</label>
														<div class="form-field">
															<div class="icon"><span class="fa fa-calendar"></span></div>
															<input type="text" class="form-control checkout_date" placeholder="Chọn ngày về">
														</div>
													</div>
												</div>
												
												<div class="col-md d-flex">
													<div class="form-group d-flex w-100 border-0">
														<div class="form-field w-100 align-items-center d-flex">
															<input type="submit" value="Search" class="align-self-stretch form-control btn btn-primary">
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>

						
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="ftco-section services-section">
			<div class="container">
				<div class="row d-flex">
					<div class="col-md-6 order-md-last heading-section pl-md-5 ftco-animate d-flex align-items-center">
						<div class="w-100">
							<span class="subheading">Welcome to Pacific</span>
							<h2 class="mb-4">Lên đường để cảm nhận vẻ đẹp Việt Nam</h2>
							<p>Một con sông nhỏ hiền hòa uốn lượn qua làng, mang theo phù sa và hơi thở của đất trời, nuôi dưỡng cuộc sống nơi đây. Vùng đất ấy thanh bình như chốn thiên đường, nơi lời ăn tiếng nói mộc mạc, ấm áp, len lỏi vào lòng người một cách tự nhiên.</p>
							<p>Xa xa, vượt qua những dãy núi trùng điệp và những miền đất lạ, có một làng quê nép mình bên bờ biển tri thức bao la. Người dân sống chan hòa, gắn bó với thiên nhiên, với từng con chữ, từng câu chuyện được truyền lại qua bao thế hệ. Dòng sông quen thuộc vẫn lặng lẽ chảy, mang theo tinh hoa và nếp sống thuần Việt, bồi đắp cho tâm hồn con người nơi ấy.</p>
							
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
								<div class="services services-1 color-1 d-block img" style="background-image:  url('{{ asset('clients/images/services-1.jpg')}}');">
									<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-paragliding"></span></div>
									<div class="media-body">
										<h3 class="heading mb-3">Hoạt động trải nghiệm</h3>
										<p>Những hoạt động phong phú, được thiết kế phù hợp để mang đến cho bạn hành trình trọn vẹn và đáng nhớ.</p>
									</div>
								</div>      
							</div>
							<div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
								<div class="services services-1 color-2 d-block img" style="background-image:  url('{{ asset('clients/images/services-2.jpg')}}');">
									<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-route"></span></div>
									<div class="media-body">
										<h3 class="heading mb-3">Sắp xếp lịch trình</h3>
										<p>Chúng tôi lo trọn gói mọi khâu di chuyển và sắp xếp, giúp bạn yên tâm tận hưởng chuyến đi.</p>
									</div>
								</div>    
							</div>
							<div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
								<div class="services services-1 color-3 d-block img" style="background-image: url('{{ asset('clients/images/services-3.jpg')}}');">
									<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-tour-guide"></span></div>
									<div class="media-body">
										<h3 class="heading mb-3">Hướng dẫn viên riêng</h3>
										<p>Đồng hành cùng bạn là hướng dẫn viên tận tâm, am hiểu văn hóa – địa phương, mang đến trải nghiệm sâu sắc hơn.</p>
									</div>
								</div>      
							</div>
							<div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
								<div class="services services-1 color-4 d-block img" style="background-image:  url('{{ asset('clients/images/services-4.jpg')}}');">
									<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-map"></span></div>
									<div class="media-body">
										<h3 class="heading mb-3">Quản lý điểm đến</h3>
										<p>Đội ngũ chuyên trách hỗ trợ và điều phối tại điểm đến, đảm bảo chuyến đi diễn ra suôn sẻ và an toàn.</p>
									</div>
								</div>      
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="ftco-section img ftco-select-destination" style="background-image:  url('{{ asset('clients/images/bg_3.jpg')}}');">
			<div class="container">
				<div class="row justify-content-center pb-4">
					<div class="col-md-12 heading-section text-center ftco-animate">
						<span class="subheading">Pacific Provide Places</span>
						<h2 class="mb-4">Select Your Destination</h2>
					</div>
				</div>
			</div>
			<div class="container container-2">
				<div class="row">
					<div class="col-md-12">
						<div class="carousel-destination owl-carousel ftco-animate">
							<div class="item">
								<div class="project-destination">
									<a href="#" class="img" style="background-image:  url('{{ asset('clients/images/place-1.jpg')}}');">
										<div class="text">
											<h3>Đà Nẵng</h3>
											<span>8 Tours</span>
										</div>
									</a>
								</div>
							</div>
							<div class="item">
								<div class="project-destination">
									<a href="#" class="img" style="background-image:  url('{{ asset('clients/images/place-2.jpg')}}');">
										<div class="text">
											<h3>Ninh Bình</h3>
											<span>2 Tours</span>
										</div>
									</a>
								</div>
							</div>
							<div class="item">
								<div class="project-destination">
									<a href="#" class="img" style="background-image: url('{{ asset('clients/images/place-3.jpg')}}');">
										<div class="text">
											<h3>đà lạt</h3>
											<span>5 Tours</span>
										</div>
									</a>
								</div>
							</div>
							<div class="item">
								<div class="project-destination">
									<a href="#" class="img" style="background-image: url('{{ asset('clients/images/place-4.jpg')}}');">
										<div class="text">
											<h3>Hạ Long Bay</h3>
											<span>5 Tours</span>
										</div>
									</a>
								</div>
							</div>
							<div class="item">
								<div class="project-destination">
									<a href="#" class="img" style="background-image: url('{{ asset('clients/images/place-5.jpg')}}');">
										<div class="text">
											<h3>Quy Nhơn</h3>
											<span>7 Tours</span>
										</div>
									</a>
								</div>
							</div>
							<div class="item">
								<div class="project-destination">
									<a href="#" class="img" style="background-image: url('{{ asset('clients/images/place-6.jpg')}}');">
										<div class="text">
											<h3>Hội An</h3>
											<span>5 Tours</span>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center pb-4">
					<div class="col-md-12 heading-section text-center ftco-animate">
						<span class="subheading">Destination</span>
						<h2 class="mb-4">Tour Destination</h2>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 ftco-animate">
						<div class="project-wrap">
							<a href="#" class="img" style="background-image: url('{{ asset('clients/images/destination-1.jpg')}}');">
								<span class="price">$550/person</span>
							</a>
							<div class="text p-4">
								<span class="days">8 Days Tour</span>
								<h3><a href="#">Banaue Rice Terraces</a></h3>
								<p class="location"><span class="fa fa-map-marker"></span> Banaue, Ifugao, Philippines</p>
								<ul>
									<li><span class="flaticon-shower"></span>2</li>
									<li><span class="flaticon-king-size"></span>3</li>
									<li><span class="flaticon-mountains"></span>Near Mountain</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-4 ftco-animate">
						<div class="project-wrap">
							<a href="#" class="img" style="background-image: url('{{ asset('clients/images/destination-2.jpg')}}');">
								<span class="price">$550/person</span>
							</a>
							<div class="text p-4">
								<span class="days">10 Days Tour</span>
								<h3><a href="#">Banaue Rice Terraces</a></h3>
								<p class="location"><span class="fa fa-map-marker"></span> Banaue, Ifugao, Philippines</p>
								<ul>
									<li><span class="flaticon-shower"></span>2</li>
									<li><span class="flaticon-king-size"></span>3</li>
									<li><span class="flaticon-sun-umbrella"></span>Near Beach</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-4 ftco-animate">
						<div class="project-wrap">
							<a href="#" class="img" style="background-image: url('{{ asset('clients/images/destination-3.jpg')}}');">
								<span class="price">$550/person</span>
							</a>
							<div class="text p-4">
								<span class="days">7 Days Tour</span>
								<h3><a href="#">Banaue Rice Terraces</a></h3>
								<p class="location"><span class="fa fa-map-marker"></span> Banaue, Ifugao, Philippines</p>
								<ul>
									<li><span class="flaticon-shower"></span>2</li>
									<li><span class="flaticon-king-size"></span>3</li>
									<li><span class="flaticon-sun-umbrella"></span>Near Beach</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="col-md-4 ftco-animate">
						<div class="project-wrap">
							<a href="#" class="img" style="background-image: url('{{ asset('clients/images/destination-4.jpg')}}');">
								<span class="price">$550/person</span>
							</a>
							<div class="text p-4">
								<span class="days">8 Days Tour</span>
								<h3><a href="#">Banaue Rice Terraces</a></h3>
								<p class="location"><span class="fa fa-map-marker"></span> Banaue, Ifugao, Philippines</p>
								<ul>
									<li><span class="flaticon-shower"></span>2</li>
									<li><span class="flaticon-king-size"></span>3</li>
									<li><span class="flaticon-sun-umbrella"></span>Near Beach</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-4 ftco-animate">
						<div class="project-wrap">
							<a href="#" class="img" style="background-image: url('{{ asset('clients/images/destination-5.jpg')}}');">
								<span class="price">$550/person</span>
							</a>
							<div class="text p-4">
								<span class="days">10 Days Tour</span>
								<h3><a href="#">Banaue Rice Terraces</a></h3>
								<p class="location"><span class="fa fa-map-marker"></span> Banaue, Ifugao, Philippines</p>
								<ul>
									<li><span class="flaticon-shower"></span>2</li>
									<li><span class="flaticon-king-size"></span>3</li>
									<li><span class="flaticon-sun-umbrella"></span>Near Beach</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-4 ftco-animate">
						<div class="project-wrap">
							<a href="#" class="img" style="background-image: url('{{ asset('clients/images/destination-6.jpg')}}');">
								<span class="price">$550/person</span>
							</a>
							<div class="text p-4">
								<span class="days">7 Days Tour</span>
								<h3><a href="#">Banaue Rice Terraces</a></h3>
								<p class="location"><span class="fa fa-map-marker"></span> Banaue, Ifugao, Philippines</p>
								<ul>
									<li><span class="flaticon-shower"></span>2</li>
									<li><span class="flaticon-king-size"></span>3</li>
									<li><span class="flaticon-sun-umbrella"></span>Near Beach</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<section class="ftco-section ftco-about img"style="background-image: url('{{ asset('clients/images/bg_4.jpg')}}');">
			<div class="overlay"></div>
			<div class="container py-md-5">
				<div class="row py-md-5">
					<div class="col-md d-flex align-items-center justify-content-center">
						<a href="https://vimeo.com/45830194" class="icon-video popup-vimeo d-flex align-items-center justify-content-center mb-4">
							<span class="fa fa-play"></span>
						</a>
					</div>
				</div>
			</div>
		</section>

		<section class="ftco-section ftco-about ftco-no-pt img">
			<div class="container">
				<div class="row d-flex">
					<div class="col-md-12 about-intro">
						<div class="row">
							<div class="col-md-6 d-flex align-items-stretch">
								<div class="img d-flex w-100 align-items-center justify-content-center" style="background-image:url('{{ asset('clients/images/about-1.jpg')}}');">
								</div>
							</div>
							<div class="col-md-6 pl-md-5 py-5">
								<div class="row justify-content-start pb-3">
									<div class="col-md-12 heading-section ftco-animate">
										<span class="subheading">About Us</span>
										<h2 class="mb-4">Make Your Tour Memorable and Safe With Us</h2>
										<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
										<p><a href="#" class="btn btn-primary">Book Your Destination</a></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="ftco-section testimony-section bg-bottom" style="background-image: url('{{ asset('clients/images/bg_1.jpg')}}');">
			<div class="overlay"></div>
			<div class="container">
				<div class="row justify-content-center pb-4">
					<div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
						<span class="subheading">Testimonial</span>
						<h2 class="mb-4">Tourist Feedback</h2>
					</div>
				</div>
				<div class="row ftco-animate">
					<div class="col-md-12">
						<div class="carousel-testimony owl-carousel">
							<div class="item">
								<div class="testimony-wrap py-4">
									<div class="text">
										<p class="star">
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
										</p>
										<p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
										<div class="d-flex align-items-center">
											<div class="user-img" style="background-image: url('{{ asset('clients/images/person_1.jpg')}}')"></div>
											<div class="pl-3">
												<p class="name">Roger Scott</p>
												<span class="position">Marketing Manager</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="item">
								<div class="testimony-wrap py-4">
									<div class="text">
										<p class="star">
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
										</p>
										<p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
										<div class="d-flex align-items-center">
											<div class="user-img" style="background-image: url('{{ asset('clients/images/person_2.jpg')}}')"></div>
											<div class="pl-3">
												<p class="name">Roger Scott</p>
												<span class="position">Marketing Manager</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="item">
								<div class="testimony-wrap py-4">
									<div class="text">
										<p class="star">
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
										</p>
										<p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
										<div class="d-flex align-items-center">
											<div class="user-img" style="background-image: url('{{ asset('clients/images/person_3.jpg')}}')"></div>
											<div class="pl-3">
												<p class="name">Roger Scott</p>
												<span class="position">Marketing Manager</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="item">
								<div class="testimony-wrap py-4">
									<div class="text">
										<p class="star">
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
										</p>
										<p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
										<div class="d-flex align-items-center">
											<div class="user-img" style="background-image: url('{{ asset('clients/images/person_1.jpg')}}')"></div>
											<div class="pl-3">
												<p class="name">Roger Scott</p>
												<span class="position">Marketing Manager</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="item">
								<div class="testimony-wrap py-4">
									<div class="text">
										<p class="star">
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
											<span class="fa fa-star"></span>
										</p>
										<p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
										<div class="d-flex align-items-center">
											<div class="user-img" style="background-image: url('{{ asset('clients/images/person_2.jpg')}}')"></div>
											<div class="pl-3">
												<p class="name">Roger Scott</p>
												<span class="position">Marketing Manager</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>


		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center pb-4">
					<div class="col-md-12 heading-section text-center ftco-animate">
						<span class="subheading">Our Blog</span>
						<h2 class="mb-4">Recent Post</h2>
					</div>
				</div>
				<div class="row d-flex">
					<div class="col-md-4 d-flex ftco-animate">
						<div class="blog-entry justify-content-end">
							<a href="blog-single.html" class="block-20" style="background-image: url('{{ asset('clients/images/image_1.jpg')}}');">
							</a>
							<div class="text">
								<div class="d-flex align-items-center mb-4 topp">
									<div class="one">
										<span class="day">11</span>
									</div>
									<div class="two">
										<span class="yr">2020</span>
										<span class="mos">September</span>
									</div>
								</div>
								<h3 class="heading"><a href="#">Most Popular Place In This World</a></h3>
								<!-- <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p> -->
								<p><a href="#" class="btn btn-primary">Read more</a></p>
							</div>
						</div>
					</div>
					<div class="col-md-4 d-flex ftco-animate">
						<div class="blog-entry justify-content-end">
							<a href="blog-single.html" class="block-20" style="background-image: url('{{ asset('clients/images/image_2.jpg')}}');">
							</a>
							<div class="text">
								<div class="d-flex align-items-center mb-4 topp">
									<div class="one">
										<span class="day">11</span>
									</div>
									<div class="two">
										<span class="yr">2020</span>
										<span class="mos">September</span>
									</div>
								</div>
								<h3 class="heading"><a href="#">Most Popular Place In This World</a></h3>
								<!-- <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p> -->
								<p><a href="#" class="btn btn-primary">Read more</a></p>
							</div>
						</div>
					</div>
					<div class="col-md-4 d-flex ftco-animate">
						<div class="blog-entry">
							<a href="blog-single.html" class="block-20" style="background-image: url('{{ asset('clients/images/image_3.jpg')}}');">
							</a>
							<div class="text">
								<div class="d-flex align-items-center mb-4 topp">
									<div class="one">
										<span class="day">11</span>
									</div>
									<div class="two">
										<span class="yr">2020</span>
										<span class="mos">September</span>
									</div>
								</div>
								<h3 class="heading"><a href="#">Most Popular Place In This World</a></h3>
								<!-- <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p> -->
								<p><a href="#" class="btn btn-primary">Read more</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

@endsection