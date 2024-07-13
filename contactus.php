<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

    <?php include 'includes/navbar.php'; ?>

    <div class="content-wrapper">
        <div class="container">

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-sm-9">
                        <?php
                            if(isset($_SESSION['error'])){
                                echo "
                                    <div class='alert alert-danger'>
                                        ".$_SESSION['error']."
                                    </div>
                                ";
                                unset($_SESSION['error']);
                            }
                        ?>
                        <div class="container">
                            <section class="content animate-on-scroll">
                                <h4>Contact Us</h4>
                                <p class="text-center">Feel free to reach out to us with any questions or inquiries using the form below.</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="https://api.web3forms.com/submit" method="POST" autocomplete="off">
										<input type="hidden" name="access_key" value="d9334abf-a200-4ee2-b5fa-e00bca21f6ad">
                                            <div class="form-group">
                                                <label for="name">Your Name</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Your Email</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="message">Message</label>
                                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <!-- Additional content or sidebar if needed -->
                    </div>
                </div>
            </section>

        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>
