/*
 this file is not a good candidate for coffee script because of the big JSON pass
 */
var invoices = eval ("(" + invoicesJSON + ")");
$('#invoice-list').find('input[type=checkbox]:checked').removeAttr('checked');
for (var i=0;i<invoices.length;i++)
{
    invoices[i].selected = false;
    invoices[i].ordering = 0;
    }
function reset_invoices() {
    for( var inv in invoices)
    {
    invoices[inv].ordering = 0;
    invoices[inv].selected = false;
    }
}
function update_rows()
{
    $("tr[id^=shadowrow-]:visible:even").addClass("altrow");
    $("tr[id^=shadowrow-]:visible:odd").removeClass("altrow");
}
function order_invoices(data) {
    // The JQuery plugin tableDnD provides a serialize() function which provides the re-ordered
    // data in a list. We pass that list as an object called "data" to a Django view
    // to save the re-ordered data into the database.
    //alert(data);
    // fake call
    //$.post("<?php echo $this->webroot;?>clients/reorder_payments", data, "json");


    return false;
    };
$(document).ready(function() {

    // Initialise the task table for drag/drop re-ordering
    $("#invoicetable").tableDnD();
    $('#invoicetable').tableDnD({
    onDrop: function(table, row) {
        update_rows();
        order_invoices($.tableDnD.serialize());
    }
});

$('input.ckamt').removeAttr('checked');
    $('input.ckamt-shadow').removeAttr('checked');
    $("input.ckamt").click(function () {
        // your code here
        //alert('checked')
        ckstotal = 0;
        items = [];
        items = $("input:checkbox:checked.ckamt").map(function () {
            return {'value':this.value,'id':this.id};
        }).get();
        //alert(items);
        //reset_invoices();
        j=0;
        $('tr.shadowrow').addClass("hidden");
        $('input.ckamt-shadow').removeAttr('checked');
        ck_count = 0;
        for (var item in items) {
            ck_count++;
            //alert(items[item].id);
            //alert('cycled item'+items[item]);
            inv_id = items[item].id.replace("InvoiceInvoice", "");
            for( var inv in invoices)
            {
                //alert(inv_id);
                //alert(invoices[inv].id);
              if(inv_id == invoices[inv].id)
              {
                  invoices[inv].ordering = j++;
                  invoices[inv].selected = true;
              }
            }
            ckstotal=ckstotal+parseFloat(items[item].value);
            shadowrow = 'tr#shadowrow'+'-'+inv_id;
            shadowinput = 'input#shadowinput'+'-'+inv_id;
            //alert(inv_id);
            //alert($('input#InvoiceInvoice'+inv_id).is(":checked"));
            if($('input#InvoiceInvoice'+inv_id).is(":checked"))
            {
                $(shadowinput).prop('checked', true);
                $(shadowrow).removeClass('hidden');
            } else {
                $(shadowinput).prop('checked', false);
                $(shadowrow).addClass('hidden');
            }
        }
        update_rows();
        $('#ckselcount').html(ck_count);
        $('#ckseltotal').html((ckstotal).toFixed(2));
    });
});
