# AJAX Routines for the reminders app
#
# Routines to return bulky html back to the page
#
#  Data From overnite routines that output the db to xml
remindersGlobal = {}
timecards = {}
reminders_waiting = {}
voids = 'VOIDS'
opens = 'OPENS'
employees = 'EMPLOYEES'
clients = 'CLIENTS'
contracts = 'CONTRACTS'
timecard_receipts_pending = 'TIMECARD_RECEIPTS_PENDING'
timecard_receipts_sent = 'TIMECARD_RECEIPTS_SENT'
# AJAX settings in components/json.php
settings = 'SETTINGS'
######################################################################################################
# open url in new separate window
openWindow = (window_src) ->
  window.open window_src, "newwindow", config = "height=100, width=400, " + "toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, " + "directories=no, status=no"
  return
######################################################################################################
#
# Tab type fetching of data on invoice id and tabname
#
#####################################################################################################
get_post_logs = (id,type) ->
  if type == 'reminder'
    logs = reminders.reminders[id].p_log
  if type == 'open'
    logs = opens.opens[id].p_log
  if type == 'void'
    logs = voids.voids[id].p_log
  logs
obj_out = (obj_in) ->
  pkeys = {}
  pkeys.employee_id = obj_in.e_id
  pkeys.client_id = obj_in.c_id
  pkeys.contract_id = obj_in.con_id
  pkeys.inv = obj_in
  pkeys
reminder_keys = (k) ->
  obj_in = remindersGlobal.reminders[k]
  pkeys = obj_out obj_in
timecard_keys = (k) ->
  obj_in = timecards.timecards[k]
  pkeys = obj_out obj_in
reminder_waiting_keys = (k) ->
  obj_in = reminder_waiting.reminders[k]
  pkeys = obj_out obj_in
open_keys = (k) ->
  obj_in = opens.opens[k]
  pkeys = obj_out obj_in
receipt_pending_keys = (k) ->
  obj_in = timecard_receipts_pending.timecard_receipts[k]
  pkeys = obj_out obj_in
reciept_sent_keys = (k) ->
  obj_in = timecard_receipts_sent.timecard_receipts[k]
  pkeys = obj_out obj_in
void_keys = (k) ->
  obj_in = voids.voids[k]
  pkeys = obj_out obj_in
primary_keys = (k,type) ->
  if type == 'reminder'
    pkeys = reminder_keys(k)
  if type == 'timecard'
    pkeys = timecard_keys(k)
  if type == 'reminder-waiting'
    pkeys = reminder_waiting_keys(k)
  if type == 'open'
    pkeys = open_keys(k)
  if type == 'receipt-sent'
    pkeys = reciept_sent_keys(k)
  if type == 'receipt-pending'
    pkeys = receipt_pending_keys(k)
  if type == 'void'
    pkeys = void_keys(k)
  pkeys

invoice_items_count = (invoice_items) ->

  count = 0
  for item of invoice_items
    count++
  count
######################################################################################################
#
# Time display helper functions - start
#
######################################################################################################
displayTime = ->
  str = ""
  currentTime = new Date()
  hours = currentTime.getHours()
  minutes = currentTime.getMinutes()
  seconds = currentTime.getSeconds()
  minutes = "0" + minutes  if minutes < 10
  seconds = "0" + seconds  if seconds < 10
  str += hours + ":" + minutes + ":" + seconds
  str
# change fixture timestamps to the php/sql convention
php_timestamp = ->
  days =["Sun","Mon","Tue","Wed","Thu","Fri","Sat"  ]
  months = ["January", "February", "March",  "April",  "May",  "June",  "July",   "August",  "September",  "October",  "November",  "December"]
  date = new Date()
  day = date.getDate()
  month = date.getMonth() + 1
  yy = date.getYear()
  year = (if (yy < 1000) then yy + 1900 else yy)
  year = year.toString()
  dow = date.getDay()
  displaytime = displayTime()
  displaydow = days[dow]
  displaymonth =months[month]
  ts =   displaydow + ', '
  ts = ts + day+ ' '
  ts = ts + displaymonth+ ' '
  ts = ts + year + ' '
  ts = ts + displaytime
  ts
######################################################################################################
#
# Time display helper functions - end
#
######################################################################################################
######################################################################################################
#
# Formatted snippets helpers - start
#
######################################################################################################
employee_first_last = (employee) ->
  employee.f+' '+ employee.l
######################################################################################################
#
# Formatted snippets helpers - end
#
######################################################################################################
######################################################################################################
#
# Formatted snippets - start
#
######################################################################################################
log_listing = (logs) ->
  res = '<ul class="email-log-list">'
  for log of logs
    if logs[log].em? and logs[log].ts?
      res = res + '<li class="log-entry">'
      res = res + logs[log].em + ' | '
      res = res + logs[log].ts
      res = res + '</li>'
  res = res + '</ul>'
  res
invoice_number = (reminder, type) ->
  return '<div class="invoice-number inline" id="'+type+'-invoice-number-'+reminder.id+'">'+reminder.id+'</div>'
amount_formatted = (inv)  ->
  '<div id="invoice-amount-'+inv.id+'">$'+inv.amt+'</div>'
client_formatted = (id)  ->
  cssclass = 'client-name inline'
  if parseInt(clients.clients[id].a) == 0
    cssclass = cssclass + ' inactive'
  res = '<div class="' + cssclass + '">'
  res = res + clients.clients[id].n
  res = res + '</div>'
employee_distrib_formatted = (employee)  ->
  emails = employee.ems
  res = '<div class="employee-distribution"><h3>Ditributiion Emails</h3></h3><ul>'
  for key of emails
    res =  res + '<li>'+ emails[key] + '</li>'
  res = res + '</ul></div>'
