<form wire:submit.prevent="editQuestion" method="PATCH">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="block text-sm mb-4">
            <x-jet-label for="type_id" value="{{ __('Question Type') }}" />
            <select id="type_id" name="type_id" wire:model="type_id" wire:change="multipleChoice($event.target.value)" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                <option value="2" selected>Open Ended Question</option>
                <option value="1">Multiple Choice</option>
                <option value="3">File Upload</option>
                <option value="4">Identification</option>
            </select>
            @error('type_id') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div wire:ignore class="block text-sm mb-4">
            <x-jet-label for="question" value="{{ __('Question') }}" />
            <div class="document-editor">
                <div class="document-editor__toolbar"></div>
                <div class="document-editor__editable-container">
                    <div class="document-editor__editable">{!! $questionValue !!}</div>
                </div>
            </div>
            @error('question') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="block text-sm mb-4">
            <x-jet-label for="weight" value="{{ __('Max Score') }}" />
            <x-jet-input id="weight" class="block mt-1 w-full" type="text" wire:model="weight" name="weight" :value="old('weight')"/>
            @error('weight') <span class="error">{{ $message }}</span> @enderror
        </div>

        @if($identificationField)
        <div class="block text-sm mb-4 w-full">
            <x-jet-label for="identify" value="{{ __('Answer') }}" />
            <x-jet-input id="identify" class="block mt-1 w-full" type="text" wire:model="identify" name="identify" :value="old('identify')" required/>
            @error('identify') <span class="error">{{ $message }}</span> @enderror
        </div>
        @endif

        @if($showOptionsForm || $type_id == 1)
        <div class="block text-sm">
            <table class="w-full" id="options">
                <thead>
                    <tr>
                        <th class="text-left">Options</th>
                        <th>Answer</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($options as $index => $option)
                    <tr>
                        <td>
                            <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" type="text" name="options[{{ $index }}]['value']" wire:model="options.{{$index}}.value">
                        </td>
                        <td class="text-center">
                            <input type="checkbox" class="text-pequant-blue-600 form-checkbox focus:border-pequant-blue-400 focus:outline-none focus:shadow-outline-pequant-blue dark:focus:shadow-outline-gray" name="options[{{$index}}]['answer']" wire:model="options.{{$index}}.answer">
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" class="pt-4">
                            <button wire:click.prevent="addOption" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-pequant-blue-600 border border-transparent rounded-lg active:pequant-blue-600 hover:pequant-blue-700 focus:outline-none">
                                Add option
                                <span class="ml-2" aria-hidden="true">+</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>                    
        </div>
        @endif

        <div class="flex justify-between mt-6">

            <input type="file" wire:model="attachments" id="attachments">

            <x-jet-button wire:loading.attr="disabled">
                {{ __('Update question') }}
                <span class="ml-2" aria-hidden="true">+</span>
            </x-jet-button>
        </div>
    </div>
</form>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/decoupled-document/ckeditor.js"></script>
@endpush

<script>
    class MyUploadAdapter {
        constructor( loader ) {
            this.loader = loader;
        }
        upload() {
            return this.loader.file
                .then( file => new Promise( ( resolve, reject ) => {
                    this._initRequest();
                    this._initListeners( resolve, reject, file );
                    this._sendRequest( file );
                } ) );
        }
        abort() {
            if ( this.xhr ) {
                this.xhr.abort();
            }
        }
        _initRequest() {
            const xhr = this.xhr = new XMLHttpRequest();
            xhr.open( 'POST', "{{ route('image.store') }}", true );
            xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
            xhr.responseType = 'json';
        }
        _initListeners( resolve, reject, file ) {
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = `Couldn't upload file: ${ file.name }.`;
            xhr.addEventListener( 'error', () => reject( genericErrorText ) );
            xhr.addEventListener( 'abort', () => reject() );
            xhr.addEventListener( 'load', () => {
                const response = xhr.response;
                if ( !response || response.error ) {
                    return reject( response && response.error ? response.error.message : genericErrorText );
                }
                resolve( {
                    default: response.url
                } );
            } );
            if ( xhr.upload ) {
                xhr.upload.addEventListener( 'progress', evt => {
                    if ( evt.lengthComputable ) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                } );
            }
        }
        _sendRequest( file ) {
            const data = new FormData();
            data.append( 'upload', file );
            this.xhr.send( data );
        }
    }

    function SimpleUploadAdapterPlugin( editor ) {
        editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
            // Configure the URL to the upload script in your back-end here!
            return new MyUploadAdapter( loader );
        };
    }

    DecoupledEditor
        .create( document.querySelector( '.document-editor__editable' ), {
            extraPlugins: [ SimpleUploadAdapterPlugin ],

            link: {
                decorators: {
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    },
                    openInNewTab: {
                        mode: 'manual',
                        label: 'Open in a new tab',
                        defaultValue: true,         // This option will be selected by default.
                        attributes: {
                            target: '_blank',
                            rel: 'noopener noreferrer'
                        }
                    }
                }
            }
        })
        .then( editor => {
            const toolbarContainer = document.querySelector( '.document-editor__toolbar' );

            toolbarContainer.appendChild( editor.ui.view.toolbar.element );

            editor.model.document.on('change:data', () => {
                @this.set('questionValue', editor.getData());
            })

            window.editor = editor;
        } )
        .catch( err => {
            console.error( err );
        } )

    window.addEventListener('resetFileUploader', event => {

        window.editor.model.change(writer => {
            const insertPosition = editor.model.document.selection.getFirstPosition();

            writer.insertText(event.detail.filename, {
                linkHref: event.detail.uploadedUrl
            }, insertPosition);

        });

        document.getElementById('attachments').value = "";
    });
