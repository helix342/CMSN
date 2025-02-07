<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Placement Cell</title>
    <link rel="icon" type="image/png" sizes="32x32" href="image/icons/mkce_s.png">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Rubik:wght@300;400;500;700&family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="container">
        <div class="login-wrapper">
            <!-- Tab Navigation -->
            <ul class="nav nav-pills" id="loginTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="placementOfficerTab" data-bs-toggle="pill" href="#placementOfficer" role="tab" aria-controls="placementOfficer" aria-selected="true">Placement Officer</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="studentTab" data-bs-toggle="pill" href="#student" role="tab" aria-controls="student" aria-selected="false">Student</a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="loginTabsContent">
                <!-- Placement Officer Tab -->
                <div class="tab-pane fade show active" id="placementOfficer" role="tabpanel" aria-labelledby="placementOfficerTab">
                    <form action="/placement-officer-login" method="POST" class="login-form">
                        <h3 class="text-center">Placement Officer Login</h3>
                        <div class="mb-3">
                            <label for="officerUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="officerUsername" name="officerUsername" required>
                        </div>
                        <div class="mb-3">
                            <label for="officerPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="officerPassword" name="officerPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>

                <!-- Student Tab -->
                <div class="tab-pane fade" id="student" role="tabpanel" aria-labelledby="studentTab">
                    <form action="/student-login" method="POST" class="login-form">
                        <h3 class="text-center">Student Login</h3>
                        <div class="mb-3">
                            <label for="studentUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="studentUsername" name="studentUsername" required>
                        </div>
                        <div class="mb-3">
                            <label for="studentPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="studentPassword" name="studentPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
