$(document).ready(function() {	
	responsive();
	$(window).resize(function(event) {
		responsive();
	});

	var lastScrollTop = $(this).scrollTop();
	$(window).scroll(function(event) {
		var top  = $(this).scrollTop();
		if (top != lastScrollTop){
			//$('#header').addClass('scroll');
			if($('.btn-right-side').length > 0 && !$('.btn-right-side').hasClass('active')){
				$('.btn-right-side').addClass('active');
				setTimeout(function(argument) {
					$('.btn-right-side').removeClass('active');
				}, 5000);
			}if($('.btn-back-home').length > 0 && !$('.btn-back-home').hasClass('active')){
				$('.btn-back-home').addClass('active');
				setTimeout(function(argument) {
					$('.btn-back-home').removeClass('active');
				}, 5000);
			}
		}
	});

	$('.hamburger-tab > li > div.title').click(function(event) {
		var element = $(this).parent();
		if(element.hasClass('active') && !element.hasClass('disabled'))
			element.find('.hide-tab').slideUp('slow',function(){element.removeClass('active'); $(this).css('overflow','visible');});
		else
			element.find('.hide-tab').slideDown('slow',function(){element.addClass('active'); $(this).css('overflow','visible');});
	});
	$('.hamburger-tab > li .arrow-up').click(function(event) {
		var element = $(this).closest('li');
		element.find('.hide-tab').slideUp('slow',function(){element.removeClass('active')});
	});

	$('#content-submission .ui-select li').click(function(event) {
		$(this).closest('.hide-tab').find('.hide-content').show();		
	});

	$(document).on('click', '.list-images .video', function(event) {
		$('#video-play').addClass('active');
		$('#video-play iframe').attr('src', 'https://www.youtube.com/embed/'+$(this).attr('data-id')+'?autoplay=1');
	});

	$('.md-modal .close, .md-modal .btn-cancel').click(function(event) {
		$(this).closest('.md-modal').removeClass('active');		
	});

	$('#video-play .close').click(function(event) {
		$(this).closest('#video-play').find('iframe').attr('src','');
	});

	if($('.fancybox').length > 0) $('.fancybox').fancybox();	

	if($('[data-toggle="tooltip"]').length > 0) $('[data-toggle="tooltip"]').tooltip();

	if($('.input-datepicker').length > 0) $('.input-datepicker').datetimepicker({format: 'MM/DD/YYYY'}).on('dp.change', function() {
		if($(this).length > 0)
			$(this).removeClass('invalid').addClass('valid');
	});

	if($('#run-slider').length > 0){
		var skipSlider = document.getElementById('run-slider');	
		console.log(skipSlider.getAttribute('data-value'));
		noUiSlider.create(skipSlider, {
			start: skipSlider.getAttribute('data-value'),		
			range: {
				'min': -50,
				'25%': -25,
				'50%': 0,
				'75%': 25,
				'max': 50
			},
			snap: true,
		});
		skipSlider.noUiSlider.on('change', function(values, handle){			
			if ( handle == 0 ) {
				$('#run-slider').parent().find('input').val(values[handle]);
			}
		});
	}

	if($('#header .list-notifications').length > 0)
		$('#header .list-notifications').mCustomScrollbar({theme: 'minimal-dark'});

	$('.menu-notification .icon').click(function(event) {
		event.stopPropagation();
		$('.menu-message').removeClass('active');
		if(!$(this).parent().hasClass('active'))
			$(this).parent().addClass('active');
		else
			$(this).parent().removeClass('active');
	});

	$('.menu-notification .notification-hide').click(function(event) {
		event.stopPropagation();
	});

	$('.menu-notification .notification-hide a').click(function(event) {
		event.preventDefault();
		$(this).closest('.menu-notification').removeClass('active');
	});

	if($('#header .list-messages').length > 0)
		$('#header .list-messages').mCustomScrollbar({theme: 'minimal-dark'});

	$('.menu-message .icon').click(function(event) {
		event.stopPropagation();
		$('.menu-notification').removeClass('active');
		if(!$(this).parent().hasClass('active'))
			$(this).parent().addClass('active');
		else
			$(this).parent().removeClass('active');
	});

	$('.menu-message .message-hide').click(function(event) {
		event.stopPropagation();
	});

	$('.menu-message .message-hide a').click(function(event) {
		event.preventDefault();
		$(this).closest('.menu-message').removeClass('active');
	});

	$('html').click(function(event) {
		$('.menu-notification, .menu-message').removeClass('active');
		$('.comment-box').addClass('hide');
		$('.client-selected').removeClass('active');
	});

	$('.discount-content button').click(function(event) {
		$(this).hide();
		$(this).parent().find('.hide').removeClass('hide');
	});

	$('[name=promotion_type]').click(function(event) {		
		$('.discount-content li').removeClass('active');
		$('.discount-content li:eq('+$(this).data('index')+')').addClass('active');
	});

	$('.btn-open-ticket').click(function(event) {
		$('.ticket-create').slideDown();
	});

	$('.ticket-create .btn-cancel').click(function(event) {
		$('.ticket-create').slideUp();
	});

	$('.btn-right-side.btn-open-comment').click(function(event) {
		event.stopPropagation();	
		if(!$('.comment-box').hasClass('hide'))
			$('.comment-box').addClass('hide');
		else
			$('.comment-box').removeClass('hide');
		return false;
	});

	$('.comment-box').click(function(event) {
		event.stopPropagation();
	});

	$('.client-selected .user').click(function(event) {
		event.stopPropagation();
		if(!$('.client-selected').hasClass('active'))
			$('.client-selected').addClass('active');
		else
			$('.client-selected').removeClass('active');
	});

	$('.client-selected .client-box').click(function(event) {
		event.stopPropagation();
	});

	$('.list-faqs .list li label').click(function(event) {
		if($(this).parent().hasClass('active'))
			$('.list-faqs .list li').removeClass('active');
		else{
			$('.list-faqs .list li').removeClass('active');
			$(this).parent().addClass('active');
		}
	});

	
	initUI();
	//UI CALENDAR
	if($('.ui-calendar').length > 0){
		initUICanlendar($('.ui-calendar').attr('data-date'));
	}
	$('.ui-calendar .arrow.previous').click(function(event) {
		currentDate.setMonth(currentDate.getMonth()-1);
		initUICanlendar();	
	});
	$('.ui-calendar .arrow.next').click(function(event) {
		currentDate.setMonth(currentDate.getMonth()+1);
		initUICanlendar();	
	});
	//END UI CALENDAR
	signupFunctions();
	analysisFunctions();	
	validationForm();
	actionMedia();

	//SEARCH
    jQuery.expr[':'].contains = function(a, i, m) {
      return jQuery(a).text().toUpperCase()
          .indexOf(m[3].toUpperCase()) >= 0;
    };
});

