var salt = '';
$(document).ready(function() {
	var current_step = $('#update-information').attr('data-current');
	$('#update-information .slider-information-child').addClass('hide');
	$('#update-information .slider-information-child:eq('+current_step+')').removeClass('hide');
	if(current_step > 0 && current_step < $('#update-information .slider-information-child').size() - 1){
		$('#update-information .btn-prev, #update-information .btn-next').removeClass('hide');
		$('#update-information .title .step, #update-information .title h1').removeClass('hide');			
	}
	$('#update-information .title h1').removeClass('hide').text($('#update-information .slider-information-child:eq('+current_step+')').attr('data-title'));

	$('.time_open, .time_close').datetimepicker({format: 'LT', ignoreReadonly: true});

	$('#update-information .btn-prev').click(function(event) {
		var current_step = $('#update-information').attr('data-current');
		if(current_step > 1){
			current_step--;
			$('#update-information .slider-information-child').addClass('hide');
			$('#update-information .slider-information-child:eq('+current_step+')').removeClass('hide');
			$('#update-information').attr('data-current', current_step);
			$('#update-information .title .step').removeClass('hide').text('( Question '+current_step+' of 20 )');
			$('#update-information .title h1').removeClass('hide').text($('#update-information .slider-information-child:eq('+current_step+')').attr('data-title'));
		}
	});
	
	$('#update-information .btn-next').click(function(event) {
		var current_step = $('#update-information').attr('data-current');
		salt = $('#update-information').attr('data-salt');	
		if(current_step < $('#update-information .slider-information-child').size() - 1){			
			switch(current_step){
				case "1":					
					saveStep_01();
					break;
				case "2":
					saveStep_02();
					break;
				case "3":
					saveStep_03();
					break;
				case "4":
					saveStep_04();
					break;
				case "5":
					saveStep_05();
					break;
				case "6":
					saveStep_06();
					break;
				case "7":
					saveStep_07();
					break;
				case "8":
					saveStep_08();
					break;
				case "9":
					saveStep_09();
					break;
				case "10":
					saveStep_10();
					break;
				case "11":
					saveStep_11();
					break;
				case "12":
					saveStep_12();
					break;
				case "13":
					saveStep_13();
					break;
				case "14":
					saveStep_14();
					break;
				case "15":
					saveStep_15();
					break;
				case "16":
					saveStep_16();
					break;
				case "17":
					saveStep_17();
					break;
				case "18":
					saveStep_18();
					break;
				case "19":
					saveStep_19();
					break;
				case "20":
					saveStep_20();
					break;
				case "21":
					saveStep_21();
					break;
				default: break;
			}
		}
		if(current_step == $('#update-information .slider-information-child').size() - 1){
			$('#update-information .btn-prev, #update-information .btn-next').addClass('hide');
			$('#update-information .title .step, #update-information .title h1').addClass('hide');			
		}
	});

	$('#update-information .slider-information-child.step-0 .btn').click(function(event) {		
		salt = $('#update-information').attr('data-salt');
		$.ajax({
			url: '/site/updatebusiness',
			type: 'POST',
			data : {salt: salt, step: 1},
	       dataType: "json",	       
		})
		.done(function(data) {
			if(data.status != 'success')
				console.log(data.message);
			else{
				$('#update-information').attr('data-current', 1);
				$('#update-information .slider-information-child').addClass('hide');
				$('#update-information .slider-information-child.step-1, #update-information .btn-prev, #update-information .btn-next').removeClass('hide');
				$('#update-information .title .step').removeClass('hide').text('( Question 1 of 20 )');
				$('#update-information .title h1').removeClass('hide').text($('#update-information .slider-information-child:eq(1)').attr('data-title'));
			}
		})
		.fail(function() {
			console.log("Error - ControllerJS (13)");
		});
	});

	$('#chk-always-open').click(function(event) {
		if($(this).is(':checked'))
			$(this).closest('.step-5').find('ul').addClass('hide');
		else
			$(this).closest('.step-5').find('ul').removeClass('hide');
	});

	$('.btn-addmore-usp').click(function(event) {
		$('#bi_list_usp').append('<li><input type="text" placeholder=". . ."></li>');
	});

	$('.btn-addmore-primary-services').click(function(event) {
		$('#bi_primary_services tbody').append('<tr><td class="col-1"><input type="text" placeholder="..."></td><td class="col-2"><input type="text" placeholder="..."></td></tr>');
	});

	$('#bi_upload_logo').change(function(){
		var element = $(this);
		element.parent().find('[for=bi_upload_logo]').attr('disabled',true);
		salt = $('#update-information').attr('data-salt');	
		var formData = new FormData();
		formData.append('salt', salt);
		formData.append('image', $(this)[0].files[0]);
		$('#update-information .btn-prev, #update-information .btn-next').addClass('hide');
		$.ajax({
			url: '/site/uploadfile',
			type: 'POST',
			data : formData,
	        dataType: "json",
	        processData: false,
	        contentType: false,         
		})
		.done(function(data) {
			if(data.status != 'success')
				console.log(data.message);
			else{
				$('#bi_image_logo').attr('src', data.message).removeClass('hide');
			}
		})
		.fail(function() {
			console.log("Error - ControllerJS (14)");
		}).always(function() {
			element.parent().find('[for=bi_upload_logo]').removeAttr('disabled');
			$('#update-information .btn-prev, #update-information .btn-next').removeClass('hide');
		});
	});

	$('#bi_upload_banner').change(function(){
		var element = $(this);
		element.parent().find('[for=bi_upload_banner]').attr('disabled',true);
		salt = $('#update-information').attr('data-salt');	
		var formData = new FormData();
		formData.append('salt', salt);
		formData.append('image', $(this)[0].files[0]);
		$('#update-information .btn-prev, #update-information .btn-next').addClass('hide');
		$.ajax({
			url: '/site/uploadfile',
			type: 'POST',
			data : formData,
	        dataType: "json",
	        processData: false,
	        contentType: false,         
		})
		.done(function(data) {
			if(data.status != 'success')
				console.log(data.message);
			else{
				$('#bi_image_banner').attr('src', data.message).removeClass('hide');
			}
		})
		.fail(function() {
			console.log("Error - ControllerJS (14)");
		}).always(function() {
			element.parent().find('[for=bi_upload_banner]').removeAttr('disabled');
			$('#update-information .btn-prev, #update-information .btn-next').removeClass('hide');
		});
	});

	$(document).on('input', '#bi_budget', function(){
		if(!isInt($(this).val()))
			$(this).val('');
	});

	$('#bi_is_promotion_yes').click(function(event) {
		 $('.step14-enabled').removeClass('hide');
	});

	$('#bi_is_promotion_no').click(function(event) {
		 $('.step14-enabled').addClass('hide');
	});
});

