<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ChatThread;
use App\Models\Destination;
use App\Models\Promotion;
use App\Models\Tour;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class SitemapController extends Controller
{
    public function index(): View
    {
        $items = $this->buildItems();

        return view('sitemap.index', [
            'items' => $items,
            'groupedItems' => $items->groupBy('section'),
            'generatedAt' => now(),
        ]);
    }

    public function xml(): Response
    {
        $items = $this->buildItems()
            ->unique('loc')
            ->values();

        return response()
            ->view('sitemap.xml', [
                'items' => $items,
                'generatedAt' => now(),
            ])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    protected function buildItems(): Collection
    {
        return collect()
            ->merge($this->publicItems())
            ->merge($this->authItems())
            ->merge($this->userItems())
            ->merge($this->adminItems())
            ->unique('loc')
            ->sortBy([
                ['section', 'asc'],
                ['loc', 'asc'],
            ])
            ->values();
    }

    protected function publicItems(): Collection
    {
        $items = collect([
            $this->makeItem('Public', 'Guest', 'Trang chu', route('home'), now(), 'daily', '1.0'),
            $this->makeItem('Public', 'Guest', 'Gioi thieu', route('about'), now(), 'monthly', '0.8'),
            $this->makeItem('Public', 'Guest', 'Lien he redirect ve home', route('contact'), now(), 'monthly', '0.3'),
            $this->makeItem('Public', 'Guest', 'Danh sach diem den', route('destinations.index'), now(), 'weekly', '0.9'),
            $this->makeItem('Public', 'Guest', 'Danh sach tour', route('tours.index'), now(), 'weekly', '0.9'),
            $this->makeItem('Public', 'Guest', 'Dang nhap', route('login'), now(), 'monthly', '0.3'),
            $this->makeItem('Public', 'Guest', 'Dang ky', route('register'), now(), 'monthly', '0.3'),
            $this->makeItem('Public', 'Guest', 'Quen mat khau', route('password.request'), now(), 'monthly', '0.2'),
            $this->makeItem('Public', 'Guest', 'QR thanh toan', route('payment.qr'), now(), 'monthly', '0.2'),
        ]);

        if (Schema::hasTable('destinations')) {
            $items = $items->merge(
                Destination::query()
                    ->select(['id', 'slug', 'name', 'status', 'updated_at'])
                    ->orderBy('name')
                    ->get()
                    ->flatMap(function (Destination $destination) {
                        $lastmod = $destination->updated_at ?? now();

                        return [
                            $this->makeItem(
                                'Public',
                                'Guest',
                                'Diem den: ' . $destination->name,
                                route('destinations.show', $destination->slug),
                                $lastmod,
                                'weekly',
                                $destination->status === 'PUBLISHED' ? '0.8' : '0.4'
                            ),
                            $this->makeItem(
                                'Public',
                                'Guest',
                                'Tour theo diem den: ' . $destination->name,
                                route('tours.byDestination', $destination->slug),
                                $lastmod,
                                'weekly',
                                $destination->status === 'PUBLISHED' ? '0.7' : '0.3'
                            ),
                        ];
                    })
            );
        }

        if (Schema::hasTable('tours')) {
            $items = $items->merge(
                Tour::query()
                    ->select(['id', 'slug', 'name', 'status', 'updated_at'])
                    ->orderBy('name')
                    ->get()
                    ->map(function (Tour $tour) {
                        return $this->makeItem(
                            'Public',
                            'Guest',
                            'Chi tiet tour: ' . $tour->name,
                            route('tours.show', $tour->slug),
                            $tour->updated_at ?? now(),
                            'weekly',
                            $tour->status === 'PUBLISHED' ? '0.8' : '0.3'
                        );
                    })
            );
        }

        return $items;
    }

    protected function authItems(): Collection
    {
        return collect([
            $this->makeItem('Auth', 'Authenticated', 'Xu ly dang nhap', $this->routeUrl('login.submit'), now(), 'monthly', '0.1', 'POST'),
            $this->makeItem('Auth', 'Authenticated', 'Xu ly dang ky', $this->routeUrl('register.submit'), now(), 'monthly', '0.1', 'POST'),
            $this->makeItem('Auth', 'Authenticated', 'Dang xuat', $this->routeUrl('logout'), now(), 'monthly', '0.1', 'POST'),
            $this->makeItem('Auth', 'Authenticated', 'Dat lai mat khau truc tiep', $this->routeUrl('password.direct'), now(), 'monthly', '0.1', 'POST'),
            $this->makeItem('Auth', 'Authenticated', 'Gui lien he', $this->routeUrl('contact.submit'), now(), 'monthly', '0.1', 'POST'),
            $this->makeItem('Auth', 'Authenticated', 'Gui review', $this->routeUrl('reviews.store'), now(), 'monthly', '0.1', 'POST'),
        ])->filter();
    }

    protected function userItems(): Collection
    {
        $items = collect([
            $this->makeItem('User', 'Authenticated', 'Ho so ca nhan', route('profile'), now(), 'weekly', '0.5'),
            $this->makeItem('User', 'Authenticated', 'Cap nhat ho so', $this->routeUrl('profile.update'), now(), 'monthly', '0.1', 'POST'),
            $this->makeItem('User', 'Authenticated', 'Doi mat khau', $this->routeUrl('profile.password'), now(), 'monthly', '0.1', 'POST'),
            $this->makeItem('User', 'Authenticated', 'Danh sach booking cua toi', route('profile.bookings'), now(), 'weekly', '0.4'),
            $this->makeItem('User', 'Authenticated', 'Wishlist redirect', route('profile.wishlist'), now(), 'monthly', '0.2'),
        ]);

        if (Schema::hasTable('tours')) {
            $items = $items->merge(
                Tour::query()
                    ->select(['id', 'name', 'updated_at'])
                    ->orderBy('name')
                    ->get()
                    ->flatMap(function (Tour $tour) {
                        return [
                            $this->makeItem(
                                'User',
                                'Authenticated',
                                'Checkout tour: ' . $tour->name,
                                route('checkout', $tour),
                                $tour->updated_at ?? now(),
                                'monthly',
                                '0.2'
                            ),
                            $this->makeItem(
                                'User',
                                'Authenticated',
                                'Xu ly checkout: ' . $tour->name,
                                $this->routeUrl('checkout.store'),
                                $tour->updated_at ?? now(),
                                'monthly',
                                '0.1',
                                'POST'
                            ),
                        ];
                    })
            );
        }

        if (Schema::hasTable('bookings')) {
            $items = $items->merge(
                Booking::query()
                    ->select(['id', 'updated_at'])
                    ->orderByDesc('id')
                    ->get()
                    ->flatMap(function (Booking $booking) {
                        $lastmod = $booking->updated_at ?? now();

                        return [
                            $this->makeItem('User', 'Authenticated', 'Xac nhan booking #' . $booking->id, route('booking.confirmation', $booking), $lastmod, 'monthly', '0.2'),
                            $this->makeItem('User', 'Authenticated', 'Thanh toan booking #' . $booking->id, route('booking.payment', $booking), $lastmod, 'monthly', '0.2'),
                            $this->makeItem('User', 'Authenticated', 'Gui thanh toan booking #' . $booking->id, $this->routeUrl('booking.payment.submit', $booking), $lastmod, 'monthly', '0.1', 'POST'),
                            $this->makeItem('User', 'Authenticated', 'Mo thong bao booking #' . $booking->id, route('profile.bookings.notification', $booking), $lastmod, 'monthly', '0.1'),
                            $this->makeItem('User', 'Authenticated', 'Huy booking #' . $booking->id, $this->routeUrl('profile.bookings.cancel', $booking), $lastmod, 'monthly', '0.1', 'POST'),
                            $this->makeItem('User', 'Authenticated', 'Xoa booking #' . $booking->id, $this->routeUrl('profile.bookings.delete', $booking), $lastmod, 'monthly', '0.1', 'DELETE'),
                        ];
                    })
            );
        }

        return $items->filter();
    }

    protected function adminItems(): Collection
    {
        $items = collect([
            $this->makeItem('Admin', 'Admin', 'Dashboard', route('admin.dashboard'), now(), 'daily', '0.6'),
            $this->makeItem('Admin', 'Admin', 'Tim kiem tong hop', route('admin.search'), now(), 'weekly', '0.4'),
            $this->makeItem('Admin', 'Admin', 'Danh sach diem den', route('admin.destinations.index'), now(), 'weekly', '0.4'),
            $this->makeItem('Admin', 'Admin', 'Tao diem den', route('admin.destinations.create'), now(), 'monthly', '0.2'),
            $this->makeItem('Admin', 'Admin', 'Danh sach tour', route('admin.tours.index'), now(), 'weekly', '0.4'),
            $this->makeItem('Admin', 'Admin', 'Tao tour', route('admin.tours.create'), now(), 'monthly', '0.2'),
            $this->makeItem('Admin', 'Admin', 'Danh sach booking', route('admin.bookings.index'), now(), 'weekly', '0.4'),
            $this->makeItem('Admin', 'Admin', 'Danh sach promotion', route('admin.promotions.index'), now(), 'weekly', '0.3'),
            $this->makeItem('Admin', 'Admin', 'Tao promotion', route('admin.promotions.create'), now(), 'monthly', '0.2'),
            $this->makeItem('Admin', 'Admin', 'Danh sach chat', route('admin.chats.index'), now(), 'weekly', '0.3'),
            $this->makeItem('Admin', 'Admin', 'Lich su thao tac', route('admin.histories.index'), now(), 'weekly', '0.3'),
            $this->makeItem('Admin', 'Admin', 'Media va thanh toan', route('admin.media.index'), now(), 'weekly', '0.3'),
            $this->makeItem('Admin', 'Admin', 'Danh sach reviews', route('admin.reviews.index'), now(), 'weekly', '0.3'),
        ]);

        if (Schema::hasTable('destinations')) {
            $items = $items->merge(
                Destination::query()
                    ->select(['id', 'name', 'updated_at'])
                    ->orderBy('name')
                    ->get()
                    ->flatMap(function (Destination $destination) {
                        $lastmod = $destination->updated_at ?? now();

                        return [
                            $this->makeItem('Admin', 'Admin', 'Admin xem diem den: ' . $destination->name, route('admin.destinations.show', $destination), $lastmod, 'monthly', '0.2'),
                            $this->makeItem('Admin', 'Admin', 'Admin sua diem den: ' . $destination->name, route('admin.destinations.edit', $destination), $lastmod, 'monthly', '0.2'),
                        ];
                    })
            );
        }

        if (Schema::hasTable('tours')) {
            $items = $items->merge(
                Tour::query()
                    ->select(['id', 'name', 'updated_at'])
                    ->orderBy('name')
                    ->get()
                    ->flatMap(function (Tour $tour) {
                        $lastmod = $tour->updated_at ?? now();

                        return [
                            $this->makeItem('Admin', 'Admin', 'Admin xem tour: ' . $tour->name, route('admin.tours.show', $tour), $lastmod, 'monthly', '0.2'),
                            $this->makeItem('Admin', 'Admin', 'Admin sua tour: ' . $tour->name, route('admin.tours.edit', $tour), $lastmod, 'monthly', '0.2'),
                        ];
                    })
            );
        }

        if (Schema::hasTable('bookings')) {
            $items = $items->merge(
                Booking::query()
                    ->select(['id', 'updated_at'])
                    ->orderByDesc('id')
                    ->get()
                    ->flatMap(function (Booking $booking) {
                        $lastmod = $booking->updated_at ?? now();

                        return [
                            $this->makeItem('Admin', 'Admin', 'Admin xem booking #' . $booking->id, route('admin.bookings.show', $booking), $lastmod, 'monthly', '0.2'),
                            $this->makeItem('Admin', 'Admin', 'Admin sua booking #' . $booking->id, route('admin.bookings.edit', $booking), $lastmod, 'monthly', '0.2'),
                            $this->makeItem('Admin', 'Admin', 'Admin cap nhat booking #' . $booking->id, $this->routeUrl('admin.bookings.update', $booking), $lastmod, 'monthly', '0.1', 'PATCH'),
                            $this->makeItem('Admin', 'Admin', 'Admin xoa booking #' . $booking->id, $this->routeUrl('admin.bookings.destroy', $booking), $lastmod, 'monthly', '0.1', 'DELETE'),
                            $this->makeItem('Admin', 'Admin', 'Admin doi trang thai booking #' . $booking->id, $this->routeUrl('admin.bookings.status', $booking), $lastmod, 'monthly', '0.1', 'PATCH'),
                        ];
                    })
            );
        }

        if (Schema::hasTable('promotions')) {
            $items = $items->merge(
                Promotion::query()
                    ->select(['id', 'title', 'updated_at'])
                    ->orderBy('title')
                    ->get()
                    ->flatMap(function (Promotion $promotion) {
                        $title = $promotion->title ?: ('Promotion #' . $promotion->id);
                        $lastmod = $promotion->updated_at ?? now();

                        return [
                            $this->makeItem('Admin', 'Admin', 'Admin xem promotion: ' . $title, route('admin.promotions.show', $promotion), $lastmod, 'monthly', '0.2'),
                            $this->makeItem('Admin', 'Admin', 'Admin sua promotion: ' . $title, route('admin.promotions.edit', $promotion), $lastmod, 'monthly', '0.2'),
                            $this->makeItem('Admin', 'Admin', 'Admin cap nhat promotion: ' . $title, $this->routeUrl('admin.promotions.update', $promotion), $lastmod, 'monthly', '0.1', 'PATCH'),
                            $this->makeItem('Admin', 'Admin', 'Admin xoa promotion: ' . $title, $this->routeUrl('admin.promotions.destroy', $promotion), $lastmod, 'monthly', '0.1', 'DELETE'),
                        ];
                    })
            );
        }

        if (Schema::hasTable('chat_threads')) {
            $items = $items->merge(
                ChatThread::query()
                    ->select(['id', 'updated_at'])
                    ->orderByDesc('id')
                    ->get()
                    ->flatMap(function (ChatThread $thread) {
                        $lastmod = $thread->updated_at ?? now();

                        return [
                            $this->makeItem('Admin', 'Admin', 'Admin xem chat #' . $thread->id, route('admin.chats.show', $thread), $lastmod, 'monthly', '0.2'),
                            $this->makeItem('Admin', 'Admin', 'Admin reply chat #' . $thread->id, $this->routeUrl('admin.chats.reply', $thread), $lastmod, 'monthly', '0.1', 'POST'),
                        ];
                    })
            );
        }

        return $items->filter();
    }

    protected function makeItem(
        string $section,
        string $access,
        string $label,
        ?string $loc,
        $lastmod,
        string $changefreq,
        string $priority,
        string $method = 'GET'
    ): ?array {
        if (!$loc) {
            return null;
        }

        return [
            'section' => $section,
            'access' => $access,
            'label' => $label,
            'loc' => $loc,
            'method' => $method,
            'lastmod' => optional($lastmod)->toAtomString() ?? now()->toAtomString(),
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    }

    protected function routeUrl(string $name, mixed $parameters = []): ?string
    {
        if (!Route::has($name)) {
            return null;
        }

        return route($name, $parameters);
    }
}
