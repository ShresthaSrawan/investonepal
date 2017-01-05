<div class="row">
  <div class="col-lg-12">
    @if(Session::has('danger'))
      <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        {{Session::get('danger')}}
      </div>
    @elseif(Session::has('info'))
      <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-info"></i> Alert!</h4>
        {{Session::get('info')}}
      </div>
    @elseif(Session::has('warning'))
      <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Alert!</h4>
        {{Session::get('warning')}}
      </div>
    @elseif(Session::has('success'))
      <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4>	<i class="icon fa fa-check"></i> Alert!</h4>
        {{Session::get('success')}}
      </div>
    @endif
  </div>
</div>
