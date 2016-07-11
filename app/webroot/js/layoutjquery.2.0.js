/**
 * Title: LayoutQuery jQuery Plugin
 * Written By: Abhishek Saha
 * Version: 2.0
 * Released On: 24-10-2011
 **/


/*
 * Declaring all variables. These are global.
 */
var headerid,headerclass,headerpath,headerheight,headerdisplay,headerstatus = false,header_load_once = true;
var content_col_id,content_col_class,content_col_width,content_col_path,content_col_status = false;
var left_col_display,left_col_id,left_col_class,left_col_width,left_col_path,left_col_status = false;
var right_col_display,right_col_id,right_col_class,right_col_width,right_col_path,right_col_status = false;
var footerid,footerclass,footerpath,footerheight,footerdisplay,footerstatus = false,footer_load_once = true;
var menuid,menupath,menuclass,menuheight,menu_status = false,menu_load_once=true;
var cols,loading,colsPadding,unit,smartCSS;
var leftmenu = false,rightmenu = false;
var selector;
var layoutWidth,totalpadding;
var error = {};
var siteLoaded = false,padOthers = false;

/**
 * START-OF-PLUGIN **************************************************************************************************************************
 */
$.fn.layout = function(options) {

    /**
     * Remove Preloader if it exist
     **/
    $('.preload').remove();

    selector = $(this);
    var defaults = {

        cols: 3,
        layoutWidth: null,
        content_col: {'width':46,'id':'content_col','_class':'content_col','path':''},
        left_col: {'display':false,'width':21,'id':'left_col','_class':'left_col','path':''},
        right_col: {'display':false,'width':21,'id':'right_col','_class':'right_col','path':''},
        colsPadding: 2,
        header: {'display':false,'id':'header','_class':'','height':'auto','path':'','load_once':true},
        footer: {'display':false,'id':'footer','_class':'','height':'auto','path':'','load_once':true},
        loadAtOnce: true,
        menu: {'display':false,'id':'menu','_class':'','height':'auto','path':'','load_once':true},
        smartCSS: true,
        unit: '%',
        preloadImage: "",
        padOthers: false
    };


    var options = $.extend({},defaults, options);

    /**
     * If loadAtOnce is true, make div for the preloader
     */
    if(options.loadAtOnce)
    {
        $("body").append("<span class = 'preload'>"+
            "<img src = '' alt = 'Loading'>"+
            "</span>");
    }

    /**
     * Set the global values with parameters recieved
     */
    addValues(options,$(this));

    /**
     * Checking the Parameters passed and capturing Error Messages
     **/
    if(cols == 2 && left_col_display && right_col_display)
    {
        error['INVALID_COL_ASSIGNMENT'] = "<br>2 column layout cannot contain left and right column together.<p>";
    }

    if(cols == 3 && !left_col_display)
    {
        error['LEFT_COL_DISPLAY'] = "<br>Left Column Display should be true.<p>";
    }

    if(cols == 3 && !right_col_display)
    {
        error['RIGHT_COL_DISPLAY'] = "<br>Right Column Display should be true.<p>";
    }

    /**
     * Create the div of header if it doest not exist.
     */
    if (options.header.display && $("#"+headerid).length == 0)
    {
        $("<div class='hcss'></div>").appendTo($(this)).attr({

            'id':headerid,
            'class':headerclass

        });
    }
    /**
     * Create the div of menu if it doest not exist.
     */
    if(options.menu.display && $("#"+menuid).length == 0)
    {
        $("<div></div>").appendTo($(this)).attr({

            'id':menuid,
            'class':menuclass

        }).css('clear','both');

    }

    /**
     * Remove all columns if they exist.
     */
    $('.colmask').remove();

    /**
     * HTML Markup of columns.
     */
    var divs = "<div class = 'colmask n_cols'>" +
        "<div class='colcontent'>" +
        "<div class='colleft'>" +
        "<div id="+ content_col_id +" class="+ content_col_class +"></div>" +
        "<div id="+ left_col_id +" class="+ left_col_class +"></div>" +
        "<div id="+ right_col_id +" class="+ right_col_class +"></div>" +
        "</div>" +
        "</div>" +
        "</div>";

    /**
     * Create the div of footer if it doest not exist.
     */
    if(options.footer.display && $("#"+footerid).length == 0)
    {
        $("<div class='hcss'></div>").appendTo($(this)).attr({

            'id':footerid,
            'class':footerclass

        });
    }

    /**
     * Append the column markup before the footer.
     */
    $("#"+footerid).before(divs);

    /**
     * Apply Smart CSS if smartCSS is true and also apply the common CSS needed for any layout.
     */
    if(smartCSS)applySmartCSS();
    applyCommonCSS();

    /**
     * Based on X-Column Layout, apply the required X-Column CSS
     */

    if(options.cols == 3)applyCSS_3();
    if(options.cols == 2 && left_col_display == true)applyCSS_2_leftmenu();
    if(options.cols == 2 && right_col_display == true)applyCSS_2_rightmenu();
    if(options.cols == 1)applyCSS_1();

    /**
     * Count the total errors so far
     */
    var totalErrors = checkErrors(error);

    /**
     * Load all the pages first if no errors and if loadAtOnce is true. Hide the selector.
     * -------ELSE-----
     * Load pages one by one if no errors and if loadAtOnce is false and show the selector.
     * -------ELSE-----
     * Display All the errors
     */
    if(options.loadAtOnce && totalErrors == 0)
    {
        $(this).hide();

        // Starts loading all the pages
        loadAll(options);
        loading = setInterval('checkloadcomplete()',1000);
    }
    else if(!options.loadAtOnce && totalErrors == 0)
    {
        $(this).show();

        // Starts loading all the pages
        loadAll(options);
    }
    else
    {
        $('.preload').hide();
        selector.html("<h4>Please rectify the below awesome errors:</h4>").css('background','none repeat scroll 0 0 #567E40').show();
        $.each(error, function(key,value) {

            selector.append("<b>"+key + " :</b> "+ value);

        });

    }

    /**
     * Set the width of the layout.
     */
    return this.each(function() {
        $(this).css({
            'width': layoutWidth + unit,
            'margin': 'auto'
        });

    });

};

