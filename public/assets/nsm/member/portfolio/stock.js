/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _App = __webpack_require__(1);

	var _App2 = _interopRequireDefault(_App);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	$(document).ready(function () {
		new _App2.default();
	});

/***/ },
/* 1 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
		value: true
	});

	var _dataTableNames = __webpack_require__(2);

	var DTN = _interopRequireWildcard(_dataTableNames);

	var _dataTableElements = __webpack_require__(3);

	var DTE = _interopRequireWildcard(_dataTableElements);

	var _dataTableSettings = __webpack_require__(4);

	var DTS = _interopRequireWildcard(_dataTableSettings);

	var _tabPaneNames = __webpack_require__(5);

	var TPN = _interopRequireWildcard(_tabPaneNames);

	var _tabPaneElements = __webpack_require__(6);

	var TPE = _interopRequireWildcard(_tabPaneElements);

	var _tabPaneAnchors = __webpack_require__(7);

	var TPA = _interopRequireWildcard(_tabPaneAnchors);

	var _modalNames = __webpack_require__(8);

	var MN = _interopRequireWildcard(_modalNames);

	var _GroupedView = __webpack_require__(9);

	var _GroupedView2 = _interopRequireDefault(_GroupedView);

	var _SellView = __webpack_require__(11);

	var _SellView2 = _interopRequireDefault(_SellView);

	var _BuyView = __webpack_require__(12);

	var _BuyView2 = _interopRequireDefault(_BuyView);

	var _Datatable = __webpack_require__(13);

	var _Datatable2 = _interopRequireDefault(_Datatable);

	var _Notify = __webpack_require__(14);

	var _Notify2 = _interopRequireDefault(_Notify);

	var _Views = __webpack_require__(15);

	var _Views2 = _interopRequireDefault(_Views);

	var _Event = __webpack_require__(23);

	var _Event2 = _interopRequireDefault(_Event);

	var _BuyModal = __webpack_require__(17);

	var _BuyModal2 = _interopRequireDefault(_BuyModal);

	var _SellModal = __webpack_require__(25);

	var _SellModal2 = _interopRequireDefault(_SellModal);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

	function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } } /* CONSTANTS */

	/* CLASSES */


	var App = function App() {
		var _datatables, _ref, _modals;

		_classCallCheck(this, App);

		this.notify = new _Notify2.default(this);

		this.event = new _Event2.default(this);

		this.datatables = (_datatables = {}, _defineProperty(_datatables, DTN.GROUPED, new _Datatable2.default(this, DTE.GROUPED, DTS.GROUPED)), _defineProperty(_datatables, DTN.BUY, new _Datatable2.default(this, DTE.BUY, DTS.BUY)), _defineProperty(_datatables, DTN.SELL, new _Datatable2.default(this, DTE.SELL, DTS.SELL)), _datatables);

		this.views = new _Views2.default(this, (_ref = {}, _defineProperty(_ref, TPN.GROUPED, new _GroupedView2.default(this, TPE.GROUPED, TPA.GROUPED, TPN.GROUPED)), _defineProperty(_ref, TPN.BUY, new _BuyView2.default(this, TPE.BUY, TPA.BUY, TPN.BUY)), _defineProperty(_ref, TPN.SELL, new _SellView2.default(this, TPE.SELL, TPA.SELL, TPN.SELL)), _ref));

		this.modals = (_modals = {}, _defineProperty(_modals, MN.BUY, new _BuyModal2.default(this, this.datatables[DTN.BUY])), _defineProperty(_modals, MN.SELL, new _SellModal2.default(this, this.datatables[DTN.SELL])), _modals);

		window.app = this;
	};

	exports.default = App;

/***/ },
/* 2 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	/* Datatable names */
	var GROUPED = exports.GROUPED = 'grouped';
	var DETAILS = exports.DETAILS = 'details';
	var SELL = exports.SELL = 'sell';
	var BUY = exports.BUY = 'buy';
	/* end of Datatable names */

/***/ },
/* 3 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	/* Datatable names */
	var GROUPED = exports.GROUPED = $('table[data-table=grouped]');
	var BUY = exports.BUY = $('table[data-table=buy]');
	var SELL = exports.SELL = $('table[data-table=sell]');
	/* end of Datatable names */

