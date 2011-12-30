$(function(){
	$images = $('.elgg-gallery .lightbox-photo .album-gallery-item a');
	$.each($images, function(i, a) {
		a.href = $(a).children().first().attr('src').replace(/size=[^&]*/, "size=full");
	});
	$images.lightBox({txtImage: 'Imagem',
	txtOf: 'de'});
});
