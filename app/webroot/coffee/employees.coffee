# AJAX Routines for the employees app

$(document).ready ->
  validateDate = (date) ->
    re = /^\d{1,2}\/\d{1,2}\/\d{4}$/
    if date isnt "" and not date.match(re)
      alert "Invalid date format: " + date
      return false
    true
  # need binary values 1 and 0 as objects to quickly convert to string, to match format of int storage in json
  one = 1
  zero = 0
  completeness_check = ($emp_id) ->
    $strike = 0
    $strike_max = 13
    $message = ""
    $strike++  unless empsJSS.Employee[$emp_id].dob
    $strike++  unless empsJSS.Employee[$emp_id].startdate
    $strike++  unless empsJSS.Employee[$emp_id].street1
    $strike++  unless empsJSS.Employee[$emp_id].city
    $strike++  unless empsJSS.Employee[$emp_id].zip
    if parseInt(empsJSS.Employee[$emp_id].usworkstatus ) is 0
      $strike++
      $message = $message + "<li>Work Status not set</li>"
    if parseInt(empsJSS.Employee[$emp_id].tcard) is 0
      $strike++
      $message = $message + "<li>Timecard not given</li>"
    if parseInt( empsJSS.Employee[$emp_id].medical) is 0
      $strike++
      $message = $message + "<li>No Medical Given</li>"
    if parseInt( empsJSS.Employee[$emp_id].w4) is 0
      $strike++
      $message = $message + "<li>W4 Not Filed</li>"
    if parseInt( empsJSS.Employee[$emp_id].de34) is 0
      $strike++
      $message = $message + "<li>De34 Not Filed</li>"
    if parseInt( empsJSS.Employee[$emp_id].i9) is 0
      $strike++
      $message = $message + "<li>I9 Not Filed</li>"
    if parseInt( empsJSS.Employee[$emp_id].indust) is 0
      $strike++
      $message = $message + "<li>Industrial Brochure Not Given</li>"
    if parseInt( empsJSS.Employee[$emp_id].info) is 0
      $strike++
      $message = $message + "<li>Info Not Filed</li>"
    $strike = $strike_max - $strike
    $("#employee-remaining-work-" + $emp_id).html '<ul>'+$message+'</ul>'
    [Math.round(($strike / $strike_max) * 100, 0), $message]
  # turn on spinner
  turnon_spinner = () ->
    $("#employees_waiting_area").addClass "waiting div400x100"
    $("#employees_waiting_area").center()
  # turn on spinner
  turnoff_spinner = () ->
    # turn off spinner
    $("#employees_waiting_area").removeClass "waiting div400x100"
  # finish ajax task by stoping spinner and updating the progress bar
  turnoff_spinner_update_pbar = ($emp_id) ->
    turnoff_spinner()
    # update progressbar
    completeness = completeness_check($emp_id)
    if parseInt(completeness, 10) is 100
      $("#employee-completeness-" + $emp_id).hide()
    else
      $("#emp-completeness-value-" + $emp_id).html completeness[0] + "%"
      $("#pbar-" + $emp_id).progressbar "option", "value", parseInt(completeness[0], 10)
  update_rows = ->
    $("[id^=employee-details-]:visible:even").addClass "altrow"
    $("[id^=employee-details-]:visible:odd").removeClass "altrow"
  pathname = window.location.pathname
  $emp_id = undefined
  $("[id^=employee-details-]").each ->
    str = @id
    substr = str.split("-")
    $emp_id = substr[2]
    completeness = completeness_check($emp_id)
    if parseInt(completeness, 10) is 100
      $("#employee-details-" + $emp_id).remove()
      $("#employee-completeness-" + $emp_id).remove()
    else
      $("#emp-completeness-value-" + $emp_id).html completeness[0] + "%"
      $("#pbar-" + $emp_id).progressbar "option", "value", parseInt(completeness[0], 10)

  $("#deactivate-enddate-form").hide()
  $("#reactivate-form").hide()
  $deactivate_dialog = $("#deactivate-enddate-form").dialog(
    resizable: false
    height: 420
    width: 800
    modal: true
    buttons:
      Deactivate: ->
        $("#deactivate-enddate-form").dialog "close"
        pickerdate = $("#employee-enddate").datepicker("getDate")
        unless pickerdate
          alert "You must input an end date for " + $empName + "."
          $("#deactivate-enddate-form").dialog "open"
        else
          $("#employees_waiting_area").addClass "waiting div400x100"
          $("#employees_waiting_area").center()
          $url = $("#employeedeactiveurl").html()
          $data =
            id: $emp_id
            active: 0
            day: $("#employee-enddate").datepicker("getDate").getDate()
            month: $("#employee-enddate").datepicker("getDate").getMonth() + 1
            year: $("#employee-enddate").datepicker("getDate").getFullYear()
          $.post $url, $data, ((data) ->
            $("#deactivate-enddate-form").dialog "close"
            $("#employees_waiting_area").removeClass "waiting div400x100"
            $("#deactive-employee-" + $emp_id).html "Reactivate"
            $("#employee-details-" + $emp_id).hide()
            update_rows()
          ), "json"
      Cancel: ->
        $("#deactivate-enddate-form").dialog "close"
  )
  $deactivate_dialog.dialog "close"
  $reactivate_dialog = $("#reactivate-form").dialog(
    resizable: false
    height: 420
    width: 800
    modal: true
    buttons:
      Reactivate: ->
        $("#reactivate-form").dialog "close"
        $("#employees_waiting_area").addClass "waiting div400x100"
        $("#employees_waiting_area").center()
        $url = $("#employeedeactiveurl").html()
        $data =
          id: $emp_id
          active: 1
          day: "00"
          month: "00"
          year: "0000"
        $.post $url, $data, ((data) ->
          $("#employees_waiting_area").removeClass "waiting div400x100"
          $("#deactive-employee-" + $emp_id).html "Deactivate"
        ), "json"
      Cancel: ->
        $("#reactivate-enddate-form").dialog "close"
  )
  $reactivate_dialog.dialog "close"
  $("button.employee-status").click (e) ->
    str = @id
    substr = str.split("-")
    $emp_id = substr[2]
    $task = substr[0]
    $empName = empsJSS.Employee[$emp_id].first + " " + empsJSS.Employee[$emp_id].last
    #
    # Activate/Deactivate logic
    #
    if $task is "deactive"
      if $("#deactive-employee-" + $emp_id).html() is "Deactivate"
        $("#active-label").html "Deactivate " + $empName
        $deactivate_dialog.dialog "open"
        $("#employee-enddate").datepicker
          changeMonth: true
          changeYear: true
          yearRange: "1938:2020"
        $("#employee-enddate").show()
        $("#employee-enddate").datepicker "hide"
        $("#employee-enddate").blur()
      else
        $("#reactivate-label").html "Reactivate " + $empName
        $reactivate_dialog.dialog "open"
    #
    # Timecard Logic
    #
    else if $task is "timecard"
      $url = $("#employeetimecardurl").html()
      # turn on spinner
      turnon_spinner()
      if $("#timecard-employee-" + $emp_id).html() is "Timecard Not Given"
        $data =
          id: $emp_id
          vote: 1
        $.post $url, $data, ((data) ->
          $("#timecard-employee-" + $emp_id).html "Timecard Given"
          empsJSS.Employee[$emp_id].tcard = one.toString()
          # needs to be here for proper completion
          turnoff_spinner_update_pbar ($emp_id)
        ), "json"
      else
        $data =
          id: $emp_id
          vote: 0
        $.post $url, $data, ((data) ->
          $("#timecard-employee-" + $emp_id).html "Timecard Not Given"
          empsJSS.Employee[$emp_id].tcard = zero.toString()
          # needs to be here for proper completion
          turnoff_spinner_update_pbar ($emp_id)
        ), "json"
    #
    # Medical Logic
    #
    else if $task is "medical"
      $url = $("#employeemedicalurl").html()
      # turn on spinner
      turnon_spinner()
      if $("#medical-employee-" + $emp_id).html() is "No Medical Given"
        $data =
          id: $emp_id
          vote: 1
        $.post $url, $data, ((data) ->
          $("#medical-employee-" + $emp_id).html "Medical Given"
          empsJSS.Employee[$emp_id].medical = one.toString()
          # needs to be here for proper completion
          turnoff_spinner_update_pbar ($emp_id)
        ), "json"
      else
        $data =
          id: $emp_id
          vote: 0
        $.post $url, $data, ((data) ->
          $("#medical-employee-" + $emp_id).html "No Medical Given"
          empsJSS.Employee[$emp_id].medical = zero.toString()
          # needs to be here for proper completion
          turnoff_spinner_update_pbar ($emp_id)
        ), "json"
    #
    # W4 Logic
    #
    else if $task is "w4"
      $url = $("#employeew4url").html()
      # turn on spinner
      turnon_spinner()
      if $("#w4-employee-" + $emp_id).html() is "W4 Sheet Not Filed"
        $data =
          id: $emp_id
          vote: 1
        $.post $url, $data, ((data) ->
          $("#w4-employee-" + $emp_id).html "W4 Sheet Filed"
          empsJSS.Employee[$emp_id].w4 = one.toString()
          # needs to be here for proper completion
          turnoff_spinner_update_pbar ($emp_id)
        ), "json"
      else
        $data =
          id: $emp_id
          vote: 0
        $.post $url, $data, ((data) ->
          $("#w4-employee-" + $emp_id).html "W4 Sheet Not Filed"
          empsJSS.Employee[$emp_id].w4 = zero.toString()
          # needs to be here for proper completion
          turnoff_spinner_update_pbar ($emp_id)
        ), "json"
    #
    # Info Logic
    #
    else if $task is "info"
      $url = $("#employeeinfourl").html()
      # turn on spinner
      turnon_spinner()
      if $("#info-employee-" + $emp_id).html() is "Info Sheet Not Filed"
        $data =
          id: $emp_id
          vote: 1
        $.post $url, $data, ((data) ->
          $("#info-employee-" + $emp_id).html "Info Sheet Filed"
          empsJSS.Employee[$emp_id].info = one.toString()
          # needs to be here for proper completion
          turnoff_spinner_update_pbar ($emp_id)
        ), "json"
      else
        $data =
          id: $emp_id
          vote: 0
        $.post $url, $data, ((data) ->
          $("#info-employee-" + $emp_id).html "Info Sheet Not Filed"
          empsJSS.Employee[$emp_id].info = zero.toString()
          # needs to be here for proper completion
          turnoff_spinner_update_pbar ($emp_id)
        ), "json"
    #
    # De34 Logic
    #
    else if $task is "de34"
      $url = $("#employeede34url").html()
      # turn on spinner
      turnon_spinner()
      if $("#de34-employee-" + $emp_id).html() is "De34 Not Filed"
        $data =
          id: $emp_id
          vote: 1
        $.post $url, $data, ((data) ->
          $("#de34-employee-" + $emp_id).html "De34 Filed"
          empsJSS.Employee[$emp_id].de34 = one.toString()
          # needs to be here for proper completion
          turnoff_spinner_update_pbar ($emp_id)
        ), "json"
      else
        $data =
          id: $emp_id
          vote: 0
        $.post $url, $data, ((data) ->
          $("#de34-employee-" + $emp_id).html "De34 Not Filed"
          empsJSS.Employee[$emp_id].de34 = zero.toString()
          # needs to be here for proper completion
          turnoff_spinner_update_pbar ($emp_id)
        ), "json"
    #
    # I9 Logic
    #
    else if $task is "i9"
      $url = $("#employeei9url").html()
      # turn on spinner
      turnon_spinner()
      if $("#i9-employee-" + $emp_id).html() is "I9 Not Filed"
        $data =
          id: $emp_id
          vote: 1
        $.post $url, $data, ((data) ->
          $("#i9-employee-" + $emp_id).html "I9 Filed"
          empsJSS.Employee[$emp_id].i9 = one.toString()
          # needs to be here for proper completion
          turnoff_spinner_update_pbar ($emp_id)
        ), "json"
      else
        $data =
          id: $emp_id
          vote: 0
        $.post $url, $data, ((data) ->
          $("#i9-employee-" + $emp_id).html "I9 Sheet Not Filed"
          empsJSS.Employee[$emp_id].i9 = zero.toString()
          # needs to be here for proper completion
          turnoff_spinner_update_pbar ($emp_id)
        ), "json"
    #
    # Indust Logic
    #
    else if $task is "industrial"
      $url = $("#employeeindusturl").html()
      # turn on spinner
      turnon_spinner()
      if $("#industrial-employee-" + $emp_id).html() is "Industrial Brochure Not Given"
        $data =
          id: $emp_id
          vote: 1
        $.post $url, $data, ((data) ->
          $("#industrial-employee-" + $emp_id).html "Industrial Brochure Given"
          empsJSS.Employee[$emp_id].indust = one.toString()
          # needs to be here for proper completion
          turnoff_spinner_update_pbar ($emp_id)
        ), "json"
      else
        $data =
          id: $emp_id
          vote: 0
        $.post $url, $data, ((data) ->
          $("#industrial-employee-" + $emp_id).html "Industrial Brochure Not Given"
          empsJSS.Employee[$emp_id].indust = zero.toString()
          # needs to be here for proper completion
          turnoff_spinner_update_pbar ($emp_id)
        ), "json"
    #
      # Void Logic
      #
    else if $task is "voided"
      $url = $("#employeevoidurl").html()
      # turn on spinner
      turnon_spinner()
      if $("#voided-employee-" + $emp_id).html() is "Void this new employee"
        $data =
          id: $emp_id
          vote: 1
        $.post $url, $data, ((data) ->
          $("#voided-employee-" + $emp_id).html "UnVoid this new employee"
          # needs to be here for proper completion
          turnoff_spinner()
        ), "json"
      else
        $data =
          id: $emp_id
          vote: 0
        $.post $url, $data, ((data) ->
          $("#voided-employee-" + $emp_id).html "Void this new employee"
          # needs to be here for proper completion
          turnoff_spinner()
        ), "json"
