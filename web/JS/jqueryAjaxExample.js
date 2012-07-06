/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function restults(xml)
{
    alert(xml);
}



$(document).ready(function(){
    $("#myid").click(function(){
        //alert('hello');
        $.ajax({
            data: "name=anton",
            type: "GET",
            dataType: "xml",
            url: "http://EcotrabJAXWS/hello",
            success: function(xml)
            { restults(xml); } 
        });
    });
});


