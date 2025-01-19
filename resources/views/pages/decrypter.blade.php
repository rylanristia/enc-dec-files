@extends('layouts.index')

@section('content')
    <div class="card">

        @if (session('success'))
            <div class="p3">
                <p style="color: green;">{{ session('success') }}</p>
                <p>File Path: {{ session('decrypted_path') }}</p>
                <p><a href="{{ asset('storage/' . session('decrypted_path')) }}" target="_blank">Download File</a></p>
            </div>
        @else
            <div class="card-header">
                Decrypter
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
                        <form id="symmetric-form" action="{{ route('symmetricDecrypter') }}" method="POST" class="mb-4"
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
                                    placeholder="Enter your decryption key ( recommend 16 characters )" required>
                            </div>
                            <div class="mb-3">
                                <input type="file" class="form-control" id="inputGroupFile01" name="filetarget"
                                    placeholder="select the file you want to decrypt" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Decrypt</button>
                        </form>
                        <p><span>Notes: </span>Put the key that you use to encrypt
                            before you decrypt the file.</p>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <form id="symmetric-form" action="{{ route('asymmetricDecrypter') }}" method="POST" class="mb-4"
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
                                <label for="" class="mb-2">private key (bits 1024, 2048, 4096)</label>
                                <input type="file" class="form-control" id="inputGroupFile01" name="key" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="mb-2">select the file you want to decrypt</label>
                                <input type="file" class="form-control" id="inputGroupFile01"
                                    placeholder="select the file you want to decrypt" name="filetarget" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Decrypt</button>
                        </form>
                        <p><span>Notes: </span>This decryption using RSA + chiper. put the key that you use
                            to decrypt
                            before you decrypt the file.</p>
                    </div>
                </div>
            </div>
        @endif
    @endsection