/***/ },
/* 4 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	exports.SELL = exports.BUY = exports.GROUPED = undefined;

	var _dataTableElements = __webpack_require__(3);

	var DTE = _interopRequireWildcard(_dataTableElements);

	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

	var GROUPED = exports.GROUPED = {
	    ajax: {
	        url: DTE.GROUPED.data('url'),
	        type: 'POST',
	        data: {
	            basket_id: function basket_id() {
	                return $('select[data-name=baskets]').val();
	            }
	        }
	    },
	    footerCallback: function footerCallback(row, data, start, end, display) {
	        var self = this;

	        var investment = 0;
	        var market_value = 0;
	        var profit_loss = {
	            change: 0,
	            percent: 0
	        };
	        $.each(data, function (i, row) {
	            investment += row.investment;
	            market_value += row.market_value;
	            profit_loss.change += row.profit_loss;
	        });

	        profit_loss.percent = parseFloat(Math.abs((market_value - investment) * 100 / (investment || market_value))).toFixed(2);
	        profit_loss.change = parseFloat(profit_loss.change).toFixed(2);
	        investment = parseFloat(investment).toFixed(2);
	        market_value = parseFloat(market_value).toFixed(2);

	        // Update footer
	        var dataChange = profit_loss.change > 0 ? "up" : profit_loss.change < 0 ? 'down' : 'neutral';

	        $('#grouped-view span[data-investment]').text(investment);
	        $('#grouped-view span[data-market-value]').text(market_value);
	        $('#grouped-view span[data-change]').html('<span data-change="' + dataChange + '">' + profit_loss.change + '  <small>(' + profit_loss.percent + ' %)</small></span>');
	    },

	    columns: [{ data: 'company_quote', searchable: true, render: function render(data, type, row, meta) {
	            return '<a href="/quote/' + data + '" target="_blank"><span data-toggle="tooltip" data-placement="down" title="' + row.company_name + '">' + data + '</span></a>';
	        }
	    }, { data: 'buy_rate', render: function render(data, type, row, meta) {
	            return parseFloat(data).toFixed(2);
	        }
	    }, { data: 'remaining_quantity', searchable: false }, { data: 'close_price', searchable: false, render: function render(data, type, row, meta) {
	            var closeDate = moment(row.close_date).format('D MMM. YY');
	            return data == null ? 'NA' : data + ' <small>(' + closeDate + ')</small>';
	        }
	    }, { data: 'investment', searchable: false, render: function render(data, type, row, meta) {
	            return parseFloat(data).toFixed(2);
	        }
	    }, { data: 'market_value', searchable: false, render: function render(data, type, row, meta) {
	            return parseFloat(data).toFixed(2);
	        }
	    }, { data: 'profit_loss', searchable: false, render: function render(data, type, row, meta) {
	            if (!data) return 'NA';

	            var changePercent = Math.abs(parseFloat(100 * (row.market_value - row.investment) / (row.investment || row.market_value)).toFixed(2));

	            var dataChange = data > 0 ? 'up' : data < 0 ? 'down' : 'neutral';

	            return '<span data-change="' + dataChange + '">' + parseFloat(data).toFixed(2) + ' <small>(' + changePercent + '%)</small></span>';
	        }
	    }, { data: 'total_stocks' }, { data: null, orderable: false, searchable: false, render: function render(data, type, row, meta) {
	            return '<button class="btn btn-box-tool" data-change-view="buy" data-name="' + row.company_name + '" data-id="' + row.company_id + '" data-toggle="tooltip" data-placement="top" title="More Details"><i class="fa fa-chevron-circle-right"></i></button>';
	        }
	    }]
	};

	var BUY = exports.BUY = {
	    ajax: {
	        url: DTE.BUY.data('url'),
	        type: 'POST',
	        data: {
	            basket_id: function basket_id() {
	                return $('select[data-name=baskets]').val();
	            },
	            company_id: function company_id() {
	                return $('input[name=company_id]').val();
	            }
	        }
	    },
	    footerCallback: function footerCallback(row, data, start, end, display) {
	        var investment = 0;
	        var market_value = 0;
	        var profit_loss = {
	            change: 0,
	            percent: 0
	        };

	        $.each(data, function (i, row) {
	            investment += row.investment;
	            market_value += row.market_value;
	            profit_loss.change += row.profit_loss;
	        });

	        profit_loss.percent = parseFloat(Math.abs((market_value - investment) * 100 / (investment || market_value))).toFixed(2);
	        profit_loss.change = parseFloat(profit_loss.change).toFixed(2);
	        investment = parseFloat(investment).toFixed(2);
	        market_value = parseFloat(market_value).toFixed(2);

	        // Update footer
	        var dataChange = profit_loss.change > 0 ? "up" : profit_loss.change < 0 ? 'down' : 'neutral';

	        $('#buy-view span[data-investment]').text(investment);
	        $('#buy-view span[data-market-value]').text(market_value);
	        $('#buy-view span[data-change]').html('<span data-change="' + dataChange + '">' + profit_loss.change + '  <small>(' + profit_loss.percent + ' %)</small></span>');
	    },

	    columns: [{ data: 'company_quote', searchable: true, render: function render(data, type, row, meta) {
	            return '<a href="/quote/' + data + '" target="_blank"><span data-toggle="tooltip" data-placement="down" title="' + row.company_name + '">' + data + '</span></a>';
	        }
	    }, { data: 'buy_rate', searchable: false, render: function render(data, type, row, meta) {
	            return parseFloat(data).toFixed(2);
	        }
	    }, { data: 'remaining_quantity', searchable: false }, { data: 'close_price', searchable: false, render: function render(data, type, row, meta) {
	            var closeDate = moment(row.close_date).format('D MMM. YY');
	            return data == null ? 'NA' : data + ' <small>(' + closeDate + ')</small>';
	        }
	    }, { data: 'investment', searchable: false, render: function render(data, type, row, meta) {
	            return parseFloat(data).toFixed(2);
	        }
	    }, { data: 'market_value', searchable: false, render: function render(data, type, row, meta) {
	            return parseFloat(data).toFixed(2);
	        }
	    }, { data: 'profit_loss', searchable: false, render: function render(data, type, row, meta) {
	            if (!data) return 'NA';

	            var changePercent = Math.abs(parseFloat(100 * (row.market_value - row.investment) / (row.investment || row.market_value)).toFixed(2));

	            var dataChange = data > 0 ? 'up' : data < 0 ? 'down' : 'neutral';

	            return '<span data-change="' + dataChange + '">' + parseFloat(data).toFixed(2) + ' <small>(' + changePercent + '%)</small></span>';
	        }
	    }, { data: null, orderable: false, searchable: false, render: function render(data, type, row, meta) {
	            return '\n                <button class="btn btn-box-tool" \n                    data-modal="buy" \n                    data-id="' + row.id + '"\n                    data-toggle="tooltip" \n                    data-placement="top" \n                    title="Edit"\n                ><i class="fa fa-edit"></i></button>\n\n                <button class="btn btn-box-tool" \n                    data-change-view="sell" \n                    data-name="' + row.company_name + '" data-id="' + row.id + '" \n                    data-toggle="tooltip" \n                    data-placement="top" \n                    title="Sales"\n                ><i class="fa fa-history"></i></button>\n\n                <button class="btn btn-box-tool" \n                    data-change-view="details"\n                    data-name="' + row.company_name + '" data-id="' + row.id + '" \n                    data-toggle="tooltip" \n                    data-placement="top" \n                    title="Details"\n                ><i class="fa fa-info-circle"></i></button>\n\n                <button class="btn btn-box-tool"\n                    data-name="' + row.company_name + '" data-id="' + row.id + '" \n                    data-toggle="tooltip" \n                    data-placement="top" \n                    title="Delete"\n                ><i class="fa fa-trash"></i></button>\n            ';
	        }
	    }]
	};

	var SELL = exports.SELL = {
	    ajax: {
	        url: DTE.SELL.data('url'),
	        type: 'POST',
	        data: {
	            basket_id: function basket_id() {
	                return $('select[data-name=baskets]').val();
	            },
	            buy_id: function buy_id() {
	                return $('input[name=buy_id]').val();
	            }
	        }
	    },
	    footerCallback: function footerCallback(row, data, start, end, display) {
	        var investment = 0;
	        var sales_value = 0;
	        var profit_loss = {
	            change: 0,
	            percent: 0
	        };

	        $.each(data, function (i, row) {
	            investment += row.investment;
	            sales_value += row.sales_value;
	            profit_loss.change += row.profit_loss;
	        });

	        profit_loss.percent = parseFloat(Math.abs((sales_value - investment) * 100 / (investment || sales_value))).toFixed(2);
	        profit_loss.change = parseFloat(profit_loss.change).toFixed(2);
	        investment = parseFloat(investment).toFixed(2);
	        sales_value = parseFloat(sales_value).toFixed(2);

	        // Update footer
	        var dataChange = profit_loss.change > 0 ? "up" : profit_loss.change < 0 ? 'down' : 'neutral';

	        $('#sell-view span[data-investment]').text(investment);
	        $('#sell-view span[data-sales-value]').text(sales_value);
	        $('#sell-view span[data-change]').html('<span data-change="' + dataChange + '">' + profit_loss.change + '  <small>(' + profit_loss.percent + ' %)</small></span>');
	    },

	    columns: [{ data: 'sell_date', searchable: true, render: function render(data, type, row, meta) {
	            return moment(data).format('D MMM, YYYY');
	        }
	    }, { data: 'sell_quantity', searchable: false }, { data: 'sell_rate', searchable: false }, { data: 'sell_commission', searchable: false }, { data: 'sell_tax', searchable: false }, { data: 'buy_rate_computed', render: function render(data) {
	            return parseFloat(data).toFixed(2);
	        }
	    }, { data: 'investment', render: function render(data) {
	            return parseFloat(data).toFixed(2);
	        }
	    }, { data: 'sales_value', render: function render(data, type, row, meta) {
	            return parseFloat(data).toFixed(2);
	        }
	    }, { data: 'profit_loss', render: function render(data, type, row, meta) {
	            if (!data) return 'NA';

	            var changePercent = Math.abs(parseFloat(100 * (row.sales_value - row.investment) / (row.investment || row.sales_value)).toFixed(2));

	            var dataChange = data > 0 ? 'up' : data < 0 ? 'down' : 'neutral';

	            return '<span data-change="' + dataChange + '">' + parseFloat(data).toFixed(2) + ' <small>(' + changePercent + '%)</small></span>';
	        }
	    }, { data: null, orderable: false, searchable: false, render: function render(data, type, row, meta) {
	            return '\n                <button class="btn btn-box-tool" \n                    data-modal="sell" \n                    data-id="' + row.id + '"\n                    data-toggle="tooltip" \n                    data-placement="top" \n                    title="Edit"\n                ><i class="fa fa-edit"></i></button>\n\n                <button class="btn btn-box-tool"\n                    data-id="' + row.id + '" \n                    data-toggle="tooltip" \n                    data-placement="top" \n                    title="Delete"\n                ><i class="fa fa-trash"></i></button>\n            ';
	        }
	    }]
	};

/***/ },
/* 5 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	var GROUPED = exports.GROUPED = 'grouped';
	var BUY = exports.BUY = 'buy';
	var SELL = exports.SELL = 'sell';
	var DETAILS = exports.DETAILS = 'details';

/***/ },
/* 6 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	var GROUPED = exports.GROUPED = $('#grouped-view');
	var BUY = exports.BUY = $('#buy-view');
	var SELL = exports.SELL = $('#sell-view');

/***/ },
/* 7 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	var GROUPED = exports.GROUPED = $('a[href="#grouped-view"]');
	var BUY = exports.BUY = $('a[href="#buy-view"]');
	var SELL = exports.SELL = $('a[href="#sell-view"]');

/***/ },
/* 8 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	/* Modal names */
	var BUY = exports.BUY = 'buy';
	var SELL = exports.SELL = 'sell';
	/* end of Modal names */

