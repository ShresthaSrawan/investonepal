import * as DTE from './data-table-elements.js';
import * as TPE from './tab-pane-elements.js';

export const GROUPED = {
	ajax: {
      url: DTE.GROUPED.data('url'),
      type: 'POST',
      data: {
        basket_id () {
        	return $('select[data-name=baskets]').val();
        },
        show_sold () {
          return TPE.GROUPED.find('#toggle-sold-stock').prop('checked') ? 1 : 0;
        }
      }
  },
  searchDelay: 350,
  createdRow ( row, data, dataIndex ) {
    var start = $( row ).find('td:first-child').get(0);
    var end = $( row ).find('td:last-child').get(0);

    $(start)
      .nextUntil(end)
        .attr('data-change-view','buy')
        .attr('data-id', data.company_id)
        .attr('data-name', data.company_name);
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
      {data: 'company_quote', searchable : true ,render(data,type,row,meta){
          return '<a href="/quote/'+data+'" target="_blank"><span data-toggle="tooltip" data-placement="down" title="'+row.company_name+'">'+data+'</span></a>';
      }},
      {data: 'buy_rate',render(data,type,row,meta){
          return data ? parseFloat(data).toFixed(2) : '0.00';
      }},
      {data: 'remaining_quantity', searchable : false},
      {data: 'close_price', searchable : false, render(data,type,row,meta){
          var closeDate = moment(row.close_date).format('D MMM. YY');
          return (data == null) ? 'NA' : (data + ' <small>('+closeDate+')</small>');
      }},
      {data: 'investment', searchable : false, render(data,type,row,meta){
          return parseFloat(data).toFixed(2);
      }},
      {data: 'market_value', searchable : false, render(data,type,row,meta){
          return parseFloat(data).toFixed(2);
      }},
      {data: 'profit_loss', searchable : false, render(data,type,row,meta){
          if (!data) {
            return '<span data-change="neutral">0.00 <small>(0.00%)</small></span>';
          }

          var changePercent = Math.abs(parseFloat(100* (row.market_value - row.investment)/(row.investment || row.market_value)).toFixed(2));

          var dataChange = data > 0 ? 'up' : (data < 0 ? 'down' : 'neutral');

          return '<span data-change="'+dataChange+'">'+parseFloat(data).toFixed(2)+' <small>('+changePercent+'%)</small></span>';
      }},
      {data: 'total_stocks'},
      {data: null, orderable: false, searchable: false, render(data,type,row,meta){
          return '<button class="btn btn-box-tool" data-change-view="buy" data-name="'+row.company_name+'" data-id="'+row.company_id+'" data-toggle="tooltip" data-placement="top" title="More Details"><i class="fa fa-chevron-circle-right"></i></button>';
      }}
  ]
}

