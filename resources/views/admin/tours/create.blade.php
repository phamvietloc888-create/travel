@php
    $title = 'Tạo tour';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Quản lý tour</p>
            <h1 class="text-2xl font-semibold tracking-tight">Tạo tour mới</h1>
        </div>
        <a href="{{ route('admin.tours.index') }}" class="btn-secondary">Quay lại</a>
    </div>

    <form method="POST" action="{{ route('admin.tours.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                <p class="font-semibold">Tạo tour chưa thành công. Vui lòng kiểm tra các lỗi sau:</p>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-admin.card title="Thông tin chính">
            <div class="grid gap-4 md:grid-cols-2">
                <x-admin.input label="Tên tour" name="name" value="{{ old('name') }}" required />
                <x-admin.input label="Slug" name="slug" value="{{ old('slug') }}" hint="Tự sinh nếu để trống" />

                <div class="space-y-1">
                    <label class="label">Điểm đến</label>
                    <select name="destination_id" class="input" required>
                        <option value="">Chọn điểm đến</option>
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" @selected(old('destination_id') == $destination->id)>{{ $destination->name }}</option>
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
                            <option value="{{ $status }}" @selected(old('status') === $status)>{{ ucfirst(strtolower($status)) }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <x-admin.input label="Giá người lớn" name="price_adult" type="number" step="1000" value="{{ old('price_adult') }}" required />
                <x-admin.input label="Giá trẻ em" name="price_child" type="number" step="1000" value="{{ old('price_child') }}" />
                <x-admin.input label="Số ngày" name="duration_days" type="number" value="{{ old('duration_days', 3) }}" required />
                <x-admin.input label="Nơi khởi hành" name="start_location" value="{{ old('start_location') }}" />
                <x-admin.input label="Số người tối đa" name="max_people" type="number" value="{{ old('max_people', 10) }}" required />
                <x-admin.input label="Số chỗ còn" name="available_seats" type="number" value="{{ old('available_seats', 0) }}" required />
            </div>
        </x-admin.card>

        <x-admin.card title="Hình ảnh">
            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-1">
                    <label class="label">Thumbnail</label>
                    <input type="file" name="thumbnail" class="input" data-image-input data-preview-target="tour-thumbnail-preview-create" />
                    <div id="tour-thumbnail-preview-create" class="hidden overflow-hidden rounded-2xl border border-slate-200 bg-white p-2">
                        <img src="" alt="Thumbnail preview" class="h-40 w-full rounded-xl object-cover">
                    </div>
                    @error('thumbnail')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="label">Ảnh gallery</label>
                    <input type="file" name="images[]" class="input" multiple data-gallery-input data-gallery-limit="3" data-gallery-preview="tour-gallery-preview-create" />
                    <p class="text-xs text-slate-500">Tối đa 3 ảnh gallery cho mỗi tour.</p>
                    @error('images')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <div id="tour-gallery-preview-create" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3"></div>
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Nội dung">
            <div class="space-y-4">
                <div class="space-y-1">
                    <label class="label">Mô tả ngắn</label>
                    <textarea name="short_desc" rows="3" class="input">{{ old('short_desc') }}</textarea>
                    @error('short_desc')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="label">Nội dung chi tiết</label>
                    <textarea name="content" rows="5" class="input">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Lịch trình mặc định">
            <div class="space-y-2">
                @for($i = 0; $i < 3; $i++)
                    <div class="grid gap-2 md:grid-cols-12">
                        <input class="input md:col-span-2" type="number" name="schedules[{{$i}}][day_no]" placeholder="Ngày" value="{{ old("schedules.$i.day_no", $i + 1) }}">
                        <input class="input md:col-span-4" type="text" name="schedules[{{$i}}][title]" placeholder="Tiêu đề" value="{{ old("schedules.$i.title") }}">
                        <input class="input md:col-span-6" type="text" name="schedules[{{$i}}][detail]" placeholder="Mô tả" value="{{ old("schedules.$i.detail") }}">
                    </div>
                @endfor
            </div>
        </x-admin.card>

        <div class="flex flex-wrap gap-3">
            <button type="submit" class="btn-primary">Lưu tour</button>
            <a href="{{ route('admin.tours.index') }}" class="btn-secondary">Hủy</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    (function () {
        document.querySelectorAll('[data-image-input]').forEach((input) => {
            const preview = document.getElementById(input.dataset.previewTarget);
            const image = preview?.querySelector('img');
            if (!preview || !image) return;

            input.addEventListener('change', function () {
                const file = this.files?.[0];
                if (!file) {
                    preview.classList.add('hidden');
                    image.src = '';
                    return;
                }

                image.src = URL.createObjectURL(file);
                image.onload = () => URL.revokeObjectURL(image.src);
                preview.classList.remove('hidden');
            });
        });

        document.querySelectorAll('[data-gallery-input]').forEach((input) => {
            const preview = document.getElementById(input.dataset.galleryPreview);
            if (!preview) return;

            const maxFiles = Number(input.dataset.galleryLimit || 3);
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
                selectedFiles = incoming.slice(0, maxFiles);
                syncInputFiles();
                renderPreview();
            });
        });
    })();
</script>
@endpush
