<section class="row mb0"> <article class="rc12"> <div class="footer tac"> <a href="index.php">Home</a> | <a href="about.php">About Us</a> | <a href="service.php">Gallery</a> | <a href="service.php">Our Services</a> | <a href="contact.php">Contact Us</a> | <?php copyright(); ?> </div> </article> </section> </main>
<script src="jquery-2.2.4.min.js"></script>
<script src="https://raw.githubusercontent.com/ganeshmax/jcarousellite/master/jquery.jcarousellite.min.js"></script>
<script defer="defer" src="jquery.jcarousellite.min.js"></script>
<script>
/*Mobile*/
	$(function(){
		$("#trigure").click(function(){
			$("#nav").slideToggle("slow");
		});
/*Carousel*/
		$(".anyClass").jCarouselLite({ btnNext: ".next", btnPrev: ".prev", visible:3, scroll:1, speed:500, circular:true});
		$("#slideshow > div:gt(0)").hide();setInterval(function(){
			$('#slideshow > div:first')  .fadeOut(1000)  .next()  .fadeIn(1000)  .end()  .appendTo('#slideshow');
		},3000);
	});
/*InputField Reset*/	
	function clearText(field){field.defaultValue == field.value ? field.value = '' : field.value = field.defaultValue;}
</script>
</body></html>
