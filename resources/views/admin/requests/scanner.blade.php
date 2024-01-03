<form id="update-scanned-code-form" action="{{route('admin.document-request.mark-as-completed')}}" method="post">
    @method('put')
    @csrf

    <input type="hidden" name="cert_id" value="" />
</form>
<div id="update-scanned-code-loader" class="hidden pb-4">
    <div class="flex justify-center items-center gap-x-2">
        <svg class="w-5 h-5 -ml-2 -my-2 animate-spin fill-white" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentFill"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools --> <title>ic_fluent_spinner_ios_20_filled</title> <desc>Created with Sketch.</desc> <g id="🔍-System-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="ic_fluent_spinner_ios_20_filled" fill="currentColor" fill-rule="nonzero"> <path d="M10,3.5 C6.41015,3.5 3.5,6.41015 3.5,10 C3.5,10.4142 3.16421,10.75 2.75,10.75 C2.33579,10.75 2,10.4142 2,10 C2,5.58172 5.58172,2 10,2 C14.4183,2 18,5.58172 18,10 C18,14.4183 14.4183,18 10,18 C9.58579,18 9.25,17.6642 9.25,17.25 C9.25,16.8358 9.58579,16.5 10,16.5 C13.5899,16.5 16.5,13.5899 16.5,10 C16.5,6.41015 13.5899,3.5 10,3.5 Z" id="🎨-Color"> </path> </g> </g> </g></svg>
        <p class="font-semibold">Processing scanned result... </p>
    </div>
</div>

<div id="qr-scanner-container" class="w-full max-w-md aspect-square mx-auto"></div>

