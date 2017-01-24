export default {
	ajax: {
        url: $('table[data-table=grouped]').data('url'),
        type: 'POST',
        data: {
            basket_id (){
            	return $('select[data-name=baskets]').val()
            }
        }
    },
    footerCallback ( row, data, start, end, display) {
        var self = this;

        var investment = 0;
        var market_value = 0;
        var profit_loss = {
            change: 0,
            percent:0
        };
        $.each(data,function(i,row){
            investment += row.investment;
            market_value += row.market_value;
            profit_loss.change += row.profit_loss;
        });

        profit_loss.percent = parseFloat(Math.abs((market_value - investment) * 100 / (investment || market_value))).toFixed(2);
        profit_loss.change = parseFloat(profit_loss.change).toFixed(2);
        investment = parseFloat(investment).toFixed(2);
        market_value = parseFloat(market_value).toFixed(2);

        // Update footer
        var dataChange = profit_loss.change > 0 ? "up" : (profit_loss.change < 0 ? 'down' : 'neutral');

        $('#grouped-view span[data-investment]').text(investment);
        $('#grouped-view span[data-market-value]').text(market_value);
        $('#grouped-view span[data-change]').html('<span data-change="'+dataChange+'">'+profit_loss.change+'  <small>('+profit_loss.percent+' %)</small></span>');
    },
    columns: [
        {data: 'company_quote',render: function(data,type,row,meta){
            return '<a href="/quote/'+data+'" target="_blank"><span data-toggle="tooltip" data-placement="down" title="'+row.company_name+'">'+data+'</span></a>';
        }},
        {data: 'buy_rate',render: function(data,type,row,meta){
            return parseFloat(data).toFixed(2);
        }},
        {data: 'remaining_quantity'},
        {data: 'close_price', render: function(data,type,row,meta){
            var closeDate = moment(row.close_date).format('D MMM. YY');
            return (data == null) ? 'NA' : (data + ' <small>('+closeDate+')</small>');
        }},
        {data: 'investment', render: function(data,type,row,meta){
            return parseFloat(data).toFixed(2);
        }},
        {data: 'market_value', render: function(data,type,row,meta){
            return parseFloat(data).toFixed(2);
        }},
        {data: 'profit_loss', render: function(data,type,row,meta){
            if(!data) return 'NA';

            var changePercent = Math.abs(parseFloat(100* (row.market_value - row.investment)/(row.investment || row.market_value)).toFixed(2));

            var dataChange = data > 0 ? 'up' : (data < 0 ? 'down' : 'neutral');

            return '<span data-change="'+dataChange+'">'+parseFloat(data).toFixed(2)+' <small>('+changePercent+'%)</small></span>';
        }},
        {data: 'total_stocks'},
        {data: null, orderable: false, searchable: false, render: function(data,type,row,meta){
            return '<button class="btn btn-box-tool" data-change-view="buy-view" data-company-name="'+row.company_name+'" data-company="'+row.company_id+'" data-toggle="tooltip" data-placement="top" title="More Details"><i class="fa fa-chevron-circle-right"></i></button>';
        }}
    ]
}