<?php
$response = file_get_contents("forecastdata.json");
$data = json_decode($response);
$weatherdata = $data->data;
$filedate =  $weatherdata[0]->valid_date;
if ($filedate !== date("Y-m-d")) {
    include 'forecastAPI.php';
}

?>

<!doctype html>
<html>

<head>
    <style>
        #today {
            display: flex;
            min-height: 150px;
            background: linear-gradient(0deg, rgba(51, 48, 41, 0.9), rgba(237, 179, 33, 0.3)), url(imForSite/kualalumpur.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            padding: 20px;
            padding-left: 40px;
        }

        .weather-icon {
            vertical-align: middle;
            margin-right: 5px;
            width: 80px;
            padding-top: 10px;
        }

        * {
            box-sizing: border-box
        }

        body {
            font-family: Verdana, sans-serif;
            margin: 0
        }

        .mySlides {
            display: none
        }

        img {
            vertical-align: middle;
        }

        /* Slideshow container */
        .slideshow-container {
            max-width: 1000px;
            position: relative;
            margin: auto;
            padding-top: 10px;
        }

        /* Next & previous buttons */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Caption text */
        .text {
            color: #f2f2f2;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* The dots/bullets/indicators */
        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .active,
        .dot:hover {
            background-color: #717171;
        }

        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {

            .prev,
            .next,
            .text {
                font-size: 11px
            }
        }

        .flexbox {
            margin-left: 5px;
            margin-right: 5px;
            padding: auto;
            text-align: center;
            word-wrap: break-word;
            width: 120px;
        }
    </style>
</head>

<body>
    <div id="today">
        <div style="color:white;margin-top:15px;">
            <img class="weather-icon" src=" https://www.weatherbit.io/static/img/icons/<?php echo $weatherdata[0]->weather->icon; ?>.png" style="width:90px;margin-left:10px;" /><br>
            <b><?php echo $weatherdata[0]->weather->description; ?></b><br>
        </div>
        <div style="margin-left:30px;margin-top:10px;color:white;">
            <div><b> <?php echo date('l') ?></b>&nbsp;<?php echo date('d F Y') ?> </div>

            <div style="font-size:xx-large;"><b><?php echo $data->city_name; ?><br></b></div>
            <div style="font-size:x-large;"><b><?php echo $weatherdata[0]->temp; ?>&#176;C<br></b></div>
            <div style="font-size:x-small; margin-top:3px;">
                <?php echo $weatherdata[0]->min_temp; ?>&#176;C &nbsp; | &nbsp;
                <?php echo $weatherdata[0]->max_temp; ?>&#176;C
            </div>

        </div>
    </div>
    <div class="slideshow-container">
        <div class="mySlides">
            <div class="numbertext">1 / 2</div>
            <div style="width:100%; display: flex;justify-content: center;">
                <?php for ($x = 1; $x <= 7; $x += 1) {

                ?>
                    <div class="flexbox">
                        <div><b><?php echo date('D', strtotime($weatherdata[$x]->valid_date)); ?></b></div>
                        <div style="font-size:small"><b><?php echo date('d M', strtotime($weatherdata[$x]->valid_date)); ?></b></div>
                        <img class="weather-icon" src=" https://www.weatherbit.io/static/img/icons/<?php echo $weatherdata[$x]->weather->icon; ?>.png" />
                        <div style="font-size:small;min-height:40px;"><b><?php echo $weatherdata[$x]->weather->description; ?></b></div>
                        <div style="font-size:xx-small; margin-top:5px;">
                            <?php echo $weatherdata[$x]->min_temp; ?>&#176;C &nbsp; | &nbsp;
                            <?php echo $weatherdata[$x]->max_temp; ?>&#176;C
                        </div>
                    </div>
                <?php }
                ?>
            </div>
        </div>

        <div class="mySlides">
            <div class="numbertext">2 / 2</div>
            <div style="width:100%; display: flex;justify-content: center;">
                <?php for ($x = 8; $x <= 14; $x += 1) {

                ?>
                    <div class="flexbox">
                        <div><b><?php echo date('D', strtotime($weatherdata[$x]->valid_date)); ?></b></div>
                        <div style="font-size:small"><b><?php echo date('d M', strtotime($weatherdata[$x]->valid_date)); ?></b></div>
                        <img class="weather-icon" src=" https://www.weatherbit.io/static/img/icons/<?php echo $weatherdata[$x]->weather->icon; ?>.png" />
                        <div style="font-size:small;min-height:40px;"><b><?php echo $weatherdata[$x]->weather->description; ?></b></div>
                        <div style="font-size:xx-small; margin-top:5px;">
                            <?php echo $weatherdata[$x]->min_temp; ?>&#176;C &nbsp; | &nbsp;
                            <?php echo $weatherdata[$x]->max_temp; ?>&#176;C
                        </div>
                    </div>
                <?php }
                ?>
            </div>
        </div>



        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>

    </div>
    <br>

    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
    </div>

    <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }
    </script>
</body>

</html>