<!-- Content -->
<div class="content">
    <?php
    include 'HeaderInst.php';
    ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-4">Total Courses</h5>
                        <h1 class="display-2 mb-4">10</h1>
                        <div class="row">
                            <div class="col">
                                <p>Under-Graduate: <strong>5</strong></p>
                            </div>
                            <div class="col">
                                <p>Post-Graduate Students: <strong>4</strong></p>
                            </div>
                            <div class="col">
                                <p>PhDs: <strong>1</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-4">Total Exams</h5>
                        <h1 class="display-2 mb-4">50</h1>
                        <div class="row">
                            <div class="col">
                                <p>Classified: <strong>10</strong></p>
                            </div>
                            <div class="col">
                                <p>Unclassified: <strong>10</strong></p>
                            </div>
                            <div class="col">
                                <p>Unscored: <strong>30</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex align-items-center justify-content-center">
                <div class="card create-box text-center p-4">
                    <h5 class="mb-4">Quick Create</h5>
                    <button type="button" class="btn btn-light mb-2">New Course</button>
                    <button type="button" class="btn btn-light">New Exam</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include 'Footer.php';
    ?>
</div>
<!-- Content -->