@extends('clients.layout')

@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('clients/images/bg_4.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="{{ route('home') }}">Trang chu <i class="fa fa-chevron-right"></i></a>
                        </span>
                        <span>Privacy Policy <i class="fa fa-chevron-right"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Chinh Sach Bao Mat</h1>
                    <p class="policy-hero-copy">Trang nay giai thich cach Lotus Vietnam Travel thu thap, su dung va bao ve thong tin cua nguoi dung khi truy cap website hoac gui yeu cau ho tro.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section policy-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="policy-shell ftco-animate">
                        <section class="policy-block">
                            <h2>1. Thong tin chung</h2>
                            <p>Lotus Vietnam Travel cam ket ton trong quyen rieng tu cua nguoi dung. Chinh sach nay duoc lap ra de giup ban hieu ro nhung loai thong tin co the duoc tiep nhan trong qua trinh su dung website, dat tour hoac gui yeu cau ho tro.</p>
                        </section>

                        <section class="policy-block">
                            <h2>2. Thong tin co the duoc thu thap</h2>
                            <p>Chung toi co the tiep nhan cac thong tin do nguoi dung chu dong cung cap nhu ho ten, email, so dien thoai, noi dung lien he va thong tin lien quan den booking. Mot so du lieu ky thuat nhu dia chi IP, thiet bi, trinh duyet hoac hanh vi dieu huong cung co the duoc ghi nhan de cai thien trai nghiem su dung.</p>
                        </section>

                        <section class="policy-block">
                            <h2>3. Muc dich su dung thong tin</h2>
                            <p>Thong tin duoc su dung de phan hoi yeu cau cua khach hang, xac nhan thong tin dat cho, nang cao chat luong dich vu, phat hien loi van hanh va giu cho website hoat dong on dinh. Chung toi khong ban thong tin ca nhan cua nguoi dung cho ben thu ba vi muc dich thuong mai trai phep.</p>
                        </section>

                        <section class="policy-block">
                            <h2>4. Cookie va cong nghe do luong</h2>
                            <p>Website co the su dung cookie hoac cong cu do luong de hieu cach nguoi dung truy cap noi dung va toi uu hoa giao dien. Cac cong cu quang cao hoac phan tich cua ben thu ba, neu duoc kich hoat, co the su dung cookie theo chinh sach rieng cua ho.</p>
                        </section>

                        <section class="policy-block">
                            <h2>5. Bao mat du lieu</h2>
                            <p>Chung toi co gang ap dung cac bien phap ky thuat va quy trinh quan ly hop ly de han che truy cap trai phep, thay doi hoac that thoat du lieu. Tuy nhien, khong co he thong truyen du lieu nao tren Internet co the dam bao an toan tuyet doi.</p>
                        </section>

                        <section class="policy-block">
                            <h2>6. Lien ket ben thu ba</h2>
                            <p>Website co the chua lien ket den cac trang hoac dich vu ben ngoai. Noi dung va chinh sach bao mat cua cac ben nay nam ngoai pham vi kiem soat cua Lotus Vietnam Travel, vi vay nguoi dung nen tham khao chinh sach rieng truoc khi cung cap du lieu.</p>
                        </section>

                        <section class="policy-block">
                            <h2>7. Lien he ve quyen rieng tu</h2>
                            <p>Neu ban can yeu cau cap nhat, dieu chinh hoac giai dap ve du lieu ca nhan, vui long truy cap trang lien he de gui thong tin cho chung toi. Chung toi se co gang phan hoi trong thoi gian hop ly.</p>
                            <p class="mb-0">
                                <a href="{{ route('contact') }}" class="btn btn-primary py-3 px-4">Di den trang lien he</a>
                            </p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .policy-hero-copy {
            max-width: 760px;
            margin: 0 auto;
            color: rgba(255, 255, 255, 0.9);
            font-size: 17px;
            line-height: 1.85;
        }

        .policy-section {
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
        }

        .policy-shell {
            padding: 40px 36px;
            border-radius: 30px;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: 0 24px 56px rgba(15, 23, 42, 0.08);
        }

        .policy-block + .policy-block {
            margin-top: 26px;
        }

        .policy-block h2 {
            margin-bottom: 14px;
            font-size: 30px;
            color: #0f172a;
        }

        .policy-block p {
            margin-bottom: 14px;
            color: #334155;
            line-height: 1.9;
            font-size: 17px;
        }

        @media (max-width: 767.98px) {
            .policy-shell {
                padding: 26px 18px;
                border-radius: 24px;
            }

            .policy-block h2 {
                font-size: 24px;
            }

            .policy-block p {
                font-size: 16px;
            }
        }
    </style>
@endsection
