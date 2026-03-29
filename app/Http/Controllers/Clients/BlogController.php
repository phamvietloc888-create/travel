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
        ];
    }
}
