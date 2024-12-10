@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Tombol Logout -->
    @if(Auth::check())
        <form action="{{ route('logout') }}" method="POST" class="mb-3">
        </form>
    @endif

    <div id="main-banner" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('toko_bajuu.jpg') }}" class="d-block w-100" alt="New Catalog">
                <div class="carousel-caption">
                    <h1 class="display-4 text-uppercase font-weight-bold custom-title">The New Catalog Is Here</h1>
                    <p><a class="btn btn-shop-now btn-lg mt-3" href="pesanans">Belanja Sekarang!</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
  .custom-title {
    color: #fff;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
    letter-spacing: 2px;
    padding: 10px 20px;
    background: rgba(0, 0, 0, 0.4);
    border-radius: 8px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
    animation: fadeIn 2s ease-in-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  /* Style untuk tombol "Belanja Sekarang" */
  .btn-shop-now {
    background-color: #ff6b6b;
    color: #fff5e1;
    padding: 12px 30px;
    font-weight: bold;
    border-radius: 30px;
    box-shadow: 0px 5px 15px rgba(255, 107, 107, 0.3);
    transition: all 0.3s ease;
  }

  .btn-shop-now:hover {
    background-color: #ff4c4c;
    color: #ffffff;
    box-shadow: 0px 8px 20px rgba(255, 76, 76, 0.5);
    transform: translateY(-3px);
  }
</style>
