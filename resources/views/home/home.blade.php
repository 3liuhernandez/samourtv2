@extends('layouts.app')

@section('content')
    <section class="cover-2 text-left" id="text">
        <div class="cover-container">
            <div class="cover-inner container">
                <div class="row justify-center">
                    <div class="col-lg-5 mt-5 mb-5 text-center text-lg-left">
                        <h1 class="jumbotron-heading">THE BOX PROJECTS</h1>
                        <p class="lead">productos digitales, de sonido y audio, para productores musicales / Creadores de contenido / post produccion cinematografica / Ingenieros de audio y video.</p>
                        <p>
                            <a href="#" class="btn btn-outline-success btn-lg mb-2 mr-2 ml-2 pill-btn">Productos</a>
                            <a href="#" class="btn link-white mb-2 ml-2 ml-2 pill-btn">Contacto</a>
                        </p>
                    </div>
                    {{-- <div class="col-lg-5 offset-lg-2 mt-5 mb-5 text-center">
                        <img class="img-fluid mt-5 mb-5" src="images/placeholder-phone.png" >
                    </div> --}}
                    <div class="col-lg-5 offset-lg-2 mt-5 mb-5 text-center">
                        <img class="img-fluid mt-5 mb-5" src="{{ asset('images/box1.jpg') }}" >
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="cover-1 text-center">
        <style>
            #video_ {
                /*left: 0px;
                right: 0;
                bottom: 0;*/
                position: relative;
                min-width: 100%;
                min-height: 100%;
            }

            #video_content {
                position: absolute;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                color: #f1f1f1;
                width: 100%;
                padding: 20px;
            }

            #btn_video {
                width: 200px;
                font-size: 18px;
                padding: 10px;
                border: none;
                background: #000;
                color: #fff;
                cursor: pointer;
            }
        </style>

        <div class="cover-container" style="margin: 0; padding: 1%; width: 100%;">
            <div class="row">
                <div class="col-md-7">
                    <video autoplay muted controls id="video_">
                        {{--  <source src="{{ asset('video/video_samourt2.mp4') }}" type="video/mp4">  --}}
                        Your browser does not support HTML5 video.
                    </video>
                    {{-- <button id="btn_video" onclick="myFunction()">Pause</button> --}}
                </div>
                <div class="col-md-5 text-center">
                    <h2 class="jumbotron-heading text-center" style="vertical-align: middle;">
                        WHAT ALREADY <br> SOUNDS GOOD
                        <br><br>
                        <em>WE MAKE IT <br>SOUND PERFECT</em>
                        <br><br><br>
                        <strong>SAM OURT</strong>
                    </h2>
                    <br><br>
                    <img src="{{ asset('images/logo.jpg') }}" alt="Samourt Logo" style="width: 150px; height: 150px" class="text-center">
                </div>
            </div>
            {{-- <div id="video_content">
                <div class="cover-inner">
                    <h1 class="jumbotron-heading">
                        WHAT ALREADY SOUNDS GOOD <em>WE MAKE IT SOUND PERFECT</em>
                    </h1>
                </div>
                <div class="cover-inner">
                    <h1 class="jumbotron-heading">
                        <strong>SAM OURT</strong>
                    </h1>
                </div>
            </div> --}}
        </div>

        <script>
            var video = document.getElementById("video_");
            var btn = document.getElementById("btn_video");

            function myFunction() {
                if (video.paused) {
                    video.play();
                    btn.innerHTML = "Pause";
                } else {
                    video.pause();
                    btn.innerHTML = "Play";
                }
            }
        </script>
    </section>

    <section class="content-1 mt-4 p-4">
        <div class="container-fluid text-white">
            <div class="row justify-center">
                <div class="col-md-4 text-center">
                    <img class="mb-4 img-fluid" src="images/10_free_flp.jpg" >
                </div>
                <div class="col-md-8" style="background: #081c15; height: 60vh; padding: 3rem">
                    <div class="title_seccion d-flex flex-column justify-content-start">
                        <h2 class="display-3">The Box & Sam Ourt</h2>
                        <h3 class="mb-4 display-4">Sylengh 1 Preset pack</h3>
                    </div>
                    <p class="m4-4 text-white">The Venezuelan artist and music producer teams up with The Box inside you can fin 100% madre scratch Sylenth 1 preset inspired in the top music artist right now.</p>
                    <p class="text-white"> Licensing rights included with purchase: </p>
                    <ul>
                        <li>Straming on Spotify, Youtube, SoundCloud, etc</li>
                        <li>Beat lease sales on Beatstarts, airbit, etc</li>
                        <li>Placement with major artists</li>
                        <li>100% melodies are 100% royalty free</li>
                    </ul>
                    <div class="col-md-12">
                        <h4>Preview</h4>
                        <div class="previe">
                            <div class="row bg-gray">
                                <div class="col-md-6">
                                    <audio controls>
                                        <source src="horse.ogg" type="audio/ogg">
                                        <source src="horse.mp3" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                        </audio>
                                </div>
                                <div class="col-md-6">
                                    <audio controls>
                                        <source src="horse.ogg" type="audio/ogg">
                                        <source src="horse.mp3" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                        </audio>
                                </div>
                                <div class="col-md-6">
                                    <audio controls>
                                        <source src="horse.ogg" type="audio/ogg">
                                        <source src="horse.mp3" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                        </audio>
                                </div>
                                <div class="col-md-6">
                                    <audio controls>
                                        <source src="horse.ogg" type="audio/ogg">
                                        <source src="horse.mp3" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                        </audio>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-center mt-4">
                        <a class="btn border text-white" href="#" role="button">
                            FREE <b>DOWNLOAD</b>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="content-2">
        <div class="container">
            <div class="row justify-center">
                <div class="col-md-6 text-center text-md-left pl-5">
                    <h2 class="mb-4 mt-4">Talk about your awesome features</h2>
                    <p class="mb-4">Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p><a class="btn btn-outline-secondary" href="#" role="button">Find out more    </a></p>
                </div>
                <div class="col-md-6 text-center">
                    <img class="mb-4 img-fluid" src="images/guitar_sample_pack.jpg" >
                </div>
            </div>
        </div>
    </section>

    <section class="content-4">
        <div class="container">
            <div class="row justify-center mt-5">
                <div class="col-md-6 pl-5 pr-5 text-center" >
                    <img class="mb-4 img-fluid" src="images/tb_x_bluk.jpg" >
                </div>
                <div class="col-md-6 text-left" >
                    <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h2>
                    <p class="lead mt-4 mb-5">Integer libero nunc, elementum eu venenatis sed, molestie non tortor. Duis suscipit pulvinar justo. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. </p>

                    <div class="row">
                        <div class="col-md-6 col-feature mb-4">
                            <h4 class="mb-3">Clean Design</h4>
                            <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                        </div>
                        <div class="col-md-6 col-feature mb-4">
                            <h4 class="mb-3">Bootstrap 4</h4>
                            <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES --}}
    <section class="features-4 text-center">
        <div class="container">
            <div class="row justify-center">
                <div class="col-md-8 text-center" >
                    <h2>Features</h2>
                    <p class="lead mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse cursus erat sed sem sagittis cursus.</p>
                    <div class="divider"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-feature">
                    <div class="rounded-circle justify-center">
                        <em class="fa fa-2x fa-paint-brush"></em>
                    </div>
                    <h4>Clean Design</h4>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p>
                </div>
                <div class="col-md-3 col-feature">
                    <div class="rounded-circle justify-center">
                        <em class="fa fa-2x fa-mobile"></em>
                    </div>
                    <h4>Responsive</h4>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p>
                </div>
                <div class="col-md-3 col-feature">
                    <div class="rounded-circle justify-center">
                        <em class="fa fa-2x fa-code"></em>
                    </div>
                    <h4>Bootstrap 4</h4>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p>
                </div>
                <div class="col-md-3 col-feature">
                    <div class="rounded-circle justify-center">
                        <em class="fa fa-2x fa-pencil"></em>
                    </div>
                    <h4>Easy to Edit</h4>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- STATS --}}
    <section class="cta-5 text-center text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 text-left">
                    <h2>STATS</h2>
                    <p class="lead mt-3">Lorem ipsum dolor sit amet, consectetur </p>
                </div>
                <div class="col-lg-4 text-center text-lg-left">
                    <h2 class="mt-4 mb-2">+800</h2>
                    <p class="lead mb-3 text-white">DOWNLOADS IN FREEBIES</p>
                </div>
                <div class="col-lg-4 text-center text-lg-left">
                    <h2 class="mt-4 mb-2">200</h2>
                    <p class="lead mb-3 text-white">NEW REACHED PEOPLE</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SIGNED WORKED WITH --}}
    <section class="features-4 text-center">
        <div class="container">
            <div class="row justify-center">
                <div class="col-md-8 text-center" >
                    <h2>SIGNED / WORKED WITH</h2>
                    {{-- <p class="lead mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse cursus erat sed sem sagittis cursus.</p> --}}
                    <div class="divider"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-feature">
                    <div class="justify-center">
                        <em class="fa fa-2x fa-paint-brush"></em>
                    </div>
                    <h4>Clean Design</h4>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p>
                </div>
                <div class="col-md-4 col-feature">
                    <div class="justify-center">
                        <em class="fa fa-2x fa-mobile"></em>
                    </div>
                    <h4>Responsive</h4>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p>
                </div>
                <div class="col-md-4 col-feature">
                    <div class="justify-center">
                        <em class="fa fa-2x fa-code"></em>
                    </div>
                    <h4>Bootstrap 4</h4>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-feature">
                    <div class="justify-center">
                        <em class="fa fa-2x fa-mobile"></em>
                    </div>
                    <h4>Responsive</h4>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p>
                </div>
                <div class="col-md-4 col-feature">
                    <div class="justify-center">
                        <em class="fa fa-2x fa-code"></em>
                    </div>
                    <h4>Bootstrap 4</h4>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p>
                </div>
                <div class="col-md-4 col-feature">
                    <div class="justify-center">
                        <em class="fa fa-2x fa-pencil"></em>
                    </div>
                    <h4>Easy to Edit</h4>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-1 text-white">

        <div class="container">
            <div class="row contact-details">
                <div class="col-sm-8 text-center text-md-left mb-4">
                    <h3>Ask us a question</h3>
                    <form class="contact-form mt-4">
                        <div class="row">
                            <div class="col-md-5">
                                <input type="text" class="form-control-custom mb-4" placeholder="Name" value="Your name">
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control-custom mb-4" placeholder="Email address" value="Email address">
                            </div>
                            <br />
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <textarea class="form-control-custom mb-4" rows="3">Your Message</textarea><br />
                                <button type="submit" class="btn btn-primary btn-lg mb-4">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-4 text-center text-md-left">
                    <h3>Contact</h3>
                    <h4 class="pt-4">Email</h4>
                    <p>hello@startup.co</p>
                    <h4 class="pt-2">Phone</h4>
                    <p>+111 234 567 89</p>
                    <h4 class="pt-2">Address</h4>
                    <p>1 Street Name, City, Zip Code<br />
                    United States</p>
                    <ul class="social">
                        <li><a href="#" title="Facebook" class="fa fa-facebook"></a></li>
                        <li><a href="#" title="Twitter" class="fa fa-twitter"></a></li>
                        <li><a href="#" title="Google+" class="fa fa-google"></a></li>
                        <li><a href="#" title="Dribbble" class="fa fa-dribbble"></a></li>
                        <li><a href="#" title="Instagram" class="fa fa-instagram"></a></li>
                        <div class="clear"></div>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer-4">
        <div class="container">
            <div class="row mb-5 text-center text-md-left">
                <div class="col-md-3 col-lg-4 mb-3">
                    <a class="logo" href="#">Startup UI Kit</a>
                </div>
                <div class="col-md-3 offset-lg-2 col-lg-2 pt-2">
                    <h5>Category 1</h5>
                    <ul class="nav-footer">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Our Work</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 col-lg-2 pt-2">
                    <h5>Category 2</h5>
                    <ul class="nav-footer">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Our Work</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 col-lg-2 pt-2">
                    <h5>Category 3</h5>
                    <ul class="nav-footer">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Our Work</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="divider"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-left mt-2 mb-3 pt-1">
                    <p class="copyright">Copyright &copy; YourStartup. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-right mb-4">
                    <ul class="social">
                        <li><a href="#" title="Facebook" class="fa fa-facebook"></a></li>
                        <li><a href="#" title="Twitter" class="fa fa-twitter"></a></li>
                        <li><a href="#" title="Google+" class="fa fa-google"></a></li>
                        <li><a href="#" title="Dribbble" class="fa fa-dribbble"></a></li>
                        <li><a href="#" title="Instagram" class="fa fa-instagram"></a></li>
                        <div class="clear"></div>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
@endsection

@section('appFooter')
{{-- <div id="map"></div> --}}
{{-- <script src="js/maps.js"></script>
<!--YOU MUST REPLACE WITH YOUR OWN API KEY FOR THE MAP TO WORK-->
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBptaDKT_ntSoNEytCnSang5JenaNAj_Us&callback=initMap">
</script> --}}
@endsection