var currentDate;

responsive = function(){
	if($('.dotdotdot').length > 0)
		$('.dotdotdot').dotdotdot();
}

initUI = function(){
	$('.ui-select label').click(function(event) {
		event.stopPropagation();
		if($(this).parent().hasClass('active'))
			$(this).parent().removeClass('active');
		else
			$(this).parent().addClass('active');
	});

	$('.ui-select li').click(function(event) {
		$(this).closest('.ui-select').removeClass('active');
		$(this).closest('.ui-select').find('label').text($(this).text()).attr('data-value', $(this).attr('data-value'));
	});

	$('.ui-calendar .calendar-content li .ui-ads').click(function(event) {
		event.preventDefault();
	});

	$('html').click(function(event) {
		$('.ui-select').removeClass('active');
	});
}

initUICanlendar = function(date){
	if(date)
		currentDate = new Date(date);
	var arrayMonth = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	
	$('.ui-calendar').each(function(indexParent) {
		var otherDate = new Date(currentDate);		
		otherDate.setMonth(otherDate.getMonth() + indexParent);		
		var previousLastDay = new Date(otherDate.getFullYear(), otherDate.getMonth(), 0);
		var currentFirstDay = new Date(otherDate.getFullYear(), otherDate.getMonth(), 1);
		var currentLastDay = new Date(otherDate.getFullYear(), otherDate.getMonth()+1, 0);			

		var totalChild = $('.ui-calendar .calendar-content > li').length;	
		$(this).find('.calendar-content > li').removeClass('disabled');	
		$(this).find('.calendar-bar center strong').text(arrayMonth[otherDate.getMonth()]+' - '+otherDate.getFullYear());
		$(this).attr('data-date',((otherDate.getMonth()+1) + '/01/' + otherDate.getFullYear()));

		var previousCount = previousLastDay.getDate();

		var currentCount = 1;
		var nextCount = 1;
		$(this).find('.calendar-content > li').each(function(index) {
			if(index < currentFirstDay.getDay()){
				$(this).addClass('disabled');
				previousCount = previousLastDay.getDate() - currentFirstDay.getDay() + index + 1;
				$(this).attr('data-number', previousCount);
				$(this).attr('data-date',  ("0" + otherDate.getMonth()).slice(-2) + '-' + ("0" + previousCount).slice(-2) + '-' + otherDate.getFullYear());
				previousCount++;
			}else if(index > (currentLastDay.getDate() + currentFirstDay.getDay() - 1)){
				$(this).addClass('disabled');
				$(this).attr('data-number', nextCount);
				$(this).attr('data-date', ("0" + (otherDate.getMonth()+2)).slice(-2) + '-' + ("0" + nextCount).slice(-2) + '-' + otherDate.getFullYear());
				nextCount++;
			}else{
				$(this).attr('data-number', currentCount);
				$(this).attr('data-date', ("0" + (otherDate.getMonth()+1)).slice(-2) + '-' + ("0" + currentCount).slice(-2) + '-' + otherDate.getFullYear());
				currentCount++;
			}
		});
	});	
}

