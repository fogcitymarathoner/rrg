
function invoice_void($vote, $id,$webroot)
{
     var myxmlhttp;
     xmlhttp=new XMLHttpRequest();
     myxmlhttp = CreateXmlHttpReq(resultHandler);
     if ($vote == "Up")
     {
     // REQUEST URL should be replaced by the URL you need to request
     // For example: http://www.websitetoolbox.com/tool/register/USERNAME/create_account
         var url = $webroot+"soap/invoices/void/"+$id+"/1";
     }
     else
     {
         var url = $webroot+"soap/invoices/void/"+$id+"/0";
     }
     //alert(url);alert($vote);
     XmlHttpGET(myxmlhttp, url);
     //alert(url);
}
function invoice_timecard($vote, $id,$webroot)
{
     var myxmlhttp;
     xmlhttp=new XMLHttpRequest();
     myxmlhttp = CreateXmlHttpReq(resultHandler);
     if ($vote == "Up")
     {
     // REQUEST URL should be replaced by the URL you need to request
     // For example: http://www.websitetoolbox.com/tool/register/USERNAME/create_account
         var url = $webroot+"soap/invoices/timecard/"+$id+"/1";
     }
     else
     {
         var url = $webroot+"soap/invoices/timecard/"+$id+"/0";
     }
     //alert(url);alert($vote);
     XmlHttpGET(myxmlhttp, url);
     //alert(url);
}
     function resultHandler () {
     // request is 'ready'
     if (myxmlhttp.readyState == 4) {
         // success
         if (myxmlhttp.status == 200) {
             alert("Success!");
             // myxmlhttp.responseText is the content that was received from the request
         } else {
             alert("There was a problem retrieving the data:\n" + req.statusText);
         }
     }
}
function CreateXmlHttpReq(handler) {
     var xmlhttp = null;

     if (window.XMLHttpRequest) {
         xmlhttp = new XMLHttpRequest();
     } else if (window.ActiveXObject) {
         // users with activeX off
         try {
             xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
         } catch (e) {}
     }
     if (xmlhttp) xmlhttp.onreadystatechange = handler;
     return xmlhttp;
}
// XMLHttp send GEt request
function XmlHttpGET(xmlhttp, url) {
     try {
         xmlhttp.open("GET", url, true);
         xmlhttp.send(null);
     } catch (e) {}
}

$( document ).ready(function() {
    console.log( "ready!" );
    $( "div.reminder-date" ).each(function() {
        var currentElement = $(this);

        var value = currentElement.html(); // if it is an input/select/textarea field
        var date = $.datepicker.parseDate( "mm/dd/yy", value );

        var today = new Date();

        var targetDate= new Date();
        targetDate.setDate(today.getDate() - 7);
        targetDate.setHours(0);
        targetDate.setMinutes(0);
        targetDate.setSeconds(0);

        if ( date <= targetDate ) {
            currentElement.addClass('reminder-date-past');
        }
    });
});