effectWhenNext = function(current_step){
	$('#update-information .slider-information-child').addClass('hide');
	$('#update-information .slider-information-child:eq('+current_step+')').removeClass('hide');
	$('#update-information').attr('data-current', current_step);
	$('#update-information .title .step').removeClass('hide').text('( Question '+current_step+' of 21 )');
	$('#update-information .title h1').removeClass('hide').text($('#update-information .slider-information-child:eq('+current_step+')').attr('data-title'));	
}

saveStep_01 = function(){
	var current_step = 2;	
	if($.trim($('#bi_name').val()).length == 0)
	{
		$('#update-information').find('.alert p').text('Please enter your business name');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	}else
		$.ajax({
			url: '/site/updatebusiness',
			type: 'POST',
			data : {salt: salt, step: current_step, name: $.trim($('#bi_name').val())},
	       dataType: "json",	       
		})
		.done(function(data) {
			$('#update-information').find('.alert p').text(data.message);
			if(data.status != 'success')
				$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
			else{
				effectWhenNext(current_step);
			}
		})
		.fail(function() {
			$('#update-information').find('.alert p').text('Error - ControllerJS (13.1)');
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		});
}

saveStep_02 = function(){
	var current_step = 3;
	var error = '';
	if($.trim($('#bi_month').val()).length == 0)
		error = 'Please select established month';
	else if($.trim($('#bi_year').val()).length == 0)
		error = 'Please enter established year';
	else if($.trim($('#bi_year').val()).length > 4)
		error = 'Established year should has 4 digit or less';
	else if(!isInt($.trim($('#bi_year').val()).length))
		error = 'Established year must be digit';
	if(error.length > 0){
		$('#update-information').find('.alert p').text(error);
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	}else
		$.ajax({
			url: '/site/updatebusiness',
			type: 'POST',
			data : {salt: salt, step: current_step, month: $('#bi_month').val(), year: $.trim($('#bi_year').val())},
	       dataType: "json",	       
		})
		.done(function(data) {
			$('#update-information').find('.alert p').text(data.message);
			if(data.status != 'success')
				$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
			else{
				effectWhenNext(current_step);
			}
		})
		.fail(function() {
			$('#update-information').find('.alert p').text('Error - ControllerJS (13.2)');
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		});
}

