<footer class="page-footer">
        <div class="container-wrap3 pb-25">
            <!-- <div class="row mb-0">
                <div class="col l12 m12  s12">
                    <h5 class="center-align subscribe-heading">SUBSCRIBE NOW FOR UPDATES</h5>
                </div>
            </div> -->
            <!-- <div class="row mb-0">
                <div class="col  l12 m12  s12">
                    <div class="newsletter-box">
                        <form>
                            <div class="row mb-0">
                                <div class="input-field col offset-l3 l6 offset-m2 m6 s7">
                                    <input placeholder="Enter Your Email" id="subscribe-input" type="text"
                                        class="validate">
                                </div>
                                <button class="waves-effect waves-light btn subscribe-button">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->
            <div class="row mb-0">
                <div class="col l4 m4  s12">
                    <h6 class="center-align">Useful Links</h6>
                    <ul class="center-align useful-links">
                        <li class="white-text"><a class="white-text" href="#!">Contact Us</a> | </li>
                        <li class="white-text"><a class="white-text" href="#!">About Us</a> | </li>
                        <li class="white-text"><a class="white-text" href="#!">Refer & Earn</a> | </li>
                        <li class="white-text"><a class="white-text" href="#!">Product & Service</a> |
                        </li>
                    </ul>
                </div>
                <div class="col l4 m4 s12">
                    <h6 class="center-align white-text">Follow Us</h6>
                    <ul class=" center-align social-icons">
                        <li><a class="btn-floating facebook btn-small waves-effect waves-light "><i
                                    class="fab fa-facebook-f"></i></a></li>
                        <li><a class="btn-floating twitter btn-small waves-effect waves-light "><i
                                    class="fab fa-twitter"></i></a></li>

                        <li><a class="btn-floating youtube btn-small waves-effect waves-light "><i
                                    class="fab fa-youtube "></i></a></li>

                        <li><a class="btn-floating instagram btn-small waves-effect waves-light "><i class="fab fa-linkedin-in"></i>
                            </a></li>
                    </ul>
                </div>
                <div class="col l4 m4 s12">
                    <h6 class="center-align white-text">Address</h6>
                    <p class="footer-address white-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos
                        animi, eveniet hic aliquid </p>
                </div>
            </div>
        </div>
        </div>
        <div class="footer-copyright ">
            <div class="container-wrap3">
                <center>  
                <span class="copry-right">© <?php echo date('Y') ?> Smart Link, All Rights Reserved. Developed By <a
                        target="_blank" href="http://www.5ines.com/">5ine</a></span></center>
            </div>
        </div>
    </footer>

    <?php if($this->session->flashdata('success')){ ?>
	<div id="popup1" class="overlay-popup">
		<div class="popup text-center">
			<i class="fa fa-check-circle text-success model-icon"></i>
			<h2 class="text-success mb15">Success</h2>
			<a class="close close-model" href="#">&times;</a>
			<div class="content">
				<p><?php echo $this->session->flashdata('success') ?></p>
			</div>
		</div>
	</div>
<?php } ?>


<?php if($this->session->flashdata('error')){ ?>
	<div id="popup1" class="overlay-popup">
		<div class="popup text-center">
			<i class="fa fa-times text-danger model-icon"></i>
			<h2 class="text-danger mb15">Error</h2>
			<a class="close close-model" href="#">&times;</a>
			<div class="content">
				<p><?php echo $this->session->flashdata('error') ?></p>
			</div>
		</div>
	</div>
<?php } ?>