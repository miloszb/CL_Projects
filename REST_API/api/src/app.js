
jQuery(function(){
    $('body').empty();
    $(document).attr('title', 'REST API');
    jQuery.ajax({
            url:'http://localhost/CL_Projects/REST_API/api/src/rest.php',
            method: 'GET'
    }).done(function(response){
        var colors = JSON.parse(response);
        colors.forEach(function(col) {
            var newDiv = $(
                    '<div style="width: 100px; background-color: '
                    + col + '">' + col + '</div>'
            );
            newDiv.appendTo($('body'));
        });
    });

//    jQuery.ajax({
//            url:'http://date.jsontest.com/',
//    }).done(function(response){
//        console.log(response);
//    });
});
