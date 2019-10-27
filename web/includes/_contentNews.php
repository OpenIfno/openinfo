<!--Start Page Content-->
<section id="page-content">
    <!--Start Page Heading-->
    <div class="page-heading bg-cover">
        <div class="overlay"></div>
        <div class="page-heading-content text-center">
            <h2 class="font-700 text-uppercase color-white">Blog Single</h2>
            <ol class="breadcrumb">
                <li><a href="index.php">Inicio</a></li>
                <li class="active">Blog Single</li>
            </ol>
        </div>
    </div>
    <!--End Page Heading-->

    <!--Start Blog Single Wrap-->
    <div class="blog-single-wrap">
        <!--Start Container-->
        <div class="container">
            <!--Start Row-->
            <div class="row">
                <?php
                  require_once("includes/_sidebar.php");
                  require_once("includes/_dataNews.php");
                ?>
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </div>
    <!--End Blog Single Wrap-->
</section>
<!--End Page Content-->
