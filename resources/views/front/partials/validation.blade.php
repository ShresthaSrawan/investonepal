@if(!empty($errors->all()))
<div class="alert alert-validation alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
    <h4><i class="icon fa fa-warning"></i> Invaid Input!</h4>
    <ul>
        <?php $dumpErrors = []; ?>
        @foreach($errors->all() as $pos=>$error)
            @if(!in_array($error,$dumpErrors))
                <li>{{$error}}</li>
                <?php $dumpErrors[] = $error; ?>
            @endif
        @endforeach
    </ul>
</div>
@endif