date_colored = (date) ->
  cssclass = 'inline'
  substr = date.split("/")
  month = substr[0] - 1
  day = substr[1]
  year = substr[2]
  date_obj = new Date(year, month, day)
  now = new Date()
  if date_obj > now
    cssclass = cssclass + ' future'
  else
    cssclass = cssclass + ' past'
  res = '<div class="' + cssclass+'">'+date + '</div>'
period_formatted_color = (inv) ->
  res = date_colored inv.ps
  res = res + "<div class='inline date-sep'>-</div>"
  res = res + date_colored inv.pe

period_formatted = (reminder)  ->
  res = '<div class="period inline" >'
  res = res + period_formatted_color reminder
  res = res + "</div>"
  res
employee_formatted = (id)  ->

  cssclass = 'employee-name inline'
  if parseInt(employees.employees[id].a) == 0
    cssclass = cssclass + ' inactive'
  res = '<div class="' + cssclass + '">'
  res = res + employee_first_last employees.employees[id]
  res = res + '</div>'
employee_log_formatted = (id, reminder, type)  ->
  if type == 'reminder'
    logs = reminder.r_log
  if type == 'reminder-waiting'
    logs = reminder.r_log
  if type == 'void'
    logs = reminder.r_log
  res = '<h3>Reminder History</h3>'
  res = res + log_listing(logs)
  res
receipt_log_formatted = (id,type)  ->
  if type == 'receipt-pending'
    logs = timecard_receipts_pending.timecard_receipts[id].log
  if type == 'receipt-sent'
    logs = timecard_receipts_sent.timecard_receipts[id].log
  res = '<h3>Receipt Log</h3>'
  res = res + log_listing(logs)
  res
post_log_formatted = (id,type)  ->
  logs = get_post_logs(id, type)
  res = '<h3>Post History</h3>'
  res = res + log_listing(logs)
  res
employee_email_distribution_formatted = (id, reminder, type)  ->

  employee_id = reminder.e_id
  res = '<h3>Employee Distribution</h3>'
  res = res +  '<ul class="email-list">'

  employee_email_distribution = employees.employees[employee_id].ems
  for email of employee_email_distribution
    res = res + '<li class="email">'
    if employee_email_distribution[email]?
      res = res + employee_email_distribution[email]
    res = res + '</li>'
  res = res + '</ul>'
  res
invoice_email_distribution_formatted = (id,reminder, type)  ->
  res = '<h3>Invoice Distribution</h3>'
  res = res +  '<ul class="email-list">'
  res = res + '<li class="email">-- Internal Distribution --</li>'
  invoice_email_distribution = contracts.contracts[reminder.con_id].emd
  for email of invoice_email_distribution
    res = res + '<li class="email">'
    if invoice_email_distribution[email]?
      res = res + invoice_email_distribution[email]
    res = res + '</li>'
  res = res + '<li class="email">-- External Distribution --</li>'
  manager_email_distribution = contracts.contracts[reminder.con_id].mmd
  for email of manager_email_distribution
    res = res + '<li class="email">'
    if manager_email_distribution[email]?
      res = res + manager_email_distribution[email]
    res = res + '</li>'
  res = res + '</ul>'
  res
invoice_items_formatted = (id,invoice_items) ->
  res = ''
  res = res + '<li class="invoice-item">'
  res = res + '<div class="invoice-item-description  inline">Description</div>'
  res = res + '<div class="invoice-item-amount inline">Amount</div>'
  res = res + '<div class="invoice-item-quantity inline">Quantity</div>'
  res = res + '<div class="invoice-item-total inline"></div>'
  res = res + '</li>'
  for item of invoice_items
    res = res + '<li class="invoice-item">'
    res = res + '<div class="invoice-item-description  inline">' + invoice_items[item].d + '</div>'
    res = res + '<div class="invoice-item-amount inline">' + invoice_items[item].a + '</div>'
    res = res + '<div class="invoice-item-quantity inline">' + invoice_items[item].q + '</div>'
    res = res + '<div class="invoice-item-total inline"></div>'
    res = res + '</li>'
  # blank item
  res
######################################################################################################
#
# Formatted snippets - end
#
######################################################################################################
######################################################################################################
#
# Formatted snippets filled in - start
#
######################################################################################################
invoice_number_formatted_filled = (id, element)  ->
  $('#'+element).html id
period_formatted_filled = (inv, element)  ->
  $('#'+element).html period_formatted_color(inv)
employee_formatted_filled = (employee, element)  ->
  cssclass = 'employee-name inline'
  $('#'+element).addClass(cssclass)
  $('#'+element).removeClass('inactive')
  if parseInt(employee.a) == 0
    $('#'+element).addClass('inactive')
  $('#'+element).html employee_first_last employee
client_formatted_filled = (client, element)  ->
  cssclass = 'employee-name inline'
  $('#'+element).addClass(cssclass)
  $('#'+element).removeClass('inactive')
  if parseInt(client.a) == 0
    $('#'+element).addClass('inactive')
  $('#'+element).html client.n
amount_formatted_filled = (inv, element)  ->
  cssclass = 'employee-name inline'
  $('#'+element).addClass(cssclass)

  $('#'+element).html inv.amt
