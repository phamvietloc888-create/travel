@php($title = 'Sửa tour')
@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500">Cập nhật tour</p>
            <h1 class="text-2xl font-semibold">{{ $tour->name }}</h1>
        </div>
        <a href="{{ route('admin.tours.index') }}" class="btn-secondary">Quay lại</a>
    </div>

    <form method="POST" action="{{ route('admin.tours.update', $tour) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <x-admin.card>
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
                <x-admin.input label="Giá người lớn" name="price_adult" type="number" step="1000" value="{{ old('price_adult', $tour->price_adult) }}" required />
                <x-admin.input label="Giá trẻ em" name="price_child" type="number" step="1000" value="{{ old('price_child', $tour->price_child) }}" />
                <x-admin.input label="Số ngày" name="duration_days" type="number" value="{{ old('duration_days', $tour->duration_days) }}" required />
                <x-admin.input label="Nơi khởi hành" name="start_location" value="{{ old('start_location', $tour->start_location) }}" />
                <x-admin.input label="Số người tối đa" name="max_people" type="number" value="{{ old('max_people', $tour->max_people) }}" required />
                <x-admin.input label="Số chỗ còn" name="available_seats" type="number" value="{{ old('available_seats', $tour->available_seats) }}" required />
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
                <div class="space-y-2">
                    <label class="label">Thumbnail</label>
                    <input type="file" name="thumbnail" class="input" />
                    @if($tour->thumbnail_path)
                        <img src="{{ Storage::url($tour->thumbnail_path) }}" class="mt-2 h-24 rounded-lg object-cover" alt="">
                    @endif
                    @error('thumbnail')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-1 md:col-span-2">
                    <label class="label">Ảnh gallery</label>
                    <input type="file" name="images[]" class="input" multiple />
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach($tour->images as $img)
                            <img src="{{ Storage::url($img->image_path) }}" class="h-16 w-24 rounded object-cover" alt="">
                        @endforeach
                    </div>
                    @error('images.*')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-1 md:col-span-2">
                    <label class="label">Mô tả ngắn</label>
                    <textarea name="short_desc" rows="2" class="input">{{ old('short_desc', $tour->short_desc) }}</textarea>
                    @error('short_desc')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-1 md:col-span-2">
                    <label class="label">Nội dung</label>
                    <textarea name="content" rows="4" class="input">{{ old('content', $tour->content) }}</textarea>
                    @error('content')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-1 md:col-span-2">
                    <label class="label">Lịch trình</label>
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
                </div>
            </div>
        </x-admin.card>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Lưu</button>
            <a href="{{ route('admin.tours.index') }}" class="btn-secondary">Hủy</a>
        </div>
    </form>
@endsection
