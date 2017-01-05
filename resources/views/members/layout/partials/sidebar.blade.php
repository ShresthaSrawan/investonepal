<?php
function check_url_is(array $str){
    if(is_array($str)){
        foreach($str as $url){
            if(Request::is($url)) return true;
        }
    }

    return false;
}
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">System Navigation Links</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="treeview {{check_url_is(['member/stock','member/bullion','member/currency','member/property']) ? 'active' : ''}}">
                <a href="#">
                    <i class="fa fa-files-o"></i> <span>Portfolio</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li {{check_url_is(['member/stock']) ? 'class=active' : ''}}><a href="{{route('member.stock.index')}}"><i class="fa fa-th-list"></i> <span>Stock</span></a></li>
                    <li {{check_url_is(['member/bullion']) ? 'class=active' : ''}}><a href="{{route('member.bullion.index')}}"><i class="fa fa-cubes"></i> <span>Gold & Silver</span></a></li>
                    <li {{check_url_is(['member/currency']) ? 'class=active' : ''}}><a href="{{route('member.currency.index')}}"><i class="fa fa-money"></i> <span>Currency</span></a></li>
                    <li {{check_url_is(['member/property']) ? 'class=active' : ''}}><a href="{{route('member.property.index')}}"><i class="fa fa-diamond"></i> <span>Property</span></a></li>
                </ul>
            </li>
            <li class="treeview {{check_url_is(['member/stock/report','member/bullion/report','member/currency/report','member/property/report']) ? 'active' : ''}}">
                <a href="#">
                    <i class="fa fa-area-chart"></i> <span>Report</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li {{check_url_is(['member/stock/report']) ? 'class=active' : ''}}><a href="{{route('member.report.stock')}}"><i class="fa fa-th-list"></i> <span>Stock</span></a></li>
                    <li {{check_url_is(['member/bullion/report']) ? 'class=active' : ''}}><a href="{{route('member.report.bullion')}}"><i class="fa fa-cubes"></i> <span>Gold & Silver</span></a></li>
                    <li {{check_url_is(['member/currency/report']) ? 'class=active' : ''}}><a href="{{route('member.report.currency')}}"><i class="fa fa-money"></i> <span>Currency</span></a></li>
                    <li {{check_url_is(['member/property/report']) ? 'class=active' : ''}}><a href="{{route('member.report.property')}}"><i class="fa fa-diamond"></i> <span>Property</span></a></li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>