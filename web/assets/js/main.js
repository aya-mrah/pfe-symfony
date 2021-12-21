/*
	Project: Jwebi
	Developer: 
*/

$(document).ready(function(){
    
    /* ## Btn Hamburger Event */
    $("header .iconHamburger").click(function(e){
        e.preventDefault();
        $(".headerContent").slideToggle('fast');
        $(this).toggleClass('navbar-toggle');
    });
    
    /* ## HowItWorks Event  */
    $(".HowItWorks h3").click(function(){
         $(".HowItWorks .HowItWorksCont").slideToggle('fast');
         $(this).toggleClass('ShapeOne2');
    });

    /* ### collapsibleGroup */
    $('.clHead').on('click', function(e){
        e.preventDefault();
        $(this).closest('.collapsibleGroup').toggleClass('collapsed');
    });

    /* ## Height Block Calcular*/

    /*
    var ch = $('.darkBg .leftSidebar').height();
    $('.darkBg .mainSection').css({
        'height': ch + 'px'
    });
    */
    /* ## Height Block Paiement*/
    var chTwo = $('.Paiements .content-right').height();
    $('.Paiements .content-left .Paiement-level').css({
        'height': chTwo + 'px'
    });
    
    /* ## Alert Messages */
    $(".alertMessages .close").click(function(){
        $('.alertMessages').hide();
    });
    /*## Aller Retour -- Aller Simple*/
    $(".blueBack a").click(function(){
        $(".blueBack a").removeClass('active');
        $(this).addClass('active');
     });
    $("#allerS").click(function(){
           $('.dateTwoHide').hide();
           $('#date2').hide();
          $('#allerSimple').val('1');
    });
    $("#allerR").click(function(){
        $('.dateTwoHide').show();
        $('#date2').show();
        $('#allerSimple').val('0');
    });

    /*## search Result Mobile*/
     $(".searchBtnM").click(function(){
        $('.leftSidebar').removeClass('hide');
        $('.rechercheMobile').hide();
     });

    $(".resultM .Close").click(function(){
        $('.mainSearch').removeClass('searchData');
        $('.searchSideBar').removeClass('searchData');
    });

    /* ## SubMenu Header */
    $('.userMail .userPhoto .jwebiLink').click(function(e){
        e.preventDefault();
        $('.userMail .subMenu').slideToggle('fast');
    });
    $(".userPhoto").mouseover(function () {
        $('.userMail .subMenu').show();
        $('.userPhoto').mouseout(function() {$('.userMail .subMenu').hide();});
    });

    /* ## numbers-row */
    
    $(".button").on("click", function() {

        var $button = $(this);
        var oldValue = ($button.parent().find("input").val() == '') ? 0 : $button.parent().find("input").val();

        if ($button.text() == "+") {
          var newVal = parseFloat(oldValue) + 1;
        } else {
           // Don't allow decrementing below zero
          if (oldValue > 0) {
            var newVal = parseFloat(oldValue) - 1;
            } else {
            newVal = 0;
          }
          }

        $button.parent().find("input").val(newVal);
        $button.parent().find("input").trigger('change');

      });
    
        /* ## Tab Nav */
    
          $('.TabClick').click(function(){
            var a = $(this);

            var active_tab_class = 'active-tab-menu';

            var the_tab = '.' + a.attr('data-tab');

            $('.TabClick').removeClass(active_tab_class);

            a.addClass(active_tab_class);

            $('.tabs-content .tabs').css({'display' : 'none'});
            $(the_tab).show();

            return false;
          });
    
        $('.TabClickTwo').click(function(){
            var a = $(this);

            if(a.data('tab') == 'tab11'){
                $('.HowItWorks').addClass('showSubTabs');
            }else{
                $('.HowItWorks').removeClass('showSubTabs');
            }

            $('h2.paddH').text(a.text());

            var active_tab_class = 'active-tab-menu';

            var the_tab = '.' + a.attr('data-tab');

            $('.TabClickTwo').removeClass(active_tab_class);

            a.addClass(active_tab_class);

            $('.tabs-content2 .tabsTwo').css({'display' : 'none'});
            $(the_tab).show();

            return false;
          });

        /* ## Scroll Header Fixed Mobile */
    
    
        if($(window).width() < 767){
            $(window).scroll(function() {
                if($(window).scrollTop() > 50){
                    $('header').addClass('fixed');
                }else  {
                    $('header').removeClass('fixed');
                }
            });
        }
    
        /* ## FAQ */
        
        $(".FAQ dt").click(function(){
            $(this).next().slideToggle();
        });
    
        /* ## PopPin */
                
        $(".ReportThisUserBlock .ReportThisUser").click(function(e){
            e.preventDefault();
            $(".ReportThisUserBlock .ModelContent").show();
        });
        $(".ReportThisUserBlock .CloseModel").click(function(e){
            e.preventDefault();
            $(".ReportThisUserBlock .ModelContent").hide();
        }); 
    
        $(".btnUpContent .btnUpComm").click(function(e){
            e.preventDefault();
            $(".btnUpContent .ModelContent").show();
        });
        $(".btnUpContent .CloseModel").click(function(e){
            e.preventDefault();
            $(".btnUpContent .ModelContent").hide();
        });
    
        $(".NoteTransaction .btnLink").click(function(e){
            e.preventDefault();
            $(this).parent('.NoteTransaction').find(".ModelContent").show();
        });
        $(".NoteTransaction .CloseModel").click(function(e){
            e.preventDefault();
            $(".NoteTransaction .ModelContent").hide();
        });

        $(".ReportThisAdTwo .ReportThisAd").on('click', function(e){
            e.preventDefault();
            $(this).closest('.ReportThisAdTwo').find('.ModelContent').show();
        });

        $(".ReportThisAdTwo .ModelItem .CloseModel").on('click', function(e){
            e.preventDefault();
            $(".ReportThisAdTwo .ModelContent").hide();
            
        });
    
    
    
        /* ## Show & Hide Link */
    
        if($(window).width() < 767){
            $(".content-right .ShowLink").click(function(e){
                e.preventDefault();
                $(".content-right .blockHide").slideDown();
                $(".content-right .ShowLink").css("display", "none");
                $(".content-right .HideLink").css("display", "block");
            });
            $(".content-right .HideLink").click(function(e){
                e.preventDefault();
                $(".content-right .blockHide").slideUp();
                $(".content-right .HideLink").css("display", "none");
                $(".content-right .ShowLink").css("display", "block");
            });
        }
        
        /* ## Hover Déconnexion */
        
        $(".btnDeconnexion .iconDesc").hover(
          function(){
              $('.btnDeconnexion .LinkDesc').show();
          },
          function(){
              $('.btnDeconnexion .LinkDesc').hide();
          } 
        );

        /*
        $('.stars').each(function(){
            val = $(this).data('val') || 0;
            val = isNaN(val) ? 0 : val ;
            $(this).find('.star:lt('+val+')').addClass('on');
            $(this).find('input').val(val);
        });*/

        $('.stars .star').on('click', function(){
            $parent = $(this).closest('.stars');

            val = $(this).data('val') || 0;

            $('.stars .star').removeClass('on');
            $parent.find('.star:lt('+val+')').addClass('on');
            $parent.data('val', val);
            $parent.find('input').val(val);

        });
    
        /* ## PreventDefauilt */
        
        $(".UtilsateurJwebiImg  a, .CommunityUsersImg").click(function(e){
           e.preventDefault(); 
        });

         /* ## CloseModelBtn */
        $(".CloseModelBtn").click(function(e){
            e.preventDefault();
           Modal.hide();
            if ($('#trip_uniqid').length) {
                $('#trip_uniqid').val('');
            }

            if ($('#form_trip_errors').length) {
                $('#form_trip_errors').remove();
            }
            if ($('#form_trip_errors').length) {
                $('#form_trip_errors').remove();
            }
        });


    // ###################################################### //

    /* Responsive Script */
    //if (window.matchMedia("(max-width: 768px)").matches) {

        $(".sideBarHead").click(function(){ 
            $('.leftSidebar').toggleClass('visibilityBlock');
        });

    //}
    
    
    
    /* Resize Inscription Two */
    /*
    $(window).resize(function() {
        $('.ConnexionTwo').height($(window).height());
    });

    $(window).trigger('resize');
    */
});


var Modal = {
    show: function(popup,callBack){
        $('#modal, .modalContent').hide();
        if(popup){
            $('#modal:has('+popup+'), '+popup).show();
        }else{
            $('#modal').show();
        }

        $('body').addClass('noScroll');
        this.redisplay();
        if(typeof callBack == 'function')
        {
            callBack();
        }
        $(document).keyup(function(e) {
          if (e.keyCode == 27) Modal.hide();
        });
        
       
    },

    hide: function(callBack){
        $('#modal, .modalContent').hide();
        $('body').removeClass('noScroll');
        this.redisplay();
        if(typeof callBack == 'function')
            callBack();
    },

    reset: function(){
        $('#modal').hide();
        $('body').removeClass('noScroll');
        $('#modalBox').html('');
        this.redisplay();
    },

    redisplay: function(){
        setTimeout(function(){
            if($('#modalBox').innerHeight() > $(window).height()){ $('#modalBox').addClass('fullHeight'); }
            else{ $('#modalBox').removeClass('fullHeight'); }
        },200);
        
    }
};














