(function ($, OC) {

    function getQuantity() {
        return $.ajax({
             url: OC.generateUrl('/apps/user_quota/getItemsCount'),
        }); 
    } 

    function getUsed(quotadiv) {
        return quotadiv.attr('style').replace(/width:(.*%).*/g, '$1');
    }

    $(function () {
        var quotatext = $('#quota #quotatext');

        if(quotatext.length) {
            var used = '<strong>' + getUsed($('#quota div')) + '</strong>';

            quotatext.append('  (Used : ' + used + ')');

            getQuantity().done(function (result) {
                var files = '<strong>' + result.files + '</strong>';
                var folders = '<strong>' + result.folders + '</strong>';

                quotatext.append('  Items Count : (');
                quotatext.append('files : ' + files + ', ');
                quotatext.append('folders : ' + folders + ')');
            });
        }
    });



})(jQuery, OC); 
