(function ($, OC) {

    function getQuantity() {
        return $.ajax({
             url: OC.generateUrl('/apps/user_quota/getItemsCount'),
        }); 
    } 

    function getUsed(quotadiv) {
        return quotadiv.attr('style').replace(/width:(.*%).*/g, '$1');
    }

    function createContain() {
        var contains = $('<div>').attr({id : 'contains', class : 'section'}).append('<h2>'+t('user_quota', 'Contains')+'</h2>');

        contains.append($('<div>').attr({class : 'loading-contains'}));
         
        return contains; 
    }

    function setItemsQuantity(files, folders) {
        var files_contain = $('<div>').attr({class:'contains-item'});
        var folders_contain = $('<div>').attr({class:'contains-item'});
        var files_span = $('<span>').attr({class:'contains-item-text'});
        var folders_span = $('<span>').attr({class:'contains-item-text'});
        var contain_div = $('<div>');

        files_contain.append($('<div>').attr({class:'contains-item-icon', style:'background-image:url("../../core/img/filetypes/text.svg"); background-size:32px;'}));
        files_span.text(' x '+files);
        files_contain.append(files_span);

        folders_contain.append($('<div>').attr({class:'contains-item-icon', style:'background-image:url("../../core/img/filetypes/folder.svg"); background-size:32px;'}));
        folders_span.text(' x '+folders);
        folders_contain.append(folders_span);
        
        contain_div.append(folders_contain);
        contain_div.append(files_contain);

        $('#contains').find('.loading-contains').replaceWith(contain_div);
    }

    $(function () {
        var quotatext = $('#quota #quotatext');

        if(quotatext.length) {
            var used = getUsed($('#quota div'));
            var span = $('<span>').attr({class : 'quota-ratio'});

            span.append(used);
            quotatext.append(span);
            $('#quota').after(createContain());
            
            
            getQuantity().done(function (result) {
                setItemsQuantity(result.files, result.folders);    

            });
           
        }
    });



})(jQuery, OC); 
