/*
	SUPER ADMIN SCRIPT
	1. employeeFunctions: has all functions for employee management
	2. customerFunctions: has all functions for customer management
	3. serviceFunctions: has all functions for service management
	4. adFunctions: has all functions for ADs management
	5. supportFunctions: has all functions for Support
	6. contentVaultFunctions: all function for Content Vault
	7. advertisingFunctions: all function for Advertising
	8. adsFunctions: ADs
	9. marketingCalendarFunctions: marketingcalendar
*/
$(document).ready(function() {
	employeeFunctions();
	customerFunctions();
	serviceFunctions();
	adFunctions();
	supportFunctions();
	contentVaultFunctions();
	advertisingFunctions();
	adsFunctions();
	marketingCalendarFunctions();
	currentClientFunctions();

	$('#updateprofile-form').submit(function(event) {
	    var form = $(this);
		if(!form.hasClass('success')){
			if(!form.find('button').hasClass('active')){
				form.find('button').addClass('active');
				var formData = new FormData($(this)[0]);
				$.ajax({
		            url: "/superadmin/updateuser",
		            type: "POST",            
		            dataType: "json",
		            data: formData,
		            contentType: false,
		            processData: false,
		            success: function (data) {
		            	form.find('.alert p').text(data.message);
		                if(data.status == 'error'){       	
		                	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), marginTop: 10, opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
							form.find('button').removeClass('active').addClass('success');
		                }else{		                	
		                	form.find('.alert').addClass('success').stop().animate({height: form.find('.alert p').height(), marginTop: 10, opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
							form.find('button').removeClass('active').addClass('success');
		                }
		            },
		            error: function(){
		            	form.find('.alert p').text('Error - ControllerJS (13)');
		            	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), marginTop: 10, opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
						form.find('button').removeClass('active').addClass('success');
		            }
		        });
			}
		}
		return false;
	});
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

//5. supportFunctions: has all functions for Support
supportFunctions = function(){
	$('.btn-loadmore-ticket').click(function(event) {
		var element = $(this);
		element.hide();
		$('.loading-effect').removeClass('hide');
		$.ajax({
	        url: "/superadmin/support",
	        type: "POST",            
	        dataType: "json",
	        data: {
	        	search: $.trim($('#txt-ticket-search').val()),
	        	start_item: $('#list-tickets').size(),	        	
	        },	        
	        success: function (data) {	        	
	    		$('.loading-effect').addClass('hide');    	
	    		if(data.loadmore_status)
	    			element.show();
	    		$.each(data.data, function(index, item) {
	    			var cls = (item.status)?'':'closed';
	    			var status = (item.status)?'Open Ticket':'Close Ticket';
	    			var respond = (item.respond)?'<span class="respond">Respond</span>':'';
	    			var string = '<li>'
                                    +'<a href="/supperadmin/ticketdetail/'+item.id+'" title="">'+item.name+'</a>'
                                    +'<div class="clearfix"></div>'
                                    +'<span class="datetime">On '+item.date+'</span>'
                                    +'<span class="status '+cls+'">'+item.status+'</span>' + respond
                                +'</li> ';
	    			$('#list-tickets').appendTo(string);
	    		});
	        },
	        error: function(){
	        	$('.loading-effect').addClass('hide');	
	        	element.show();
	        }
	    });
	});
		
	var suportAjax;
	$('#txt-ticket-search').on('input', function(event) {
		$('.loading-effect').removeClass('hide');
		$('#list-tickets').html('');
		if(suportAjax && suportAjax.readystate != 4)
            suportAjax.abort();
		suportAjax = $.ajax({
	        url: "/superadmin/support",
	        type: "POST",            
	        dataType: "json",
	        data: {
	        	search: $.trim($('#txt-ticket-search').val()),
	        	start_item: $('#list-tickets').size(),	        	
	        },	        
	        success: function (data) {	        	
	    		$('.loading-effect').addClass('hide');    	
	    		if(data.loadmore_status)
	    			element.show();
	    		$.each(data.data, function(index, item) {
	    			var cls = (item.status)?'':'closed';
	    			var status = (item.status)?'Open Ticket':'Close Ticket';
	    			var respond = (item.respond)?'<span class="respond">Respond</span>':'';
	    			var string = '<li>'
                                    +'<a href="/supperadmin/ticketdetail/'+item.id+'" title="">'+item.name+'</a>'
                                    +'<div class="clearfix"></div>'
                                    +'<span class="datetime">On '+item.date+'</span>'
                                    +'<span class="status '+cls+'">'+item.status+'</span>' + respond
                                +'</li> ';
	    			$('#list-tickets').appendTo(string);
	    		});
	        },
	        error: function(){
	        	$('.loading-effect').addClass('hide');	
	        	element.show();
	        }
	    });
	});

	$('#form-reply-feedback').submit(function(event) {
		var form = $(this);
		if(!form.hasClass('success')){
			if(!form.find('button').hasClass('active')){
				form.find('button').addClass('active');
				var formData = new FormData($(this)[0]);
				formData.append('comment-html', ticket_editor.getData());				
				$.ajax({
			        url: "/superadmin/sendfeedback/",
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
		                	window.location = window.location.href;
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
}

//6. contentVaultFunctions: all function for Content Vault
contentVaultFunctions = function(){
	$('.btn-open-add-image').click(function(event) {
		$('#modal-image-upload').addClass('active');
		$('#modal-image-upload').find('input').val('').removeClass('valid').removeClass('invalid');
		$('#modal-image-upload').find('button').removeClass('active');
	});

	$('.btn-open-add-video').click(function(event) {
		$('#modal-video-upload').addClass('active');
		$('#modal-video-upload').find('input').val('').removeClass('valid').removeClass('invalid');
		$('#modal-video-upload').find('button').removeClass('active');
	});

	$('.btn-open-add-article').click(function(event) {
		$('#modal-article').addClass('active');
		$('#modal-article .title').text('Add new Article');
		$('#modal-article').find('input').val('').removeClass('valid').removeClass('invalid');
		article_editor.setData('');
		$('#modal-article').find('button').removeClass('active');
	});

	$('#form-addnew-image').submit(function(event) {
		var form = $(this);
		if(!form.hasClass('success')){
			if(!form.find('button').hasClass('active')){
				form.find('button').addClass('active');
				var formData = new FormData($(this)[0]);				
				$.ajax({
			        url: "/superadmin/addimage",
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
		                	string = '<figure data-id="'+data.data.id+'">'
		                                +'<a class="box-img">'
		                                    +'<img src="'+data.data.url+'" itemprop="thumbnail" alt="'+data.data.name+'" />'
		                                +'</a>'
		                                +'<input type="text" value="'+data.data.name+'">'
		                                +'<button class="btn-remove">Remove</button>'
		                            +'</figure>';
		                	$('.content-vault-images').prepend(string);
		                	$('#modal-image-upload, #modal-image-upload button').removeClass('active');
		                }
			        },
			        error: function(){
			        	form.find('.alert p').text('Error - ControllerJS (9.1)');
		            	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
						form.find('button').removeClass('active').addClass('success');
			        }
			    });
			}
		}
		return false;
	});

	$('#form-addnew-video').submit(function(event) {
		var form = $(this);
		if(!form.hasClass('success')){
			if(!form.find('button').hasClass('active')){
				form.find('button').addClass('active');
				var formData = new FormData($(this)[0]);				
				$.ajax({
			        url: "/superadmin/addvideo",
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
		                	string = '<li data-id="'+data.data.id+'">'
		                                +'<div class="box-img video" data-id="'+data.data.url+'" data-time="'+data.data.time+'"><img src="http://img.youtube.com/vi/'+data.data.url+'/0.jpg" alt=""></div>'
		                                +'<label>'+data.data.name+'</label>'
		                                +'<button class="btn-remove">Remove</button>'
		                            +'</li>';
		                	$('.content-vault-videos').prepend(string);
		                	$('#modal-video-upload, #modal-video-upload button').removeClass('active');
		                }
			        },
			        error: function(){
			        	form.find('.alert p').text('Error - ControllerJS (9.2)');
		            	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
						form.find('button').removeClass('active').addClass('success');
			        }
			    });
			}
		}
		return false;
	});

	$('#form-addnew-article').submit(function(event) {
		var form = $(this);
		if(!form.hasClass('success')){
			if(!form.find('button').hasClass('active')){
				form.find('button').addClass('active');
				var formData = new FormData($(this)[0]);	
				formData.append('description-html', article_editor.getData());
				if(form.find('[name="id"]').val() == '')		
					$.ajax({
				        url: "/superadmin/addarticle",
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
			                	string = '<div class="panel panel-default" data-id="'+data.data.id+'">'
			                                +'<div class="panel-heading" role="tab" id="heading'+data.data.id+'">'
			                                  +'<h4 class="panel-title">'
			                                    +'<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'+data.data.id+'" aria-expanded="false" aria-controls="collapse'+data.data.id+'">'
			                                      +'<span>'+data.data.name+'</span>'
			                                      +'<button class="btn-remove">Remove</button><button class="btn-edit">Edit</button>'
			                                    +'</a>'
			                                  +'</h4>'
			                                +'</div>'
			                                +'<div id="collapse'+data.data.id+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'+data.data.id+'">'
			                                  +'<div class="panel-body">'
			                                    +'<div class="text-inner">'
			                                        +data.data.description
			                                    +'</div>'
			                                  +'</div>'
			                                +'</div>'
			                            +'</div>';
			                	$('.content-vault-articles').prepend(string);
			                	$('#modal-article, #modal-article button').removeClass('active');			                	
			                }
				        },
				        error: function(){
				        	form.find('.alert p').text('Error - ControllerJS (9.3)');
			            	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
							form.find('button').removeClass('active').addClass('success');
				        }
				    });
				else
					$.ajax({
				        url: "/superadmin/updatearticle",
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
			                	string = '<div class="panel panel-default" data-id="'+data.data.id+'">'
			                                +'<div class="panel-heading" role="tab" id="heading'+data.data.id+'">'
			                                  +'<h4 class="panel-title">'
			                                    +'<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'+data.data.id+'" aria-expanded="false" aria-controls="collapse'+data.data.id+'">'
			                                      +'<span>'+data.data.name+'</span>'
			                                      +'<button class="btn-remove">Remove</button><button class="btn-edit">Edit</button>'
			                                    +'</a>'
			                                  +'</h4>'
			                                +'</div>'
			                                +'<div id="collapse'+data.data.id+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'+data.data.id+'">'
			                                  +'<div class="panel-body">'
			                                    +'<div class="text-inner">'
			                                        +data.data.description
			                                    +'</div>'
			                                  +'</div>'
			                                +'</div>'
			                            +'</div>';
			                	$('.content-vault-articles [data-id="'+form.find('[name="id"]').val()+'"]').html(string);
			                	$('#modal-article, #modal-article button').removeClass('active');			                	
			                }
				        },
				        error: function(){
				        	form.find('.alert p').text('Error - ControllerJS (9.6)');
			            	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
							form.find('button').removeClass('active').addClass('success');
				        }
				    });
			}
		}
		return false;
	});

	$(document).on('click', '.content-vault .btn-remove', function(event) {
		var check = confirm('Are you sure?');
		if(check){
			var element = $(this).closest('[data-id]');
			var id = element.attr('data-id');
			$.ajax({
		        url: "/superadmin/removecontentvault",
		        type: "POST",            
		        dataType: "json",
		        data: {id: id},		        
		        success: function (data) {		        			        
	                if(data.status == 'error'){
	                	alert(data.message);
	                }else{
	                	element.remove();
	                }
		        },
		        error: function(){
		        	alert('Error - ControllerJS (9.4)');	            	
		        }
		    });
		}
		return false;	
	});

	var imageAjax;
	$(document).on('input', '.content-vault-images input', function(event) {		
		var id = $(this).closest('[data-id]').attr('data-id');
		var name = $(this).val();
		if(imageAjax && imageAjax.readystate != 4)
            imageAjax.abort();
		imageAjax = $.ajax({
	        url: "/superadmin/updateimage",
	        type: "POST",            
	        dataType: "json",
	        data: {id: id, name: name},		        
	        success: function (data) {
	        },
	        error: function(){}
	    });	   
	});

	$(document).on('click', '.content-vault-articles .btn-edit', function(event) {
		var element = $(this).closest('[data-id]');
		var id = element.attr('data-id');
		var name = $(this).parent().find('span').text();
		var description = element.find('.text-inner').html();
		$('#modal-article').addClass('active');
		$('#modal-article .title').text('Update Article');
		$('#modal-article [name="id"]').val(id);
		$('#modal-article [name="name"]').val(name);
		article_editor.setData(description);
		return false;
	});
}

