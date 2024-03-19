@extends('admin.layouts.admin')

@section('title')
    create blog
@endsection

@section('script')
    <script>

        $('#blog_image').change(function() {
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });

        class MyUploadAdapter {
            // The constructor method.
            // ...
            constructor( loader ) {
                // The file loader instance to use during the upload. It sounds scary but do not
                // worry — the loader will be passed into the adapter later on in this guide.
                this.loader = loader;
            }
            // Starts the upload process.
            upload() {
                return this.loader.file
                    .then( file => new Promise( ( resolve, reject ) => {
                        this._initRequest();
                        this._initListeners( resolve, reject, file );
                        this._sendRequest( file );
                    } ) );
            }

            // Aborts the upload process.
            abort() {
                if ( this.xhr ) {
                    this.xhr.abort();
                }
            }

            // More methods.
            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();

                // Note that your request may look different. It is up to you and your editor
                // integration to choose the right communication channel. This example uses
                // a POST request with JSON as a data structure but your configuration
                // could be different.
                xhr.open( 'POST', '{{route('admin.images.store')}}', true );
                xhr.setRequestHeader('x-csrf-token','{{csrf_token()}}')
                xhr.responseType = 'json';
            }
            // ...
            _initListeners( resolve, reject, file ) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `Couldn't upload file: ${ file.name }.`;

                xhr.addEventListener( 'error', () => reject( genericErrorText ) );
                xhr.addEventListener( 'abort', () => reject() );
                xhr.addEventListener( 'load', () => {
                    const response = xhr.response;

                    // This example assumes the XHR server's "response" object will come with
                    // an "error" which has its own "message" that can be passed to reject()
                    // in the upload promise.
                    //
                    // Your integration may handle upload errors in a different way so make sure
                    // it is done properly. The reject() function must be called when the upload fails.
                    if ( !response || response.error ) {
                        return reject( response && response.error ? response.error.message : genericErrorText );
                    }

                    // If the upload is successful, resolve the upload promise with an object containing
                    // at least the "default" URL, pointing to the image on the server.
                    // This URL will be used to display the image in the content. Learn more in the
                    // UploadAdapter#upload documentation.
                    resolve( {
                        default: response.url
                    } );
                } );

                // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
                // properties which are used e.g. to display the upload progress bar in the editor
                // user interface.
                if ( xhr.upload ) {
                    xhr.upload.addEventListener( 'progress', evt => {
                        if ( evt.lengthComputable ) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    } );
                }
            }
            // Prepares the data and sends the request.
            _sendRequest( file ) {
                // Prepare the form data.
                const data = new FormData();

                data.append( 'upload', file );

                // Important note: This is the right place to implement security mechanisms
                // like authentication and CSRF protection. For instance, you can use
                // XMLHttpRequest.setRequestHeader() to set the request headers containing
                // the CSRF token generated earlier by your application.

                // Send the request.
                this.xhr.send( data );
            }
        }


        function SimpleUploadAdapterPlugin( editor ) {
            editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                // Configure the URL to the upload script in your back-end here!
                return new MyUploadAdapter( loader );
            };
        }
        ClassicEditor
            .create( document.querySelector( '#body' ),{
                extraPlugins: [ SimpleUploadAdapterPlugin ],

                // More configuration options.
                // ...
            } )
            .catch( error => {
                console.error( error );
            } );

    </script>
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ایجاد مقاله</h5>
            </div>
            <hr>

            @include('admin.sections.errors')

            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="title">عنوان</label>
                        <input class="form-control" id="title" name="title" type="text" value="{{old('title')}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="primary_image"> انتخاب تصویر </label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="blog_image">
                            <label class="custom-file-label" for="blog_image"> انتخاب فایل </label>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="status"> وضعیت انتشار</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" selected>انتشار</option>
                            <option value="0">عدم انتشار </option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="keywords">کلمات کلیدی</label>
                        <textarea id="keywords" rows="3" name="keywords" class="form-control">{{old('keywords')}}</textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="body">توضیحات</label>
                        <textarea class="form-control" rows="5" id="body" name="body">{{old('body')}}</textarea>
                    </div>

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
