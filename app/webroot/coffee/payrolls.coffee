###
Created with JetBrains PhpStorm.
User: marc
Date: 4/21/13
Time: 1:23 PM
To change this template use File | Settings | File Templates.
###
order_checks = (data) ->

  # The JQuery plugin tableDnD provides a serialize() function which provides the re-ordered
  # data in a list. We pass that list as an object called "data" to a Django view
  # to save the re-ordered data into the database.
  $payroll_id = $("#payroll-id").html()
  $rebuild_script_url = $("#rebuild-scripts-url").html()
  $.post $rebuild_script_url, data, "json"
  false
page_numbers = ->
  i = 0
  rows = $("#paymenttable tr")
  rows.each (index) ->
    cell = $("td:first-child", this)
    ++i
    cell.html i.toString()

update_rows = ->
  $("tr:even").addClass "altrow"
  $("tr:odd").removeClass "altrow"
$(document).ready ->

  # Initialise the task table for drag/drop re-ordering
  $("#paymenttable").tableDnD()
  $("#paymenttable").tableDnD onDrop: (table, row) ->
    update_rows()
    page_numbers()
    order_checks $.tableDnD.serialize()

  $("div#label-soap-message").hide()
  $preview_count = 0
  $("#preview-radio").prop "checked", true # set preview to be checked default
  $("input[name=group1]:radio").click ->
    radioVal = $("input[name=group1]:checked").val()
    if radioVal is "Preview"
      $("#label-submit").val "Preview"
      $("#label-soap-message").hide()
    else
      if $preview_count is 0
        alert "You need to have preview the sheet once before you can email"
        $("#preview-radio").prop "checked", true # set preview to be checked default
        return
      else
        $("#label-submit").val "Email"
        $("#label-soap-message").show()
        $("#label-soap-message").html "email sheet to " + labelsheetdata.user_email
  $("input#label-submit").click (e) ->
    e.preventDefault()
    radioVal = $("input[name=group1]:checked").val()
    if radioVal is "Preview"
      $preview_count++
      $url = $("#payroll-labels-pdf-sendurl").html()
      labelsheetdata.row =$("select[name=row]").val()
      labelsheetdata.column =$("select[name=column]").val()
      $data = labelsheetdata #$("#EmployeesLabelsPdfForm").serialize()
      $.post $url, $data, ((data) ->
        $("#label-soap-message").show()
        $("#label-soap-message").html data["message"]
      ), "json"
      alert "Please review the label sheet in next window and come back here to email"
      $fixname = $("input[name=fixture-random]").val()
      $url = $("#employeelabelspdfurl").html() + "?fixfile=" + labelsheetdata['fixture-random']
      window.open $url
    else if radioVal is "Email"
      $url = $("#employeelabelspdfsendemailurl").html()
      $data = labelsheetdata #$("#EmployeesLabelsPdfForm").serialize()
      $.post $url, $data, ((data) ->
        $("#label-soap-message").show()
        $("#label-soap-message").html data["message"]
        $preview_count = 0
        $("#label-submit").val "Preview"
        $("#preview-radio").prop "checked", true # set preview to be checked default
      ), "json"