signupFunctions = function() {	
	$('#updateprofile-form #password').on('input', function(event) {
		event.stopPropagation();
		if($(this).val().length > 0){
			$('#updateprofile-form .check-strength').show();
			var check = checkStrength($.trim($(this).val()));
			$('#updateprofile-form .check-strength').css('color', check.color).text(check.text);
			if(check.type < 3)
				$(this).removeClass('valid').addClass('invalid');
			else
				$(this).removeClass('invalid').addClass('valid');
		}else{
			$(this).removeClass('valid').addClass('invalid');
			$('#updateprofile-form .check-strength').hide();
		}
	});

	$('#updateprofile-form #confirm-password').on('input', function(event) {
		event.stopPropagation();
		if($(this).val().length > 0 && $(this).val() == $('#updateprofile-form #password').val()){
			$(this).removeClass('invalid').addClass('valid');
		}else{
			$(this).removeClass('valid').addClass('invalid');
		}
	});

	$('#change-password').click(function(event) {
		if($(this).is(':checked')){
			$('.open-change-password').removeClass('hide');
			$('.open-change-password input').attr('required', true);
		}
		else{
			$('.open-change-password').addClass('hide');
			$('.open-change-password input').attr('required', false);
		}
	});

	$('#upload-user-avatar').change(function(){
		var formData = new FormData();
        formData.append('image', $(this)[0].files[0]);
        var element = $(this);
        $.ajax({
			url: "/site/updateavatar",
            type: "POST",            
            dataType: "json",
            data: formData,                             
            contentType: false,
            processData: false, 
		})
		.done(function(data) {
			if(data.status == 'error')
				alert(data.message);
			else{								
				element.closest('.user-avatar').find('.avatar').addClass('none');
				element.closest('.user-avatar').find('.img').removeClass('hide').attr('style', 'background-image: url('+data.message+')');
			}
		})
		.fail(function() {
			alert('Error - Upload Avatar');
		})
		.always(function() {
			
		});
	});

	$('.list-marketing-services h3 input').click(function() {
		if($(this).is(':checked'))
			$(this).closest('li').find('ul').removeClass('hide');
		else
			$(this).closest('li').find('ul').addClass('hide');
	});

	$('#big-tabs li').click(function(event) {
		$('#big-tabs li').removeClass('active');
		$(this).addClass('active');
		$('.big-tab-child').addClass('hide');
		$('.big-tab-child.'+$(this).attr('data-tab')).removeClass('hide');
	});
}

