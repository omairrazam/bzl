/* variable names to make code generic and save time*/
var DIV_MSG_SENT = '#message_sent';
var DIV_MSG_FAIL = '#message_nsent';
var FORM_NAME = '#contact-form';
var BLUR_CLASS = '.form-group';
var DIV_PROCESS = '#process';

//requires  bootstrap validator  ref = http://1000hz.github.io/bootstrap-validator/

$('#contact-form').validator().on('submit', function (e) {

  if (e.isDefaultPrevented()) {
    // handle the invalid form...
  } else {

   		e.preventDefault();

		$contact_form = $(FORM_NAME);
		var fields = $contact_form.serializeArray();
		var test = {};
		$.each(fields, function(){

			test[this.name] = this.value;
		})
		
		$(BLUR_CLASS).addClass("blur");
		
		
		
		$(DIV_PROCESS).show();
		$.ajax({
			type: "POST",
			url: "php/contact-form.php",
			data: fields,
			dataType: 'json',
			success: function(response) {
				//alert(response.error);
				if(response.status)
					{
						//alert('success');
						$(DIV_PROCESS).hide();
						$(DIV_MSG_SENT).slideDown(400).delay(2000).slideUp('','',clearDiv);	
						$(DIV_MSG_SENT).removeClass("hidden");

					}
				else
					{
						$(DIV_PROCESS).hide();
						$(DIV_MSG_FAIL).slideDown(400).delay(2000).slideUp('','',clearDiv);	
						$(DIV_MSG_FAIL).removeClass("hidden");
					}
				
				
			},
			
		}).fail(function(){
			alert('no internet connection');
		});
  }
})

function clearDiv(){
	//removing blurness that was added before
	$(BLUR_CLASS).removeClass("blur");
	//resetting form
	 $(FORM_NAME).closest('form').find("input[type=text], textarea").val("");
}

