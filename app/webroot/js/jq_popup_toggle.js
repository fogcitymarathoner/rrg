var tmpExample = {
  ready : function() {
    $('input#tmpDialogueOpen').click(
      function($e) {
  		//alert('hi');
        $e.preventDefault();
        $('div#tmpDialogue').addClass('tmpDialogueOn').show();
      }
    );

$('input#tmpDialogueClose').click(
      function($e) {
    		//alert('hi');
        $e.preventDefault();
        $('div#tmpDialogue').removeClass('tmpDialogueOn').hide();
      }
    );
  }
};

$(document).ready(tmpExample.ready);
