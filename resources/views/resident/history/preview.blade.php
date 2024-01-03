<div class="space-y-4">
    <div class="flex justify-center p-2">
        @if(isset($request->cert_id))
        <x-qr-code :size="256" :key="$request->cert_id" />
        @else
        <div class="flex justify-center items-center border-2 border-gray-800 w-64 h-64">
            <p class="italic">No Cert ID issued</p>
        </div>
        @endif
    </div>

    <div>
        <table>
            <tr>
                <td class="font-semibold">Document</td>
                <td class="py-1 pl-4">{{$request->document->description}}</td>
            </tr>
            <tr>
                <td class="font-semibold">Purpose</td>
                <td class="py-1 pl-4">{{$request->purpose}}</td>
            </tr>
            <tr>
                <td class="font-semibold">Status</td>
                <td class="py-1 pl-4">{{$request->status}}</td>
            </tr>
            <tr>
                <td class="font-semibold">Date Rquested</td>
                <td class="py-1 pl-4">{{Carbon\Carbon::parse($request->created_at)->format('F d, Y \a\\t h:i A')}}</td>
            </tr>
            <tr>
                <td class="font-semibold">Last Modified</td>
                <td class="py-1 pl-4">{{Carbon\Carbon::parse($request->updated_at)->format('F d, Y \a\\t h:i A')}}</td>
            </tr>
        </table>
    </div>
</div>