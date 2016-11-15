/*
	SUPER ADMIN SCRIPT
	1. employeeFunctions: has all functions for employee management
	2. customerFunctions: has all functions for customer management
	3. serviceFunctions: has all functions for service management
	4. adFunctions: has all functions for ADs management
	5. marketingServicesFuncions: has all functions for Marketin Services
*/
$(document).ready(function() {
	employeeFunctions();
	customerFunctions();
	serviceFunctions();
	adFunctions();
	marketingServicesFuncions();
});

//1. employeeFunctions: has all functions for employee management
employeeFunctions = function(){
	$('#mail-for-employee input[type=email]').on('input',function(){
		if(isEmail($.trim($(this).val())))
			$(this).removeClass('invalid').addClass('valid');
		else
			$(this).removeClass('valid').addClass('invalid');
	});

	$('#mail-for-employee').submit(function(){		
		var form = $(this);
		if(!form.hasClass('success')){
			if(!form.find('button').hasClass('active')){
				form.find('button').addClass('active');
				$.ajax({
		            url: "/superadmin/addemployee",
		            type: "POST",            
		            dataType: "json",
		            data: {
		            	email: $('#mail-for-employee #employee-email').val(),
		            	user_type: $('#mail-for-employee [type=radio]:checked').val()
		            },
		            success: function (data) {
		            	form.find('.alert p').text(data.message);
		                if(data.status == 'error'){       	
		                	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), marginTop: 10, opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
							form.find('button').removeClass('active').addClass('success');
		                }else{
		                	$('#mail-for-employee #employee-email').val('').removeClass('valid').removeClass('invalid');
		                	form.find('.alert').addClass('success').stop().animate({height: form.find('.alert p').height(), marginTop: 10, opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
							form.find('button').removeClass('active').addClass('success');
		                }
		            },
		            error: function(){
		            	form.find('.alert p').text('Error - ControllerJS (4.1)');
		            	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), marginTop: 10, opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
						form.find('button').removeClass('active').addClass('success');
		            }
		        });
			}
		}
		return false;
	});

	$('#mail-for-employee [type=radio]').click(function(){
		var tab = $(this).attr('data-tab');
		$('#mail-for-employee .text').addClass('hide');
		$('#mail-for-employee .text.'+tab).removeClass('hide');
	});

	$(document).on('click', '.employee-tab-child .btn-remove-employee', function(event) {
		var check = confirm('Are you sure?');
		if(check){
			var element = $(this).closest('li');
			$.ajax({
		        url: "/superadmin/removeemployee",
		        type: "POST",            
		        dataType: "json",
		        data: {id: $(this).attr('data-id')},
		        success: function (data) {
		        	element.remove();
		        },
		        error: function(){
		        	alert('Error - ControllerJS (4.2)');
		        }
		    });
		}
	});
}

//2. customerFunctions: has all functions for customer management
customerFunctions = function(){
	$('#customer-profile-form').submit(function(event) {
		var form = $(this);
		if(!form.hasClass('success')){
			if(!form.find('button').hasClass('active')){
				form.find('button').addClass('active');
				var formData = new FormData($(this)[0]);
				$.ajax({
			        url: "/superadmin/updatecustomer",
			        type: "POST",            
			        dataType: "json",
			        data: formData,
		            contentType: false,
		            processData: false,
			        success: function (data) {
			        	form.find('.alert p').text(data.message);
		                if(data.status == 'error'){       	
		                	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
							form.find('button').removeClass('active').addClass('success');
		                }else{
		                	$('#mail-for-employee #employee-email').val('').removeClass('valid').removeClass('invalid');
		                	form.find('.alert').addClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
							form.find('button').removeClass('active').addClass('success');
		                }
			        },
			        error: function(){
			        	form.find('.alert p').text('Error - ControllerJS (5)');
		            	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
						form.find('button').removeClass('active').addClass('success');
			        }
			    });
			}
		}
		return false;
	});

	$('.management-box .txt-search.customers').on('input', function(){
		$(this).closest('.management-box').find('.customers-list li').hide();
		if($.trim($(this).val()).length > 0){
			$(this).closest('.management-box').find('.customers-list li > a:contains('+$.trim($(this).val())+')').closest('li').show();
		}else{
			$(this).closest('.management-box').find('.customers-list li').show();
		}
	});
}

