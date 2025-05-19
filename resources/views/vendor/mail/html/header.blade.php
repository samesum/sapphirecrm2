@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" class="d-inline-block">

{{ $slot }}

</a>
</td>
</tr>
