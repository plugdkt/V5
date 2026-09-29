<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา - ข้อมูลเผยแพร่ล่าสุด</title>
        <link>{{ route('home') }}</link>
        <atom:link href="{{ route('rss') }}" rel="self" type="application/rss+xml" />
        <description>แผน นโยบาย รายงานผลการดำเนินงาน แบบฟอร์ม และหน้าเว็บที่ปรับปรุงล่าสุด ของคณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</description>
        <language>th</language>
        <lastBuildDate>{{ now()->toRfc2822String() }}</lastBuildDate>
        @foreach($items as $item)
            <item>
                <title>{{ $item['title'] }}</title>
                <link>{{ $item['link'] }}</link>
                <guid isPermaLink="false">{{ md5($item['link'] . $item['title']) }}</guid>
                <description>{{ $item['desc'] }}</description>
                <pubDate>{{ \Illuminate\Support\Carbon::parse($item['date'])->toRfc2822String() }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>
