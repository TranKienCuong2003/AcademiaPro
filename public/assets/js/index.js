//AcademiaPro/app/wiews/auth/register.php
function validateForm() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const passwordError = document.getElementById('passwordError');

    // Kiểm tra xem mật khẩu và xác nhận mật khẩu có giống nhau không
    if (password !== confirmPassword) {
        passwordError.style.display = 'block';
            return false; // Ngăn không cho form được gửi
        }

        passwordError.style.display = 'none';
    return true; // Cho phép form được gửi
}


//AcademiaPro/app/wiews/courses/index.php
// Xử lý sự kiện khi modal mở
$('#confirmDeleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');

    // Cập nhật liên kết xóa vào nút trong modal
    var deleteUrl = "?delete_id=" + id;
    $('#confirmDeleteButton').attr('href', deleteUrl);
})