</script>

<style type="text/css">
    .document-editor {
        border: 1px solid var(--ck-color-base-border);
        border-radius: var(--ck-border-radius);

        /* Set vertical boundaries for the document editor. */
        max-height: 500px;

        /* This element is a flex container for easier rendering. */
        display: flex;
        flex-flow: column nowrap;
    }

    .document-editor__toolbar {
        /* Make sure the toolbar container is always above the editable. */
        z-index: 1;

        /* Create the illusion of the toolbar floating over the editable. */
        box-shadow: 0 0 5px hsla( 0,0%,0%,.2 );

        /* Use the CKEditor CSS variables to keep the UI consistent. */
        border-bottom: 1px solid var(--ck-color-toolbar-border);
    }

    /* Adjust the look of the toolbar inside the container. */
    .document-editor__toolbar .ck-toolbar {
        border: 0;
        border-radius: 0;
    }

    /* Make the editable container look like the inside of a native word processor application. */
    .document-editor__editable-container {
        min-height:  400px;
        /*padding: calc( 2 * var(--ck-spacing-large) );*/
        background: var(--ck-color-base-foreground);

        /* Make it possible to scroll the "page" of the edited content. */
        overflow-y: scroll;
    }

    .document-editor__editable-container .ck-editor__editable {
        /* Set the dimensions of the "page". */
        /*width: 21cm;*/
        min-height: 400px;

        /* Keep the "page" off the boundaries of the container. */
        padding: 10px 30px;

        border: 1px hsl( 0,0%,82.7% ) solid;
        border-radius: var(--ck-border-radius);
        background: white;

        /* The "page" should cast a slight shadow (3D illusion). */
        box-shadow: 0 0 5px hsla( 0,0%,0%,.1 );

        /* Center the "page". */
        margin: 0 auto;
    }

    /* Set the default font for the "page" of the content. */
    .document-editor .ck-content,
    .document-editor .ck-heading-dropdown .ck-list .ck-button__label {
        font: 16px/1.6 "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    /* Adjust the headings dropdown to host some larger heading styles. */
    .document-editor .ck-heading-dropdown .ck-list .ck-button__label {
        line-height: calc( 1.7 * var(--ck-line-height-base) * var(--ck-font-size-base) );
        min-width: 6em;
    }

    /* Scale down all heading previews because they are way too big to be presented in the UI.
    Preserve the relative scale, though. */
    .document-editor .ck-heading-dropdown .ck-list .ck-button:not(.ck-heading_paragraph) .ck-button__label {
        transform: scale(0.8);
        transform-origin: left;
    }

    /* Set the styles for "Heading 1". */
    .document-editor .ck-content h2,
    .document-editor .ck-heading-dropdown .ck-heading_heading1 .ck-button__label {
        font-size: 2.18em;
        font-weight: normal;
    }

    .document-editor .ck-content h2 {
        line-height: 1.37em;
        padding-top: .342em;
        margin-bottom: .142em;
    }

    /* Set the styles for "Heading 2". */
    .document-editor .ck-content h3,
    .document-editor .ck-heading-dropdown .ck-heading_heading2 .ck-button__label {
        font-size: 1.75em;
        font-weight: normal;
        color: hsl( 203, 100%, 50% );
    }

    .document-editor .ck-heading-dropdown .ck-heading_heading2.ck-on .ck-button__label {
        color: var(--ck-color-list-button-on-text);
    }

    /* Set the styles for "Heading 2". */
    .document-editor .ck-content h3 {
        line-height: 1.86em;
        padding-top: .171em;
        margin-bottom: .357em;
    }

    /* Set the styles for "Heading 3". */
    .document-editor .ck-content h4,
    .document-editor .ck-heading-dropdown .ck-heading_heading3 .ck-button__label {
        font-size: 1.31em;
        font-weight: bold;
    }

    .document-editor .ck-content h4 {
        line-height: 1.24em;
        padding-top: .286em;
        margin-bottom: .952em;
    }

    /* Set the styles for "Paragraph". */
    .document-editor .ck-content p {
        font-size: 1em;
        line-height: 1.63em;
        padding-top: .5em;
        margin-bottom: 1.13em;
    }

    /* Make the block quoted text serif with some additional spacing. */
    .document-editor .ck-content blockquote {
        font-family: Georgia, serif;
        margin-left: calc( 2 * var(--ck-spacing-large) );
        margin-right: calc( 2 * var(--ck-spacing-large) );
    }
</style>