//3. serviceFunctions: has all functions for service management
serviceFunctions = function(){
	//SEARCH
	$('.management-box .txt-search.services').on('input', function(){
		$(this).closest('.management-box').find('.management-list > li').hide();
		if($.trim($(this).val()).length > 0){
			$(this).closest('.management-box').find('.management-list > li:contains('+$.trim($(this).val())+')').closest('li').show();
		}else{
			$(this).closest('.management-box').find('.management-list > li').show();
		}
	});

	//ADD NEW
	$('#addnew-service-form').submit(function(event) {
		var form = $(this);
		if(!form.hasClass('success')){
			if(!form.find('button').hasClass('active')){
				form.find('button').addClass('active');
				var formData = new FormData($(this)[0]);
				formData.append('description-html', service_editor.getData());
				$.ajax({
			        url: "/superadmin/addservice",
			        type: "POST",            
			        dataType: "json",
			        data: formData,
		            contentType: false,
		            processData: false,			        
			        success: function (data) {
			        	form.find('.alert p').text(data.message);			        	
		                if(data.status == 'error'){       	
		                	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
							form.find('button').removeClass('active').addClass('success');
		                }else{
		                	window.location = data.url;
		                }
			        },
			        error: function(){
			        	form.find('.alert p').text('Error - ControllerJS (6)');
		            	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
						form.find('button').removeClass('active').addClass('success');
			        }
			    });
			}
		}
		return false;
	});
	
	//UPDATE
	$('#update-service-form').submit(function(event) {
		var form = $(this);
		if(!form.hasClass('success')){
			if(!form.find('button').hasClass('active')){
				form.find('button').addClass('active');
				var formData = new FormData($(this)[0]);
				formData.append('description-html', service_editor.getData());
				$.ajax({
			        url: "/superadmin/updateservice/"+$('#service-id').val(),
			        type: "POST",            
			        dataType: "json",
			        data: formData,
		            contentType: false,
		            processData: false,			        
			        success: function (data) {
			        	form.find('.alert p').text(data.message);			        	
		                if(data.status == 'error'){       	
		                	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
							form.find('button').removeClass('active').addClass('success');
		                }else{
		                	window.location = data.url;
		                }
			        },
			        error: function(){
			        	form.find('.alert p').text('Error - ControllerJS (6.1)');
		            	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
						form.find('button').removeClass('active').addClass('success');
			        }
			    });
			}
		}
		return false;
	});

	//REMOVE
	$(document).on('click', '.btn-delete-service', function(event) {
		var check = confirm('Are you sure?');
		if(check){
			var element = $(this).parent().parent().closest('li');
			$.ajax({
		        url: "/superadmin/removeservice",
		        type: "POST",            
		        dataType: "json",
		        data: {id: $(this).attr('data-id')},
		        success: function (data) {
		        	element.remove();
		        },
		        error: function(){
		        	alert('Error - ControllerJS (6.2)');
		        }
		    });
		}
	});

	//COLOR PICKER
	if($('.nim-colorpicker').length > 0){		
		$('.nim-colorpicker input').ColorPicker({
	        color: $('.nim-colorpicker input').val(),
	        onShow: function (colpkr) {
	          $(colpkr).fadeIn(500);
	          return false;
	        },
	        onHide: function (colpkr) {
	          $(colpkr).fadeOut(500);
	          return false;
	        },
	        onChange: function (hsb, hex, rgb) {
	          $('.nim-colorpicker input').parent().find('span').css('backgroundColor', '#' + hex);
	          $('.nim-colorpicker input').val('#'+hex);
	        }
	    });
	}
}

