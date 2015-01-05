<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">Dashboard</h1>

  <div class="row placeholders">
    <div class="col-xs-6 col-sm-3 placeholder">
      <img data-src="holder.js/200x200/auto/sky" class="img-responsive" alt="Generic placeholder thumbnail">
      <h4>Label</h4>
      <span class="text-muted">Something else</span>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
      <img data-src="holder.js/200x200/auto/vine" class="img-responsive" alt="Generic placeholder thumbnail">
      <h4>Label</h4>
      <span class="text-muted">Something else</span>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
      <img data-src="holder.js/200x200/auto/sky" class="img-responsive" alt="Generic placeholder thumbnail">
      <h4>Label</h4>
      <span class="text-muted">Something else</span>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
      <img data-src="holder.js/200x200/auto/vine" class="img-responsive" alt="Generic placeholder thumbnail">
      <h4>Label</h4>
      <span class="text-muted">Something else</span>
    </div>
  </div>

  <h2 class="sub-header">Section title</h2>
  <div class="table-responsive">
  
    <table class="table table-striped">
      <thead>
        <tr>
          <th></th>
          <th>Firstname</th>
          <th>Lastname</th>
          <th>Username</th>
          <th>Type</th>
        </tr>
      </thead>
      <tbody>
      {{{ $status_col = null }}}
      @foreach($users as $user)
        @if($user->type == 1)
          <? $type_col = 'stud' ?>
        @else 
          <? $type_col = 'teac' ?>
        @endif

        @if($user->status == 1)
          <? $status_col = 'act' ?>
        @else 
          <? $status_col = 'pas' ?>
        @endif

        @if($user->type == 1)
          <? $type = 'Administrator' ?>
        @else 
          <? $type = 'User' ?>
        @endif
        <tr>
          <td><i class="glyphicon glyphicon-minus {{{ $status_col }}}_cell"></i></td>
          <td>{{{ $user->firstname }}}</td>
          <td>{{{ $user->lastname }}}</td>
          <td>{{{ $user->username }}}</td>
          <td>{{{ $type }}}</td>
        </tr>
      @endforeach
      <? echo $users->links() ?>
      </tbody>
    </table>
  </div>
</div>