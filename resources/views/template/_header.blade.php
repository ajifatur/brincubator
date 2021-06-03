	<!-- top bar navigation -->
	<div class="headerbar">

		<!-- LOGO -->
        <div class="headerbar-left">
			<a href="/admin" class="logo d-none d-sm-none d-md-block" id="logo-full">
			    <img alt="Logo" src="{{ asset('assets/images/logo/LOGO MITRA UMKM.png') }}" style="max-width:80%;"/>
			</a>
			<a href="/admin" class="logo d-sm-block d-md-none" id="logo-mini">
			    <img alt="Logo" src="{{ asset('assets/images/logo/ICON MITRA UMKM.png') }}" style="max-width:unset;"/>
			</a>
        </div>

        @include('template/_nav')

	</div>
	<!-- End Navigation -->