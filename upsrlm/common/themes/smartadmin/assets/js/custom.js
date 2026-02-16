myapp_config.root_
        .on('click touchend', '[data-action]', function (e) {

            var actiontype = $(this).data('action');
            switch (true) {


                case (actiontype === 'app-back'):

                    window.history.go(-1);

                    break;

            }

            /* hide tooltip if any present */
            $(this).tooltip('hide');
            if (myapp_config.debugState)
                console.log("From Custom-> data-action clicked: " + actiontype);
            /* stop default link action */
            e.stopPropagation();
            e.preventDefault();

        });

        
        $(document).ready(function() {
            $('#i18').click(function() {
                if ($('.hee').hasClass('ques-border_sa')) {
                  $('.hee').removeClass('ques-border_sa');
                } else {
                  $('.hee').addClass('ques-border_sa');
                }
              });

              $('#i19').click(function() {
                  $('.hee').removeClass('ques-border_sa');
               
              });

              $('#i27').click(function() {
                if ($('.hee2').hasClass('ques-border_sa')) {
                  $('.hee2').removeClass('ques-border_sa');
                } else {
                  $('.hee2').addClass('ques-border_sa');
                }
              });

              $('#i28').click(function() {
                $('.hee2').removeClass('ques-border_sa');
             
            });


              $('#i38').click(function() {
                if ($('.hee3').hasClass('ques-border_sa')) {
                  $('.hee3').removeClass('ques-border_sa');
                } else {
                  $('.hee3').addClass('ques-border_sa');
                }
              });

              $('#i39').click(function() {
                $('.hee3').removeClass('ques-border_sa');
             
            });

            $('#i17').click(function() {
              if ($('.hee_4').hasClass('ques-border_last')) {
                $('.hee_4').removeClass('ques-border_last');
              } else {
                $('.hee_4').addClass('ques-border_last');
              }
            });

            $('#i18').click(function() {
              $('.hee_4').removeClass('ques-border_last');
           
          });

        });



    
    