analysisFunctions = function(){
	if($('.circle').length > 0)
		$('.circle').each(function(index, el) {
			$(this).circleProgress({
				startAngle: -Math.PI/2,
				value: Number($(this).data('value'))/100,
		      	thickness: 8,
		      	animation: {duration: 1600},
		      	fill: { color: $(this).data('color') },
		      	emptyFill: "#4b4b4b"
			});
		});
	$('.analysis-tabs > li').click(function(event) {
		$(this).parent().find('li').removeClass('active');
		$(this).addClass('active');
		$(this).parent().parent().find('.analysis-child').removeClass('active');
		$(this).parent().parent().find('.analysis-child.'+$(this).data('tab')).addClass('active');
	});

	$('.employee-tabs > li').click(function(event) {
		$(this).parent().find('li').removeClass('active');
		$(this).addClass('active');
		$(this).parent().parent().find('.employee-tab-child').addClass('hide');
		$(this).parent().parent().find('.employee-tab-child.'+$(this).data('tab')).removeClass('hide');
	});

	$('.ads-tabs > li').click(function(event) {
		$(this).parent().find('li').removeClass('active');
		$(this).addClass('active');
		$(this).parent().parent().find('.ads-tab-child').addClass('hide');
		$(this).parent().parent().find('.ads-tab-child.'+$(this).data('tab')).removeClass('hide');
	});
}

validationForm = function() {
	$(document).on('input', 'form[novalidate] input[required], form[novalidate] select[required]', function() {
		$(this).removeClass('invalid').addClass('valid');
		if($.trim($(this).val()).length == 0)
			$(this).removeClass('valid').addClass('invalid');
		if($(this).attr('type') == 'email' && !isEmail($(this).val()))
			$(this).removeClass('valid').addClass('invalid');				
	});

	$(document).on('click', 'form[novalidate] [type=submit]', function(event) {		
		var n = 0;
		$(this).closest('form').find('input, select').each(function(){
			var attr = $(this).attr('required');
			$(this).removeClass('invalid').addClass('valid');
			if(typeof attr !== typeof undefined && attr !== false && $.trim($(this).val()).length == 0){
				$(this).removeClass('valid').addClass('invalid');
				n++;
			}
			if($(this).attr('type') == 'email' && !isEmail($(this).val())){
				$(this).removeClass('valid').addClass('invalid');
				n++;
			}
		});	
		if(n == 0)
			return true;
		return false;
	});
}

