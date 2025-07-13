<?php
  // Xử lý form gửi đi (nếu có)
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ví dụ lấy dữ liệu
    $ten_trang_trai = $_POST["ten_trang_trai"] ?? '';
    $chu_trai = $_POST["chu_trai"] ?? '';

    // Có thể thêm mã ghi vào database ở đây

    // Phản hồi
    echo "<script>alert('Đã nhận dữ liệu đơn thuốc!');</script>";
  }
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <title>Đơn thuốc trộn cám</title>
    <link rel="stylesheet" href="/Application/Product-Dept/View/styless.css">
</head>

<body>

    <div class="container">
        <!-- PHẦN ĐẦU TRANG -->
        <br class="header">
        <div class="left-info">
            <img src="/Application/Product-Dept/View/img/logo.png" alt="Logo CP" class="logo" /><br />

        </div>
        <div class="left-header">
            <strong>Tên Đơn Vị: CÔNG TY CỔ PHẦN CHĂN NUÔI C.P VIỆT NAM</strong><br />
            <strong>Nhà Máy: NHÀ MÁY THỨC ĂN GIA SÚC BÌNH ĐỊNH</strong><br />
            <strong>Địa Chỉ: Lô A2.1, A2.2, A2.3 VÀ A2.4, KCN Nhơn Hòa, Phường An Nhơn Nam, Tỉnh Gia Lai</strong><br />
        </div>
        <div class="right-header">
            <strong>SỐ:</strong>
            <input type="text" name="Số" placeholder="số" />
        </div>
        <br />
        <br />
        <br />
        <br />
        <br />
        <h2>ĐƠN YÊU CẦU CÁM TRỘN THUỐC ĐIỀU TRỊ / ĐIỀU TRỊ DỰ PHÒNG</h2>
        <?php
    // Tạo đối tượng ngày hiện tại
    $today = new DateTime();
    // Cộng thêm 1 tuần
    $today->modify('+1 week');
    // Lấy tuần và năm sau khi cộng
    $nextWeek = $today->format('W');
    $nextYear = $today->format('Y');
