
function stickyFooter(){

    positionFooter(); 
    function positionFooter(){
        $("#contentFoot").css({position: "absolute",top:($(window).scrollTop()+$(window).height()-$("#contentFoot").height())+"px"})    
    }
 
    $(window)
        .scroll(positionFooter)
        .resize(positionFooter)
}


        jQuery(document).ready(function($)
        {
            stickyFooter(); 
            
            var percent = ($("body").height() * 10)/100;
           

        $(window).resize(function() {
            stickyFooter();
            var percent = ($("body").height() * 10)/100;
            $(".tablescroll_wrapper").css("width", ($(window).width())+'px');
             $(".tablescroll_wrapper2").css("width", ($(window).width())+'px');
              $(".tablescroll_head").css("width", ($(window).width())+'px');
               $(".tablescroll_body").css("width", ($(window).width())+'px');
               $(".tablescroll_foot").css("width", ($(window).width())+'px');
               $(".tablescroll_head thead").css("width", ($(window).width())+'px');
               $(".tablescroll_foot tfoot").css("width", ($(window).width())+'px');

                $("#sorter").css("height", percent+'px');

              

        });

             $("#sorter").tablesorter({ 
        // sort on the first column and third column, order asc 
        sortList: [[0,0],[2,0]] 
    }); 
             $('#select1').ddslick({width:'120'});
             $('#select2').ddslick({width:'120'});
             $('#select4').ddslick({width:'120'});
             $('#select5').ddslick({width:'140'});
         
       
        });

        /*]]>*/