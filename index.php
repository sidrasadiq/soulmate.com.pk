<?php include 'includes/main.php'; ?>
<?php include 'includes/functions.php'; ?>

<head>
  <title>Soulmate</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include 'includes/head-css.php'; ?>
</head>

<body>
  <!-- Navbar Start-->
  <nav class="navbar navbar-expand fixed-top">
    <div class="container">
      <a class="navbar-brand me-auto" href="<?php echo homeURL(); ?>"><img src='assets/images/logo.png'></a>
      <a href="login.php" class="log-in-button me-3">Log In</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a href="signup.php" class="sign-up-button">Join Us</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>
  <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/images/Slider new 1.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption  d-md-block">
          <h1>Find the Perfect Life Partner</h1>
          <h5>Connect with your soul mate that can be nearby or within your city.</h5>
          <?php include 'includes/slider-form.php'; ?>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/images/SLIDERS SOULMATE 2.png" class="d-block w-100" alt="...">
        <div class="carousel-caption  d-md-block">
          <h1>Find the Perfect Life Partner</h1>
          <h5>Connect with your soul mate that can be nearby or within your city.</h5>
          <?php include 'includes/slider-form.php'; ?>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/images/SLIDERS SOULMATE 3.png" class="d-block w-100" alt="...">
        <div class="carousel-caption  d-md-block">
          <h1>Find the Perfect Life Partner</h1>
          <h5>Connect with your soul mate that can be nearby or within your city.</h5>
          <?php include 'includes/slider-form.php'; ?>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <section class="about my-3">
    <div class="container">
      <h1 class=text-center data-aos="fade-right" data-aos-offset="200">
        About <span class="text-primary"> Us </span>
      </h1>
      <hr class="w-25 m-auto" />
      <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6 col-12 " data-aos="zoom-in" data-aos-offset="200">

          <h1> What do you <span class="text-primary color-black"> want to know </h1>
          <p class="p-2">
            At Soulmate Matrimony, we believe that finding the
            right life partner is one of the most important decisions in life.
            Our mission is to help individuals discover their perfect
            match through a trusted and personalized matchmaking experience.
            With a focus on genuine connections, we provide a safe and
            supportive platform where individuals from diverse backgrounds can meet,
            communicate, and build meaningful relationships. Whether you're seeking
            companionship, friendship, or a lifelong partner, Soulmate
            Matrimony is dedicated to guiding you on your journey to love and happiness.

            Why join Soulmate Matrimony?
            Because we offer more than just a matchmaking service—we offer a
            personalized approach to help you find a meaningful, lasting connection. Our platform is designed to make your search for the perfect partner as smooth and secure as possible, with verified profiles and user-friendly tools to help you
            connect with individuals who share your values, interests,
            and relationship goals. Whether you’re looking for a life partner
            or a deep connection, Soulmate Matrimony provides the support
            and resources you need to take the next step in your journey towards
            love.</p>
          <button type="button" class="btn btn-primary">More About Us</button>


          <div class="accordion p-2" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Is it safe to join Soulmate?
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  Yes! We prioritize the safety and security of our members, with robust privacy measures to protect personal information.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  What makes Soulmate different?
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  We use a unique algorithm and thorough profile verification to help you connect with the right matches for a genuine relationship.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  How do I find a match on your platform?
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  By completing a detailed profile, our platform matches you with individuals based on compatibility, shared interests, and values.
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-12 m-auto text-end" data-aos="fade-left" data-aos-offset="200">
          <img src="assets/images/download (3).jpg" class="img-fluid img-thumbnail">
        </div>
      </div>
    </div>
  </section>
  <section class="services my-6">
        <div class="container ">
                <h1 class=text-center data-aos="fade-left" data-aos-offset="200">
                Our <span class="text-primary"> Services </span>
                <hr / class="w-25 m-auto" >
                </h1>

                <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-left" data-aos-offset="200">

                                    <div class="card">
                                            <div class="card-body">
                                                <i class="fa fa-user bg-primary p-2 text-white rounded mb-2"></i>
                                                <h5 class="card-title">Profile Verification</h5>
                                                <p class="card-text">Ensure authenticity with verified profiles, minimizing fake accounts and creating a safer environment for all.</p>
                                                <a href="#" class="btn btn-primary">Join Us </a>
                                            </div>
                                    </div>
                            
                            </div>



                             <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-left" data-aos-offset="200">

                                    <div class="card bg-primary text-white">
                                            <div class="card-body">
                                            <i class="fa fa-heart bg-white p-2 text-dark rounded mb-2"></i>
                                                <h5 class="card-title">Personalized Matchmaking</h5>
                                                <p class="card-text">Our advanced algorithm pairs you with individuals who share your interests, goals, and values.</p>
                                                <a href="#" class="btn btn-primary bg-white text-dark">Join Us </a>
                                            </div>
                                    </div>
                            
                            </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-left" data-aos-offset="200">

                                    <div class="card">
                                            <div class="card-body">
                                            <i class="fa fa-comments bg-primary p-2 text-white rounded mb-2"></i>
                                                <h5 class="card-title">Communication Tools</h5>
                                                <p class="card-text">Engage through private messages, video calls, and live chats, helping you get to know potential matches better.</p>
                                                <a href="#" class="btn btn-primary">Join Us</a>
                                            </div>
                                    </div>

                                </div>
            </div>

            <div class="row mt-4">
                                <div class="col-sm-12 col-md-4 col-lg-4 col-12"data-aos="fade-right" data-aos-offset="200">

                                        <div class="card">
                                                <div class="card-body">
                                                <i class="fa fa-envelope bg-primary p-2 text-white rounded mb-2"></i>
                                                    <h5 class="card-title">Event Invitations</h5>
                                                    <p class="card-text">Receive invitations to exclusive matchmaking events where you can meet potential matches in a safe, comfortable setting.</p>
                                                    <a href="#" class="btn btn-primary">Join us</a>
                                                </div>
                                        </div>

                                 </div>


                                 <div class="col-sm-12 col-md-4 col-lg-4 col-12"data-aos="fade-right" data-aos-offset="200">

                                        <div class="card bg-primary text-white">
                                                <div class="card-body">
                                                <i class="fa fa-people-group bg-white p-2 text-dark rounded mb-2"></i>
                                                    <h5 class="card-title">Relationship Counseling</h5>
                                                    <p class="card-text">Our experienced counselors provide guidance to help you make confident relationship choices and navigate the matchmaking process.</p>
                                                    <a href="#" class="btn btn-primary bg-white text-dark">Join Us</a>
                                                </div>
                                        </div>

                                 </div>

                                 <div class="col-sm-12 col-md-4 col-lg-4 col-12"data-aos="fade-right" data-aos-offset="200">

                                        <div class="card">
                                                <div class="card-body">
                                                <i class="fa fa-shield-halved bg-primary p-2 text-white rounded mb-2"></i>
                                                    <h5 class="card-title">Privacy Protection</h5>
                                                    <p class="card-text">We maintain strict privacy controls, allowing you to control your information and decide when and with whom to share it.</p>
                                                    <a href="#" class="btn btn-primary">Join Us</a>
                                                </div>
                                        </div>

                                 </div>
                </div>

        </div>
