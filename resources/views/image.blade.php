@extends('layouts.main')
@section('title','图床')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropzone@5/dist/min/dropzone.min.css">
    <style>
        .dropzone {
            border: 2px dashed #ccc;
            border-radius: 10px;
            background: white;
        }
    </style>
@stop
@section('content')
    <div class="card border-light mb-3">
        <div class="card-body">
            <div class="page-container">
                <h4>图床</h4>
                <p>您可以尝试文件拖拽或者点击虚线框进行文件上传，单张图片最大支持4MB.</p>
                <form class="dropzone" id="image-dropzone">
                </form>
            </div>
        </div>
    </div>
    <div id="showUrl" style="display: none;">
        <ul id="navTab" class="nav nav-tabs">
            <li class="nav-item active">
                <a class="nav-link" data-toggle="tab" href="#urlPanel">URL</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#htmlPanel">HTML</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#bbPanel">bbCode</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#markdownPanel">Markdown</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#markdownLinkPanel">Markdown with Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#deletePanel">Delete Link</a>
            </li>
        </ul>
        <div id="navTabContent" class="tab-content">
            <div class="tab-pane fade in active show" id="urlPanel">
                <pre style="margin-top: 5px;"><code id="urlCode"></code></pre>
            </div>
            <div class="tab-pane fade" id="htmlPanel">
                <pre style="margin-top: 5px;"><code id="htmlCode"></code></pre>
            </div>
            <div class="tab-pane fade" id="bbPanel">
                <pre style="margin-top: 5px;"><code id="bbCode"></code></pre>
            </div>
            <div class="tab-pane fade" id="markdownPanel">
                <pre style="margin-top: 5px;"><code id="markdown"></code></pre>
            </div>
            <div class="tab-pane fade" id="markdownLinkPanel">
                <pre style="margin-top: 5px;"><code id="markdownLinks"></code></pre>
            </div>
            <div class="tab-pane fade" id="deletePanel">
                <pre style="margin-top: 5px;"><code id="deleteCode"></code></pre>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        Dropzone.options.imageDropzone = {
            url: Config.routes.upload_image,
            method: 'post',
            maxFilesize: 4,
            paramName: 'olaindex_img',
            maxFiles: 10,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            init: function () {
                this.on('sending', function (file, xhr, formData) {
                    formData.append('_token', Config._token);
                });
                this.on('success', function (file, response) {
                    $('#showUrl').show();
                    $('#urlCode').append(response.data.url + '\n');
                    $('#htmlCode').append('&lt;img src=\'' + response.data.url + '\' alt=\'' + response.data.filename + '\' title=\'' + response.data.filename + '\' /&gt;' + '\n');
                    $('#bbCode').append('[img]' + response.data.url + '[/img]' + '\n');
                    $('#markdown').append('![' + response.data.filename + '](' + response.data.url + ')' + '\n');
                    $('#markdownLinks').append('[![' + response.data.filename + '](' + response.data.url + ')]' + '(' + response.data.url + ')' + '\n');
                    $('#deleteCode').append(response.data.delete + '\n')
                });
            },

            dictDefaultMessage: '拖拽文件至此上传',
            dictFallbackMessage: '浏览器不支持拖拽上传',
            dictFileTooBig: '文件过大(@{{filesize}}MiB)，请重试',
            dictInvalidFileType: '文件类型不支持',
            dictResponseError: '上传错误 @{{statusCode}}',
            dictCancelUpload: '取消上传',
            dictUploadCanceled: '上传已取消',
            dictCancelUploadConfirmation: '确定取消上传吗?',
            dictRemoveFile: '移除此文件',
            dictRemoveFileConfirmation: '确定移除此文件吗',
            dictMaxFilesExceeded: '已达到最大上传数.',
        };
    </script>
@stop
