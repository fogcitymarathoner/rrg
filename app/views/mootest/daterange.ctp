<h1>Range</h1>

<p>
Inputs:<br>
<input type="text" value="02/08/1991 - 02/20/1991"><br />
<input type="text" value="02/08/1991"><br />
<input type="text" />
</p>

<p>
Hidden input:<br />
<input type="hidden" id="range_hidden" /><span id="range_text"></span><a href="#" id="range_select">Select Range</a>
</p>

<script>

var picker = new Picker.Date.Range($$('input[type="text"]'), {
    timePicker: false,
    columns: 3,
    positionOffset: {x: 5, y: 0}
});

var picker2 = new Picker.Date.Range('range_hidden', {
    toggle: $$('#range_select'),
    columns: 3,
    onSelect: function(){
        $('range_text').set('text', Array.map(arguments, function(date){
            return date.format('%e %B %Y');
        }).join(' - '))
    }
});

</script>