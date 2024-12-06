<form class="search-form mt-3">
    <div class="row">
        <!-- I'm looking for a -->
        <div class="col-12 col-md-3">
            <label for="lookingFor" class="form-label text-start d-block mb-0">I'm looking for a</label>
            <select id="lookingFor" name="lookingFor" class="form-select" aria-label="I'm looking for a">
                <!-- <option selected disabled>Choose...</option> -->
                <option value="woman">Woman</option>
                <option value="man">Man</option>
            </select>
        </div>

        <!-- Aged from -->
        <div class="col-6 col-md-1">
            <label for="ageFrom" class="form-label text-start d-block mb-0">aged</label>
            <select id="ageFrom" name="ageFrom" class="form-select" aria-label="Age from"></select>
        </div>

        <!-- To age -->
        <div class="col-6 col-md-1">
            <label for="ageTo" class="form-label text-start d-block mb-0">&nbsp;</label>
            <select id="ageTo" name="ageTo" class="form-select" aria-label="Age to"></select>
        </div>

        <!-- Fetch religions and display them in a select box -->
        <?php
        // Fetch religions
        $religions = getReligions($conn);
        ?>

        <!-- Of religion -->
        <div class="col-6 col-md-2">
            <label for="religion" class="form-label text-start d-block mb-0">of religion</label>
            <select name="religion" class="form-select" aria-label="Religion">
                <option selected disabled>Religion</option>
                <?php foreach ($religions as $religion): ?>
                    <option value="<?php echo htmlspecialchars($religion['religion_name']); ?>">
                        <?php echo htmlspecialchars($religion['religion_name']); ?>
                    </option>
                <?php endforeach; ?>
                <!-- Option for 'Other' -->
                <option value="Other">Other</option>
            </select>
        </div>

        <?php

        // Get all countries
        $countries = getCountries($conn);
        ?>

        <!-- Country selection dropdown in your form -->
        <div class="col-6 col-md-3">
            <label for="country" class="form-label text-start d-block mb-0">and living in</label>
            <select name="country" class="form-select" aria-label="Country">
                <option selected disabled>Select Country</option>
                <?php foreach ($countries as $country): ?>
                    <option value="<?php echo htmlspecialchars($country['country_code']); ?>">
                        <?php echo htmlspecialchars($country['country_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>


        <!-- Submit Button -->
        <div class="col-12 col-md-2 d-flex align-items-end mt-3">
            <a href="<?php echo homeURL(); ?>/auth/login.php" class="btn btn-primary w-100">
                Let's Begin
            </a>
        </div>
    </div>
</form>