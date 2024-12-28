<form class="search-form mt-3 p-3" method="POST" action="auth/search-result.php">
    <div class="row">
        <!-- I'm looking for a -->
        <div class="col-12 col-md-3">
            <label for="seeking" class="form-label text-start d-block mb-1">I'm looking for a</label>
            <select id="seeking" name="seeking" class="form-select" aria-label="I'm looking for a">
                <!-- <option selected disabled>Choose...</option> -->
                <option value="female">Woman</option>
                <option value="male">Man </option>

            </select>
        </div>

        <!-- Aged from -->
        <div class="col-6 col-md-1">
            <label for="age_from" class="form-label text-start d-block mb-1">aged</label>
            <select id="age_from" name="age_from" class="form-select" aria-label="Age from"></select>
        </div>

        <!-- To age -->
        <div class="col-6 col-md-1">
            <label for="age_to" class="form-label text-start d-block mb-1">&nbsp;</label>
            <select id="age_to" name="age_to" class="form-select" aria-label="Age to"></select>
        </div>

        <!-- Fetch religions and display them in a select box -->
        <?php
        // Fetch religions
        $religions = getReligions($conn);
        ?>

        <!-- Of religion -->
        <div class="col-6 col-md-2">
            <label for="religion" class="form-label text-start d-block mb-1">of religion</label>
            <select name="religion" class="form-select" aria-label="Religion">
                <option selected disabled>Religion</option>
                <?php foreach ($religions as $religion): ?>
                    <option value="<?php echo htmlspecialchars($religion['religion_name']); ?>">
                        <?php echo htmlspecialchars($religion['religion_name']); ?>
                    </option>
                <?php endforeach; ?>
                <!-- Option for 'Other' -->
                <option value="any">Other</option>
            </select>
        </div>

        <?php

        // Get all countries
        $countries = getCountries($conn);
        ?>

        <!-- Country selection dropdown in your form -->
        <div class="col-6 col-md-3">
            <label for="country" class="form-label text-start d-block mb-1">and living in</label>
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