saveStep_03 = function(){
	var current_step = 4;	
	if($.trim($('#bi_locations').val()).length == 0)
	{
		$('#update-information').find('.alert p').text('Please enter your business locations');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	}else if(!isInt($.trim($('#bi_locations').val())))
	{
		$('#update-information').find('.alert p').text('Business locations must be digit');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	}else
		$.ajax({
			url: '/site/updatebusiness',
			type: 'POST',
			data : {salt: salt, step: current_step, locations: $.trim($('#bi_locations').val())},
	       dataType: "json",	       
		})
		.done(function(data) {
			$('#update-information').find('.alert p').text(data.message);
			if(data.status != 'success')
				$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
			else{
				effectWhenNext(current_step);
				var totalRow = $('#update-information .slider-information-child:eq('+current_step+') ul li').size();
				var total = $.trim($('#bi_locations').val()) - totalRow;				
				if(total > 0)
					for (var i = 0; i < total; i++) {
						$('#update-information .slider-information-child:eq('+current_step+') ul').append('<li><input type="text" data-id="0" placeholder=". . ."></li>');	
					}
				else if(total < 0){
					total = -total;
					for (var i = 1; i <= total; i++) {
						$('#update-information .slider-information-child:eq('+current_step+') ul li:eq('+$.trim($('#bi_locations').val())+')').remove();	
					}
				}		
			}
		})
		.fail(function() {
			$('#update-information').find('.alert p').text('Error - ControllerJS (13.3)');
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		});
}

saveStep_04 = function(){
	var current_step = 5;
	var check = true;
	var list_address = [];
	$('#bi_list_address input').each(function(index, el) {
		list_address.push({id: $(this).attr('data-id'), address: $.trim($(this).val())});
		if($.trim($(this).val()).length == 0){
			check = false;
			return;
		}
	});
	if(!check)
	{
		$('#update-information').find('.alert p').text('Please enter your business address');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	}else
		$.ajax({
			url: '/site/updatebusiness',
			type: 'POST',
			data : {salt: salt, step: current_step, list_address: list_address},
	       dataType: "json",	       
		})
		.done(function(data) {
			$('#update-information').find('.alert p').text(data.message);
			if(data.status != 'success')
				$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
			else{
				effectWhenNext(current_step);
			}
		})
		.fail(function() {
			$('#update-information').find('.alert p').text('Error - ControllerJS (13.4)');
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		});
}

saveStep_05 = function(){
	var current_step = 6;	
	var list_hours = [];
	var day = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
	$('#bi_list_hour li').each(function(index, el) {
		var status = ($(this).find('[type=checkbox]').is(':checked'))?1:0;
		var time_open = $(this).find('.time_open').val();
		var time_close = $(this).find('.time_close').val(); 
		list_hours.push({day: day[index],time_open: time_open, time_close: time_close, status: status});
	});
	var always_open = ($('#chk-always-open').is(':checked'))?1:0;
	$.ajax({
		url: '/site/updatebusiness',
		type: 'POST',
		data : {salt: salt, step: current_step, list_hours: list_hours, always_open: always_open},
       dataType: "json",	       
	})
	.done(function(data) {
		$('#update-information').find('.alert p').text(data.message);
		if(data.status != 'success')
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		else{
			effectWhenNext(current_step);
		}
	})
	.fail(function() {
		$('#update-information').find('.alert p').text('Error - ControllerJS (13.5)');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	});
}

