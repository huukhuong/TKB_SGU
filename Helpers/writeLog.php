<?php
error_reporting(E_ALL & ~E_NOTICE);
try {
    require_once('./connection.php');
    $length = count($listResult) - 1;
    $student = $listResult[$length];
    $id = $student['name'];
    $nameAndBirth = explode(" - Ngày sinh:", $student['day']);
    $name = $nameAndBirth[0];
    $birthday = $nameAndBirth[1];
    $classBranchFaculty = explode(" - ", $student['start']);
    $class = $classBranchFaculty[0];
    $faculty = $classBranchFaculty[1];
    $branch = $classBranchFaculty[2];
    if (count($classBranchFaculty) == 4) {
        $faculty = $classBranchFaculty[1] . " - " . $classBranchFaculty[2];
        $branch = $classBranchFaculty[3];
    }
    if (count($classBranchFaculty) == 5) {
        $faculty = $classBranchFaculty[1] . " - " . $classBranchFaculty[2];
        $branch = $classBranchFaculty[3] . " - " . $classBranchFaculty[4];
    }
    $sql = "SELECT * FROM `students` WHERE `id`='$id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        $sql = "UPDATE `students` SET `visited_at`=NOW(), `visit_count`=visit_count+1 WHERE `id`='$id'";
    } else {
        $sql = "INSERT INTO `students`(`id`, `name`, `birthday`, `class`, `faculty`, `branch`,`visited_at`) VALUES('$id', '$name', '$birthday', '$class', '$faculty', '$branch', NOW())";
    }
    if ($name != null)
        mysqli_query($conn, $sql);
} catch (Exception $e) {
}
