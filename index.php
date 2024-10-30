<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
   
    <!-- Bootstrap CSS Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Gooogle fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="styles.css">    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<title>Soulmate</title>
<link rel="icon" type="image/x-icon" href="assest/faviconicon.png">
  </head>

  <body>
    <!-- Navbar Start-->
    <nav class="navbar navbar-expand fixed-top">
    <div class="container">
    <a class="navbar-brand me-auto" href="#"><img src='assest/logo.png'></a>
    <a href="#" class="log-in-button me-3 mx-auto mx-md-0">Log In</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a href="#" class="sign-up-button d-none d-md-block">Join Us</a>
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
      <img src="assest/Slider new 1.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption  d-md-block">
        <h1>Find the Perfect Life Partner</h1>
        <h5>Connect with your soul mate that can be nearby or within your city.</h5>

        

        <form class="search-form mt-3">
        <div class="row g-2">
            <!-- I'm looking for a -->
            <div class="col-12 col-md-2">
                <select id="lookingFor" name="lookingFor" class="form-select" aria-label="I'm looking for a">
                    <option selected disabled>I'm looking for a</option>
                    <option value="woman">Woman</option>
                    <option value="man">Man</option>
                </select>
            </div>

            <!-- Aged from -->
            <div class="col-6 col-md-2">
                <select id="ageFrom" name="ageFrom" class="form-select" aria-label="Age from">
                    <option selected disabled>Age from</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                </select>
            </div>

            <!-- To age -->
            <div class="col-6 col-md-2">
                <select id="ageTo" name="ageTo" class="form-select" aria-label="Age to">
                    <option selected disabled>Age to</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                </select>
            </div>

            <!-- Of religion -->
            <div class="col-12 col-md-2">
                <select id="religion" name="religion" class="form-select" aria-label="Religion">
                    <option selected disabled>Religion</option>
                    <option value="islam">Islam</option>
                    <option value="christianity">Christianity</option>
                    <option value="hinduism">Hinduism</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <!-- And living in -->
            <div class="col-12 col-md-2">
                <select id="country" name="country" class="form-select" aria-label="Country">
                    <option selected disabled>Country</option>
                    <option value="pakistan">Pakistan</option>
                    <option value="india">India</option>
                    <option value="usa">USA</option>
                    <option value="uk">UK</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="col-12 col-md-2 d-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary w-100">Let's Begin</button>
            </div>
        </div>
    </form>
      </div>
    </div>
    <div class="carousel-item">
      <img src="assest/SLIDERS SOULMATE 2.png" class="d-block w-100" alt="...">
      <div class="carousel-caption  d-md-block">
      <h1>Find the Perfect Life Partner</h1>
      <h5>Connect with your soul mate that can be nearby or within your city.</h5>
        
      <form class="search-form mt-3">
        <div class="row g-2">
            <!-- I'm looking for a -->
            <div class="col-12 col-md-2">
                <select id="lookingFor" name="lookingFor" class="form-select" aria-label="I'm looking for a">
                    <option selected disabled>I'm looking for a</option>
                    <option value="woman">Woman</option>
                    <option value="man">Man</option>
                </select>
            </div>

            <!-- Aged from -->
            <div class="col-6 col-md-2">
                <select id="ageFrom" name="ageFrom" class="form-select" aria-label="Age from">
                    <option selected disabled>Age from</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                </select>
            </div>

            <!-- To age -->
            <div class="col-6 col-md-2">
                <select id="ageTo" name="ageTo" class="form-select" aria-label="Age to">
                    <option selected disabled>Age to</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                </select>
            </div>

            <!-- Of religion -->
            <div class="col-12 col-md-2">
                <select id="religion" name="religion" class="form-select" aria-label="Religion">
                    <option selected disabled>Religion</option>
                    <option value="islam">Islam</option>
                    <option value="christianity">Christianity</option>
                    <option value="hinduism">Hinduism</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <!-- And living in -->
            <div class="col-12 col-md-2">
                <select id="country" name="country" class="form-select" aria-label="Country">
                    <option selected disabled>Country</option>
                    <option value="pakistan">Pakistan</option>
                    <option value="india">India</option>
                    <option value="usa">USA</option>
                    <option value="uk">UK</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="col-12 col-md-2 d-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary w-100">Let's Begin</button>
            </div>
        </div>
    </form>
      </div>
    </div>
    <div class="carousel-item">
      <img src="assest/SLIDERS SOULMATE 3.png" class="d-block w-100" alt="...">
      <div class="carousel-caption  d-md-block">
      <h1>Find the Perfect Life Partner</h1>
      <h5>Connect with your soul mate that can be nearby or within your city.</h5>
      <form class="search-form mt-3">
        <div class="row g-2">
            <!-- I'm looking for a -->
            <div class="col-12 col-md-2">
                <select id="lookingFor" name="lookingFor" class="form-select" aria-label="I'm looking for a">
                    <option selected disabled>I'm looking for a</option>
                    <option value="woman">Woman</option>
                    <option value="man">Man</option>
                </select>
            </div>

            <!-- Aged from -->
            <div class="col-6 col-md-2">
                <select id="ageFrom" name="ageFrom" class="form-select" aria-label="Age from">
                    <option selected disabled>Age from</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                </select>
            </div>

            <!-- To age -->
            <div class="col-6 col-md-2">
                <select id="ageTo" name="ageTo" class="form-select" aria-label="Age to">
                    <option selected disabled>Age to</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                </select>
            </div>

            <!-- Of religion -->
            <div class="col-12 col-md-2">
                <select id="religion" name="religion" class="form-select" aria-label="Religion">
                    <option selected disabled>Religion</option>
                    <option value="islam">Islam</option>
                    <option value="christianity">Christianity</option>
                    <option value="hinduism">Hinduism</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <!-- And living in -->
            <div class="col-12 col-md-2">
                <select id="country" name="country" class="form-select" aria-label="Country">
                    <option selected disabled>Country</option>
                    <option value="pakistan">Pakistan</option>
                    <option value="india">India</option>
                    <option value="usa">USA</option>
                    <option value="uk">UK</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="col-12 col-md-2 d-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary w-100">Let's Begin</button>
            </div>
        </div>
    </form>
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
        <div class="container ">
                <h1 class=text-center data-aos="fade-right" data-aos-offset="200">
                About <span class="text-primary"> Us </span>
                </h1>
                
                 <hr / class="w-25 m-auto" >
       


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

                            <img src="assest/download (3).jpg" class= "img-fluid img-thumbnail">
                            
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