//7. advertisingFunctions: all function for Advertising
advertisingFunctions = function(){
	//SEARCH
	$('.management-box .txt-search.promotion').on('input', function(){
		$(this).closest('.management-box').find('.management-list > li').hide();
		if($.trim($(this).val()).length > 0){
			$(this).closest('.management-box').find('.management-list > li:contains('+$.trim($(this).val())+')').closest('li').show();
		}else{
			$(this).closest('.management-box').find('.management-list > li').show();
		}
	});

	$('#form-update-advertising').submit(function(event) {
		var form = $(this);
		if(!form.hasClass('success')){
			$('#confirm-change').addClass('active');
		}
		return false;
	});
	
	$(document).on('click', '#confirm-change .btn-submit', function(event) {
		$('#confirm-change').removeClass('active');
		var form = $('#form-update-advertising');
		var formData = new FormData(form[0]);	
		$.ajax({
	        url: "/superadmin/advertising/",
	        type: "POST",            
	        dataType: "json",
	        data: formData,
            contentType: false,
            processData: false,			        
	        success: function (data) {
	        	form.find('.alert p').text(data.message);		        	
                if(data.status == 'error'){  	
                	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), marginBottom: 20, opacity: 1}).delay(5000).animate({height: 0, marginBottom: 0, opacity: 0});
					form.find('button').removeClass('active').addClass('success');
                }else{
                	form.find('.alert').addClass('success').stop().animate({height: form.find('.alert p').height(), marginBottom: 20, opacity: 1}).delay(5000).animate({height: 0, marginBottom: 0, opacity: 0});
					form.find('button').removeClass('active').addClass('success');
                }
	        },
	        error: function(){
	        	form.find('.alert p').text('Error - ControllerJS (10.1)');
            	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), marginBottom: 20, opacity: 1}).delay(5000).animate({height: 0, marginBottom: 0, opacity: 0});
				form.find('button').removeClass('active').addClass('success');
	        }
	    });
	});

	$('#form-update-advertising-promotion').submit(function(event) {
		var form = $(this);
		if(!form.hasClass('success')){
			if(!form.find('button').hasClass('active')){
				form.find('button').addClass('active');
				var formData = new FormData($(this)[0]);
				$.ajax({
			        url: "/superadmin/updatepromotion/",
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
		                	window.location = '/superadmin/advertising';
		                }
			        },
			        error: function(){
			        	form.find('.alert p').text('Error - ControllerJS (10.2)');
		            	form.find('.alert').removeClass('success').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, marginTop: 0, opacity: 0});
						form.find('button').removeClass('active').addClass('success');
			        }
			    });
			}
		}
		return false;
	});	

	$('.ad-child-checkbox input').click(function(){		
		var parent = $(this).closest('.col-md-6');		
		parent.find('.feature-image').addClass('hide');
		if($(this).is(':checked')){
			parent.find('.feature-image[data-id=video]').removeClass('hide');			
		}else{
			parent.find('.feature-image[data-id=image]').removeClass('hide');			
		}
	});
}