saveStep_06 = function(){
	var current_step = 7;	
	if($.trim($('#bi_slogan').val()).length == 0)
	{
		$('#update-information').find('.alert p').text('Please enter your business slogan');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	}else
		$.ajax({
			url: '/site/updatebusiness',
			type: 'POST',
			data : {salt: salt, step: current_step, slogan: $.trim($('#bi_slogan').val())},
	       dataType: "json",	       
		})
		.done(function(data) {
			$('#update-information').find('.alert p').text(data.message);
			if(data.status != 'success')
				$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
			else{
				effectWhenNext(current_step);
			}
		})
		.fail(function() {
			$('#update-information').find('.alert p').text('Error - ControllerJS (13.6)');
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		});
}

saveStep_07 = function(){
	var current_step = 8;
	var list_usp = [];
	if($.trim($('#bi_list_usp input:eq(0)').val()).length == 0)
	{
		$('#update-information').find('.alert p').text('Please enter USPs of your business');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	}else{
		$('#bi_list_usp input').each(function(index, el) {
			if($.trim($(this).val()).length > 0)
				list_usp.push($.trim($(this).val()));
		});
		$.ajax({
			url: '/site/updatebusiness',
			type: 'POST',
			data : {salt: salt, step: current_step, list_usp: list_usp},
	       dataType: "json",	       
		})
		.done(function(data) {
			$('#update-information').find('.alert p').text(data.message);
			if(data.status != 'success')
				$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
			else{
				effectWhenNext(current_step);
			}
		})
		.fail(function() {
			$('#update-information').find('.alert p').text('Error - ControllerJS (13.6)');
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		});
	}
}

saveStep_08 = function(){
	var current_step = 9;
	var logo, banner;
	if($.trim($('#bi_image_logo').attr('src')).length != 0)
		logo = $.trim($('#bi_image_logo').attr('src'));
	if($.trim($('#bi_image_banner').attr('src')).length != 0)
		banner = $.trim($('#bi_image_banner').attr('src'));

	$.ajax({
		url: '/site/updatebusiness',
		type: 'POST',
		data : {salt: salt, step: current_step, logo: logo, banner: banner},
       dataType: "json",	       
	})
	.done(function(data) {
		$('#update-information').find('.alert p').text(data.message);
		if(data.status != 'success')
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		else{
			effectWhenNext(current_step);
		}
	})
	.fail(function() {
		$('#update-information').find('.alert p').text('Error - ControllerJS (13.7)');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	});
}

saveStep_09 = function(){
	var current_step = 10;
	if(!isInt($.trim($('#bi_budget').val())))
	{
		$('#update-information').find('.alert p').text('Budget must be digit');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	}else
		$.ajax({
			url: '/site/updatebusiness',
			type: 'POST',
			data : {salt: salt, step: current_step, budget: $.trim($('#bi_budget').val())},
	       dataType: "json",	       
		})
		.done(function(data) {
			$('#update-information').find('.alert p').text(data.message);
			if(data.status != 'success')
				$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
			else
				effectWhenNext(current_step);			
		})
		.fail(function() {
			$('#update-information').find('.alert p').text('Error - ControllerJS (13.8)');
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		});
}

saveStep_10 = function(){
	var current_step = 11;
	var primary_services = [];
	if($.trim($('#bi_primary_services tbody tr:eq(0) .col-1 input').val()).length == 0)
	{
		$('#update-information').find('.alert p').text('Please enter primary service');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	}else if($.trim($('#bi_primary_services tbody tr:eq(0) .col-2 input').val()).length == 0)
	{
		$('#update-information').find('.alert p').text('Please enter average price');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	}else{
		$('#bi_primary_services tbody tr').each(function(index, el) {
			if($.trim($(this).find('.col-1 input').val()).length > 0){
				var average_price = $.trim($(this).find('.col-2 input').val());
				average_price = (average_price.length > 0)?average_price:0;
				$(this).find('.col-2 input').val(average_price);
				primary_services.push({primary_service: $.trim($(this).find('.col-1 input').val()), average_price: average_price});
			}
		});
		$.ajax({
			url: '/site/updatebusiness',
			type: 'POST',
			data : {salt: salt, step: current_step, primary_services: primary_services},
	       dataType: "json",	       
		})
		.done(function(data) {
			$('#update-information').find('.alert p').text(data.message);
			if(data.status != 'success')
				$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
			else{
				effectWhenNext(current_step);
			}
		})
		.fail(function() {
			$('#update-information').find('.alert p').text('Error - ControllerJS (13.9)');
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		});
	}
}

