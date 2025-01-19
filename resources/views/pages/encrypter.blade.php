@extends('layouts.index')

@section('content')
    <div class="card">

        @if (session('success'))
            <div class="p-3">
                <p style="color: green;">{{ session('success') }}</p>
                <p>File Path: {{ session('encrypted_path') }}</p>
                <p><a href="{{ asset('storage/' . session('encrypted_path')) }}" target="_blank">Download File</a></p>
            </div>
        @else
            <div class="card-header">
                Encrypter
            </div>
            <div class="card-body">
                <ul class="nav nav-pills mb-3 d-flex justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Symmetrical</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">Asymmetrical</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <form id="symmetric-form" action="{{ route('symmetricEncrypt') }}" method="POST" class="mb-4"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <select name="chiper" id="chiper" class="form-control" required>
                                    <option value="">Choose chiper</option>
                                    <option value="AES-256-CBC">AES-256-CBC</option>
                                    <option value="camellia-128-cbc">camellia-128-cbc</option>
                                    <option value="des-ede-cbc">des-ede-cbc</option>
                                    <option value="sm4-cbc">sm4-cbc</option>
                                    <option value="aria-256-cfb">aria-256-cfb</option>
                                    <option value="des-ede3-cbc">des-ede3-cbc</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="key"
                                    placeholder="Enter your encryption key ( recommend 16 characters )" required>
                            </div>
                            <div class="mb-3">
                                <input type="file" class="form-control" id="inputGroupFile01" name="filetarget"
                                    placeholder="select the file you want to encrypt" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Encrypt</button>
                        </form>
                        <p><span>Notes: </span>Before you encrypt the file, make sure
                            you
                            save
                            your key in a safe
                            place in the place that only you knows it and remember. if you forgot your key, you'll never get
                            back
                            you file after you encrypt it.</p>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <form id="symmetric-form" action="{{ route('asymmetricEncrypt') }}" method="POST" class="mb-4"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <select name="chiper" id="chiper" class="form-control" required>
                                    <option value="">Choose chiper</option>
                                    <option value="AES-256-CBC">AES-256-CBC</option>
                                    <option value="camellia-128-cbc">camellia-128-cbc</option>
                                    <option value="des-ede-cbc">des-ede-cbc</option>
                                    <option value="sm4-cbc">sm4-cbc</option>
                                    <option value="aria-256-cfb">aria-256-cfb</option>
                                    <option value="des-ede3-cbc">des-ede3-cbc</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="mb-2">public key (bits 1024, 2048, 4096)</label>
                                <input type="file" class="form-control" id="inputGroupFile01" name="key" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="mb-2">select the file you want to encrypt</label>
                                <input type="file" class="form-control" id="inputGroupFile01"
                                    placeholder="select the file you want to encrypt" name="filetarget" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Encrypt</button>
                        </form>
                        <p><span>Notes: </span>This encryption RSA + chiper. before you encrypt the file,
                            make sure you have been create and save
                            the RSA key with private key and public key. up to you what RSA bit you gonna use it (1024,
                            2048, etc)</p>
                    </div>
                </div>
            </div>
        @endif
    @endsection
