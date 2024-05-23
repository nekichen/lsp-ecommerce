<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owl Carousel Example</title>
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
</head>
<body>

<!-- Set up your HTML -->
<div class="owl-carousel">
    <div> <img src="{{ asset('assets/hoshi_ganteng.jpg')}}" alt="Image 1"> </div>
    <div> <img src="{{ asset('assets/hoshi_ganteng.jpg')}}" alt="Image 2"> </div>
    <div> <img src="{{ asset('assets/hoshi_ganteng.jpg')}}" alt="Image 3"> </div>
    <div> <img src="{{ asset('assets/hoshi_ganteng.jpg')}}" alt="Image 4"> </div>
    <div> <img src="{{ asset('assets/hoshi_ganteng.jpg')}}" alt="Image 5"> </div>
    <div> <img src="{{ asset('assets/hoshi_ganteng.jpg')}}" alt="Image 6"> </div>
    <div> <img src="{{ asset('assets/hoshi_ganteng.jpg')}}" alt="Image 7"> </div>
</div>

<script>
$(document).ready(function(){
    var owl = $('.owl-carousel');
    owl.owlCarousel({
        loop: true,
        nav: true,
        margin: 10,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            960: {
                items: 5
            },
            1200: {
                items: 6
            }
        }
    });
    owl.on('mousewheel', '.owl-stage', function(e) {
        if (e.originalEvent.deltaY > 0) {
            owl.trigger('next.owl.carousel');
        } else {
            owl.trigger('prev.owl.carousel');
        }
        e.preventDefault();
    });
});
</script>

</body>
</html>
