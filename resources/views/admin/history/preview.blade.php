<table>
    <tr>
        <td class="font-semibold">Requester Name</td>
        <td class="py-1 pl-4">{{"{$request->user->resident->lname}, {$request->user->resident->fname} ".(isset($request->user->resident->mname) ? $request->user->resident->mname[0].'.' : '')}}</td>
    </tr>
    <tr>
        <td class="font-semibold">Household & Zone</td>
        <td class="py-1 pl-4">{{"#{$request->user->resident->household_no} Zone {$request->user->resident->zone}"}}</td>
    </tr>
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