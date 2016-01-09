<div id="menu">
<a href="dashboard2" rel="tab">menu1</a> |
<a href="Polls" rel="tab">menu2</a> |
<a href="all_report" rel="tab">menu3</a>
</div>



<script>
$(function(){
$("a[rel='tab']").click(function(e){
//code for the link action
return false;
});
});



$(function(){
$("a[rel='tab']").click(function(e){
//e.preventDefault();
/*
if uncomment the above line, html5 nonsupported browers won't change the url but will display the ajax content;
if commented, html5 nonsupported browers will reload the page to the specified link.
*/

//get the link location that was clicked
pageurl = $(this).attr('href');

//to get the ajax content and display in div with id 'content'
$.ajax({url:pageurl+'?rel=tab',success: function(data){
$('#content').html(data);
}});

//to change the browser URL to the given link location
if(pageurl!=window.location){
window.history.pushState({path:pageurl},'',pageurl);
}
//stop refreshing to the page given in
return false;
});
});




/* the below code is to override back button to get the ajax content without page reload*/
$(window).bind('popstate', function() {
$.ajax({url:location.pathname+'?rel=tab',success: function(data){
$('#content').html(data);
}});
});
</script>