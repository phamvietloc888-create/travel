# Sitemap Chức Năng Chính

## 1. Nhóm chức năng chính

### 1.1. Khách / Công khai

- Trang chủ
- Giới thiệu
- Điểm đến
  - Danh sách điểm đến
  - Chi tiết điểm đến
- Tours
  - Danh sách tour
  - Tour theo điểm đến
- Chi tiết tour
- Đăng nhập / Đăng ký

### 1.2. Người dùng

- Đặt tour
  - Checkout
  - Xác nhận booking
- Thanh toán
  - Gửi thông tin thanh toán
- Booking của tôi
  - Xem thông báo
  - Hủy booking
  - Xóa booking đã hủy
- Hồ sơ cá nhân
  - Cập nhật hồ sơ
  - Đổi mật khẩu
- Đánh giá / Hỗ trợ
  - Gửi đánh giá tour
  - Chat / Liên hệ hỗ trợ

### 1.3. Quản trị viên

- Dashboard
- Quản lý điểm đến
- Quản lý tour
- Quản lý booking
- Quản lý khuyến mãi
- Quản lý review
- Quản lý chat
- Media / Thanh toán

## 2. Mermaid Sitemap

```mermaid
flowchart LR
    ROOT["Website Du lịch"]

    ROOT --> PUBLIC
    ROOT --> MEMBER
    ROOT --> ADMIN

    subgraph PUBLIC["Khách / Công khai"]
        direction TB
        P1["Trang chủ"]
        P2["Giới thiệu"]
        P3["Điểm đến"]
        P4["Tours"]
        P5["Chi tiết tour"]
        P6["Đăng nhập / Đăng ký"]

        P3 --> P31["Danh sách điểm đến"]
        P3 --> P32["Chi tiết điểm đến"]
        P4 --> P41["Danh sách tour"]
        P4 --> P42["Tour theo điểm đến"]
    end

    subgraph MEMBER["Người dùng"]
        direction TB
        U1["Đặt tour"]
        U2["Thanh toán"]
        U3["Booking của tôi"]
        U4["Hồ sơ cá nhân"]
        U5["Đánh giá / Hỗ trợ"]

        U1 --> U11["Checkout"]
        U1 --> U12["Xác nhận booking"]
        U2 --> U21["Gửi thông tin thanh toán"]
        U3 --> U31["Xem thông báo"]
        U3 --> U32["Hủy booking"]
        U3 --> U33["Xóa booking đã hủy"]
        U4 --> U41["Cập nhật hồ sơ"]
        U4 --> U42["Đổi mật khẩu"]
        U5 --> U51["Gửi đánh giá tour"]
        U5 --> U52["Chat / Liên hệ hỗ trợ"]
    end

    subgraph ADMIN["Quản trị viên"]
        direction TB
        A1["Dashboard"]
        A2["Quản lý điểm đến"]
        A3["Quản lý tour"]
        A4["Quản lý booking"]
        A5["Quản lý khuyến mãi"]
        A6["Quản lý review"]
        A7["Quản lý chat"]
        A8["Media / Thanh toán"]
    end

    classDef root fill:#0f172a,stroke:#0f172a,color:#ffffff,stroke-width:2px;
    classDef public fill:#eff6ff,stroke:#2563eb,color:#000000,stroke-width:1.5px;
    classDef member fill:#ecfdf5,stroke:#059669,color:#000000,stroke-width:1.5px;
    classDef admin fill:#faf5ff,stroke:#7c3aed,color:#000000,stroke-width:1.5px;

    class ROOT root;
    class P1,P2,P3,P4,P5,P6,P31,P32,P41,P42 public;
    class U1,U2,U3,U4,U5,U11,U12,U21,U31,U32,U33,U41,U42,U51,U52 member;
    class A1,A2,A3,A4,A5,A6,A7,A8 admin;
```

## 3. Ghi chú

- Đây là sitemap trình bày chức năng chính, không phải sơ đồ luồng hoạt động.
- Nếu dùng trong slide, nên chụp phần Mermaid ở mục `2`.
- Nếu dùng trong báo cáo, có thể giữ cả mục `1` và mục `2` để vừa có danh sách vừa có sơ đồ.
