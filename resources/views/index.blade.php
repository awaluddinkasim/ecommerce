@extends('layouts.horizontal')

@section('content')
    @if (Request::has('q'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            Menampilkan semua hasil untuk "<b>{{ Request::get('q') }}</b>"
        </div>
    @else
        <div class="p-5 mb-4 bg-primary rounded-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 fw-bold">{{ config('app.name') }}</h1>
                        <p class="col-md-8 fs-4">
                            Selamat datang di {{ config('app.name') }}! Temukan berbagai produk terbaik untuk
                            kebutuhan Anda.
                        </p>
                        @if (!Auth::guard('admin')->check() && !Auth::check())
                            <button class="btn btn-success" onclick="document.location.href = '{{ route('login') }}'">
                                Login
                            </button>
                            <button class="btn btn-secondary" onclick="document.location.href = '{{ route('register') }}'">
                                Register
                            </button>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('assets/images/shopping.svg') }}" alt="" class="w-75">
                </div>
            </div>
        </div>
        <h3 class="mb-3">Daftar produk</h3>
    @endif

    <div class="product-grid">
        <div class="product-wrapper-grid">
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-sm-4 col-md-3 col-xl-2">
                        <div class="card">
                            <div class="product-box">
                                <div class="product-img">
                                    <img class="img-barang" src="{{ asset('files/product/' . $product->img) }}"
                                        alt="">
                                    <div class="product-hover">
                                        <ul>
                                            <li>
                                                <button class="btn" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#modalCenter{{ $product->kode }}">
                                                    <i class="icon-eye"></i>
                                                </button>
                                            </li>
                                        </ul>
                                        <form action="#" id="deleteBarang{{ $product->kode }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="kode" value="{{ $product->kode }}">
                                        </form>
                                    </div>
                                </div>
                                <div class="modal fade" id="modalCenter{{ $product->kode }}" tabindex="-1" role="dialog"
                                    aria-labelledby="modalCenter{{ $product->kode }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="product-box row">
                                                    <div class="product-img col-lg-6">
                                                        <img class="img-fluid"
                                                            src="{{ asset('files/product/' . $product->img) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="product-details col-lg-6 text-start">
                                                        <h4>{{ $product->nama }}</h4>
                                                        <div class="product-price">
                                                            Rp. {{ number_format($product->harga) }}
                                                        </div>
                                                        <div class="product-view mb-3">
                                                            <h6 class="f-w-600">Product Details</h6>
                                                            <p class="mb-0">
                                                                {{ $product->deskripsi }}
                                                            </p>
                                                        </div>
                                                        @if (!Auth::guard('admin')->check())
                                                            <div class="product-qnty">
                                                                <h6 class="f-w-600">Quantity</h6>
                                                                <form action="{{ route('cart.store') }}" method="post">
                                                                    @csrf
                                                                    <fieldset>
                                                                        <div class="input-group">
                                                                            <input class="touchspin text-center"
                                                                                type="text" name="qty"
                                                                                value="1">
                                                                        </div>
                                                                    </fieldset>

                                                                    <div class="addcart-btn">
                                                                        <input type="hidden" name="product"
                                                                            value="{{ $product->kode }}">
                                                                        <button class="btn btn-primary">
                                                                            Add to Cart
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <div class="product-qnty">
                                                                <h6 class="f-w-600">Stok</h6>
                                                                <div class="mb-3">
                                                                    <input class="form-control w-75" type="text"
                                                                        value="{{ $product->stok }}" readonly>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-details">
                                    @if ($product->rating)
                                        <div class="rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $product->rating)
                                                    <i class="fa fa-star"></i>
                                                @else
                                                    <i class="fa fa-star text-secondary"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    @endif
                                    <h4>{{ $product->nama }}</h4>
                                    <p>{{ Str::limit($product->deskripsi, 30, '...') ?? '-' }}</p>
                                    <div class="product-price">
                                        Rp. {{ number_format($product->harga) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted py-5">Tidak ada data ditemukan</p>
                @endforelse
            </div>

            {{ $products->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/touchspin/touchspin.js') }}"></script>
    <script src="{{ asset('assets/js/touchspin/input-groups.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweet-alert/sweetalert.min.js') }}"></script>

    @if (Session::has('success'))
        <script>
            swal({
                title: "Berhasil!",
                text: "{{ Session::get('success') }}",
                icon: "success",
            })
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            swal({
                title: "Gagal!",
                text: "{{ Session::get('error') }}",
                icon: "error",
            })
        </script>
    @endif
@endpush