invoice_items_filled = (id,invoice_items) ->
  j = 0
  for key of  invoice_items
    #alert invoice_items[key].id
    #alert invoice_items[key].d
    $('input#InvoicesItem-id-'+j).val(invoice_items[key].id)
    $('input#InvoicesItem-description-'+j).val(invoice_items[key].d)
    $('input#InvoicesItem-amount-'+j).val(invoice_items[key].a)
    $('input#InvoicesItem-quantity-'+j).val(invoice_items[key].q)
    j++
  count = invoice_items_count(invoice_items)
  for i in [j..10] by 1
    #alert i
    $('input#InvoicesItem-id-'+i).val('')
    $('input#InvoicesItem-description-'+i).val('')
    $('input#InvoicesItem-amount-'+i).val('')
    $('input#InvoicesItem-quantity-'+i).val('')

  for i in [0..10] by 1

    if isEven(i++)
      $('li#invoice-item-'+i).addClass('altrow')
#$('#edit-invoice-input-items').html invoice_items_formatted(id,invoice_items)
######################################################################################################
#
# Formatted snippets filled in - end
#
######################################################################################################
start_spinner = () ->
  $("#reminders-waiting-area").addClass "waiting div400x100"
  $("#reminders-waiting-area").center().css("zIndex",11)
  $("#modal-overlay").fadeIn() # darkens background for for spinner
stop_spinner = () ->
  $("#reminders-waiting-area").removeClass "waiting div400x100"
  $("#modal-overlay").fadeOut() # darkens background for for spinner
######################################################################################################
#
# Object moving functions - start
#
######################################################################################################
remove_reminder = (id) ->
  # remove reminder from reminders
  reminders_tmp = {}
  reminders_tmp.reminders = {}
  for key of reminders.reminders
    if key != id
      reminder = reminders.reminders[key]
      reminders_tmp.reminders[key] = {}
      reminders_tmp.reminders[key]  = reminder
  ts = php_timestamp
  reminders.reminders = reminders_tmp.reminders
remove_void = (id) ->
  # remove reminder from reminders
  voids_tmp = {}
  voids_tmp.voids = {}
  for key of voids.voids
    if key != id
      voidrec = voids.voids[key]
      voids_tmp.voids[key] = {}
      voids_tmp.voids[key]  = voidrec
  ts = php_timestamp
  voids.voids = voids_tmp.voids
######################################################################################################
#
# Object moving functions - end
#
######################################################################################################

#
#     Edit invoice CODE
#
##############################################################################################################
#
# Button Actions - START
#
##############################################################################################################
do_email = () ->
  str = @id
  substr = str.split("-")
  id = substr[3]
  url =  settings.urls.soap_reminders_soap_email_url
  data =
  {
    id: id,
  }
  start_spinner()
  $.post url, data, ((data) ->

    res = '<h3>Reminder History</h3>'
    res = res + log_listing(data.reminder.r_log)
    $('#reminder-log-list-'+id).html(res)

    stop_spinner()
  ), "json"
  $("#modal-overlay").hide()
##############################################################################################################
do_timecard = () ->
  str = @id
  substr = str.split("-")
  id = substr[3]
  url =  settings.urls.soap_invoices_timecard_received_url
  start_spinner()
  data =
  {
    id: id
    updown: 1,
  }
  $.post url, data, ((data, status) ->
    #
    stop_spinner()
    build_reminders(1)
  ), "json"
#
##############################################################################################################
# Run the Ajax void button
do_reminder_to_void = () ->
  str = @id
  substr = str.split("-")
  id = substr[3]
  url =  settings.urls.soap_invoices_set_reminder_void_url
  if $("#reminder-void-button-"+id).html() is 'Void This Reminder'
    #move_reminder_to_void(id)
    $("#reminder-void-button-"+id).html "Voided"
    #$("#reminder-index-row-"+id).hide()
  else
    return true
  start_spinner()
  $data = new Array()
  $data =
  {
    id: id,
    updown: 1,
  }
  $.post url, $data, ((data, status) ->
    #
    stop_spinner()
    $('div#reminder-timecard-button-'+id).hide()

    $('div#reminder-email-button-'+id).hide()
    build_reminders(1)
  ), "json"
do_timecard_to_void = () ->
  #alert 'in do void'
  str = @id
  #alert str
  substr = str.split("-")
  id = substr[3]
  url =  settings.urls.soap_invoices_set_timecard_void_url
  if $("#reminder-void-button-"+id).html() is 'Void This Reminder'
    #move_reminder_to_void(id)
    $("#reminder-void-button-"+id).html "Voided"
    $("#reminder-index-row-"+id).hide()
  else
    $("#reminder-void-button-"+id).html "Void This Reminder"
  start_spinner()
  $data = new Array()
  $data =
  {
    id: id,
    updown: 1,
  }
  $.post url, $data, ((data, status) ->
    #
    stop_spinner()
    build_timecards(1)
  ), "json"
do_open_to_void = () ->
  #alert 'in do void'
  str = @id
  #alert str
  substr = str.split("-")
  id = substr[3]
  url =  settings.urls.soap_invoices_set_open_void_url
  if $("#reminder-void-button-"+id).html() is 'Void This Reminder'
    #move_reminder_to_void(id)
    $("#reminder-void-button-"+id).html "Voided"
    $("#reminder-index-row-"+id).hide()
  else
    $("#reminder-void-button-"+id).html "Void This Reminder"
  start_spinner()
  $data = new Array()
  $data =
  {
    id: id,
    updown: 1,
  }
  $.post url, $data, ((data, status) ->
    #
    stop_spinner()
    build_opens(1)
  ), "json"
