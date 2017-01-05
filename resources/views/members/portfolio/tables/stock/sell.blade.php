<div class="box">
    <div class="box-header with-border">
        <div class="box-title">
            <i class="fa fa-building"></i> Stock: <span data-title></span>
        </div>
        <div class="box-tools pull-right">
            <div class="btn-group">
                <button class="btn btn-box-tool" data-change-view="buy"><i class="fa fa-chevron-circle-left"></i> Back</button>
                <a class="btn btn-box-tool" href="{{route('member.report.stock')}}"><i class="fa fa-area-chart"></i> Report</a>
                <button class="btn btn-box-tool" data-modal="sell"><i class="fa fa-minus-circle"></i> Sell Stock</button>
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <input type="hidden" name="buy_id">
            <div class="table-responsive col-xs-12">    
                <table 
                    class="table table-condensed table-striped" 
                    data-table="sell" 
                    data-url="{{route('members.stock.fetch-stock-sell')}}" 
                    style="width: 100%"
                >
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th><span data-toggle="tooltip" data-placement="top" title="Sales Rate">S. Rate</span></th>
                            <th><span data-toggle="tooltip" data-placement="top" title="Sales Commission">Commission</span></th>
                            <th><span data-toggle="tooltip" data-placement="top" title="Capital Gain">C.G.Tax</span></th>
                            <th><span data-toggle="tooltip" data-placement="top" title="Buy Rate">B. Rate</span></th>
                            <th>Investment</th>
                            <th>Sales Amount</th>
                            <th>Change</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th><span data-toggle="tooltip" data-placement="top" title="Sales Rate">S. Rate</span></th>
                            <th><span data-toggle="tooltip" data-placement="top" title="Sales Commission">Commission</span></th>
                            <th><span data-toggle="tooltip" data-placement="top" title="Capital Gain">C.G.Tax</span></th>
                            <th><span data-toggle="tooltip" data-placement="top" title="Buy Rate">B. Rate</span></th>
                            <th>Investment</th>
                            <th>Sales Amount</th>
                            <th>Change</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <th colspan="6">Total</th>
                            <th><span data-investment>Investment</span></th>
                            <th><span data-sales-value>Sales Value</span></th>
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