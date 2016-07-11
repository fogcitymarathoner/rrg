
function resume_activeinactive($vote, $id,$webroot)
{
     var myxmlhttp;

     xmlhttp=new XMLHttpRequest();
     myxmlhttp = CreateXmlHttpReq(resultHandler);

     if ($vote == "Up")
     {
     // REQUEST URL should be replaced by the URL you need to request
     // For example: http://www.websitetoolbox.com/tool/register/USERNAME/create_account
         var url = $webroot+"soap/resumes/activeinactive/"+$id+"/1";
     }
     else
     {
         var url = $webroot+"soap/resumes/activeinactive/"+$id+"/0";
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