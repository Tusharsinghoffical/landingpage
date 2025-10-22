<?php include 'includes/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <div class="error-content">
                <h1 class="display-1 fw-bold text-danger">500</h1>
                <h2 class="mb-4">Internal Server Error</h2>
                <p class="lead mb-4">Sorry, something went wrong on our end. Our team has been notified and is working to resolve the issue.</p>
                
                <div class="mb-4">
                    <img src="assets/images/500.png" alt="Internal Server Error" class="img-fluid" style="max-width: 300px;">
                </div>
                
                <div class="mt-4">
                    <a href="index.php" class="btn btn-primary btn-lg me-3">Go Home</a>
                    <a href="inquiry.php" class="btn btn-outline-primary btn-lg">Report Issue</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>