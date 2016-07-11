# AJAX Routines for the reminders app
#
# Routines to return bulky html back to the page
#
client_formatted = (inv)  ->
  return '<p class="invoices-client">'+clients.clients[invoices.invoices[inv].c_id].n+'</p>'
employee_formatted = (inv)  ->
  return '<p class="invoices-employee">'+employees.employees[invoices.invoices[inv].e_id].f+' '+employees.employees[invoices.invoices[inv].e_id].l+'</p>'


client_name = (id) ->
  return '<div class="invoice-client" id="invoice-client-'+id+'-"></div>'
employee_name = (id) ->
  return '<div class="invoice-employee" id="invoice-employee-'+id+'-"></div>'

$(document).ready ->
  #<li class='invoices-actions'><?php echo $this->element('reminders/buttons/edit_notes',array('id'=>$invoice['Invoice']['id']));?></li>
  #

  $("[id^=invoice-employee-]").each ->
    str = @id
    substr = str.split("-")
    $("#"+@id).html employee_formatted(substr[2])

  $("[id^=invoice-client-]").each ->
    str = @id
    substr = str.split("-")
    $("#"+@id).html client_formatted(substr[2])