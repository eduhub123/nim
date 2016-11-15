$(document).ready(function() {	
	responsive();
	$(window).resize(function(event) {
		responsive();
	});

	loginFunctions();
	signupFunctions();
	validationForm();
});

var currentDate;

responsive = function(){
	if($('.dotdotdot').length > 0)
		$('.dotdotdot').dotdotdot();
}

loginFunctions = function(){
	$('#login-form').submit(function(event) {
		var form = $(this);
		if(!form.hasClass('success')){
			if(!form.find('button').hasClass('active')){
				form.find('button').addClass('active');
				$.ajax({
		            url: "login",
		            type: "POST",            
		            dataType: "json",
		            data: {
		            	username: $('#login-email').val(),
		            	password: $('#login-password').val()
		            },
		            success: function (data) {
		                if(data.status == 'error'){
		                	form.find('.alert p').text(data.message);
		                	form.find('.alert').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, opacity: 0});
							form.find('button').removeClass('active').addClass('success');
		                }
		                else window.location = data.url;
		            },
		            error: function(){
		            	form.find('.alert p').text('Error - ControllerJS (1)');
		            	form.find('.alert').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, opacity: 0});
						form.find('button').removeClass('active').addClass('success');
		            }
		        });
			}
		}
		return false;
	});
}

signupFunctions = function() {
	$('#signup-form').submit(function(event) {
		var form = $(this);
		if(!form.hasClass('success')){
			if(!form.find('button').hasClass('active')){
				form.find('button').addClass('active');
				$.ajax({
		            url: "signupemployee",
		            type: "POST",            
		            dataType: "json",
		            data: {
		            	salt: $('#signup-salt').val(),
		            	firstname: $('#signup-firstname').val(),
		            	lastname:  $('#signup-lastname').val(),		            	
		            	password: $('#password').val(),
		            	birthday:  $('#signup-birthday').val(),
		            },
		            success: function (data) {
		                if(data.status == 'error'){
		                	form.find('.alert p').text(data.message);
		                	form.find('.alert').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, opacity: 0});
							form.find('button').removeClass('active').addClass('success');
		                }
		                else window.location = data.url;
		            },
		            error: function(){
		            	form.find('.alert p').text('Error - ControllerJS (2.2)');
		            	form.find('.alert').stop().animate({height: form.find('.alert p').height(), opacity: 1}).delay(5000).animate({height: 0, opacity: 0});
						form.find('button').removeClass('active').addClass('success');
		            }
		        });
			}
		}
		return false;
	});
	if($('.input-datepicker').length > 0) $('.input-datepicker').datetimepicker({format: 'MM/DD/YYYY'}).on('dp.change', function() {
		if($(this).length > 0)
			$(this).removeClass('invalid').addClass('valid');
	});
	$('#signup-form #agree-term').click(function(event) {
		if($(this).is(':checked'))
			$(this).closest('#signup-form').find('.btn-submit').attr('disabled', false);
		else
			$(this).closest('#signup-form').find('.btn-submit').attr('disabled', true);

	});
	$('#signup-form #password').on('input', function(event) {
		event.stopPropagation();
		if($(this).val().length > 0){
			$('#signup-form .check-strength').show();
			var check = checkStrength($.trim($(this).val()));
			$('#signup-form .check-strength').css('color', check.color).text(check.text);
			if(check.type < 3)
				$(this).removeClass('valid').addClass('invalid');
			else
				$(this).removeClass('invalid').addClass('valid');
		}else{
			$(this).removeClass('valid').addClass('invalid');
			$('#signup-form .check-strength').hide();
		}
	});

	$('#signup-form #confirm-password').on('input', function(event) {
		event.stopPropagation();
		if($(this).val().length > 0 && $(this).val() == $('#signup-form #password').val()){
			$(this).removeClass('invalid').addClass('valid');
		}else{
			$(this).removeClass('valid').addClass('invalid');
		}
	});
}

validationForm = function() {
	$(document).on('input', 'form[novalidate] input[required]', function() {
		$(this).removeClass('invalid').addClass('valid');
		if($.trim($(this).val()).length == 0)
			$(this).removeClass('valid').addClass('invalid');
		if($(this).attr('type') == 'email' && !isEmail($(this).val()))
			$(this).removeClass('valid').addClass('invalid');				
	});

	$(document).on('click', 'form[novalidate] [type=submit]', function(event) {		
		var n = 0;
		$(this).closest('form').find('input').each(function(){
			var attr = $(this).attr('required');
			$(this).removeClass('invalid').addClass('valid');
			if(typeof attr !== typeof undefined && attr !== false && $.trim($(this).val()).length == 0){
				$(this).removeClass('valid').addClass('invalid');
				n++;
			}
			if($(this).attr('type') == 'email' && !isEmail($(this).val()))
				$(this).removeClass('valid').addClass('invalid');
		});	
		if(n == 0)
			return true;
		return false;
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