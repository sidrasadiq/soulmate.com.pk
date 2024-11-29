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
            <a href="<?php echo homeURL(); ?>/auth/login.php" class="btn btn-primary w-100">
                Let's Begin <!-- <button type="submit" class="btn btn-primary w-100">Let's Begin</button> -->
            </a>
        </div>
    </div>
</form>