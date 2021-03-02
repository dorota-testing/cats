$(document).ready(function(){
//alert('lorem');
//    initiate datepicker
// NOTE: this datepicker is highly customisable, check website for more options
$('input.datepicker').datepicker({
        format: "yyyy-mm-dd",
        weekStart: 1,
//        startDate: "22-11-1999",
//        endDate: "22-11-2222",
        todayBtn: true,
//        daysOfWeekDisabled: "0,6",
//       daysOfWeekHighlighted: "0,6",
//        calendarWeeks: true,
        autoclose: true,
        todayHighlight: true
    });
	

//hover tips for guest user
$( ".hoverTip" ).on('mouseenter touchstart', function(){
    $( this ).append( '<p class="tip">This button does not work<br>for guest users.</p>' );
  })
$( ".hoverTip").on('mouseleave touchend', function(){
    $( this ).children().fadeOut('slow', function(){
		$(this).remove(); //remove after fade out
	});
  });
//add a segment
$( ".addSegment" ).click(function() {
	var segment = $(this).data('segment');
	var content = $(".hidden ."+segment).html();
	$(this).parent().parent().before( content );
//  alert( content );
});

//remove a segment  
// to make it work for dynamicly inserted buttons, we need to call it from a static parent, can be a wrapper or in this case a form
$('form').on("click",".delete",function() {
	$(this).parent().parent().remove();
//    alert( 'lorem');
}); 

});