/***/ },
/* 9 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
		value: true
	});

	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

	var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

	var _ViewPane2 = __webpack_require__(10);

	var _ViewPane3 = _interopRequireDefault(_ViewPane2);

	var _dataTableNames = __webpack_require__(2);

	var DTN = _interopRequireWildcard(_dataTableNames);

	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

	function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

	function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

	var GroupedView = function (_ViewPane) {
		_inherits(GroupedView, _ViewPane);

		function GroupedView() {
			_classCallCheck(this, GroupedView);

			return _possibleConstructorReturn(this, Object.getPrototypeOf(GroupedView).apply(this, arguments));
		}

		_createClass(GroupedView, [{
			key: 'listenEvents',
			value: function listenEvents() {
				_get(Object.getPrototypeOf(GroupedView.prototype), 'listenEvents', this).call(this);

				this.listenBasketChangeEvent();
				this.listenDatatableEvents();
			}
		}, {
			key: 'listenDatatableEvents',
			value: function listenDatatableEvents() {
				this.datatable().$el.on('processing.dt', function (e, setting, processing) {
					console.debug('Grouped Table Processing:', processing);
				});
			}
		}, {
			key: 'listenBasketChangeEvent',
			value: function listenBasketChangeEvent() {
				var _this = this;
				$(document).on('change', 'select[data-name="baskets"]', function () {
					var selected = $(this).find('option:selected').text();
					_this.app.datatables[DTN.GROUPED].reload();
					_this.$el.find('span[data-title]').text(selected);
				});

				this.$el.find('span[data-title]').text($('select[data-name="baskets"] > option:selected').text());
			}
		}]);

		return GroupedView;
	}(_ViewPane3.default);

	exports.default = GroupedView;

/***/ },
/* 10 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
		value: true
	});

	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

	var ViewPane = function () {
		function ViewPane(app, element, anchor, datatableName) {
			var modal = arguments.length <= 4 || arguments[4] === undefined ? null : arguments[4];

			_classCallCheck(this, ViewPane);

			this.app = app;
			this.$el = $(element);
			this.$anchor = $(anchor);
			this.datatableName = datatableName;
			this.modal = modal;

			this.listenEvents();
		}

		_createClass(ViewPane, [{
			key: 'datatable',
			value: function datatable() {
				return this.app.datatables[this.datatableName];
			}
		}, {
			key: 'show',
			value: function show() {
				if (!this.datatable().isInitialized()) {
					this.datatable().run();
				}

				this.$anchor.tab('show');
			}
		}, {
			key: 'listenEvents',
			value: function listenEvents() {
				if (this.modal) this.modal.listenEvents(this.$el);
			}
		}]);

		return ViewPane;
	}();

	exports.default = ViewPane;

/***/ },
/* 11 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
		value: true
	});

	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

	var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

	var _ViewPane2 = __webpack_require__(10);

	var _ViewPane3 = _interopRequireDefault(_ViewPane2);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

	function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

	function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

	var SellView = function (_ViewPane) {
		_inherits(SellView, _ViewPane);

		function SellView() {
			_classCallCheck(this, SellView);

			return _possibleConstructorReturn(this, Object.getPrototypeOf(SellView).apply(this, arguments));
		}

		_createClass(SellView, [{
			key: 'show',
			value: function show(data) {
				this.setViewData(data);

				_get(Object.getPrototypeOf(SellView.prototype), 'show', this).call(this);
			}
		}, {
			key: 'setViewData',
			value: function setViewData(_ref) {
				var id = _ref.id;
				var name = _ref.name;

				if (!id || !name) return;

				this.$el.find('input[name=buy_id]').val(id);
				this.$el.find('span[data-title]').text(name);

				this.datatable().reload();
			}
		}, {
			key: 'listenEvents',
			value: function listenEvents() {
				this.listenDatatableEvents();
			}
		}, {
			key: 'listenDatatableEvents',
			value: function listenDatatableEvents() {
				this.datatable().$el.on('processing.dt', function (e, setting, processing) {
					console.debug('Sell Table Processing:', processing);
				});
			}
		}]);

		return SellView;
	}(_ViewPane3.default);

	exports.default = SellView;

/***/ },
/* 12 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
		value: true
	});

	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

	var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

	var _ViewPane2 = __webpack_require__(10);

	var _ViewPane3 = _interopRequireDefault(_ViewPane2);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

	function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

	function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

	var BuyView = function (_ViewPane) {
		_inherits(BuyView, _ViewPane);

		function BuyView() {
			_classCallCheck(this, BuyView);

			return _possibleConstructorReturn(this, Object.getPrototypeOf(BuyView).apply(this, arguments));
		}

		_createClass(BuyView, [{
			key: 'show',
			value: function show(data) {
				this.setViewData(data);

				_get(Object.getPrototypeOf(BuyView.prototype), 'show', this).call(this);
			}
		}, {
			key: 'setViewData',
			value: function setViewData(_ref) {
				var id = _ref.id;
				var name = _ref.name;

				if (!id || !name) return;

				this.$el.find('input[name=company_id]').val(id);
				this.$el.find('span[data-title]').text(name);

				this.datatable().reload();
			}
		}, {
			key: 'listenEvents',
			value: function listenEvents() {
				this.listenDatatableEvents();
			}
		}, {
			key: 'listenDatatableEvents',
			value: function listenDatatableEvents() {
				this.datatable().$el.on('processing.dt', function (e, setting, processing) {
					console.debug('Buy Table Processing:', processing);
				});
			}
		}]);

		return BuyView;
	}(_ViewPane3.default);

	exports.default = BuyView;

/***/ },
/* 13 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
		value: true
	});

	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

	var SETTINGS = {
		processing: true,
		paging: true,
		serverSide: true,
		aLengthMenu: [[50, 100, 150, 200], [50, 100, 150, 200]],
		iDisplayLength: 50,
		drawCallback: function drawCallback() {
			$(window).trigger('resize');
		}
	};

	var Datatable = function () {
		/**
	  * constructor() Datatable class contructor
	  * @param {App} app
	  * @param {DOMElement} element, table element to initialize DataTable on
	  * @param {Object} settings, DataTable settings
	  */
		function Datatable(app, element) {
			var settings = arguments.length <= 2 || arguments[2] === undefined ? {} : arguments[2];

			_classCallCheck(this, Datatable);

			this.app = app;
			this.$el = $(element);
			this.settings = settings;
			this.datatable = null;
			this.initialized = false;
		}

		/**
	  * getSettings() extends DEFAULT_SETTINGS 
	  * param {Object} settings to overwrite or extend
	  * @return {Object} DataTable settings
	  */


		_createClass(Datatable, [{
			key: 'getSettings',
			value: function getSettings(settings) {
				return $.extend({}, SETTINGS, settings);
			}

			/**
	   * run() initialize DataTable
	   * @return {Datatable}
	   */

		}, {
			key: 'run',
			value: function run() {
				if (this.datatable) {
					this.reload();
				} else {
					this.datatable = this.$el.DataTable(this.getSettings(this.settings));

					this.initialized = true;
				}

				return this;
			}

			/**
	   * reload() refetch and redraw DataTable
	   * @return {Datatable}
	   */

		}, {
			key: 'reload',
			value: function reload() {
				if (this.datatable) {
					this.datatable.ajax.reload();
				}

				return this;
			}
		}, {
			key: 'isInitialized',
			value: function isInitialized() {
				return this.initialized;
			}
		}, {
			key: 'json',
			value: function json() {
				return this.datatable ? this.datatable.ajax.json() : null;
			}
		}, {
			key: 'find',
			value: function find(key, value) {
				var strict = arguments.length <= 2 || arguments[2] === undefined ? false : arguments[2];

				var json = this.json();

				if (!json || !json.recordsFiltered) return null;

				for (var i = json.data.length - 1; i >= 0; i--) {
					if (strict && json.data[i][key] === value) {
						return json.data[i];
					} else if (!strict && json.data[i][key] == value) {
						return json.data[i];
					}
				}

				return null;
			}
		}]);

		return Datatable;
	}();

	exports.default = Datatable;