export const BUY = {
    ajax: {
        url: DTE.BUY.data('url'),
        type: 'POST',
        data: {
            basket_id () { return $('select[data-name=baskets]').val() },
            company_id () { return TPE.BUY.find('input[name=company_id]').val() },
            show_sold () { return TPE.BUY.find('input[name=toggle-sold]').prop('checked') ? 1 : 0 }
        }
    },
    searchDelay: 350,
    footerCallback ( row, data, start, end, display) {
        let investment = 0;
        let market_value = 0;
        let profit_loss = {
          change: 0,
          percent:0
        };

        let total_remaining_quantity = 0;
        let average_rate = 0;
        let dataChange = 'neutral';
        let closePrice = 0;

        $.each(data, (i,row) => {
            investment += row.investment;
            market_value += row.market_value;
            profit_loss.change += row.profit_loss;
            total_remaining_quantity += row.remaining_quantity;
            closePrice = row.close_price;
        });

        if (total_remaining_quantity != 0) {
          average_rate = parseFloat(investment / total_remaining_quantity).toFixed(2);

          profit_loss.percent = parseFloat(Math.abs((market_value - investment) * 100 / (investment || market_value))).toFixed(2);
          profit_loss.change = parseFloat(profit_loss.change).toFixed(2);
          investment = parseFloat(investment).toFixed(2);
          market_value = parseFloat(market_value).toFixed(2);
          closePrice = parseFloat(closePrice).toFixed(2);

          dataChange = profit_loss.change > 0 ? "up" : (profit_loss.change < 0 ? 'down' : 'neutral');
        }
        else {
          average_rate = profit_loss.percent = profit_loss.change = investment = market_value = '0.00';
        }

        // Update footer
        $('#buy-view tfoot [data-average-rate]').text(average_rate);
        $('#buy-view .box-header [data-average-rate]').text('@ ' + average_rate);
        $('#buy-view [data-quantity]').text(total_remaining_quantity);
        $('#buy-view [data-investment]').text(investment);
        $('#buy-view [data-market-value]').text(market_value);
        $('#buy-view [data-close-price]').text('@ ' +closePrice);
        $('#buy-view .box-header [data-change]').html('<span data-change="'+dataChange+'">'+profit_loss.change+'</span>');
        $('#buy-view .box-header [data-change-percent]').html('<span data-change="'+dataChange+'">'+profit_loss.percent+'%</span>');
        $('#buy-view tfoot span[data-change]').html('<span data-change="'+dataChange+'">'+profit_loss.change+'  <small>('+profit_loss.percent+' %)</small></span>');
    },
    columns: [
        {data: 'company_quote',searchable : true, render(data,type,row,meta){
            return '<a href="/quote/'+data+'" target="_blank"><span data-toggle="tooltip" data-placement="down" title="'+row.company_name+'">'+data+'</span></a>';
        }},
        {data: 'buy_rate', searchable : false, render(data,type,row,meta){
            return parseFloat(data).toFixed(2);
        }},
        {data: 'remaining_quantity', searchable : false},
        {data: 'close_price',searchable : false, render(data,type,row,meta){
            var closeDate = moment(row.close_date).format('D MMM. YY');
            return (data == null) ? 'NA' : (data + ' <small>('+closeDate+')</small>');
        }},
        {data: 'investment',searchable : false, render(data,type,row,meta){
            return parseFloat(data).toFixed(2);
        }},
        {data: 'market_value',searchable : false, render(data,type,row,meta){
            return parseFloat(data).toFixed(2);
        }},
        {data: 'profit_loss',searchable : false, render(data,type,row,meta){
            if (!data) {
              return '<span data-change="neutral">0.00 <small>(0.00%)</small></span>';
            }

            var changePercent = Math.abs(parseFloat(100* (row.market_value - row.investment)/(row.investment || row.market_value)).toFixed(2));

            var dataChange = data > 0 ? 'up' : (data < 0 ? 'down' : 'neutral');

            return '<span data-change="'+dataChange+'">'+parseFloat(data).toFixed(2)+' <small>('+changePercent+'%)</small></span>';
        }},
        {data: null, orderable: false, searchable: false, render(data,type,row,meta){
            return `
                <button class="btn btn-box-tool" 
                    data-modal="buy" 
                    data-id="${row.id}"
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Edit"
                ><i class="fa fa-edit"></i></button>

                <button class="btn btn-box-tool" 
                    data-change-view="sell" 
                    data-name="${row.company_name}" data-id="${row.id}" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Sales"
                ><i class="fa fa-history"></i></button>

                <button class="btn btn-box-tool" 
                    data-change-view="details"
                    data-name="${row.company_name}" data-id="${row.id}" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Details"
                ><i class="fa fa-info-circle"></i></button>

                <button class="btn btn-box-tool"
                    data-name="${row.company_name}"
                    data-id="${row.id}" 
                    data-modal="delete"
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Delete"
                ><i class="fa fa-trash"></i></button>
            `;
        }}
    ],
    createdRow ( row, data, dataIndex ) {
      var start = $( row ).find('td:first-child').get(0);
      var end = $( row ).find('td:last-child').get(0);

      $( start )
        .nextUntil(end)
          .attr('data-change-view','sell')
          .attr('data-id', data.id)
          .attr('data-name', data.company_name);
    }
};

