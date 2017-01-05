var stockmarketTable;
var bullionmarketTable;
var currencymarketTable;
var energymarketTable;

$(document).ready(function () {
    //setting latest date for all market data
    $.each(latestDate, function (k, v) {
        $("#" + k + "datepicker").data("DateTimePicker").date(v);
    });

    refreshStockData();
    refreshBullionData();
    refreshCurrencyData();
    refreshEnergyData();


    $("#stockdatepicker").on("dp.change", function (e) {
        refreshStockData();
    });
    $("#bulliondatepicker").on("dp.change", function (e) {
        refreshBullionData();
    });
    $("#currencydatepicker").on("dp.change", function (e) {
        refreshCurrencyData();
    });
    $("#energydatepicker").on("dp.change", function (e) {
        refreshEnergyData();
    });
});

function refreshStockData() {
    if (stockmarketTable === undefined) {
        stockmarketTable = $('#stockdatatable').DataTable({
            processing: false,
            serverSide: false,
            info: false,
            fixedHeader: false,
            responsive: false,
            paging: false,
            bSort: false,
            language: {
                processing: SPINNER
            },
            ajax: {
                url: marketDataByDateURL,
                type: 'POST',
                data: {
                    stockmarketdate: function () {
                        return $('#stockmarketdate').val();
                    },
                }
            },
            columns: [
                {
                    data: 'name', render: function (data) {
                    return data.toUpperCase();
                }
                },
                {
                    data: 'value', class: 'text-right', render: function (data) {
                    return addCommas(data);
                }
                },
                {
                    data: 'previous', class: 'text-right', render: function (data) {
                    return addCommas(data);
                }
                },
                {
                    data: 'change', class: 'text-right', render: function (data) {
                    change = "neutral";
                    if (eval(data) > 0)
                        change = "up";
                    else if (eval(data) < 0)
                        change = "down";
                    return "<span data-change=" + change + ">" + addCommas(data) + "</span>";
                }
                },
                {
                    data: 'percent', class: 'text-right', render: function (data) {
                    change = "neutral";
                    if (eval(data) > 0)
                        change = "up";
                    else if (eval(data) < 0)
                        change = "down";
                    return "<span data-change=" + change + ">" + addCommas(data) + "</span>";
                }
                }
            ]
        });
    }
    else {
        stockmarketTable.ajax.reload();
    }
}

function refreshBullionData() {
    if (bullionmarketTable === undefined) {
        bullionmarketTable = $('#bulliondatatable').DataTable({
            processing: false,
            serverSide: false,
            info: false,
            fixedHeader: false,
            responsive: false,
            paging: false,
            language: {
                processing: SPINNER
            },
            order: [[0, 'asc']],
            ajax: {
                url: marketDataByDateURL,
                type: 'POST',
                data: {
                    bullionmarketdate: function () {
                        return $('#bullionmarketdate').val();
                    },
                }
            },
            columns: [
                {
                    data: 'name', render: function (data) {
                    return "<a href='/bullion/" + data + "' class='link'>" + data + "</a>";
                }
                },
                {
                    data: 'value', class: 'text-right', render: function (data) {
                    return addCommas(data);
                }
                },
                {data: 'previous', class: 'text-right'},
                {
                    data: 'change', class: 'text-right', render: function (data) {
                    change = "neutral";
                    if (eval(data) > 0)
                        change = "up";
                    else if (eval(data) < 0)
                        change = "down";
                    return "<span data-change=" + change + ">" + addCommas(data) + "</span>";
                }
                },
                {
                    data: 'percent', class: 'text-right', render: function (data) {
                    change = "neutral";
                    if (eval(data) > 0)
                        change = "up";
                    else if (eval(data) < 0)
                        change = "down";
                    return "<span data-change=" + change + ">" + addCommas(data) + "</span>";
                }
                }
            ]
        });
    }
    else {
        bullionmarketTable.ajax.reload();
    }
}