actionMedia = function(){
  $(document).on('click', '#modal-gallery .list-media li', function(event) {
    if($('#modal-gallery').hasClass('multi')){
      if($(this).hasClass('active'))
        $(this).removeClass('active');  
      else
        $(this).addClass('active');
    }else{
      if(!$(this).hasClass('active')){
        $('#modal-gallery .list-media li').removeClass('active');
        $(this).addClass('active');
      }else
        $('#modal-gallery .list-media li').removeClass('active');      
    }
    if($(this).hasClass('active')){
      $('#modal-gallery .media-detail').addClass('active');
      $('#modal-gallery .media-detail img').attr('src', $(this).data('url'));      
      $('#modal-gallery .media-detail strong').text($(this).data('url').split('/')[$(this).data('url').split('/').length-1]);
      $('#modal-gallery .media-detail .date').text($(this).data('date'));
      $('#modal-gallery .media-detail .size').text($(this).data('size'));
      $('#modal-gallery .media-detail .width_height').text($(this).data('width_height'));
      $('#modal-gallery .media-detail .url').val($(this).data('url'));
      $('#modal-gallery .media-detail .name').val($(this).data('name'));
    }else
      $('#modal-gallery .media-detail').removeClass('active');
  });
  
  if($('#modal-gallery').length > 0){
    // $.ajax({
    //   url: "/manager/mediaajax",
    //   type: "POST",            
    //   dataType: "json",
    //   success: function (data) {
    //     var list = $('#modal-gallery .list-media');
    //     list.html('');
    //     for (var i = 0; i < data.length; i++) {
    //       var string = '<li data-id="'+data[i].id+'" data-name="'+data[i].name+'" data-type="'+data[i].type+'" data-url="'+data[i].url+'" data-width_height="'+data[i].width_height+'" data-size="'+data[i].size+'">'
    //                     +'<div class="box-img"><img src="'+data[i].url+'" alt=""></div></li>';
    //       list.append(string);
    //     };
    //   },
    //   error: function(){
    //   }
    // });
  }

  $(document).on('change', '#modal-gallery #input-file-upload', function(event) {
    var formData = new FormData();
    formData.append('image', $(this)[0].files[0]);
    $.ajax({
       url : '/manager/createmediaajax',
       type : 'POST',
       data : formData,
       dataType: "json",
       processData: false,  // tell jQuery not to process the data
       contentType: false,  // tell jQuery not to set contentType
       success : function(data) {
          if(data.status == 'success'){
            $.ajax({
              url: "/manager/mediaajax",
              type: "POST",            
              dataType: "json",
              success: function (data) {
                var list = $('#modal-gallery .list-media');
                list.html('');
                for (var i = 0; i < data.length; i++) {
                  var string = '<li data-id="'+data[i].id+'" data-name="'+data[i].name+'" data-type="'+data[i].type+'" data-url="'+data[i].url+'" data-width_height="'+data[i].width_height+'" data-size="'+data[i].size+'">'
                                +'<div class="box-img"><img src="'+data[i].url+'" alt=""></div></li>';
                  list.append(string);
                };
              },
              error: function(){
              }
            });
          }
          $('#modal-gallery .form-upload .alert').text(data.message);
       }
    });
  });

  $(document).on('click', '#modal-gallery .close', function(event) {
    $('#modal-gallery').removeClass('active').removeClass('multi');
  });

  $(document).on('click', '.btn-open-gallery', function(event) {
    var id = $(this).data('id');
    $('#modal-gallery').addClass('active');
    $('#modal-gallery .gallery-footer .btn').attr('data-id', id);
    $('#modal-gallery .list-media li, #modal-gallery .media-detail').removeClass('active');
    if($(this).hasClass('multi'))
      $('#modal-gallery').addClass('multi');
  });

  $(document).on('click', '#modal-gallery .gallery-footer .btn', function(event) {
    if($('#modal-gallery .list-media li.active').length == 0)
      alert('Vui lòng chọn ảnh');
    else{            
      if(!$('#modal-gallery').hasClass('multi')){
        $('#'+$(this).attr('data-id')).attr('src', $('#modal-gallery .list-media li.active').attr('data-url')).show();
        $('#'+$(this).attr('data-id')).parent().find('input[type=hidden]').val($('#modal-gallery .list-media li.active').attr('data-url'));
      }else{
        var string = '';
        var element = $('#'+$(this).attr('data-id'));
        element.html('');      
        $('#modal-gallery .list-media li.active').each(function(index, el) {
          element.append('<li><span class="remove">&times;</span><img src="'+$(this).attr('data-url')+'"></li>');
          string = string + $(this).attr('data-url') + '||ladaku||';          
        });
        $('#'+$(this).attr('data-id')).parent().find('input[type=hidden]').val(string);
      }
      $('#modal-gallery').removeClass('active').removeClass('multi');
    }
  });

  $(document).on('click', '#slide_images .remove', function(event) {
    var index = $(this).parent().index();        
    var array = $(this).closest('#slide_images').parent().find('input[type=hidden]').val().split('||ladaku||');
    array.splice(index,1);
    console.log(array);
    var string = '';
    for (var i = 0; i < array.length - 1; i++) {
      string = string + array[i] + '||ladaku||';
    };
    $(this).closest('#slide_images').parent().find('input[type=hidden]').val(string);
    $(this).parent().remove();
  });
}

//VALIDATE EMAIL
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

//VALIDATE PASSWORD
checkStrength = function(password)
{
	//initial strength
	var strength = 0
	
	//if the password length is less than 6, return message.
	if (password.length < 6) {
		return {type: 1, color: '#c34242', text: 'Too short'};
	}
	
	//length is ok, lets continue.
	
	//if length is 8 characters or more, increase strength value
	if (password.length > 7) strength += 1
	
	//if password contains both lower and uppercase characters, increase strength value
	if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))  strength += 1
	
	//if it has numbers and characters, increase strength value
	if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))  strength += 1 
	
	//if it has one special character, increase strength value
	if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))  strength += 1
	
	//if it has two special characters, increase strength value
	if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
	
	//now we have calculated strength value, we can return messages
	
	//if value is less than 2
	if (strength < 2 )
	{		
		return {type: 2, color: '#c34242', text: 'Weak'};		
	}
	else if (strength == 2 )
	{
		return {type: 3, color: '#578129', text: 'Good'};
	}
	else
	{
		return {type: 4, color: '#578129', text: 'Strong'};
	}
}