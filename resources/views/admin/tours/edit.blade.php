@php
    $title = 'Sửa tour';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Cập nhật tour</p>
            <h1 class="text-2xl font-semibold tracking-tight">{{ $tour->name }}</h1>
        </div>
        <a href="{{ route('admin.tours.index') }}" class="btn-secondary">Quay lại</a>
    </div>

    <form method="POST" action="{{ route('admin.tours.update', $tour) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                <p class="font-semibold">Cập nhật chưa thành công. Vui lòng kiểm tra các lỗi sau:</p>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-admin.card title="Thông tin chính">
            <div class="grid gap-4 md:grid-cols-2">
                <x-admin.input label="Tên tour" name="name" value="{{ old('name', $tour->name) }}" required />
                <x-admin.input label="Slug" name="slug" value="{{ old('slug', $tour->slug) }}" />

                <div class="space-y-1">
                    <label class="label">Điểm đến</label>
                    <select name="destination_id" class="input" required>
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" @selected(old('destination_id', $tour->destination_id) == $destination->id)>{{ $destination->name }}</option>
                        @endforeach
                    </select>
                    @error('destination_id')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="label">Trạng thái</label>
                    <select name="status" class="input">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @selected(old('status', $tour->status) === $status)>{{ ucfirst(strtolower($status)) }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <x-admin.input label="Giá người lớn" name="price_adult" type="number" step="1000" value="{{ old('price_adult', $tour->price_adult) }}" required />
                <x-admin.input label="Giá trẻ em" name="price_child" type="number" step="1000" value="{{ old('price_child', $tour->price_child) }}" />
                <x-admin.input label="Số ngày" name="duration_days" type="number" value="{{ old('duration_days', $tour->duration_days) }}" required />
                <x-admin.input label="Nơi khởi hành" name="start_location" value="{{ old('start_location', $tour->start_location) }}" />
                <div class="space-y-1">
                    <label class="label">Phương tiện di chuyển</label>
                    <select name="transport_type" class="input">
                        <option value="">Chọn phương tiện</option>
                        @foreach($transportOptions as $transportOption)
                            <option value="{{ $transportOption }}" @selected(old('transport_type', $tour->transport_type) === $transportOption)>{{ $transportOption }}</option>
                        @endforeach
                    </select>
                    @error('transport_type')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <x-admin.input label="Khách sạn" name="hotel_name" value="{{ old('hotel_name', $tour->hotel_name) }}" />
                <x-admin.input label="Số sao khách sạn" name="hotel_stars" type="number" min="1" max="5" value="{{ old('hotel_stars', $tour->hotel_stars) }}" />
                <x-admin.input label="Số người tối đa" name="max_people" type="number" value="{{ old('max_people', $tour->max_people) }}" required />
                <x-admin.input label="Số chỗ còn" name="available_seats" type="number" value="{{ old('available_seats', $tour->available_seats) }}" required />
            </div>
        </x-admin.card>

        <x-admin.card title="Hình ảnh">
            <div class="space-y-5">
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="space-y-2">
                        <label class="label">Thumbnail mới</label>
                        <input type="file" name="thumbnail" class="input" />
                        @if($tour->thumbnail_path)
                            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 dark:border-slate-700 dark:bg-slate-800">
                                <img src="{{ $tour->thumbnail_url }}" class="h-40 w-full object-cover" alt="{{ $tour->name }}">
                            </div>
                        @endif
                        @error('thumbnail')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="label">Thêm ảnh gallery</label>
                        <input type="file" name="images[]" class="input" multiple data-gallery-input data-gallery-limit="{{ max(0, 3 - $tour->images->count()) }}" data-gallery-preview="tour-gallery-preview-edit" />
                        <p class="text-xs text-slate-500">Tối đa 3 ảnh gallery cho mỗi tour. Hiện có {{ $tour->images->count() }}/3 ảnh.</p>
                        @error('images')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <div id="tour-gallery-preview-edit" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3"></div>
                    </div>
                </div>

                @if($tour->images->isNotEmpty())
                    <div class="space-y-2">
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">Gallery hiện tại</p>
                        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($tour->images as $img)
                                <div class="space-y-2 rounded-2xl border border-slate-200 p-2 dark:border-slate-700">
                                    <img src="{{ $img->image_url }}" class="h-28 w-full rounded-xl object-cover" alt="">
                                    <button
                                        type="submit"
                                        form="delete-tour-image-{{ $img->id }}"
                                        class="w-full rounded-lg border border-rose-200 px-2 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50 dark:border-rose-800 dark:hover:bg-rose-950/30"
                                        onclick="return confirm('Bạn có chắc muốn xóa ảnh này không?');"
                                    >
                                        Xóa ảnh
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </x-admin.card>

        <x-admin.card title="Nội dung">
            <div class="space-y-4">
                <div class="space-y-1">
                    <label class="label">Mô tả ngắn</label>
                    <textarea name="short_desc" rows="3" class="input">{{ old('short_desc', $tour->short_desc) }}</textarea>
                    @error('short_desc')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="label">Nội dung chi tiết</label>
                    <textarea name="content" rows="5" class="input">{{ old('content', $tour->content) }}</textarea>
                    @error('content')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Lịch trình">
            <div class="space-y-2">
                @foreach(old('schedules', $tour->schedules->toArray()) as $i => $schedule)
                    <div class="grid gap-2 md:grid-cols-12">
                        <input class="input md:col-span-2" type="number" name="schedules[{{$i}}][day_no]" value="{{ $schedule['day_no'] ?? ($i+1) }}" placeholder="Ngày">
                        <input class="input md:col-span-4" type="text" name="schedules[{{$i}}][title]" value="{{ $schedule['title'] ?? '' }}" placeholder="Tiêu đề">
                        <input class="input md:col-span-6" type="text" name="schedules[{{$i}}][detail]" value="{{ $schedule['detail'] ?? '' }}" placeholder="Mô tả">
                    </div>
                @endforeach

                @for($i = 0; $i < 2; $i++)
                    <div class="grid gap-2 md:grid-cols-12">
                        <input class="input md:col-span-2" type="number" name="schedules[new{{$i}}][day_no]" value="" placeholder="Ngày">
                        <input class="input md:col-span-4" type="text" name="schedules[new{{$i}}][title]" placeholder="Tiêu đề">
                        <input class="input md:col-span-6" type="text" name="schedules[new{{$i}}][detail]" placeholder="Mô tả">
                    </div>
                @endfor
            </div>
        </x-admin.card>

        <div class="flex flex-wrap gap-3">
            <button type="submit" class="btn-primary">Cập nhật tour</button>
            <a href="{{ route('admin.tours.index') }}" class="btn-secondary">Hủy</a>
        </div>
    </form>

    @if($tour->images->isNotEmpty())
        @foreach($tour->images as $img)
            <form id="delete-tour-image-{{ $img->id }}" method="POST" action="{{ route('admin.tours.images.destroy', [$tour, $img]) }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @endif
@endsection

@push('scripts')
<script>
    (function () {
        const input = document.querySelector('[data-gallery-input]');
        if (!input) return;

        const preview = document.getElementById(input.dataset.galleryPreview);
        const maxFiles = Number(input.dataset.galleryLimit || 0);
        let selectedFiles = [];

        function syncInputFiles() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach((file) => dataTransfer.items.add(file));
            input.files = dataTransfer.files;
        }

        function renderPreview() {
            preview.innerHTML = '';

            selectedFiles.forEach((file, index) => {
                const item = document.createElement('div');
                item.className = 'overflow-hidden rounded-2xl border border-slate-200 bg-white p-2';

                const image = document.createElement('img');
                image.className = 'h-28 w-full rounded-xl object-cover';
                image.alt = file.name;
                image.src = URL.createObjectURL(file);
                image.onload = () => URL.revokeObjectURL(image.src);

                const caption = document.createElement('div');
                caption.className = 'mt-2 flex items-center justify-between gap-2';
                caption.innerHTML = '<p class="truncate text-xs text-slate-500">' + file.name + '</p>';

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'rounded-lg border border-rose-200 px-2 py-1 text-xs font-semibold text-rose-600 hover:bg-rose-50';
                removeBtn.textContent = 'Xóa';
                removeBtn.addEventListener('click', function () {
                    selectedFiles.splice(index, 1);
                    syncInputFiles();
                    renderPreview();
                });

                caption.appendChild(removeBtn);
                item.appendChild(image);
                item.appendChild(caption);
                preview.appendChild(item);
            });
        }

        input.addEventListener('change', function () {
            const incoming = Array.from(this.files || []);
            if (maxFiles <= 0) {
                selectedFiles = [];
            } else {
                const remainingSlots = Math.max(0, maxFiles - selectedFiles.length);
                const nextFiles = incoming.slice(0, remainingSlots);
                selectedFiles = selectedFiles.concat(nextFiles);
            }
            syncInputFiles();
            renderPreview();
        });
    })();
</script>
@endpush
