<!--begin::Search-->
<div class="d-flex align-items-stretch ms-1 ms-lg-3">
<!--begin::Main wrapper-->
<div id="kt_docs_search_handler_menu"
    class="d-flex align-items-stretch"

    data-kt-search-keypress="true"
    data-kt-search-min-length="1"
    data-kt-search-enter="true"
    data-kt-search-layout="menu"

    data-kt-menu-trigger="auto"
    data-kt-menu-overflow="false"
    data-kt-menu-permanent="true"
    data-kt-menu-placement="bottom-end">

    <!--begin::Search toggle-->
    <div class="d-flex align-items-center" data-kt-search-element="toggle" id="kt_header_search_toggle">
        <div class="btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px">
			<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
			<span class="svg-icon svg-icon-1">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
					<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
    </div>
    <!--end::Search toggle-->

    <!--begin::Menu-->
    <div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown p-7 w-325px w-md-375px">
        <!--begin::Wrapper-->
        <div data-kt-search-element="wrapper">
        <!--begin::Form-->
            <form data-kt-search-element="form" class="w-100 position-relative mb-3" autocomplete="off">
                <!--begin::Icon-->
				<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
				<span class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 translate-middle-y ms-0">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
						<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
					</svg>
				</span>
				<!--end::Svg Icon-->
				<!--end::Icon-->

                <!--begin::Input-->
                <input type="text"
                    class="form-control form-control-flush ps-10"
                    name="search"
                    value=""
                    placeholder="Search..."
                    data-kt-search-element="input"/>
                <!--end::Input-->

                <!--begin::Spinner-->
				<span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-1" data-kt-search-element="spinner">
					<span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
				</span>
				<!--end::Spinner-->

                <!--begin::Reset-->
                <span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none"
                    data-kt-search-element="clear">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
						<span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
								<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
							</svg>
						</span>
						<!--end::Svg Icon-->
                </span>
                <!--end::Reset-->

                
            </form>
            <!--end::Form-->
			<!--begin::Separator-->
			<div class="separator border-gray-200 mb-6"></div>
			<!--end::Separator-->
            <!--begin::Search results-->
            <div data-kt-search-element="results" class="d-none">
                <!--begin::Heading-->
				<div class="d-flex flex-stack fw-bold mb-4">
					<!--begin::Label-->
					<span class="text-muted fs-6 me-2">Pages:</span>
					<!--end::Label-->
				</div>
				<!--end::Heading-->
				<!--begin::Items-->
				<div class="scroll-y mh-200px mh-lg-325px" id="searchresults">
					
				</div>
            </div>
            <!--end::Search results-->

            <!--begin::Main content element-->
            <div data-kt-search-element="main">
				<!--begin::Heading-->
				<div class="d-flex flex-stack fw-bold mb-4">
					<!--begin::Label-->
					<span class="text-muted fs-6 me-2">Recently Searched:</span>
					<!--end::Label-->
				</div>
				<!--end::Heading-->
				<!--begin::Items-->
				<div class="scroll-y mh-200px mh-lg-325px" id="recentsearches">
					
				</div>
			</div>
            <!--end::Main content element-->

            <!--begin::Empty-->
			<div data-kt-search-element="empty" class="text-center d-none">
				<!--begin::Icon-->
				<div class="pt-10 pb-10">
					<!--begin::Svg Icon | path: icons/duotune/files/fil024.svg-->
					<span class="svg-icon svg-icon-4x opacity-50">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path opacity="0.3" d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" fill="currentColor" />
							<path d="M20 8L14 2V6C14 7.10457 14.8954 8 16 8H20Z" fill="black" />
							<rect x="13.6993" y="13.6656" width="4.42828" height="1.73089" rx="0.865447" transform="rotate(45 13.6993 13.6656)" fill="black" />
							<path d="M15 12C15 14.2 13.2 16 11 16C8.8 16 7 14.2 7 12C7 9.8 8.8 8 11 8C13.2 8 15 9.8 15 12ZM11 9.6C9.68 9.6 8.6 10.68 8.6 12C8.6 13.32 9.68 14.4 11 14.4C12.32 14.4 13.4 13.32 13.4 12C13.4 10.68 12.32 9.6 11 9.6Z" fill="currentColor" />
						</svg>
					</span>
					<!--end::Svg Icon-->
				</div>
				<!--end::Icon-->
				<!--begin::Message-->
				<div class="pb-15 fw-bold">
					<h3 class="text-gray-600 fs-5 mb-2">No result found</h3>
					<div class="text-muted fs-7">Please try again with a different query</div>
				</div>
				<!--end::Message-->
			</div>
			<!--end::Empty-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Menu-->
