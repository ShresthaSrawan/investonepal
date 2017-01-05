@extends('admin.master')

@section('title')
Todays Price
@endsection

@section('content')
{!! Form::open() !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Todays Price :List:</h3>
        <div class="box-tools pull-right">  
                <div class="form-group">    
                    <div class="input-group">   
                            {!! Form::input('date','date',$latestDate,['class'=>'form-control mydate','style'=>'width: 200px;float: right;']) !!}
                            <div class="input-group-btn">   
                                <a href="{{route('admin.todaysPrice',$latestDate)}}" class="form-control btn btn-primary go" value="GO">GO</a>
                            </div>
                        </div>
                </div>
        </div>     
    </div>
    <div class="box-body">	
    	<table class="table table-hover table-condensed datatable">
            <thead>
            <tr>
                <th>S.N.</th>
                <th>Company</th>
                <th>No. of Transaction</th>
                <th>Max Price</th>
                <th>Min Price</th>
                <th>Opening Price</th>
                <th>Closing Price</th>
                <th>Traded Shares</th>
                <th>Amount</th>
                <th>Previous Closing</th>
                <th>Difference</th>
                <th>% Change</th>
            </tr>
            </thead>
            <?php $sn = 1 ?>
            @foreach($data as $todaysPrice)
            <tr>
                <td>{{$sn}}</td>
                <td>{{$todaysPrice['company']['name']}}</td>
                <td>{{$todaysPrice['tran_count']}}</td>
                <td>{{$todaysPrice["high"]}}</td>
                <td>{{$todaysPrice["low"]}}</td>
                <td>{{$todaysPrice["open"]}}</td>
                <td>{{$todaysPrice["close"]}}</td>
                <td>{{$todaysPrice["volume"]}}</td>
                <td>{{$todaysPrice["amount"]}}</td>
                <td>{{$todaysPrice["previous"]}}</td>
                <td>{{$todaysPrice["close"]-$todaysPrice["previous"]}}</td>
                <td><?php if($todaysPrice["previous"]!=0){echo number_format((float)(($todaysPrice["close"]-$todaysPrice["previous"])*100)/$todaysPrice["previous"],2,'.','');}else{echo "N/A";} ?></td>
            </tr>
            <?php $sn++;?>
            @endforeach
        </table>
    </div>	
</div>
{!! Form::close() !!}
@endsection
@section('endscript')
<script type="text/javascript">
    $('.mydate').on('blur',function(){
        newDate = $(this).val().replace(/-/g,'/');
        address = "{{route('admin.todaysPrice')}}";
        $('a.go').attr('href',address+'/'+newDate);
    });
</script>
@endsection