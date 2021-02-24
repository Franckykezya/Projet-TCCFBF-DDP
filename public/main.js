jQuery(function($){
    $('.tabs').each(function(){
        var current = null;
        current = $(this).find('a:first').attr('href');
        //alert(current);
        $(this).find('a[href="'+current+'"]').addClass('active');
        $(current).siblings().hide();
        
        $(this).find('a').click(function(){
            var link = $(this).attr('href');
            if(link == current){
                return false;
            }else{
                $(this).siblings().removeClass('active');
                $(this).addClass('active');
                $(link).show().siblings().hide();
                current = link;
            } 
        
        });
    });
});