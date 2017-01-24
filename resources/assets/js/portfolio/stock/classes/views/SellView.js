import ViewPane from '../ViewPane.js';

export default class SellView extends ViewPane {
	show (data, element) {
    let datatable = this.app.datatables.buy.datatable;
    let row = element.closest('tr');

    this.buy_data = datatable.row(row).data();

    this.setViewData(this.buy_data);
		this.openSellModal();

		super.show();
	}

	setViewData (data) {
		if(!data || typeof data != 'object' || !data.id || !data.company_name) return;
    this.renderBuyData();
		this.datatable().reload();
	}

  renderBuyData () {
    let data = this.buy_data;

    if(typeof data != 'object' || !data.id || !data.company_name) return;

    let data_change = data.profit_loss > 0 ? 'up' : (data.profit_loss < 0 ? 'down' : 'neutral');

    let investment = data.investment ? parseInt(data.investment).toFixed(2) : '0.00';
    let buy_rate = '@ ' + parseInt(data.buy_rate || 0).toFixed(2);
    let market_value = parseInt(data.market_value || 0).toFixed(2);
    let close_price = '@ ' + parseInt(data.close_price || 0).toFixed(2);
    let profit_loss = parseInt(data.profit_loss || 0).toFixed(2);
    let profit_loss_percent = parseInt(( (data.market_value - data.investment) * 100 / (data.investment) ) || 0).toFixed(2);

    let quantity = data.sell_quantity + data.remaining_quantity;
    
    this.$el.find('input[name=buy_id]').val(data.id);
    this.$el.find('span[data-title]').text(data.company_name);

    this.$el.find('[data-header-investment]').text(investment);
    this.$el.find('[data-header-buy-rate]').text(buy_rate);

    this.$el.find('[data-header-market-value]').text(market_value);
    this.$el.find('[data-header-close-price]').text(close_price);

    this.$el.find('[data-header-change]').html('<span data-change="'+data_change+'">'+profit_loss+'</span>');
    this.$el.find('[data-header-change-percent]').html('<span data-change="'+data_change+'">'+profit_loss_percent+'%</span>')

    //percent change
    this.$el.find('[data-header-remaining-quantity]').html(data.remaining_quantity + ' <small>(Remaining)</small>');
    this.$el.find('[data-header-quantity]').html(quantity + ' <small>(Buy)</small>');
  }

  getBuyData () {
    console.log(this.buy_data.id, this.app.datatables.buy.datatable.data());

    return this.buy_data;
  }

  openSellModal () {
    this.app.modals.sell.open()
  }

	listenEvents () {
		this.listenDatatableEvents();
	}

	listenDatatableEvents() {
		this.datatable().$el.on('processing.dt', (e, setting, processing) => {
			console.debug('Sell Table Processing:',processing)
		});
	}
}