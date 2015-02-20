@extends('layouts.home')
@section('home')
@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif

<!-- Main jumbotron for a primary marketing message or call to action -->
<div id="services">
    <div class="jumbotron">
    <div class="container">
        <div class="media">

            <div class="media-body">
                <div class="col-md-11">
                    <h1 class="title">ITDC <span>Freelancer</span></h1>

                    <p>Template Eden is a marketplace for all kind of template. If you need a fresh looking, valid and
                        highly optimized template for your site this is the right place to fill your need in best
                        possible way. </p>

                    <p><a class="btn btn-success btn-lg">Learn more <i class="icon icon-angle-right"></i></a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Example row of columns -->
    <div class="row features">
        <div class="col-lg-4 text-center">
            <div class="single-fet">
                <div>
                <span class="icon-stack icon-4x">
  <i class="icon-circle icon-stack-base"></i>
  <i class="icon-ok icon-light"></i>
</span>
                </div>
                <h2>With Bootstrap <span class="label label-warning">3.0</span></h2>

                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor
                    mauris
                    condimentum nibh, ut fermentum massa justo sit amet. </p>

            </div>
        </div>
        <div class="col-lg-4 text-center">
            <div class="single-fet">
                <div>
                <span class="icon-stack icon-4x">
  <i class="icon-circle icon-stack-base"></i>
  <i class="icon-laptop icon-light"></i>
</span>
                </div>
                <h2>Fully Responsive</h2>

                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor
                    mauris
                    condimentum nibh, ut fermentum massa justo sit amet. </p>

            </div>
        </div>
        <div class="col-lg-4 text-center">
            <div class="single-fet">
                <div>
                <span class="icon-stack icon-4x">
  <i class="icon-circle icon-stack-base"></i>
  <i class="icon-download-alt icon-light"></i>
</span>
                </div>
                <h2>And Totally <span style="color:#248822">Free</span></h2>

                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor
                    mauris
                    condimentum nibh, ut fermentum massa justo sit amet. </p>

            </div>
        </div>

    </div>


</div>
</div>



<section class="slider" id="features">
    <div class="container">
        <div class="inner-page">
            <h2 class="page-headline large text-center">Tell your projects awesome story.</h2>

            <p class="text-center">Tell your projects awesome story. Tell your projects awesome story. Tell your
                projects awesome story. Tell your projects awesome story.</p>
        </div>
        <div class="row inner-page">
            <div class="col-md-8 col-md-push-4 lazy-container loaded">
                <!--<img data-original="images/mockup.png" src="images/mockup.png" alt="Looks great on every device"-->
                <!--class="lazy">-->

                <h2>Our <strong>Features</strong></h2>

                <div class="row">
                    <div class="col-md-6">
                        <div class="feature-box">
                            <div class="feature-box-icon">
                                <i class="icon-group"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">Customer Support</h4>

                                <p class="tall">Lorem ipsum dolor sit amet, consectetur adip.</p>
                            </div>
                        </div>
                        <div class="feature-box">
                            <div class="feature-box-icon">
                                <i class="icon-file"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">HTML5 / CSS3 / JS</h4>

                                <p class="tall">Lorem ipsum dolor sit amet, adip.</p>
                            </div>
                        </div>
                        <div class="feature-box">
                            <div class="feature-box-icon">
                                <i class="icon-google-plus"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">500+ Google Fonts</h4>

                                <p class="tall">Lorem ipsum dolor sit amet, consectetur adip.</p>
                            </div>
                        </div>
                        <div class="feature-box">
                            <div class="feature-box-icon">
                                <i class="icon-adjust"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">Colors</h4>

                                <p class="tall">Lorem ipsum dolor sit amet, consectetur adip.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-box">
                            <div class="feature-box-icon">
                                <i class="icon-film"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">Sliders</h4>

                                <p class="tall">Lorem ipsum dolor sit amet, consectetur.</p>
                            </div>
                        </div>
                        <div class="feature-box">
                            <div class="feature-box-icon">
                                <i class="icon-magic small user"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">Icons</h4>

                                <p class="tall">Lorem ipsum dolor sit amet, consectetur adip.</p>
                            </div>
                        </div>
                        <div class="feature-box">
                            <div class="feature-box-icon">
                                <i class="icon-reorder"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">Buttons</h4>

                                <p class="tall">Lorem ipsum dolor sit, consectetur adip.</p>
                            </div>
                        </div>
                        <div class="feature-box">
                            <div class="feature-box-icon">
                                <i class="icon-desktop"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">Lightbox</h4>

                                <p class="tall">Lorem sit amet, consectetur adip.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4 col-md-pull-8">
                <div class="list-group">
                    <a href="#" class="list-group-item active">
                        <h4 class="list-group-item-heading">List group item heading</h4>

                        <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Fusce dapibus,
                            tellus ac cursus commodo, tortor </p>
                    </a>
                    <a href="#" class="list-group-item">
                        <h4 class="list-group-item-heading">List group item heading</h4>

                        <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Fusce dapibus,
                            tellus ac cursus commodo, tortor </p>
                    </a>
                    <a href="#" class="list-group-item">
                        <h4 class="list-group-item-heading">List group item heading</h4>

                        <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Fusce dapibus,
                            tellus ac cursus commodo, tortor </p>
                    </a>
                    <a href="#" class="list-group-item">
                        <h4 class="list-group-item-heading">List group item heading</h4>

                        <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Fusce dapibus,
                            tellus ac cursus commodo, tortor </p>
                    </a>

                </div>


            </div>
        </div>
    </div>
