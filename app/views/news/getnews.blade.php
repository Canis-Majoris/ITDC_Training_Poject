    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">
    @if($attribute == 'author')
      <p class="authorpage"><span class="auth_name_highlight">{{{ $news->first()->author }}}`s</span> Profile Goes Here..</p>
      <hr/>
    @endif
      <!-- START THE FEATURETTES -->
      @foreach($news as $n)
      <div class="row featurette">
         <h2 class="featurette-heading"><a href="{{ URL::to('news/id/'.$n->id) }}" class="title_header_a">{{{ $n->title }}}</a></h2>
        <div class="col-md-7">
          <span>By <a href="{{ URL::to('news/author/'.$n->author) }}">{{{ $n->author }}}</a></span>
          <span class="pull-right">{{{ $n->inserted_at }}}</span>
          <p class="lead">{{{ $n->text }}}</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" alt="Generic placeholder image">
        </div>
      </div>
      @endforeach
      <!-- /END THE FEATURETTES -->


      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2014 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
      </footer>

    </div><!-- /.container -->