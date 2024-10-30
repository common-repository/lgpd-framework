jQuery(function ($) {
	var calvisible = false;
	$('.lgpd-consent-until-cal').click(function(){
		if(calvisible == false){
			$('.lgpd-consent-until').css('opacity', 1);
			calvisible = true;
		}else{
			$('.lgpd-consent-until').css('opacity', 0);
			calvisible = false;
		}		
	});
	$('.lgpd-consent-until').change(function(){
		$('.lgpd-consent-until').css('opacity', 0);

	});
});
