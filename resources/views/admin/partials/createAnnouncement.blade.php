<h3>Prerequisites</h3>
<fieldset title="Announcement Prerequisites">
<div class="form-group">
    {!! Form::label('company', 'Company',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('company',($company),old('company'),['class'=>'form-control chosen-select','data-placeholder'=>'Select Company']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('company')}}</i></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('type', 'Type',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('type',($anonTypes),old('type'),['class'=>'form-control']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('type')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('subtype', 'Subtype',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('subtype',[],old('subtype'),['class'=>'form-control','data-value'=>old('subtype')]) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('subtype')}}</i></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('event', 'Event Date',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::input('date','event_date',old('event_date'),['class'=>'form-control','id'=>'event_date']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('event_date')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('pub_date', 'Published Date',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <?php $date = is_null(old('pub_date')) ? date('Y-m-d\TH:i:s') : old('pub_date'); ?>
        {!! Form::input('datetime-local','pub_date',$date,['class'=>'form-control','placeholder'=>'']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('pub_date')}}</i></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('source', 'Source',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('source',old('source'),['class'=>'form-control','placeholder'=>'Source']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('source')}}</i></span>
    </div>
</div>
</fieldset>
<h3><span id="typeDetails">Type Details</span></h3>
<fieldset title="Type Details">
    <div id="dynamic-form">
        <div id="agm">
            <div class="form-group">
                {!! Form::label('agm.fiscalYear[fiscal_year_id]', 'Fiscal Year',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('agm.fiscalYear[fiscal_year_id][]',$fiscalYear,old('agm.fiscalYear[fiscal_year_id]'),['class'=>'form-control fiscalYear','multiple'=>'multiple']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('agm_fiscalYear.fiscal_year_id')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('agm[count]', 'Count',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('agm[count]',old('agm[count]'),['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('agm.count')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('agm[venue]', 'Venue',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('agm[venue]',old('agm[venue]'),['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('agm.venue')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('agm[bonus]', 'Bonus',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('number','agm[bonus]',old('agm[bonus]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                {!! Form::label('agm[dividend]', 'Dividend',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('number','agm[dividend]',old('agm[dividend]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('agm.bonus')}}</i></span>
                    <span class="text-danger"><i>{{$errors->first('agm.dividend')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('agm[time]', 'Time',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('time','agm[time]',old('agm[time]'),['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('agm.time')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('agm[book_closer_from]', 'Book closer From',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','agm[book_closer_from]',old('agm[book_closer_from]'),['class'=>'form-control']) !!}
                </div>
                {!! Form::label('agm[book_closer_to]', 'Book closer To',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','agm[book_closer_to]',old('agm[book_closer_to]'),['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('agm.book_closer_from')}}</i></span>
                    <span class="text-danger"><i>{{$errors->first('agm.book_closer_to')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('agm[agenda]', 'Agenda',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::textarea('agm[agenda]',old('agm[agenda]'),['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('agm.agenda')}}</i></span>
                </div>
            </div>
        </div>
        <div id="issue">
            <div class="form-group">
                {!! Form::label('issue[fiscal_year_id]', 'Fiscal Year',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('issue[fiscal_year_id]',$fiscalYear,old('issue[fiscal_year_id]'),['class'=>'form-control fiscalYear']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('issue.fiscal_year_id')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('issue.manager[im_id]', 'Issue Manager',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('issue.manager[im_id][]',$issueManager,old('issue.manager[im_id]'),['class'=>'form-control issueManager','multiple'=>true]) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('issue_manager.im_id')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                <?php
                    $ifv = 100;
                    if(array_key_exists('issue',old())){
                        $ifv = old('issue[face_value]');
                    }
                ?>
                {!! Form::label('issue[face_value]', 'Face Value',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','issue[face_value]',$ifv,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('issue.face_value')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('issue[issue_date]', 'Issue Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','issue[issue_date]',old('issue[issue_date]'),['class'=>'form-control']) !!}
                </div>
                {!! Form::label('issue[close_date]', 'Close Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','issue[close_date]',old('issue[close_date]'),['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('issue.issue_date')}}</i></span>
                    <span class="text-danger"><i>{{$errors->first('issue.close_date]')}}</i></span>
                </div>
            </div>
            <div id="kitta_">
                <div class="form-group">
                    {!! Form::label('issue[kitta]', 'Kitta',['class'=>'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::input('number','issue[kitta]',old('issue[kitta]'),['step'=>'any','class'=>'form-control']) !!}
                    </div>
                    <div class="col-lg-10 col-lg-offset-2">
                        <span class="text-danger"><i>{{$errors->first('issue.kitta')}}</i></span>
                    </div>
                </div>
            </div>
            <div id="ratio_">
                <div class="form-group">
                    {!! Form::label('issue[ratio]', 'Ratio',['class'=>'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::input('text','issue[ratio]',old('issue[ratio]'),['class'=>'form-control']) !!}
                    </div>
                    <div class="col-lg-10 col-lg-offset-2">
                        <span class="text-danger"><i>{{$errors->first('issue.ratio')}}</i></span>
                    </div>
                </div>
            </div>
            <div id="promoter_">
                <div class="form-group">
                    {!! Form::label('auction[promoter]', 'Promoter',['class'=>'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::input('number','auction[promoter]',old('auction[promoter]'),['step'=>'any','class'=>'form-control']) !!}
                    </div>
                    <div class="col-lg-10 col-lg-offset-2">
                        <span class="text-danger"><i>{{$errors->first('auction.promoter')}}</i></span>
                    </div>
                </div>
            </div>
            <div id="ordinary_">
                <div class="form-group">
                    {!! Form::label('auction[ordinary]', 'Ordinary',['class'=>'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::input('number','auction[ordinary]',old('auction[ordinary]'),['step'=>'any','class'=>'form-control']) !!}
                    </div>
                    <div class="col-lg-10 col-lg-offset-2">
                        <span class="text-danger"><i>{{$errors->first('auction.ordinary')}}</i></span>
                    </div>
                </div>
            </div>
        </div>
        <div id="bond_debenture">
            <div class="form-group">
                {!! Form::label('bondDebenture[fiscal_year_id]', 'Fiscal Year',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('bondDebenture[fiscal_year_id]',$fiscalYear,old('bondDebenture[fiscal_year_id]'),['class'=>'form-control fiscalYear']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.fiscal_year_id')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('bondDebenture[title_of_securities]', 'Title of Securities',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('bondDebenture[title_of_securities]',old('bondDebenture[title_of_securities]'),['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.title_of_securities')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bondDebenture[face_value]', 'Face Value',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    <?php
                    $bdfv = 100;
                    if(array_key_exists('bondDebenture',old())){
                        $bdfv = old('bondDebenture[face_value]');
                    }
                    ?>
                    {!! Form::input('number','bondDebenture[face_value]',$bdfv,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.face_value')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bondDebenture[kitta]', 'Kitta',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','bondDebenture[kitta]',old('bondDebenture[kitta]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.kitta')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bondDebenture[maturity_period]', 'Maturity Period',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','bondDebenture[maturity_period]',old('bondDebenture[maturity_period]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.maturity_period')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bondDebenture[issue_open_date]', 'Issue Open Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','bondDebenture[issue_open_date]',old('bondDebenture[issue_open_date]'),['class'=>'form-control']) !!}
                </div>
                {!! Form::label('bondDebenture[issue_close_date]', 'Close Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','bondDebenture[issue_close_date]',old('bondDebenture[issue_close_date]'),['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.issue_open_date')}}</i></span>
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.issue_close_date')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bondDebenture[coupon_interest_rate]', 'Coupon Interest Rate',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','bondDebenture[coupon_interest_rate]',old('bondDebenture[coupon_interest_rate]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.coupon_interest_rate')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bondDebenture[interest_payment_method]', 'Interest Payment Method',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('text','bondDebenture[interest_payment_method]',old('bondDebenture[interest_payment_method]'),['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.interest_payment_method')}}</i></span>
                </div>
            </div>
        </div>
        <div id="bill">
            <div class="form-group">
                {!! Form::label('treasuryBill[fiscal_year_id]', 'Fiscal Year',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('treasuryBill[fiscal_year_id]',$fiscalYear,old('treasuryBill[fiscal_year_id]'),['class'=>'form-control fiscalYear']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.fiscal_year_id')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('treasuryBill[issue_amount]', 'Issue Amount',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('text','treasuryBill[issue_amount]',old('treasuryBill[issue_amount]'),['class'=>'form-control']) !!}
                    <input type="hidden" name="bill" value="bill">
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.issue_amount')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('treasuryBill[serial_number]', 'Serial Number',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('text','treasuryBill[serial_number]',old('treasuryBill[serial_number]'),['step'=>'any','class'=>'form-control']) !!}
                    <input type="hidden" name="bill" value="bill">
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.serial_number')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('treasuryBill[highest_discount_rate]', 'Highest Discount Rate',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','treasuryBill[highest_discount_rate]',old('treasuryBill[highest_discount_rate]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.highest_discount_rate')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('treasuryBill[lowest_discount_rate]', 'Lowest Discount Rate',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','treasuryBill[lowest_discount_rate]',old('treasuryBill[lowest_discount_rate]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.lowest_discount_rate')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('treasuryBill[bill_days]', 'Bill Days',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','treasuryBill[bill_days]',old('treasuryBill[bill_days]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.bill_days')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('treasuryBill[issue_open_date]', 'Issue Open Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','treasuryBill[issue_open_date]',old('treasuryBill[issue_open_date]'),['class'=>'form-control']) !!}
                </div>
                {!! Form::label('treasuryBill[issue_close_date]', 'Close Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','treasuryBill[issue_close_date]',old('treasuryBill[issue_close_date]'),['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.issue_open_date')}}</i></span>
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.issue_close_date')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('treasuryBill[weighted_average_rate]', 'Weighted Average Rate',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('number','treasuryBill[weighted_average_rate]',old('treasuryBill[weighted_average_rate]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                {!! Form::label('treasuryBill[slr_rate]', 'SLR Rate',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('number','treasuryBill[slr_rate]',old('treasuryBill[slr_rate]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.weighted_average_rate')}}</i></span>
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.slr_rate')}}</i></span>
                </div>
            </div>
        </div>
        <div id="certificate">
            <div class="form-group">
                {!! Form::label('bonusDividend[fiscal_year_id]', 'Fiscal Year',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('bonusDividend[fiscal_year_id]',$fiscalYear,old('bonusDividend[fiscal_year_id]'),['class'=>'form-control fiscalYear']) !!}
                    <input type="hidden" name="certificate" value="certificate">
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bonusDividend.fiscal_year_id')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bonusDividend[bonus_share]', 'Bonus Share',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','bonusDividend[bonus_share]',old('bonus_share'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bonusDividend.bonus_share')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bonusDividend[cash_dividend]', 'Cash Dividend',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','bonusDividend[cash_dividend]',old('bonusDividend[cash_dividend]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bonusDividend.cash_dividend')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bonusDividend[distribution_date]', 'Distribution Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('date','bonusDividend[distribution_date]',old('bonusDividend[distribution_date]'),['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bonusDividend.distribution_date')}}</i></span>
                </div>
            </div>
        </div>
        <div id="finance">
            <div class="form-group">
                {!! Form::label('financialHighlight.fiscalYear[fiscal_year_id]', 'Fiscal Year',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::select('financialHighlight.fiscalYear[fiscal_year_id]',$fiscalYear,old('financialHighlight.fiscalYear[fiscal_year_id]'),['class'=>'form-control fiscalYear']) !!}
                    <input type="hidden" name="finance" value="finance">
                </div>
                <div class="col-lg-9 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight_fiscalYear[fiscal_year_id]')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('financialHighlight[paid_up_capital]', 'Paid Up Capital',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('number','financialHighlight[paid_up_capital]',old('financialHighlight[paid_up_capital]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-9 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.paid_up_capital')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[reserve_and_surplus]', 'Reserve And Surplus',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('number','financialHighlight[reserve_and_surplus]',old('financialHighlight[reserve_and_surplus]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-9 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.reserve_and_surplus')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[operating_profit]', 'Operating Profit',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('number','financialHighlight[operating_profit]',old('financialHighlight[operating_profit]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-9 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.operating_profit')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[net_profit]', 'Net Profit',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('number','financialHighlight[net_profit]',old('financialHighlight[net_profit]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-9 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.net_profit')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[earning_per_share]', 'Earning Per Share',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('number','financialHighlight[earning_per_share]',old('financialHighlight[earning_per_share]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-9 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.earning_per_share')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[book_value_per_share]', 'Net Assets Per Share',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('number','financialHighlight[book_value_per_share]',old('financialHighlight[book_value_per_share]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-9 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.book_value_per_share')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[price_earning_ratio]', 'Price Earning Ratio',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('text','financialHighlight[price_earning_ratio]',old('financialHighlight[price_earning_ratio]'),['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-9 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.operating_profit')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[liquidity_ratio]', 'Liquidity Ratio',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('text','financialHighlight[liquidity_ratio]',old('financialHighlight[liquidity_ratio]'),['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-9 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.liquidity_ratio')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[net_worth_per_share]', 'Net Worth Per Share',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('number','financialHighlight[net_worth_per_share]',old('financialHighlight[net_worth_per_share]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-9 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.net_worth_per_share')}}</i></span>
                </div>
            </div>
        </div>
        <div id="bod_approved">
            <div class="form-group">
                {!! Form::label('bodApproved[fiscal_year_id]', 'Fiscal Year',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('bodApproved[fiscal_year_id]',$fiscalYear,old('bodApproved[fiscal_year_id]'),['class'=>'form-control fiscalYear']) !!}
                    <input type="hidden" name="certificate" value="certificate">
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bodApproved.fiscal_year_id')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bodApproved[bonus_share]', 'Bonus Share',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','bodApproved[bonus_share]',old('bonus_share'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bodApproved.bonus_share')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bodApproved[cash_dividend]', 'Cash Dividend',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','bodApproved[cash_dividend]',old('bodApproved[cash_dividend]'),['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bodApproved.cash_dividend')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bodApproved[distribution_date]', 'Distribution Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('date','bodApproved[distribution_date]',old('bodApproved[distribution_date]'),['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bodApproved.distribution_date')}}</i></span>
                </div>
            </div>
        </div>
    </div>
</fieldset>
<h3>Announcement Details</h3>
<fieldset title="Announcement Details">
    <div class="form-group">
        {!! Form::label('title', 'Title',['class'=>'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::input('text','title',old('title'),['class'=>'form-control']) !!}
        </div>
        <div class="col-lg-10 col-lg-offset-2">
            <span class="text-danger"><i>{{$errors->first('title')}}</i></span>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('details', 'Detail',['class'=>'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('details',old('details'),['class'=>'editor']) !!}
        </div>
        <div class="col-lg-10 col-lg-offset-2">
            <span class="text-danger"><i>{{$errors->first('details')}}</i></span>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('featured_image', 'Featured Image',['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-10">
            {!! Form::input('file','featured_image',null,['class'=>'form-control','multiple'=>true]) !!}
        </div>
        <div class="col-lg-10 col-lg-offset-2">
            <span class="text-danger"><i>{{$errors->first('featured_image')}}</i></span>
        </div>
    </div>
</fieldset>