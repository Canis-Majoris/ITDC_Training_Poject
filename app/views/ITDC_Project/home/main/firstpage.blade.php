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

                    <p>This is very best freelancer site. It is recommended by Gugle, Gihub, Facebok and etc.. By this site you will become bilionair. </p>
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
            <h2 class="page-headline large text-center">Our projects awesome story.</h2>
        </div>
        <div class="row inner-page">
            <div class="col-md-10 col-md-offset-1 lazy-container loaded">
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
        </div>
    </div>
</section>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
</body>

@stop