/**
 * END-OF-PLUGIN **************************************************************************************************************************
 */


/**
 * WE START OUR FUNCTIONS HERE. THESE FUNCTIONS ARE USED IN THE ABOVE PLUGIN
 */
function checkErrors(error)
{
    var count = 0;
    for (var prop in error) {
        if (error.hasOwnProperty(prop)) {
            count++;
        }
    }
    return count;
}
function addValues(options,selector)
{
    cols = options.cols;
    $('.preload img').attr('src',options.preloadImage);
    $('.preload').css({
        'position':'absolute',
        'margin-left': -parseInt($('.preload img').width()/2),
        'margin-top': -parseInt($('.preload img').height()/2),
        'left':'50%',
        'top':'50%'

    });
    paddOthers = options.paddOthers;

    headerid = options.header.id;
    headerclass = options.header._class;
    headerpath = options.header.path;
    headerheight = options.header.height;
    headerdisplay = options.header.display;
    header_load_once = options.header.load_once;

    menuid = options.menu.id;
    menuclass = options.menu._class;
    menupath = options.menu.path;
    menuheight = options.menu.height;
    menudisplay = options.menu.display;
    menu_load_once = options.menu.load_once;

    footerid = options.footer.id;
    footerclass = options.footer._class;
    footerpath = options.footer.path;
    footerheight = options.footer.height;
    footerdisplay = options.footer.display;
    footer_load_once = options.footer.load_once;

    content_col_id = options.content_col.id;
    content_col_class = options.content_col._class;
    content_col_width = options.content_col.width;
    content_col_path = options.content_col.path;

    left_col_id = options.left_col.id;
    left_col_class = options.left_col._class;
    left_col_width = options.left_col.width;
    left_col_path = options.left_col.path;
    left_col_display = options.left_col.display;

    right_col_id = options.right_col.id;
    right_col_class = options.right_col._class;
    right_col_width = options.right_col.width;
    right_col_path = options.right_col.path;
    right_col_display = options.right_col.display;

    colsPadding = options.colsPadding;
    unit = options.unit;
    smartCSS = options.smartCSS;


    if(unit == "px" || unit == "em")
    {
        if(cols == 3)totalpadding = colsPadding * 6;
        if(cols == 2)totalpadding = colsPadding * 4;
        if(cols == 1)totalpadding = colsPadding * 2;
        var t = content_col_width + left_col_width + right_col_width + totalpadding;
        layoutWidth = (options.layoutWidth == null)?t:options.layoutWidth;
    }
    if(unit == "%")
    {
        layoutWidth = (options.layoutWidth == "")?100:options.layoutWidth;


        if(cols == 3)
        {
            var totalwidth = content_col_width + left_col_width + right_col_width + (6*colsPadding);
            if(totalwidth != 100)
                error['COL_CALC_ERROR'] = "<br>Left column width + Content column width + Right Column width + (6 x padding) is not equal to 100.<p>";
        }
        if(cols == 2 && left_col_display)
        {
            var totalwidth = content_col_width + left_col_width  + (4*colsPadding);
            if(totalwidth != 100)
                error['COL_CALC_ERROR'] = "<br>Left column width + Content column width + (4 x padding) is not equal to 100.<p>";
        }
        if(cols == 2 && right_col_display)
        {
            var totalwidth = content_col_width + right_col_width  + (4*colsPadding);
            if(totalwidth != 100)
                error['COL_CALC_ERROR'] = "<br>Right column width + Content column width + (4 x padding) is not equal to 100.<p>";
        }
    }
}