/***/ },
/* 14 */
/***/ function(module, exports) {

	"use strict";

	Object.defineProperty(exports, "__esModule", {
		value: true
	});

	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

	var DEFAULT_NOTIFY_OPTIONS = {
		allow_dismiss: true,
		newest_on_top: true,
		placement: {
			from: "bottom",
			align: "right"
		},
		offset: 20,
		spacing: 10,
		z_index: 9999,
		delay: 5000,
		timer: 1000,
		type: 'info',
		mouse_over: 'pause'
	};

	var Notify = function () {
		function Notify(app) {
			var options = arguments.length <= 1 || arguments[1] === undefined ? {} : arguments[1];

			_classCallCheck(this, Notify);

			this.app = app;
			this.notifications = {};
			this.options = $.extend({}, DEFAULT_NOTIFY_OPTIONS, options);
		}

		_createClass(Notify, [{
			key: "info",
			value: function info(message) {
				var title = arguments.length <= 1 || arguments[1] === undefined ? 'Info' : arguments[1];

				this.show({ icon: 'fa fa-info', title: title, message: message }, 'info');
				return this;
			}
		}, {
			key: "success",
			value: function success(message) {
				var title = arguments.length <= 1 || arguments[1] === undefined ? 'Success' : arguments[1];

				this.show({ icon: 'fa fa-bell', title: title, message: message }, 'success');
				return this;
			}
		}, {
			key: "warning",
			value: function warning(message) {
				var title = arguments.length <= 1 || arguments[1] === undefined ? 'Warning' : arguments[1];

				this.show({ icon: 'fa fa-warning', title: title, message: message }, 'warning');
				return this;
			}
		}, {
			key: "danger",
			value: function danger(message) {
				var title = arguments.length <= 1 || arguments[1] === undefined ? 'Danger' : arguments[1];

				this.show({ icon: 'fa fa-warning', title: title, message: message }, 'danger');
				return this;
			}
		}, {
			key: "show",
			value: function show(data, type) {
				this.push(type, data);
				$.notify(data, this.options).update('type', 'pastel-' + type);
			}
		}, {
			key: "push",
			value: function push(type, _ref) {
				var message = _ref.message;

				this.notifications[type] = this.notifications[type] || [];
				this.notifications[type].push({
					time: moment().format('h:m A'),
					message: message
				});
			}
		}, {
			key: "list",
			value: function list() {
				return this.notifications;
			}
		}]);

		return Notify;
	}();

	exports.default = Notify;

/***/ },
/* 15 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
		value: true
	});

	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();
	//import StockBuyModal from './modals/stock-buy-modal.js'


	var _tabPaneNames = __webpack_require__(5);

	var TPN = _interopRequireWildcard(_tabPaneNames);

	var _modalNames = __webpack_require__(8);

	var MN = _interopRequireWildcard(_modalNames);

	var _helpers = __webpack_require__(16);

	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

	var Views = function () {
		function Views(App, VuePaneList) {
			_classCallCheck(this, Views);

			this.app = App;
			this.views = VuePaneList;
			this.current = {
				view: null,
				params: {}
			};

			this.listenEvents();

			this.show(TPN.GROUPED);
		}

		_createClass(Views, [{
			key: 'show',
			value: function show(name) {
				var params = arguments.length <= 1 || arguments[1] === undefined ? {} : arguments[1];

				this.current = { name: name, params: params };
				this.views[name].show(params);
			}
		}, {
			key: 'listenEvents',
			value: function listenEvents() {
				//change to buy view when clicked on
				this.listenViewChangeEvents();
				this.listenModalEvents();
			}
		}, {
			key: 'listenViewChangeEvents',
			value: function listenViewChangeEvents() {
				var _this = this;
				$(document).on('click', '[data-change-view]', function () {
					var target = $(this);
					var view = target.data('change-view');

					var id = target.data('id');
					var name = target.data('name');

					var params = id && name ? { id: id, name: name } : {};

					console.log(view, params);

					switch (target.data('change-view')) {
						case TPN.GROUPED:
							_this.show(TPN.GROUPED, params);
							break;

						case TPN.BUY:
							_this.show(TPN.BUY, params);
							break;

						case TPN.SELL:
							_this.show(TPN.SELL, params);
							break;
					}
				});
			}
		}, {
			key: 'listenModalEvents',
			value: function listenModalEvents() {
				var _this = this;

				$(document).on('click', '[data-modal]', function (e) {
					var target = $(this);
					var id = target.data('id');
					var modalName = target.data('modal');
					console.info('Opening Modal', modalName);

					_this.app.modals[modalName].open(id);
				});
			}
		}]);

		return Views;
	}();

	exports.default = Views;

/***/ },
/* 16 */
/***/ function(module, exports) {

	"use strict";

	Object.defineProperty(exports, "__esModule", {
		value: true
	});
	exports.finder = finder;
	function finder(context, element) {
		return $(context).find(element);
	}

/***/ },
/* 17 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
		value: true
	});

	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

	var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

	var _Modal2 = __webpack_require__(18);

	var _Modal3 = _interopRequireDefault(_Modal2);

	var _utils = __webpack_require__(19);

	var _templateHtml = __webpack_require__(22);

	var TEMPLATE = _interopRequireWildcard(_templateHtml);

	var _eventNames = __webpack_require__(24);

	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

	function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

	function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

	var BuyModal = function (_Modal) {
		_inherits(BuyModal, _Modal);

		function BuyModal() {
			_classCallCheck(this, BuyModal);

			return _possibleConstructorReturn(this, Object.getPrototypeOf(BuyModal).apply(this, arguments));
		}

		_createClass(BuyModal, [{
			key: 'open',
			value: function open() {
				var id = arguments.length <= 0 || arguments[0] === undefined ? null : arguments[0];

				id ? this.edit(id) : this.create();
			}
		}, {
			key: 'create',
			value: function create() {
				var _this2 = this;

				if (this.isOpen || this.$el) return;

				var html = Mustache.to_html(TEMPLATE.BUY_MODAL, {
					title: 'Add Stock',
					basket: $('[data-name="baskets"]').val(),
					btnLabel: '<i class="ion-ios-plus-outline"></i> Add'
				});

				this.$el = $(html);

				_get(Object.getPrototypeOf(BuyModal.prototype), 'open', this).call(this, function () {
					_this2.$el.find('select[name=company]').chosen();
					//this.$el.find('input[name=buy_date]').datepicker({dateFormat:'yyyy-mm-dd' , lang: 'en'});
					_this2.ajaxSubmit();
				});
			}
		}, {
			key: 'edit',
			value: function edit(id) {
				var _this3 = this;

				if (this.isOpen || this.$el || !id) return;

				var data = this.datatable.find('id', id);

				console.log(data);

				if (!data) return;

				var html = Mustache.to_html(TEMPLATE.BUY_MODAL, {
					title: 'Edit Stock',
					btnLabel: '<i class="ion-compose"></i> Update',
					method: 'put',
					basket: data.basket_id,
					certificate_number: data.certificate_number,
					shareholder_number: data.shareholder_number,
					owner_name: data.owner_name,
					buy_rate: data.buy_rate,
					buy_date: data.buy_date,
					company: data.company_id,
					type: data.type_id,
					quantity: data.remaining_quantity + data.sell_quantity,
					commission: data.commission
				});

				this.$el = $(html);

				this.$el.find('select[name=company] option[value=' + data.company_id + ']').prop('selected', true);

				_get(Object.getPrototypeOf(BuyModal.prototype), 'open', this).call(this, function () {
					_this3.$el.find('select[name=company]').chosen();
					_this3.ajaxSubmit(id);
				});
			}
		}, {
			key: 'ajaxSubmit',
			value: function ajaxSubmit() {
				var _this4 = this;

				var id = arguments.length <= 0 || arguments[0] === undefined ? null : arguments[0];

				this.form = this.$el.find('form');
				console.log('Processing Form');

				var ajax = (0, _utils.ajaxForm)(this.app, this.form, id).onSuccess(function (response) {
					_this4.close();
					id ? _this4.app.event.occured(_eventNames.BUY_UPDATED_EVENT) : _this4.app.event.occured(_eventNames.BUY_CREATED_EVENT);
				});
			}
		}]);

		return BuyModal;
	}(_Modal3.default);

	exports.default = BuyModal;

/***/ },
/* 18 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});

	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

	var Template = $('#stock-buy-create-update-modal').html();

	var Modal = function () {
	    function Modal(app) {
	        var datatable = arguments.length <= 1 || arguments[1] === undefined ? null : arguments[1];

	        _classCallCheck(this, Modal);

	        this.app = app;
	        this.datatable = datatable;
	        this.$el = null;
	        this.isOpen = false;
	        this.form = null;

	        this.listenEvents();
	    }

	    _createClass(Modal, [{
	        key: 'eventTriggered',
	        value: function eventTriggered(eventName) {
	            this.app.eventTriggered(eventName);

	            return this;
	        }
	    }, {
	        key: 'open',
	        value: function open(callback) {
	            if (this.isOpen || !this.$el) return;

	            var _this = this;

	            this.isOpen = true;

	            this.$el.on('hide.bs.modal', function (e) {
	                var _this2 = this;

	                e.preventDefault();
	                console.info('Closing Modal');
	                $(this).toggleClass('fadeIn fadeOut');

	                setTimeout(function () {
	                    $('body').removeClass('modal-open');

	                    _this.$el = null;
	                    _this.isOpen = false;

	                    $(_this2).remove();
	                }, 300);
	            }).modal({ keyboard: true, backdrop: false });

	            if (callback) callback();
	        }
	    }, {
	        key: 'close',
	        value: function close() {
	            this.$el.modal('hide');
	        }
	    }, {
	        key: 'listenEvents',
	        value: function listenEvents() {}
	    }]);

	    return Modal;
	}();

	exports.default = Modal;

/***/ },
/* 19 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
		value: true
	});
	exports.ajaxForm = ajaxForm;

	var _AjaxForm = __webpack_require__(20);

	var _AjaxForm2 = _interopRequireDefault(_AjaxForm);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	function ajaxForm(app, form, id) {
		return new _AjaxForm2.default(app, form, id);
	}

/***/ },
/* 20 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});

	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

	var _ValidationError = __webpack_require__(21);

	var _ValidationError2 = _interopRequireDefault(_ValidationError);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

	var AjaxForm = function () {
	    function AjaxForm(app, form) {
	        var id = arguments.length <= 2 || arguments[2] === undefined ? null : arguments[2];

	        _classCallCheck(this, AjaxForm);

	        this.id = id;
	        this.app = app;
	        this.form = form;
	        this.successCallback = null;
	        this.failCallback = null;
	        this.validationError = new _ValidationError2.default('flipInX', 'flipOutX');

	        this.listenEvents();
	    }

	    _createClass(AjaxForm, [{
	        key: 'notify',
	        value: function notify() {
	            return this.app.notify;
	        }
	    }, {
	        key: 'onSuccess',
	        value: function onSuccess(successCallback) {
	            this.successCallback = successCallback;

	            return this;
	        }
	    }, {
	        key: 'onFail',
	        value: function onFail(failCallback) {
	            this.failCallback = failCallback;

	            return this;
	        }
	    }, {
	        key: 'showValidationErrors',
	        value: function showValidationErrors(errors) {
	            this.validationError.show(this.form.find('.form-errors'), errors);
	        }
	    }, {
	        key: 'listenEvents',
	        value: function listenEvents() {
	            var _this = this;

	            this.form.on('submit', function (e) {
	                e.preventDefault();
	                _this.submit();
	            });
	        }
	    }, {
	        key: 'submit',
	        value: function submit() {
	            var _this2 = this;

	            this.toggleButton();

	            var data = this.form.serialize();
	            var url = this.form.attr('action');
	            var method = this.form.find('input[name="_method"]').val();

	            if (this.id) url += '/' + this.id;
	            if (!method) method = this.form.attr('method');

	            $.ajax({ method: method, url: url, data: data }).done(function (response) {
	                if (response.error) {
	                    if (response.message) _this2.notify().warning(response.message);
	                    if (_this2.failCallback) _this2.failCallback(response);
	                } else {
	                    if (response.message) _this2.notify().success(response.message);
	                    if (_this2.successCallback) _this2.successCallback(response);
	                }
	            }).fail(function (response) {
	                if (response.status === 422) {
	                    _this2.showValidationErrors(response.responseJSON);
	                } else {
	                    _this2.notify().danger(response.statusText);
	                }

	                if (_this2.failCallback) _this2.failCallback(response);
	            }).always(function (response) {
	                _this2.toggleButton();
	            });
	        }
	    }, {
	        key: 'toggleButton',
	        value: function toggleButton() {
	            var btn = this.form.find('button[type=submit]');
	            var icon = btn.find('i');

	            btn.prop('disabled', !btn.prop('disabled'));

	            if (!icon.length) return this;

	            if (icon.data('icon')) {
	                icon.removeClass('fa fa-spinner fa-pulse').addClass(icon.data('icon')).removeData('icon');
	            } else {
	                var icon_class = icon.attr('class');

	                icon.data('icon', icon_class).removeClass(icon_class).addClass('fa fa-spinner fa-pulse');
	            }

	            return this;
	        }
	    }]);

	    return AjaxForm;
	}();

	exports.default = AjaxForm;

/***/ },
/* 21 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
		value: true
	});

	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

	var _templateHtml = __webpack_require__(22);

	var TEMPLATE = _interopRequireWildcard(_templateHtml);

	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

	var ValidationError = function () {
		function ValidationError(animateIn, animateOut) {
			_classCallCheck(this, ValidationError);

			this.animateIn = animateIn;
			this.animateOut = animateOut;
			this.$el = null;
		}

		_createClass(ValidationError, [{
			key: 'show',
			value: function show(target, errors) {
				var description = this.getErrorList(errors);

				var html = Mustache.to_html(TEMPLATE.CALLOUT, {
					type: 'danger',
					description: description
				});

				this.$el = $(html);

				console.log(target, this.$el);

				this.$el.addClass(this.animateIn);

				var modalDiaglog = target.closest('.modal-dialog');

				/*if(modalDiaglog) {
	   	modalDiaglog.removeClass('shake');
	    	setTimeout(() => {
	     modalDiaglog.addClass('animated shake')
	     .css({animationDuration: '400ms'});
	      target.empty().append(this.$el);
	   	}, 100);
	   }else{
	   target.empty().append(this.$el);
	   }*/

				target.empty().append(this.$el);

				this.listenEvents(this.$el);
				this.autoClose(this.$el);
			}
		}, {
			key: 'getErrorList',
			value: function getErrorList(errors) {
				var keys = Object.keys(errors);
				var description = '<ul>';

				for (var i = keys.length - 1; i >= 0; i--) {
					description += '<li>' + errors[keys[i]] + '</li>';
				}

				description += '</ul>';

				return description;
			}
		}, {
			key: 'autoClose',
			value: function autoClose($el) {
				setTimeout(function () {
					$el.alert('close');
				}, 10000);
			}
		}, {
			key: 'listenEvents',
			value: function listenEvents($el) {
				var _this = this;

				$el.on('close.bs.alert', function (e) {
					var _this2 = this;

					e.preventDefault();
					$(this).removeClass(_this.animateIn).addClass(_this.animateOut);

					setTimeout(function () {
						$(_this2).remove();
					}, 300);
				});
			}
		}]);

		return ValidationError;
	}();

	exports.default = ValidationError;

