// Generated by CoffeeScript 1.6.2
/*
Created with JetBrains PhpStorm.
User: marc
Date: 4/21/13
Time: 1:23 PM
To change this template use File | Settings | File Templates.
*/


(function() {
  $(document).ready(function() {
    var $preview_count;

    $preview_count = 0;
    $("#preview-radio").prop("checked", true);
    $("input[name=group1]:radio").click(function() {
      var $email, radioVal;

      radioVal = $("input[name=group1]:checked").val();
      if (radioVal === "Preview") {
        $("#label-submit").val("Preview");
        return $("#label-soap-message").hide();
      } else {
        if ($preview_count === 0) {
          alert("You need to have preview the sheet once before you can email");
          $("#preview-radio").prop("checked", true);
        } else {
          $("#label-submit").val("Email");
          $email = $("input[name=user_email]").val();
          $("#label-soap-message").show();
          return $("#label-soap-message").html("email sheet to " + $email);
        }
      }
    });
    return $("input#label-submit").click(function(e) {
      var $data, $fixname, $url, radioVal;

      e.preventDefault();
      radioVal = $("input[name=group1]:checked").val();
      if (radioVal === "Preview") {
        $preview_count++;
        $url = $("#employeelabelspdfsendurl").html();
        $data = labelsheetdata;
        $.post($url, $data, (function(data) {
          $("#label-soap-message").show();
          return $("#label-soap-message").html(data["message"]);
        }), "json");
        alert("Please review the label sheet in next window and come back here to email");
        $fixname = $("input[name=fixture-random]").val();
        $url = $("#employeelabelspdfurl").html() + "?fixfile=" + labelsheetdata['fixture-random'] + '.json';
        return window.open($url);
      } else if (radioVal === "Email") {
        $url = $("#employeelabelspdfsendemailurl").html();
        $data = labelsheetdata;
        return $.post($url, $data, (function(data) {
          $("#label-soap-message").show();
          $("#label-soap-message").html(data["message"]);
          $preview_count = 0;
          $("#label-submit").val("Preview");
          return $("#preview-radio").prop("checked", true);
        }), "json");
      }
    });
  });

}).call(this);
