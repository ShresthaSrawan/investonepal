export default {
    processing: true,
    paging: true,
    serverSide: true,
    aLengthMenu: [[50, 100, 150, 200], [50, 100, 150, 200]],
    iDisplayLength: 50,
    drawCallback () {
        $(window).trigger('resize');
    }
}