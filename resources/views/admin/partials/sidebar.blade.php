<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">System Navigation Links</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-fw"></i> <span>Dashboard</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-newspaper-o"></i> <span>News</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{route('admin.newsCategory.index')}}"><i class="fa fa-th-list"></i> News Category</a></li>
                    <li><a href="{{route('admin.news.index')}}"><i class="fa fa-newspaper-o"></i> News</a></li>
                    <li><a href="{{route('admin.interview.index')}}"><i class="fa fa-microphone"></i> Interview</a></li>
                    <li><a href="{{route('admin.article.index')}}"><i class="fa fa-file-text"></i> Article</a></li>
					@if(Auth::user()->hasRightsTo('create','news') || Auth::user()->hasRightsTo('create','data') || Auth::user()->hasRightsTo('create','crawl'))
					<li><a href="{{route('admin.newsletter.preview')}}"><i class="fa fa-envelope"></i> Newsletter</a></li>
					@endif
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>User</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{route('admin.userType.index')}}"><i class="fa fa-th-list"></i> User Types</a></li>
                    <li><a href="{{route('admin.user.index')}}"><i class="fa fa-users"></i> User List</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-gears"></i> <span>Company</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{route('admin.sector.index')}}"><i class="fa fa-th-list"></i> Sector</a></li>
                    <li><a href="{{route('admin.ipoPipeline.index')}}"><i class="fa fa-send-o"></i> IPO Pipeline</a></li>
                    <li><a href="{{route('admin.basePrice.upload')}}"><i class="fa fa-money"></i> Base Price</a></li>
                    <li><a href="{{route('admin.company.index')}}"><i class="fa fa-gears"></i> Company List</a></li>
                    <li><a href="{{route('admin.merger.index')}}"><i class="fa fa-compress"></i> Merger & Acquisition</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-calendar"></i> <span>Daily</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{route('admin.indexType.index')}}"><i class="fa fa-th-list"></i> Index Type</a></li>
                    <li><a href="{{route('admin.marketIndex.index')}}"><i class="fa fa-history"></i> Index Log</a></li>
                    <li><a href="{{route('admin.todaysPrice')}}"><i class="fa fa-line-chart"></i> Today's Price</a></li>
                    <li><a href="{{route('admin.floorsheet')}}"><i class="fa fa-file-text"></i> Floorsheet</a></li>
                    <li><a href="{{route('admin.addFloorsheet')}}"><i class="fa fa-bug"></i> Crawl Floorsheet</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bullhorn"></i> <span>Announcement</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{route('admin.announcement-type.index')}}"><i class="fa fa-th-list"></i> Ann. Type</a></li>
                    <li><a href="{{route('admin.announcement.index')}}"><i class="fa fa-bullhorn"></i> Ann. List</a></li>
                    <li><a href="{{route('admin.announcement.misc.index')}}"><i class="fa fa-cubes"></i> Dynamic Gen.</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-btc"></i> <span>Currency</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{route('admin.currencyType.index')}}"><i class="fa fa-th-list"></i> Add Type</a></li>
                    <li><a href="{{route('admin.currencyRate.index')}}"><i class="fa fa-history"></i> Rate Log</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bolt"></i> <span>Energy</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{route('admin.energyType.index')}}"><i class="fa fa-th-list"></i> Add Type</a></li>
                    <li><a href="{{route('admin.energyPrice.index')}}"><i class="fa fa-history"></i> Price Log</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-diamond"></i> <span>Bullion</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{route('admin.bullionType.index')}}"><i class="fa fa-th-list"></i> Add Type</a></li>
                    <li><a href="{{route('admin.bullionPrice.index')}}"><i class="fa fa-history"></i> Price Log</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-briefcase"></i> <span>Stakeholders</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{route('admin.bodPost.index')}}"><i class="fa fa-user-md"></i> BOD Post</a></li>
                    <li><a href="{{route('admin.brokerageFirm.index')}}"><i class="fa fa-building"></i> Brokerage Firm</a></li>
                    <li><a href="{{route('admin.issueManager.index')}}"><i class="fa fa-male"></i> Issue Manager</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-archive"></i> <span>Miscellaneous</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{route('admin.fiscalYear.index')}}"><i class="fa fa-calendar"></i> Fiscal Year</a></li>
                    <li><a href="{{route('admin.quarter.index')}}"><i class="fa fa-pie-chart"></i> Quarter</a></li>
                    <li><a href="{{route('admin.ipo-result.index')}}"><i class="fa fa-book"></i> IPO Allotment</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file"></i> <span>Report</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{route('admin.financialReport.index')}}"><i class="fa fa-files-o"></i> Financial Report</a></li>
					<li><a href="{{route('admin.budgetFiscalYear.index')}}"><i class="fa fa-calendar"></i> Budget Report</a></li>
                    <li><a href="{{route('admin.reportLabel.index')}}"><i class="fa fa-tags"></i> Report Label</a></li>
                    <li><a href="{{route('admin.budgetLabel.index')}}"><i class="fa fa-tags"></i> Budget Label</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i> <span>Economy</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{route('admin.economyLabel.index')}}"><i class="fa fa-th-list"></i> Label</a></li>
                    <li><a href="{{route('admin.economy.index')}}"><i class="fa fa-bar-chart-o"></i> Economy List</a></li>
                </ul>
            </li>
			<li class="treeview">
                <a href="#">
                    <i class="fa fa-list-alt"></i> <span>Asset Management</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{route('admin.stock-type.index')}}"><i class="fa fa-th-list"></i> Stock Type</a></li>
                </ul>
            </li>
			@if(Auth::user()->hasRightsTo('create','news') || Auth::user()->hasRightsTo('create','data') || Auth::user()->hasRightsTo('create','crawl'))
			<li><a href="{{route('admin.command','cache:clear')}}"><i class="fa fa-trash"></i> Clear Cache</a></li>
			@endif
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>