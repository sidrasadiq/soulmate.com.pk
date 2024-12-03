<footer class="footer">
    <!-- Floating Buttons -->
    <div class="floating-buttons">
        <!-- WhatsApp Button -->
        <a href="https://wa.me/923032666675" target="_blank" class="floating-btn whatsapp-btn" title="Chat on WhatsApp">
            <img src="assets/icons/whatsapp-icon.png" height="24px" alt="WhatsApp" />
        </a>
        <!-- Call Now Button -->
        <a href="tel:+923032666675" class="floating-btn call-btn" title="Call Now">
            <img src="assets/icons/phone.png" height="24px" alt="Call Now" />
        </a>
    </div>

    <!-- Add to your existing CSS or a new CSS file -->
    <style>
        /* Style for the floating buttons container */
        .floating-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            /* Space between buttons */
            z-index: 1000;
            /* Ensure it stays on top */
        }

        /* Style for each button */
        .floating-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background-color: white;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease, background-color 0.3s;
        }

        .floating-btn:hover {
            transform: scale(1.1);
            background-color: #f5f5f5;
        }

        /* WhatsApp button specific styling */
        .whatsapp-btn {
            background-color: #25d366;
        }

        .whatsapp-btn:hover {
            background-color: #1ebe57;
        }

        /* Call button specific styling */
        .call-btn {
            background-color: #007bff;
        }

        .call-btn:hover {
            background-color: #0056b3;
        }

        /* Icon inside button */
        .floating-btn img {
            width: 50%;
            height: auto;
        }
    </style>

    <div class="container">
        <div class="row text-center text-md-start">
            <!-- About Us Section -->
            <div class="col-md-3">
                <a class="navbar-brand me-auto" href="#"><img src="../assets/images/logo.png"></a>
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
                    <li><i class="fa-solid fa-location-dot"></i> Main College Road Town <br> Ship Lahore</li>
                    <li><i class="fa-regular fa-envelope"></i> info@soulmate.com.pk </li>
                    <li><i class="fa-brands fa-whatsapp"></i> +923032666675 </li>
                    <li><i class="fa-solid fa-phone"></i> +923032666675</li>
                </ul>
            </div>
        </div>
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>Copyright ©2020 All rights reserved by <a href="https://themillionairesoft.com/" class="text-decoration-none">The Millionaire Soft.</a></p>
            <div class="social-icons">
                <a href="https://web.facebook.com/soulmatemetrimony"><i class="fa-brands fa-facebook"></i></a>
                <!-- <a href="#"><i class="fa-brands fa-twitter"></i></a> -->
                <a href="https://www.instagram.com/soulmatemetrimonypakistan/"><i class="fa-brands fa-instagram"></i></a>
                <!-- <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a> -->
            </div>
        </div>
    </div>

</footer>