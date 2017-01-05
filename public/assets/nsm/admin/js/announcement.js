var initType = initSubType = '';
var formDirection = 'next';
var $form = $('form#createAnnForm');
var issueOpenDateSetCounter = 0;
var config = {
    '.chosen-select-deselect'  : {allow_single_deselect:true},
    '.chosen-select-no-single' : {disable_search_threshold:10},
    '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
    '.chosen-select-width'     : {width:"95%"}
};
for (var selector in config) {
    $(selector).chosen(config[selector]);
}
$(document).ready(function(){
    loadSource();
    loadTypeDetailHeader();
    initAll();

    //fetch and load subtypes
    allForms.init().loadSubType({
        type:$('#type'),
        subtype:$('#subtype')
    });

    initializeFiscalYear();
    initializeIssueManager();
});

var loadTypeDetailHeader = function(){
    //$('a[href=#createAnnForm-h-1] >').append($('<span class="label label-info">Issue Open | IPO</span>'));
};

$form.steps({
    headerTag : 'h3',
    bodyTag: "fieldset",
    enableAllSteps: false,
    enableCancelButton: true,
    onStepChanging: function (event, currentIndex, newIndex)
    {
        if(newIndex == 1){
            var currentType = $('#type').val();
            var currentSubType = $('#subtype').val();
            loadTypeDetailHeader();
            if(initType == ''){
                initType = currentType;
                initSubType = currentSubType;
            }
            allForms.loadForm();
            if(allForms.response.other){
                if(currentIndex > newIndex){
                    $("a[href=#next]").click();
                }else{
                    $("a[href=#previous]").click();
                }
            }
        }

        formDirection = currentIndex < newIndex ? 'next' : 'back';

        var form = $(this);
        return form.valid();
    },
    onStepChanged: function (event, currentIndex, priorIndex)
    {
        if(currentIndex == 2){
            $form = $('#createAnnForm');
            data = $form.serialize();
             //var data = {type:type(),subtype:subtype()};
             $.post(getDynamicTD,data,function(response){
                 if(response.error) return;
                 $('#title').val(response.message.title);
                 tinymce.get('details').setContent(response.message.description);
             });
        }

        //console.log(event,currentIndex,priorIndex);
        var form = $(this);
        return form.valid();
    },
    onFinishing: function (event, currentIndex)
    {
        //console.log(event,currentIndex);
        var form = $(this);
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {
        //console.log(event,currentIndex);
        var form = $(this);
        form.submit();
    }
});

var allForms = {
    agm:'',
    ordinary:"",
    promoter:"",
    issue:"",
    ratio:"",
    kitta:"",
    operating_profit:"",
    certificate:"",
    bond_debenture:"",
    bill:"",
    finance:"",
    response:"",
    current:{type:'',subtype:''},
    init: function(){
        this.agm = $('#agm');
        this.bod_approved = $('#bod_approved');
        this.ordinary = $('#ordinary_');
        this.promoter = $('#promoter_');
        this.ratio = $('#ratio_');
        this.kitta = $('#kitta_');
        this.operating_profit = $('#operating_profit_');
        $('#ordinary_').remove();
        $('#promoter_').remove();
        $('#ratio_').remove();
        $('#kitta_').remove();
        $('#operating_profit_').remove();
        this.issue = $('#issue');
        this.bond_debenture = $('#bond_debenture');
        this.bill = $('#bill');
        this.certificate = $('#certificate');
        this.finance = $('#finance');

        this.removeAll();
        return this;
    },

    loadSubType: function(obj,callback){
        var self = this;
        var html = '';
        if(obj.type.val() == self.current.type){
            self.current.subtype = obj.subtype.val();
            if(callback != null){
                callback();
            }

        }else{
            $.post(url,{id:obj.type.val()}, function(data){
                $.each(data,function(index,sType){
                    html += '<option value="'+sType.id+'">'+sType.label+'</option>';
                });

                obj.subtype.html(html);
                if(data.length == 0){
                    obj.subtype.prop('disabled',true);
                }else{
                    obj.subtype.prop('disabled',false);
                }

            }).done(function() {
                if(obj.subtype.attr('data-value')){
                    var subValue = obj.subtype.data('value');
                    var firstVal = obj.subtype.children().first().val();
                    if(obj.subtype.children("option[value='"+subValue+"']").length == 1){
                        obj.subtype.val(subValue);
                    }else{
                        obj.subtype.val(firstVal);
                    }
                    //console.log();
                }

                self.current.type = obj.type.val();
                self.current.subtype = obj.subtype.val();

                searchRecentAnnouncements();
                if(callback != null){
                    callback();
                }
            });
        }
    },
    removeAll: function(){
        $('#dynamic-form').empty();
        return this;
    },
    loadForm: function(){
        var self = this;
        if(self.current.subtype == null){
            self.current.subtype = 0;
        }
        $.post(dynamicFormUrl,{
            type:self.current.type,
            subtype:self.current.subtype
        }, function(response){
            self.response = response;
            //console.log(self.response);
            var dynamicForm = $('#dynamic-form');
            if(self.response.agm == true){
                dynamicForm.html(self.agm);
            }else if(self.response.issue == true){
                dynamicForm.html(self.issue);

                if(self.response.auction.promoter == true){
                    dynamicForm.append(self.promoter);
                }

                if(self.response.auction.ordinary == true){
                    dynamicForm.append(self.ordinary);
                }
                if(self.response.auction.promoter == false && self.response.auction.ordinary == false){
                    dynamicForm.append(self.operating_profit);
                    dynamicForm.append(self.kitta);
                }

                if(self.response.ratio == true){
                    dynamicForm.append(self.ratio);
                }
            }else if(self.response.bond_debenture == true){
                dynamicForm.html(self.bond_debenture);
            }else if(self.response.bill == true){
                dynamicForm.html(self.bill);
            }else if(self.response.certificate == true){
                dynamicForm.html(self.certificate);
            }else if(self.response.finance == true){
                dynamicForm.html(self.finance);
            }else if(self.response.bod_approved == true){
                dynamicForm.html(self.bod_approved);
            }else{
                dynamicForm.empty();
            }



            if(self.response.other == true){
                if(formDirection == 'next'){
                    $("a[href=#next]").click();
                }else{
                    $("a[href=#previous]").click();
                }
            }

            if(self.response.other == false){
                initializeFiscalYear();
                initializeIssueManager();
            }

        }).done(function(){
            issueOpenDateSetCounter = 0;
            setIssueOpenDate();
        });
    }
};


$( "#type" ).change(function() {
    allForms.loadSubType({
        type:$('#type'),
        subtype:$('#subtype')
    });
});
$( "#subtype" ).change(function() {
    allForms.loadSubType({
        type:$('#type'),
        subtype:$('#subtype')
    });
    searchRecentAnnouncements();
});

function initAll(){
    tinymce.init(getTinyMceSettings('textarea'));

    $('#featured_image').fileinput({
        'showUpload':false,
        'previewFileType':'any',
        'allowedFileExtensions':['jpg', 'jpeg', 'png', 'gif']
    });
}

//search company
$('#company').chosen();
$('#company').change(function(){
    searchRecentAnnouncements();
});
var fyCounter = 0;
function initializeFiscalYear(){
    var fy = $(".fiscalYear");
    if(fyCounter == 0){
        fy.chosen();
    }else{
        nextNode = fy.next();
        if(nextNode.hasClass('chosen-container')){
            nextNode.remove();
        }
        fy.chosen();
    }

    fyCounter++;
}

var imCounter = 0;
function initializeIssueManager(){
    var im = $(".issueManager");
    if(imCounter == 0){
        im.chosen();
    }else{
        nextNode = im.next();
        if(nextNode.hasClass('chosen-container')){
            nextNode.remove();
        }
        im.chosen();
    }

    imCounter++;
}

function loadSource()
{
    var source = $('#source');
    if(source.val() == ''){
        source.val('Newspaper');
    }
}

var searchRecentAnnouncements = function(){
    var $this = this;
    $this.search = function(){
        $this.loadHeader();
        var postData = {company:$this.$company.val(),type:$this.$type.val(),subtype:$this.$subtype.val()};
        $.post(searchRecentAnnouncemnet,postData,function(data){
            showRecentAnnouncement(data);
        });
    };

    $this.loadHeader = function(){
        var title = $this.$type.find('option:selected').text();
        var subtitle = $this.$subtype.attr('disabled') === undefined ? $this.$subtype.find('option:selected').text() : 'Unavailable';
        if(subtitle == 'Unavailable'){
            var $newHeader = title+' <span class="label label-danger">'+subtitle+'</span>';
        }else{
            var $newHeader = title+' <span class="label label-info">'+subtitle+'</span>';
        }

        $('#typeDetails').html($newHeader);
    };

    $this.$header = $('#typeDetails');
    $this.$company = $('#company');
    $this.$subtype = $('#subtype');
    $this.$type = $('#type');

    if(searchRecentAnnouncemnet == null) {
        $this.loadHeader();
        return;
    }

    if($this.$subtype.attr('disabled') === undefined){
        if($this.$subtype.val() == null){
            setTimeout('searchRecentAnnouncements()',100);
        }else{
            $this.search();
        }
    }else{
        $this.search();
    }
};

var showRecentAnnouncement = function(data){
    var html = '';
    $.each(data,function(index,announcement){
        html += '<div class="list-group-item">';
        html += '<h6 class="list-group-item-heading">'+announcement.title+'</h6>';
        var eventDate = 'NA';
        var subtype = 'NA';
        if(announcement.event != '') eventDate = announcement.event;
        if(announcement.subtype != '') subtype = announcement.subtype;

        html += '<p><span class="label label-info">'+eventDate+'</span>';
        html += ' <span class="label label-info">'+subtype+'</span>';
        html += '<a target="_blank" href="'+announcement.link+'" class="btb btn-xs btn-flat btn-default pull-right"><i class="fa fa-eye"></i> View</a>'
        html += '</p></div>';

    });

    if(html.length == 0) html = '<li class="list-group-item">No recent announcement found.</li>';

    $('#recentAnouncement').html(html);
};

var setIssueOpenDate = function() {
    var eventValue = $('#event_date').val();
    this.load = function(){
        var iod = $('input[name*="issue_open_date"]');
        var id = $('input[name*="issue_date"]');
        var dd = $('input[name*="distribution_date"]');

        if (iod.length != 0 && iod.val() == '') iod.val(eventValue);
        if (id.length != 0 && id.val() == '') id.val(eventValue);
        if (dd.length != 0 && dd.val() == '') dd.val(eventValue);

    };

    if(issueOpenDateSetCounter == 0 && eventValue != ''){
        setTimeout('this.load()',200);
        issueOpenDateSetCounter++;
    }
};