
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tính điểm qua môn SGU</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css">
    <?php
    include './Helpers/favicon.php';
    require './Helpers/clearCache.php';
    ?>
</head>

<style>
    table,
    thead,
    tbody,
    td,
    th,
    tr {
        border: 1px solid #DEE2E6;
    }

    .input {
        box-shadow: none !important;
        outline: none !important;
        border: 1px solid #ccc;
        border-radius: 6px;
        display: block;
        padding: 4px 6px;
    }

    .input:focus {
        border-color: var(--blue);
    }

    .input_M {
        width: 70px;
        margin: auto;
        text-align: center;
    }

    .input_L {
        min-width: 100%;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .width-50px {
        min-width: 80px !important;
        max-width: 80px !important;
    }
</style>

<body>
    <div class="container-fluid">
        <h2 class="text-center py-4">Công cụ tính điểm qua môn</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="" scope="col">Môn</th>
                    <th class="text-center width-50px" scope="col">Điểm QT</th>
                    <th class="text-center width-50px" scope="col">Hệ số QT</th>
                    <th class="text-center width-50px" scope="col">HSố Thi</th>
                    <th class="text-center width-50px" scope="col">Đạt D</th>
                    <th class="text-center width-50px" scope="col">Đạt C</th>
                    <th class="text-center width-50px" scope="col">Đạt B</th>
                    <th class="text-center width-50px" scope="col">Đạt A</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 1; $i <= 10; $i++) {
                ?>
                    <tr>
                        <td class="text-center">
                            <input id="monHoc_<?= $i ?>" autocomplete="off" class="input input_L" />
                        </td>
                        <td class="text-center width-50px">
                            <input type="number" id="quaTrinh_<?= $i ?>" placeholder="Vd: 8.4" min=0 max=10 step="0.01" autocomplete="off" class="input input_M">
                        </td>
                        <td class="text-center width-50px">
                            <input type="number" id="heSoQuaTrinh_<?= $i ?>" placeholder="Vd: 0.5" min=0 max=1 step="0.1" autocomplete="off" class="input input_M">
                        </td>
                        <td class="text-center width-50px">
                            <input type="number" id="heSoThi_<?= $i ?>" placeholder="Vd: 0.5" min=0 max=1 step="0.1" autocomplete="off" class="input input_M">
                        </td>
                        <td class="text-center width-50px">
                            <input type="number" id="diemD_<?= $i ?>" value="0" autocomplete="off" class="input input_M font-weight-bold" disabled>
                        </td>
                        <td class="text-center width-50px">
                            <input type="number" id="diemC_<?= $i ?>" value="0" autocomplete="off" class="input input_M font-weight-bold" disabled>
                        </td>
                        <td class="text-center width-50px">
                            <input type="number" id="diemB_<?= $i ?>" value="0" autocomplete="off" class="input input_M font-weight-bold" disabled>
                        </td>
                        <td class="text-center width-50px">
                            <input type="number" id="diemA_<?= $i ?>" value="0" autocomplete="off" class="input input_M font-weight-bold" disabled>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <div class="text-center mt-4 mb-5 pb-5">
            Số lượt truy cập:
            <?php
            require_once './Helpers/connection.php';

            $sql = "SELECT * FROM `count` WHERE `pageName`='quaMon'";
            $query = mysqli_query($conn, $sql);
            $row  = mysqli_fetch_assoc($query);

            echo number_format($row['countNum'], 0, '.', '.');
            if(!isset($_GET['admin'])){
            $sql = "UPDATE `count` SET `countNum`=`countNum`+1 WHERE `pageName`='quaMon'";
            $query = mysqli_query($conn, $sql);}
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(() => {
            const monHoc = "monHoc_";
            const quaTrinh = "quaTrinh_";
            const heSoQuaTrinh = "heSoQuaTrinh_";
            const heSoThi = "heSoThi_";
            const diemD = "diemD_";
            const diemC = "diemC_";
            const diemB = "diemB_";
            const diemA = "diemA_";

            const main = () => {
                for (let i = 1; i <= 10; i++) {
                    $("#" + quaTrinh + i).change(() => {
                        tinhDiemThanhPhan(i);
                    });
                    $("#" + heSoQuaTrinh + i).change(() => {
                        tinhDiemThanhPhan(i);
                    });
                    $("#" + heSoThi + i).change(() => {
                        tinhDiemThanhPhan(i);
                    });
                    const containerD = $("#" + diemD + i);
                    setColorOutput(containerD);
                    const containerC = $("#" + diemC + i);
                    setColorOutput(containerC);
                    const containerB = $("#" + diemB + i);
                    setColorOutput(containerB);
                    const containerA = $("#" + diemA + i);
                    setColorOutput(containerA);
                }
            }

            const tinhDiemThanhPhan = (index) => {
                tinhDiemA(index);
                tinhDiemB(index);
                tinhDiemC(index);
                tinhDiemD(index);
            }

            const tinhDiemD = (index) => {
                const target = 4.0;
                const val_quaTrinh = $("#" + quaTrinh + index).val() || 1;
                const val_heSoQuaTrinh = $("#" + heSoQuaTrinh + index).val() || 1;
                const val_heSoThi = $("#" + heSoThi + index).val() || 1;
                const outputContainer = $("#" + diemD + index);
                let result = (target - val_quaTrinh * val_heSoQuaTrinh) / val_heSoThi;
                result = result >= 0 ? formatNumber(result) : 0
                outputContainer.val(result);
                setColorOutput(outputContainer);
            }

            const tinhDiemC = (index) => {
                const target = 5.5;
                const val_quaTrinh = $("#" + quaTrinh + index).val() || 1;
                const val_heSoQuaTrinh = $("#" + heSoQuaTrinh + index).val() || 1;
                const val_heSoThi = $("#" + heSoThi + index).val() || 1;
                const outputContainer = $("#" + diemC + index);
                let result = (target - val_quaTrinh * val_heSoQuaTrinh) / val_heSoThi;
                result = result >= 0 ? formatNumber(result) : 0
                outputContainer.val(result);
                setColorOutput(outputContainer);
            }

            const tinhDiemB = (index) => {
                const target = 7.0;
                const val_quaTrinh = $("#" + quaTrinh + index).val() || 1;
                const val_heSoQuaTrinh = $("#" + heSoQuaTrinh + index).val() || 1;
                const val_heSoThi = $("#" + heSoThi + index).val() || 1;
                const outputContainer = $("#" + diemB + index);
                let result = (target - val_quaTrinh * val_heSoQuaTrinh) / val_heSoThi;
                result = result >= 0 ? formatNumber(result) : 0
                outputContainer.val(result);
                setColorOutput(outputContainer);
            }

            const tinhDiemA = (index) => {
                const target = 8.5;
                const val_quaTrinh = $("#" + quaTrinh + index).val() || 1;
                const val_heSoQuaTrinh = $("#" + heSoQuaTrinh + index).val() || 1;
                const val_heSoThi = $("#" + heSoThi + index).val() || 1;
                const outputContainer = $("#" + diemA + index);
                let result = (target - val_quaTrinh * val_heSoQuaTrinh) / val_heSoThi;
                result = result >= 0 ? formatNumber(result) : 0
                outputContainer.val(result);
                setColorOutput(outputContainer);
            }

            const setColorOutput = (container) => {
                const val = container.val();
                container.css("color", "#333");
                container.css("border-color", "#B7E1CD");
                if (val == 0) {
                    container.css("background-color", "#B7E1CD");
                    container.css("border-color", "#B7E1CD");
                } else if (val <= 6) {
                    container.css("background-color", "#FFFF00");
                    container.css("border-color", "#FFFF00");
                } else if (val <= 8) {
                    container.css("background-color", "#F1C232");
                    container.css("border-color", "#F1C232");
                } else {
                    container.css("background-color", "#ff0006");
                    container.css("border-color", "#ff0006");
                    container.css("color", "#ffffff");
                }
            }

            const formatNumber = (num) => {
                return num.toFixed(1).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }

            main();
        })
    </script>
</body>

</html>