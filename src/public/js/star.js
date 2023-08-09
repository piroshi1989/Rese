function starColor(starNum) {
    $(".star-rating label").removeClass("fill");

  for (let i = 1; i <= starNum; i++) {
    $(`#star${i} + label`).addClass("fill");
  }
}

$(".star-rating label").on('click mouseenter', function () {
  const starNum = $(this).attr('data-label-num');
  starColor(starNum);
});

$(".star-rating label").on('mouseleave', function () {
  const starNum = $(".star-rating input:checked").val();
  starColor(starNum);
});