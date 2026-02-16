jQuery(function($) {

	$(function(){
		$('#main-slider.carousel').carousel({
			interval: 10000,
			pause: false
		});
	});

	//Ajax contact
	var form = $('.contact-form');
	form.submit(function () {
		$this = $(this);
		$.post($(this).attr('action'),form.serialize(), function(data,status) {
			$this.prev().text(data).fadeIn().delay(3000).fadeOut();
                        if (data == "Your Query has been received, We will contact you soon.") {
                                $('.contact-form')[0].reset();//To reset form fields on success
                          }else{
                              $this.prev().addClass('alert-danger');
                          }
		});
		return false;
	});

	//smooth scroll
	$('.navbar-nav > li').click(function(event) {	
		var target = $(this).find('>a').prop('hash');
                if(target){
                    event.preventDefault();
		$('html, body').animate({
                    
			scrollTop: $(target).offset().top
		}, 500);
            }
	});

	//scrollspy
	$('[data-spy="scroll"]').each(function () {
		var $spy = $(this).scrollspy('refresh')
	})

	//PrettyPhoto
	$("a.preview").prettyPhoto({
		social_tools: false
	});

	//Isotope
	$(window).load(function(){
		$portfolio = $('.portfolio-items');
		$portfolio.isotope({
			itemSelector : 'li',
			layoutMode : 'fitRows'
		});
		$portfolio_selectors = $('.portfolio-filter >li>a');
		$portfolio_selectors.on('click', function(){
			$portfolio_selectors.removeClass('active');
			$(this).addClass('active');
			var selector = $(this).attr('data-filter');
			$portfolio.isotope({ filter: selector });
			return false;
		});
	});
});