<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Course Information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="custom-header">

                <p>Good Morning <?php echo $_SESSION["user_firstname"] ?>...</p>

            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        The Next Exam
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Exam Name</th>
                                        <th scope="col">Course Code</th>
                                        <th scope="col">Availability</th>
                                        <th scope="col">Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Web Programming Vize</td>
                                        <td>CSE 236</td>
                                        <td>25 May 2024</td>
                                        <td>45 min</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container mt-4 ">
        <div class="row p-3">
            <div class="col-4 offset-2">
                <div style="box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 2px, rgba(0, 0, 0, 0.07) 0px 2px 4px, rgba(0, 0, 0, 0.07) 0px 4px 8px, rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 16px 32px, rgba(0, 0, 0, 0.07) 0px 32px 64px;box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;" class="card text-bg-primary mb-3">
                    <div class="card-header"><strong>Total Exam Taken</strong></div>
                    <div class="card-body">

                        <p class="card-text text-center"><b>5</b></p>
                    </div>
                </div>
            </div>
            <div class="col-4 ">
                <div style="box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;" class="card text-bg-success mb-3">
                    <div class="card-header"><strong>Total Score</strong></div>
                    <div class="card-body">

                        <p class="card-text text-center"><b>42/75 || %54</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>