saveStep_11 = function(){
	var current_step = 12;	
	if($.trim($('#bi_in_demand_service').val()).length == 0)
	{
		$('#update-information').find('.alert p').text('Please enter the most in-demand service of your business');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	}else
		$.ajax({
			url: '/site/updatebusiness',
			type: 'POST',
			data : {salt: salt, step: current_step, in_demand_service: $.trim($('#bi_in_demand_service').val())},
	       dataType: "json",	       
		})
		.done(function(data) {
			$('#update-information').find('.alert p').text(data.message);
			if(data.status != 'success')
				$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
			else{
				effectWhenNext(current_step);
			}
		})
		.fail(function() {
			$('#update-information').find('.alert p').text('Error - ControllerJS (13.10)');
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		});
}

saveStep_12 = function(){
	var current_step = 13;
	if($.trim($('#bi_walk_in').val()).length == 0)
	{
		$('#bi_walk_in').focus();
		$('#update-information').find('.alert p').text('Please enter walk in percent');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	}else if($.trim($('#bi_appointment').val()).length == 0)
	{
		$('#bi_appointment').focus();
		$('#update-information').find('.alert p').text('Please enter appointment percent');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	}else
		$.ajax({
			url: '/site/updatebusiness',
			type: 'POST',
			data : {salt: salt, step: current_step, walk_in: $.trim($('#bi_walk_in').val()), appointment: $.trim($('#bi_appointment').val())},
	       dataType: "json",	       
		})
		.done(function(data) {
			$('#update-information').find('.alert p').text(data.message);
			if(data.status != 'success')
				$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
			else{
				effectWhenNext(current_step);
			}
		})
		.fail(function() {
			$('#update-information').find('.alert p').text('Error - ControllerJS (13.11)');
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		});
}

saveStep_13 = function(){
	var current_step = 14;
	var list_percent_each_month = [];
	$('#bi_list_percent_each_month input').each(function(index, el) {		
		var answer = $.trim($(this).val());
		answer = (answer.length > 0)?answer:0;
		var id = $(this).attr('data-id');
		$(this).val(answer);
		list_percent_each_month.push({id: id, answer: answer});		
	});
	$.ajax({
		url: '/site/updatebusiness',
		type: 'POST',
		data : {salt: salt, step: current_step, list_percent_each_month: list_percent_each_month},
       dataType: "json",	       
	})
	.done(function(data) {
		$('#update-information').find('.alert p').text(data.message);
		if(data.status != 'success')
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		else{
			effectWhenNext(current_step);
		}
	})
	.fail(function() {
		$('#update-information').find('.alert p').text('Error - ControllerJS (13.12)');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	});	
}

saveStep_14 = function(){
	var current_step = 15;
	var is_promotion = 0;
	var promotion_description = '';
	if($('#bi_is_promotion_yes').is(':checked')){
		is_promotion = 1;
		promotion_description = $.trim($('.step14-enabled textarea').val());
	}
	if(is_promotion == 1 && $.trim($('.step14-enabled textarea').val()).length == 0){
		$('.step14-enabled textarea').focus();
		$('#update-information').find('.alert p').text('Please enter marketing, advertising campaign or promotion program');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	}else
		$.ajax({
			url: '/site/updatebusiness',
			type: 'POST',
			data : {salt: salt, step: current_step, is_promotion: is_promotion, promotion_description: promotion_description},
	       dataType: "json",	       
		})
		.done(function(data) {
			$('#update-information').find('.alert p').text(data.message);
			if(data.status != 'success')
				$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
			else{
				effectWhenNext(current_step);
			}
		})
		.fail(function() {
			$('#update-information').find('.alert p').text('Error - ControllerJS (13.13)');
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		});	
}

saveStep_15 = function(){
	var current_step = 16;
	var list_holidays = [];
	$('#bi_list_holidays input').each(function(index, el) {		
		var answer = $(this).is(':checked');
		answer = (answer)?1:0;
		var id = $(this).attr('data-id');		
		list_holidays.push({id: id, answer: answer});		
	});
	$.ajax({
		url: '/site/updatebusiness',
		type: 'POST',
		data : {salt: salt, step: current_step, list_holidays: list_holidays},
       dataType: "json",	       
	})
	.done(function(data) {
		$('#update-information').find('.alert p').text(data.message);
		if(data.status != 'success')
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		else{
			effectWhenNext(current_step);
		}
	})
	.fail(function() {
		$('#update-information').find('.alert p').text('Error - ControllerJS (13.14)');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	});	
}