# The Label application

  $("form#setup-labels").submit (e) ->
    n = $("#employeeslist").find(":checkbox:checked").length
    unless n
      e.preventDefault()
      alert "You must select some employees"
      false

  unselectAllEmployees = ->
    $("#employeeslist").find(":checkbox").attr "checked", false
    $("#employeeslist").find(":button").html "Select All Employees"
    $("#select-all-employees").attr "value", "Select All Employees"

  $("#select-all-employees").click ->
    if $("#select-all-employees").attr("value") is "Select All Employees"
      $("#employeeslist").find(":checkbox").attr "checked", true
      $("#employeeslist").find(":button").html "Unselect All Employees"
      $("#select-all-employees").attr "value", "Unselect All Employees"
    else
      unselectAllEmployees()

  $preview_count = 0
  $("#preview-radio").prop "checked", true # set preview to be checked default
  $("input[name=group1]:radio").click ->
    radioVal = $("input[name=group1]:checked").val()
    if radioVal is "Preview"
      $("#employee-label-submit").val "Preview"
      $("#label-soap-message").hide()
    else
      if $preview_count is 0
        alert "You need to have preview the sheet once before you can email"
        $("#preview-radio").prop "checked", true # set preview to be checked default
        return
      else
        $("#employee-label-submit").val "Email"
        $email = $("input[name=user_email]").val()
        $("#label-soap-message").show()
        $("#label-soap-message").html "email sheet to " + $email

  $("input#employee-label-submit").click (e) ->
    e.preventDefault()
    radioVal = $("input[name=group1]:checked").val()
    if radioVal is "Preview"
      $preview_count++
      $url = $("#soap-employees-labels-pdf").html()
      $data = $("#EmployeesLabelsPdfForm").serialize()
      $.post $url, $data, ((data) ->
        $("#label-soap-message").show()
        $("#label-soap-message").html data["message"]
      ), "json"
      alert "Please review the label sheet in next window and come back here to email"
      $fixname = $("input[name=fixture-random]").val()
      $url = $("#employeelabelspdfurl").html() + "?fixfile=" + $fixname
      window.open $url
    else if radioVal is "Email"
      $url = $("#soap-employees-labels-pdf-email").html()
      $data = $("#EmployeesLabelsPdfForm").serialize()
      $.post $url, $data, ((data) ->
        $("#label-soap-message").show()
        $("#label-soap-message").html data["message"]
        $preview_count = 0
        $("#employee-label-submit").val "Preview"
        $("#preview-radio").prop "checked", true # set preview to be checked default
      ), "json"

