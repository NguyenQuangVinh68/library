$(document).ready(function () {
    $(".slider").slick({
        infinite: true,
        slidesToShow: 6,
        slidesToScroll: 2,
        prevArrow:
            "<button type='button' class='slick-prev slick-arrow'><i class='bi bi-arrow-left'></i></button>",
        nextArrow:
            "<button type='button' class='slick-next slick-arrow'><i class='bi bi-arrow-right'></i></button>",
        dots: true,
        responsive: [
            {
                breakpoint: 1026,
                settings: {
                    slidesToShow: 4,
                },
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3,
                    infinite: false,
                },
            },
            {
                breakpoint: 428,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    infinite: false,
                },
            },
        ],
    });
});
