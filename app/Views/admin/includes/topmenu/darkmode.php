<div class="d-flex align-items-center ms-1 ms-lg-3">
	<!--begin::Menu toggle-->
	<a href="#" class="btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
		<i class="fonticon-sun fs-2 <?php if($adminDetails->theme_appearence == 1){ echo 'd-none';}?>"></i>
		<i class="fonticon-moon fs-2 <?php if($adminDetails->theme_appearence == 0){ echo 'd-none';}?>"></i>
	</a>
	<!--begin::Menu toggle-->
	<!--begin::Menu-->
	<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-primary fw-bold py-4 fs-6 w-200px" data-kt-menu="true">
		<!--begin::Menu item-->
		<div class="menu-item px-3 my-1">
			<a href="javascript:" data-id="0" class="menu-link darkmode darkmodelight px-3 <?php if($adminDetails->theme_appearence == 0){ echo 'active';}?>">
				<span class="menu-icon">
					<i class="fonticon-sun fs-2"></i>
				</span>
				<span class="menu-title">Light</span>
			</a>
		</div>
		<!--end::Menu item-->
		<!--begin::Menu item-->
		<div class="menu-item px-3 my-1">
			<a href="javascript:" data-id="1" class="menu-link darkmode darkmodedark px-3 <?php if($adminDetails->theme_appearence == 1){ echo 'active';}?>">
				<span class="menu-icon">
					<i class="fonticon-moon fs-2"></i>
				</span>
				<span class="menu-title">Dark</span>
			</a>
		</div>
		<!--end::Menu item-->
	</div>
	<!--end::Menu-->
</div>