//8. adsFunctions: ADs
adsFunctions = function() {
	$('.feature-image input[type=file]').change(function(event) {
		if($(this).val() != ''){			
			var element = $(this).closest('.feature-image');
			var id = element.attr('data-ad');
			element.addClass('upload');
			var formData = new FormData();
			formData.append('id', id);
    		formData.append('image', $(this)[0].files[0]);
			$.ajax({
				url: '/superadmin/imagead',
				type: 'POST',
				data : formData,
		       dataType: "json",
		       processData: false,
		       contentType: false,  
			})
			.done(function(data) {
				if(data.status == 'success'){		
					element.find('img').attr('src', data.image).show();
					element.parent().find('[data-id=video] img').attr('src', '').hide();
					element.parent().find('[data-id=video] input').val('');
				}
				else
					console.log(data.message);
			})
			.fail(function() {
				console.log("Error - ControllerJS (11.1)");
			})
			.always(function() {
				element.removeClass('upload');
			});
			
		}
	});

	$('.feature-image input[type=text]').change(function(event) {
		if($(this).val() != ''){			
			var element = $(this).closest('.feature-image');
			var id = element.attr('data-ad');
			var url = $(this).val();
			element.addClass('upload');
			$.ajax({
				url: '/superadmin/videoad',
				type: 'POST',
				data : {id: id, url: url},
		       dataType: "json",		       
			})
			.done(function(data) {
				if(data.status == 'success'){
					element.find('img').attr('src', 'http://img.youtube.com/vi/'+url+'/0.jpg').show();
					element.parent().find('[data-id=image] img').attr('src', '').hide();
				}else
					console.log(data.message);				
			})
			.fail(function() {
				console.log("Error - ControllerJS (11.2)");
			})
			.always(function() {
				element.removeClass('upload');
			});
			
		}
	});

	var ajaxAdLink;
	$('.input-ad-link').on('input', function(event) {
		var id = $(this).attr('data-ad');
		if(ajaxAdLink && ajaxAdLink.readystate != 4)
        	ajaxAdLink.abort();
		ajaxAdLink = $.ajax({
			url: '/superadmin/linkad',
			type: 'POST',
			data : {id: id, link: $(this).val()},
	       dataType: "json",	       
		})
		.done(function(data) {
			if(data.status != 'success')
				console.log(data.message);
		})
		.fail(function() {
			console.log("Error - ControllerJS (11.3)");
		})
		.always(function() {
		});
	});
}

