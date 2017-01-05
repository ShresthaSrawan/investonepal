@extends('admin.master')

@section('specificheader')
<style type="text/css">
    table.table tr td{
        vertical-align: middle;
    }
</style>
@endsection

@section('title')
Market Index
@endsection

@section('content')
{!! Form::open(['route'=>'admin.marketIndex.store']) !!}
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-thumb-tack fa-fw"></i> Market Index :Add:</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-sm btn-flat" type="button" onclick="crawl()" data-toggle="modal" data-target="#crawlModal"><i class="fa fa-bug"></i> Crawl</button>
            <a class="btn btn-primary btn-sm btn-flat" href="{{route('admin.addFloorsheet')}}">
                <i class="fa fa-bug"></i> Crawl Floorsheet
            </a>
        </div>
    </div>
    <div class="box-body">
        @include('admin.partials.validation')
        <table class="table table-condensed" id="main-table">
            <thead>
                <tr>
                    <th>Index Type</th>
                    @foreach($previousIndex as $date => $v)
                        <th class="hidden-xs hidden-sm">{{$date}}</th>
                    @endforeach
                    <th>New Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach($indexType as $id=>$name)
                    <tr>
                        <th class="index-name">{{$name}}</th>
                        @foreach($previousIndex as $values)
                            <td class="hidden-xs hidden-sm">{{array_key_exists($name,$values) ? $values[$name] : 'NA'}}</td>
                        @endforeach
                        <td>
                            {!! Form::input('number','value['.$id.']',null,['step'=>'any','class'=>'form-control','placeholder'=>'Value','required'=>'required']) !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        <div class="row">
            <div class="col-xs-6">
            </div>
            <div class="col-xs-6">
                <div class="form-group">
					<span class="md-date-label">Insert Date</span>
                    <?php $date = (is_null(old('date'))) ? date('Y-m-d') : old('date'); ?>
                    <div class="input-group pull-right md-date-input">
                        {!! Form::input('date','date',$date,['class'=>'form-control']) !!}
                        <div class="input-group-btn">
                            {!! Form::submit('Create',['class'=>'btn btn-primary']) !!}
                        </div>
                    </div>
                    <span class="text-danger"><i>{{$errors->first('date')}}</i></span>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

<!-- Modal -->
<div class="modal fade in" id="crawlModal" tabindex="-1" role="dialog" aria-labelledby="crawlModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crawling...</h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 spinner" style="min-height: 200px;">
                    <div class="sk-cube-grid">
                        <div class="sk-cube sk-cube1"></div>
                        <div class="sk-cube sk-cube2"></div>
                        <div class="sk-cube sk-cube3"></div>
                        <div class="sk-cube sk-cube4"></div>
                        <div class="sk-cube sk-cube5"></div>
                        <div class="sk-cube sk-cube6"></div>
                        <div class="sk-cube sk-cube7"></div>
                        <div class="sk-cube sk-cube8"></div>
                        <div class="sk-cube sk-cube9"></div>
                        <h5>Loading</h5>
                    </div>
                </div>
                <span class="clearfix"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="crawl-apply-btn">Apply</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('endscript')
<script>
    var CRAWL_URL = '{{route('admin.marketIndex.crawl')}}';
    var $modal = $('#crawlModal');
    var SPINNER = $('.modal-body').html();
    var apply = false;
    function crawl(){
        $.post(CRAWL_URL,{},function(response){
            if(response.error == false){
                showData(response.data);
            }else{
                showMessage(response.message);
            }
        });
    }

    function showData(data)
    {
        $body = $modal.find('.modal-body');
        $modal.find('.modal-title').text('As of '+ data.date);
        var html = '<form name="crawled-data"><table class="table table-condensed"><thead><tr><th>Reference</th>';

        $.each(data.header,function(i,value){ html += '<th>'+value+'</th>'; });
        html += '</tr></thead><tbody>';
        console.log(getIndexList());
        $.each(getIndexList(),function(k,v){
            this.selected = makeSelectable($(v).text(),data.body);
            this.value = $(this.selected).find('option:selected').length == 1 ? $(this.selected).find('option:selected').val() : '';
            html += '<tr data-row="'+k+'">' +
                    '<th>'+ $(v).text()+'</th>' +
                    '<td>'+ this.selected+'</td>' +
                    '<td>'+ this.value +'</td>' +
                    '</tr>';
        });

        html += '</tbody></table></form>';

        $body.html(html);

        $(document).on('change','select[name*=selected]',function(){
            console.log($(this).parent());
            $(this).parent().next().text($(this).val());
        });

        $(document).on('click','#crawl-apply-btn',function(){
            var inputs = $('input[name*=value]');
            $('select[name*=selected]').each(function(i,select){
                var found = $(select).find('option:selected');
                $(inputs[i]).val(found.val());
            });
            $('input[name=date]').val(data.date);
            $('button[data-dismiss=modal]').click();
            $body.html(SPINNER);
        });
    }

    function matchString(string1, string2){
        string1 = string1.toLowerCase().replace('&','').replace(' ','').replace('.','');
        string2 = string2.toLowerCase().replace('&','').replace(' ','').replace('.','');

        return string1 == string2;
    }

    function getIndexList(){
        return $('th.index-name').each(function(i, v){
            return $(v).text();
        });
    }

    function makeSelectable(text,data){
        var self = this;
        this.selectBox = '<select name="selected[]" class="form-control input-sm"><option value="" data-value=""></option>';
        $.each(data,function(k,v){
            this.match = matchString(text,v[0]) ? 'selected' : '';
            self.selectBox += '<option value="'+v[1].replace(' ','')+'" '+this.match+'>'+v[0]+'</option>';
        });
        this.selectBox += '</select>';

        return this.selectBox;
    }
</script>
@endsection