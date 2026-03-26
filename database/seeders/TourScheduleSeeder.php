<?php

namespace Database\Seeders;

use App\Models\Tour;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TourScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            12 => [
                ['day_no' => 1, 'title' => 'Đà Nẵng - Sơn Trà - Biển Mỹ Khê', 'detail' => "08:00 Đón khách tại sân bay hoặc trung tâm thành phố Đà Nẵng.\n10:00 Tham quan bán đảo Sơn Trà, viếng chùa Linh Ứng.\n12:00 Dùng bữa trưa với đặc sản địa phương.\n14:30 Tự do tắm biển Mỹ Khê và check-in ven biển.\n18:30 Thưởng thức bữa tối, dạo cầu Rồng về đêm."],
                ['day_no' => 2, 'title' => 'Bà Nà Hills - Cầu Vàng', 'detail' => "07:30 Khởi hành đi Bà Nà Hills.\n09:00 Di chuyển bằng cáp treo, tham quan Cầu Vàng.\n11:30 Vui chơi tại Fantasy Park và làng Pháp.\n13:00 Dùng buffet trưa trên đỉnh Bà Nà.\n16:00 Trở về Đà Nẵng, nghỉ ngơi tự do."],
                ['day_no' => 3, 'title' => 'Ngũ Hành Sơn - Hội An - Kết thúc', 'detail' => "08:30 Tham quan Ngũ Hành Sơn và làng đá mỹ nghệ.\n11:30 Dùng bữa trưa.\n14:30 Khởi hành đi phố cổ Hội An.\n17:00 Tản bộ phố cổ, chụp ảnh và mua sắm.\n20:00 Tiễn khách, kết thúc chương trình."],
            ],
            13 => [
                ['day_no' => 1, 'title' => 'Hà Nội - Tràng An - Hang Múa', 'detail' => "07:30 Đón khách tại Hà Nội, khởi hành đi Ninh Bình.\n10:00 Ngồi thuyền tham quan danh thắng Tràng An.\n12:30 Dùng cơm trưa với đặc sản dê núi.\n14:30 Chinh phục Hang Múa, ngắm toàn cảnh Tam Cốc.\n18:30 Nhận phòng và nghỉ đêm tại Ninh Bình."],
                ['day_no' => 2, 'title' => 'Bái Đính - Hà Nội', 'detail' => "07:00 Ăn sáng tại khách sạn.\n08:30 Tham quan chùa Bái Đính.\n11:30 Trả phòng và dùng bữa trưa.\n14:00 Lên xe trở về Hà Nội.\n17:00 Kết thúc hành trình."],
            ],
            14 => [
                ['day_no' => 1, 'title' => 'Hà Nội - Hạ Long - Lên du thuyền', 'detail' => "08:00 Đón khách tại Hà Nội, khởi hành đi Hạ Long.\n11:30 Làm thủ tục lên du thuyền.\n12:30 Dùng bữa trưa trên tàu khi bắt đầu hải trình.\n15:00 Tham quan hang động và chèo kayak.\n19:00 Dùng bữa tối, nghỉ đêm trên du thuyền."],
                ['day_no' => 2, 'title' => 'Khám phá vịnh - Sunset Party', 'detail' => "06:30 Tập Tai Chi trên boong tàu.\n08:00 Tham quan làng chài hoặc bãi tắm trên vịnh.\n12:00 Dùng bữa trưa.\n15:30 Tiếp tục hoạt động chèo thuyền và ngắm cảnh.\n18:00 Tham gia tiệc hoàng hôn và câu mực đêm."],
                ['day_no' => 3, 'title' => 'Hạ Long - Hà Nội', 'detail' => "06:30 Ngắm bình minh trên vịnh.\n08:00 Dùng bữa sáng nhẹ và thư giãn trên boong.\n10:00 Trả phòng, làm thủ tục rời tàu.\n11:30 Xe đón khách trở về Hà Nội.\n15:30 Kết thúc chương trình."],
            ],
            15 => [
                ['day_no' => 1, 'title' => 'Đến đảo - Nhận phòng - Tắm biển', 'detail' => "08:00 Đón khách và di chuyển ra đảo.\n11:30 Nhận phòng khách sạn, nghỉ ngơi.\n12:30 Dùng bữa trưa hải sản.\n15:00 Tự do tắm biển và tham gia trò chơi bãi biển.\n19:00 Ăn tối và khám phá chợ đêm."],
                ['day_no' => 2, 'title' => 'Lặn ngắm san hô - Cano đảo nhỏ', 'detail' => "07:00 Ăn sáng tại khách sạn.\n08:30 Lên cano tham quan các đảo nhỏ.\n10:00 Lặn ngắm san hô và tắm biển.\n12:30 Dùng bữa trưa trên đảo.\n16:00 Trở về khách sạn, nghỉ ngơi."],
                ['day_no' => 3, 'title' => 'Mua sắm đặc sản - Kết thúc', 'detail' => "07:30 Dùng bữa sáng.\n09:00 Tự do mua sắm đặc sản địa phương.\n11:00 Trả phòng khách sạn.\n12:00 Dùng bữa trưa.\n14:00 Khởi hành về lại điểm đón ban đầu."],
            ],
            16 => [
                ['day_no' => 1, 'title' => 'Đà Lạt - Langbiang - Chợ đêm', 'detail' => "08:00 Đón khách tại Đà Lạt, bắt đầu tham quan.\n10:00 Chinh phục núi Langbiang.\n12:00 Dùng bữa trưa.\n14:30 Tham quan vườn hoa và quảng trường Lâm Viên.\n19:00 Dạo chợ đêm Đà Lạt."],
                ['day_no' => 2, 'title' => 'Thác Datanla - Thiền Viện - Hồ Tuyền Lâm', 'detail' => "07:30 Ăn sáng và khởi hành.\n09:00 Trải nghiệm máng trượt thác Datanla.\n11:00 Tham quan Thiền Viện Trúc Lâm.\n12:30 Ăn trưa.\n14:00 Check-in hồ Tuyền Lâm và vườn dâu."],
                ['day_no' => 3, 'title' => 'Đồi chè Cầu Đất - Kết thúc', 'detail' => "06:30 Săn mây đồi chè Cầu Đất.\n09:00 Trở về khách sạn, dùng bữa sáng.\n10:30 Mua sắm đặc sản Đà Lạt.\n12:00 Trả phòng.\n14:00 Kết thúc chương trình."],
            ],
            17 => [
                ['day_no' => 1, 'title' => 'Hà Nội - Sapa - Bản Cát Cát', 'detail' => "06:30 Khởi hành đi Sapa.\n12:30 Đến Sapa, nhận phòng và ăn trưa.\n14:30 Tham quan bản Cát Cát, tìm hiểu văn hóa H'Mông.\n17:30 Trở về thị trấn.\n19:00 Dùng bữa tối, tự do khám phá Sapa về đêm."],
                ['day_no' => 2, 'title' => 'Fansipan - Moana', 'detail' => "07:00 Ăn sáng.\n08:30 Chinh phục Fansipan bằng cáp treo.\n12:00 Ăn trưa tại thị trấn.\n14:30 Check-in Moana Sapa hoặc nhà thờ đá.\n18:30 Dùng bữa tối với đặc sản vùng cao."],
                ['day_no' => 3, 'title' => 'Chợ địa phương - Hà Nội', 'detail' => "07:30 Dùng bữa sáng.\n09:00 Tham quan chợ Sapa, mua đặc sản.\n11:00 Trả phòng khách sạn.\n12:00 Ăn trưa.\n13:30 Khởi hành về Hà Nội."],
            ],
            18 => [
                ['day_no' => 1, 'title' => 'Phú Quốc - Grand World', 'detail' => "08:00 Đón khách tại sân bay Phú Quốc.\n10:00 Nhận phòng khách sạn.\n12:00 Dùng bữa trưa.\n15:00 Tham quan Grand World và check-in kiến trúc nổi bật.\n19:00 Ăn tối và nghỉ ngơi."],
                ['day_no' => 2, 'title' => 'VinWonders - Safari', 'detail' => "07:30 Ăn sáng tại khách sạn.\n09:00 Vui chơi tại VinWonders.\n12:30 Dùng bữa trưa trong khu vui chơi.\n14:00 Khám phá Safari hoặc thủy cung.\n18:00 Trở về khách sạn."],
                ['day_no' => 3, 'title' => 'Nam đảo - Cáp treo Hòn Thơm', 'detail' => "07:30 Khởi hành tham quan Nam đảo.\n09:00 Trải nghiệm cáp treo Hòn Thơm.\n12:00 Dùng bữa trưa.\n14:00 Mua sắm nước mắm, hồ tiêu, đặc sản.\n16:00 Tiễn khách, kết thúc tour."],
            ],
            19 => [
                ['day_no' => 1, 'title' => 'Đại Nội - Chùa Thiên Mụ', 'detail' => "08:00 Đón khách tại Huế.\n09:00 Tham quan Đại Nội và các cung điện triều Nguyễn.\n12:00 Dùng bữa trưa với ẩm thực Huế.\n14:30 Tham quan chùa Thiên Mụ.\n19:00 Thưởng thức ca Huế trên sông Hương."],
                ['day_no' => 2, 'title' => 'Lăng Khải Định - Lăng Tự Đức', 'detail' => "07:30 Dùng bữa sáng.\n09:00 Tham quan lăng Khải Định.\n11:00 Ghé lăng Tự Đức.\n12:30 Ăn trưa.\n15:00 Mua sắm đặc sản mè xửng, nón lá.\n17:00 Kết thúc hành trình."],
            ],
            20 => [
                ['day_no' => 1, 'title' => 'Hà Nội - Mộc Châu - Đồi chè', 'detail' => "06:30 Khởi hành đi Mộc Châu.\n11:30 Đến nơi, ăn trưa và nhận phòng.\n14:00 Check-in đồi chè trái tim.\n16:00 Tham quan nông trại bò sữa.\n19:00 Ăn tối và nghỉ đêm."],
                ['day_no' => 2, 'title' => 'Thác Dải Yếm - Cầu kính Bạch Long', 'detail' => "07:00 Dùng bữa sáng.\n08:30 Tham quan thác Dải Yếm.\n10:30 Trải nghiệm cầu kính Bạch Long.\n12:30 Ăn trưa.\n14:30 Tự do tham quan bản làng địa phương."],
                ['day_no' => 3, 'title' => 'Mua đặc sản - Hà Nội', 'detail' => "07:30 Ăn sáng và trả phòng.\n09:00 Mua sắm chè, sữa chua, đặc sản Mộc Châu.\n11:30 Dùng bữa trưa.\n13:00 Khởi hành về Hà Nội.\n17:30 Kết thúc chương trình."],
            ],
            21 => [
                ['day_no' => 1, 'title' => 'Quy Nhơn - Eo Gió - Tịnh xá', 'detail' => "08:00 Đón khách tại Quy Nhơn.\n10:00 Check-in Eo Gió.\n11:30 Tham quan Tịnh xá Ngọc Hòa.\n12:30 Dùng bữa trưa.\n15:00 Tắm biển và nghỉ ngơi."],
                ['day_no' => 2, 'title' => 'Kỳ Co - Lặn biển', 'detail' => "07:30 Khởi hành đi bãi Kỳ Co.\n09:00 Tắm biển, lặn ngắm san hô.\n12:00 Ăn trưa hải sản.\n14:30 Tham quan làng chài Nhơn Lý.\n18:30 Ăn tối tại trung tâm thành phố."],
                ['day_no' => 3, 'title' => 'Tháp Đôi - Mua sắm đặc sản', 'detail' => "07:30 Dùng bữa sáng.\n09:00 Tham quan Tháp Đôi.\n10:30 Mua sắm đặc sản Bình Định.\n12:00 Trả phòng và ăn trưa.\n14:00 Tiễn khách, kết thúc tour."],
            ],
            22 => [
                ['day_no' => 1, 'title' => 'Hà Giang - Quản Bạ - Yên Minh', 'detail' => "06:00 Khởi hành từ Hà Giang.\n09:00 Check-in Cổng trời Quản Bạ.\n11:30 Ăn trưa tại Yên Minh.\n14:00 Tiếp tục cung đường đèo và ngắm cao nguyên đá.\n18:00 Nghỉ đêm tại Đồng Văn."],
                ['day_no' => 2, 'title' => 'Mã Pí Lèng - Sông Nho Quế', 'detail' => "07:00 Dùng bữa sáng.\n08:30 Chinh phục đèo Mã Pí Lèng.\n10:30 Đi thuyền sông Nho Quế.\n12:30 Dùng bữa trưa.\n15:00 Tham quan phố cổ Đồng Văn và cột cờ Lũng Cú."],
                ['day_no' => 3, 'title' => 'Đồng Văn - Hà Giang', 'detail' => "07:30 Trả phòng và ăn sáng.\n09:00 Khởi hành về thành phố Hà Giang.\n12:00 Ăn trưa trên đường.\n15:30 Về đến Hà Giang.\n16:00 Kết thúc hành trình."],
            ],
            23 => [
                ['day_no' => 1, 'title' => 'Văn Miếu - Lăng Bác - Hồ Tây', 'detail' => "08:00 Đón khách tại trung tâm Hà Nội.\n09:00 Tham quan Văn Miếu - Quốc Tử Giám.\n10:30 Viếng Lăng Bác và khu Phủ Chủ tịch.\n12:00 Dùng bữa trưa.\n14:00 Dạo Hồ Tây, chùa Trấn Quốc.\n18:00 Thưởng thức ẩm thực phố cổ."],
                ['day_no' => 2, 'title' => 'Phố cổ - Hồ Gươm - Kết thúc', 'detail' => "07:30 Ăn sáng.\n09:00 Tham quan Hồ Gươm và đền Ngọc Sơn.\n10:30 Xích lô quanh phố cổ Hà Nội.\n12:00 Dùng bữa trưa.\n14:00 Tự do mua sắm đặc sản.\n16:00 Kết thúc chương trình."],
            ],
        ];

        DB::transaction(function () use ($data) {
            foreach ($data as $tourId => $schedules) {
                $tour = Tour::find($tourId);
                if (!$tour) {
                    continue;
                }

                $tour->schedules()->delete();

                foreach ($schedules as $schedule) {
                    $tour->schedules()->create($schedule);
                }
            }
        });
    }
}
