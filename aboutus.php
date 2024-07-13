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
                                <h4>About Us</h4>
                                <p>Selamat datang di Shoe Mania, tempat terbaik untuk menemukan berbagai macam sepatu berkualitas tinggi. Kami bangga menyediakan pilihan sepatu yang luas untuk segala usia dan gaya.</p>
                                <p>Misi kami adalah untuk memberikan pengalaman berbelanja yang menyenangkan dan memuaskan bagi semua pelanggan kami. Dengan koleksi yang selalu up-to-date, kami memastikan bahwa Anda selalu dapat menemukan sepatu terbaru dan terbaik di toko kami.</p>
                                <section class="team animate-on-scroll">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-2">
                <div class="team-member">
                    <img src="images/270x270-male-avatar.png" alt="Nama Anggota Tim 1" class="img-responsive">
                    <h3>Aji Haryo Poespo</h3>
                    <p>CEO & Founder</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="team-member">
                    <img src="images/270x270-male-avatar.png" alt="Nama Anggota Tim 2" class="img-responsive">
                    <h3>Dani Taufik Riyan</h3>
                    <p>Head of Marketing</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="team-member">
                    <img src="images/270x270-male-avatar.png" alt="Nama Anggota Tim 3" class="img-responsive">
                    <h3>Erwin Lamtota</h3>
                    <p>Head of Design</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="team-member">
                    <img src="images/270x270-male-avatar.png" alt="Nama Anggota Tim 4" class="img-responsive">
                    <h3>Efrata</h3>
                    <p>Product Manager</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="team-member">
                    <img src="images/270x270-male-avatar.png" alt="Nama Anggota Tim 5" class="img-responsive">
                    <h3>M Aditio Nurcahyadi</h3>
                    <p>Sales Manager</p>
                </div>
            </div>
        </div>
    </div>
</section>
                            </section>
                        </div>
                        <?php
                            $month = date('m');
                            $conn = $pdo->open();

                            try {
                                $inc = 3;
                                $stmt = $conn->prepare("SELECT *, SUM(quantity) AS total_qty FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE MONTH(sales_date) = '$month' GROUP BY details.product_id ORDER BY total_qty DESC LIMIT 6");
                                $stmt->execute();
                                foreach ($stmt as $row) {
                                    $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
                                    $inc = ($inc == 3) ? 1 : $inc + 1;
                                    if ($inc == 1) echo "<div class='row'>";
                                    echo "
                                        <div class='col-sm-4'>
                                            <div class='box box-solid'>
                                                <div class='box-body prod-body'>
                                                    <img src='".$image."' width='100%' height='230px' class='thumbnail'>
                                                    <h5><a href='product.php?product=".$row['slug']."'>".$row['name']."</a></h5>
                                                </div>
                                                <div class='box-footer'>
                                                    <b>&#36; ".number_format($row['price'], 2)."</b>
                                                </div>
                                            </div>
                                        </div>
                                    ";
                                    if ($inc == 3) echo "</div>";
                                }
                                if ($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>";
                                if ($inc == 2) echo "<div class='col-sm-4'></div></div>";
                            } catch (PDOException $e) {
                                echo "There is some problem in connection: " . $e->getMessage();
                            }

                            $pdo->close();
                        ?>
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
