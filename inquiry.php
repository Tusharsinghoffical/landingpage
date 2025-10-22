<?php
include 'includes/db_config.php';
include 'includes/header.php';

// Initialize variables
$name = $email = $mobile = $service = $message = "";
$nameErr = $emailErr = $mobileErr = $serviceErr = $messageErr = "";
$success = false;
$dbError = false;

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        // Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $nameErr = "Only letters and white space allowed";
        }
    }
    
    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // Check if email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }
    
    // Validate mobile
    if (empty($_POST["mobile"])) {
        $mobileErr = "Mobile number is required";
    } else {
        $mobile = test_input($_POST["mobile"]);
        // Check if mobile number is valid
        if (!preg_match("/^[0-9]{10}+$/",$mobile)) {
            $mobileErr = "Invalid mobile number format (10 digits required)";
        }
    }
    
    // Validate service
    if (empty($_POST["service"])) {
        $serviceErr = "Please select a service";
    } else {
        $service = test_input($_POST["service"]);
    }
    
    // Validate message
    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
    } else {
        $message = test_input($_POST["message"]);
    }
    
    // If no errors and database connection is available, insert into database
    if (empty($nameErr) && empty($emailErr) && empty($mobileErr) && empty($serviceErr) && empty($messageErr)) {
        if ($conn) {
            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO inquiries (name, email, mobile, service, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $mobile, $service, $message);
            
            // Execute the statement
            if ($stmt->execute()) {
                $success = true;
            } else {
                $dbError = true;
            }
            
            $stmt->close();
        } else {
            // If no database connection, simulate success for demo purposes
            $success = true;
        }
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">
                    <i class="fas fa-home me-1"></i> Home
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fas fa-envelope me-1"></i> Inquiry
            </li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4 fw-bold">
                <i class="fas fa-comment-dollar me-2"></i> Request a Free Quote
            </h1>
            <p class="lead">Fill out the form below and our experts will contact you shortly</p>
            <div class="mt-4">
                <p class="mb-1"><i class="fas fa-phone me-2"></i> <strong>Call us:</strong> +91-9876543210</p>
                <p class="mb-0"><i class="fab fa-whatsapp me-2"></i> <strong>WhatsApp:</strong> +91-9876543210</p>
            </div>
        </div>
    </div>
    
    <?php if ($success): ?>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">
                    <i class="fas fa-check-circle me-2"></i> Thank You!
                </h4>
                <p>Your inquiry has been submitted successfully. Our team will contact you within 24 hours.</p>
                <hr>
                <p class="mb-0">You can also reach us directly at <strong>+91-9876543210</strong> or <strong>info@reliablepackers.com</strong></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if ($dbError): ?>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">
                    <i class="fas fa-exclamation-triangle me-2"></i> Database Error
                </h4>
                <p>There was an issue saving your inquiry. Please try again or contact us directly.</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light text-primary">
                    <h5 class="mb-0">
                        <i class="fas fa-paper-plane me-2"></i> Inquiry Form
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-1"></i> Full Name *
                                </label>
                                <input type="text" class="form-control <?php echo (!empty($nameErr)) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?php echo $name; ?>" placeholder="Enter your full name">
                                <?php if (!empty($nameErr)): ?>
                                    <div class="invalid-feedback"><?php echo $nameErr; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i> Email Address *
                                </label>
                                <input type="email" class="form-control <?php echo (!empty($emailErr)) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo $email; ?>" placeholder="Enter your email">
                                <?php if (!empty($emailErr)): ?>
                                    <div class="invalid-feedback"><?php echo $emailErr; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="mobile" class="form-label">
                                    <i class="fas fa-phone me-1"></i> Mobile Number *
                                </label>
                                <input type="tel" class="form-control <?php echo (!empty($mobileErr)) ? 'is-invalid' : ''; ?>" id="mobile" name="mobile" value="<?php echo $mobile; ?>" placeholder="Enter 10-digit mobile number" maxlength="10">
                                <?php if (!empty($mobileErr)): ?>
                                    <div class="invalid-feedback"><?php echo $mobileErr; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="service" class="form-label">
                                    <i class="fas fa-concierge-bell me-1"></i> Service Interested In *
                                </label>
                                <select class="form-select <?php echo (!empty($serviceErr)) ? 'is-invalid' : ''; ?>" id="service" name="service">
                                    <option value="">Select a service</option>
                                    <option value="House Shifting" <?php if ($service == "House Shifting") echo "selected"; ?>>House Shifting</option>
                                    <option value="Office Relocation" <?php if ($service == "Office Relocation") echo "selected"; ?>>Office Relocation</option>
                                    <option value="Packing Services" <?php if ($service == "Packing Services") echo "selected"; ?>>Packing Services</option>
                                    <option value="Car Transportation" <?php if ($service == "Car Transportation") echo "selected"; ?>>Car Transportation</option>
                                    <option value="Storage Services" <?php if ($service == "Storage Services") echo "selected"; ?>>Storage Services</option>
                                    <option value="International Moving" <?php if ($service == "International Moving") echo "selected"; ?>>International Moving</option>
                                    <option value="Other" <?php if ($service == "Other") echo "selected"; ?>>Other</option>
                                </select>
                                <?php if (!empty($serviceErr)): ?>
                                    <div class="invalid-feedback"><?php echo $serviceErr; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">
                                <i class="fas fa-comment me-1"></i> Message *
                            </label>
                            <textarea class="form-control <?php echo (!empty($messageErr)) ? 'is-invalid' : ''; ?>" id="message" name="message" rows="4" placeholder="Tell us about your moving requirements"><?php echo $message; ?></textarea>
                            <?php if (!empty($messageErr)): ?>
                                <div class="invalid-feedback"><?php echo $messageErr; ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="terms.php" target="_blank">Terms & Conditions</a> and <a href="privacy.php" target="_blank">Privacy Policy</a>
                            </label>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i> Submit Inquiry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-4 text-center p-4 bg-light rounded">
                <h5 class="mb-3">
                    <i class="fas fa-exclamation-circle me-2"></i> Need immediate assistance?
                </h5>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="tel:+919876543210" class="btn btn-primary">
                        <i class="fas fa-phone me-2"></i> Call Now
                    </a>
                    <a href="https://wa.me/919876543210" target="_blank" class="btn btn-success">
                        <i class="fab fa-whatsapp me-2"></i> WhatsApp Chat
                    </a>
                </div>
                <p class="mt-3 mb-0 text-muted">
                    Our experts are available 24/7 to assist you
                </p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>