do_reminders_waiting_to_void = () ->
  alert 'in do void'
  str = @id
  alert str
  substr = str.split("-")
  id = substr[3]
  url =  settings.urls.soap_invoices_set_reminder_void_url
  if $("#reminder-void-button-"+id).html() is 'Void This Reminder'
    #move_reminder_to_void(id)
    $("#reminder-void-button-"+id).html "Voided"
    $("#reminder-index-row-"+id).hide()
  else
    $("#reminder-void-button-"+id).html "Void This Reminder"
  start_spinner()
  $data = new Array()
  $data =
  {
    id: id,
    updown: 1,
  }
  $.post url, $data, ((data, status) ->
    #
    stop_spinner()
    build_reminders(1)
  ), "json"
##############################################################################################################
#
# compliment a jqmodal dialog above
#
do_edit_notes_save = (e) ->
  e.preventDefault()
  start_spinner()
  url =  settings.urls.soap_invoices_edit_notes_url
  id =  $('input#InvoiceId').val()
  notes = $('input#InvoiceNotes').val()
  $data = new Array()
  $data =
  {
    id: id,
    notes: notes
  }
  $.post url, $data, ((data, status) ->
    #
    stop_spinner()
    $("div#reminders-footer-"+id).html(notes)
    $("div#edit-note-form").hide()
  ), "json"

do_edit_notes_cancel = (e) ->
  e.preventDefault()
  $("div#edit-note-form").hide()
  $("#modal-overlay").hide()

do_edit_invoice_save = (e) ->
  e.preventDefault()
  start_spinner()
  url =  settings.urls.soap_invoices_save_invoice_url

  $data =$('#edit-invoice-form-id').serialize();
  $.post url, $data, ((data, status) ->
    #
    stop_spinner()
    $('div#invoice-amount-'+data.inv.id).html('$'+data.inv.amt)
    $('div#edit-invoice-form').hide()
  ), "json"


do_edit_notes = (e) ->
  #alert e.pageY
  str = @id
  substr = str.split("-")
  type = substr[0]
  id = substr[3]
  $('div#edit-note-form').css('position':'absolute')
  $('div#edit-note-form').css('top':e.pageY+'px')
  $('div#edit-note-form').css('z-index':11)

  $("#modal-overlay").show()
  $('div#edit-note-form').show()
  if type == 'reminder'
    pkeys = primary_keys(id,type)
  invoice_number_formatted_filled(id, 'edit-notes-invoice-number')
  period_formatted_filled(pkeys.inv, 'edit-notes-period')
  employee_formatted_filled(employees.employees[pkeys.employee_id], 'edit-notes-employee-name')
  client_formatted_filled(clients.clients[pkeys.client_id], 'edit-notes-client-name')
  amount_formatted_filled(pkeys.inv, 'edit-notes-inv-amt')
  $('input#InvoiceId').attr('value', id)
  $('input#InvoiceNotes').attr('value', pkeys.inv.n)
##############################################################################################################
#
# do_edit_invoice - sets up the edit invoice form
#  does ajax call to get the latest version of the invoice -
#
##############################################################################################################
do_edit_invoice = (e) ->
  str = @id
  substr = str.split("-")
  type = substr[0]
  id = substr[3]

  start_spinner()
  # make an ajax call to check status of the invoice
  url = settings.urls.soap_invoices_edit_invoice_url

  $data = {
    'id': id,
  }
  $.post url, $data, ((data, status) ->
    #
    if data['error_code'] >  0
      # drop out if invoice is bad to continue with
      stop_spinner()
      return true
    else
      inv = data['inv']
      $('div#edit-invoice-form').css('position':'absolute')
      $('div#edit-invoice-form').css('top':e.pageY+'px')
      $('div#edit-invoice-form').css('z-index':11)

      pkeys = primary_keys(id,'timecard')
      invoice_number_formatted_filled(id, 'edit-notes-invoice-number')
      period_formatted_filled(pkeys.inv, 'edit-notes-period')
      employee_formatted_filled(employees.employees[pkeys.employee_id], 'edit-notes-employee-name')


      $('input#InvoicePo').val inv['Invoice']['po']
      $('input#InvoiceId').val inv['Invoice']['id']
      $('input#InvoiceTerms').val inv['Invoice']['terms']
      $('input#notes').val inv['Invoice']['notes']
      $('input#message').val inv['Invoice']['message']
      $('input#InvoiceEmployerexpenserate').val inv['Invoice']['employerexpenserate']


      date = inv['Invoice']['date']
      period_start = inv['Invoice']['period_start']
      period_end = inv['Invoice']['period_end']

      ds = date.split("-")

      $("select[name='date-date-day-of-month']  :nth-child("+ds[2]+")").prop('selected', true)
      $("select[name='date-date-month']  :nth-child("+ds[1]+")").prop('selected', true)
      indx = parseInt(ds[0],10)-1938+1
      $("select[name='date-date-year']  :nth-child("+indx+")").prop('selected', true)



      ds = period_start.split("-")


      $("select[name='period_start-date-day-of-month']  :nth-child("+ds[2]+")").prop('selected', true)
      $("select[name='period_start-date-month']  :nth-child("+ds[1]+")").prop('selected', true)
      indx = parseInt(ds[0],10)-1938+1
      $("select[name='period_start-date-year']  :nth-child("+indx+")").prop('selected', true)



      ds = period_end.split("-")


      $("select[name='period_end-date-day-of-month']  :nth-child("+ds[2]+")").prop('selected', true)
      $("select[name='period_end-date-month']  :nth-child("+ds[1]+")").prop('selected', true)
      indx = parseInt(ds[0],10)-1938+1
      $("select[name='period_end-date-year']  :nth-child("+indx+")").prop('selected', true)




      # get item list
      url = settings.urls.soap_invoice_item_list_url
      $data = new Array()
      $data =
      {
        id: id,
      }
      $.post url, $data, ((invoice_items, status) ->
        #
        #alert 'back again'
        invoice_items_filled(id, invoice_items)

        count = invoice_items_count(invoice_items)
        h = count*30+350
        w = 1200
        #
        inv = timecards.timecards[id]
        $('div#edit-invoice-invoice-number').html id
        $('div#edit-invoice-period').html period_formatted(inv)
        $('div#edit-invoice-employee-name').html employee_formatted(inv.e_id)
        $('div#edit-invoice-client-name').html client_formatted(inv.c_id)
        $('div#edit-invoice-invoice-amount').html amount_formatted(inv)
        #$('div#edit-invoice-form').css('height': h+'px')
        #$('div#edit-invoice-form').css('width': w+'px')

        $("#reminders-waiting-area").removeClass "waiting div400x100"


        $('div#edit-invoice-form').show()
        # $("#modal-overlay").show( does not work
        $("#modal-overlay").css('display','show')

        stop_spinner()
      ), "json"
  ), "json"

  return true

