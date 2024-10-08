(() => {
	function dateTimePickerInit() {
		if (typeof $.fn.datetimepicker !== "function") return;

		let dateFormat = arAllcorp3Options["THEME"]["DATE_FORMAT"];
		if (dateFormat === "DOT") {
			dateFormat = "dd.mm.yyyy hh:ii";
		} else if (dateFormat === "HYPHEN") {
			dateFormat = "dd-mm-yyyy hh:ii";
		} else if (dateFormat === "SPACE") {
			dateFormat = "dd mm yyyy hh:ii";
		} else if (dateFormat === "SLASH") {
			dateFormat = "dd/mm/yyyy hh:ii";
		} else {
			dateFormat = "dd:mm:yyyy hh:ii";
		}

		const $datetime = $(`.form form input.datetime`);

		$datetime.on("click", function (e) {
			e.stopPropagation();
			$(".datetimepicker").hide();
			$(this).datetimepicker("show");
		});

		let field = $datetime.closest(".form-group");

		$datetime.each(function () {
			let $item = $(this);
			const bOnlyTime = $item.hasClass("date");

			$item.prop('readonly', 'readonly');

			$item
				.datetimepicker({
					weekStart: 1,
					todayBtn: 1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					forceParse: 0,
					timepicker: !bOnlyTime,
					format: dateFormat,
					autoclose: true,
					language: "ru",
					keyboardNavigation: false,
					minView: bOnlyTime ? 2 : 0,
				}).on("changeDate", function (ev) {
					$(ev.currentTarget).closest(".form-group").addClass("input-filed");
  					}).on("show", function (ev) {
							
					
					let calendarHeight = 330, 
					classes2Add = 'datetimepicker-dropdown-bottom-right',
				
					heightElementTop = ev.currentTarget.closest(".datetime").getBoundingClientRect(),
					heightFormTop = ev.currentTarget.closest(".form").getBoundingClientRect(),
					elementTop = heightElementTop.top - heightFormTop.top,
				
					heightElementBottom = ev.currentTarget.closest(".datetime").getBoundingClientRect(),
					heightFormBottom = ev.currentTarget.closest(".form").getBoundingClientRect(),
					viewBottom = heightElementBottom.bottom - heightFormBottom.bottom,
				
					checkPositionInput = ev.currentTarget.closest(".form-group").getBoundingClientRect();
				
					if (ev.currentTarget.closest('.popup')) { 
						if ((elementTop > calendarHeight) && (elementTop > viewBottom)) {
							if (checkPositionInput.top >= calendarHeight){
								classes2Add = "datetimepicker-dropdown-top-right";
							}
						}  
							
						let dataPicker = $(ev.currentTarget).data('datetimepicker');
							if (dataPicker && dataPicker.picker) {
								dataPicker.picker.removeClass('datetimepicker-dropdown-bottom-right datetimepicker-dropdown-top-right').addClass(classes2Add);
							}
					};				
				});			
     	});

		if (field.length) {

			$(field).each(function () {
				let picker = $(this)
					.find("input")
					.data("datetimepicker")
					.picker.detach();
				$(this).append(picker);
			});
		}

		$("body").on("click", function (e) {
			if ($(e.target)[0] != field[0]) {
				$(".datetimepicker").hide();
			}
		});
	}

	readyDOM(() => {
		dateTimePickerInit();
	});
})();
