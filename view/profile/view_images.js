$(document).ready(function(){
   var sliderIsOpen = false;
   var currentPhoto = 0;
   var allImagesInBlock = [];

   $('.post_photo_block').click(function(){
      allImagesInBlock = getAllImages(this);
      if (!sliderIsOpen) {
         $('#photo_slider').show(300);
         $('.photo_slider_image > img').attr('src', allImagesInBlock[currentPhoto]);
         sliderIsOpen = true;
      }
   });
   $('#close_slider').click(function(){
      $('#photo_slider').hide(300);
      sliderIsOpen = false;
      currentPhoto = 0;
   });
   $('#nav_next').click(function(){
      if (currentPhoto < allImagesInBlock.length-1) {
         $('.photo_slider_image > img').attr('src', allImagesInBlock[++currentPhoto]);
      }
   });
   $('#nav_prev').click(function(){
      if (currentPhoto > 0){
         $('.photo_slider_image > img').attr('src', allImagesInBlock[--currentPhoto]);
      }
   });
});

function getAllImages(block){
   var imageBlock;
   var allImages = [];
   var countImages = 0;
   imageBlock = $(block).children('.image_block');
   $(imageBlock).each(function(){
      allImages[countImages] = $(this).children('img').attr('src');
      countImages++;
   });
   return allImages;
}