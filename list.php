<?php
require_once('./Helpers/connection.php');

// Phân trang
$results_per_page = 200;
$page = 1;
if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
$page_first_result = ($page - 1) * $results_per_page;
$query = "SELECT * FROM `students`";
$result = mysqli_query($conn, $query);
$number_of_result = mysqli_num_rows($result);
$number_of_page = ceil ($number_of_result / $results_per_page);

$sql = "SELECT * FROM `students` ORDER BY `visited_at` DESC LIMIT " . $page_first_result . ',' . $results_per_page;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <?php
      include './Helpers/favicon.php';
    ?>
</head>

<body>
    <div class="container-fluid my-5">
        <h3 class="text-center py-4">Danh sách sinh viên (Tổng: <?=$number_of_result?>)</h3>
		<nav>
          <ul class="pagination justify-content-center align-items-center" style="flex-wrap: wrap">
            <?php
            for($pageNow = 1; $pageNow <= $number_of_page; $pageNow++) {
            ?>
            <li class="page-item <?= $pageNow == $page ? "active" : '' ?>">
                <a class="page-link" href="list.php?page=<?=$pageNow?>"><?=$pageNow?></a>
              </li>
            <?php
              }
            ?>
          </ul>
		</nav>
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
                    $i = count($students);
                    foreach ($students as $student) {
                      $date = new DateTime($student['visited_at']);
                    ?>
                        <tr>
                            <td><?=$i--?></td>
                            <td><?= $student['visit_count'] ?></td>
                            <td><?= $date->format('d/m/Y || H:i:s A') ?></td>
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
		<nav>
          <ul class="pagination justify-content-center align-items-center" style="flex-wrap: wrap">
            <?php
            for($pageNow = 1; $pageNow <= $number_of_page; $pageNow++) {
            ?>
              <li class="page-item <?= $pageNow == $page ? "active" : '' ?>">
                <a class="page-link" href="list.php?page=<?=$pageNow?>"><?=$pageNow?></a>
              </li>
            <?php
              }
            ?>
          </ul>
		</nav>
    </div>
</body>

</html>
