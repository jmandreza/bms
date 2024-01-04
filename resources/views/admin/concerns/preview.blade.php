<table>
        <tr>
            <td class="font-semibold">Email</td>
            <td class="py-1 pl-4">{{$concern->email}}</td>
        </tr>
        <tr>
            <td class="font-semibold">Subject</td>
            <td class="py-1 pl-4">{{$concern->subject}}</td>
        </tr>
        <tr>
            <td class="font-semibold">Message</td>
            <td class="py-1 pl-4">{{$concern->message}}</td>
        </tr>
        <tr>
            <td class="font-semibold">Date Sent</td>
            <td class="py-1 pl-4">{{Carbon\Carbon::parse($concern->created_at)->format('F d, Y \a\\t h:i A')}}</td>
        </tr>
        <tr>
            <td class="font-semibold">Date Replied</td>
            <td class="py-1 pl-4">{{Carbon\Carbon::parse($concern->replied_at)->format('F d, Y \a\\t h:i A')}}</td>
        </tr>
    </table>