$( document ).ready(function(){
	/*$(".dropmenu-a").each(function(){
		$(this).on("click", function(){
			if($(this).children('ul').is(":hidden")){
				$(this).children('ul').fadeIn();
				$(this).children('.dropmenu-active').toggleClass("active");
			}
			else if($(this).children('ul').is(":visible")){
				$(this).children('ul').fadeOut();
				$(this).children('.dropmenu-active').removeClass("active");
			}
		})
	});*/

	
	var csrfVar = $('meta[name="csrf-token"]').attr('content');
	$('.abctest').each(function(){
		$(this).val('hi');
	});
	$(".image-user").on("click", function(){
		if($('.logout-dropdown').is(":hidden")){
			$('.logout-dropdown').fadeIn();
		}
		else if($('.logout-dropdown').is(":visible")){
			$('.logout-dropdown').fadeOut();
		}
	})


	$('#bd').change(function() {
		var val = $("#bd option:selected").text();
		var url = val;
		$(".bangdiem-l").empty();
		var temptr = $("<tr/>");
	    	temptr.append($("<th/>",{ text: "Mã môn học"
	    	})).append($("<th/>",{ text: "Tên môn học"
	    	})).append($("<th/>",{ text: "Tín chỉ"
	    	})).append($("<th/>",{ text: "Điểm"
	    	}));
		$(".bangdiem-l").append(temptr);
	    $.get(url,function(data){
	    	$.each(data, function(i, value){
	    		var tr = $("<tr/>");
	    			tr.append($("<td/>",{ text: value.MaMH
	    			})).append($("<td/>",{ text: value.TenMH
	    			})).append($("<td/>",{ text: value.SoTC
	    			})).append($("<td/>",{ text: value.Diem
	    			}));
	    		$(".bangdiem-l").append(tr);
	    	});
	    });
	})

	
});