//9. marketingCalendarFunctions: marketingcalendar
marketingCalendarFunctions = function(){
	if($('.ui-calendar').length > 0)
		loadMarketingCalendar();	
	$('.addnew-calendar-plan').click(function(event) {
		$('#addnew-calendar').addClass('active').removeAttr('data-id');
		$('#addnew-calendar .select-type-marketing').val($('#addnew-calendar .select-type-marketing option:eq(0)').val());
		$('#addnew-calendar .ad-autocomplete input').val('');
		$('#addnew-calendar .ad-autocomplete').removeClass('active');
		$('#addnew-calendar .btn-remove-plan').addClass('hide');
		$('#addnew-calendar .list-add').html('');
		var now = new Date();
		now = (now.getMonth()+1)+'/'+now.getDate()+'/'+now.getFullYear();
		$('#addnew-calendar .start_date, #addnew-calendar .end_date').val(now);
		return false;
	});

	$('#addnew-calendar .select-type-marketing').change(function(){
		$('#addnew-calendar .list-add').html('');
		$('#addnew-calendar .ad-autocomplete input').val('');
	});

	var ajaxAutocomplete;
	$('.ad-autocomplete input').on('input', function(event) {
		//event.preventDefault();
		var key = $.trim($(this).val());
		var element = $(this).closest('.ad-autocomplete');
		var ad = element.closest('ul').find('.select-type-marketing option:selected').val();		
		element.removeClass('active');
		element.find('ul').html('');
		if(key.length > 0){
			if(ajaxAutocomplete && ajaxAutocomplete.readystate != 4)
	        	ajaxAutocomplete.abort();
			ajaxAutocomplete = $.ajax({
				url: '/superadmin/adautocomplete',
				type: 'POST',
				data : {id: ad, key: key},
		       dataType: "json",	       
			})
			.done(function(data) {				
				if(data.length > 0){
					var string = '';
					$.each(data, function(index, item) {
						string = string +'<li data-id="'+item.id+'" data-type="'+ad+'"><i class="fa '+item.icon+'"></i>'+item.name+'</li>';
					});
					element.find('ul').html(string);
					element.addClass('active');
				}
			})
			.fail(function() {
				console.log("Error - ControllerJS (12.1)");
			})
		}
	});

	$('.ad-autocomplete input').on('keypress', function(e) {
		if(e.keyCode == 13 && $(this).closest('.ad-autocomplete').find('li').length > 0){
			$(this).closest('.ad-autocomplete').removeClass('active');			
			$(this).val('');
			var string = '<li data-id="'+$(this).closest('.ad-autocomplete').find('li:eq(0)').attr('data-id')+'" data-type="'+$(this).closest('.ad-autocomplete').find('li:eq(0)').attr('data-type')+'">'+$(this).closest('.ad-autocomplete').find('li:eq(0)').append('<span class="btn-remove">&times;</span>').html()+'</li>';
	        $('#addnew-calendar .list-add').append(string);	
		}
	});

	$(document).on('click', '#addnew-calendar .ad-autocomplete li', function(event) {
		$(this).closest('.ad-autocomplete').removeClass('active');
		$(this).closest('.ad-autocomplete').find('input').val('');
		var string = '<li data-id="'+$(this).attr('data-id')+'" data-type="'+$(this).attr('data-type')+'">'+$(this).append('<span class="btn-remove">&times;</span>').html()+'</li>';
        $('#addnew-calendar .list-add').append(string);
	});

	$('html').click(function(event) {
		$('#addnew-calendar .ad-autocomplete').removeClass('active');
	});

	$(document).on('click', '#addnew-calendar .list-add .btn-remove', function(event) {
		$(this).closest('li').remove();
	});

	$('#addnew-calendar .btn-submit').click(function(event) {
		var id = $('#addnew-calendar').attr('data-id');
		var start_date = $('#addnew-calendar .start_date').val();
		var end_date = $('#addnew-calendar .end_date').val();
		var type_id = $('#addnew-calendar .select-type-marketing option:selected').val();
		if(Date.parse(start_date) > Date.parse(end_date)){
			$('#addnew-calendar .alert p').text('Opps! start date should less than end date');
        	$('#addnew-calendar .alert').removeClass('success').stop().animate({height: $('#addnew-calendar .alert p').height(), opacity: 1}).delay(3000).animate({height: 0, marginTop: 0, opacity: 0});			
		}
		else if($('#addnew-calendar .list-add li').length == 0){
			$('#addnew-calendar .alert p').text('Opps! you should add Ad type');
        	$('#addnew-calendar .alert').removeClass('success').stop().animate({height: $('#addnew-calendar .alert p').height(), opacity: 1}).delay(3000).animate({height: 0, marginTop: 0, opacity: 0});			
		}else{			
			var ads = [];
			$('#addnew-calendar .list-add li').each(function() {				
				ads.push($(this).attr('data-id'));
			});
			if (typeof id !== typeof undefined && id !== false) {
				$.ajax({
					url: '/superadmin/updateadtocalendar',
					type: 'POST',
					data : {
						id: id,
						start_date: start_date, 
						end_date: end_date, 
						type_id: type_id,
						ads: ads
					},
			        dataType: "json",	       
				})
				.done(function(data) {				
					if(data.status != 'success'){
						$('#addnew-calendar .alert p').text(data.message);
	        			$('#addnew-calendar .alert').removeClass('success').stop().animate({height: $('#addnew-calendar .alert p').height(), opacity: 1}).delay(3000).animate({height: 0, marginTop: 0, opacity: 0});
					}else{
						$('#addnew-calendar').removeClass('active');
						//reload scheduler
						loadMarketingCalendar();
					}
				})
				.fail(function() {
					$('#addnew-calendar .alert p').text("Error - ControllerJS (12.1)");
	        		$('#addnew-calendar .alert').removeClass('success').stop().animate({height: $('#addnew-calendar .alert p').height(), opacity: 1}).delay(3000).animate({height: 0, marginTop: 0, opacity: 0});
				});
			}else{
				$.ajax({
					url: '/superadmin/addadtocalendar',
					type: 'POST',
					data : {
						start_date: start_date, 
						end_date: end_date, 
						type_id: type_id,
						ads: ads
					},
			        dataType: "json",	       
				})
				.done(function(data) {				
					if(data.status != 'success'){
						$('#addnew-calendar .alert p').text(data.message);
	        			$('#addnew-calendar .alert').removeClass('success').stop().animate({height: $('#addnew-calendar .alert p').height(), opacity: 1}).delay(3000).animate({height: 0, marginTop: 0, opacity: 0});
					}else{
						$('#addnew-calendar').removeClass('active');
						//reload scheduler
						loadMarketingCalendar();
					}
				})
				.fail(function() {
					$('#addnew-calendar .alert p').text("Error - ControllerJS (12)");
	        		$('#addnew-calendar .alert').removeClass('success').stop().animate({height: $('#addnew-calendar .alert p').height(), opacity: 1}).delay(3000).animate({height: 0, marginTop: 0, opacity: 0});
				});
			}
		}
	});

	$('.ui-calendar .arrow.previous').click(function(event) {
		loadMarketingCalendar();	
	});
	$('.ui-calendar .arrow.next').click(function(event) {
		loadMarketingCalendar();	
	});

	$(document).on('click', '.ui-calendar [data-id]', function(event) {
		var id = $(this).attr('data-id');
		$('#addnew-calendar').addClass('active');
		$('#addnew-calendar .select-type-marketing').val($('#addnew-calendar .select-type-marketing option:eq(0)').val());
		$('#addnew-calendar .ad-autocomplete input').val('');
		$('#addnew-calendar .ad-autocomplete').removeClass('active');
		$('#addnew-calendar .list-add').html('');
		$('#addnew-calendar .btn-remove-plan').removeClass('hide');
		$.ajax({
			url: '/superadmin/getcalendardetail',
			type: 'POST',
			data : {id: id},
	        dataType: "json",	       
		})
		.done(function(data) {
			$('#addnew-calendar').attr('data-id', data.id);
			$('#addnew-calendar .select-type-marketing').val(data.type_id);
			$('#addnew-calendar .start_date').val(data.start_date);
			$('#addnew-calendar .end_date').val(data.end_date);
			var string = '';
			$.each(data.list, function(index, item) {
				string+=item.content;
			});
			$('#addnew-calendar .list-add').html(string);
		})
		.fail(function() {});
	});

	$(document).on('click', '#addnew-calendar .btn-remove-plan', function(event) {
		var id = $(this).closest('#addnew-calendar').attr('data-id');
		$.ajax({
			url: '/superadmin/removeadtocalendar',
			type: 'POST',
			data : {id: id},
	        dataType: "json",	       
		})
		.done(function(data) {				
			if(data.status != 'success'){
				$('#addnew-calendar .alert p').text(data.message);
    			$('#addnew-calendar .alert').removeClass('success').stop().animate({height: $('#addnew-calendar .alert p').height(), opacity: 1}).delay(3000).animate({height: 0, marginTop: 0, opacity: 0});
			}else{
				$('#addnew-calendar').removeClass('active');
				//reload scheduler
				loadMarketingCalendar();
			}
		})
		.fail(function() {
			$('#addnew-calendar .alert p').text("Error - ControllerJS (12.3)");
    		$('#addnew-calendar .alert').removeClass('success').stop().animate({height: $('#addnew-calendar .alert p').height(), opacity: 1}).delay(3000).animate({height: 0, marginTop: 0, opacity: 0});
		});
	});
}

