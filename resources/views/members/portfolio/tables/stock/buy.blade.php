<div class="box">
    <div class="box-header with-border">
        <div class="box-title">
            <i class="fa fa-building"></i> Stock: <span data-title></span>
        </div>
        <div class="box-tools pull-right">
            <div class="btn-group">
            <button class="btn btn-box-tool" data-change-view="grouped"><i class="fa fa-chevron-circle-left"></i> Back</button>
                <a class="btn btn-box-tool" href="{{route('member.report.stock')}}"><i class="fa fa-area-chart"></i> Report</a>
                <button class="btn btn-box-tool" data-modal="buy"><i class="fa fa-plus-circle"></i> Add Stock</button>
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12">
                <div class="checkbox">
                    <input type="hidden" name="company_id">
                    <label>
                        <input type="checkbox" name="toggle-sold"> Show/Hide Sold Stock
                    </label>
                </div>
            </div>
            <div class="table-responsive col-xs-12">    
                <table 
                    class="table table-condensed table-striped" 
                    data-table="buy" 
                    data-url="{{route('members.stock.fetch-grouped-company')}}" 
                    style="width: 100%"
                >
                    <thead>
                        <tr>
                            <th><span data-toggle="tooltip" data-placement="top" title="Stock Quote">Quote</span></th>
                            <th>Buy Rate</th>
                            <th><span data-toggle="tooltip" data-placement="top" title="Total Quantity">Qty</span></th>
                            <th><span data-toggle="tooltip" data-placement="top" title="Last Close Price">Close Price</span></th>
                            <th>Investment</th>
                            <th>Market Value</th>
                            <th>Change</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><span data-toggle="tooltip" data-placement="top" title="Stock Quote">Quote</span></th>
                            <th>Buy Rate</th>
                            <th><span data-toggle="tooltip" data-placement="top" title="Total Quantity">Qty</span></th>
                            <th><span data-toggle="tooltip" data-placement="top" title="Last Close Price">Close Price</span></th>
                            <th>Investment</th>
                            <th>Market Value</th>
                            <th>Change</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <th colspan="4">Total</th>
                            <th><span data-investment>Investment</span></th>
                            <th><span data-market-value>Market Value</span></th>
                            <th><span data-change>Change</span></th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>