//4. adFunctions: has all functions for ADs management
adFunctions = function(){
	//SEARCH
	$('.management-box .txt-search.ad').on('input', function(){
		$(this).closest('.management-box').find('.management-list > li').hide();
		if($.trim($(this).val()).length > 0){
			$(this).closest('.management-box').find('.management-list > li:contains('+$.trim($(this).val())+')').closest('li').show();
		}else{
			$(this).closest('.management-box').find('.management-list > li').show();
		}
	});

	//ADD NEW
	$('#addnew-ad-form').submit(function(event) {
		var form = $(this);
		if(!form.hasClass('success')){
			if(!form.find('button').hasClass('active')){
				form.find('button').addClass('active');
				var formData = new FormData($(this)[0]);
				formData.append('description-html', ad_editor.getData());
				$.ajax({
			        url: "/superadmin/addad",
			        type: "POST",            
			        dataType: "json",
			        data: formData,
		            contentType: false,
		            processData: false,			        
			        success: function (data) {
			        	form.find('.alert p').text(data.message);			        	
		                if(data.status == 'error'){       	
		                	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
							form.find('button').removeClass('active').addClass('success');
		                }else{
		                	window.location = data.url;
		                }
			        },
			        error: function(){
			        	form.find('.alert p').text('Error - ControllerJS (7)');
		            	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
						form.find('button').removeClass('active').addClass('success');
			        }
			    });
			}
		}
		return false;
	});
	
	//UPDATE
	$('#update-ad-form').submit(function(event) {
		var form = $(this);
		if(!form.hasClass('success')){
			if(!form.find('button').hasClass('active')){
				form.find('button').addClass('active');
				var formData = new FormData($(this)[0]);
				formData.append('description-html', ad_editor.getData());
				$.ajax({
			        url: "/superadmin/updatead/"+$('#ad-id').val(),
			        type: "POST",            
			        dataType: "json",
			        data: formData,
		            contentType: false,
		            processData: false,			        
			        success: function (data) {
			        	form.find('.alert p').text(data.message);			        	
		                if(data.status == 'error'){       	
		                	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
							form.find('button').removeClass('active').addClass('success');
		                }else{
		                	window.location = data.url;
		                }
			        },
			        error: function(){
			        	form.find('.alert p').text('Error - ControllerJS (7.1)');
		            	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
						form.find('button').removeClass('active').addClass('success');
			        }
			    });
			}
		}
		return false;
	});
	
	//REMOVE
	$(document).on('click', '.btn-delete-ad', function(event) {
		var check = confirm('Are you sure?');
		if(check){
			var element = $(this).parent().parent().closest('li');
			$.ajax({
		        url: "/superadmin/removead",
		        type: "POST",            
		        dataType: "json",
		        data: {id: $(this).attr('data-id')},
		        success: function (data) {
		        	element.remove();
		        },
		        error: function(){
		        	alert('Error - ControllerJS (7.2)');
		        }
		    });
		}
	});
}

//5. marketingServicesFuncions: has all functions for Marketin Services
marketingServicesFuncions = function(){
	$('#marketing-services-form').submit(function(event) {
		var form = $(this);
		if(!form.hasClass('success')){
			if(!form.find('button').hasClass('active')){
				form.find('button').addClass('active');
				var formData = new FormData($(this)[0]);
				$.ajax({
			        url: "/superadmin/marketingservices",
			        type: "POST",            
			        dataType: "json",
			        data: formData,
		            contentType: false,
		            processData: false,			        
			        success: function (data) {
			        	form.find('.alert p').text(data.message);			        	
		                form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
						form.find('button').removeClass('active').addClass('success');
			        },
			        error: function(){
			        	form.find('.alert p').text('Error - ControllerJS (7)');
		            	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
						form.find('button').removeClass('active').addClass('success');
			        }
			    });
			}
		}
		return false;
	});
}