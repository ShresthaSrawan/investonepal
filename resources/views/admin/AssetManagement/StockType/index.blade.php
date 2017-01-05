@extends('admin.master')

@section('title')
    Asset Management: Stock Type
@endsection

@section('specificheader')
    <style>
        .expand-transition {
            transition: all .3s ease;
            overflow: hidden;
        }
        .expand-enter, .expand-leave {
            height: 0;
            padding: 0 10px;
            opacity: 0;
        }
        .table .form-group{
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')
    <div class="box box-info hide" id="stock-type-app">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bullhorn fa-fw"></i> Asset Management <small>:Stock Type:</small></h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div v-if="response.hasOwnProperty('message')" class="alert alert-@{{response.type}} alert-dismissible fade in" role="alert" transition="expand">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="response = {}"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <i class="fa @{{response.icon}}"></i> @{{ response.message }}
            </div>
            <form action="{!! route('admin.stock-type.store') !!}" @submit.prevent="create()">
                <div class="form-group col-md-6 col-md-offset-3">
                    <div class="input-group">
                        <input type="text" class="form-control" v-model="newType" placeholder="Stock Type Name">
                        <div class="input-group-btn">
                            <button class="btn btn-primary" v-disable="isLoading('create')"><i class="fa@{{ isLoading('create') ? ' fa-spinner fa-pulse' : ' fa-floppy-o' }}"></i> Save</button>
                        </div>
                    </div>
                    <p class="help-block" v-if="hasError('name','create')" transition="expand">@{{ getError('name','create') }}</p>
                </div>
            </form>
            <table class="table table-hover table-bordered no-padding">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="type in types" track-by="$index" transition="expand">
                        <td v-if="edits.index != $index">@{{ type.name }}</td>
                        <td v-if="edits.index != $index">
                            <div class="box-tools">
                                <button class="btn btn-box-tool editBasket" @click="edit($index)"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-box-tool deleteBasket" @click="destroy($index)"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                        <td colspan="2" v-else>
                            <form action="type.action" class="col-md-8 col-md-offset-2 col-xs-12" @submit.prevent="update($index)">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" v-model="edits.name">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" v-disable="isLoading('edit')" type="submit">
                                                <i class="fa@{{ isLoading('edit') ? ' fa-spinner fa-pulse' : ' fa-floppy-o' }}"></i> Save
                                            </button>
                                            <button class="btn btn-default" v-disable="isLoading('edit')" type="button" @click="edits.index = null">
                                                <i class="fa fa-ban"></i> Cancel
                                            </button>
                                        </div>
                                    </div>
                                    <p class="help-block" v-if="hasError('name','edit')" transition="expand">@{{ getError('name','edit') }}</p>
                                </div>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('endscript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.13/vue.min.js"></script>
    <script>
        Vue.directive('disable', function (value) {
            this.el.disabled = !!value
        });
        new Vue({
            el:'#stock-type-app',
            data:{
                loading: {create: false,edit:false},
                types: {!! $stockTypes->toJson() !!},
                url : '{!! route('admin.stock-type.store') !!}',
                token: '{{csrf_token()}}',
                newType: '',
                edits: {index:null,name:''},
                helpBlock: {create:{},edit:{}},
                response: {}
            },

            methods: {
                create: function()
                {
                    var self = this;
                    var payload = {name: this.newType,_token:this.token};
                    self.loading.create = true;

                    $.post(this.url,payload)
                        .done(function(response){
                            self.types.push(response.data);
                            self.newType = '';
                            self.helpBlock = {create:{},edit:{}};
                            self.setResponse(response,false);
                        })
                        .fail(function(response){
                            if(response.status == 500){
                                self.setResponse(response,true);
                            }else if(response.status == 422){
                                self.helpBlock.create = response.responseJSON;
                            }
                        })
                        .always(function(){
                            self.loading.create = false;
                            setTimeout(function(){
                                self.helpBlock.create = {};
                            },10000);
                        }
                    );
                },
                edit: function(index){
                    if(this.isLoading('edit')) return false;
                    this.edits.index = index;
                    this.edits.name = this.types[index].name;
                },
                update: function(index){
                    var self = this;
                    var record = this.types[index];
                    var payload = {_method:'put',name: this.edits.name,_token:this.token};
                    this.loading.edit = true;

                    $.post(record.action,payload)
                        .done(function(response){
                            self.types.$set(index,response.data);
                            self.edits.index = null;
                            self.edits.name = '';
                            self.helpBlock.edit = {};
                            self.setResponse(response,false);
                        }).fail(function(response){
                            if(response.status == 500){
                                self.setResponse(response,true);
                            }else if(response.status == 503){

                            }else if(response.status == 422){
                                self.helpBlock.edit = response.responseJSON;
                            }
                        })
                        .always(function(){
                            self.loading.edit = false;
                            setTimeout(function(){
                                self.helpBlock.edit = {};
                            },10000);
                        });
                },
                destroy: function(index){
                    var self = this;
                    var record = this.types[index];
                    var payload = {_method:'delete',id: record.id,_token:this.token};
                    $.post(record.action,payload)
                        .done(function(response){
                            self.types.splice(index,1);
                            self.setResponse(response,false);
                        })
                        .fail(function(response){
                            self.setResponse(response,true);
                        });
                },
                hasError: function(field,type){
                    type = (typeof type == 'undefined') ? 'edit' : type;
                    return (type == 'create')
                            ? this.helpBlock.create.hasOwnProperty(field)
                            : this.helpBlock.edit.hasOwnProperty(field);
                },
                getError: function(field,type){
                    type = (typeof type == 'undefined') ? 'edit' : type;

                    if( ! this.hasError(field,type)){
                        return '';
                    }

                    return (type == 'create')
                            ? this.helpBlock.create[field][0]
                            : this.helpBlock.edit[field][0];

                },
                isLoading: function(type){
                    type = (typeof type == 'undefined') ? 'edit' : type;

                    return (type == 'create') ? this.loading.create : this.loading.edit;
                },
                setResponse: function(response,fail){
                    var data = {type:'',icon:'',message:''};
                    fail = (typeof fail == 'undefined') ? true : fail;
                    if(fail == true){
                        if(response.status == 500){
                            data = {type:'danger',icon:'fa-flash',message:response.responseJSON.message || 'Internal Server Error'};
                        }else if(response.status == 503){
                            data = {type:'info',icon:'fa-info-circle',message:response.responseJSON.message || 'Action performed was unsuccessful.'};
                        }else if(response.status == 404){
                            data = {type:'warning',icon:'fa-warning',message:response.responseJSON.message || 'Resource Not found'};
                        }
                    }else if(fail == false){
                        data = {type:'success',icon:'fa-check',message:response.message || 'Action performed successfully.'}
                    }

                    this.response = data;

                }
            },
            ready: function(){
                $('#stock-type-app').removeClass('hide');
            }
        });
    </script>
@endsection