function refreshCurrencyData() {
    if (currencymarketTable === undefined) {
        currencymarketTable = $('#currencydatatable').DataTable({
            processing: false,
            serverSide: false,
            info: false,
            fixedHeader: false,
            responsive: false,
            paging: false,
            language: {
                processing: SPINNER
            },
            order: [[0, 'asc']],
            ajax: {
                url: marketDataByDateURL,
                type: 'POST',
                data: {
                    currencymarketdate: function () {
                        return $('#currencymarketdate').val();
                    },
                }
            },
            columns: [
                {
                    data: 'name', render: function (data) {
                    return "<a href='/currency/" + data + "' class='link'>" + data + "</a>";
                }
                },
                {
                    data: 'buy', class: 'text-right', render: function (data) {
                    return addCommas(data);
                }
                },
                {
                    data: 'previousBuy', class: 'text-right', render: function (data) {
                    if (data == "" || data == null)
                        data = '-';
                    return addCommas(data);
                }
                },
                {
                    data: 'changeBuy', class: 'text-right', render: function (data) {
                    change = "neutral";
                    if (eval(data) > 0)
                        change = "up";
                    else if (eval(data) < 0)
                        change = "down";
                    else if (eval(data) == 0 || data == null)
                        data = '-';
                    return "<span data-change=" + change + ">" + addCommas(data) + "</span>";
                }
                },
                {
                    data: 'sell', class: 'text-right', render: function (data) {
                    change = "neutral";
                    if (eval(data) > 0)
                        change = "up";
                    else if (eval(data) < 0)
                        change = "down";
                    else if (eval(data) == 0 || data == null)
                        data = '-';
                    return "<span data-change=" + change + ">" + addCommas(data) + "</span>";
                }
                },
                {
                    data: 'previousSell', class: 'text-right', render: function (data) {
                    if (data == "" || data == null)
                        data = '-';
                    return addCommas(data);
                }
                },
                {
                    data: 'changeSell', class: 'text-right', render: function (data) {
                    change = "neutral";
                    if (eval(data) > 0)
                        change = "up";
                    else if (eval(data) < 0)
                        change = "down";
                    else if (eval(data) == 0 || data == null)
                        data = '-';
                    return "<span data-change=" + change + ">" + addCommas(data) + "</span>";
                }
                },
            ]
        });
    }
    else {
        currencymarketTable.ajax.reload();
    }
}

function refreshEnergyData() {
    if (energymarketTable === undefined) {
        energymarketTable = $('#energydatatable').DataTable({
            processing: false,
            serverSide: false,
            info: false,
            fixedHeader: false,
            responsive: false,
            paging: false,
            language: {
                processing: SPINNER
            },
            order: [[0, 'asc']],
            ajax: {
                url: marketDataByDateURL,
                type: 'POST',
                data: {
                    energymarketdate: function () {
                        return $('#energymarketdate').val();
                    },
                }
            },
            columns: [
                {
                    data: 'name', render: function (data) {
                    return "<a href='/energy/" + data + "' class='link'>" + data + "</a>";
                }
                },
                {
                    data: 'value', class: 'text-right', render: function (data) {
                    return addCommas(data);
                }
                },
                {data: 'previous', class: 'text-right'},
                {
                    data: 'change', class: 'text-right', render: function (data) {
                    change = "neutral";
                    if (eval(data) > 0)
                        change = "up";
                    else if (eval(data) < 0)
                        change = "down";
                    return "<span data-change=" + change + ">" + addCommas(data) + "</span>";
                }
                },
                {
                    data: 'percent', class: 'text-right', render: function (data) {
                    change = "neutral";
                    if (eval(data) > 0)
                        change = "up";
                    else if (eval(data) < 0)
                        change = "down";
                    return "<span data-change=" + change + ">" + addCommas(data) + "</span>";
                }
                }
            ]
        });
    }
    else {
        energymarketTable.ajax.reload();
    }
}