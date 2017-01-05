<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'minify'], function () {
    Route::get('/', ['as' => 'index', 'uses' => 'FrontController@index']);
    Route::get('/login', ['as' => 'login', 'uses' => 'LoginController@getLogin']);
    Route::post('/login', ['as' => 'request-login', 'uses' => 'LoginController@postLogin']);

    Route::post('/user/reset/request', ['as' => 'reset-password-request', 'uses' => 'UserController@resetPasswordRequest']);
    Route::get('/user/reset/{confirmationCode}', ['as' => 'reset-password-form', 'uses' => 'UserController@resetPassword']);
    Route::post('/user/reset', ['as' => 'reset-password', 'uses' => 'UserController@newPassword']);
    Route::post('/user/resend/confirmationCode', ['as' => 'resend-confirmation', 'uses' => 'UserController@resendConfirmationCode']);
    Route::get('/user/verify/{confirmationCode}', ['as' => 'verify-user', 'uses' => 'UserController@verify']);
    Route::post('/user/register', ['as' => 'register-client', 'uses' => 'UserController@registerClient']);

    Route::any('/logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);

    Route::get('/403', ['as' => '403', 'uses' => 'FrontController@show403']);

    Route::get('ourteam', ['as' => 'ourteam', 'uses' => 'FrontController@ourteam']);

    Route::get('/stock/{category?}', ['as' => 'stock', 'uses' => 'FrontController@getStock']);
    Route::get('/bullion/{type?}', ['as' => 'front.bullion', 'uses' => 'FrontController@getBullion']);
    Route::get('/energy/{type?}', ['as' => 'front.energy', 'uses' => 'FrontController@getEnergy']);
    Route::get('/currency/{type?}', ['as' => 'front.currency', 'uses' => 'FrontController@getCurrency']);
    Route::any('/quote/{quote}', ['as' => 'quote', 'uses' => 'FrontController@getQuote']);
    Route::get('/quote/{quote}/news', ['as' => 'front.news.quote', 'uses' => 'FrontController@newsQuote']);
    Route::get('/quote/{quote}/announcement', ['as' => 'front.announcement.quote', 'uses' => 'FrontController@announcementQuote']);
    Route::any('/technical-analysis/company/{quote}', ['as' => 'technical-analysis', 'uses' => 'FrontController@getTechnicalAnalysis']);
    Route::any('/technical-analysis/company/{quote}/ohlc', ['as' => 'technical-analysis-ohlc', 'uses' => 'FrontController@getTechnicalAnalysisOHLC']);
    Route::any('/technical-analysis/index/{indexName}', ['as' => 'technical-analysis-index', 'uses' => 'FrontController@getTechnicalAnalysisIndex']);

    Route::get('news', ['as' => 'front.news.index', 'uses' => 'FrontController@newsIndex']);
    Route::get('news/category/{type}', ['as' => 'front.news.category', 'uses' => 'FrontController@newsCategory']);
    Route::get('news/category/{type}/{slug}', ['as' => 'front.news.show', 'uses' => 'FrontController@newsShow']);
    Route::get('news/tags/{tag}', ['as' => 'front.news.tags.show', 'uses' => 'FrontController@newsTag']);
    Route::get('news-archive', ['as' => 'front.news.archive', 'uses' => 'FrontController@newsArchive']);
    Route::post('/news-by-date', ['as' => 'get-news-by-date', 'uses' => 'FrontController@getNewsByDate']);

    Route::get('announcements', ['as' => 'front.announcement.index', 'uses' => 'FrontController@announcementIndex']);
    Route::get('announcements/{type}', ['as' => 'front.announcement.category', 'uses' => 'FrontController@announcementCategory']);
    Route::get('announcements/{type}/{slug}', ['as' => 'front.announcement.show', 'uses' => 'FrontController@announcementShow']);
    Route::any('/announcement-by-date', ['as' => 'get-announcement-by-date', 'uses' => 'FrontController@getAnnouncementByDate']);

    Route::get('/ia/{type}', ['as' => 'front.interviewArticle.index', 'uses' => 'FrontController@interviewArticleIndex']);
    Route::get('/ia/{type}/{slug}', ['as' => 'front.interviewArticle.show', 'uses' => 'FrontController@interviewArticleShow']);

    Route::get('ipoPipeline', ['as' => 'front.ipoPipeline', 'uses' => 'FrontController@getPipeline']);
    Route::get('brokerageFirm', ['as' => 'front.brokerageFirm', 'uses' => 'FrontController@getBrokerageFirm']);
    Route::get('basePrice', ['as' => 'front.basePrice', 'uses' => 'FrontController@getBasePrice']);
    Route::get('ipo-result', ['as' => 'front.ipoResult', 'uses' => 'FrontController@getIpoResult']);
    Route::get('issue', ['as' => 'front.issue', 'uses' => 'FrontController@getIssue']);
    Route::match(['get', 'post'], 'benifits-bod-approved', ['as' => 'front.bodApproved', 'uses' => 'FrontController@getBodApproved']);
    Route::match(['get', 'post'], 'annual-general-meeting', ['as' => 'front.agm', 'uses' => 'FrontController@getAGM']);
    Route::match(['get', 'post'], 'certificates-and-benifits-distribution', ['as' => 'front.certificate', 'uses' => 'FrontController@getCertificate']);
    Route::match(['get', 'post'], 'treasury-bill', ['as' => 'front.treasury', 'uses' => 'FrontController@getTreasury']);
    Route::match(['get', 'post'], 'bond-and-debenture', ['as' => 'front.bondAndDebenture', 'uses' => 'FrontController@getBond']);
    Route::match(['get', 'post'], 'issueManager', ['as' => 'front.issueManager', 'uses' => 'FrontController@getIssueManager']);
    Route::post('bonus-dividend', ['as' => 'bonus.dividend', 'uses' => 'FinancialReportController@bonusDividend']);
    Route::post('published-report', ['as' => 'published.report', 'uses' => 'FrontController@getPublishedReport']);

    Route::match(['get', 'post'], 'market', ['as' => 'front.market', 'uses' => 'FrontController@getMarket']);

    Route::get('budget', ['as' => 'front.budget', 'uses' => 'FrontController@getBudget']);

    Route::get('economy', ['as' => 'front.economy', 'uses' => 'FrontController@getEconomy']);

    Route::post('review', ['as' => 'front.review', 'uses' => 'CompanyReviewController@review']);
    Route::post('watchlist', ['as' => 'front.watchlist', 'uses' => 'WatchlistController@addOrRemove']);

    Route::post('get-reviews', ['as' => 'front.review.show', 'uses' => 'CompanyReviewController@getReview']);

    Route::post('get-reviews-chart', ['as' => 'front.review.chart', 'uses' => 'CompanyReviewController@getChart']);

    Route::post('vote', ['as' => 'front.review.vote', 'uses' => 'CompanyReviewController@vote']);

    Route::get('site-map', ['as' => 'front.siteMap', 'uses' => 'FrontController@siteMap']);

    Route::get('contact', ['as' => 'front.contact', 'uses' => 'FrontController@contact']);

    Route::get('about', ['as' => 'front.about', 'uses' => 'FrontController@about']);

    Route::post('contact', ['as' => 'front.contact', 'uses' => 'FrontController@contactSendMessage']);
});
/*Do not minify events route*/
Route::match(['get', 'post'], 'events', ['as' => 'event', 'uses' => 'FrontController@getEvent']);
/*For Image Caching*/
Route::get('thumbs/{file}', ['as' => 'image.thumbs', 'uses' => 'ImageController@thumbnail']);
Route::get('featured/{file}', ['as' => 'image.featured', 'uses' => 'ImageController@featured']);

