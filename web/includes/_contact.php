
        <!--Start Contact Area-->
        <section id="contact-area" class="bg-gray">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 text-uppercase">Cont&aacute;ctenos</h2>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. </p>
                        </div>
                    </div>
                </div>
                <!--Start Heading Row-->

                <!--Start Contact Info-->
                <div class="contact-info">
                    <!--Start Row-->
                    <div class="row">
                        <!--Start Contact Info Single-->
                        <div class="col-sm-4">
                            <div class="contact-info-single text-center">
                                <i class="icofont icofont-phone color-main"></i>
                                <p class="font-500"><?php echo $page_fono; ?></p>
                            </div>
                        </div>
                        <!--End Contact Info Single-->

                        <!--Start Contact Info Single-->
                        <div class="col-sm-4">
                            <div class="contact-info-single text-center">
                                <i class="icofont icofont-email color-main"></i>
                                <p class="font-500"><?php echo $page_email; ?></p>
                            </div>
                        </div>
                        <!--End Contact Info Single-->

                        <!--Start Contact Info Single-->
                        <div class="col-sm-4">
                            <div class="contact-info-single text-center">
                                <i class="icofont icofont-social-google-map color-main"></i>
                                <p class="font-500"><?php echo $page_direccion_1; ?></p>
                            </div>
                        </div>
                        <!--End Contact Info Single-->
                    </div>
                    <!--End Row-->
                </div>
                <!--End Contact Info-->

                <!--Start Contact Form Row-->
                <div class="row">
                    <!--Start Contact Form-->
                    <div class="col-md-6">
                        <div class="contact-form">
                            <form action="index.html" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Nombres y Apellidos">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Motivo del mensaje">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" cols="30" rows="10" placeholder="Mensaje"></textarea>
                                </div>
                                <button type="submit">Enviar</button>
                            </form>
                        </div>
                    </div>
                    <!--End Contact Form-->

                    <!--Start Google Map-->
                    <div class="col-md-6">
                        <div id="google-map"></div>
                    </div>
                    <!--End Google Map-->
                </div>
                <!--End Contact Form Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Contact Area-->