saveStep_16 = function(){
	var current_step = 17;	
	var male = ($('#bi_male').val().length == 0)?0:$('#bi_male').val();
	$('#bi_male').val(male);
	var female = ($('#bi_female').val().length == 0)?0:$('#bi_female').val();
	$('#bi_female').val(female);
	$.ajax({
		url: '/site/updatebusiness',
		type: 'POST',
		data : {salt: salt, step: current_step, male: male, female: female},
       dataType: "json",	       
	})
	.done(function(data) {
		$('#update-information').find('.alert p').text(data.message);
		if(data.status != 'success')
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		else{
			effectWhenNext(current_step);
		}
	})
	.fail(function() {
		$('#update-information').find('.alert p').text('Error - ControllerJS (13.15)');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	});	
}

saveStep_17 = function(){
	var current_step = 18;
	var target_customers = [];
	$('#bi_target_customers input').each(function(index, el) {		
		var answer = ($(this).val().length == 0)?0:$(this).val();
		$(this).val(answer);
		var id = $(this).attr('data-id');		
		target_customers.push({id: id, answer: answer});		
	});
	$.ajax({
		url: '/site/updatebusiness',
		type: 'POST',
		data : {salt: salt, step: current_step, target_customers: target_customers},
       dataType: "json",	       
	})
	.done(function(data) {
		$('#update-information').find('.alert p').text(data.message);
		if(data.status != 'success')
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		else{
			effectWhenNext(current_step);
		}
	})
	.fail(function() {
		$('#update-information').find('.alert p').text('Error - ControllerJS (13.16)');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	});	
}

saveStep_18 = function(){
	var current_step = 19;
	var customer_relationships = [];
	$('#bi_customer_relationships input').each(function(index, el) {		
		var answer = ($(this).val().length == 0)?0:$(this).val();
		$(this).val(answer);
		var id = $(this).attr('data-id');		
		customer_relationships.push({id: id, answer: answer});		
	});
	$.ajax({
		url: '/site/updatebusiness',
		type: 'POST',
		data : {salt: salt, step: current_step, customer_relationships: customer_relationships},
       dataType: "json",	       
	})
	.done(function(data) {
		$('#update-information').find('.alert p').text(data.message);
		if(data.status != 'success')
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		else{
			effectWhenNext(current_step);
		}
	})
	.fail(function() {
		$('#update-information').find('.alert p').text('Error - ControllerJS (13.17)');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	});	
}

saveStep_19 = function(){
	var current_step = 20;	
	var segment_level = $('[name=bi_segment_level]:checked').val();
	$.ajax({
		url: '/site/updatebusiness',
		type: 'POST',
		data : {salt: salt, step: current_step, segment_level: segment_level},
       dataType: "json",	       
	})
	.done(function(data) {
		$('#update-information').find('.alert p').text(data.message);
		if(data.status != 'success')
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		else{
			effectWhenNext(current_step);
		}
	})
	.fail(function() {
		$('#update-information').find('.alert p').text('Error - ControllerJS (13.18)');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	});	
}

saveStep_20 = function(){
	var current_step = 21;	
	if($.trim($('#bi_purchasing_behavior').val()).length == 0){
		$('#bi_purchasing_behavior').focus();
		$('#update-information').find('.alert p').text('Please enter purchasing behavior');
		$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
	}else
		$.ajax({
			url: '/site/updatebusiness',
			type: 'POST',
			data : {salt: salt, step: current_step, purchasing_behavior: $('#bi_purchasing_behavior').val()},
	       dataType: "json",	       
		})
		.done(function(data) {
			$('#update-information').find('.alert p').text(data.message);
			if(data.status != 'success')
				$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
			else{
				effectWhenNext(current_step);
			}
		})
		.fail(function() {
			$('#update-information').find('.alert p').text('Error - ControllerJS (13.18)');
			$('#update-information').find('.alert').stop().animate({height: $('#update-information').find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
		});	
}

saveStep_21 = function(){
	var current_step = 22;
}

isInt = function(value) {
  return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
}