##############################################################################################################
#
# do_edit_invoice_cancel - the cancel button for the edit invoice form
#
##############################################################################################################
do_edit_invoice_cancel = (e) ->
  e.preventDefault()
  $("div#edit-invoice-form").hide()
  $("#modal-overlay").hide()
##############################################################################################################
do_post_invoice = (e) ->
  url =  settings.urls.soap_invoices_post_invoice_url

  str = @id
  substr = str.split("-")
  type = substr[0]
  id = substr[4]

  $data =
  {
    id: id,
  }
  $.post url, $data, ((data, status) ->
    #
    stop_spinner()
    build_timecards(1)
  ), "json"
##############################################################################################################
do_preview_invoice = () ->
  url =  settings.urls.invoice_pdf_preview_url

  str = @id
  substr = str.split("-")
  id = substr[4]

  openWindow url+id

##############################################################################################################
do_send_timecard_reciept = () ->
  str = @id
  substr = str.split("-")
  id = substr[2]

  url = settings.urls.soap_invoices_send_timecard_receipt_url

  start_spinner()
  $data = new Array()
  $data =
  {
    id: id,
  }
  $.post url, $data, ((data, status) ->
    #
    stop_spinner()
    build_timecard_receipts_pendings(1)
  ), "json"
##############################################################################################################
do_void_push_to_reminders = () ->
  str = @id
  substr = str.split("-")
  id = substr[4]
  url =  settings.urls.soap_void_push_to_reminders
  start_spinner()
  $data = new Array()
  #move_void_to_reminder(id)
  $data =
  {
    id: id,
    updown: 0,
  }
  $.post url, $data, ((data, status) ->
    #
    stop_spinner()
    build_voids(1)
  ), "json"
##############################################################################################################
#
# Button Actions - END
#
##############################################################################################################
# explicitly register all buttons after created
register_button_callbacks = (e) ->
  # for future elements - dom elements created after initial doc load
  $('div.reminder-email-button').on('click',  do_email)
  $('div.reminder-timecard-button').on('click',  do_timecard)
  $('div.reminder-void-button').on('click',  do_reminder_to_void)

  $('div.timecard-void-button').on('click',  do_timecard_to_void)
  $('div.open-void-button').on('click',  do_open_to_void)
  $('div.reminders_waiting-void-button').on('click',  do_reminders_waiting_to_void)

  $('div.edit-notes-button').on('click', do_edit_notes)
  $('div.timecard-edit-invoice-button').on('click',  do_edit_invoice)
  $('div.timecard-post-invoice-button').on('click',  do_post_invoice)
  $('div.timecard-preview-invoice-button').on('click',  do_preview_invoice)
  $('div.void-push-to-reminders-button').on('click',  do_void_push_to_reminders)
  $('div.timecard-reciept-pending-button').on('click',  do_send_timecard_reciept)

  rollover_on_buttons(1)
##############################################################################################################
#
# Action Buttons - START
#
#
#  reminder_void_button(id)+
#  timecard_void_button(id)+
#  reminders_waiting_void_button(id)+
#  opens_void_button(id)+
#  edit_notes_button(id)+
##############################################################################################################
edit_invoice_button = (id) ->
  return '<li><div class="timecard-edit-invoice-button button" id="timecard-edit-invoice-'+id+'">Edit Invoice</div></li>'
preview_invoice_button = (id) ->
  return '<li><div class="timecard-preview-invoice-button button" id="timecard-preview-invoice-button-'+id+'">Preview Invoice</div></li>'
post_invoice_button = (id) ->
  return '<li><div class="timecard-post-invoice-button button" id="timecard-post-invoice-button-'+id+'">Post Invoice</div></li>'
edit_notes_button = (id) ->
  return '<li><div class="edit-notes-button button" id="reminder-edit-notes-'+id+'">Edit Notes</div></li>'

reminder_void_button = (id) ->
  return '<li><div class="reminder-void-button button void-button" id="reminder-void-button-'+id+'">Void This Reminder</div></li>'
timecard_void_button = (id) ->
  return '<li><div class="timecard-void-button button void-button" id="timecard-void-button-'+id+'">Void This Timecard</div></li>'
reminders_waiting_void_button = (id) ->
  return '<li><div class="reminders_waiting-void-button button void-button" id="reminders_waiting-void-button-'+id+'">Void This Waiting Reminder</div></li>'


opens_void_button = (id) ->
  return '<li><div class="open-void-button void-button button" id="opens-void-button-'+id+'">Void This Open Invoice</div></li>'


reciept_send_button = (id) ->
  return '<li><div class="timecard-reciept-pending-button button" id="reciept-send-'+id+'">Send Reciept</div></li>'

