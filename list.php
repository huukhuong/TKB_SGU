<?php
require_once('./Helpers/connection.php');
$sql = "SELECT * FROM `students` ORDER BY `visited_at` DESC";
$query = mysqli_query($conn, $sql);
$students = array();
while ($row = mysqli_fetch_assoc($query))
    $students[] = $row;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <h3 class="text-center py-4">Danh sách sinh viên</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Count</th>
                        <th scope="col" style="min-width: 120px">Time</th>
                        <th scope="col">MSSV</th>
                        <th scope="col" style="min-width: 200px">Họ tên</th>
                        <th scope="col">Ngày sinh</th>
                        <th scope="col">Lớp</th>
                        <th scope="col" style="min-width: 200px">Ngành</th>
                        <th scope="col" style="min-width: 200px">Khoa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($students as $student) {
                    ?>
                        <tr>
                            <td><?=$i++?></td>
                            <td><?= $student['visit_count'] ?></td>
                            <td><?= $student['visited_at'] ?></td>
                            <td><?= $student['id'] ?></td>
                            <td><?= $student['name'] ?></td>
                            <td><?= $student['birthday'] ?></td>
                            <td><?= $student['class'] ?></td>
                            <td><?= $student['faculty'] ?></td>
                            <td><?= $student['branch'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>