var ajaxCalendar;
loadMarketingCalendar = function(){
	$('.ui-calendar .calendar-content > li').html('');
	if(ajaxCalendar && ajaxCalendar.readystate != 4)
	    ajaxCalendar.abort();
	ajaxCalendar = $.ajax({
		url: '/superadmin/getcalendar',
		type: 'POST',
		data : {
			start_date: $('.ui-calendar:eq(0)').attr('data-date'), 
			end_date: $('.ui-calendar:eq(1)').attr('data-date'),
		},
        dataType: "json",	       
	})
	.done(function(data) {
		var faceData = data;
		$('.ui-calendar .calendar-content > li').each(function(index) {
			var elenment = $(this);
			$.each(faceData, function(index, item) {
				if(item.date == elenment.attr('data-date')){					
					elenment.html(item.ads);
					return;
				}
			});
		});
	})
	.fail(function() {});
}

var ajaxSearchclient;
currentClientFunctions = function(){
	$('.client-selected .client-box input').on('input', function(){
		$(this).parent().find('ul').html('');
		var element = $(this).parent().find('ul');
		if(ajaxSearchclient && ajaxSearchclient.readystate != 4)
	    	ajaxSearchclient.abort();
		ajaxSearchclient = $.ajax({
			url: '/superadmin/getclientsearch',
			type: 'POST',
			data : {search: $.trim($(this).val())},
	        dataType: "json",	       
		})
		.done(function(data) {
			$.each(data, function(index, item) {
				if(item.active == 0)
					element.append('<li data-salt="'+item.salt+'">'+item.name+' <span>'+item.id+'</span></li>');
				else
					element.append('<li data-salt="'+item.salt+'" class="active">'+item.name+' <span>'+item.id+'</span></li>');
			});
		})
		.fail(function() {});
	});

	$('.client-selected .client-box ul li').on('click', function(event) {		
		var salt = $(this).attr('data-salt');
		if(!$(this).hasClass('active'))
			$.ajax({
				url: '/superadmin/updatecurrentclient',
				type: 'POST',
				data : {salt: salt},
		        dataType: "json",	       
			})
			.done(function(data) {
				if(data.status != 'success')
					alert(data.message);
				else
					window.location = window.location.pathname;
			})
			.fail(function() {});
	});
}