function checkloadcomplete()
{
    if( headerstatus == true && content_col_status == true &&
        left_col_status == true && 	right_col_status == true && footerstatus == true )
    {
        clearInterval(loading);
        selector.fadeIn('slow');
        $('.preload').hide();
        siteLoaded = true;

    }
}



function loadAll()
{
    if((headerpath != "" && header_load_once && !headerstatus) || (headerpath != "" && !header_load_once) )
        $("#"+headerid).load(headerpath,function(){headerstatus = true});


    if((menupath != "" && menu_load_once && !menu_status) || (menupath != "" && !menu_load_once) )
        $("#"+menuid).load(menupath,function(){menu_status = true});


    if(content_col_path != "")
        $("#"+content_col_id).load(content_col_path,function(){content_col_status = true});

    if(left_col_display && left_col_path != "")
        $("#"+left_col_id).load(left_col_path,function(){left_col_status = true});
    else
        left_col_status = true;

    if(right_col_display && right_col_path != "")
        $("#"+right_col_id).load(right_col_path,function(){right_col_status = true});
    else
        right_col_status = true;

    if((footerpath != "" && footer_load_once && !headerstatus) || (footerpath != "" && !footer_load_once))
        $("#"+footerid).load(footerpath,function(){footerstatus = true});
}

function applySmartCSS()
{
    $('#'+right_col_id+', #'+content_col_id+', #'+left_col_id).css({
        'padding-top':'10px',
        'padding-bottom':'10px'
    });

    if(paddOthers)
    {
        $('#'+headerid+',#'+footerid+', #'+menuid).css({
            'padding':colsPadding + unit
        });
    }
}

function applyCommonCSS()
{

    $('body').css({
        'margin':0,
        'padding':0,
        'border':0	,
        'width':'100%',
        'min-width':'400px',
        'font-size':'90%'
    });

    $('.colmask').css({
        'position':'relative',
        'clear':'both',
        'float':'left',
        'width':'100%',
        'overflow':'hidden'
    });

    $('.colcontent,.colleft').css({
        'float':'left',
        'width':"100%",
        'position':'relative'
    });

    $("#"+content_col_id+",#"+left_col_id+",#"+right_col_id).css({
        'float':'left',
        'position':'relative',
        'padding':'1em 0 1em 0',
        'overflow':'hidden'
    });

    $("#"+footerid).css('clear','both');
}


function applyCSS_3()
{
    var width = (unit == "%")?100:layoutWidth;
    /* 3 Column settings */
    $('.n_cols').css({
        'background':'#eee'
    });

    $('.n_cols .colcontent').css({
        'right':right_col_width + (2*colsPadding) +  unit,
        'background':'#fff'
    });

    $('.n_cols .colleft').css({
        'right':content_col_width + (2*colsPadding) + unit,
        'background':'#f4f4f4'
    });

    $('.n_cols #'+content_col_id).css({
        'width':content_col_width + unit,
        'left':(width+colsPadding)+unit
    });
    $('.n_cols #'+left_col_id).css({
        'width':left_col_width +unit,
        'left':(right_col_width)+(5*colsPadding)+unit
    });
    $('.n_cols #'+right_col_id).css({
        'width':right_col_width + unit,
        'left':(width-left_col_width)+(3*colsPadding)+unit
    });
}

function applyCSS_2_leftmenu()
{
    var width = (unit == "%")?100:layoutWidth;
    $('.n_cols').css({
        'background':'#fff'
    });

    $('.n_cols .colleft').css({
        'right': content_col_width + (2*colsPadding) + unit,
        'background':'#F4F4F4'
    });


    $('.n_cols #'+ content_col_id).css({
        'width': content_col_width + unit,
        'left':(width+colsPadding)+unit
    });

    $('.n_cols #'+left_col_id).css({
        'width':left_col_width +unit,
        'left':(3*colsPadding)+unit
    });
}

function applyCSS_2_rightmenu()
{
    var width = (unit == "%")?100:layoutWidth;

    $('.n_cols').css({
        'background':'#fff'
    });

    $('.n_cols .colleft').css({
        'right': right_col_width + (2*colsPadding) + unit,
        'background':'#F4F4F4'
    });


    $('.n_cols #'+ content_col_id).css({
        'width': content_col_width + unit,
        'left':right_col_width + (3*colsPadding)+unit
    });

    $('.n_cols #'+right_col_id).css({
        'width':right_col_width +unit,
        'left':right_col_width + (5*colsPadding)+unit
    });

}

function applyCSS_1()
{
    $('.n_cols #'+content_col_id).css({
        'left': colsPadding+unit,
        'width': content_col_width + unit
    });
}