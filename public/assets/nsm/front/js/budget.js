$(document).ready(function(){
	updateBudget();
	$('#fiscalYear').change(function(){
		updateBudget();
	});

	function updateBudget(){
		$('#budgetSource').html('');
		$('#budgetExpense').html('');
		$.post(budgetURL,{fiscal_year_id:$('#fiscalYear').val()},function(response){
			var budgetTable='';
			console.log(response);
				$.each(response.budget,function(k,budget){

					budgetTable = "";
						if(budget.budget_label.sub_label.length != 0){
							budgetTable+='<div class="table-responsive">\
								<table class="table datatable table-hover table-condensed table-striped responsive with-border">\
									<thead>\
									<tr>\
										<th style="width: 70%;">\
											<strong>'+budget.budget_label.label+'</strong>\
										</th>\
										<th style="width:30%;">Value</th>\
									</tr>\
									</thead>\
									<tbody>';
										$.each(budget.budget_label.sub_label,function(k,sl){
												budgetTable+='<tr>\
												<td>'+sl.label+'</td><td>';
												var flag = 0;
												$.each(sl.sub_value,function(k,sv){
													subValue = null;
													match = (sv.budget_id == budget.id) && (sv.sub_label_id ==sl.id);
													if(match == true){
														subValue=sv.value;
													}
													if(!(subValue==null)){
														budgetTable +=addCommas(subValue);
														flag=1;
													}
												});
													flag==1 ? budgetTable+='</td></tr>':budgetTable+='N/A</td></tr>';
										});
									budgetTable+='</tbody>\
									<tfoot>\
									<tr>\
										<th>Total</th>\
										<th><strong>'+addCommas(budget.value)+'</strong></th>\
									</tr>\
									</tfoot>\
								</table>\
							</div>';
						}
						else{
							budgetTable+='<div class="table-responsive">\
								<table class="table datatable table-hover table-condensed table-striped responsive with-border">\
									<thead>\
									<tr>\
										<th style="width:70%;">\
											<strong>'+budget.budget_label.label+'</strong>\
										</th>\
										<th style="width:30%;"><strong>'+addCommas(budget.value)+'</strong></th>\
									</tr>\
									</thead>\
								</table></div>';
						}
					
					if(budget.budget_label.type == 0)
					{
						$('#budgetSource').append(budgetTable);
					} 
					else if(budget.budget_label.type == 1)
					{
						$('#budgetExpense').append(budgetTable);
					}
				});
			});
	}
});