export const SELL = {
    ajax: {
        url: DTE.SELL.data('url'),
        type: 'POST',
        data: {
            basket_id () { return $('select[data-name=baskets]').val() },
            buy_id (){ return TPE.SELL.find('input[name=buy_id]').val() }
        }
    },
    searchDelay: 350,
    footerCallback ( row, data, start, end, display) {
        let investment = 0;
        let sales_value = 0;
        let profit_loss = {
            change: 0,
            percent:0
        };

        $.each(data, (i,row) => {
            investment += row.investment;
            sales_value += row.sales_value;
            profit_loss.change += row.profit_loss;
        });

        profit_loss.percent = parseFloat(Math.abs((sales_value - investment) * 100 / (investment || sales_value)) || 0).toFixed(2);
        profit_loss.change = parseFloat(profit_loss.change).toFixed(2);
        investment = parseFloat(investment).toFixed(2);
        sales_value = parseFloat(sales_value).toFixed(2);

        // Update footer
        let dataChange = profit_loss.change > 0 ? "up" : (profit_loss.change < 0 ? 'down' : 'neutral');
        
        $('#sell-view tfoot span[data-investment]').text(investment);
        $('#sell-view tfoot span[data-sales-value]').text(sales_value);
        $('#sell-view tfoot span[data-change]').html('<span data-change="'+dataChange+'">'+profit_loss.change+'  <small>('+profit_loss.percent+'%)</small></span>');
    },
    columns: [
        {data: 'sell_date',searchable : true, render (data,type,row,meta) {
            return moment(data).format('D MMM, YYYY');
        }},
        {data: 'sell_quantity', searchable : false},
        {data: 'sell_rate', searchable : false},
        {data: 'sell_commission', searchable : false},
        {data: 'sell_tax', searchable : false},
        {data: 'buy_rate_computed', render (data) {
            return parseFloat(data).toFixed(2);
        }},
        {data: 'investment', render(data){
            return parseFloat(data).toFixed(2);
        }},
        {data: 'sales_value', render(data,type,row,meta){
            return parseFloat(data).toFixed(2);
        }},
        {data: 'profit_loss', render(data,type,row,meta){
            if(!data) return 'NA';

            var changePercent = Math.abs(parseFloat(100* (row.sales_value - row.investment)/(row.investment || row.sales_value)).toFixed(2));

            var dataChange = data > 0 ? 'up' : (data < 0 ? 'down' : 'neutral');

            return '<span data-change="'+dataChange+'">'+parseFloat(data).toFixed(2)+' <small>('+changePercent+'%)</small></span>';
        }},
        {data: null, orderable: false, searchable: false, render(data,type,row,meta){
            return `
                <button class="btn btn-box-tool" 
                    data-modal="sell" 
                    data-id="${row.id}"
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Edit"
                ><i class="fa fa-edit"></i></button>

                <button class="btn btn-box-tool"
                    data-id="${row.id}"
                    data-modal="delete" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Delete"
                ><i class="fa fa-trash"></i></button>
            `;
        }}
    ]
};

export const DETAILS = {
    ajax: {
        url: DTE.DETAILS.data('url'),
        type: 'POST',
        data: {
            basket_id () { return $('select[data-name=baskets]').val() },
            buy_id (){ return TPE.DETAILS.find('input[name=buy_id]').val() }
        }
    },
    searchDelay: 350,
    columns: [
        {data: 'fiscal_year_label',searchable : true},
        {data: 'stock_dividend', searchable : false},
        {data: 'cash_dividend', searchable : false},
        {data: 'right_share', searchable : false},
        {data: null, orderable: false, searchable: false, render(data,type,row,meta){
            return `
                <button class="btn btn-box-tool" 
                    data-modal="details" 
                    data-id="${row.id}"
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Edit"
                ><i class="fa fa-edit"></i></button>

                <button class="btn btn-box-tool"
                    data-id="${row.id}" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Delete"
                ><i class="fa fa-trash"></i></button>
            `;
        }}
    ]
};