timecard_button = (id) ->
  return '<li><div class="reminder-timecard-button button" id="reminder-timecard-button-'+id+'">Waiting For Timecard</div></li>'
push_to_reminders_button = (id) ->
  return '<li><div class="void-push-to-reminders-button button" id="void-push-to-reminders-'+id+'">Push to Reminders</div></li>'
email_button = (id) ->
  return '<li><div class="reminder-email-button button" id="reminder-email-button-'+id+'">Email Reminder</div></li>'
##############################################################################################################
#
# Action Buttons - END
#
##############################################################################################################
##############################################################################################################
#
# Action button sets withing tabs - START
#
##############################################################################################################
reminders_buttons = (id) ->
  res = '<ul class="actions">'+
  edit_notes_button(id)+
  email_button(id)+
  timecard_button(id)+
  reminder_void_button(id)+
  '</ul>'
  return res
timecards_buttons = (id) ->
  res = '<ul class="actions">'+
  edit_invoice_button(id)+
  post_invoice_button(id)+
  push_to_reminders_button(id)+
  timecard_void_button(id)+
  preview_invoice_button(id)+
  '</ul>'
  return res
reminders_waiting_buttons = (id) ->
  res = '<ul class="actions">'+
  email_button(id)+
  timecard_button(id)+
  reminders_waiting_void_button(id)+
  edit_notes_button(id)+
  '</ul>'
  return res
opens_buttons = (id) ->
  res = '<ul class="actions">'+
  #resend_to_staff_open_button(id)+
  #view_pdf_open_button(id)+
  opens_void_button(id)+
  '</ul>'
  return res
receipts_pending_buttons = (id) ->
  res = '<ul class="actions">'+
  reciept_send_button(id)+
  #post_invoice_button(id)+
  #push_to_reminders_button(id)+
  '</ul>'
  return res
voids_buttons = (id) ->
  res = '<ul class="actions">'+
  push_to_reminders_button(id)+
  '</ul>'
  return res
##############################################################################################################
#
# Action button sets within tabs - END
#
#
##############################################################################################################
# start the rollover effects
rollover_on_buttons = (dum) ->
  # roll over effects for buttons
  # Start
  $("div.reminder-email-button").mouseover ->
    $(this).removeClass('reminder-email-button')
    $(this).addClass('rolledover')
  $("div.reminder-email-button").mouseout ->
    $(this).removeClass('rolledover')
    $(this).addClass('reminder-email-button')
  $("div.reminder-timecard-button").mouseover ->
    $(this).removeClass('reminder-timecard-button')
    $(this).addClass('rolledover')
  $("div.reminder-timecard-button").mouseout ->
    $(this).removeClass('rolledover')
    $(this).addClass('reminder-timecard-button')



  $("div.void-button").mouseover ->
    $(this).removeClass('void-button')
    $(this).addClass('rolledover')
  $("div.void-button").mouseout ->
    $(this).removeClass('rolledover')
    $(this).addClass('void-button')

  $("div.void-push-to-reminders-button").mouseover ->
    $(this).removeClass('void-push-to-reminders-button')
    $(this).addClass('rolledover')
  $("div.void-push-to-reminders-button").mouseout ->
    $(this).removeClass('rolledover')
    $(this).addClass('void-push-to-reminders-button')
  $("div.edit-notes-button").mouseover ->
    $(this).removeClass('edit-notes-button')
    $(this).addClass('rolledover')
  $("div.edit-notes-button").mouseout ->
    $(this).removeClass('rolledover')
    $(this).addClass('edit-notes-button')
  $("div.timecard-preview-invoice-button").mouseover ->
    $(this).removeClass('timecard-preview-invoice-button')
    $(this).addClass('rolledover')
  $("div.timecard-preview-invoice-button").mouseout ->
    $(this).removeClass('rolledover')
    $(this).addClass('timecard-preview-invoice-button')
  $("div.timecard-edit-invoice-button").mouseover ->
    $(this).removeClass('timecard-edit-invoice-button')
    $(this).addClass('rolledover')
  $("div.timecard-edit-invoice-button").mouseout ->
    $(this).removeClass('rolledover')
    $(this).addClass('timecard-edit-invoice-button')
  $("div.timecard-post-invoice-button").mouseover ->
    $(this).removeClass('timecard-post-invoice-button')
    $(this).addClass('rolledover')
  $("div.timecard-post-invoice-button").mouseout ->
    $(this).removeClass('rolledover')
    $(this).addClass('timecard-post-invoice-button')

  $("div.timecard-reciept-pending-button").mouseover ->
    $(this).removeClass('timecard-reciept-pending-button')
    $(this).addClass('rolledover')
  $("div.timecard-reciept-pending-button").mouseout ->
    $(this).removeClass('rolledover')
    $(this).addClass('timecard-reciept-pending-button')
# roll over effects for buttons
# End
isEven= (value) ->
  if value%2 == 0
    return true
  else
    return false
row_header = (reminder, type) ->
  #pkeys = primary_keys(k,type)
  res = ''
  res = res + '<div class="tab-index-header ">'+' '
  res = res + invoice_number(reminder, type)+' '+period_formatted(reminder)+' '
  res = res + employee_formatted(reminder.e_id)+' '+client_formatted(reminder.c_id)+' '+amount_formatted(reminder)+'</div>'
  return res
