# AcademiaPro

#DATABASE
-- Database: `studentmanagementdb`

-- Table structure for table `courses`
CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `credits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `courses`
INSERT INTO `courses` (`id`, `course_name`, `credits`) VALUES
(1, 'Cấu trúc dữ liệu', 3),
(2, 'Cơ sở dữ liệu', 4),
(3, 'Lập trình hướng đối tượng', 3),
(4, 'Thiết kế web', 3),
(5, 'Mạng máy tính', 4),
(6, 'Hệ điều hành', 3),
(7, 'An toàn thông tin', 3),
(8, 'Phân tích thiết kế hệ thống', 3),
(9, 'Kiểm thử phần mềm', 3),
(10, 'Quản lý dự án phần mềm', 3);

-- Table structure for table `grades`
CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `grade` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `grades`
INSERT INTO `grades` (`id`, `student_id`, `course_id`, `grade`) VALUES
(1, 1, 1, 8.50),
(2, 1, 2, 9.00),
(3, 1, 3, 4.50),
(4, 1, 4, 6.00),
(5, 1, 5, 8.00),
(6, 1, 6, 9.50),
(7, 1, 7, 7.00),
(8, 1, 8, 8.50),
(9, 1, 9, 9.00),
(10, 1, 10, 6.50),
(11, 2, 1, 7.00),
(12, 2, 2, 8.00),
(13, 2, 3, 7.50),
(14, 2, 4, 6.50),
(15, 2, 5, 8.00),
(16, 2, 6, 8.50),
(17, 2, 7, 9.00),
(18, 2, 8, 8.50),
(19, 2, 9, 7.50),
(20, 2, 10, 6.00),
(21, 3, 1, 6.50),
(22, 3, 2, 7.00),
(23, 3, 3, 6.00),
(24, 3, 4, 4.50),
(25, 3, 5, 7.50),
(26, 3, 6, 8.00),
(27, 3, 7, 6.50),
(28, 3, 8, 7.00),
(29, 3, 9, 8.50),
(30, 3, 10, 9.00),
(31, 4, 1, 9.50),
(32, 4, 2, 8.00),
(33, 4, 3, 7.00),
(34, 4, 4, 9.50),
(35, 4, 5, 8.50),
(36, 4, 6, 7.50),
(37, 4, 7, 4.00),
(38, 4, 8, 9.00),
(39, 4, 9, 6.50),
(40, 4, 10, 8.50),
(41, 5, 1, 8.00),
(42, 5, 2, 7.50),
(43, 5, 3, 8.50),
(44, 5, 4, 6.50),
(45, 5, 5, 7.00),
(46, 5, 6, 9.00),
(47, 5, 7, 8.50),
(48, 5, 8, 6.00),
(49, 5, 9, 7.50),
(50, 5, 10, 8.00),
(51, 6, 1, 7.00),
(52, 6, 2, 9.00),
(53, 6, 3, 8.50),
(54, 6, 4, 6.00),
(55, 6, 5, 8.00),
(56, 6, 6, 4.00),
(57, 6, 7, 8.50),
(58, 6, 8, 9.00),
(59, 6, 9, 6.50),
(60, 6, 10, 7.00),
(61, 7, 1, 8.00),
(62, 7, 2, 6.50),
(63, 7, 3, 9.00),
(64, 7, 4, 8.50),
(65, 7, 5, 7.00),
(66, 7, 6, 9.50),
(67, 7, 7, 7.50),
(68, 7, 8, 8.00),
(69, 7, 9, 8.50),
(70, 7, 10, 6.00),
(71, 8, 1, 6.50),
(72, 8, 2, 7.00),
(73, 8, 3, 8.00),
(74, 8, 4, 9.00),
(75, 8, 5, 6.50),
(76, 8, 6, 7.50),
(77, 8, 7, 9.50),
(78, 8, 8, 8.00),
(79, 8, 9, 7.00),
(80, 8, 10, 8.50),
(81, 9, 1, 9.00),
(82, 9, 2, 6.00),
(83, 9, 3, 7.00),
(84, 9, 4, 8.50),
(85, 9, 5, 7.50),
(86, 9, 6, 9.00),
(87, 9, 7, 8.00),
(88, 9, 8, 4.50),
(89, 9, 9, 7.50),
(90, 9, 10, 9.50),
(91, 10, 1, 7.50),
(92, 10, 2, 8.50),
(93, 10, 3, 6.00),
(94, 10, 4, 9.00),
(95, 10, 5, 8.00),
(96, 10, 6, 7.50),
(97, 10, 7, 4.00),
(98, 10, 8, 8.50),
(99, 10, 9, 7.00),
(100, 10, 10, 8.00);

-- Table structure for table `instructors`
CREATE TABLE `instructors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject_taught` varchar(100) NOT NULL,
  `degree` varchar(50) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `hometown` varchar(100) DEFAULT NULL,
  `current_address` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `instructors` (`id`, `name`, `subject_taught`, `degree`, `date_of_birth`, `avatar`, `hometown`, `current_address`, `phone`, `email`) VALUES
(1, 'Lê Thị Diệu Anh', 'Cấu trúc dữ liệu', 'Thạc sĩ', '1998-02-20', 'https://faceinch.vn/upload/elfinder/%E1%BA%A2nh/chup-chan-dung-5.jpg', 'Hà Nội', 'Số 12, Quận Ba Đình, Hà Nội', '0901234567', 'lethidieuanh@gmail.com'),
(2, 'Nguyễn Gia Bảo', 'Cơ sở dữ liệu', 'Tiến sĩ', '1985-02-20', 'https://chuphinhthe.com/upload/product/4709-tam-8496.jpg', 'Hà Nội', 'Số 5, Quận Nam Từ Liêm, Hà Nội', '092345678', 'nguyengiabao@gmail.com'),
(3, 'Phạm Thị Nguyệt Cát', 'Lập trình hướng đối tượng', 'Thạc sĩ', '1999-05-14', 'http://www.inanhducanh.com//img/upload/images/files/3x4%20%E1%BA%A3nh%20BLX-CMT.jpg', 'Hà Nội', 'Số 43, Quận Hai Bà Trưng, Hà Nội', '093456789', 'phamthinguyetcat@gmail.com'),
(4, 'Nguyễn Tiến Dũng', 'Thiết kế web', 'Tiến sĩ', '1980-08-12', 'https://toplist.vn/images/800px/hieu-anh-huynh-trong-318778.jpg', 'Hà Nội', 'Số 32, Quận Thanh Xuân, Hà Nội', '094567890', 'nguyentiendung@gmail.com'),
(5, 'Bùi Quang Đạt', 'Mạng máy tính', 'Thạc sĩ', '1980-01-01', 'https://chuphinhthe.com/upload/product/863-vu-6042.jpg', 'Hà Nội', 'Số 15, Quận Tây Hồ, Hà Nội', '0956789012', 'buiquangdat@gmail.com'),
(6, 'Trần Văn Giỏi', 'Nguyễn lý hệ điều hành', 'Tiến sĩ', '1994-06-09', 'https://i.vietgiaitri.com/2021/3/28/ngam-nhung-buc-anh-the-lam-can-cuoc-cong-dan-cua-cac-co-cau-hoc-tro-than-thai-dinh-cua-chop-084-5665478.jpg', 'Hà Nội', 'Số 77, Quận Hà Đông, Hà Nội', '0967890123', 'tranvangioi@gmail.com'),
(7, 'Phan Thị Thu Hương', 'An toàn thông tin', 'Thạc sĩ', '1986-06-01', 'https://anhvienpiano.com/wp-content/uploads/2017/06/dich-vu-chup-anh-the-lay-ngay-sau-5-phut-2-1.jpg', 'Hà Nội', 'Số 58, Quận Cầu Giấy, Hà Nội', '0978901234', 'phanthithuhuong@gmail.com'),
(8, 'Hoàng Tuấn Kiệt', 'Phân tích thiết kế hệ thống', 'Tiến sĩ', '1978-07-23', 'https://live.staticflickr.com/2599/4220120104_e94031ca84_w.jpg', 'Hà Nội', 'Số 42, Quận Hà Đông, Hà Nội', '0989012345', 'hoangtuankiet@gmail.com'),
(9, 'Lê Quang Linh', 'Kiểm thử phần mềm', 'Thạc sĩ', '1996-02-12', 'https://vn-test-11.slatic.net/p/fe9c38380c3ecbaf4873e7b51855e900.jpg', 'Hà Nội', 'Số 82, Quận Long Biên, Hà Nội', '0990123456', 'lequanglinh.com'),
(10, 'Trần Văn Mạnh', 'Quản lý dự án phần mềm', 'Tiến sĩ', '1983-05-31', 'https://cauduong.huce.edu.vn/wp-content/uploads/2020/05/z3623066581843_0186efb6f132d6284e6acc7d53d1080c.jpg', 'Hà Nội', 'Số 12, Huyện Mê Linh, Hà Nội', '0901234567', 'tranvanmanh@gmail.com');

-- Table structure for table `students`
CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `class` varchar(50) NOT NULL,
  `major` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `birthplace` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `students`
INSERT INTO `students` (`id`, `name`, `class`, `major`, `dob`, `birthplace`, `email`, `phone`, `avatar`) VALUES
(1, 'Nguyễn Văn An', 'CNTT01', 'Công nghệ thông tin', '2004-04-15', 'Hà Nội', 'nguyenvanan@gmail.com', '0123456789', 'https://anhdephd.vn/wp-content/uploads/2022/05/mau-anh-the-400x600.jpg'),
(2, 'Phạm Bảo Bình', 'CNTT01', 'Công nghệ thông tin', '2004-05-20', 'Hà Nam', 'phambaobinh@gmail.com', '0234567890', 'https://img.tripi.vn/cdn-cgi/image/width=700,height=700/https://gcs.tripi.vn/public-tripi/tripi-feed/img/473653wsL/dino-studio-anh-vien-cho-be-va-gia-dinh-317623.jpg'),
(3, 'Lê Thị Thu Chi', 'CNTT02', 'Công nghệ thông tin', '2004-06-10', 'Vĩnh Phúc', 'lethithuchi@gmail.com', '0345678901', 'https://img.tripi.vn/cdn-cgi/image/width=700,height=700/https://gcs.tripi.vn/public-tripi/tripi-feed/img/473653hgz/anh-vien-ban-trang-studio-675656.jpg'),
(4, 'Trần Tiến Đạt', 'CNTT02', 'Công nghệ thông tin', '2004-07-22', 'Lào Cai', 'trantiendat@gmail.com', '0456789012', 'https://tgroup.vn/uploads/images/korea-tour-package/chup-anh-the-tai-han-quoc-tgroup-travel-5.jpg'),
(5, 'Nguyễn Thị Mai Hương', 'CNTT01', 'Công nghệ thông tin', '2004-08-01', 'Nam Định', 'nguyenthimaihuong@gmail.com', '0567890123', 'https://anhdephd.vn/wp-content/uploads/2022/05/mau-anh-the-dep.jpg'),
(6, 'Trần Văn Kiên', 'CNTT03', 'Công nghệ thông tin', '2004-09-05', 'Hưng Yên', 'tranvankien@gmail.com', '0678901234', 'https://vietabinhdinh.edu.vn/wp-content/uploads/1675558278_92_Tong-hop-nhung-anh-the-dep-nhat.jpg'),
(7, 'Phạm Thị Thị Kim Liên', 'CNTT01', 'Công nghệ thông tin', '2004-10-11', 'Thanh Hóa', 'phamthikimlien@gmail.com', '0789012345', 'https://anhdephd.vn/wp-content/uploads/2022/05/mau-anh-the-voi-phong-trang.jpg'),
(8, 'Nguyễn Văn Minh', 'CNTT02', 'Công nghệ thông tin', '2004-11-15', 'Bắc Giang', 'nguyenvanminh@gmail.com', '0890123456', 'https://baoquangbinh.vn/dataimages/202211/original/images744973_1.jpg'),
(9, 'Lê Thị Nụ', 'CNTT03', 'Công nghệ thông tin', '2004-12-20', 'Ninh Bình', 'lethinu@gmail.com', '0678901245', 'https://toplist.vn/images/800px/studio-mai-lam-1001111.jpg'),
(10, 'Trần Văn Phú', 'CNTT01', 'Công nghệ thông tin', '2004-01-25', 'Hà Tĩnh', 'tranvanphu@gmail.com', '0789012456', 'https://i.vietgiaitri.com/2021/1/9/hanh-trinh-tu-hot-boy-anh-the-den-sinh-vien-5-tot-cap-trung-uong-cua-nam-sinh-dai-hoc-luat-ha-noi-fb8-5503531.png');

-- Table structure for table `users`
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `users`
INSERT INTO `users` (`id`, `username`, `password`, `email`, `fullname`, `phone`, `created_at`, `avatar`) VALUES
(1, 'admin', '$2y$10$n7F8P4kz2O7.qB8nIjL/Oemba/zfsY2X2oJhWDqNkYAdOgwHMnfm6', 'admin@gmail.com', 'Quản trị viên', '0123456789', '2024-10-17 16:46:21', 'https://www.webiconio.com/_upload/255/image_255.svg'),
(3, 'Kiên Cường', '$2y$10$VM5nOxmG7uVj6WrPwahDu.OumesuN8BUfSK/XF4eNy7WOJGZIvk7e', 'trankiencuong30072003@gmail.com', 'Trần Kiên Cường', '0369702376', '2024-10-17 21:12:37', 'https://artena.vn/wp-content/uploads/2024/09/avatar-vo-tri-0U55BCM.jpg');

-- Indexes for table `courses`
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `grades`
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

-- Indexes for table `instructors`
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `students`
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `users`
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

-- AUTO_INCREMENT for table `courses`
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

-- AUTO_INCREMENT for table `grades`
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

-- AUTO_INCREMENT for table `instructors`
ALTER TABLE `instructors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

-- AUTO_INCREMENT for table `students`
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

-- AUTO_INCREMENT for table `users`
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- Constraints for table `grades`
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;
