<?php
error_reporting(E_ALL);

require_once('jshrink_minifier.php');

use JShrink\Minifier as jsmin;

// JavaScript Minifier
function minify_js($input)
{
    return jsmin::minify($input);
}

// CSS Minifier => http://ideone.com/Q5USEF + improvement(s)
function minify_css($input)
{
    if (trim($input) === "") return $input;
    return preg_replace(
        array(
            // Remove comment(s)
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
            // Remove unused white-space(s)
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
            // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
            '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
            // Replace `:0 0 0 0` with `:0`
            '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
            // Replace `background-position:0` with `background-position:0 0`
            '#(background-position):0(?=[;\}])#si',
            // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
            '#(?<=[\s:,\-])0+\.(\d+)#s',
            // Minify string value
            '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
            '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
            // Minify HEX color code
            '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
            // Replace `(border|outline):none` with `(border|outline):0`
            '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
            // Remove empty selector(s)
            '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
        ),
        array(
            '$1',
            '$1$2$3$4$5$6$7',
            '$1',
            ':0',
            '$1:0 0',
            '.$1',
            '$1$3',
            '$1$2$4$5',
            '$1$2$3',
            '$1:0',
            '$1$2'
        ),
        $input);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ethlo</title>
    <meta name="description" content="">
    <meta charset="utf-8">
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css"
          integrity="sha512-usVBAd66/NpVNfBge19gws2j6JZinnca12rAe2l+d+QkLU9fiG02O1X8Q6hepIpr/EYKZvKx/I9WsnujJuOmBA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
          integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <style>
        <?php output("\n\n/********************* SEPARATOR ***********************/\n\n", array(
            'css/style.css',
            'css/style-responsive.css',
            'css/vertical-rhythm.min.css',
            'css/magnific-popup.css',
            'css/owl.carousel.css',
            'css/animate.min.css',
            'css/splitting.css'), 'minify_css'); ?>
    </style>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#333333">

</head>
<body class="appear-animate">

<!-- Page Loader -->
<div class="page-loader dark">
    <div class="loader">Loading...</div>
</div>
<!-- End Page Loader -->

<!-- Skip to Content -->
<a href="#main" class="btn skip-to-content">Skip to Content</a>
<!-- End Skip to Content -->

<!-- Page Wrap -->
<div class="page bg-dark light-content" id="top">

    <!-- Navigation panel -->
    <nav class="main-nav dark transparent stick-fixed wow-menubar">
        <div class="full-wrapper relative clearfix">

            <!-- Logo ( * your text or image into link tag *) -->
            <div class="nav-logo-wrap local-scroll">
                <a href="/" class="logo">
                    <img src="img/logo_ethlo_new.svg" alt="ethlo logo" width="188" height="37"/>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="mobile-nav" role="button" tabindex="0">
                <i class="fa fa-bars"></i>
                <span class="sr-only">Menu</span>
            </div>

            <!-- Main Menu -->
            <div class="inner-nav desktop-nav">
                <ul class="clearlist scroll-nav local-scroll">
                    <li class="active"><a href="#home">Home</a></li>
                    <li><a href="#video">Videos</a></li>
                    <li><a href="#software">Software</a></li>
                    <li><a href="#about">About</a></li>
                </ul>
            </div>
            <!-- End Main Menu -->

        </div>
    </nav>
    <!-- End Navigation panel -->

    <main id="main">

        <!-- Home Section -->
        <section class="home-section bg-dark-alfa-70 parallax-5" data-background="img/ocean_uhd.webp" id="home">
            <div class="container min-height-100vh d-flex align-items-center pt-100 pb-100">

                <!-- Hero Content -->
                <div class="home-content">
                    <div class="wow fadeInUpShort" data-wow-delay=".1s">
                        <h1 class="hs-line-9 mb-60 mb-xs-40">
                                    <span class="text-rotate">
                                        Professional software development|
                                        Avid video production|
                                        Curious thinking and tinkering
                                    </span>
                        </h1>
                    </div>
                    <div class="wow fadeInUpShort" data-wow-delay=".4s">
                        <p class="hs-line-4 opacity-07">
                                    <span class="text-rotate">Extensive experience delivering high quality solutions|
                                        Shooting and editing|
                                        Jack of all trades, master of a few ;-)</span>
                        </p>
                    </div>
                </div>
                <!-- End Hero Content -->

                <!-- Scroll Down -->
                <div class="local-scroll scroll-down-wrap wow fadeInUpShort" data-wow-offset="0">
                    <a href="#about" class="scroll-down"><i class="scroll-down-icon"></i><span class="sr-only">Scroll to the next section</span></a>
                </div>
                <!-- End Scroll Down -->

            </div>
        </section>
        <!-- End Home Section -->

        <!-- Video section -->
        <section class="page-section pb-0 bg-dark light-content" id="video">
            <div class="full-wrapper relative">
                <div class="text-center mb-80 mb-sm-50">
                    <h2 class="section-title">Videos</h2>
                    <p class="section-title-descr">
                        A selection of created videos, hosted on <a
                                href="https://www.youtube.com/channel/UCxhi3ZkJ8SdAMvSj_XSAKpA">YouTube</a>.
                        Please <a href="https://www.youtube.com/channel/UCxhi3ZkJ8SdAMvSj_XSAKpA?sub_confirmation=1">subscribe</a>
                        to be notified of new videos!
                    </p>
                </div>

                <!-- Video grid -->
                <ul class="works-grid work-grid-3 work-grid-gut clearfix hide-titles" id="video-grid">

                    <?php
                    $yt_videos = json_decode(file_get_contents('https://ethlo.com/yt'), true);
                    foreach ($yt_videos as $video) {
                        ?>
                        <!-- Video -->
                        <li class="work-item mix video">
                            <a href="https://youtu.be/<?php echo $video['id']; ?>" class="work-ext-link">
                                <div class="work-img">
                                    <div class="work-img-bg wow-p scalexIn"></div>
                                    <img src="https://i.ytimg.com/vi_webp/<?php echo $video['id']; ?>/maxresdefault.webp"
                                         srcset="https://i.ytimg.com/vi_webp/<?= $video['id'] ?>/maxresdefault.webp 1100w, https://img.youtube.com/vi/<?= $video['id'] ?>/hqdefault.jpg 480w, https://i.ytimg.com/vi/<?= $video['id'] ?>/mqdefault.jpg 320w"
                                         sizes="(min-width: 1000px), 50vw, 100vw"
                                         alt="<?= $video['title'] ?>" class="wow-p fadeIn" data-wow-delay=".2s"/>
                                </div>
                                <div class="work-intro">
                                    <h3 class="work-title"><?= $video['title'] ?></h3>
                                    <div class="work-descr">
                                        <?= $video['summary'] ?>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <!-- End video -->
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </section>

        <!-- Software section -->
        <section class="page-section bg-dark light-content" id="software">
            <div class="container relative">
                <div class="mb-60 mb-xs-40">
                    <div class="text-center mb-80 mb-sm-50">
                        <h2 class="section-title">Software</h2>
                        <p class="section-title-descr">
                            A selection of open-source software projects, hosted on <a
                                    href="https://github.com/ethlo">GitHub</a>.
                        </p>
                    </div>
                    <?php
                    $github_repos = json_decode(file_get_contents('https://ethlo.com/github'), true);
                    $idx = 0;
                    foreach ($github_repos as $repo) {
                        if ($idx == 0) {
                            echo "<div class=\"row\">\n";
                        }
                        ?>

                        <div class="col-sm-4 mb-40">
                            <div class="text" style="padding:2rem">
                                <h5><a class="text-link" style="font-size:20px; text-transform: none"
                                       href="https://github.com/ethlo/<?= $repo['name'] ?>">
                                        <i class="fab fa-github"></i> <?= $repo['name'] ?></a>
                                </h5>
                                <div class="row">
                                    <div class="col">
                                        <i class="fas fa-star" style="color:darkgoldenrod"
                                           aria-hidden="true"></i> <?= $repo['stargazers_count'] ?>&nbsp;
                                        <i class="fas fa-code-branch" style="color: #888"
                                           aria-hidden="true"></i> <?= $repo['forks_count'] ?>
                                    </div>
                                    <div class="col align-right"><?= date("Y-m-d", strtotime($repo['updated_at'])) ?></div>
                                </div>
                                <p><?= $repo['description'] ?></p>
                            </div>
                        </div>
                        <?php

                        if (($idx == 2)) {
                            echo "</div>\n";
                            $idx = 0;
                        } else {
                            $idx++;
                        }
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="page-section bg-dark light-content" id="about">
            <div class="container relative">

                <div class="text-center mb-80 mb-sm-50">
                    <h2 class="section-title">About</h2>
                </div>

                <div class="mb-140 mb-sm-70">
                    <div class="row section-text">

                        <div class="col-md-12 col-lg-4 mb-md-50 mb-xs-30">
                            <div class="lead-alt wow linesAnimIn" data-splitting="lines">
                                Welcome to my playground!
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4 mb-sm-50 mb-xs-30 wow linesAnimIn" data-splitting="lines">
                            I'm a professional, highly experienced software developer and architect. My background
                            ranges from mapping business processes to low-level software and data optimizations.
                        </div>

                        <div class="col-md-6 col-lg-4 mb-sm-50 mb-xs-30 wow linesAnimIn" data-splitting="lines">
                            When not busy with work or life, I love bringing my camera and create photos and videos that
                            can portray the experience!
                        </div>
                    </div>
                    <div class="row section-text">
                        <div class="col-md-12 col-lg-4 mb-sm-50 mb-xs-30 wow linesAnimIn" data-splitting="lines">
                            The name &quot;ethlo&quot; used to be my company name, and has been with me since I started
                            doing professional software development, and has stayed with me. Since I find it short
                            and sweet, I use it as a signature on things I have created.
                            <p>Fun-fact: The name stems from the Linux <em>ifconfig</em> output, listing network
                                interfaces, usually listing <em>eth</em> and <em>lo</em> as standard devices.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="page-section bg-dark-lighter light-content footer pb-100 pb-sm-50">
        <div class="container">
            <div class="footer-social-links mb-90 mb-xs-40">
                <a href="https://www.youtube.com/channel/UCxhi3ZkJ8SdAMvSj_XSAKpA?sub_confirmation=1" title="Youtube"><i
                            class="fab fa-youtube-square"></i> <span class="sr-only">Youtube channel</span></a>
            </div>

            <!-- Footer Text -->
            <div class="footer-text">

                <!-- Copyright -->
                <div class="footer-copy">
                    <a href="https://ethlo.com">Copyright ethlo 2004-2021</a>.
                </div>
                <!-- End Copyright -->

                <div class="footer-made">
                    Made with love, coffee and pure stubbornness.
                </div>

            </div>
            <!-- End Footer Text -->

        </div>

        <!-- Top Link -->
        <div class="local-scroll">
            <a href="#top" class="link-to-top"><i class="link-to-top-icon"></i></a>
        </div>
        <!-- End Top Link -->

    </footer>
    <!-- End Footer -->

</div>
<!-- End Page Wrap -->

<!-- JS -->
<?php
function output($delim, $files, $fn)
{
    foreach ($files as $file) {
        echo $fn(file_get_contents($file));
        echo $delim;
    }
}

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"
        integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/16.1.3/smooth-scroll.min.js"
        integrity="sha512-HYG9E+RmbXS7oy529Nk8byKFw5jqM3R1zzvoV2JnltsIGkK/AhZSzciYCNxDMOXEbYO9w6MJ6SpuYgm5PJPpeQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.3/jquery.scrollTo.min.js"
        referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-localScroll/2.0.0/jquery.localScroll.min.js"
        integrity="sha512-x/Viuh5YndnrDISWqrZ6rerGnHccdLv/TW2B+xEGqubrLGCT6LdBGhnQxXo1Q4sXFgO12YeRWDYJkIV41OtOTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-viewport-checker/1.8.8/jquery.viewportchecker.min.js"
        integrity="sha512-FRX6MYITclzDyyMmSQLgZoZTfE+GLzAQpjs15adVZMY6AqhsrBLx8UZwp4FoqrrRFWY9TiaPwja7EY5fk309vw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-countto/1.2.0/jquery.countTo.min.js"
        integrity="sha512-RXuJVZbGztKGYMNgmWU6oOHbUwYu+NnzovhT4lyW1kfmEfRK6CD1xL8U+0xACFqSkC3cxMugaaNEP8wWmvl4Jw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.appear/0.4.1/jquery.appear.min.js"
        integrity="sha512-vYYoQJKYzaJQaOaYxaJhhmxikOJ2SEgHwmCNa0EMP0aRr7opdt4HHrorAwnCyPm8bdW/JBApIomo85YaBX81zA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-parallax/1.1.3/jquery-parallax-min.js"
        integrity="sha512-ES/eSqVi/9sgeZfvunOto+gwgFGrD/hzi5UOJFDR1Me8acKSBJIb2Gk0IyKje2ZaX+OovAG2/bRzj/uBcNeesg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/luxon/2.0.2/luxon.min.js"
        integrity="sha512-frUCURIeB0OKMPgmDEwT3rC4NH2a4gn06N3Iw6T1z0WfrQZd7gNfJFbHrNsZP38PVXOp6nUiFtBqVvmCj+ARhw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/fitvids/1.2.0/jquery.fitvids.min.js" integrity="sha512-/2sZKAsHDmHNoevKR/xsUKe+Bpf692q4tHNQs9VWWz0ujJ9JBM67iFYbIEdfDV9I2BaodgT5MIg/FTUmUv3oyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
-->

<script>
    <?php output("\n\n", array(
        'js/owl.carousel.min.js',
        'js/isotope.pkgd.min.js',
        'js/imagesloaded.pkgd.min.js',
        'js/jquery.magnific-popup.min.js',
        'js/masonry.pkgd.min.js',
        'js/jquery.lazyload.min.js',
        'js/wow.min.js',
        'js/morphext.js',
        'js/typed.min.js',
        'js/all.js',
        'js/splitting.min.js'), 'minify_js'); ?>
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-FKGJPF4HFE"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-FKGJPF4HFE');
</script>

</body>
</html>
<!-- Last modified: <?= date('c') ?> -->