</section>

  </section>
  <section class="Testimonials my-6">
    <div class="container mt-3">
      <h1 class=text-center data-aos="fade-left" data-aos-offset="200">
        Our <span class="text-primary"> Testimonials </span>
        <hr class="w-25 m-auto" />
      </h1>

      <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-left" data-aos-offset="200">

          <div class="card">
            <div class="card-body">
              <img src="assets/images/Singuppageimage.jpg" class="img-fluid img-thumbnail">

              <h5 class="card-title">Ahmed Khan</h5>
              <p class="card-text">I found my partner on Soulmate within a few months of joining. The matching process was easy, and the profiles were genuine. Highly recommended!</p>
              <a href="#" class="btn btn-primary">Join Now</a>
            </div>
          </div>

        </div>
        <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-up" data-aos-offset="200">
          <div class="card">
            <div class="card-body">
              <img src="assets/images/Testimonials2.png" class="img-fluid img-thumbnail">
              <h5 class="card-title">Fatima Ali</h5>
              <p class="card-text">Soulmate helped me connect with someone I wouldn’t have met otherwise. We bonded over shared values and now, we’re happily engaged!</p>
              <a href="#" class="btn btn-primary">Join Now</a>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-right" data-aos-offset="200">
          <div class="card">
            <div class="card-body">
              <img src="assets/images/Testimonials 3.png" class="img-fluid img-thumbnail">
              <h5 class="card-title">Sara Malik</h5>
              <p class="card-text">I was skeptical initially, but [Matrimony Site Name] exceeded my expectations. The support and security features made me feel comfortable finding my life partner.</p>
              <a href="#" class="btn btn-primary">Join Now</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
  <section class="Contact my-3">
    <div class="container ">
      <h1 class=text-center data-aos="fade-left" data-aos-offset="200">
        Contact <span class="text-primary"> Us </span>
      </h1>

      <hr class="w-25 m-auto" />
      <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6 col-12 mt-5" data-aos="fade-left" data-aos-offset="200">
          <form class="row g-3">
            <div class="col-md-6">
              <label for="inputEmail4" class="form-label">Email</label>
              <input type="email" class="form-control" id="inputEmail4">
            </div>
            <div class="col-md-6">
              <label for="inputPassword4" class="form-label">Password</label>
              <input type="password" class="form-control" id="inputPassword4">
            </div>
            <div class="col-12">
              <label for="inputAddress" class="form-label">Address</label>
              <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
            </div>
            <div class="col-12">
              <label for="inputAddress2" class="form-label">Address 2</label>
              <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
            </div>
            <div class="col-md-6">
              <label for="inputCity" class="form-label">City</label>
              <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="col-md-4">
              <label for="inputState" class="form-label">State</label>
              <select id="inputState" class="form-select">
                <option selected>Choose...</option>
                <option>...</option>
              </select>
            </div>
            <div class="col-md-2">
              <label for="inputZip" class="form-label">Zip</label>
              <input type="text" class="form-control" id="inputZip">
            </div>
            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck">
                <label class="form-check-label" for="gridCheck">
                  Check me out
                </label>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary">Sign in</button>
            </div>
          </form>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-12 m-auto text-end" data-aos="fade-right" data-aos-offset="200">
          <img src="assets/images/b95b0519-e9ed-46cd-9f93-2feb1ad79798.jpg" class="img-fluid img-thumbnail mt-5">
        </div>
      </div>
    </div>
    </div>
  </section>
  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/footer-scripts.php'; ?>

</body>

</html>