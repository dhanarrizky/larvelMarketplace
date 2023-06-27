<div>
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
                        <span></span> All Products
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
                                            All Products
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('admin.product.add') }}" class="btn btn-success float-end">Add New Product</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if (Session::has('message'))
                                        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                                    @endif
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Stock</th>
                                                <th>Price</th>
                                                <th>Category</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = ($products->currentPage()-1)*$products->perPage();
                                            @endphp
                                            @foreach ($products as $p)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td><img src="{{ asset('assets/imgs/products') }}/{{ $p->image }}" alt="{{ $p->name }}" width="60"></td>
                                                <td>{{ $p->name }}</td>
                                                <td>{{ $p->stock_status }}</td>
                                                <td>{{ $p->regular_price }}</td>
                                                {{-- untuk menggabungkan kategory ke product supaya category name bisa di panggil maka kita harus menggabungkan pada product.php pada file models --}}
                                                <td>{{ $p->category->name }}</td>
                                                <td>{{ $p->created_at }}</td>
                                                <td>
                                                    <a href="{{ route('admin.product.edit',['product_id'=>$p->id]) }}" class="text-info">Edit</a>
                                                    {{-- delete button --}}
                                                    <a href="#" class="text-danger" onclick="deleteConfirmation({{ $p->id }})" style="margin-left:20px;">Delete</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $products->links() }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>

{{-- for page alert before make sure user want to deleted it or not --}}
<div class="modal" id="deleteConfirmation">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body pb-30 pt-30">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4 class="pb-3">Do You Want to Delete this record ?!</h4>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#deleteConfirmation">Cencel</button>
                        <button type="button" class="btn btn-danger" onclick="deleteProduct()">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function deleteConfirmation(id)
        {
            @this.set('product_id',id);
            $('#deleteConfirmation').modal('show');
        }

        function deleteProduct()
        {
            @this.call('deleteProduct');
            $('#deleteConfirmation').modal('hide')
        }
    </script>
@endpush