</section>

<section class="gray">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Tell your projects awesome story.</h3>
            </div>
        </div>
    </div>
</section>
<section class="about" id="clients">
    <div class="dmask">

        <div class="our-clients">
            <div class="container">
                <div class="row">
                    <div class="client" style="background-position: 50% 27px;">
                        <div class="client-logo">
                            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                                <div class="clients-title">
                                    <h3 class="title">Our <span>Clients</span></h3>

                                    <div class="carousel-controls pull-right">
                                        <a data-slide="prev" href="#client-carousel" class="prev btn-mini"><i
                                                class="icon-angle-left"></i></a>
                                        <a data-slide="next" href="#client-carousel" class="next btn-mini"><i
                                                class="icon-angle-right"></i></a>

                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="row">
                                    <div class="client-carousel slide" id="client-carousel">
                                        <div class="carousel-inner">
                                            <div class="item active">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 item animate_afc d1 animate_start">
                                                    <div class="item-inner"><a style="cursor: pointer;"><img
                                                            src="images/logo-1.png" alt="Upportdash"></a></div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 item animate_afc d2 animate_start">
                                                    <div class="item-inner"><a style="cursor: pointer;"><img
                                                            src="images/logo-2.png" alt="Upportdash"></a></div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 item animate_afc d3 animate_start">
                                                    <div class="item-inner"><a style="cursor: pointer;"><img
                                                            src="images/logo-3.png" alt="Upportdash"></a></div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 item animate_afc d4 animate_start">
                                                    <div class="item-inner"><a style="cursor: pointer;"><img
                                                            src="images/logo-4.png" alt="Upportdash"></a></div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 item">
                                                    <div class="item-inner"><a style="cursor: pointer;"><img
                                                            src="images/logo-5.png" alt="Upportdash"></a></div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 item">
                                                    <div class="item-inner"><a style="cursor: pointer;"><img
                                                            src="images/logo-4.png" alt="Upportdash"></a></div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 item">
                                                    <div class="item-inner"><a style="cursor: pointer;"><img
                                                            src="images/logo-3.png" alt="Upportdash"></a></div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 item">
                                                    <div class="item-inner"><a style="cursor: pointer;"><img
                                                            src="images/logo-2.png" alt="Upportdash"></a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <!-- Testimonials Widget Start -->
                                <div class="row ">
                                    <div class="testimonials widget">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="testimonials-title">
                                                <h3 class="title">Client <span>Testimonials</span></h3>

                                                <div class="carousel-controls pull-right">
                                                    <a data-slide="prev" href="#testimonials-carousel"
                                                       class="prev btn-mini"><i class="icon-angle-left"></i></a>
                                                    <a data-slide="next" href="#testimonials-carousel"
                                                       class="next btn-mini"><i class="icon-angle-right"></i></a>

                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="testimonials-carousel slide animate_afr d5 animate_start"
                                             id="testimonials-carousel">
                                            <div class="carousel-inner">
                                                <div class="item">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="testimonial item">
                                                            <p>
                                                                Lorem Ipsum is simply dummy text of the printing and
                                                                typesetting industry. Lorem Ipsum has been the
                                                                industry's standard dummy text ever since the 1500s,
                                                                when an unknown printer took a galley of type.
                                                            </p>

                                                            <div class="testimonials-arrow">
                                                            </div>
                                                            <div class="author">
                                                                <div class="testimonial-image "><img
                                                                        src="images/team-member-1.jpg" alt=""></div>
                                                                <div class="testimonial-author-info">
                                                                    <a style="cursor: pointer;">Monica Sing/a> Template
                                                                        Eden
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item active">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="testimonial item">
                                                            <p>
                                                                Lorem Ipsum is simply dummy text of the printing and
                                                                typesetting industry. Lorem Ipsum has been the
                                                                industry's standard dummy text ever since the 1500s,
                                                                when an unknown printer took a galley of type.
                                                            </p>

                                                            <div class="testimonials-arrow">
                                                            </div>
                                                            <div class="author">
                                                                <div class="testimonial-image "><img
                                                                        src="images/team-member-2.jpg" alt=""></div>
                                                                <div class="testimonial-author-info">
                                                                    <a href="#">John Doe</a> Template Eden
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="testimonial item">
                                                            <p>
                                                                Lorem Ipsum is simply dummy text of the printing and
                                                                typesetting industry. Lorem Ipsum has been the
                                                                industry's standard dummy text ever since the 1500s,
                                                                when an unknown printer took a galley of type.
                                                            </p>

                                                            <div class="testimonials-arrow">
                                                            </div>
                                                            <div class="author">
                                                                <div class="testimonial-image "><img
                                                                        src="images/team-member-3.jpg" alt=""></div>
                                                                <div class="testimonial-author-info">
                                                                    <a style="cursor: pointer;">Carol Johansen</a>
                                                                    Template Eden
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
</body>

@stop