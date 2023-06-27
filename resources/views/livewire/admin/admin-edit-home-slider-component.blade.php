<div>
    <style>
        nav svg {
            height: 20px;
        }
        nav .hidden {
            display: block;
        }
    </style>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow">Home</a>
                    <span></span> Edit Categories
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        Edit Slider
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('admin.home.slider') }}" class="btn btn-success float-end">All Slider</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                                @endif
                                <form wire:submit.prevent="updateSlide">
                                    <div class="mb-3 mt-3">
                                        <label for="name" class="form-label">Top Title</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Top Title" wire:model="top_title">
                                        @error('top_title')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="slug" class="form-label">Title</label>
                                        <input type="text" name="slug" class="form-control" placeholder="Enter Title" wire:model="title">
                                        @error('title')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="slug" class="form-label">Sub Title</label>
                                        <input type="text" name="slug" class="form-control" placeholder="Enter Sub Title" wire:model="sub_title">
                                        @error('sub_title')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="slug" class="form-label">Offer</label>
                                        <input type="text" name="slug" class="form-control" placeholder="Enter Offer" wire:model="offer">
                                        @error('offer')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="slug" class="form-label">Link</label>
                                        <input type="text" name="slug" class="form-control" placeholder="Enter Link" wire:model="link">
                                        @error('link')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="slug" class="form-label">Status</label>
                                        <select name="" class="form-control" wire:model="status">
                                            <option value="1">Active</option>
                                            <option value="0">InActive</option>
                                        </select>
                                        @error('status')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="slug" class="form-label">Image</label>
                                        <input type="file" class="form-control" wire:model="newimage">
                                        @if ($newimage)
                                            <img src="{{ $newimage->temporaryUrl() }}" width="100">
                                        @else
                                            <img src="{{ asset('assets/imgs/slider') }}/{{ $image }}" width="100">
                                        @endif
                                        @error('image')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary float-end">Submit</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
