/* Sidebar navigation */
/* ------------------ */

/* Show navigation when the width is greather than or equal to 991px */

$(document).ready(function(){

  $(window).resize(function()
  {
    if($(window).width() >= 767){
      $(".side-nav").slideDown(150);
    }     
	else{
	  $(".side-nav").slideUp(150);
	}	
  });
	function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return x1 + x2;
}

function coma(nStr){
	var barunih = nStr.replace(/[$.]+/g,"");
	return barunih;
}
	$('.timepicker').timepicker({
		minuteStep: 5,
		disableFocus: true,
		showSeconds: false,
		defaultTime: '07:00',
		showMeridian: false,
	});
	
	$('.timepicker').timepicker().on('changeTime.timepicker', function(e) {
		changevalue();
	});
	
	var pad = function(x) {
			return x < 10 ? '0'+x : x;
		};
		
	function tambahjam(jam_awal, jam, menit){
		jam_awal=jam_awal.split(':');
		menitsekarang = parseInt(jam_awal[1]) + menit;
		jamsekarang = parseInt(jam_awal[0]) + jam;
		if(menitsekarang >= 60){
			jamsekarang = jamsekarang + 1;
			menitsekarang = menitsekarang % 60;
		}
		if(jamsekarang>=24){
			jamsekarang = jamsekarang % 24;
		}
		jam_sekarang = pad(jamsekarang)+':'+pad(menitsekarang);
		return jam_sekarang;
	}
	function changevalue(){
		var awal = $('input#jam_awal').val();
		var durasi = $('select#durasi').val();
		var jam = parseInt(durasi / 60);
		var menit = durasi % 60;
		tambahjam(awal, jam, menit); 
		$('input#jam_akhir').val(jam_sekarang);
	}
	
	$('select#durasi').on('change', function() {
		changevalue();
	});
	$('input#jam_awal').on('change', function() {
		changevalue();
	});
	
	function getTotal(){
		var biayadaftar = parseInt(coma($('input#biaya').val()));
		
		if($('input#biayainstrument').val() == ""){
			var instrument = 0;
		}
		else{
			var instrument = parseInt(coma($('input#biayainstrument').val()))
		}
		
		if($('input#discount') == ""){
			var discount = 0;
		}
		else if($('input#discount').val() > 100){
			var discount = 100;
			$('input#discount').val(100)
		}
		else{
			var discount = $('input#discount').val();
		}
		
		discount = (discount/100)*biayadaftar;
		
		var total = biayadaftar - discount + instrument;
		$('input#total').val(addCommas(total));
	}
	$('input#biaya').on('keyup', function() {
		getTotal();
	});
	$('input#discount').on('keyup', function() {
		getTotal();
	});
	
	
	$("select#instrument").bind("change", function(event) {
		var url = "./content/proses.php?act=getBiaya";
	
		var v_id = $('select#instrument').val();		

		$.post(url, {id: v_id})
			.done(function(biaya) {
				$('input#biayainstrument').val(addCommas(biaya));
				getTotal();
				$('input#biaya').focus();
			})
		});
		
	});

/* ****************************************** */
/* Sidebar dropdown */
/* ****************************************** */

$(document).ready(function(){
  $(".sidebar-dropdown a").on('click',function(e){
      e.preventDefault();

      if(!$(this).hasClass("open")) {
        // hide any open menus and remove all other classes
        $(".sidebar .side-nav").slideUp(150);
        $(".sidebar-dropdown a").removeClass("open");
        
        // open our new menu and add the open class
        $(".sidebar .side-nav").slideDown(150);
        $(this).addClass("open");
      }
      
      else if($(this).hasClass("open")) {
        $(this).removeClass("open");
        $(".sidebar .side-nav").slideUp(150);
      }
  });

});

/* ****************************************** */
/* Sidebar dropdown menu */
/* ****************************************** */

$(document).ready(function(){

  $(".has_submenu > a").click(function(e){
    e.preventDefault();
    var menu_li = $(this).parent("li");
    var menu_ul = $(this).next("ul");

    if(menu_li.hasClass("open")){
      menu_ul.slideUp(150);
      menu_li.removeClass("open");
	  $(this).find("span").removeClass("fa-caret-up").addClass("fa-caret-down");
    }
    else{
      $(".side-nav > li > ul").slideUp(150);
      $(".side-nav > li").removeClass("open");
      menu_ul.slideDown(150);
      menu_li.addClass("open");
	  $(this).find("span").removeClass("fa-caret-down").addClass("fa-caret-up");
    }
  });
  
});

/* ****************************************** */
/* Slim Scroll */
/* ****************************************** */

$(function(){
    $('.scroll').slimScroll({
        height: '315px',
		size: '5px',
		color:'rgba(50,50,50,0.3)'
    });
});	

/* ****************************************** */
/* JS for UI Tooltip */
/* ****************************************** */

$('.ui-tooltip').tooltip();

/* ****************************************** */
/* Form Validate // Form Validation */
/* ****************************************** */

$.validator.setDefaults({
	submitHandler: function() { alert("submitted!"); }
});

$().ready(function() {

	// validate signup form on keyup and submit
	$("#signupForm").validate({
		rules: {
			firstname: "required",
			lastname: "required",
			username: {
				required: true,
				minlength: 2
			},
			password: {
				required: true,
				minlength: 5
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			email: {
				required: true,
				email: true
			},
			gender: {
				required: true
			},
			limit: {
				required: true
			},
			location: {
				required: true
			},
			agree: "required"
		},
		messages: {
			firstname: "Please enter your firstname",
			lastname: "Please enter your lastname",
			username: {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 2 characters"
			},
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			confirm_password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long",
				equalTo: "Please enter the same password as above"
			},
			email: "Please enter a valid email address",
			gender: "Please choose gender",
			limit: "Please choose at least one option",
			location: "Please select your location",
			agree: "Please accept our policy"
		}
	});

});
function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return x1 + x2;
}

function coma(nStr){
	return nStr.replace(/[$.]+/g,"");
}