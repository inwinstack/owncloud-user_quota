/**
 * ownCloud - User_Quota 
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Simon <simon.l@inwinstack.com>
 * @copyright Simon 2015
 */
(function ($, OC) { 
    
    function getData(uids) {
        return  $.ajax({	    
           url: OC.generateUrl('/apps/user_quota/getUsed'),
           method: 'POST',
           datatype: 'json',
           data: {uids: uids}
        });    
    }
    
    function render(current_row, data, name) {
        
       data[name] != undefined && current_row.find('.usage div').replaceWith(data[name]);
    }

    function userCreated(usage, name) {
        $('#userlist tbody tr:visible').each(function() {
            if($(this).data('uid') == name) {
               var current_row = $(this);
                
               render(current_row, usage, name);
                
               return false;
            }
        });
    }
    
    function userListLoaded(data) {
        $('#userlist tbody tr:visible').each(function() {
            var current_row = $(this);
            var name =  current_row.find('.name').text();
            
            render(current_row, data, name);
        });
    } 
    
    $(function() {
        ajaxSuccess.bind('GET:/settings/users/users', function(event) {
            var uids = "";
            var uidresponse = event.xhr.responseJSON;
            for(var i = 0 ; i < uidresponse.length ; i++) {
                uids += uidresponse[i]['name'];
                if(i != uidresponse.length-1) {
                    uids += ",";
                }
            }
            
            if(uids != "") {
                getData(uids).done(function(result) {
                    userListLoaded(result.data);
                });
            }
        });
        
        ajaxSuccess.bind('POST:/settings/users/users', function(event) {
            var uid =  event.xhr.responseJSON.name;
            
            getData(uid).done(function(result) {
                userCreated(result.data, uid);
            });
        });

        var cell_usage = $('<td>').attr({class:'usage'});
        var loader = $('<div>').attr({class:'loading-usages'});
        var translation = t('user_quota', 'Usage');
        var th = $('<th>').attr({width: '150px'});
        
        cell_usage.append(loader);
        $('#userlist tbody tr:hidden .quota').after(cell_usage);
        $('#userlist thead tr #headerQuota').after(th.text(translation));
    });

})(jQuery, OC);    
