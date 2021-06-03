	<!-- Left Sidebar -->
	<div class="left main-sidebar">
	
		<div class="sidebar-inner leftscroll">

			<div id="sidebar-menu">
        
			<ul>

					<li class="submenu">
						<a href="/admin"><i class="fa fa-fw fa-dashboard"></i><span> Dashboard </span> </a>
                    </li>

                    <li class="submenu">
                        <a href="/admin/pelatihan"><i class="fa fa-fw fa-signing"></i><span> Data Pelatihan </span> </a>
                    </li>

                    <li class="submenu">
                        <a href="/admin/mentor"><i class="fa fa-fw fa-user-plus"></i><span> Data Mentor </span> </a>
                    </li>

                    <li class="submenu">
                        <a href="/admin/bidang"><i class="fa fa-fw fa-tags"></i><span> Data Bidang Usaha </span> </a>
                    </li>

                    <li class="submenu">
                        <a href="/admin/umkm"><i class="fa fa-fw fa-building"></i><span> Data UMKM </span> </a>
                    </li>

                    @if(Auth::user()->role_id != 1)
                    <li class="submenu">
                        <a href="/admin/wilayah"><i class="fa fa-fw fa-map-marker"></i><span> Data Wilayah </span> </a>
                    </li>
                    @endif

                    <li class="submenu">
                        <a href="#"><i class="fa fa-fw fa-money"></i> <span> Omset </span> <span class="menu-arrow"></span></a>
						<ul class="list-unstyled">
							<li><a href="/admin/omset/tahun/{{ date('Y') }}">Data Omset</a></li>
							<li><a href="/admin/omset/grafik">Grafik Omset</a></li>
						</ul>
                    </li>

                    <li class="submenu">
                        <a href="/admin/kpi-program"><i class="fa fa-fw fa-certificate"></i><span> KPI Program </span> </a>
                    </li>

                    <li class="submenu">
                        <a href="/admin/user"><i class="fa fa-fw fa-users"></i><span> Data User </span> </a>
                    </li>
					
<!-- 					<li class="submenu">
                        <a href="#" class="active"><i class="fa fa-fw fa-table"></i> <span> Tables </span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="tables-basic.html">Basic Tables</a></li>
								<li class="active"><a href="tables-datatable.html">Data Tables</a></li>
							</ul>
                    </li> -->
										
<!-- 					<li class="submenu">
                        <a class="pro" href="#"><i class="fa fa-fw fa-star"></i><span> Pike Admin PRO </span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">								
                                <li><a target="_blank" href="https://www.pikeadmin.com/pike-admin-pro">Admin PRO features</a></li>
								<li><a href="pro-settings.html">Settings</a></li>
								<li><a href="pro-profile.html">My Profile</a></li>
                                <li><a href="pro-users.html">Users</a></li>
                                <li><a href="pro-articles.html">Articles</a></li>
                                <li><a href="pro-categories.html">Categories</a></li>
								<li><a href="pro-pages.html">Pages</a></li>								
                                <li><a href="pro-contact-messages.html">Contact Messages</a></li>
								<li><a href="pro-slider.html">Slider</a></li>
                            </ul>
                    </li> -->
					
            </ul>

            <div class="clearfix"></div>

			</div>
        
			<div class="clearfix"></div>

		</div>

	</div>
	<!-- End Sidebar -->