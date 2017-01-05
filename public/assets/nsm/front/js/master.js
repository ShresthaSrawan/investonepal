var SPINNER = '<div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div></div>'
var NOTIFY_CONFIG = {
    allow_dismiss: true,
    newest_on_top: true,
    showProgressbar: false,
    placement: {from: "bottom", align: "right"},
    offset: 20,
    spacing: 10,
    z_index: 9999,
    delay: 5000,
    timer: 1000,
    type: 'info',
    mouse_over: 'pause'
};

/*Mobile Menu Dropdown*/
if (screen.width < 480) {
    mobileDropdown();
    function mobileDropdown() {
        var menuItems = document.getElementsByClassName("yamm-ddt");
        $(menuItems).each(function (menu, item) {
            item.setAttribute("data-toggle", "dropdown");
        });
    }
}

$(document).on('click', '.yamm .dropdown-menu', function (e) {
    e.stopPropagation()
});

$(".datepicker").datetimepicker({
    format: 'YYYY-MM-DD',
    daysOfWeekDisabled: [5, 6],
    showTodayButton: true
});
$(".datetimepicker").datetimepicker({
    format: 'YYYY-MM-DD LT',
    daysOfWeekDisabled: [5, 6],
    sideBySide: true,
    showTodayButton: true
});

//Share window pop up
//jQuery
$(".js-social-share").on("click", function (e) {
    e.preventDefault();

    windowPopup($(this).attr("href"), 500, 300);
});

// Vanilla JavaScript
var jsSocialShares = document.querySelectorAll(".js-social-share");
if (jsSocialShares) {
    [].forEach.call(jsSocialShares, function (anchor) {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();

            windowPopup(this.href, 500, 300);
        });
    });
}
function windowPopup(url, width, height) {
    // Calculate the position of the popup so
    // it’s centered on the screen.
    var left = (screen.width / 2) - (width / 2),
        top = (screen.height / 2) - (height / 2);

    window.open(
        url,
        "",
        "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=" + width + ",height=" + height + ",top=" + top + ",left=" + left
    );
}
//End of share window pop up

//Add commas function for number
function addCommas(nStr) {
    // nStr += '';
    // var x = nStr.split('.');
    // var x1 = x[0];
    // var x2 = x.length > 1 ? '.' + x[1] : '';
    // var rgx = /(\d+)(\d{3})/;
    // while (rgx.test(x1)) {
    //     x1 = x1.replace(rgx, "$1" + ',' + "$2");
    // }
    // return parseFloat(x1 + x2).toFixed(2);

    var formatted =  parseFloat(nStr).toFixed(2).replace(/./g, function(c, i, a) {
        return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
    });
    var splitval = formatted.split('.');
    return parseInt(splitval[1]) > 0 ? formatted : splitval[0];
}
$('.commas').each(function () {
    var th = $(this);
    var preVal = th.text();
    th.html(addCommas(preVal));
});
//End of Add Commas

//Chosen Config
var config = {
    allow_single_deselect: true,
    enable_split_word_search: true,
    search_contains: true,
    disable_search_threshold: 5,
    no_results_text: 'No company found with name.',
    width: '100%'
};
//End of Chosen Config

//Search bar company
$(document).ready(function () {
    $('.search-select').on('change', function () {
        $(this).closest('form').submit();
    });
    $(".search-company-selector,.search-company-selector-nav").select2({
        placeholder: 'Company/Quote',
        allowClear: true,
        ajax: {
            quietMillis: 10,
            delay: 250,
            cache: false,
            type: 'POST',
            url: searchCompanyUrl,
            data: function (params) {
                return {
                    company: params.term
                };
            },
            processResults: function (data) {
                // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data
                return {
                    results: data
                };
            },
        },
        minimumInputLength: 2,
        escapeMarkup: function (m) {
            return m;
        },
        templateResult: formatItem, // omitted for brevity, see the source of this page
        templateSelection: formatItemSelection // omitted for brevity, see the source of this page
    });
    setTimeout(function () {
        $('.select2-selection__placeholder').html('Company/Quote');
    }, 5000);

    var previousScroll = 0;
    var margintop = 150;
    $(window).scroll(function () {

        var currentScroll = $(this).scrollTop();

        /*
         If the current scroll position is greater than 0 (the top) AND the current scroll position is less than the document height minus the window height (the bottom) run the navigation if/else statement.
         */
        if (currentScroll > margintop && currentScroll < $(document).height() - $(window).height() && $(window).width() > 480) {
            $('.navbar').css('position', 'fixed').css('top', '0');
            /*
             If the current scroll is greater than the previous scroll (i.e we're scrolling down the page), hide the nav.
             */
            if (currentScroll > previousScroll) {
                window.setTimeout(hideNav, 300);
                /*
                 Else we are scrolling up (i.e the previous scroll is greater than the current scroll), so show the nav.
                 */
            } else {
                window.setTimeout(showNav, 300);
            }
            /*
             Set the previous scroll value equal to the current scroll.
             */
            previousScroll = currentScroll;
        } else {
            $('.navbar').css('position', 'absolute').css('top', 'inherit');
        }
        //goto top button
        if ($(this).scrollTop() > 200) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }

    });

    //Click event to scroll to top
    $('.scrollToTop').click(function () {
        $('html, body').animate({scrollTop: 0}, 800);
        return true;
    });
    
    function hideNav() {
        $(".navbar").removeClass("is-visible").addClass("is-hidden");
    }

    function showNav() {
        $(".navbar").removeClass("is-hidden").addClass("is-visible");
    }

    function formatItem(item) {
        if (item.loading) return item.text;

        var markup = '<div class="clearfix">' +
            '<div class="col-sm-9 no-padding">' + item.name + '</div>' +
            '<div class="col-sm-3 no-padding">' + item.quote + '</div>' +
            '</div>';

        /*if (repo.description) {
         markup += '<div>' + repo.description + '</div>';
         }*/

        return markup;
    }

    function formatItemSelection(item) {
        return item.quote || item.name;
    }

//End of search bar
});
//CSRF token
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
//End of CSRF