##########################################################################
#
# BUILD OUT TABS - START
# coffee script needs the dummy param for the parens in function call
#
#
##########################################################################
build_reminders = (dum) ->
  # fill up reminders table
  $('div#reminders-index').empty()

  url = settings.urls.soap_reminderlist_url
  $data = new Array()
  $data =
  {
  }
  start_spinner()
  $.post url, $data, ((reminders, status) ->
    remindersGlobal = reminders
    #
    j = 1
    for reminder of reminders.reminders
      k = reminders.reminders[reminder].id
      res = ''
      if isEven(j++)
        res = res + '<div id="reminder-index-row-'+k+'" class="index-row altrow">'+' '
      else
        res = res + '<div id="reminder-index-row-'+k+'" class="index-row ">'+' '

      res = res + row_header(reminders.reminders[reminder], 'reminder')

      res = res + '<div class="index-row-left-cell ">'
      res = res + '<div id="reminder-log-list-'+k+'">'
      res = res + employee_log_formatted(k, reminders.reminders[reminder],'reminder')
      res = res + '</div>'
      res = res + employee_email_distribution_formatted(k, reminders.reminders[reminder], 'reminder')
      res = res + '</div>'
      res = res + '<div class="index-row-right-cell">'
      res = res + reminders_buttons(k)+'</div>'
      # Notes
      res = res + '<div id="reminders-footer-'+k+'"  class="tab-index-footer">'+ reminders.reminders[k].n+'</div>'
      #
      res = res + '</div>'
      $('div#reminders-index').append(res)
    register_button_callbacks(1)
    stop_spinner()
  ), "json"
build_timecards = (dum) ->
  # fill up reminders table
  $('div#timecards-index').empty()
  url = settings.urls.soap_timecardlist_url
  $data = new Array()
  $data =
  {
  }
  start_spinner()
  $.post url, $data, ((reminders, status) ->
    #
    timecards = reminders
    j = 1
    for reminder of timecards.timecards
      k = reminders.timecards[reminder].id
      res = ''
      if isEven(j++)
        res = res + '<div id="timecard-index-row-'+k+'" class="index-row altrow">'+' '
      else
        res = res + '<div id="timecard-index-row-'+k+'" class="index-row ">'+' '

      res = res + row_header(timecards.timecards[reminder], 'timecard')
      res = res + '<div class="index-row-left-cell ">'+' '
      res = res + invoice_email_distribution_formatted(k, timecards.timecards[reminder], 'reminder')
      res = res + '</div>'
      res = res + '<div class="index-row-right-cell">'+' '
      res = res + timecards_buttons(k)+'</div>'
      # Notes
      res = res + '<div id="timecards-footer-'+k+'"  class="tab-index-footer">'+ timecards.timecards[reminder].n+'</div>'
      #
      res = res + '</div>'
      $('div#timecards-index').append(res)
    register_button_callbacks(1)
    stop_spinner()

  ), "json"
build_reminders_waiting = (dum) ->
  # fill up reminders table
  $('div#timecards-index').empty()
  url = settings.urls.soap_invoices_reminders_waiting_url
  $data = new Array()
  $data =
  {
  }
  start_spinner()
  $.post url, $data, ((reminders, status) ->
    #

    $('div#reminders-waiting-index').empty()
    j = 1
    for k of reminders.reminders_inwait
      res = ''
      if isEven(j++)
        res = res + '<div id="reminder-index-row-'+k+'" class="index-row altrow">'+' '
      else
        res = res + '<div id="reminder-index-row-'+k+'" class="index-row ">'+' '

      res = res + row_header(reminders.reminders_inwait[k], 'reminder-waiting')

      # Notes
      res = res + '<div id="reminders-footer-'+k+'"  class="tab-index-footer">'+ reminders.reminders_inwait[k].n+'</div>'
      #
      res = res + '</div>'
      $('div#reminders-waiting-index').append(res)

    stop_spinner()
    register_button_callbacks(1)

  ), "json"
build_opens = (dum) ->
  # fill up reminders table
  $('div#timecards-index').empty()
  url = settings.urls.soap_invoices_open_invoices_url
  $data = new Array()
  $data =
  {
  }
  start_spinner()
  $.post url, $data, ((reminders, status) ->
    #
    opens = reminders

    $('div#opens-index').empty()
    j = 1
    for k of opens.opens
      res = ''
      if isEven(j++)
        res = res + '<div id="open-index-row-'+k+'" class="index-row altrow">'+' '
      else
        res = res + '<div id="open-index-row-'+k+'" class="index-row ">'+' '
      res = res + row_header(opens.opens[k],'open')

      res = res + '<div class="index-row-left-cell ">'+' '
      res = res + employee_log_formatted(k,'open')
      res = res + post_log_formatted(k,'open')
      res = res + '</div>'
      res = res + '<div class="index-row-right-cell">'+' '
      res = res + opens_buttons(k)+'</div>'
      # Notes
      res = res + '<div id="opens-footer-'+k+'"  class="tab-index-footer">'+ opens.opens[k].n+'</div>'
      #
      res = res + '</div>'
      $('div#opens-index').append(res)

    stop_spinner()
    register_button_callbacks(1)

  ), "json"


