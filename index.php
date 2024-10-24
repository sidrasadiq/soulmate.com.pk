

    <!-- Header Section -->
     <?php  include("header.php")?>

    <!-- Simple Section -->
    <section class="hero">
        <div class="hero-content">
            <h2>Find the Perfect Life Partner</h2>
            <p>Connect with your soul mate that can be nearby or within your city. </p>
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
    </section>


    <section class="info-section">
        <div class="info-block">
            <img src="assest/Icon 1.png" alt="User Icon" class="icon">
            <p>Millions of people register on Soulmate.com looking for someone special. This site is for serious singles looking for a long-lasting relationship.</p>
        </div>
        <div class="info-block">
            <img src="assest/Icon 2.png" alt="Education Icon" class="icon">
            <p>80% of our members are highly educated. Most of them are successful professionals in their selected fields.</p>
        </div>
        <div class="info-block">
            <img src="assest/Icon 3.png" alt="Matchmaking Icon" class="icon">
            <p>soulmate.com uses a smart matchmaking system. We present you matches based on current location, education level, & lifestyle choices.</p>
        </div>
    </section>



    <section class="browse-section">
        <h2>BROWSE MATRIMONIAL PROFILES</h2>
        <div class="browse-categories">
            <div class="category">
                <h3>RELIGION</h3>
                <p><a href="#">Hindu</a> | <a href="#">Muslim</a> | <a href="#">Christian</a> | <a href="#">Sikh</a> | <a href="#">Buddhist</a> | <a href="#">Jain</a></p>
                <button class="read-more">READ MORE</button>
            </div>
            <div class="category">
                <h3>CASTE</h3>
                <p><a href="#">Agarwal</a> | <a href="#">Arora</a> | <a href="#">Brahmin</a> | <a href="#">Gupta</a> | <a href="#">Khatri</a> | <a href="#">Iyer</a> | <a href="#">Kayastha</a> | <a href="#">Maratha</a> | <a href="#">Rajput</a> | <a href="#">Sunni</a> | <a href="#">Swetambar</a></p>
                <button class="read-more">READ MORE</button>
            </div>
            <div class="category">
                <h3>STATES</h3>
                <p><a href="#">California</a> | <a href="#">New York</a> | <a href="#">Texas</a> | <a href="#">New Jersey</a> | <a href="#">Virginia</a> | <a href="#">Illinois</a> | <a href="#">Florida</a> | <a href="#">Pennsylvania</a> | <a href="#">Michigan</a> | <a href="#">Georgia</a></p>
                <button class="read-more">READ MORE</button>
            </div>
        </div>
    </section>





    <!-- Footer Section -->
   <?php   include("footer.php")?>

</body>
</html>

