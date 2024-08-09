@extends('layouts.app')

@section('content')
    <!---style--->
    <style>
        .input-group.file-caption-main {
            display: none;
        }

        .close.fileinput-remove {
            display: none;
        }

        .file-drop-zone {
            margin: 0px;
            border: 1px solid #fff;
            background-color: #fff;
            padding: 0px;
            display: contents;
        }

        .file-drop-zone.clickable:hover {
            border-color: #fff;
        }

        .file-drop-zone .file-preview-thumbnails {
            display: inline;
        }

        .file-drop-zone-title {
            padding: 15px;
            height: 120px;
            width: 120px;
            font-size: 12px;
        }

        .file-input-ajax-new {
            display: inline-block;
        }

        .file-input.theme-fas {
            display: inline-block;
            width: 100%;
        }

        .file-preview {
            padding: 0px;
            border: none;
            display: inline;

        }

        .file-drop-zone-title {
            display: none;
        }

        .file-footer-caption {
            display: none !important;
        }

        .kv-file-upload {
            display: none;
        }

        .file-upload-indicator {
            display: none;
        }

        .file-drag-handle.drag-handle-init.text-info {
            display: none;
        }

        .krajee-default.file-preview-frame .kv-file-content {
            width: 90px;
            height: 90px;
            display: flex;
            text-align: center;
            align-items: center;
        }

        .krajee-default.file-preview-frame {
            background-color: #fff;
            margin: 3px;
            border-radius: 15px;
            overflow: hidden;
        }

        .krajee-default.file-preview-frame:not(.file-preview-error):hover {
            box-shadow: none;
            border-color: #ed3237;
        }

        .krajee-default.file-preview-frame:not(.file-preview-error):hover .file-preview-image {
            transform: scale(1.1);
        }

        .krajee-default.file-preview-frame {
            box-shadow: none;
            border-color: #fff;
            max-width: 150px;
            margin: 5px;
            padding: 0px;
            transition: 0.5s;
        }

        .file-thumbnail-footer,
        .file-actions {
            width: 20px;
            height: 20px !important;
            position: absolute !important;
            top: 3px;
            right: 3px;
        }

        .kv-file-remove:focus,
        .kv-file-remove:active {
            outline: none !important;
            box-shadow: none !important;
        }

        .kv-file-remove {
            border-radius: 50%;
            z-index: 1;
            right: 0;
            position: absolute;
            top: 0;
            text-align: center;
            color: #fff;
            background-color: #ed3237;
            border: 1px solid #ed3237;
            padding: 2px 6px;
            font-size: 11px;
            transition: 0.5s;
        }

        .kv-file-remove:hover {
            border-color: #fdeff0;
            background-color: #fdeff0;
            color: #ed1924;
        }

        .kv-preview-data.file-preview-video {
            width: 100% !important;
            height: 100% !important;
        }

        .btn-outline-secondary.focus,
        .btn-outline-secondary:focus {
            box-shadow: none;
        }

        .btn-toggleheader,
        .btn-fullscreen,
        .btn-borderless {
            display: none;
        }

        .btn-kv.btn-close {
            color: #fff;
            border: none;
            background-color: #ed3237;
            font-size: 11px;
            width: 18px;
            height: 18px;
            text-align: center;
            padding: 0px;
        }

        .btn-outline-secondary:not(:disabled):not(.disabled).active:focus,
        .btn-outline-secondary:not(:disabled):not(.disabled):active:focus,
        .show>.btn-outline-secondary.dropdown-toggle:focus {
            background-color: rgba(255, 255, 255, 0.8);
            color: #000;
            box-shadow: none;
            color: #ed3237;
        }

        .kv-file-content .file-preview-image {
            width: 90px !important;
            height: 90px !important;
            max-width: 90px !important;
            max-height: 90px !important;
            transition: 0.5s;
        }

        .btn-danger.btn-file {
            padding: 0px;
            height: 95px;
            width: 95px;
            display: inline-block;
            margin: 5px;
            border-color: #fdeff0;
            background-color: #fdeff0;
            color: #ed1924;
            border-radius: 15px;
            padding-top: 30px;
            transition: 0.5s;
        }

        .btn-danger.btn-file:active,
        .btn-danger.btn-file:hover {
            background-color: #fde3e5;
            color: #ed1924;
            border-color: #fdeff0;
            box-shadow: none;
        }

        .btn-danger.btn-file i {
            font-size: 30px;
        }


        @media (max-width: 350px) {
            .krajee-default.file-preview-frame:not([data-template=audio]) .kv-file-content {
                width: 90px;
            }
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p>Produc Create</p>
                            <a href="{{ route('product.index') }}" class="btn btn-primary">Product List</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" placeholder="Enter Product Name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="name" class="form-label">Product Description</label>
                                <textarea type="text" class="form-control" placeholder="Enter Product Details" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="name" class="form-label">Product Price</label>
                                <input type="number" class="form-control" placeholder="Enter Product Price" name="price">
                            </div>


                            <!---image upload--->
                            <div class="verify-sub-box">
                                <div class="file-loading">
                                    <input id="multiplefileupload" name="images[]" type="file" accept=".jpg,.gif,.png"
                                        multiple>
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary">submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!---script--->
    <script>
        $(document).ready(function() {
            // ----------multiplefile-upload---------
            $("#multiplefileupload").fileinput({
                'theme': 'fa',
                'uploadUrl': '#',
                showRemove: false,
                showUpload: false,
                showZoom: false,
                showCaption: false,
                browseClass: "btn btn-danger",
                browseLabel: "",
                browseIcon: "<i class='bi bi-align-middle'></i>",
                overwriteInitial: false,
                initialPreviewAsData: true,
                fileActionSettings: {
                    showUpload: false,
                    showZoom: false,
                    removeIcon: "<i class='bi bi-bag-x'></i>",
                }
            });
        })
    </script>
@endsection
