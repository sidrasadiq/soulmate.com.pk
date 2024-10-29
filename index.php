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
        <a href="#" class="log-in-button me-3">Log In </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a href="#" class="sign-up-button">Sign Up </a>
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
        <h5>Find the Perfect Life Partner</h5>
        <p>Connect with your soul mate that can be nearby or within your city.</p>

        <form class="search-form">
            <label for="lookingFor">I'm looking for a</label>
            <select id="lookingFor" name="lookingFor">
                <option value="woman">Woman</option>
                <option value="man">Man</option>
            </select>

            <label for="ageFrom">aged</label>
            <select id="ageFrom" name="ageFrom">
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
            </select>

            <span>to</span>

            <select id="ageTo" name="ageTo">
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
            </select>

            <label for="religion">of religion</label>
            <select id="religion" name="religion">
                <option value="select">Select</option>
                <option value="islam">Islam</option>
                <option value="christianity">Christianity</option>
                <option value="hinduism">Hinduism</option>
                <option value="other">Other</option>
            </select>

            <label for="country">and living in</label>
            <select id="country" name="country">
                <option value="pakistan">Pakistan</option>
                <option value="india">India</option>
                <option value="usa">USA</option>
                <option value="uk">UK</option>
            </select>

            <button type="submit">Let's Begin</button>
        </form>
      </div>
    </div>
    <div class="carousel-item">
      <img src="assest/SLIDERS SOULMATE 2.png" class="d-block w-100" alt="...">
      <div class="carousel-caption  d-md-block">
        <h5>Find the Perfect Life Partner</h5>
        <p>Connect with your soul mate that can be nearby or within your city.</p>
        <form class="search-form">
            <label for="lookingFor">I'm looking for a</label>
            <select id="lookingFor" name="lookingFor">
                <option value="woman">Woman</option>
                <option value="man">Man</option>
            </select>

            <label for="ageFrom">aged</label>
            <select id="ageFrom" name="ageFrom">
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
            </select>

            <span>to</span>

            <select id="ageTo" name="ageTo">
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
            </select>

            <label for="religion">of religion</label>
            <select id="religion" name="religion">
                <option value="select">Select</option>
                <option value="islam">Islam</option>
                <option value="christianity">Christianity</option>
                <option value="hinduism">Hinduism</option>
                <option value="other">Other</option>
            </select>

            <label for="country">and living in</label>
            <select id="country" name="country">
                <option value="pakistan">Pakistan</option>
                <option value="india">India</option>
                <option value="usa">USA</option>
                <option value="uk">UK</option>
            </select>

            <button type="submit">Let's Begin</button>
        </form>
      </div>
    </div>
    <div class="carousel-item">
      <img src="assest/SLIDERS SOULMATE 3.png" class="d-block w-100" alt="...">
      <div class="carousel-caption  d-md-block">
        <h5>Find the Perfect Life Partner</h5>
        <p>Connect with your soul mate that can be nearby or within your city.</p>
        <form class="search-form">
            <label for="lookingFor">I'm looking for a</label>
            <select id="lookingFor" name="lookingFor">
                <option value="woman">Woman</option>
                <option value="man">Man</option>
            </select>

            <label for="ageFrom">aged</label>
            <select id="ageFrom" name="ageFrom">
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
            </select>

            <span>to</span>

            <select id="ageTo" name="ageTo">
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
            </select>

            <label for="religion">of religion</label>
            <select id="religion" name="religion">
                <option value="select">Select</option>
                <option value="islam">Islam</option>
                <option value="christianity">Christianity</option>
                <option value="hinduism">Hinduism</option>
                <option value="other">Other</option>
            </select>

            <label for="country">and living in</label>
            <select id="country" name="country">
                <option value="pakistan">Pakistan</option>
                <option value="india">India</option>
                <option value="usa">USA</option>
                <option value="uk">UK</option>
            </select>

            <button type="submit">Let's Begin</button>
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
        Accordion Item #1
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Accordion Item #2
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        Accordion Item #3
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
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
                                                <i class="fa fa-users bg-primary p-2 text-white rounded"></i>
                                                <h5 class="card-title">Special title treatment</h5>
                                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                <a href="#" class="btn btn-primary">Go somewhere</a>
                                            </div>
                                    </div>
                            
                            </div>



                             <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-left" data-aos-offset="200">

                                    <div class="card bg-primary text-white">
                                            <div class="card-body">
                                            <i class="fa fa-users bg-white p-2 text-dark rounded mb-2"></i>
                                                <h5 class="card-title">Special title treatment</h5>
                                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                <a href="#" class="btn btn-primary">Go somewhere</a>
                                            </div>
                                    </div>
                            
                            </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-12" data-aos="fade-left" data-aos-offset="200">

                                    <div class="card">
                                            <div class="card-body">
                                            <i class="fa fa-users bg-primary p-2 text-white rounded"></i>
                                                <h5 class="card-title">Special title treatment</h5>
                                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                <a href="#" class="btn btn-primary">Go somewhere</a>
                                            </div>
                                    </div>

                                </div>
            </div>

            <div class="row mt-4">
                                <div class="col-sm-12 col-md-4 col-lg-4 col-12"data-aos="fade-right" data-aos-offset="200">

                                        <div class="card">
                                                <div class="card-body">
                                                <i class="fa fa-users bg-primary p-2 text-white rounded"></i>
                                                    <h5 class="card-title">Special title treatment</h5>
                                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                                </div>
                                        </div>

                                 </div>


                                 <div class="col-sm-12 col-md-4 col-lg-4 col-12"data-aos="fade-right" data-aos-offset="200">

                                        <div class="card bg-primary text-white">
                                                <div class="card-body">
                                                <i class="fa fa-users bg-white p-2 text-dark rounded mb-2"></i>
                                                    <h5 class="card-title">Special title treatment</h5>
                                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                                </div>
                                        </div>

                                 </div>

                                 <div class="col-sm-12 col-md-4 col-lg-4 col-12"data-aos="fade-right" data-aos-offset="200">

                                        <div class="card">
                                                <div class="card-body">
                                                <i class="fa fa-users bg-primary p-2 text-white rounded"></i>
                                                    <h5 class="card-title">Special title treatment</h5>
                                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                    <a href="#" class="btn btn-primary">Go somewhere</a>
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
                                                
                                                <h5 class="card-title">Special title treatment</h5>
                                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                <a href="#" class="btn btn-primary">Go somewhere</a>
                                            </div>
                                    </div>
                            
                            </div>



                             <div class="col-sm-12 col-md-4 col-lg-4 col-12"data-aos="fade-up" data-aos-offset="200">

                             <div class="card">
                                            <div class="card-body">
                                            <img src="assest/Singuppageimage.jpg" class= "img-fluid img-thumbnail">
                                                
                                                <h5 class="card-title">Special title treatment</h5>
                                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                <a href="#" class="btn btn-primary">Go somewhere</a>
                                            </div>
                                    </div>
                            </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-12"data-aos="fade-right" data-aos-offset="200">

                                <div class="card">
                                            <div class="card-body">
                                            <img src="assest/Singuppageimage.jpg" class= "img-fluid img-thumbnail">
                                                
                                                <h5 class="card-title">Special title treatment</h5>
                                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                <a href="#" class="btn btn-primary">Go somewhere</a>
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

<script>
    window.addEventListener('scroll', () => { 
        document.querySelector('.navbar').style.top = (window.pageYOffset === 0) ? '0' : '-56px';
    });
</script>



<div class="container-fluid bg-primary text-white text-center p-1 fs-4"> Developed By The Millionaire Soft.   </div>
<!-- Bootstrap Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
 <!-- Bootstrap Java Scripts -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  AOS.init();
</script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  </body>
</html>