/***/ },
/* 22 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	var CALLOUT = exports.CALLOUT = $('#callout-tmpl').html();
	var BUY_MODAL = exports.BUY_MODAL = $('#stock-buy-create-update-modal-tmpl').html();
	var SELL_MODAL = exports.SELL_MODAL = $('#stock-sell-create-update-modal-tmpl').html();

/***/ },
/* 23 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
		value: true
	});

	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

	var _eventNames = __webpack_require__(24);

	var EN = _interopRequireWildcard(_eventNames);

	var _tabPaneNames = __webpack_require__(5);

	var TPN = _interopRequireWildcard(_tabPaneNames);

	var _dataTableNames = __webpack_require__(2);

	var DTN = _interopRequireWildcard(_dataTableNames);

	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

	var BUY_CALLBACK = function BUY_CALLBACK(view, datatables) {
		if (view === TPN.BUY || view === TPN.SELL || view === TPN.DETAILS) {
			datatables[DTN.BUY].reload();
			datatables[DTN.GROUPED].reload();
		} else if (view === TPN.GROUPED) {
			datatables[DTN.GROUPED].reload();
		}
	};

	var SELL_CALLBACK = function SELL_CALLBACK(view, datatables) {
		if (view === TPN.SELL) {
			datatables[DTN.SELL].reload();
			datatables[DTN.BUY].reload();
			datatables[DTN.GROUPED].reload();
		} else if (view === TPN.BUY) {
			datatables[DTN.BUY].reload();
			datatables[DTN.GROUPED].reload();
		} else if (view === TPN.GROUPED) {
			datatables[DTN.GROUPED].reload();
		}
	};

	var DETAILS_CALLBACK = function DETAILS_CALLBACK(view, datatables) {
		datatables[DTN.DETAILS].reload();
	};

	var Event = function () {
		function Event(app) {
			_classCallCheck(this, Event);

			this.app = app;
			this.triggered = [];
		}

		_createClass(Event, [{
			key: 'exists',
			value: function exists(event) {
				var eventName = EN[event];

				if (!eventName) {
					console.warn('%cUnidentified Event Occured: ' + '%c' + event, 'color: red;', 'color: red; padding-left: 10px; font-weight: bold');
					return false;
				}

				console.info('%cEvent Occured: ' + '%c' + event, 'color: green;', 'color: green; padding-left: 10px; font-weight: bold');

				return true;
			}
		}, {
			key: 'datatables',
			value: function datatables() {
				return this.app.datatables;
			}
		}, {
			key: 'view',
			value: function view() {
				return this.app.views.current.name;
			}
		}, {
			key: 'occured',
			value: function occured(event) {
				this.triggered.push(event);

				if (!this.exists(event)) return this;

				var CALLBACK = function CALLBACK() {};

				switch (event) {
					case EN.BUY_CREATED_EVENT:
					case EN.BUY_UPDATED_EVENT:
					case EN.BUY_DELETED_EVENT:
						CALLBACK = BUY_CALLBACK;
						break;
					case EN.SELL_CREATED_EVENT:
					case EN.SELL_UPDATED_EVENT:
					case EN.SELL_DELETED_EVENT:
						CALLBACK = SELL_CALLBACK;
						break;
					case EN.DETAILS_CREATED_EVENT:
					case EN.DETAILS_UPDATED_EVENT:
					case EN.DETAILS_DELETED_EVENT:
						CALLBACK = DETAILS_CALLBACK;
						break;
				}

				CALLBACK(this.app.views.current.name, this.app.datatables);

				return this;
			}
		}]);

		return Event;
	}();

	exports.default = Event;

/***/ },
/* 24 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	var BUY_CREATED_EVENT = exports.BUY_CREATED_EVENT = 'BUY_CREATED_EVENT';
	var BUY_UPDATED_EVENT = exports.BUY_UPDATED_EVENT = 'BUY_UPDATED_EVENT';
	var BUY_DELETED_EVENT = exports.BUY_DELETED_EVENT = 'BUY_DELETED_EVENT';

	var SELL_CREATED_EVENT = exports.SELL_CREATED_EVENT = 'SELL_CREATED_EVENT';
	var SELL_UPDATED_EVENT = exports.SELL_UPDATED_EVENT = 'SELL_UPDATED_EVENT';
	var SELL_DELETED_EVENT = exports.SELL_DELETED_EVENT = 'SELL_DELETED_EVENT';

	var DETAILS_CREATED_EVENT = exports.DETAILS_CREATED_EVENT = 'DETAILS_CREATED_EVENT';
	var DETAILS_UPDATED_EVENT = exports.DETAILS_UPDATED_EVENT = 'DETAILS_UPDATED_EVENT';
	var DETAILS_DELETED_EVENT = exports.DETAILS_DELETED_EVENT = 'DETAILS_DELETED_EVENT';

/***/ },
/* 25 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
		value: true
	});

	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

	var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

	var _Modal2 = __webpack_require__(18);

	var _Modal3 = _interopRequireDefault(_Modal2);

	var _utils = __webpack_require__(19);

	var _templateHtml = __webpack_require__(22);

	var TEMPLATE = _interopRequireWildcard(_templateHtml);

	var _eventNames = __webpack_require__(24);

	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

	function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

	function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

	var SellModal = function (_Modal) {
		_inherits(SellModal, _Modal);

		function SellModal() {
			_classCallCheck(this, SellModal);

			return _possibleConstructorReturn(this, Object.getPrototypeOf(SellModal).apply(this, arguments));
		}

		_createClass(SellModal, [{
			key: 'open',
			value: function open() {
				var id = arguments.length <= 0 || arguments[0] === undefined ? null : arguments[0];

				id ? this.edit(id) : this.create();
			}
		}, {
			key: 'create',
			value: function create() {
				var _this2 = this;

				if (this.isOpen || this.$el) return;

				var html = Mustache.to_html(TEMPLATE.SELL_MODAL, {
					title: 'Sell Stock',
					basket_id: $('[data-name="baskets"]').val(),
					stock_id: $('input[name=buy_id]').val(),
					btnLabel: '<i class="ion-ios-plus-outline"></i> Add'
				});

				this.$el = $(html);

				_get(Object.getPrototypeOf(SellModal.prototype), 'open', this).call(this, function () {
					console.log(_this2.$el.find('.date'));
					//this.$el.find('.date').datetimepicker({format: 'YYYY-MM-DD'});
					_this2.ajaxSubmit();
				});
			}
		}, {
			key: 'edit',
			value: function edit(id) {
				var _this3 = this;

				if (this.isOpen || this.$el || !id) return;

				var data = this.datatable.find('id', id);

				console.log(data);

				if (!data) return;

				var html = Mustache.to_html(TEMPLATE.SELL_MODAL, {
					title: 'Edit Sold Stock',
					method: 'put',
					basket_id: $('[data-name="baskets"]').val(),
					stock_id: $('input[name=buy_id]').val(),
					btnLabel: '<i class="ion-compose"></i> Update',
					sell_date: data.sell_date,
					sell_quantity: data.sell_quantity,
					sell_rate: data.sell_rate,
					sell_commission: data.sell_commission,
					sell_tax: data.sell_tax,
					sell_note: data.sell_note
				});

				this.$el = $(html);

				this.$el.find('select[name=company] option[value=' + data.company_id + ']').prop('selected', true);

				_get(Object.getPrototypeOf(SellModal.prototype), 'open', this).call(this, function () {
					_this3.$el.find('select[name=company]').chosen();
					_this3.ajaxSubmit(id);
				});
			}
		}, {
			key: 'ajaxSubmit',
			value: function ajaxSubmit() {
				var _this4 = this;

				var id = arguments.length <= 0 || arguments[0] === undefined ? null : arguments[0];

				this.form = this.$el.find('form');
				console.log('Processing Form');

				var ajax = (0, _utils.ajaxForm)(this.app, this.form, id).onSuccess(function (response) {
					_this4.close();
					id ? _this4.app.event.occured(_eventNames.SELL_UPDATED_EVENT) : _this4.app.event.occured(_eventNames.SELL_CREATED_EVENT);
				});
			}
		}]);

		return SellModal;
	}(_Modal3.default);

	exports.default = SellModal;

/***/ }
/******/ ]);