build_timecard_receipts_pendings = (dum) ->
  # fill up reminders table
  $('div#timecards-index').empty()
  url = settings.urls.soap_timecards_receipts_pending_url

  start_spinner()
  $.post url,  ((reminders, status) ->
    #
    timecard_receipts_pending = reminders

    $('div#receipts-pending-index').empty()
    j = 1
    for k of timecard_receipts_pending.timecard_receipts

      res = ''
      if isEven(j++)
        res = res + '<div id="receipt-pending-index-row-'+timecard_receipts_pending.timecard_receipts[k].id+'" class="index-row altrow">'+' '
      else
        res = res + '<div id="receipt-pending-index-row-'+timecard_receipts_pending.timecard_receipts[k].id+'" class="index-row ">'+' '
      res = res + row_header(timecard_receipts_pending.timecard_receipts[k], 'receipt-pending')

      res = res + '<div class="index-row-left-cell ">'+' '
      res = res + receipt_log_formatted(k,'receipt-pending')
      res = res + '</div>'
      res = res + '<div class="index-row-right-cell">'+' '
      res = res + receipts_pending_buttons(timecard_receipts_pending.timecard_receipts[k].id)+'</div>'
      # Notes
      res = res + '<div id="receipt-pending-footer-'+k+'"  class="tab-index-footer">'+ timecard_receipts_pending.timecard_receipts[k].n+'</div>'
      #
      res = res + '</div>'
      $('div#receipts-pending-index').append(res)

    stop_spinner()
    register_button_callbacks(1)

  ), "json"
build_timecard_receipts_sents = (dum) ->
  # fill up reminders table
  $('div#timecards-index').empty()
  url = settings.urls.soap_timecards_receipts_send_url
  $data = new Array()
  $data =
  {
  }
  start_spinner()
  $.post url, $data, ((reminders, status) ->
    #
    timecard_receipts_sent = reminders


    $('div#receipts-sent-index').empty()
    j = 1
    for k of timecard_receipts_sent.timecard_receipts
      res = ''
      if isEven(j++)
        res = res + '<div id="receipt-sent-index-row-'+k+'" class="index-row altrow">'+' '
      else
        res = res + '<div id="receipt-sent-index-row-'+k+'" class="index-row ">'+' '
      res = res + row_header(timecard_receipts_sent.timecard_receipts[k],'receipt-sent')

      res = res + '<div class="index-row-left-cell ">'+' '

      res = res + receipt_log_formatted(k,'receipt-sent')
      res = res + '</div>'

      res = res + '<div class="index-row-right-cell">'
      res = res + '</div>'
      # Notes
      res = res + '<div id="receipt-sent-footer-'+k+'"  class="tab-index-footer">'+ timecard_receipts_sent.timecard_receipts[k].n+'</div>'
      #
      res = res + '</div>'
      $('div#receipts-sent-index').append(res)

    stop_spinner()
    register_button_callbacks(1)

  ), "json"
# coffee script needs the dummy param for the parens in function call
build_voids = (dum) ->
  # fill up reminders table
  $('div#timecards-index').empty()
  url = settings.urls.soap_invoices_voided_invoices_url
  $data = new Array()
  $data =
  {
  }
  start_spinner()
  $.post url, $data, ((reminders, status) ->
    #
    voids = reminders
    $('div#voids-index').empty()
    j = 1
    for k of voids.voids
      res = ''
      if isEven(j++)
        res = res + '<div id="void-index-row-'+k+'" class=" index-row altrow">'+' '
      else
        res = res + '<div id="void-index-row-'+k+'" class=" index-row ">'+' '
      res = res + row_header(voids.voids[k],'void')
      res = res + '<div class="index-row-left-cell ">'+' '
      res = res + employee_log_formatted(k,'void')
      res = res + post_log_formatted(k,'void')
      res = res + '</div>'
      res = res + '<div class="index-row-right-cell">'+' '
      res = res + voids_buttons(k)+'</div>'
      # Notes
      res = res + '<div id="voids-footer-'+k+'"  class="tab-index-footer">'+ voids.voids[k].n+'</div>'
      #
      res = res + '</div>'
      $('div#voids-index').append(res)
    stop_spinner()
    register_button_callbacks(1)

  ), "json"
##########################################################################
#
# BUILD OUT TABS - END
#
##########################################################################
$(document).ready ->

  # 1 is a dummy to get coffee script to place parenthesis in generated js
  rollover_on_buttons(1)
  # hide popup forms on startup
  $('#reminders-edit-notes-form').hide()
  # hide spinner that had to be displayed for download
  $("#reminders-waiting-area").removeClass "waiting div400x100"
  # hide the modal overlay
  $("#modal-overlay").hide()
  # paint the tabs
  $( ".reminder-tabs" ).tabs()
  # Put in call backs known at document load time

  $("#edit-notes-save-button").click (e) ->
    do_edit_notes_save(e)
  $("#edit-invoice-save-button").click (e) ->
    do_edit_invoice_save(e)

  $("#edit-notes-cancel-button").click (e) ->
    do_edit_notes_cancel(e)
  $("#edit-invoice-cancel-button").click (e) ->
    do_edit_invoice_cancel(e)
  # Tab initialization
  $(".reminder-tabs ul li a").click (e) ->
    if e.target.id == 'ui-id-1'
      build_reminders(1)
    if e.target.id == 'ui-id-2'
      build_timecards(1)
    if e.target.id == 'ui-id-3'
      build_reminders_waiting(1)
    if e.target.id == 'ui-id-4'
      build_opens(1)
    if e.target.id == 'ui-id-5'
      build_timecard_receipts_pendings(1)
    if e.target.id == 'ui-id-6'
      build_timecard_receipts_sents(1)
    if e.target.id == 'ui-id-7'
      build_voids(1)
    rollover_on_buttons(1)
  build_reminders(1)

  #$("div.reminder-date").each ->
  #  currentElement = $(this)
  #  value = currentElement.html() # if it is an input/select/textarea field
  #  date = $.datepicker.parseDate("mm/dd/yy", value)
  #  today = new Date()
  #  targetDate = new Date()
  #  targetDate.setDate today.getDate() - 7
  #  targetDate.setHours 0
  #  targetDate.setMinutes 0
  #  targetDate.setSeconds 0
  #  if date <= targetDate
  #    currentElement.addClass "reminder-date-past"
