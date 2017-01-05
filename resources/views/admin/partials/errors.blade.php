<div class="row">
  <div class="col-lg-12">
    @if( !empty($errors->all()) )
      <div class="alert alert-dismissible alert-warning">
        <button type="button" class="close" data-dismiss="alert">×</button>
        @foreach($errors->all() as $error)
          <ul>
              <li>{{$error}}</li>
          </ul>
        @endforeach
      </div>
    @endif
  </div>
</div>
