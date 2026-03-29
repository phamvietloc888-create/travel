<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $posts = collect($this->posts())
            ->map(function (array $post) {
                $post['excerpt'] = Str::limit(strip_tags(implode(' ', Arr::flatten($post['sections']))), 180);

                return $post;
            });

        return view('clients.blog.index', [
            'posts' => $posts,
        ]);
    }

    public function show(string $slug)
    {
        $post = collect($this->posts())->firstWhere('slug', $slug);

        abort_unless($post, 404);

        $relatedPosts = collect($this->posts())
            ->where('slug', '!=', $slug)
            ->take(2);

        return view('clients.blog.show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ]);
    }

    /**
     * Static editorial content used to make the blog section available quickly.
     *
     * @return array<int, array<string, mixed>>
     */
    private function posts(): array
    {
        return [
            [
                'slug' => 'blog-du-lich-viet-nam-kinh-nghiem-thuc-te',
                'title' => 'Blog du lich Viet Nam: kinh nghiem len lich trinh thong minh cho nguoi moi',
                'category' => 'Cam nang du lich',
                'published_at' => '2026-03-29',
                'read_time' => '8 phut doc',
                'image' => asset('clients/images/bg_1.jpg'),
                'sections' => [
                    [
                        'heading' => 'Vi sao nen doc blog du lich truoc khi dat tour',
                        'paragraphs' => [
                            'Rat nhieu khach dat tour theo cam tinh, xem gia la chot ngay, nhung den luc di moi phat hien lich trinh khong hop suc, diem tham quan khong dung mua dep nhat, hoac chi phi phat sinh vuot du kien. Mot bai blog du lich tot se giup nguoi doc nhin duoc buc tranh tong the truoc khi dua ra quyet dinh.',
                            'Khi doc cac bai viet tong hop ve du lich Viet Nam, ban se de dang so sanh giua nhung diem den pho bien nhu Ha Noi, Ha Long, Da Nang, Hoi An, Hue, Nha Trang hay Phu Quoc. Moi noi co the manh khac nhau: noi hop cho gia dinh, noi hop cho cap doi, noi hop cho nguoi thich check-in, va noi hop cho nguoi uu tien nghi duong.',
                            'Noi dung huu ich cho nguoi dung cung la diem cong lon khi website dang xay dung uy tin de dang ky quang cao. Thay vi chi co trang ban hang, blog giup website co them thong tin huong dan, giai dap thac mac va cho thay don vi van hanh hieu hanh vi tim kiem thuc te cua khach hang.',
                        ],
                    ],
                    [
                        'heading' => 'Cach chon diem den phu hop theo thoi gian va ngan sach',
                        'paragraphs' => [
                            'Neu ban chi co 2 den 3 ngay, nen uu tien diem den co ket noi giao thong de dang va nhieu hoat dong tap trung trong mot khu vuc. Vi du, Da Nang - Hoi An la lua chon can bang vi vua co bien, co pho co, co am thuc va co the di chuyen tuong doi nhe nha.',
                            'Neu ban co 4 den 5 ngay, co the nghi den hanh trinh co nhieu trai nghiem hon nhu Ha Noi - Ninh Binh - Ha Long hoac Hue - Da Nang - Hoi An. Ngan sach trung binh thuong duoc toi uu tot hon neu dat som va tranh dip cao diem le tet.',
                            'Blog du lich can nen noi ro cho nguoi doc biet muc chi phi co ban gom ve di chuyen, khach san, bua an, ve tham quan va du phong phat sinh. Cach viet minh bach, co so lieu uoc tinh ro rang se giup website thuyet phuc hon rat nhieu so voi noi dung qua chung chung.',
                        ],
                    ],
                    [
                        'heading' => 'Mau mot lich trinh co gia tri cho nguoi doc',
                        'paragraphs' => [
                            'Mot bai viet huu ich khong nhat thiet phai qua hoc thuat. Dieu quan trong la nguoi doc ap dung duoc ngay. Vi du, thay vi chi viet ve ve dep cua Da Lat, hay goi y luon lich trinh 3 ngay 2 dem, gio khoi hanh hop ly, dia diem an sang, quan cafe ngam doi va khung gio nen san may.',
                            'Ben canh do, ban nen chen cac lien ket noi bo sang trang tour, trang diem den, trang lien he hoac trang dat cho. Dieu nay giup nguoi xem di chuyen thuan hon, tang thoi gian tren site va cung la mot dau hieu tot cho ca trai nghiem nguoi dung lan qua trinh xet duyet web.',
                            'Neu duy tri deu dan mot muc blog chat luong, website du lich se khong con la mot trang gioi thieu dich vu don thuan ma tro thanh noi tim thong tin huu ich. Day la huong di ben vung hon cho SEO va cho ca viec xay dung do tin cay khi xin duyet quang cao.',
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'huong-dan-dat-ve-tau-va-chuan-bi-hanh-trinh',
                'title' => 'Huong dan dat ve tau va chuan bi hanh trinh de tranh phat sinh chi phi',
                'category' => 'Huong dan dat cho',
                'published_at' => '2026-03-29',
                'read_time' => '7 phut doc',
                'image' => asset('clients/images/bg_4.jpg'),
                'sections' => [
                    [
                        'heading' => 'Xac dinh nhu cau truoc khi dat ve',
                        'paragraphs' => [
                            'Truoc khi dat ve tau hoac dat tour tron goi, ban nen xac dinh ro so nguoi tham gia, do tuoi, muc uu tien ve thoi gian va kha nang chi tra. Voi gia dinh co tre nho hoac nguoi lon tuoi, yeu to quan trong thuong la gio di hop ly, cho ngoi de chiu va kha nang ket noi phuong tien khi den noi.',
                            'Nhieu nguoi co thoi quen tim gia re nhat truoc, sau do moi xem lich trinh. Cach lam nay de dan toi viec phai doi gio, doi ga, doi xe va tang met moi khong can thiet. Neu website co bai viet huong dan dat cho ro rang, nguoi dung se de ra quyet dinh hon va it gap tinh trang bo gio giua duong.',
                        ],
                    ],
                    [
                        'heading' => 'Nhung thong tin can kiem tra ky truoc khi thanh toan',
                        'paragraphs' => [
                            'Ban can kiem tra ten hanh khach, so giay to, gio khoi hanh, diem di diem den va chinh sach doi tra. Voi cac hanh trinh dai, nen xem them thong tin hanh ly, bua an, kha nang ho tro neu co nguoi gia hoac tre em di cung.',
                            'Neu ban dat qua website du lich, phan huong dan thanh toan can de tim, ngon ngu de hieu va nen co trang lien he khi can ho tro. Day la mot dau hieu quan trong de nguoi dung cam thay an tam. Google AdSense cung thuong uu tien nhung website co cau truc ro rang, minh bach ve thong tin va khong gay nham lan.',
                            'Mot kinh nghiem don gian nhung rat hieu qua la chup lai thong tin dat cho sau khi thanh toan xong, luu email xac nhan va kiem tra lai trong vong 5 den 10 phut. Neu co sai sot, viec xu ly som bao gio cung de hon de sat gio di.',
                        ],
                    ],
                    [
                        'heading' => 'Toi uu hanh trinh sau khi da dat ve',
                        'paragraphs' => [
                            'Sau khi co ve, ban nen lap danh sach cong viec nho gom dat phong, sap xep xe dua don, kiem tra du bao thoi tiet va du phong mot khoan chi phi phat sinh. Cang co ke hoach som, kha nang chuyen di dien ra em va tiet kiem cang cao.',
                            'Voi hanh trinh ket hop du lich va nghi duong, hay de lich rong o ngay dau hoac ngay cuoi. Khach thuong danh gia cao nhung bai viet co chi dan thuc te nhu vay, boi vi noi dung khong chi ban y tuong ma con giai quyet duoc nhung van de ho rat hay gap.',
                            'Neu website cua ban dang muon tang co hoi duyet quang cao, nhung bai huong dan dat cho va chuan bi hanh trinh la noi dung rat nen co. Chung cham dung nhu cau tim kiem that, de doc, de chia se va rat phu hop voi linh vuc du lich.',
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'review-ha-noi-da-nang-4-ngay-3-dem',
                'title' => 'Review hanh trinh Ha Noi den Da Nang 4 ngay 3 dem tu trai nghiem thuc te',
                'category' => 'Review hanh trinh',
                'published_at' => '2026-03-29',
                'read_time' => '9 phut doc',
                'image' => asset('clients/images/bg_5.jpg'),
                'sections' => [
                    [
                        'heading' => 'Ngay 1: di chuyen va lam quen thanh pho',
                        'paragraphs' => [
                            'Chung toi khoi hanh tu Ha Noi vao buoi sang va co mat tai Da Nang truoc buoi trua. Diem cong lon cua Da Nang la san bay gan trung tam, nen qua trinh di ve khach san kha nhe. Sau khi nhan phong va nghi tam, nhom danh buoi chieu de di dao bien My Khe, uong ca phe va lam quen nhip song dia phuong.',
                            'Neu ban di lan dau, nen giu lich trinh ngay dau thong thoang. Viec ep lich qua day thuong khien nhom met va mat hung ngay tu dau chuyen di. Mot bai review trung thuc nen noi ca diem dep va nhung dieu can tranh, vi do moi la thu nguoi doc can.',
                        ],
                    ],
                    [
                        'heading' => 'Ngay 2: ket hop Da Nang va Hoi An',
                        'paragraphs' => [
                            'Buoi sang, chung toi chon tham quan mot so diem co ban trong thanh pho nhu ban dao Son Tra va cau Rong. Buoi chieu di Hoi An la hop ly hon vi pho co len den dep va khong khi de chiu. Thoi gian di chuyen khong qua xa nen rat phu hop voi nhung nhom muon gom nhieu trai nghiem trong mot ngay.',
                            'Chi phi an uong o ca Da Nang va Hoi An kha de chiu neu da tim hieu tu truoc. Dieu huu ich nhat rut ra sau chuyen di la nen dat truoc mot vai muc co dinh nhu ve tham quan, xe dua don hoac ban an cuoi tuan. Khi do, nhom chu dong hon va tranh duoc canh cho doi kha lau vao mua cao diem.',
                            'Noi dung review dang tin nen co ca anh chup that, gio di, gio den, muc chi phi uoc tinh va nhung danh gia can bang. Neu website xay dung duoc nhieu bai review kieu nay, nguoi dung se o lai lau hon va co ly do quay tro lai doc them.',
                        ],
                    ],
                    [
                        'heading' => 'Ngay 3 va 4: nghi duong, mua sam va tong ket',
                        'paragraphs' => [
                            'Ngay thu ba phu hop cho nghi duong nhieu hon, tam bien som, an trua gon nhe va chon mot diem trong thanh pho de mua dac san. Ngay cuoi cung nen de thoi gian dem lai do dung, tra phong dung gio va di ra san bay som hon du kien de tranh ket xe.',
                            'Tong chi phi cho hanh trinh 4 ngay 3 dem se phu thuoc vao cach dat phong va phuong an di chuyen, nhung neu len ke hoach som, muc ngan sach van de kiem soat. Dieu quan trong nhat la giu lich trinh can bang giua tham quan va nghi ngoi.',
                            'Voi nguoi dang can mot chuyen di de thu gian nhung van muon co nhieu diem check-in, Ha Noi den Da Nang la mot hanh trinh de di, de sap xep va phu hop cho ca cap doi lan gia dinh. Day cung la dang bai viet rat tot cho mot website du lich dang xay dung noi dung de duyet AdSense.',
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'review-lotus-train-ha-noi-da-nang',
                'title' => 'Review Lotus Train tu Ha Noi den Da Nang: trai nghiem cabin, wifi va giac ngu tren tau',
                'category' => 'Review Lotus Train',
                'published_at' => '2026-03-29',
                'read_time' => '10 phut doc',
                'image' => asset('clients/images/bg_2.jpg'),
                'sections' => [
                    [
                        'heading' => 'Vi sao nhieu nguoi quan tam Lotus Train',
                        'paragraphs' => [
                            'Lotus Train thu hut su chu y vi danh vao trai nghiem thoai mai hon so voi ky vong thong thuong khi di tau du lich duong dai. Nguoi doc thuong muon biet cabin co sach khong, giuong nam co em khong, dieu hoa co on dinh khong va wifi co dung duoc khong. Day deu la cac cau hoi rat thuc te ma mot bai review nen tra loi ro.',
                            'Khi viet bai review dang nay, gia tri lon nhat khong nam o viec khen hay che mot chieu, ma nam o su can bang. Nguoi doc can biet nhung diem phu hop voi minh va nhung diem co the bat tien. Chinh kieu noi dung minh bach do moi giup website xay dung uy tin lau dai.',
                            'Neu website co nhieu bai review hanh trinh nhu vay, Google cung de hieu rang day la noi dung co ich cho nguoi dang tim thong tin, khong chi la trang ban tour don thuan.',
                        ],
                    ],
                    [
                        'heading' => 'Trai nghiem cabin, tien nghi va khong gian',
                        'paragraphs' => [
                            'Mot trong nhung phan duoc quan tam nhat la cabin. Nguoi di tau du lich duong dai thuong ky vong khong gian gon gang, giuong sach, chan ga on va co cho de hanh ly hop ly. Neu cabin duoc giu ve sinh tot, anh sang vua phai va it tieng on tu hanh lang, trai nghiem tong the se tang len ro ret.',
                            'Wifi tren cac hanh trinh dai thuong khong nen duoc ky vong qua muc. Cach viet dung la thong bao ro luc nao ket noi on, luc nao yeu, va ai nen xem wifi chi la tien ich phu tro. Nguoi doc danh gia cao nhung bai viet noi that nhu vay hon la mot bai review qua dep nhung khong sat thuc te.',
                            'Ngoai cabin, nen bo sung thong tin ve nha ve sinh, khu vuc hanh lang, o cam sac, dieu hoa va thai do phuc vu. Day la nhung chi tiet lam nen authority cho noi dung review.',
                        ],
                    ],
                    [
                        'heading' => 'FAQ nho cho nguoi dang can dat cho',
                        'paragraphs' => [
                            'Cau hoi thuong gap thu nhat la co nen di tau du lich cho chang dai hay khong. Cau tra loi phu thuoc vao uu tien cua tung nguoi. Neu ban muon ngam canh, thich di chuyen thong tha va khong qua gap ve thoi gian, tau la lua chon dang can nhac.',
                            'Cau hoi thu hai la co phu hop voi gia dinh hay cap doi khong. Neu website co bai viet chi ro uu diem va han che cho tung nhom khach, muc do huu ich se tang rat nhanh. Day cung la cach de bien blog thanh tai san noi dung that su.',
                            'Ket lai, bai review Lotus Train nen huong den viec giup nguoi doc ra quyet dinh, khong nen dung lai o mo ta hinh anh chung chung. Chinh su cu the moi giup bai viet co gia tri ve SEO va AdSense.',
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'gia-ve-lotus-train-kinh-nghiem-xem-chi-phi',
                'title' => 'Gia ve Lotus Train va cach uoc tinh tong chi phi cho mot chuyen di duong dai',
                'category' => 'Gia ve va chi phi',
                'published_at' => '2026-03-29',
                'read_time' => '8 phut doc',
                'image' => asset('clients/images/bg_3.jpg'),
                'sections' => [
                    [
                        'heading' => 'Khong nen chi nhin vao gia ve niem yet',
                        'paragraphs' => [
                            'Khi tim thong tin gia ve, nhieu nguoi chi quan tam mot con so dau tien roi so sanh ngay. Thuc te, tong chi phi chuyen di thuong con bao gom phi dua don, bua an, nuoc uong, luu tru truoc hoac sau chang tau va cac khoan phat sinh nho. Mot bai viet huu ich nen giup nguoi doc nhin tong chi phi thay vi chi mot muc gia.',
                            'Neu khong the cap nhat bang gia theo thoi gian thuc, bai viet van co gia tri neu trinh bay cach tu tinh ngan sach. Vi du, co the huong dan nguoi doc tach chi phi thanh 3 nhom: di chuyen, luu tru va tieu dung phat sinh. Cach trinh bay nay ben vung hon va it gay hieu nham.',
                        ],
                    ],
                    [
                        'heading' => 'Yeu to lam gia tri thay doi',
                        'paragraphs' => [
                            'Gia ve co the khac nhau theo loai cabin, thoi diem dat, ngay trong tuan va mua du lich. Mua cao diem, cuoi tuan hoac dip nghi le thuong co muc gia cao hon. Vi vay, bai viet dang authority nen tap trung vao logic bien dong gia thay vi dua ra mot con so co dinh de roi nhanh chong lac hau.',
                            'Ngoai ra, mot so nguoi uu tien trai nghiem em, yen tinh va muon ngu nghi tot. Khi do, ho san sang tra cao hon de doi lay su thoai mai. Nguoi khac chi can di chuyen hop ly va tiet kiem. Website se huu ich hon neu chi ro moi muc chi phi phu hop voi kieu khach nao.',
                            'Noi dung dang nay rat hop cho AdSense vi no giai dap mot truy van tim kiem rat ro: gia ve va chi phi can chuan bi. Neu viet ky, bai se co kha nang thu hut traffic tot.',
                        ],
                    ],
                    [
                        'heading' => 'Mau huong dan ngan sach de nguoi doc tu ap dung',
                        'paragraphs' => [
                            'Ban co the goi y mot khung don gian: dau tien xac dinh loai cho muon dat, sau do cong them di chuyen dau den, bua an trong hanh trinh, chi phi luu tru va mot khoan du phong. Cach tinh tung buoc nhu vay de doc, de lam theo va an toan hon viec cam ket mot muc gia chung cho moi truong hop.',
                            'Neu co dieu kien, hay bo sung mot phan FAQ nho nhu dat som bao lau thi hop ly, di nhom co tiet kiem hon khong, va can chuan bi giay to gi. Cac phan hoi dap cu the giup bai viet day hon, co ich hon va tang kha nang duoc danh gia la noi dung chat luong.',
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'co-nen-di-lotus-train-khong',
                'title' => 'Co nen di Lotus Train khong: ai nen chon, ai nen can nhac va cach quyet dinh de phu hop',
                'category' => 'So sanh va tu van',
                'published_at' => '2026-03-29',
                'read_time' => '9 phut doc',
                'image' => asset('clients/images/bg_4.jpg'),
                'sections' => [
                    [
                        'heading' => 'Nhung nhom khach phu hop',
                        'paragraphs' => [
                            'Lotus Train thuong phu hop voi nguoi muon trai nghiem hanh trinh cham hon, co thoi gian ngam canh va uu tien su thu thai hon la toc do. Cap doi, nhom ban nho va nhung nguoi muon co mot ky niem khac voi may bay thuong de de mo long hon voi loai hinh nay.',
                            'Nguoc lai, voi nguoi can toi noi nhanh, lich trinh rat sat gio hoac khong quen nghi tren tau, can can nhac ky hon. Mot bai viet tu van dang tin nen chi ra ca hai mat de nguoi doc tu chon chinh xac cho minh.',
                        ],
                    ],
                    [
                        'heading' => 'So sanh cach ra quyet dinh',
                        'paragraphs' => [
                            'De quyet dinh co nen di Lotus Train khong, ban co the so sanh theo 4 tieu chi: thoi gian, ngan sach, muc do thoai mai mong muon va muc tieu chuyen di. Neu chuyen di ban huong den trai nghiem va nghi duong nhe, di tau co the hop. Neu muc tieu la den noi that nhanh de kip cong viec hoac lich tour day, lua chon khac co the thuc dung hon.',
                            'Noi dung authority khong can khang dinh mot dap an duy nhat. Dieu co gia tri hon la dua cho nguoi doc mot framework de tu ra quyet dinh. Khi website cung cap duoc kieu thong tin nay, nguoi doc se cam thay duoc ton trong va de quay lai hon.',
                        ],
                    ],
                    [
                        'heading' => 'Cach viet bai tu van de tang do tin cay',
                        'paragraphs' => [
                            'Mot bai tu van tot nen ket thuc bang ket luan ro: ai nen dat, ai nen cho them thong tin, va khi nao nen doi phuong an khac. Neu co the, hay chen lien ket sang bai review chi tiet, bai huong dan dat cho va trang lien he de nguoi doc tiep tuc tim hieu.',
                            'Voi muc tieu duyet quang cao, cac bai dang hoi dap, so sanh va tu van cu the nhu the nay se bo sung rat tot cho cac bai review. Chung tao thanh mot cum noi dung hop ly va day dan hon trong mat Google.',
                        ],
                    ],
                ],
            ],
        ];
    }
}
