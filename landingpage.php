<?php 
    $pageTitle = "Landing Page - Healpoint";
    include './inc/inc_header.php'; 
?>
    <section>
        <div class="container-fluid mb-5">
            <div class="row mt-5">
                <div class="col-md-5"
                    style="justify-content: center; align-items: center; display: flex; flex-direction: column;">
                    <button type="button"
                        style="border-radius: 20px; border: 1px solid #BB8446; font-weight: bolder; color: black;"
                        class="btn btn-outline-link" disabled>MENTAL HEALTH AT 30’S
                    </button>
                    <h3 class="tagline mt-4 text-center">
                        <a style="color: #BB8446;">Mental health</a> is wealth
                    </h3>
                    <p class="text-center" style="width: 70%;">
                        Untuk menjalani hidup Anda sepenuhnya, kami terus menemukan cara untuk mencegah masalah mental
                        health anda
                    </p>
                    <div class="row">
                        <div class="col-sm-6 mt-4">
                            <img src="assets/image.png" class="img-thumbnail" alt="...">
                        </div>
                        <div class="col-sm-6">
                            <img src="assets/image (1).png" class="img-thumbnail" alt="...">
                        </div>
                    </div>
                    <img src="assets/image (2).png" class=" img-thumbnail mt-3 mx-auto" alt="...">
                </div>
                <div class="col-md-1" style="justify-content: center; align-items: center; display: flex; flex-direction: column;">
                    <div class="vertical-line" style="height: 80%; width: 1px;">
                    </div>
                    <button type="button" class="btn btn-outline-dark mt-3" style="border-radius: 30px; height: 55px; box-shadow: 0 0 5px;"><i class="bi bi-arrow-down"></i></button>
                </div>
                <div class="col-md-5">

                    <div class="row">
                        <div class="col-sm-6 mt-4" style="justify-content: end; align-items: end; display: flex; ">
                            <img src="assets/image1.png" class="img-thumbnail" style="border: none;" alt="...">
                        </div>
                        <div class="col-sm-6" style=" border: none;">
                            <img src="assets/image-3.png" class="img-thumbnail" style="border: none;" alt="...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mt-4" style="justify-content: end; align-items: end; display: flex;">
                            <img src="assets/image-2.png" class="img-thumbnail" style="border: none;" alt="...">
                        </div>
                        <div class="col-sm-6" style=" border: none;">
                            <img src="assets/image-1.png" class="img-thumbnail" style="border: none;" alt="...">
                        </div>
                    </div>
                    <h3 class="sub-title mt-5">
                        How <a style="color: #BB8446;">can we</a> help you ? <img src="assets/caution-icon.png"
                            class="img-thumbnail"
                            style="border: none; background-color: transparent; width: 70px; justify-content: center; align-items: center;"
                            alt="...">
                    </h3>
                    <p class="mt-5" style="width: 75%;">
                        We work with world-class experts to create wellbeing human centered tools and courses unite
                        sustainable growth.
                    </p>
                    <p style="width: 70%;">
                        We take data-driven decisions around your wellbeing strategy.
                    </p>
                    <a href="" type="button" class="btn btn-dark mt-3 mr-3" style="border-radius: 25px; background-color: black;">Get Help ></a>
                    <a href="logout.php" type="button" class="btn btn-dark mt-3" style="border-radius: 25px; background-color: black;">Logout ></a>
                </div>
            </div>
        </div>
    </section>
<?php 
    include './inc/inc_footer.php'; 
?>