<section class="Testimonials my-6">
        <div class="container mt-3">
                <h1 class=text-center data-aos="fade-left" data-aos-offset="200">
                Our  <span class="text-primary"> Testimonials </span>
                <hr / class="w-25 m-auto" >
                </h1>

                <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-left" data-aos-offset="200">

                                    <div class="card">
                                            <div class="card-body">
                                            <img src="assest/Singuppageimage.jpg" class= "img-fluid img-thumbnail">
                                                
                                                <h5 class="card-title">Ahmed Khan</h5>
                                                <p class="card-text">I found my partner on Soulmate within a few months of joining. The matching process was easy, and the profiles were genuine. Highly recommended!</p>
                                                <a href="#" class="btn btn-primary">Join Now</a>
                                            </div>
                                    </div>
                            
                            </div>



                             <div class="col-sm-12 col-md-4 col-lg-4 col-12"data-aos="fade-up" data-aos-offset="200">

                             <div class="card">
                                            <div class="card-body">
                                            <img src="assest/Testimonials2.png" class= "img-fluid img-thumbnail">
                                                
                                                <h5 class="card-title">Fatima Ali</h5>
                                                <p class="card-text">Soulmate helped me connect with someone I wouldn’t have met otherwise. We bonded over shared values and now, we’re happily engaged!</p>
                                                <a href="#" class="btn btn-primary">Join Now</a>
                                            </div>
                                    </div>
                            </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-12"data-aos="fade-right" data-aos-offset="200">

                                <div class="card">
                                            <div class="card-body">
                                            <img src="assest/Testimonials 3.png" class= "img-fluid img-thumbnail">
                                                
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
                
                 <hr / class="w-25 m-auto" >
       


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

                        <div class="col-sm-12 col-md-6 col-lg-6 col-12 m-auto text-end"data-aos="fade-right" data-aos-offset="200">

                        <img src="assest/b95b0519-e9ed-46cd-9f93-2feb1ad79798.jpg" class= "img-fluid img-thumbnail mt-5">

                        </div>
                 </div>


                 </div>



</div>
</section>

    <!-- <section class="p-70">
        <h2 class="text-center text-para"> Body  </h2>
        <footer>
            <div class="py-6 bg-gray">
              <div></div>

            </div>

        </footer>
    </section> -->



    <!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row text-center text-md-start">
            <!-- About Us Section -->
            <div class="col-md-3">
            <a class="navbar-brand me-auto" href="#"><img src='assest/logo.png'></a>
                <p>Soulmate is a trusted platform dedicated to helping individuals find their life partners in a secure, respectful environment. </p>
            </div>
            <!-- Let Us Help Section -->
            <div class="col-md-3">
                <h5>Helpful Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>
            <!-- Make Money Section -->
            <div class="col-md-3">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Success Stories</a></li>
                    <li><a href="#">Events</a></li>
                    <li><a href="#">Testimonials</a></li>
                    <li><a href="#">Help & Support</a></li>
                </ul>
            </div>
            <!-- Contact Section -->
            <div class="col-md-3">
                <h5>CONTACT</h5>
                <ul class="list-unstyled">
                    <li><i class="fa-solid fa-location-dot"></i> New York, NY 2333, US</li>
                    <li><i class="fa-regular fa-envelope"></i> theproviders98@gmail.com</li>
                    <li><i class="fa-brands fa-whatsapp"></i> +12 3456789</li>
                    <li><i class="fa-solid fa-phone"></i> +12 3456789</li>
                </ul>
            </div>
        </div>
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>Copyright ©2020 All rights reserved by <a href="#" class="text-decoration-none">The Providers</a></p>
            <div class="social-icons">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>
    </div>
</footer> 





<script>
    window.addEventListener('scroll', () => { 
        document.querySelector('.navbar').style.top = (window.pageYOffset === 0) ? '0' : '-56px';
    });
</script>


<!-- <div class="container-fluid bg-primary text-white text-center p-1 fs-4"> Developed By The Millionaire Soft.   </div> -->
<!-- Bootstrap Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
 <!-- Bootstrap Java Scripts -->
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
 
 
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  AOS.init();
</script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  </body>
</html>