/*Members Area*/
Route::group(['middleware' => 'clientAuthenticate', 'prefix' => 'member', 'namespace' => 'Members'], function () {
    Route::get('/', ['as' => 'member.home', 'uses' => 'MembersController@index']);
    Route::get('/bullion', ['as' => 'member.bullion.index', 'uses' => 'MembersController@bullion']);
    Route::get('/currency', ['as' => 'member.currency.index', 'uses' => 'MembersController@currency']);
    Route::get('/property', ['as' => 'member.property.index', 'uses' => 'MembersController@property']);
    Route::post('/fetch-all', ['as' => 'member.home.fetchAll', 'uses' => 'MembersController@fetchAll']);

    /*Report*/
    Route::get('stock/report', ['as' => 'member.report.stock', 'uses' => 'ReportController@stock']);
    Route::post('stock/report/performance', ['as' => 'member.report.stockPerformance', 'uses' => 'ReportController@stockPerformance']);
    Route::post('stock/report/buy', ['as' => 'member.report.buyReport', 'uses' => 'ReportController@stockBuyReport']);
    Route::post('stock/report/sell', ['as' => 'member.report.sellReport', 'uses' => 'ReportController@stockSellReport']);
    Route::post('stock/report/fundamental-analysis', ['as' => 'member.report.fundamentalAnalysis', 'uses' => 'ReportController@stockFundamentalAnalysis']);

    Route::get('property/report', ['as' => 'member.report.property', 'uses' => 'ReportController@property']);
    Route::post('property/report/buy', ['as' => 'member.report.buyProperty', 'uses' => 'ReportController@propertyBuyReport']);
    Route::post('property/report/sell', ['as' => 'member.report.sellProperty', 'uses' => 'ReportController@propertySellReport']);

    Route::get('currency/report', ['as' => 'member.report.currency', 'uses' => 'ReportController@currency']);
    Route::post('currency/report/buy', ['as' => 'member.report.buyCurrency', 'uses' => 'ReportController@currencyBuyReport']);
    Route::post('currency/report/sell', ['as' => 'member.report.sellCurrency', 'uses' => 'ReportController@currencySellReport']);
    Route::post('currency/report/summary', ['as' => 'member.report.currencySummary', 'uses' => 'ReportController@currencySummary']);

    Route::get('bullion/report', ['as' => 'member.report.bullion', 'uses' => 'ReportController@bullion']);
    Route::post('bullion/report/buy', ['as' => 'member.report.buyBullion', 'uses' => 'ReportController@bullionBuyReport']);
    Route::post('bullion/report/sell', ['as' => 'member.report.sellBullion', 'uses' => 'ReportController@bullionSellReport']);
    Route::post('bullion/report/summary', ['as' => 'member.report.bullionSummary', 'uses' => 'ReportController@bullionSummary']);

    Route::resource('basket', 'BasketController', ['only' => ['store', 'update', 'destroy']]);
    Route::post('basket/fetch', ['as' => 'member.basket.fetch', 'uses' => 'BasketController@fetch']);

    // NEW
    Route::any('stock/fetch-grouped/beta', ['as' => 'members.stock.fetch-grouped', 'uses' => 'StockController@fetchGrouped']);
    Route::any('stock/fetch-group/beta', ['as' => 'members.stock.fetch-grouped-company', 'uses' => 'StockController@fetchGroup']);
    Route::any('stock/fetch-stock-sell/beta', ['as' => 'members.stock.fetch-stock-sell', 'uses' => 'StockController@fetchStockSell']);   
    Route::get('stock/{id}/beta', ['as' => 'members.stock.fetch', 'uses' => 'StockController@showNew']);

    Route::resource('stock', 'StockController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
    Route::resource('stock-details', 'StockDetailsController', ['only' => ['store', 'update', 'destroy']]);
    Route::post('stock/sell', ['as' => 'member.stock.sell', 'uses' => 'StockController@sell']);
    Route::put('stock/sell/{id}', ['as' => 'member.stock.sell.update', 'uses' => 'StockController@sellUpdate']);
    Route::delete('stock/sell/{id}', ['as' => 'member.stock.sell.delete', 'uses' => 'StockController@sellDelete']);
    Route::delete('stock/details/{id}', ['as' => 'member.stock.details.delete', 'uses' => 'StockController@detailsDelete']);
    Route::post('stock/fetch', ['as' => 'members.stock.fetch', 'uses' => 'StockController@fetch']);
    Route::post('stock-details/fetch', ['as' => 'member.stock-details.fetch', 'uses' => 'StockDetailsController@fetch']);

    Route::resource('bullion', 'BullionController', ['only' => ['store', 'update', 'destroy']]);
    Route::post('bullion/fetch', ['as' => 'member.bullion.fetch', 'uses' => 'BullionController@fetch']);
    Route::resource('bullion-sell', 'BullionSellController', ['only' => ['store', 'update', 'destroy']]);

    Route::resource('currency', 'CurrencyController', ['only' => ['store', 'update', 'destroy']]);
    Route::post('currency/fetch', ['as' => 'member.currency.fetch', 'uses' => 'CurrencyController@fetch']);
    Route::resource('currency-sell', 'CurrencySellController', ['only' => ['store', 'update', 'destroy']]);

    Route::resource('property', 'PropertyController', ['only' => ['store', 'update', 'destroy']]);
    Route::resource('property-sell', 'PropertySellController', ['only' => ['store', 'update', 'destroy']]);
    Route::post('property/fetch', ['as' => 'member.property.fetch', 'uses' => 'PropertyController@fetch']);


});

/*Client Authentication*/
Route::group(['middleware' => 'clientAuthenticate'], function () {
    Route::get('watchlist', [
        'as' => 'watchlist',
        'uses' => 'WatchlistController@index'
    ]);
    Route::get('/user/profile', ['as' => 'user.profile', 'uses' => 'UserController@profileShow']);
    Route::get('/user/profile/edit', ['as' => 'user.profile.edit', 'uses' => 'UserController@profileEdit']);
    Route::put('/user/profile', ['as' => 'user.profile.update', 'uses' => 'UserController@profileUpdate']);
    Route::match(['get', 'put'], '/user/newsletter', ['as' => 'user.profile.newsletter', 'uses' => 'UserController@newsletter']);
});

Route::group(['middleware' => 'authenticate', 'prefix' => 'admin'], function () {
    Route::get('dashboard', [
        'as' => 'admin.dashboard',
        'uses' => 'AdminController@index'
    ]);

    /* In-house User CRUD */
    Route::resource('user', 'UserController');
    //Ajax Request
    Route::post('/get/user', [
        'as' => 'get-user-datatable',
        'uses' => 'UserController@getUserDatatable'
    ]);

    //artisan commands
    Route::get('/command/run/{command}', ['as' => 'admin.command', 'uses' => 'AdminController@command']);

    //newsletter
    Route::get('/newsletter', ['as' => 'admin.newsletter.preview', 'uses' => 'AdminController@newsletter']);
    /* User Type CRUD */
    Route::resource('userType', 'UserTypeController', ['only' => ['index', 'store', 'update', 'destroy']]);

    /* Sector CRUD*/
    Route::resource('sector', 'SectorController', ['except' => ['create', 'edit', 'show']]);

    /*Company CRUD*/
    Route::get('/company/create/{name?}', [
        'as' => 'admin.company.create',
        'uses' => 'CompanyController@create'
    ]);
    Route::resource('company', 'CompanyController', ['except' => ['create']]);
    Route::post('/get/company', [
        'as' => 'get-company-datatable',
        'uses' => 'CompanyController@getCompanyDatatable'
    ]);

    /*Issue Manager CRUD */
    Route::resource('issueManager', 'IssueManagerController', ['except' => ['show']]);

    /* News Category CRUD*/
    Route::resource('newsCategory', 'NewsCategoryController', ['only' => ['index', 'store', 'update', 'destroy']]);

    /*News CRUD */
    Route::resource('news', 'NewsController');
    //Ajax Request
    Route::post('/get/news', [
        'as' => 'get-news-datatable',
        'uses' => 'NewsController@getNewsDatatable'
    ]);
    //Deleting featured_image
    Route::delete('/news/image/{id}/delete', [
        'as' => 'admin.imageNews.destroy',
        'uses' => 'ImageNewsController@destroy'
    ]);

    /*Market Index Type CRUD*/
    Route::resource('indexType', 'IndexTypeController', ['except' => ['create', 'edit', 'show']]);

    /*Market Index CRUD*/
    Route::resource('marketIndex', 'MarketIndexController', ['except' => ['show']]);
    Route::post('marketIndex/create/crawl', ['as' => 'admin.marketIndex.crawl', 'uses' => 'MarketIndexController@crawl']);

    /*Announcement Misc CRUD */
    Route::resource('announcement/misc', 'AnnouncementMiscController');

    /*Announcement CRUD */
    Route::resource('announcement', 'AnnouncementController');

    /*Announcement Type*/
    Route::resource('announcement-type', 'AnnouncementTypeController');

    /*Announcement Sub-type CRUD*/
    Route::resource('announcement-type.subtype', 'AnnouncementSubTypeController', ['except' => ['show']]);

    /*Merger CRUD*/
    Route::resource('merger', 'MergerController', ['except' => ['show']]);

    /*Today's Price*/
    Route::get('/view/todaysprice/{year?}/{month?}/{day?}', [
        'as' => 'admin.todaysPrice',
        'uses' => 'TodaysPriceController@getTodaysPrice'
    ]);
    Route::get('/fetch/todaysprice', [
        'as' => 'admin.fetchTodaysPrice',
        'uses' => 'TodaysPriceController@fetchTodaysPrice'
    ]);

    /*Floor Sheet*/
    Route::get('floorsheet/view/{year?}/{month?}/{day?}', [
        'as' => 'admin.floorsheet',
        'uses' => 'FloorSheetController@index'
    ]);
    Route::get('floorsheet/add', [
        'as' => 'admin.addFloorsheet',
        'uses' => 'FloorSheetController@show'
    ]);
    Route::post('floorsheet/delete/{date}', [
        'as' => 'admin.deleteFloorsheet',
        'uses' => 'FloorSheetController@delete'
    ]);
    Route::get('floorsheet/add/excel', [
        'as' => 'admin.addFloorsheetExcel',
        'uses' => 'FloorSheetController@excel'
    ]);
    Route::get('floorsheet/add/crawl', [
        'as' => 'admin.addFloorsheetCrawler',
        'uses' => 'FloorSheetController@crawl'
    ]);
    Route::post('/crawl/headers', [
        'as' => 'admin.headers-crawler',
        'uses' => 'FloorSheetController@getHeaders'
    ]);
    Route::post('/crawl/floorsheet', [
        'as' => 'admin.floorsheet-crawler',
        'uses' => 'FloorSheetController@fetch'
    ]);
    Route::post('/crawl/floorsheet/save', [
        'as' => 'admin.floorsheet-updateAll',
        'uses' => 'FloorSheetController@save'
    ]);

    Route::post('floorsheet/upload', [
        'as' => 'admin.floorsheet.upload',
        'uses' => 'FloorSheetController@upload'
    ]);
    Route::post('floorsheet/add/db', [
        'as' => 'admin.addFloorsheetToDb',
        'uses' => 'FloorSheetController@floorsheet'
    ]);
    Route::post('latestPrice/add/db', [
        'as' => 'admin.addLatestTradedPriceToDb',
        'uses' => 'FloorSheetController@lastTradedPrice'
    ]);
    Route::post('todaysprice/add/db', [
        'as' => 'admin.addTodaysPriceToDb',
        'uses' => 'FloorSheetController@todaysPrice'
    ]);
    Route::post('advanceDecline/add/db', [
        'as' => 'admin.addAdvanceDeclineToDb',
        'uses' => 'FloorSheetController@advanceDecline'
    ]);

    Route::post('newHighLow/add/db', [
        'as' => 'admin.addNewHighLowToDb',
        'uses' => 'FloorSheetController@newHighLow'
    ]);
    Route::post('company/validate', [
        'as' => 'admin.validateCompanyList',
        'uses' => 'FloorSheetController@verify'
    ]);

    /*Bullion Type CRUD*/
    Route::resource('bullionType', 'BullionTypeController', ['only' => ['index', 'store', 'update', 'destroy']]);

    /*Bullion Price CRUD*/
    Route::resource('bullionPrice', 'BullionPriceController', ['except' => ['show']]);

    /*Energy Type CRUD*/
    Route::resource('energyType', 'EnergyTypeController', ['only' => ['index', 'store', 'update', 'destroy']]);

    /*Energy Price CRUD*/
    Route::resource('energyPrice', 'EnergyPriceController', ['except' => ['show']]);

	/*Asset Management Stock Type CRUD*/
    Route::resource('stock-type', 'AMStockTypeController', ['except' => ['show','create','edit']]);
	
    /*Currency Type CRUD*/
    Route::resource('currencyType', 'CurrencyTypeController', ['except' => ['show']]);

    /*Currency Rate CRUD*/
    Route::resource('currencyRate', 'CurrencyRateController', ['except' => ['show']]);
    Route::post('/currencyRate/upload', [
        'as' => 'admin.currencyRate.upload',
        'uses' => 'CurrencyRateController@upload'
    ]);

    /*Fiscal Year CRUD*/
    Route::resource('fiscalYear', 'FiscalYearController', ['except' => ['create', 'edit', 'destroy']]);

    /*Quarter CRUD*/
    Route::resource('quarter', 'QuarterController', ['only' => ['index', 'store', 'update', 'destroy']]);

    /*Month CRUD*/
    Route::resource('quarter.month', 'MonthController', ['only' => ['index', 'store', 'update', 'destroy']]);

    /*BOD POST CRUD*/
    Route::resource('bodPost', 'BodPostController', ['only' => ['index', 'store', 'update', 'destroy']]);

    /*BOD CRUD*/
    Route::resource('company.bod', 'BodController');

    /*Base Price CRUD*/
    Route::resource('company.basePrice', 'BasePriceController', ['except' => ['create', 'edit', 'show']]);
    Route::get('/basePrice/upload', [
        'as' => 'admin.basePrice.upload',
        'uses' => 'BasePriceController@form'
    ]);
    Route::get('/basePrice/show', [
        'as' => 'admin.basePrice.show',
        'uses' => 'BasePriceController@show'
    ]);
    Route::post('/basePrice/upload', [
        'as' => 'admin.basePrice.upload',
        'uses' => 'BasePriceController@upload'
    ]);
    Route::post('/basePrice/db', [
        'as' => 'admin.basePrice.db',
        'uses' => 'BasePriceController@save'
    ]);

    /*Financial Report CRUD*/
    Route::resource('financialReport', 'FinancialReportController');
    Route::post('/financialReport/{id}/{type}/upload', [
        'as' => 'admin.financialReport.upload',
        'uses' => 'FinancialReportController@upload'
    ]);
    Route::get('/financialReport/{id}/{type}/view', [
        'as' => 'admin.financialReport.view',
        'uses' => 'FinancialReportController@view'
    ]);
    Route::post('/financialReport/{id}/{type}/db', [
        'as' => 'admin.financialReport.db',
        'uses' => 'FinancialReportController@db'
    ]);

    /*Balance Sheet Reports*/
    Route::resource('financialReport.balanceSheet', 'BalanceSheetController', ['only' => ['create', 'store']]);
    Route::get('/financialReport/{fid}/balanceSheet/edit', [
        'as' => 'admin.financialReport.balanceSheet.edit',
        'uses' => 'BalanceSheetController@edit'
    ]);
    Route::put('/financialReport/{fid}/balanceSheet/update', [
        'as' => 'admin.financialReport.balanceSheet.update',
        'uses' => 'BalanceSheetController@update'
    ]);
    Route::delete('/financialReport/{id}/balanceSheet', [
        'as' => 'admin.financialReport.balanceSheet.destroy',
        'uses' => 'BalanceSheetController@destroy'
    ]);

    /*Profit Loss Reports*/
    Route::resource('financialReport.profitLoss', 'ProfitLossController', ['only' => ['create', 'store']]);
    Route::get('/financialReport/{fid}/profitLoss/edit', [
        'as' => 'admin.financialReport.profitLoss.edit',
        'uses' => 'ProfitLossController@edit'
    ]);
    Route::put('/financialReport/{fid}/profitLoss/update', [
        'as' => 'admin.financialReport.profitLoss.update',
        'uses' => 'ProfitLossController@update'
    ]);
    Route::delete('/financialReport/{id}/profitLoss', [
        'as' => 'admin.financialReport.profitLoss.destroy',
        'uses' => 'ProfitLossController@destroy'
    ]);

    /*Principal Indicators Reports*/
    Route::resource('financialReport.principalIndicators', 'PrincipalIndicatorsController', ['only' => ['create', 'store']]);
    Route::get('/financialReport/{fid}/principalIndicators/edit', [
        'as' => 'admin.financialReport.principalIndicators.edit',
        'uses' => 'PrincipalIndicatorsController@edit'
    ]);
    Route::put('/financialReport/{fid}/principalIndicators/update', [
        'as' => 'admin.financialReport.principalIndicators.update',
        'uses' => 'PrincipalIndicatorsController@update'
    ]);
    Route::delete('/financialReport/{id}/principalIndicators', [
        'as' => 'admin.financialReport.principalIndicators.destroy',
        'uses' => 'PrincipalIndicatorsController@destroy'
    ]);

    /*Income Statement Reports*/
    Route::resource('financialReport.incomeStatement', 'IncomeStatementController', ['only' => ['create', 'store']]);
    Route::get('/financialReport/{fid}/incomeStatement/edit', [
        'as' => 'admin.financialReport.incomeStatement.edit',
        'uses' => 'IncomeStatementController@edit'
    ]);
    Route::put('/financialReport/{fid}/incomeStatement/update', [
        'as' => 'admin.financialReport.incomeStatement.update',
        'uses' => 'IncomeStatementController@update'
    ]);
    Route::delete('/financialReport/{id}/incomeStatement', [
        'as' => 'admin.financialReport.incomeStatement.destroy',
        'uses' => 'IncomeStatementController@destroy'
    ]);

    /*Consolidate Revenue Reports*/
    Route::resource('financialReport.consolidateRevenue', 'ConsolidateRevenueController', ['only' => ['create', 'store']]);
    Route::get('/financialReport/{fid}/consolidateRevenue/edit', [
        'as' => 'admin.financialReport.consolidateRevenue.edit',
        'uses' => 'ConsolidateRevenueController@edit'
    ]);
    Route::put('/financialReport/{fid}/consolidateRevenue/update', [
        'as' => 'admin.financialReport.consolidateRevenue.update',
        'uses' => 'ConsolidateRevenueController@update'
    ]);
    Route::delete('/financialReport/{id}/consolidateRevenue', [
        'as' => 'admin.financialReport.consolidateRevenue.destroy',
        'uses' => 'ConsolidateRevenueController@destroy'
    ]);

    /*Brokerage Firm CRUD*/
    Route::resource('brokerageFirm', 'BrokerageFirmController', ['except' => ['show']]);

    /*IPO Pipeline CRUD*/
    Route::resource('ipoPipeline', 'IPOPipelineController', ['except' => ['show']]);

    /*IPO Result CRUD*/
    Route::resource('ipo-result', 'IPOResultController');
    Route::delete('/ipo-result/{id}/{date}/delete', [
        'as' => 'admin.ipo-result.destroy',
        'uses' => 'IPOResultController@destroy'
    ]);

    /*Report Label CRUD*/
    Route::resource('reportLabel', 'ReportLabelController', ['except' => ['edit', 'create', 'show', 'index']]);
    Route::get('/reportLabel/{label?}/{type?}', [
        'as' => 'admin.reportLabel.index',
        'uses' => 'ReportLabelController@index'
    ]);

    /*Budget Label CRUD*/
    Route::resource('budgetLabel', 'BudgetLabelController', ['except' => ['edit', 'create', 'show']]);

    /*Budget Sub Label CRUD*/
    Route::resource('budgetLabel.budgetSubLabel', 'BudgetSubLabelController', ['only' => ['index', 'store']]);
    Route::post('/budgetLabel/{id}/budgetSubLabel/delete', [
        'as' => 'admin.budgetLabel.budgetSubLabel.destroy',
        'uses' => 'BudgetSubLabelController@destroy'
    ]);
    Route::post('/budgetSubLabel/{id?}', [
        'as' => 'admin.budgetLabel.budgetSubLabel.update',
        'uses' => 'BudgetSubLabelController@update'
    ]);
	
	/*Budget Fiscal Year CRUD*/
    Route::resource('budgetFiscalYear', 'BudgetFiscalYearController', ['except' => ['create', 'edit', 'destroy']]);

    /*Budget CRUD*/
    Route::get('/fiscalYear/{id}/budget/{type}/create', [
        'as' => 'admin.fiscalYear.budget.create',
        'uses' => 'BudgetController@create'
    ]);
    Route::post('/fiscalYear/{id}/budget/{type}', [
        'as' => 'admin.fiscalYear.budget.store',
        'uses' => 'BudgetController@store'
    ]);
    Route::get('/fiscalYear/{id}/budget/edit', [
        'as' => 'admin.fiscalYear.budget.edit',
        'uses' => 'BudgetController@edit'
    ]);
    Route::put('/fiscalYear/{id}/budget/{type}', [
        'as' => 'admin.fiscalYear.budget.update',
        'uses' => 'BudgetController@update'
    ]);
    Route::delete('/fiscalYear/{id}/budget/{type}', [
        'as' => 'admin.fiscalYear.budget.destroy',
        'uses' => 'BudgetController@destroy'
    ]);

    /*Interview CRUD*/
    Route::resource('interview', 'InterviewController');
    //Ajax Request
    Route::post('/get/interview', [
        'as' => 'get-interview-datatable',
        'uses' => 'InterviewController@getInterviewDatatable'
    ]);
    //Deleting featured_image
    Route::delete('/interview/image/{id}/delete', [
        'as' => 'admin.interviewFeaturedImage.destroy',
        'uses' => 'ImageInterviewArticleController@destroy'
    ]);

    /*Article CRUD*/
    Route::resource('article', 'ArticleController');
    //Ajax Request
    Route::post('/get/article', [
        'as' => 'get-article-datatable',
        'uses' => 'ArticleController@getArticleDatatable'
    ]);
    //Deleting featured_image
    Route::delete('/article/image/{id}/delete', [
        'as' => 'admin.articleFeaturedImage.destroy',
        'uses' => 'ImageInterviewArticleController@destroy'
    ]);

    /*Interview Article Featured Image*/
    Route::resource('imageInterviewArticleController', 'ImageInterviewArticleController', ['only' => ['destroy']]);

    /*Economy CRUD */
    Route::resource('economy', 'EconomyController');

    /*Economy CRUD */
    Route::resource('economyLabel', 'EconomyLabelController', ['only' => ['index', 'store', 'update', 'destroy']]);

    /*Nepse Group CRUD*/
    Route::resource('nepseGroup', 'NepseGroupController', ['only' => ['index', 'destroy']]);
    Route::post('/nepseGroup/upload', [
        'as' => 'admin.nepseGroup.upload',
        'uses' => 'NepseGroupController@upload'
    ]);
    Route::get('/nepseGroup/show', [
        'as' => 'admin.nepseGroup.show',
        'uses' => 'NepseGroupController@show'
    ]);
    Route::post('/nepseGroup/db', [
        'as' => 'admin.nepseGroup.db',
        'uses' => 'NepseGroupController@db'
    ]);

    Route::post('/logout', ['as' => 'admin.logout', 'uses' => 'LoginController@logout']);
});
Route::group(['prefix' => 'api'], function () {
    Route::post('admin/announcement/type/subtype', [
        'as' => 'admin.api.get.announcement.subtype',
        'uses' => 'ApiController@getAnnouncementTypeSubtypes'
    ]);
    Route::match(['post', 'put'], 'admin/announcement/dynamic', [
        'as' => 'admin.api.get.announcement.dynamic',
        'uses' => 'ApiController@getAnnouncementDynamicContents'
    ]);
    Route::post('admin/announcement-form', [
        'as' => 'admin.api-get-dynamic-announcement-form',
        'uses' => 'ApiController@getAnnouncementForm'
    ]);
    Route::any('search/company', [
        'as' => 'api-search-company',
        'uses' => 'ApiController@searchCompany'
    ]);
    Route::post('admin/search/announcement', [
        'as' => 'admin.api.search.announcement',
        'uses' => 'ApiController@searchAnnouncement'
    ]);
    Route::post('admin/search/announcement/recent', [
        'as' => 'admin.api.search.recent.announcement',
        'uses' => 'ApiController@searchRecentAnnouncement'
    ]);

    Route::post('admin/fiscalYear', [
        'as' => 'admin.api-search-fiscal-year',
        'uses' => 'ApiController@searchFiscalYear'
    ]);

    Route::post('admin/financialReport', [
        'as' => 'admin.api-search-reportLabel',
        'uses' => 'ApiController@searchReportLabel'
    ]);

    Route::post('admin/financialReport', [
        'as' => 'admin.api-search-reportLabelInsurance',
        'uses' => 'ApiController@searchReportLabelInsurance'
    ]);

    Route::post('/admin/budget', [
        'as' => 'admin.api-search-budgetLabel',
        'uses' => 'ApiController@searchBudgetLabel'
    ]);
    Route::get('/admin/financialReport/download/{type}', [
        'as' => 'admin.sampleReport',
        'uses' => 'ApiController@getSample'
    ]);


    Route::post('/gainer', [
        'as' => 'api-get-gainer',
        'uses' => 'ApiController@getGainer'
    ]);
    Route::post('/loser/', [
        'as' => 'api-get-loser',
        'uses' => 'ApiController@getLoser'
    ]);
    Route::post('/active', [
        'as' => 'api-get-active',
        'uses' => 'ApiController@getActive'
    ]);
    Route::post('/latest-traded-price', [
        'as' => 'api-get-latest-traded-price',
        'uses' => 'ApiController@getLatestTradedPrice'
    ]);
    Route::post('/advance-decline', [
        'as' => 'api-get-advance-decline',
        'uses' => 'ApiController@getAdvanceDecline'
    ]);
    Route::post('/get-new-high', [
        'as' => 'api-get-new-high',
        'uses' => 'ApiController@getNewHigh'
    ]);
    Route::post('/get-new-low', [
        'as' => 'api-get-new-low',
        'uses' => 'ApiController@getNewLow'
    ]);
    Route::post('/todays-price/duration', [
        'as' => 'api-get-todays-price-duration',
        'uses' => 'ApiController@getTodaysPriceByDuration'
    ]);
    Route::post('/todays-price/duration/sector', [
        'as' => 'api-get-todays-price-duration-by-sector',
        'uses' => 'ApiController@getSectorTodaysPriceByDuration'
    ]);

    Route::post('/todays-price', [
        'as' => 'api-get-todays-price-day',
        'uses' => 'ApiController@getTodaysPriceByDay'
    ]);
    Route::post('/todays-price/ohlc', [
        'as' => 'api-get-todays-price-ohlc',
        'uses' => 'ApiController@getTodaysPriceOHLC'
    ]);
    Route::post('/average-todays-price/company', [
        'as' => 'api-get-average-todays-price-list-by-company',
        'uses' => 'ApiController@getAverageTodaysPriceListByCompanyId'
    ]);
    Route::post('/average-price/company/duration', [
        'as' => 'api-get-company-average-todays-price-by-duration',
        'uses' => 'ApiController@getAverageTodaysPriceByCompanyId'
    ]);
    Route::any('/average-todays-price/transaction', [
        'as' => 'api-get-average-todays-price-by-transaction',
        'uses' => 'ApiController@getAverageTodaysPriceByTransaction'
    ]);
    Route::post('/average-todays-price', [
        'as' => 'api-get-average-todays-price',
        'uses' => 'ApiController@getAverageTodaysPrice'
    ]);
    Route::post('/index', [
        'as' => 'api-get-index',
        'uses' => 'ApiController@getIndex'
    ]);
    Route::post('/index/datatable', [
        'as' => 'api-get-index-datatable',
        'uses' => 'ApiController@getIndexDatatable'
    ]);
    Route::post('/floorsheet', [
        'as' => 'api-get-floorsheet',
        'uses' => 'ApiController@getFloorsheet'
    ]);
    Route::post('/indexes/ohlc', [
        'as' => 'api-get-indexes-ohlc',
        'uses' => 'ApiController@getIndexesOHLC'
    ]);
    Route::post('/indexes/summary', [
        'as' => 'api-get-indexes-summary',
        'uses' => 'ApiController@getIndexesSummary'
    ]);
    Route::post('/market/summary', [
        'as' => 'api-get-market-summary',
        'uses' => 'ApiController@getMarketSummary'
    ]);
    Route::post('/market/summary/detailed', [
        'as' => 'api-get-detailed-market-summary',
        'uses' => 'ApiController@getDetailedMarketSummary'
    ]);
    Route::get('/floorsheet/sample', [
        'as' => 'get-floorsheet-sample',
        'uses' => 'FloorSheetController@getSample'
    ]);
    Route::post('/index/summary/datatable', [
        'as' => 'api-get-index-summary-datatable',
        'uses' => 'ApiController@getIndexSummaryDatatable'
    ]);
    Route::post('/todays/summary/datatable', [
        'as' => 'api-get-todays-summary-datatable',
        'uses' => 'ApiController@getTodaysSummaryDatatable'
    ]);
    Route::post('/company/trans', [
        'as' => 'api-get-company-transactions',
        'uses' => 'ApiController@getCompanyTrans'
    ]);
    Route::post('company/{company_id}/close/{ohlc?}', [
        'as' => 'api-get-company-close',
        'uses' => 'ApiController@getCompanyClose'
    ]);
    Route::post('index/close/{index_id}', [
        'as' => 'api-get-index-close',
        'uses' => 'ApiController@getIndexClose'
    ]);
    Route::post('todays/traded-days', [
        'as' => 'api-get-traded-days',
        'uses' => 'ApiController@getNOFTradedDaysBetween'
    ]);


    Route::post('/bullion', [
        'as' => 'api-get-bullion',
        'uses' => 'ApiController@getBullion'
    ]);
    Route::post('/bullion/datatable', [
        'as' => 'api-get-bullion-datatable',
        'uses' => 'ApiController@getBullionDatatable'
    ]);
    Route::post('/energy', [
        'as' => 'api-get-energy',
        'uses' => 'ApiController@getEnergy'
    ]);
    Route::post('/energy/datatable', [
        'as' => 'api-get-energy-datatable',
        'uses' => 'ApiController@getEnergyDatatable'
    ]);
    Route::post('/currency', [
        'as' => 'api-get-currency',
        'uses' => 'ApiController@getCurrency'
    ]);
    Route::post('/currency/datatable', [
        'as' => 'api-get-currency-datatable',
        'uses' => 'ApiController@getCurrencyDatatable'
    ]);
    Route::any('/ipo-pipeline', [
        'as' => 'api-get-ipo-pipeline',
        'uses' => 'ApiController@getIpoPipeline'
    ]);
    Route::post('/issue-manager', [
        'as' => 'api-get-issue-manager',
        'uses' => 'ApiController@getIssueManager'
    ]);
    Route::post('/brokerage-firm', [
        'as' => 'api-get-brokerage-firm',
        'uses' => 'ApiController@getBrokerageFirm'
    ]);
    Route::post('/base-price', [
        'as' => 'api-get-base-price',
        'uses' => 'ApiController@getBasePrice'
    ]);
    Route::post('/ipo-result', [
        'as' => 'api-get-ipo-result',
        'uses' => 'IPOResultController@getIpoResult'
    ]);
    Route::post('/search-ipo-result', [
        'as' => 'api-search-ipo-result',
        'uses' => 'IPOResultController@searchIpoResult'
    ]);
    Route::post('/budget', [
        'as' => 'api-get-budget',
        'uses' => 'ApiController@getBudget'
    ]);
});