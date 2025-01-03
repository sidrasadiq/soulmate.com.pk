<?php include 'includes/main.php'; ?>
<?php include 'includes/config.php'; ?>
<?php include 'includes/functions.php'; ?>

<head>
  <title>Soulmate</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include 'includes/head-css.php'; ?>
</head>
<style>
  .text-primary {
    color: #ce478b !important;
  }

  .btn-primary {
    background-color: #3987cc !important;
  }

  .bg-primary {
    background-color: #ce478b !important;

  }
</style>

<body>

  <!-- Navbar Start-->
  <?php include 'includes/header.php'; ?>
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
      <!-- <div class="carousel-item">
        <img src="assets/images/Sliders 22 wedding.png" class="d-block w-100" alt="...">
        <div class="carousel-caption  d-md-block">
          <h1>Find the Perfect Life Partner</h1>
          <h5>Connect with your soul mate that can be nearby or within your city.</h5>
          <?php // include 'includes/slider-form.php'; 
          ?>
        </div>
      </div> -->
      <!-- <div class="carousel-item">
        <img src="assets/images/SLIDERS SOULMATE 3.png" class="d-block w-100" alt="...">
        <div class="carousel-caption  d-md-block">
          <h1>Find the Perfect Life Partner</h1>
          <h5>Connect with your soul mate that can be nearby or within your city.</h5>
          <?php // include 'includes/slider-form.php'; 
          ?>
        </div>
      </div>
    </div> -->
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
            <a href="auth/signup.php">
              <button type="button" class="btn btn-primary">More About Us</button>
            </a>

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
          <hr class="w-25 m-auto" />
        </h1>

        <div class="row">
          <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-left" data-aos-offset="200">

            <div class="card">
              <div class="card-body">
                <i class="fa fa-user bg-primary p-2 text-white rounded mb-2"></i>
                <h5 class="card-title">Profile Verification</h5>
                <p class="card-text">Ensure authenticity with verified profiles, minimizing fake accounts and creating a safer environment for all.</p>
                <a href="auth/signup.php" class="btn btn-primary">Join Us </a>
              </div>
            </div>
          </div>

          <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-left" data-aos-offset="200">

            <div class="card bg-primary text-white">
              <div class="card-body">
                <i class="fa fa-heart bg-white p-2 text-dark rounded mb-2"></i>
                <h5 class="card-title">Personalized Matchmaking</h5>
                <p class="card-text">Our advanced algorithm pairs you with individuals who share your interests, goals, and values.</p>
                <a href="auth/signup.php" class="btn btn-white bg-white text-dark">Join Us </a>
              </div>
            </div>

          </div>
          <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-left" data-aos-offset="200">

            <div class="card">
              <div class="card-body">
                <i class="fa fa-comments bg-primary p-2 text-white rounded mb-2"></i>
                <h5 class="card-title">Communication Tools</h5>
                <p class="card-text">Engage through private messages, video calls, and live chats, helping you get to know potential matches better.</p>
                <a href="auth/signup.php" class="btn btn-primary">Join Us</a>
              </div>
            </div>

          </div>
        </div>

        <div class="row mt-4">
          <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-right" data-aos-offset="200">

            <div class="card">
              <div class="card-body">
                <i class="fa fa-envelope bg-primary p-2 text-white rounded mb-2"></i>
                <h5 class="card-title">Event Invitations</h5>
                <p class="card-text">Receive invitations to exclusive matchmaking events where you can meet potential matches in a safe, comfortable setting.</p>
                <a href="auth/signup.php" class="btn btn-primary">Join us</a>
              </div>
            </div>

          </div>


          <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-right" data-aos-offset="200">

            <div class="card bg-primary text-white">
              <div class="card-body">
                <i class="fa fa-people-group bg-white p-2 text-dark rounded mb-2"></i>
                <h5 class="card-title">Relationship Counseling</h5>
                <p class="card-text">Our experienced counselors provide guidance to help you make confident relationship choices and navigate the matchmaking process.</p>
                <a href="auth/signup.php" class="btn btn-white bg-white text-dark">Join Us</a>
              </div>
            </div>

          </div>

          <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-right" data-aos-offset="200">

            <div class="card">
              <div class="card-body">
                <i class="fa fa-shield-halved bg-primary p-2 text-white rounded mb-2"></i>
                <h5 class="card-title">Privacy Protection</h5>
                <p class="card-text">We maintain strict privacy controls, allowing you to control your information and decide when and with whom to share it.</p>
                <a href="auth/signup.php" class="btn btn-primary">Join Us</a>
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
                <a href="auth/signup.php" class="btn btn-primary">Join Now</a>
              </div>
            </div>

          </div>
          <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-up" data-aos-offset="200">
            <div class="card">
              <div class="card-body">
                <img src="assets/images/Testimonials2.png" class="img-fluid img-thumbnail">
                <h5 class="card-title">Fatima Ali</h5>
                <p class="card-text">Soulmate helped me connect with someone I wouldn’t have met otherwise. We bonded over shared values and now, we’re happily engaged!</p>
                <a href="auth/signup.php" class="btn btn-primary">Join Now</a>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-right" data-aos-offset="200">
            <div class="card">
              <div class="card-body">
                <img src="assets/images/Testimonials 3.png" class="img-fluid img-thumbnail">
                <h5 class="card-title">Sara Malik</h5>
                <p class="card-text">I was skeptical initially, but [Matrimony Site Name] exceeded my expectations. The support and security features made me feel comfortable finding my life partner.</p>
                <a href="auth/signup.php" class="btn btn-primary">Join Now</a>
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
          <div class="card p-4 shadow-sm">
            <form action="process_contact_form.php" method="POST" id="contactForm">
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name" required>
                </div>

                <div class="col-md-6">
                  <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name" required>
                </div>

                <div class="col-md-12">
                  <label for="city" class="form-label">City Name</label>
                  <input type="text" class="form-control" id="city" name="city" placeholder="City">
                </div>
              </div>

              <div class="row g-3 my-3">
                <div class="col-md-6">
                  <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="col-md-6">
                  <label for="telephone" class="form-label">Telephone</label>
                  <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Telephone">
                </div>
              </div>

              <div class="mb-3">
                <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
              </div>

              <div class="mb-3">
                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Message" required></textarea>
              </div>

              <div class="text-muted mb-3">
                <small>Note: Fields marked with <span class="text-danger">*</span> are required.</small>
              </div>

              <button type="submit" class="btn btn-primary w-100">Send Message</button>
            </form>

          </div>
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

  <script>
    $(document).ready(function() {
      // Function to populate age dropdowns dynamically
      function populateAgeDropdowns() {
        var ageFromSelect = document.getElementById("age_from");
        var ageToSelect = document.getElementById("age_to");

        // Clear previous options
        ageFromSelect.innerHTML = "";
        ageToSelect.innerHTML = "";

        // Add new options (18 to 75)
        for (var i = 18; i <= 75; i++) {
          var optionFrom = document.createElement("option");
          optionFrom.value = i;
          optionFrom.textContent = i;
          ageFromSelect.appendChild(optionFrom);

          var optionTo = document.createElement("option");
          optionTo.value = i;
          optionTo.textContent = i;
          ageToSelect.appendChild(optionTo);
        }
      }

      // Initialize age dropdowns on page load
      populateAgeDropdowns();

      // Reinitialize form fields when the carousel slide changes
      $('#carouselExampleCaptions').on('slide.bs.carousel', function() {
        populateAgeDropdowns(); // Re-populate the age dropdowns
      });
    });
  </script>
</body>

</html>