?>
        <div class="center">
            (Đặt cám tuần
            <input type="textx" class="small-input" value="<?= $nextWeek ?>" placeholder="week" /> /
            <input type="textx" class="small-input" value="<?= $nextYear ?>" placeholder="year" />)
        </div>


        <form method="POST">
            <div class="left-info1">
                <strong>Chi nhánh: </strong>
                <input type="text1" name="chinhanh" placeholder="" /> <br />
                <br />
                <strong>Địa chỉ chi nhánh:</strong>
                <input type="text1" name="diachichinhanh" placeholder="" /> <br />
                <br />
                <strong>Số Điện Thoại:</strong>
                <input type="text1" name="sodienthoaichinhanh" placeholder="" /> <br />
            </div>
        </form>
        <br />
        <form method="POST">
            <div class="right-info1">
                <strong>Tên Trại :</strong>
                <input type="text1" name="tentrai" placeholder="" /><br /> <br />
                <strong>Địa chỉ trại:</strong>
                <input type="text1" name="diachitrai" placeholder="" /><br /> <br />
                <strong>Số điện thoại:</strong>
                <input type="text1" name="sodienthoaitrai" placeholder="" /> <br />
            </div>


        </form>
    </div>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />

    <!-- TIÊU ĐỀ ĐƠN -->


    <!-- CÁC PHẦN KHÁC GIỮ NGUYÊN -->
    <div class="section-title">I. THÔNG TIN TẠI TRẠI</div>
    <!-- Tùy chọn bổ sung -->
    <table>
        <thead>
            <tr>
                <th>Loại vật nuôi</th>
                <th>Số lượng heo(con)</th>
                <th>Tuần tuổi</th>
                <th>Chuẩn đoán tại trại</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select>

                        <option value="HEO">HEO</option>
                        <option value="GA">GÀ</option>
                        <option value="VIT">VỊT</option>
                        <option value="BO">BÒ</option>
                    </select>
                </td>
                <td><input type="text" placeholder="Đơn vị con" /></td>
                <td><input type="text" placeholder="Số tuần" /></td>
                <td>
                    <label for="don_dieu_tri" style="cursor: pointer; color: blue; text-decoration: underline;">
                        Add đơn điều trị (ảnh hoặc PDF)
                    </label>
                    <input type="file" id="don_dieu_tri" accept=".pdf,image/*" multiple style="display: none;" />
                    <div id="preview" style="margin-top: 1px; display: flex; flex-wrap: wrap; gap: 1px;"></div>
                    <button id="clearAll" style="margin-top: 1px; display: none;">Hủy tất cả</button>
                </td>

                <!-- Modal hiển thị ảnh/pdf -->
                <div id="imageModal">
                    <span id="closeModal">&times;</span>
                    <div id="modalContent"></div>
                </div>

                <script>
                const fileInput = document.getElementById("don_dieu_tri");
                const preview = document.getElementById("preview");
                const clearAllBtn = document.getElementById("clearAll");
                const imageModal = document.getElementById("imageModal");
                const modalContent = document.getElementById("modalContent");
                const closeModal = document.getElementById("closeModal");

                let filesData = [];

                fileInput.addEventListener("change", () => {
                    const files = Array.from(fileInput.files);

                    if (files.length + filesData.length > 3) {
                        alert("Chỉ được chọn tối đa 3 tệp!");
                        fileInput.value = "";
                        return;
                    }

                    files.forEach((file) => {
                        const fileURL = URL.createObjectURL(file);
                        const fileType = file.type;

                        const wrapper = document.createElement("div");
                        wrapper.classList.add("preview-item");

                        const removeBtn = document.createElement("button");
                        removeBtn.classList.add("remove-btn");
                        removeBtn.innerText = "X";

                        removeBtn.addEventListener("click", () => {
                            wrapper.remove();
                            filesData = filesData.filter(f => f !== wrapper);
                            if (filesData.length === 0) {
                                clearAllBtn.style.display = "none";
                            }
                        });

                        if (fileType.startsWith("image/")) {
                            const img = document.createElement("img");
                            img.src = fileURL;
                            img.addEventListener("click", () => {
                                modalContent.innerHTML = `<img src="${fileURL}" />`;
                                imageModal.style.display = "flex";
                            });
                            wrapper.appendChild(img);
                        } else if (fileType === "application/pdf") {
                            const iframe = document.createElement("iframe");
                            iframe.src = fileURL;
                            iframe.width = 60;
                            iframe.height = 60;
                            iframe.addEventListener("click", () => {
                                modalContent.innerHTML =
                                    `<iframe src="${fileURL}" width="30%" height="30%"></iframe>`;
                                imageModal.style.display = "flex";
                            });
                            wrapper.appendChild(iframe);
                        }

                        wrapper.appendChild(removeBtn);
                        preview.appendChild(wrapper);
                        filesData.push(wrapper);
                    });

                    if (filesData.length > 0) {
                        clearAllBtn.style.display = "inline-block";
                    }

                    fileInput.value = ""; // reset input để có thể chọn lại file cũ
                });

                clearAllBtn.addEventListener("click", () => {
                    preview.innerHTML = "";
                    filesData = [];
                    clearAllBtn.style.display = "none";
                    fileInput.value = "";
                });

                closeModal.addEventListener("click", () => {
                    imageModal.style.display = "none";
                    modalContent.innerHTML = "";
                });

                imageModal.addEventListener("click", (e) => {
                    if (e.target === imageModal) {
                        imageModal.style.display = "none";
                        modalContent.innerHTML = "";
                    }
                });
                </script>
                </td>
            </tr>

        </tbody>
    </table>

    <div class="section-title">II. KÊ ĐƠN</div>
    <table>
        <thead>
            <tr>
                <th>Tên thức ăn chăn nuôi</th>
                <th>Mã số TĂCN trộn thuốc</th>
                <th>Code cám đặt(S...)</th>
                <th>Số lượng cám Bao (tấn)</th>
                <th>Số lượng cám SILO (tấn)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <h3>HEO SỮA </h3>
                    <p>(7 ngày tuổi - 12kg thể trọng)</p>
                </td>
                <td><strong>550SF</strong></td>
                <td>
                    <select>
                        <option value="">-- Chọn đuôi thuốc --</option>
                        <option value="none">NONE</option>
                        <option value="S90">S90</option>
                        <option value="S13">S13</option>
                        <option value="S54">S54</option>
                        <option value="S76">S76</option>
                        <option value="S72">S72</option>
                        <option value="S31">S31</option>
                    </select>
                </td>
                <td><input type="text" placeholder="Cám bao" /></td>
                <td><input type="text" placeholder="Cám silo" /></td>
            <tr>
                <td>
                    <h3>HEO CON TẬP ĂN </h3>
                    <p>(7 ngày tuổi - 20kg thể trọng)</p>
                </td>
                <td><strong>551F</strong></td>
                <td>
                    <select>
                        <option value="">-- Chọn đuôi thuốc --</option>
                        <option value="none">NONE</option>
                        <option value="S90">S90</option>
                        <option value="S13">S13</option>
                        <option value="S54">S54</option>
                        <option value="S76">S76</option>
                        <option value="S72">S72</option>
                        <option value="S31">S31</option>
                    </select>
                </td>
                <td><input type="text" placeholder="Cám bao" /></td>
                <td><input type="text" placeholder="Cám silo" /></td>
            </tr>
            <tr>
                <td>
                    <h3>HEO CON </h3>
                    <p>(15- 25kg thể trọng)</p>
                </td>
                <td><strong>551GPF</strong></td>
                <td>
                    <select>
                        <option value="">-- Chọn đuôi thuốc --</option>
                        <option value="none">NONE</option>
                        <option value="S90">S90</option>
                        <option value="S13">S13</option>
                        <option value="S54">S54</option>
                        <option value="S76">S76</option>
                        <option value="S72">S72</option>
                    </select>
                </td>
                <td><input type="text" placeholder="Cám bao" /></td>
                <td><input type="text" placeholder="Cám silo" /></td>
            </tr>
            <tr>
                <td>
                    <h3>HEO THỊT SIÊU NẠC </h3>
                    <p>(26- 60kg thể trọng)</p>
                </td>
                <td><strong>552SF</strong></td>
                <td>
                    <select>
                        <option value="">-- Chọn đuôi thuốc --</option>
                        <option value="none">NONE</option>
                        <option value="S90">S90</option>
                        <option value="S13">S13</option>
                        <option value="S54">S54</option>
                        <option value="S76">S76</option>
                        <option value="S72">S72</option>
                    </select>
                </td>
                <td><input type="text" placeholder="Cám bao" /></td>
                <td><input type="text" placeholder="Cám silo" /></td>
            </tr>
            <tr>
                <td>
                    <h3>HEO THỊT SIÊU NẠC </h3>
                    <p>(61kg- 80kg thể trọng)</p>
                </td>
                <td><strong>552F</strong></td>
                <td>
                    <select>
                        <option value="">-- Chọn đuôi thuốc --</option>
                        <option value="none">NONE</option>
                        <option value="S90">S90</option>
                        <option value="S13">S13</option>
                        <option value="S54">S54</option>
                        <option value="S76">S76</option>
                        <option value="S72">S72</option>
                    </select>
                </td>
                <td><input type="text" placeholder="Cám bao" /></td>
                <td><input type="text" placeholder="Cám silo" /></td>
            </tr>
            <tr>
                <td>
                    <h3>HEO ĐỰC THỊT </h3>
                    <p>(81 kg thể trọn - 2 tuần trước khi xuất chuồng)</p>
                </td>
                <td><strong>553MF</strong></td>
                <td>
                    <select>
                        <option value="">-- Chọn đuôi thuốc --</option>
                        <option value="none">NONE</option>
                        <option value="S90">S90</option>
                        <option value="S13">S13</option>
                        <option value="S54">S54</option>
                        <option value="S76">S76</option>
                        <option value="S72">S72</option>
                    </select>
                </td>
                <td><input type="text" placeholder="Cám bao" /></td>
                <td><input type="text" placeholder="Cám silo" /></td>
            </tr>
            <tr>
                <td>
                    <h3>HEO HẬU BỊ GIỐNG </h3>
                    <p>(8Okg - 100kg thể trọng) </p>
                </td>
                <td><strong>562F</strong></td>
                <td>
                    <select>
                        <option value="">-- Chọn đuôi thuốc --</option>
                        <option value="none">NONE</option>
                        <option value="S90">S90</option>
                        <option value="S13">S13</option>
                        <option value="S54">S54</option>
                        <option value="S76">S76</option>
                        <option value="S72">S72</option>
                    </select>
                </td>
                <td><input type="text" placeholder="Cám bao" /></td>
                <td><input type="text" placeholder="Cám silo" /></td>
            </tr>
            <tr>
                <td>
                    <h3>HEO HẬU BỊ THAY ĐÀN, HEO NÁI MANG THAI </h3>
                    <p>(100kg - 300kg thể trọng) </p>
                </td>
                <td><strong>566F</strong></td>
                <td>
                    <select>
                        <option value="">-- Chọn đuôi thuốc --</option>
                        <option value="none">NONE</option>
                        <option value="S90">S90</option>
                        <option value="S13">S13</option>
                        <option value="S54">S54</option>
                        <option value="S76">S76</option>
                        <option value="S72">S72</option>
                    </select>
                </td>
                <td><input type="text" placeholder="Cám bao" /></td>
                <td><input type="text" placeholder="Cám silo" /></td>
            </tr>
            <tr>
                <td>
                    <h3>HEO NÁI NUÔI CON </h3>
                    <p>(150kg - 300kg thể trọng) </p>
                </td>
                <td><strong>567SF</strong></td>
                <td>
                    <select>
                        <option value="">-- Chọn đuôi thuốc --</option>
                        <option value="none">NONE</option>
                        <option value="S90">S90</option>
                        <option value="S13">S13</option>
                        <option value="S54">S54</option>
                        <option value="S76">S76</option>
                        <option value="S72">S72</option>
                    </select>
                </td>
                <td><input type="text" placeholder="Cám bao" /></td>
                <td><input type="text" placeholder="Cám silo" /></td>
            </tr>

        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th rowspan="2">Code thuốc</th>
                <th rowspan="2">Thuốc điều trị<br />(hoạt chất chính của thuốc)</th>
                <th rowspan="2">Nồng độ</th>
                <th rowspan="2">Liều dùng<br />(ppm) g/tấn</th>
                <th rowspan="2">Khối lượng thuốc trộn (kg/tấn cám) <br />(B)</th>
                <th colspan="5">
                    Thuốc điều trị (tên thương mại)<br />(Sử dụng 1 trong các loại thuốc
                    có tên bên dưới)
                </th>
                <th rowspan="2">Khối lượng thuốc trộn vào cám (kg)<br />(A) x (B)</th>
                <th rowspan="2">Công dụng</th>
                <th rowspan="2">Đường dùng</th>
                <th rowspan="2">Thời điểm dùng thuốc</th>
                <th rowspan="2">Liệu trình điều trị (ngày)</th>
                <th rowspan="2">
                    Thời gian ngừng sử dụng thuốc trước khi xuất bán (ngày)
                </th>
            </tr>
            <tr>
                <th>1</th>
                <th>hoặc 2</th>
                <th>hoặc 3</th>
                <th>hoặc 4</th>
                <th>hoặc 5</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>S13</td>
                <td>Fenbendazole 100mg/gram</td>
                <td>100</td>
                <td>40</td>
                <td>0,40</td>
                <td>APA Fenba 10P</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Điều trị ký sinh trùng</td>
                <td>Trộn cám</td>
                <td>Trong ngày</td>
                <td>7 ngày</td>
                <td>14 ngày</td>
            </tr>
            <tr>
                <td>S13</td>
                <td>Fenbendazole 200mg/gram</td>
                <td>200</td>
                <td>40</td>
                <td>0,20</td>
                <td>Fenbazole - 20</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Điều trị ký sinh trùng</td>
                <td>Trộn cám</td>
                <td>Trong ngày</td>
                <td>7 ngày</td>
                <td>14 ngày</td>
            </tr>
            <tr>
                <td>S52</td>
                <td>Tiamulin 800mg/gram</td>
                <td>800</td>
                <td>200</td>
                <td>0,25</td>
                <td>Denzgard 80% coated</td>
                <td>Tiamulin Hydrogen Fumarate Premix 80% Coated</td>
                <td>Rodoxium 80% granular</td>
                <td>Tiamox 80%</td>
                <td></td>
                <td></td>
                <td>Điều trị bội hấp và tiêu chảy</td>
                <td>Trộn cám</td>
                <td>Trong ngày</td>
                <td>7 ngày</td>
                <td>14 ngày</td>
            </tr>
            <tr>
                <td>S52</td>
                <td>Halquinol 600 mg/g</td>
                <td>600</td>
                <td>400</td>
                <td>0,67</td>
                <td>Rovolin</td>
                <td>Advance Halquinol</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Điều trị tiêu chảy</td>
                <td>Trộn cám</td>
                <td>Trong ngày</td>
                <td>7 ngày</td>
                <td>14 ngày</td>
            </tr>
            <tr>
                <td>S54</td>
                <td>Tiamulin 800mg/gram</td>
                <td>800</td>
                <td>200</td>
                <td>0,25</td>
                <td>Denzgard 80% coated</td>
                <td>Tiamulin Hydrogen Fumarate Premix 80% Coated</td>
                <td>Rodoxium 80% granular</td>
                <td></td>
                <td></td>
                <td></td>
                <td>Điều trị bội hấp và tiêu chảy</td>
                <td>Trộn cám</td>
                <td>Trong ngày</td>
                <td>7 ngày</td>
                <td>14 ngày</td>
            </tr>
            <tr>
                <td>S54</td>
                <td>Halquinol 600 mg/g</td>
                <td>600</td>
                <td>400</td>
                <td>0,67</td>
                <td>Rovolin</td>
                <td>Advance Halquinol</td>
                <td></td>
                <td></td>
                <td></td>
                <td>2,5</td>
                <td>Điều trị tiêu chảy</td>
                <td>Trộn cám</td>
                <td>Trong ngày</td>
                <td>7 ngày</td>
                <td>14 ngày</td>
            </tr>
            <tr>
                <td>S90</td>
                <td>Tiamulin 800mg/gram</td>
                <td>800</td>
                <td>150</td>
                <td>0,19</td>
                <td>Denzgard 80% coated</td>
                <td>Tiamulin Hydrogen Fumarate Premix 80% Coated</td>
                <td>Rodoxium 80% granular</td>
                <td>Tiamox 80%</td>
                <td>Fumarate Premix 80% (China)</td>
                <td></td>
                <td>Điều trị bội hấp và tiêu chảy</td>
                <td>Trộn cám</td>
                <td>Trong ngày</td>
                <td>7 ngày</td>
                <td>14 ngày</td>
            </tr>
            <!-- Có thể thêm dòng trống nếu muốn -->
        </tbody>
    </table>


    <div class="left">
        Lưu ý:
        <input type="text" placeholder="" />
    </div>
    <br />

    <div class="row">
        <!-- Cột trái -->
        <div class="column">
            <strong>Người kê đơn</strong><br />
            <em>(Ký và ghi rõ họ tên)</em>
            <div class="date-line">


                <?php
        echo "Ngày " . date("d") . " tháng " . date("m") . " năm " . date("Y") . ".";
      ?>
            </div>
            <div class="box-signature"></div>
            <input type="text" placeholder="Ghi rõ họ và tên" /><br />
            Số CCHN: <input type="text" placeholder="số cchn" /><br />
            Số điện thoại: <input type="text" placeholder="SĐT" /><br />
            Địa chỉ (Theo CMND): <input type="text" placeholder="địa chỉ" /><br />

        </div>

        <!-- Cột giữa -->
        <div class="center-column">
            <strong>Đại diện nhà máy cám</strong><br />
            <em>(Ký và ghi rõ họ tên)</em>

            <div class="date-line">


                <?php
        echo "Ngày " . date("d") . " tháng " . date("m") . " năm " . date("Y") . ".";
      ?>
            </div>

            <div class="box-signature"></div>
            <input type="text" placeholder="Ghi rõ họ và tên" /><br />
        </div>

        <!-- Cột phải -->
        <div class="end-column">

            <div class="note">(*) Khám lại xin mang theo đơn này</div>
            <div class="row">
                <div class="columr"></div>
                <div class="columnr"></div>
                <div class="columnr">
                    <strong>Ghi chú:</strong><br />
                    <div class="footer-note">
                        Đơn này được lưu ít nhất 2 năm và được in thành 3 liên.<br />
                        Liên 1: đính hồ sơ phần INT lưu;<br />
                        Liên 2: Nhà máy cám lưu;<br />
                        Liên 3: Người nhận lưu.
                    </div>
                </div>

            </div>

            <div class="footer">
                <input type="submit" value="Gửi đơn thuốc" />
            </div>


</html>