</div>
<!--end::Main wrapper-->
</div>
<!--end::Search-->
<input type="hidden" id="recentsearchtotal" />
<script>
var processsg = function(search) {
	var input = search.getQuery();
	var searchpagesurl = $("#searchpagesurl").val();
	search.complete();
	spinnerElement.classList.remove("d-none");
	clearElement.classList.add("d-none");
	
	$.ajax({
		type: 'POST',
		url : searchpagesurl,
		data:{'keyword':input},
		cache:false,
		global: false,
		success: function(res){
			spinnerElement.classList.add("d-none");
			clearElement.classList.remove("d-none");
			const data = JSON.parse(res);
			mainElement.classList.add("d-none");
			if(data['status'] == 'success'){
				$("#recentsearchtotal").val(data['total']);
				if(data['html'] != '') {
					resultsElement.classList.remove("d-none");
					emptyElement.classList.add("d-none");
					$("#searchresults").html(data['html']);
				} else {
					mainElement.classList.add("d-none");
					resultsElement.classList.add("d-none");
					emptyElement.classList.remove("d-none");
				}
			}
			else {
				mainElement.classList.add("d-none");
				resultsElement.classList.add("d-none");
				emptyElement.classList.remove("d-none");
			}
		}
	});
	
}

var clear = function(search) {
	var checktotalrecent = $("#recentsearchtotal").val();
	resultsElement.classList.add("d-none");
	if(checktotalrecent > 0){
		mainElement.classList.remove("d-none");
		emptyElement.classList.add("d-none");
	}
    else {
		mainElement.classList.add("d-none");
		emptyElement.classList.remove("d-none");
	}
}





// Elements
element = document.querySelector("#kt_docs_search_handler_menu");


wrapperElement = element.querySelector("[data-kt-search-element='wrapper']");
formElement = element.querySelector("[data-kt-search-element='form']");
mainElement = element.querySelector("[data-kt-search-element='main']");
resultsElement = element.querySelector("[data-kt-search-element='results']");
emptyElement = element.querySelector("[data-kt-search-element='empty']");
spinnerElement = element.querySelector("[data-kt-search-element='spinner']");
clearElement = element.querySelector("[data-kt-search-element='clear']");


const handleInput = () => {
	inputField = element.querySelector("[data-kt-search-element='input']");
    // Handle keyboard press event
    inputField.addEventListener("keydown", e => {
        // Only apply action to Enter key press
        if(e.key === "Enter"){
            e.preventDefault(); // Stop form from submitting
        }
    });
}


const handlerecentsearch = () => {
	var recentsearchurl = $("#recentsearchurl").val();
	$.ajax({
		type: 'POST',
		url : recentsearchurl,
		cache:false,
		global: false,
		success: function(res){
			const data = JSON.parse(res);
			if(data['status'] == 'success'){
				$("#recentsearchtotal").val(data['total']);
				if(data['total']>0){
					$(recentsearches).html(data['html']);
				}
				else {
					mainElement.classList.add("d-none");
					resultsElement.classList.add("d-none");
					emptyElement.classList.remove("d-none");
				}
			}
		}
	});
}

// Initialize search handler
searchObject = new KTSearch(element);

// Search handler
searchObject.on("kt.search.process", processsg);

// Clear handler
searchObject.on("kt.search.clear", clear);


// Handle select
KTUtil.on(element, "[data-kt-search-element='customer']", "click", function() {
    //modal.hide();
});

handleInput();
handlerecentsearch();
</script>