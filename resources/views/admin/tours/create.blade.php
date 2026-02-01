    @php($title = 'Tạo tour')
    @extends('admin.layouts.app')

    @section('content')
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Thêm tour mới</p>
                <h1 class="text-2xl font-semibold">Create tour</h1>
            </div>
            <a href="{{ route('admin.tours.index') }}" class="btn-secondary">Quay lại</a>
        </div>

        <form method="POST" action="{{ route('admin.tours.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <x-admin.card>
                <div class="grid gap-4 md:grid-cols-2">
                    <x-admin.input label="Tên tour" name="name" value="{{ old('name') }}" required />
                    <x-admin.input label="Slug" name="slug" value="{{ old('slug') }}" hint="Tự sinh từ tên nếu bỏ trống" />
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
                    <x-admin.input label="Giá người lớn" name="price_adult" type="number" step="1000" value="{{ old('price_adult') }}" required />
                    <x-admin.input label="Giá trẻ em" name="price_child" type="number" step="1000" value="{{ old('price_child') }}" />
                    <x-admin.input label="Số ngày" name="duration_days" type="number" value="{{ old('duration_days', 3) }}" required />
                    <x-admin.input label="Nơi khởi hành" name="start_location" value="{{ old('start_location') }}" />
                    <x-admin.input label="Số người tối đa" name="max_people" type="number" value="{{ old('max_people', 10) }}" required />
                    <x-admin.input label="Số chỗ còn" name="available_seats" type="number" value="{{ old('available_seats', 0) }}" required />
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
                    <div class="space-y-1">
                        <label class="label">Thumbnail</label>
                        <input type="file" name="thumbnail" class="input" />
                        @error('thumbnail')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1 md:col-span-2">
                        <label class="label">Ảnh gallery</label>
                        <input type="file" name="images[]" class="input" multiple />
                        @error('images.*')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1 md:col-span-2">
                        <label class="label">Mô tả ngắn</label>
                        <textarea name="short_desc" rows="2" class="input">{{ old('short_desc') }}</textarea>
                        @error('short_desc')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1 md:col-span-2">
                        <label class="label">Nội dung</label>
                        <textarea name="content" rows="4" class="input">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1 md:col-span-2">
                        <label class="label">Lịch trình (ngày - tiêu đề - mô tả)</label>
                        <div class="space-y-2">
                            @for($i = 0; $i < 3; $i++)
                                <div class="grid gap-2 md:grid-cols-12">
                                    <input class="input md:col-span-2" type="number" name="schedules[{{$i}}][day_no]" placeholder="Ngày" value="{{ old("schedules.$i.day_no", $i+1) }}">
                                    <input class="input md:col-span-4" type="text" name="schedules[{{$i}}][title]" placeholder="Tiêu đề" value="{{ old("schedules.$i.title") }}">
                                    <input class="input md:col-span-6" type="text" name="schedules[{{$i}}][detail]" placeholder="Mô tả" value="{{ old("schedules.$i.detail") }}">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </x-admin.card>

            <div class="flex gap-3">
                <button type="submit" class="btn-primary">Lưu</button>
                <a href="{{ route('admin.tours.index') }}" class="btn-secondary">Hủy</a>
            </div>
        </form>
    @endsection
