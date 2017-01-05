<h3>Announcement Prerequisites</h3>
<fieldset title="Announcement Prerequisites">
<div class="form-group">
    {!! Form::label('company', 'Company',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <?php $companyVal = is_null(old('company')) ? $announcement->company_id : old('company'); ?>
        {!! Form::select('company',($company),$companyVal,['class'=>'form-control chosen-select','data-placeholder'=>'Select Company']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('company')}}</i></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('type', 'Type',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <?php $type = is_null(old('type')) ? $announcement->type_id : old('type') ?>
        {!! Form::select('type',($anonTypes),$type,['class'=>'form-control']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('type')}}</i></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('subtype', 'Subtype',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <?php $subtype = is_null(old('subtype')) ? $announcement->subtype_id : old('subtype') ?>
        {!! Form::select('subtype',[],old('subtype'),['class'=>'form-control','data-value'=>$subtype]) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('subtype')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('event', 'Event Date',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-sm-10">
        <?php $eventDate = is_null(old('event_date')) ? $announcement->event_date : old('event_date'); ?>
        {!! Form::input('date','event_date',$eventDate,['class'=>'form-control','id'=>'event_date']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('event_date')}}</i></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('pub_date', 'Published Date',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <?php
                $pub_date = is_null(old('pub_date')) ? date_create($announcement->pub_date)->format('Y-m-d\TH:i:s') : old('pub_date');
                $pub_date = is_null($pub_date) ? date('Y-m-d\TH:i:s') : $pub_date;
        ?>
        {!! Form::input('datetime-local','pub_date',$pub_date,['class'=>'form-control','placeholder'=>'']) !!}
    </div>
    <div class="col-lg-10 col-lg-offset-2">
        <span class="text-danger"><i>{{$errors->first('pub_date')}}</i></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('source', 'Source',['class'=>'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <?php $source = is_null(old('source')) ? $announcement->source : old('source'); ?>
        {!! Form::text('source',$source,['class'=>'form-control','placeholder'=>'Source']) !!}
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
            <?php
                $agm = $announcement->agm;

                $agmCount = old('agm[count]');
                $agmVenue = old('agm[venue]');
                $agmBookCloserFrom = old('agm[book_closer_from]');
                $agmBookCloserTo = old('agm[book_closer_to]');
                $agmAgenda = old('agm[agenda]');
                $agmFiscalYear = old('agm.fiscalYear[fiscal_year_id]');
                $agmBonus = old('agm.fiscalYear[bonus]');
                $agmDividend = old('agm.fiscalYear[dividend]');
                $agmTime = old('agm.fiscalYear[time]');

                if(!is_null($agm) && !array_key_exists('agm',old())){
                    $agmCount = $agm->count;
                    $agmVenue = $agm->venue;
                    $agmBookCloserFrom = $agm->book_closer_from;
                    $agmBookCloserTo = $agm->book_closer_to;
                    $agmAgenda = $agm->agenda;
                    $agmBonus = $agm->bonus;
                    $agmDividend = $agm->dividend;
                    $agmTime = $agm->time;
                    $agmFiscalYear = $agm->fiscal->lists('fiscal_year_id')->toArray();
                }
            ?>
            <div class="form-group">
                {!! Form::label('agm.fiscalYear[fiscal_year_id]', 'Fiscal Year',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('agm.fiscalYear[fiscal_year_id][]',$fiscalYear,$agmFiscalYear,['class'=>'form-control fiscalYear','multiple'=>'multiple']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('agm_fiscalYear.fiscal_year_id')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('agm[count]', 'Count',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('agm[count]',$agmCount,['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('agm.count')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('agm[venue]', 'Venue',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('agm[venue]',$agmVenue,['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('agm.venue')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('agm[bonus]', 'Bonus',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('number','agm[bonus]',$agmBonus,['step'=>'any','class'=>'form-control']) !!}
                </div>
                {!! Form::label('agm[dividend]', 'Dividend',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('number','agm[dividend]',$agmDividend,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('agm.bonus')}}</i></span>
                    <span class="text-danger"><i>{{$errors->first('agm.dividend')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('agm[time]', 'Time',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('time','agm[time]',$agmTime,['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('agm.time')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('agm[book_closer_from]', 'Book closer From',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','agm[book_closer_from]',$agmBookCloserFrom,['class'=>'form-control']) !!}
                </div>
                {!! Form::label('agm[book_closer_to]', 'Book closer To',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','agm[book_closer_to]',$agmBookCloserTo,['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('agm.book_closer_from')}}</i></span>
                    <span class="text-danger"><i>{{$errors->first('agm.book_closer_to')}}</i></span>
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('agm[agenda]', 'Agenda',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::textarea('agm[agenda]',$agmAgenda,['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('agm.agenda')}}</i></span>
                </div>
            </div>
        </div>
        <div id="issue">
            <?php
                $issue = $announcement->issue;

                $issueFiscalYear = old('issue[fiscal_year_id]');
                $issueFaceValue = old('issue[face_value]');
                $issueIssueDate = old('issue[issue_date]');
                $issueCloseDate = old('issue[close_date]');
                $issueKitta = old('issue[kitta]');
                $issueRatio = old('issue[ratio]');
                $issueIssueManager = old('issue.manager[im_id]');

                $auctionPromoter = old('auction[promoter]');
                $auctionOrdinary = old('auction[ordinary]');

                if(!is_null($issue) && !array_key_exists('issue',old())){
                    $issueFiscalYear = $issue->fiscalYear->id ;
                    $issueFaceValue = $issue->face_value ;
                    $issueIssueDate = $issue->issue_date ;
                    $issueCloseDate = $issue->close_date ;
                    $issueKitta = $issue->kitta ;
                    $issueRatio = $issue->ratio ;
                    $issueIssueManager = $issue->manager->lists('im_id')->toArray();

                    $auction = $announcement->issue->auction;
                    if(!is_null($auction) && !array_key_exists('auction',old())){
                        $auctionPromoter = $auction->promoter;
                        $auctionOrdinary = $auction->ordinary;
                    }
                }
            ?>
            <div class="form-group">
                {!! Form::label('issue[fiscal_year_id]', 'Fiscal Year',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('issue[fiscal_year_id]',$fiscalYear,$issueFiscalYear,['class'=>'form-control fiscalYear']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('issue.fiscal_year_id')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('issue.manager[im_id]', 'Issue Manager',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('issue.manager[im_id][]',$issueManager,$issueIssueManager,['class'=>'form-control issueManager','multiple'=>true]) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('issue_manager[im_id]')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('issue[face_value]', 'Face Value',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','issue[face_value]',$issueFaceValue,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('issue.face_value')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('issue[issue_date]', 'Issue Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','issue[issue_date]',$issueIssueDate,['class'=>'form-control']) !!}
                </div>
                {!! Form::label('issue[close_date]', 'Close Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','issue[close_date]',$issueCloseDate,['class'=>'form-control']) !!}
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
                        {!! Form::input('number','issue[kitta]',$issueKitta,['step'=>'any','class'=>'form-control']) !!}
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
                        {!! Form::input('text','issue[ratio]',$issueRatio,['class'=>'form-control']) !!}
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
                        {!! Form::input('number','auction[promoter]',$auctionPromoter,['step'=>'any','class'=>'form-control']) !!}
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
                        {!! Form::input('number','auction[ordinary]',$auctionOrdinary,['step'=>'any','class'=>'form-control']) !!}
                    </div>
                    <div class="col-lg-10 col-lg-offset-2">
                        <span class="text-danger"><i>{{$errors->first('auction.ordinary')}}</i></span>
                    </div>
                </div>
            </div>
        </div>
        <div id="bond_debenture">
            <?php
            $bd = $announcement->bondDebenture;

            $bdTitleOfSecurities = old('bondDebenture[title_of_securities]');
            $bdFaceValue = old('bondDebenture[face_value]');
            $bdKitta = old('bondDebenture[kitta]');
            $bdMaturityPeriod = old('bondDebenture[maturity_period]');
            $bdIssueOpenDate = old('bondDebenture[issue_open_date]');
            $bdIssueCloseDate = old('bondDebenture[issue_close_date]');
            $bdFiscalYear = old('bondDebenture[fiscal_year_id]');
            $bdCouponInterestRate = old('bondDebenture[coupon_interest_rate]');
            $bdInterestPaymentMethod = old('bondDebenture[interest_payment_method]');


            if(!is_null($bd) && !array_key_exists('bondDebenture',old())){

                $bdTitleOfSecurities = $bd->title_of_securities;
                $bdFaceValue = $bd->face_value;
                $bdKitta = $bd->kitta;
                $bdMaturityPeriod = $bd->maturity_period;
                $bdIssueOpenDate = $bd->issue_open_date;
                $bdIssueCloseDate = $bd->issue_close_date;
                $bdFiscalYear = $bd->fiscal_year_id;
                $bdCouponInterestRate = $bd->coupon_interest_rate;
                $bdInterestPaymentMethod = $bd->interest_payment_method;
            }
            ?>
            <div class="form-group">
                {!! Form::label('bondDebenture[fiscal_year_id]', 'Fiscal Year',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('bondDebenture[fiscal_year_id]',$fiscalYear,$bdFiscalYear,['class'=>'form-control fiscalYear']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.fiscal_year_id')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('bondDebenture[title_of_securities]', 'Title of Securities',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('bondDebenture[title_of_securities]',$bdTitleOfSecurities,['class'=>'form-control']) !!}
                    <input type="hidden" name="bond_debenture" value="bond_debenture">
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.title_of_securities')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bondDebenture[face_value]', 'Face Value',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','bondDebenture[face_value]',$bdFaceValue,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.face_value')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bondDebenture[kitta]', 'Kitta',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','bondDebenture[kitta]',$bdKitta,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.kitta')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bondDebenture[maturity_period]', 'Maturity Period',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','bondDebenture[maturity_period]',$bdMaturityPeriod,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.maturity_period')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bondDebenture[issue_open_date]', 'Issue Open Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','bondDebenture[issue_open_date]',$bdIssueOpenDate,['class'=>'form-control']) !!}
                </div>
                {!! Form::label('bondDebenture[issue_close_date]', 'Close Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','bondDebenture[issue_close_date]',$bdIssueCloseDate,['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.issue_open_date')}}</i></span>
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.issue_close_date')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bondDebenture[coupon_interest_rate]', 'Coupon Interest Rate',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','bondDebenture[coupon_interest_rate]',$bdCouponInterestRate,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.coupon_interest_rate')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bondDebenture[interest_payment_method]', 'Interest Payment Method',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('text','bondDebenture[interest_payment_method]',$bdInterestPaymentMethod,['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bondDebenture.interest_payment_method')}}</i></span>
                </div>
            </div>
        </div>
        <div id="bill">
            <?php
            $tb = $announcement->treasuryBill;

            $tbFiscalYear = old('treasuryBill[fiscal_year_id]');
            $tbIssueAmount = old('treasuryBill[issue_amount]');
            $tbSerialNumber = old('treasuryBill[serial_number]');
            $tbHighestDiscountRate = old('treasuryBill[highest_discount_rate]');
            $tbLowestDiscountRate = old('treasuryBill[Lowest_discount_rate]');
            $tbBillDays = old('treasuryBill[bill_days]');
            $tbIssueOpenDate = old('treasuryBill[issue_open_date]');
            $tbIssueCloseDate = old('treasuryBill[issue_close_date]');
            $tbWeightedAverageRate = old('treasuryBill[weighted_average_rate]');
            $tbSlrRate = old('treasuryBill[slr_rate]');


            if(!is_null($tb) && !array_key_exists('treasuryBill',old())){
                $tbFiscalYear = $tb->fiscal_year_id;
                $tbIssueAmount = $tb->issue_amount;
                $tbSerialNumber = $tb->serial_number;
                $tbHighestDiscountRate = $tb->highest_discount_rate;
                $tbLowestDiscountRate = $tb->lowest_discount_rate;
                $tbBillDays = $tb->bill_days;
                $tbIssueOpenDate = $tb->issue_open_date;
                $tbIssueCloseDate = $tb->issue_close_date;
                $tbWeightedAverageRate = $tb->weighted_average_rate;
                $tbSlrRate =  $tb->slr_rate;
            }

            ?>
            <div class="form-group">
                {!! Form::label('treasuryBill[fiscal_year_id]', 'Fiscal Year',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('treasuryBill[fiscal_year_id]',$fiscalYear,$tbFiscalYear,['class'=>'form-control fiscalYear']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.fiscal_year_id')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('treasuryBill[issue_amount]', 'Issue Amount',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('text','treasuryBill[issue_amount]',$tbIssueAmount,['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.issue_amount')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('treasuryBill[serial_number]', 'Serial Number',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('text','treasuryBill[serial_number]',$tbSerialNumber,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.serial_number')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('treasuryBill[highest_discount_rate]', 'Highest Discount Rate',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','treasuryBill[highest_discount_rate]',$tbHighestDiscountRate,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.highest_discount_rate')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('treasuryBill[lowest_discount_rate]', 'Lowest Discount Rate',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','treasuryBill[lowest_discount_rate]',$tbLowestDiscountRate,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.lowest_discount_rate')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('treasuryBill[bill_days]', 'Bill Days',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','treasuryBill[bill_days]',$tbBillDays,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.bill_days')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('treasuryBill[issue_open_date]', 'Issue Open Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','treasuryBill[issue_open_date]',$tbIssueOpenDate,['class'=>'form-control']) !!}
                </div>
                {!! Form::label('treasuryBill[issue_close_date]', 'Close Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('date','treasuryBill[issue_close_date]',$tbIssueCloseDate,['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.issue_open_date')}}</i></span>
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.issue_close_date')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('treasuryBill[weighted_average_rate]', 'Weighted Average Rate',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('number','treasuryBill[weighted_average_rate]',$tbWeightedAverageRate,['step'=>'any','class'=>'form-control']) !!}
                </div>
                {!! Form::label('treasuryBill[slr_rate]', 'SLR Rate',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-4">
                    {!! Form::input('number','treasuryBill[slr_rate]',$tbSlrRate,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.weighted_average_rate')}}</i></span>
                    <span class="text-danger"><i>{{$errors->first('treasuryBill.slr_rate')}}</i></span>
                </div>
            </div>
        </div>
        <div id="certificate">
            <?php
            $bonusDividend = $announcement->bonusDividend;

            $bdiFiscalYear = old('bonusDividend[fiscal_year_id]');
            $bdiBonusShare = old('bonus_share');
            $bdiCashDividend = old('bonusDividend[cash_dividend]');
            $bdiDistributionDate = old('bonusDividend[distribution_date]');


            if(!is_null($bonusDividend) && !array_key_exists('bonusDividend',old())){
                $bdiFiscalYear = $bonusDividend->fiscal_year_id;
                $bdiBonusShare = $bonusDividend->bonus_share;
                $bdiCashDividend = $bonusDividend->cash_dividend;
                $bdiDistributionDate = $bonusDividend->distribution_date;
            }
            ?>
            <div class="form-group">
                {!! Form::label('bonusDividend[fiscal_year_id]', 'Fiscal Year',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('bonusDividend[fiscal_year_id]',$fiscalYear,$bdiFiscalYear,['class'=>'form-control fiscalYear']) !!}
                    <input type="hidden" name="certificate" value="certificate">
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bonusDividend.fiscal_year_id')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bonusDividend[bonus_share]', 'Bonus Share',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','bonusDividend[bonus_share]',$bdiBonusShare,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bonusDividend.bonus_share')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bonusDividend[cash_dividend]', 'Cash Dividend',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','bonusDividend[cash_dividend]',$bdiCashDividend,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bonusDividend.cash_dividend')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bonusDividend[distribution_date]', 'Distribution Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('date','bonusDividend[distribution_date]',$bdiDistributionDate,['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bonusDividend.distribution_date')}}</i></span>
                </div>
            </div>
        </div>
        <div id="finance">
            <?php
            $financialHighlight = $announcement->financialHighlight;

            $fhFiscalYear = old('financialHighlight.fiscalYear[fiscal_year_id]');
            $fhPaidUpCapital = old('financialHighlight[paid_up_capital]');
            $fhReserveSurplus = old('financialHighlight[reserve_and_surplus]');
            $fhEarningPerShare = old('financialHighlight[earning_per_share]');
            $fhNetWorthPerShare = old('financialHighlight[net_worth_per_share]');
            $fhBookValuePerShare = old('financialHighlight[book_value_per_share]');
            $fhNetProfit = old('financialHighlight[net_profit]');
            $fhLiquidityRatio = old('financialHighlight[liquidity_ratio]');
            $fhPriceEarningRatio = old('financialHighlight[price_earning_ratio]');
            $fhOperatingProfit = old('financialHighlight[operating_profit]');

            if(!is_null($financialHighlight) && !array_key_exists('financialHighlight',old())){
                $fhFiscalYear = $financialHighlight->fiscal_year_id;
                $fhPaidUpCapital = $financialHighlight->paid_up_capital;
                $fhReserveSurplus = $financialHighlight->reserve_and_surplus;
                $fhEarningPerShare = $financialHighlight->earning_per_share;
                $fhNetWorthPerShare = $financialHighlight->net_worth_per_share;
                $fhBookValuePerShare = $financialHighlight->book_value_per_share;
                $fhNonPerformingLoan = $financialHighlight->non_performing_loan;
                $fhNetProfit = $financialHighlight->net_profit;
                $fhLiquidityRatio = $financialHighlight->liquidity_ratio;
                $fhPriceEarningRatio = $financialHighlight->price_earning_ratio;
                $fhOperatingProfit = $financialHighlight->operating_profit;
            }
            ?>
            <div class="form-group">
                {!! Form::label('financialHighlight.fiscalYear[fiscal_year_id]', 'Fiscal Year',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::select('financialHighlight.fiscalYear[fiscal_year_id]',$fiscalYear,$fhFiscalYear,['class'=>'form-control fiscalYear']) !!}
                    <input type="hidden" name="finance" value="finance">
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight_fiscalYear[fiscal_year_id]')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[paid_up_capital]', 'Paid Up Capital',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('number','financialHighlight[paid_up_capital]',$fhPaidUpCapital,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.paid_up_capital')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[reserve_and_surplus]', 'Reserve And Surplus',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('number','financialHighlight[reserve_and_surplus]',$fhReserveSurplus,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.reserve_and_surplus')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[operating_profit]', 'Operating Profit',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('number','financialHighlight[operating_profit]',$fhOperatingProfit,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.operating_profit')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[net_profit]', 'Net Profit',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('number','financialHighlight[net_profit]',$fhNetProfit,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.net_profit')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[earning_per_share]', 'Earning Per Share',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('number','financialHighlight[earning_per_share]',$fhEarningPerShare,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.earning_per_share')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[book_value_per_share]', 'Net Assets Per Share',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('number','financialHighlight[book_value_per_share]',$fhBookValuePerShare,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.book_value_per_share')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[price_earning_ratio]', 'Price Earning Ratio',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('text','financialHighlight[price_earning_ratio]',$fhPriceEarningRatio,['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.price_earning_ratio')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[liquidity_ratio]', 'Liquidity Ratio',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('text','financialHighlight[liquidity_ratio]',$fhLiquidityRatio,['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.liquidity_ratio')}}</i></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('financialHighlight[net_worth_per_share]', 'Net Worth Per Share',['class'=>'col-lg-3 control-label']) !!}
                <div class="col-lg-9">
                    {!! Form::input('number','financialHighlight[net_worth_per_share]',$fhNetWorthPerShare,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('financialHighlight.net_worth_per_share')}}</i></span>
                </div>
            </div>
        </div>
        <div id="bod_approved">
            <?php
            $bodApproved = $announcement->bodApproved;

            $bodFiscalYear = old('bodApproved[fiscal_year_id]');
            $bodBonusShare = old('bonus_share');
            $bodCashDividend = old('bodApproved[cash_dividend]');
            $bodDistributionDate = old('bodApproved[distribution_date]');


            if(!is_null($bodApproved) && !array_key_exists('bodApproved',old())){
                $bodFiscalYear = $bodApproved->fiscal_year_id;
                $bodBonusShare = $bodApproved->bonus_share;
                $bodCashDividend = $bodApproved->cash_dividend;
                $bodDistributionDate = $bodApproved->distribution_date;
            }
            ?>
            <div class="form-group">
                {!! Form::label('bodApproved[fiscal_year_id]', 'Fiscal Year',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('bodApproved[fiscal_year_id]',$fiscalYear,$bodFiscalYear,['class'=>'form-control fiscalYear']) !!}
                    <input type="hidden" name="certificate" value="certificate">
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bodApproved.fiscal_year_id')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bodApproved[bonus_share]', 'Bonus Share',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','bodApproved[bonus_share]',$bodBonusShare,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bodApproved.bonus_share')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bodApproved[cash_dividend]', 'Cash Dividend',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('number','bodApproved[cash_dividend]',$bodCashDividend,['step'=>'any','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-10 col-lg-offset-2">
                    <span class="text-danger"><i>{{$errors->first('bodApproved.cash_dividend')}}</i></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('bodApproved[distribution_date]', 'Distribution Date',['class'=>'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::input('date','bodApproved[distribution_date]',$bodDistributionDate,['class'=>'form-control']) !!}
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
            <?php $title = is_null(old('title')) ? $announcement->title : old('title') ?>
            {!! Form::input('text','title',$title,['class'=>'form-control']) !!}
        </div>
        <div class="col-lg-10 col-lg-offset-2">
            <span class="text-danger"><i>{{$errors->first('title')}}</i></span>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('details', 'Detail',['class'=>'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <?php $details = is_null(old('details')) ? $announcement->details : old('details') ?>
            {!! Form::textarea('details',$details,['class'=>'editor']) !!}
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